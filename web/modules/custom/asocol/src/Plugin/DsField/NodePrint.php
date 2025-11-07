<?php

namespace Drupal\asocol\Plugin\DsField;

use Drupal\ds\Plugin\DsField\DsFieldBase;

/**
 * Plugin that renders the node print.
 *
 * @DsField(
 *   id = "node_print",
 *   title = @Translation("Node Print"),
 *   entity_type = "node",
 *   provider = "node"
 * )
 */
class NodePrint extends DsFieldBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#type' => 'button',
      '#value' => 'Print Me',
      '#attributes' => [
        'onclick'=> 'window.print();',
        'class' => ['button-print', 'no-print'],
      ],
    ];
  }

}
