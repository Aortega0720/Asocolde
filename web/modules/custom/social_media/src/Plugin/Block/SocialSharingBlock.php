<?php

namespace Drupal\social_media\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\social_media\Event\SocialMediaEvent;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Utility\Token;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Drupal\Core\Template\Attribute;
use Drupal\Core\Path\CurrentPathStack;
use Drupal\Core\Cache\Cache;


/**
 * Provides a 'SocialSharingBlock' block.
 *
 * @Block(
 *  id = "social_sharing_block",
 *  admin_label = @Translation("Social Sharing block"),
 * )
 */
class SocialSharingBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The configFactory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The token service.
   *
   * @var \Drupal\Core\Utility\Token
   */
  protected $token;

  /**
   * An event dispatcher instance to use for configuration events.
   *
   * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
   */
  protected $eventDispatcher;

  /**
   * The current path.
   *
   * @var \Drupal\Core\Path\CurrentPathStack
   */
  protected $currentPath;

  /**
   * Constructor.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ConfigFactoryInterface $config_factory, Token $token, EventDispatcherInterface $event_dispatcher, CurrentPathStack $current_path) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->configFactory = $config_factory;
    $this->token = $token;
    $this->eventDispatcher = $event_dispatcher;
    $this->currentPath = $current_path;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('config.factory'),
      $container->get('token'),
      $container->get('event_dispatcher'),
      $container->get('path.current'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    global $base_url;

    $library = ['social_media/basic'];
    $settings = [];

    // ✅ Reemplazo de drupal_get_path().
    $modulePath = \Drupal::service('extension.list.module')->getPath('social_media');
    $icon_path = $base_url . '/' . $modulePath . '/icons/';

    $elements = [];
    $social_medias = $this->configFactory->get('social_media.settings')
      ->get('social_media');

    // Call pre_execute event before doing anything.
    $event = new SocialMediaEvent($social_medias);
    $this->eventDispatcher->dispatch($event, 'social_media.event');
    $social_medias = $event->getElement();

    $social_medias = $this->sortSocialMedias($social_medias);
    foreach ($social_medias as $name => $social_media) {
      if ($name == "email" && isset($social_media['enable_forward']) && $social_media['enable_forward']) {
        $social_media['api_url'] = str_replace('mailto:', '/social-media-forward', $social_media['api_url']);
        $social_media['api_url'] .= '&destination=' . $this->currentPath->getPath();
        if (!empty($social_media['show_forward']) && $social_media['show_forward'] == 1) {
          $library[] = 'core/drupal.dialog.ajax';
        }
      }

      if (!empty($social_media['enable']) && !empty($social_media['api_url'])) {
        $elements[$name]['text'] = $social_media['text'];
        $elements[$name]['api'] = new Attribute([$social_media['api_event'] => $this->token->replace($social_media['api_url'])]);

        if (!empty($social_media['library'])) {
          $library[] = $social_media['library'];
        }
        if (!empty($social_media['attributes'])) {
          $elements[$name]['attr'] = $this->socialMediaConvertAttributes($social_media['attributes']);
        }
        if (!empty($social_media['drupalSettings'])) {
          $settings['social_media'] = $this->socialMediaConvertDrupalSettings($social_media['drupalSettings']);
        }

        if (!empty($social_media['default_img'])) {
          $elements[$name]['img'] = $icon_path . $name . '.svg';
        }
        elseif (!empty($social_media['img'])) {
          $elements[$name]['img'] = $base_url . '/' . $social_media['img'];
        }

        if (!empty($social_media['enable_forward']) && !empty($social_media['show_forward'])) {
          $elements[$name]['forward_dialog'] = $social_media['show_forward'];
        }
      }
    }

    // Call prerender event before render.
    $event = new SocialMediaEvent($elements);
    $this->eventDispatcher->dispatch($event, 'social_media.event');
    $elements = $event->getElement();

    return [
      'social_sharing_block' => [
        '#theme' => 'social_media_links',
        '#elements' => $elements,
        '#attached' => [
          'library' => $library,
          'drupalSettings' => $settings,
        ],
      ],
    ];
  }

  protected function sortSocialMedias(&$element) {
    $weight = [];
    foreach ($element as $key => $row) {
      $weight[$key] = $row['weight'];
    }
    array_multisort($weight, SORT_ASC, $element);
    return $element;
  }

  protected function socialMediaConvertAttributes($variables) {
    $variable = explode("\n", $variables);
    $attributes = [];
    foreach ($variable as $each) {
      if ($each === '') {
        continue;
      }
      $var = explode("|", $each);
      $value = str_replace(["\r\n", "\n", "\r"], "", $var[1] ?? '');
      $attributes[$var[0]] = new Attribute([$var[0] => $value]);
    }
    return $attributes;
  }

  protected function socialMediaConvertDrupalSettings($variables) {
    $variable = explode("\n", $variables);
    $settings = [];
    foreach ($variable as $each) {
      $var = explode("|", $each);
      $settings[$var[0]] = str_replace(["\r\n", "\n", "\r"], "", $var[1] ?? '');
    }
    return $settings;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheTags() {
    return Cache::mergeTags(parent::getCacheTags(), [
      'social_media:' . $this->currentPath->getPath(),
      'config:social_media.settings',
    ]);
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheContexts() {
    return Cache::mergeContexts(parent::getCacheContexts(), ['url.path']);
  }

}
