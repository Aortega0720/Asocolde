<?php

namespace Drupal\asocol\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides tabs with dermatologist article content.
 *
 * @Block(
 *   id = "asocol_tips_fq_doctor",
 *   admin_label = @Translation("Asocol Tabs Tips Fq"),
 * )
 */
class AsocolTabsTipsFqBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [
      '#theme' => 'asocol_tabs',
      '#id' => 'content-tips-fq',
      '#items' => [
        [
          'title' => 'Tips',
          'id' => 'tips',
          'class_tab' => 'nav-link active',
          'content' => [
            '#type' => 'view',
            '#name' => 'tabs_categories',
            '#display_id' => 'block_tips',
            '#embed' => TRUE,
          ],
          'class_content' => 'tab-pane fade show active',
        ],
        [
          'title' => 'Preguntas',
          'id' => 'fq',
          'class_tab' => 'nav-link',
          'content' => [
            '#type' => 'view',
            '#name' => 'tabs_categories',
            '#display_id' => 'block_fq',
            '#embed' => TRUE,
          ],
          'class_content' => 'tab-pane fade',
        ],
      ],
    ];

    return $build;
  }

}
