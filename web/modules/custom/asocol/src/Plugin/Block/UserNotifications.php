<?php

namespace Drupal\asocol\Plugin\Block;

use Drupal\Core\Link;
use Drupal\Core\Cache\Cache;
use Drupal\file\Entity\File;
use Drupal\Core\Block\BlockBase;
use Drupal\field\Entity\FieldConfig;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\Core\Menu\MenuLinkTreeInterface;
use Drupal\Core\Access\AccessResultInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'UserNotifications' block.
 *
 * @Block(
 *   id = "user_notifications",
 *   admin_label = @Translation("User Notifications block"),
 * )
 */
class UserNotifications extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Stores an entity type manager instance.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The entity storage for User entity type.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface;
   */
  protected $userStorage;

  /**
   * Stores the current logged in user or anonymous account.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentAccount;

  /**
   * Stores the current user.
   *
   * @var \Drupal\user\Entity\User
   */
  protected $currentUser;

  /**
   * The menu link tree service.
   *
   * @var \Drupal\Core\Menu\MenuLinkTreeInterface
   */
  protected $menuTree;

  /**
   * Creates a BLockUserInfo instance.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Entity\EntityTypeManager $entity_type_manager
   *   An instance of the entity type manager.
   * @param \Drupal\Core\Session\AccountProxyInterface $current_account
   *   An instance of the current logged in user or anonymous account.
   * @param \Drupal\Core\Routing\CurrentRouteMatch $current_route_match
   *   The current request.
   * @param \Drupal\Core\Menu\MenuLinkTreeInterface $menu_tree
   *   The menu tree service.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    EntityTypeManagerInterface $entity_type_manager,
    AccountProxyInterface $current_account,
    MenuLinkTreeInterface $menu_tree
  ) {
    // Get default values.
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    // Get user entity tools.
    $this->entityTypeManager = $entity_type_manager;
    $this->userStorage = $entity_type_manager->getStorage('user');

    // Get user info.
    $this->currentAccount = $current_account;
    $this->currentUser = $this->userStorage->load($this->currentAccount->id());
    $this->menuTree = $menu_tree;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager'),
      $container->get('current_user'),
      $container->get('menu.link_tree')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [
      '#cache' => [
        'context' => $this->getCacheContexts(),
        'tags' => $this->getCacheTags(),
        'max-age' => $this->getCacheMaxAge(),
      ],
      '#theme' => 'user_notifications',
    ];

    if($this->currentUser != NULL) {
      $build['#icon'] = 'Ruta del icono';
      $build['#list'] = [
        '#type' => 'view',
        '#name' => 'notifications',
        '#display_id' => 'block',
        '#embed' => TRUE,
      ];
    }

    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheTags() {
    $uid = (NULL != $this->currentUser) ? $this->currentUser->id() : FALSE;
    if ($uid) {
      $tags = [
        'user:' . $uid,
      ];
      return Cache::mergeTags(parent::getCacheTags(), $tags);
    }
    else {
      // Return default tags instead.
      return parent::getCacheTags();
    }
  }

  public function getCacheContexts() {
    return Cache::mergeContexts(parent::getCacheContexts(), ['user']);
  }

  protected function getMenuItems($menu_name) {
    $menu_tree = \Drupal::menuTree();
    $parameters = $menu_tree->getCurrentRouteMenuTreeParameters($menu_name);
    $parameters->setMinDepth(0);
    $parameters->onlyEnabledLinks();

    $tree = $menu_tree->load($menu_name, $parameters);
    $manipulators = array(
      array('callable' => 'menu.default_tree_manipulators:checkAccess'),
      array('callable' => 'menu.default_tree_manipulators:generateIndexAndSort'),
    );
    $tree = $menu_tree->transform($tree, $manipulators);

    return $menu_tree->build($tree);
  }
}
