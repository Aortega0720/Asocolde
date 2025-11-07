<?php

namespace Drupal\asocol\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'asocol_boolean_checkbox_display' widget.
 *
 * @FieldWidget(
 *   id = "asocol_boolean_checkbox_display",
 *   label = @Translation("Label display on/off checkbox"),
 *   field_types = {
 *     "boolean"
 *   },
 *   multiple_values = TRUE
 * )
 */
class AsocolBooleanCheckboxWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'display_label' => TRUE,
    ] + parent::defaultSettings();
  }

  private function getOptions($key=NULL) {
    $options = [
      'label' => $this->t('Label'),
      'description' => $this->t('Description'),
    ];

    return $key ? $options[$key] : $options;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {

    $element['display_label'] = [
      '#type' => 'radios',
      '#title' => $this->t('Display label'),
      '#description' => $this->t('Select the option used to as the label.'),
      '#options' => $this->getOptions(),
      '#default_value' => $this->getSetting('display_label'),
    ];
    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];

    $display_label = $this->getSetting('display_label');
    $summary[] = $this->t('Use field label: @display_label', ['@display_label' => $this->getOptions($display_label)]);

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element['value'] = $element + [
      '#type' => 'checkbox',
      '#default_value' => !empty($items[0]->value),
    ];

    // Override the title from the incoming $element.
    switch($this->getSetting('display_label')) {
      case 'label':
        $element['value']['#title'] = $this->fieldDefinition->getLabel();
        break;
      case 'description':
        $element['value']['#title'] = $this->getFilteredDescription();
        unset($element['value']['#description']);
        break;
      default:
        $element['value']['#title'] = $this->fieldDefinition->getSetting('on_label');
        break;
    }

    return $element;
  }

}
