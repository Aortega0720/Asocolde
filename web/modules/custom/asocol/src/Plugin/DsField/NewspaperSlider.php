<?php

namespace Drupal\asocol\Plugin\DsField;

use Drupal\ds\Plugin\DsField\DsFieldBase;

/**
 * Plugin that renders the respect name of the user.
 *
 * @DsField(
 *   id = "newspaper_slider",
 *   title = @Translation("Newspaper Slider"),
 *   entity_type = "block_content",
 *   provider = "block_content"
 * )
 */
class NewspaperSlider extends DsFieldBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $block = $this->entity();
    return [
      '#type' => 'view',
      '#name' => 'newspaper_slider',
      '#display_id' => 'block',
      '#arguments' => [$block->id()],
      '#embed' => TRUE,
      '#cache' => [
        'tags' => $block->getCacheTags(),
      ],
    ];
  }

}
