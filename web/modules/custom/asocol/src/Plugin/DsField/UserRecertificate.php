<?php

namespace Drupal\asocol\Plugin\DsField;

use Drupal\ds\Plugin\DsField\DsFieldBase;

/**
 * Plugin that renders the user print.
 *
 * @DsField(
 *   id = "user_recertificate",
 *   title = @Translation("User recertificate"),
 *   entity_type = "user",
 *   provider = "user"
 * )
 */
class UserRecertificate extends DsFieldBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $user = $this->entity();
    $recertified = $user->field_dermatologist_recertified->value;
    if ($recertified) {
      return [
        '#markup' => '<span>Dermatólogo Re-certificado</span><span class="moneda-item"></span>',
      ];
    }
  }

}
