<?php

namespace Drupal\asocol\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides feature to print page.
 *
 * @Block(
 *   id = "asocol_search",
 *   admin_label = @Translation("Asocol Search"),
 * )
 */
class AsocolSearchBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = \Drupal::formBuilder()->getForm('Drupal\asocol\Form\SearchForm');

    return $build;
  }

}
