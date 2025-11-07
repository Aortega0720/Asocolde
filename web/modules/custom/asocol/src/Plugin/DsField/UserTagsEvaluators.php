<?php

namespace Drupal\asocol\Plugin\DsField;

use Drupal\ds\Plugin\DsField\DsFieldBase;

/**
 * Plugin that renders the user tags evaluators.
 *
 * @DsField(
 *   id = "user_tags_evaluators",
 *   title = @Translation("User tags evaluators"),
 *   entity_type = "user",
 *   provider = "user"
 * )
 */
class UserTagsEvaluators extends DsFieldBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $user = $this->entity();
    return [
      '#type' => 'view',
      '#name' => 'tags_evaluators',
      '#display_id' => 'block',
      '#arguments' => [$user->id()],
      '#embed' => TRUE,
      '#cache' => [
        'tags' => $user->getCacheTags(),
      ],
    ];
  }

}
