<?php

namespace Drupal\asocol\Plugin\views\area;

use Drupal\views\Plugin\views\area\AreaPluginBase;

/**
 * Views area with tools for each page like print, social share link, text resize.
 *
 * @ingroup views_area_handlers
 *
 * @ViewsArea("asocol_tools")
 */
class AsocolTools extends AreaPluginBase {

  /**
   * {@inheritdoc}
   */
  public function render($empty = FALSE) {
    return [
      '#theme' => 'asocol_tools',
    ];
  }

}
