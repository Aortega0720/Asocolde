<?php

namespace Drupal\asocol\Plugin\DsField;

use Drupal\ds\Plugin\DsField\DsFieldBase;
use Drupal\commerce_product\Entity\ProductVariation;

/**
 * Plugin that renders the node print.
 *
 * @DsField(
 *   id = "product_sku",
 *   title = @Translation("Product Sku"),
 *   entity_type = "commerce_product",
 *   provider = "commerce_product"
 * )
 */
class ProductSku extends DsFieldBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $product = $this->entity();
    $defaultVariation = $product->getDefaultVariation();

    if ($defaultVariation instanceof ProductVariation) {
      return [
        '#type' => 'markup',
        '#markup' => "Ref. {$defaultVariation->getSku()}",
      ];
    }
  }

}
