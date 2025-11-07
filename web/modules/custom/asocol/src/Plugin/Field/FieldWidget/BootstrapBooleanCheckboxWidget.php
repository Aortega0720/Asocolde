<?php

namespace Drupal\asocol\Plugin\Field\FieldWidget;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\Plugin\Field\FieldWidget\BooleanCheckboxWidget;

/**
 * Plugin implementation of the 'bootstrap_boolean_checkbox' widget.
 *
 * @FieldWidget(
 *   id = "bootstrap_boolean_checkbox",
 *   label = @Translation("Bootstrap on/off switch"),
 *   field_types = {
 *     "boolean"
 *   },
 *   multiple_values = TRUE
 * )
 */
class BootstrapBooleanCheckboxWidget extends BooleanCheckboxWidget {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = parent::formElement($items, $delta, $element, $form, $form_state);
    $element['value']['#theme'] = 'elements__bootstrap_options_buttons';
    $element['value']['#title_display'] = 'hidden';

    return $element;
  }

}
