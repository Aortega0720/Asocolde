<?php

namespace Drupal\asocol\Plugin\DsField;

use Drupal\Core\Cache\Cache;
use Drupal\ds\Plugin\DsField\DsFieldBase;

/**
 * Provides tools for each page like print, social share link, text resize.
 *
 * @DsField(
 *   id = "asocol_tools",
 *   title = @Translation("Asocol Tools"),
 *   entity_type = "node",
 *   provider = "node"
 * )
 */
class AsocolTools extends DsFieldBase {

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
