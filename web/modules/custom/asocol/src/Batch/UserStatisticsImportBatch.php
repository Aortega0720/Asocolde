<?php

namespace Drupal\asocol\Batch;

use Drupal\user\Entity\User;
use Drupal\eck\Entity\EckEntity;
use Drupal\commerce_product\Entity\Product;
use Drupal\commerce_product\Entity\ProductVariation;

/**
 * Methods for running the CSV import in a batch.
 *
 * @package Drupal\asocol
 */
class UserStatisticsImportBatch {

  /**
   * Handle batch completion.
   *
   *   Creates a new CSV file containing all failed rows if any.
   */
  public static function csvImportFinished($success, $results, $operations) {
    return t('The CSV import has completed.');
  }

  /**
   * Process a single line.
   */
  public static function csvimportImportLine($line, &$context) {
    $uid = $line[0];
    $year = $line[1];
    $statistic_months = $line[2];

    $entity_type_manager = \Drupal::entityTypeManager();

    $user = $entity_type_manager->getStorage('user')->load($uid);
    if($user instanceof User) {
      $connection = \Drupal::service('database');
      foreach($statistic_months as $month => $data) {
        $connection->insert('dermatologist_statistics')
          ->fields([
            'uid' => $uid,
            'month' => $month,
            'year' => $year,
            'total' => $data['num'],
          ])
          ->execute();
      }
    }
  }

}
