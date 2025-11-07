<?php

namespace Drupal\asocol\Plugin\Block;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Block\BlockBase;

/**
 * Provides tools for each page like print, social share link, text resize.
 *
 * @Block(
 *   id = "asocol_tools",
 *   admin_label = @Translation("Asocol Tools"),
 * )
 */
class AsocolToolsBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [
      '#theme' => 'asocol_tools',
    ];

    return $build;
  }

  public function getCacheContexts() {
    return Cache::mergeContexts(parent::getCacheContexts(), ['url']);
  }

}
