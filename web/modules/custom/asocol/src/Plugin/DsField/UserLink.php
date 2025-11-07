<?php

namespace Drupal\asocol\Plugin\DsField;

use Drupal\ds\Plugin\DsField\DsFieldBase;

/**
 * Plugin that renders the user print.
 *
 * @DsField(
 *   id = "user_link",
 *   title = @Translation("User Link"),
 *   entity_type = "user",
 *   provider = "user"
 * )
 */
class UserLink extends DsFieldBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $user = $this->entity();
    return [
      '#type' => 'link',
      '#title' => 'Ver perfil',
      '#url' => $user->toLink()->getUrl(),
      '#cache' => [
        'tags' => $user->getCacheTags(),
      ],
    ];
  }

}
