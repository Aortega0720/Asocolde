<?php

namespace Drupal\asocol\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides feature to print page.
 *
 * @Block(
 *   id = "asocol_print",
 *   admin_label = @Translation("Asocol Print"),
 * )
 */
class AsocolPrintBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [
      '#type' => 'button',
      '#value' => 'Print Me',
      '#attributes' => [
        'onclick'=> 'window.print();',
        'class' => ['button-print', 'no-print'],
      ],
    ];

    return $build;
  }

}
