<?php

namespace Drupal\asocol\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides tabs with dermatologist article content.
 *
 * @Block(
 *   id = "asocol_tabs_doctor",
 *   admin_label = @Translation("Asocol Tabs Doctor"),
 * )
 */
class AsocolTabsDoctorBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [
      '#theme' => 'asocol_tabs',
      '#id' => 'content-dermatologist',
      '#items' => [
        [
          'title' => 'Contenido Académico',
          'id' => 'academic',
          'class_tab' => 'nav-link active',
          'content' => [
            '#type' => 'view',
            '#name' => 'tabs_categories',
            '#display_id' => 'block_academic',
            '#embed' => TRUE,
          ],
          'class_content' => 'tab-pane fade show active',
        ],
        [
          'title' => 'Casos clínicos',
          'id' => 'clinic',
          'class_tab' => 'nav-link',
          'content' => [
            '#type' => 'view',
            '#name' => 'tabs_categories',
            '#display_id' => 'block_clinical',
            '#embed' => TRUE,
          ],
          'class_content' => 'tab-pane fade',
        ],
      ],
    ];

    return $build;
  }

}
