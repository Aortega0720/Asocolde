<?php

namespace Drupal\asocol\Plugin\Commerce\CheckoutPane;

use Drupal\commerce_checkout\Plugin\Commerce\CheckoutPane\CheckoutPaneBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides the order complete information.
 *
 * @CommerceCheckoutPane(
 *   id = "order_complete_information",
 *   label = @Translation("Order complete information"),
 *   default_step = "complete",
 * )
 */
class OrderCompleteInformation extends CheckoutPaneBase {

  /**
   * {@inheritdoc}
   */
  public function buildPaneForm(array $pane_form, FormStateInterface $form_state, array &$complete_form) {
    $pane_form['summary'] = [
      '#type' => 'view',
      '#name' => 'order_complete_information',
      '#display_id' => 'default',
      '#arguments' => [$this->order->id()],
      '#embed' => TRUE,
    ];
    if ($this->order->getState()->getString() === 'completed') {
      $pane_form['footer'] = [
        '#theme' => 'asocol_order_complete',
      ];
    }

    return $pane_form;
  }

}
