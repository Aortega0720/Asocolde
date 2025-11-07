<?php

namespace Drupal\asocol\Plugin\Field\FieldWidget;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\Plugin\Field\FieldWidget\OptionsButtonsWidget;

/**
 * Plugin implementation of the 'bootstrap_options_buttons' widget.
 *
 * @FieldWidget(
 *   id = "bootstrap_options_buttons",
 *   label = @Translation("Bootstrap Check boxes/radio buttons"),
 *   field_types = {
 *     "entity_reference",
 *     "list_integer",
 *     "list_float",
 *     "list_string",
 *   },
 *   multiple_values = TRUE
 * )
 */
class BootstrapOptionsButtonsWidget extends OptionsButtonsWidget {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = parent::formElement($items, $delta, $element, $form, $form_state);
    switch ($element['#type']) {
      case 'checkbox':
      case 'radio':
        $element['#theme'] = 'elements__bootstrap_options_buttons';
        break;
      case 'checkboxes':
      case 'radios':
        if (isset($element['#options']) && count($element['#options']) > 0) {
          foreach ($element['#options'] as $key => $choice) {
            $element[$key]['#theme'] = 'elements__bootstrap_options_buttons';
            $element[$key]['#title_display'] = 'hidden';
          }
        }
        break;
    }

    return $element;
  }

}
