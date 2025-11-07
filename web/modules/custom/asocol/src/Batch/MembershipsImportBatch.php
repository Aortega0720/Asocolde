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
class MembershipsImportBatch {

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
    $mail = $line[0];
    $sku = $line[1];
    $status = $line[2];

    $entity_type_manager = \Drupal::entityTypeManager();

    $users = $entity_type_manager->getStorage('user')->loadByProperties(['mail' => $mail]);
    $user = reset($users);
    if($user instanceof User) {
      $product_variations = $entity_type_manager->getStorage('commerce_product_variation')->loadByProperties(['sku' => $sku]);
      $product_variation = reset($product_variations);
      if($product_variation instanceof ProductVariation) {
        $product = $product_variation->product_id->entity;
        $memberships = $entity_type_manager->getStorage('membership')->loadByProperties([
          'uid' => $user->id(),
          'field_product' => $product->id(),
        ]);
        $year = $product->field_year->entity->label();
        if(empty($memberships)) {
          $fields = [
            'entity_type' => 'membership',
            'type' => 'membership',
            'uid' => $user->id(),
            'title' => "Pago membresía {$year} - $mail",
            'field_membership_status' => [
              [
                'value' => $status,
              ]
            ],
            'field_product' => $product->id(),
          ];
          $membership = EckEntity::create($fields);
        }
        else {
          $membership = reset($memberships);
          $membership->set('field_membership_status', $status);
        }
        $membership->save();

        $year_current = date('Y');
        if($year_current == $year) {
          if($user->isBlocked() && $status == 'pagado') {
            $user->activate();
            $user->field_membership = TRUE;
            $user->save();
          }
          elseif($user->isActive() && $status == 'no_vinculado') {
            $user->block();
            $user->field_membership = FALSE;
            $user->save();
          }
        }

        $context['message'] = t('Importing %title', ['%title' => $membership->label()]);
      }
    }
  }

}
