<?php

namespace Drupal\asocol\Plugin\Block;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides feature to print page.
 *
 * @Block(
 *   id = "asocol_title",
 *   admin_label = @Translation("Asocol Title"),
 * )
 */
class AsocolTitleBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Stores the current logged in user or anonymous account.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * Constructs an AggregatorFeedBlock object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Session\AccountProxyInterface $current_account
   *   An instance of the current logged in user or anonymous account.
   *   The session manager service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition,  AccountProxyInterface $current_user) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->currentUser = $current_user;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_user')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    if($this->currentUser->isAuthenticated()) {
      $build = [
        '#type' => 'html_tag',
        '#tag' => 'h3',
        '#value' => 'Dermatólogos',
      ];
    }
    else {
      $build = [
        '#type' => 'html_tag',
        '#tag' => 'h3',
        '#value' => 'Pacientes',
      ];
    }

    $build += [
      '#cache' => [
        'context' => $this->getCacheContexts(),
        'tags' => $this->getCacheTags(),
        'max-age' => $this->getCacheMaxAge(),
      ],
    ];

    return $build;
  }

  public function getCacheContexts() {
    return Cache::mergeContexts(parent::getCacheContexts(), ['user.roles']);
  }

}
