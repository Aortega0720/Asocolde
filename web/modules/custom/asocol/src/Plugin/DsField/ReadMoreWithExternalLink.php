<?php

namespace Drupal\asocol\Plugin\DsField;

use Drupal\Core\Form\FormStateInterface;
use Drupal\ds\Plugin\DsField\DsFieldBase;

/**
 * Plugin that renders the node link with external link.
 *
 * @DsField(
 *   id = "read_more_external_link",
 *   title = @Translation("Read More With External Link"),
 *   entity_type = "node",
 *   provider = "node"
 * )
 */
class ReadMoreWithExternalLink extends DsFieldBase {

  /**
   * {@inheritdoc}
   */
  public function settingsForm($form, FormStateInterface $form_state) {
    $config = $this->getConfiguration();

    $form['link text'] = [
      '#type' => 'textfield',
      '#title' => 'Link text',
      '#default_value' => $config['link text'],
    ];
    $form['link class'] = [
      '#type' => 'textfield',
      '#title' => 'Link class',
      '#default_value' => $config['link class'],
      '#description' => $this->t('Put a class on the link. Eg: btn btn-default'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary($settings) {
    $config = $this->getConfiguration();

    $summary = [];
    $summary[] = 'Link text: ' . $config['link text'];
    if (!empty($config['link class'])) {
      $summary[] = 'Link class: ' . $config['link class'];
    }

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {

    $configuration = [
      'link text' => 'Read more',
      'link class' => '',
    ];

    return $configuration;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $node = $this->entity();

    if ($node->field_url->isEmpty()) {
      $url = $node->toLink()->getUrl();
      $target = '_self';
    }
    else {
      $url = $node->field_url[0]->getUrl();
      $target = '_blank';
    }

    $config = $this->getConfiguration();

    return [
      '#type' => 'link',
      '#title' => $config['link text'],
      '#url' => $url,
      '#cache' => [
        'tags' => $node->getCacheTags(),
      ],
      '#attributes' => [
        'target' => $target,
        'class' => [$config['link class']],
      ],
    ];
  }

}
