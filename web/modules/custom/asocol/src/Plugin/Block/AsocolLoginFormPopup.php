<?php

namespace Drupal\asocol\Plugin\Block;

use Drupal\Core\Url;
use \Drupal\Core\Link;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides login from popup.
 *
 * @Block(
 *   id = "asocol_login_form_popup",
 *   admin_label = @Translation("Asocol Login Form Popup"),
 * )
 */
class AsocolLoginFormPopup extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Stores the current logged in user or anonymous account.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentAccount;

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
    $build = [];
    if($this->currentUser->isAnonymous()) {
      $url = Url::fromRoute('user.login');
      $link_options = [
        'attributes' => [
          'class' => [
            'use-ajax',
            'login-popup-form',
          ],
          'data-dialog-type' => 'modal',
        ],
      ];
      $url->setOptions($link_options);
      $link = Link::fromTextAndUrl('Ingreso Asociados', $url)->toString();
      $build['login_popup_block']['#markup'] = '<div class="Login-popup-link">' . $link . '</div>';
      $build['login_popup_block']['#attached']['library'][] = 'core/drupal.dialog.ajax';
    }

    return $build;
  }

}
