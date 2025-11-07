<?php

namespace Drupal\asocol\Plugin\DsField;

use Drupal\ds\Plugin\DsField\DsFieldBase;

/**
 * Plugin that renders the respect name of the user.
 *
 * @DsField(
 *   id = "drdra",
 *   title = @Translation("DrDra"),
 *   entity_type = "user",
 *   provider = "user"
 * )
 */
class DrDra extends DsFieldBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $user = $this->entity();
    $sex = $user->field_sex->getString();
    return [
      '#markup' => $sex == 1 ? 'Dra.' : 'Dr.',
      '#cache' => [
        'tags' => $user->getCacheTags(),
      ],
    ];
  }

}
