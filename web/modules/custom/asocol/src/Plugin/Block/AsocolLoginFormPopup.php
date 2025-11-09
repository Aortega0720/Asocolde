<?php

namespace Drupal\asocol\Plugin\Block;

use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides login form popup block.
 *
 * @Block(
 *   id = "asocol_login_form_popup",
 *   admin_label = @Translation("Asocol Login Form Popup"),
 * )
 */
class AsocolLoginFormPopup extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The current logged-in user or anonymous account.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected AccountProxyInterface $currentUser;

  /**
   * Constructs an AsocolLoginFormPopup block object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin ID for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Session\AccountProxyInterface $current_user
   *   The current user session.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, AccountProxyInterface $current_user) {
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

    // Mostrar enlace de login solo a usuarios anónimos.
    if ($this->currentUser->isAnonymous()) {
      $url = Url::fromRoute('user.login');
      $url->setOptions([
        'attributes' => [
          'class' => ['use-ajax', 'login-popup-form'],
          'data-dialog-type' => 'modal',
        ],
      ]);

      $link = Link::fromTextAndUrl($this->t('Ingreso Asociados'), $url)->toString();

      $build['login_popup_block'] = [
        '#markup' => '<div class="login-popup-link">' . $link . '</div>',
        '#attached' => [
          'library' => ['core/drupal.dialog.ajax'],
        ],
      ];
    }

    return $build;
  }

}

