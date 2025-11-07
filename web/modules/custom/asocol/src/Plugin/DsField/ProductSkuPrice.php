<?php

namespace Drupal\asocol\Plugin\DsField;

use Drupal\Core\Cache\Cache;
use Drupal\ds\Plugin\DsField\DsFieldBase;
use Drupal\Core\Language\LanguageInterface;
use Drupal\commerce_product\Entity\ProductVariation;
use CommerceGuys\Intl\Formatter\CurrencyFormatterInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin that renders the product price.
 *
 * @DsField(
 *   id = "product_price",
 *   title = @Translation("Product Price"),
 *   entity_type = "commerce_product",
 *   provider = "commerce_product"
 * )
 */
class ProductSkuPrice extends DsFieldBase {

  /**
   * The currency formatter.
   *
   * @var \CommerceGuys\Intl\Formatter\CurrencyFormatterInterface
   */
  protected $currencyFormatter;

  /**
   * Constructs a Display Suite field plugin.
   *
   * @param string $plugin_id
   *   The plugin_id for the formatter.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Field\FieldDefinitionInterface $field_definition
   *   The definition of the field to which the formatter is associated.
   * @param \CommerceGuys\Intl\Formatter\CurrencyFormatterInterface $currency_formatter
   *   The currency formatter.
   */
  public function __construct($configuration, $plugin_id, $plugin_definition, CurrencyFormatterInterface $currency_formatter) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->currencyFormatter = $currency_formatter;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('commerce_price.currency_formatter')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $product = $this->entity();
    $defaultVariation = $product->getDefaultVariation();
    if ($defaultVariation instanceof ProductVariation) {
      $price = $defaultVariation->getPrice();
      return [
        '#theme' => 'commerce_price_calculated',
        '#calculated_price' => $this->currencyFormatter->format($price->getNumber(), $price->getCurrencyCode()),
        '#purchasable_entity' => $product,
        '#cache' => [
          'tags' => $product->getCacheTags(),
          'contexts' => Cache::mergeContexts($product->getCacheContexts(), [
            'languages:' . LanguageInterface::TYPE_INTERFACE,
            'country',
          ]),
        ],
      ];
    }
  }

}
