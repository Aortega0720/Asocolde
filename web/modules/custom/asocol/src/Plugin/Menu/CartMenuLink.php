<?php

namespace Drupal\asocol\Plugin\Menu;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Menu\MenuLinkDefault;
use Drupal\Core\Cache\CacheableMetadata;
use Drupal\commerce_cart\CartProviderInterface;
use Drupal\Core\Menu\StaticMenuLinkOverridesInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Represents a menu link for a cart.
 */
class CartMenuLink extends MenuLinkDefault implements ContainerFactoryPluginInterface {

  /**
   * The cart provider.
   *
   * @var \Drupal\commerce_cart\CartProviderInterface
   */
  protected $cartProvider;

  /**
   * Constructs a new MenuLinkDefault.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Menu\StaticMenuLinkOverridesInterface $static_override
   *   The static override storage.
   * @param \Drupal\commerce_cart\CartProviderInterface $cart_provider
   *   The cart provider.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, StaticMenuLinkOverridesInterface $static_override, CartProviderInterface $cart_provider) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $static_override);

    $this->cartProvider = $cart_provider;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('menu_link.static.overrides'),
      $container->get('commerce_cart.cart_provider')

    );
  }

  /**
   * {@inheritdoc}
   */
  public function getOptions() {
    $options = $this->pluginDefinition['options'] ?: [];
    $count = $this->getCartCountItems();
    if ($count > 0) {
      $options['attributes']['data-cart-count'] = $count;
    }

    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheContexts() {
    return Cache::mergeContexts(parent::getCacheContexts(), ['user','cart']);
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheTags() {
    $cache_tags = parent::getCacheTags();
    $cart_cache_tags = [];

    /** @var \Drupal\commerce_order\Entity\OrderInterface[] $carts */
    $carts = $this->cartProvider->getCarts();
    foreach ($carts as $cart) {
      // Add tags for all carts regardless items or cart flag.
      $cart_cache_tags = Cache::mergeTags($cart_cache_tags, $cart->getCacheTags());
    }
    return Cache::mergeTags($cache_tags, $cart_cache_tags);
  }

  private function getCartCountItems() {
    $count = 0;

    $cachable_metadata = new CacheableMetadata();
    $cachable_metadata->addCacheContexts(['user', 'session']);

    /** @var \Drupal\commerce_order\Entity\OrderInterface[] $carts */
    $carts = $this->cartProvider->getCarts();
    $carts = array_filter($carts, function ($cart) {
      /** @var \Drupal\commerce_order\Entity\OrderInterface $cart */
      // There is a chance the cart may have converted from a draft order, but
      // is still in session. Such as just completing check out. So we verify
      // that the cart is still a cart.
      return $cart->hasItems() && $cart->cart->value;
    });

    if (!empty($carts)) {
      foreach ($carts as $cart_id => $cart) {
        foreach ($cart->getItems() as $order_item) {
          $count += (int) $order_item->getQuantity();
        }
        $cachable_metadata->addCacheableDependency($cart);
      }
    }

    return $count;
  }
}
