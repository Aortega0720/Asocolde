<?php

namespace Drupal\asocol\Plugin\DsField;

use Drupal\ds\Plugin\DsField\DsFieldBase;

/**
 * Plugin that renders the user print.
 *
 * @DsField(
 *   id = "user_print",
 *   title = @Translation("User Print"),
 *   entity_type = "user",
 *   provider = "user"
 * )
 */
class UserPrint extends DsFieldBase {

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
