<?php

namespace Drupal\asocol\Plugin\DsField;

use Drupal\ds\Plugin\DsField\Date;
use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Component\Datetime\TimeInterface;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Component\Render\FormattableMarkup;
use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin that renders the post date of a node.
 *
 * @DsField(
 *   id = "node_post_date",
 *   title = @Translation("Post date"),
 *   entity_type = "node",
 *   provider = "node"
 * )
 */
class NodePostDate extends Date {

  /**
   * The current Request object.
   *
   * @var \Symfony\Component\HttpFoundation\Request
   */
  protected $request;

  /**
   * Constructs a Display Suite field plugin.
   */
  public function __construct($configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager, DateFormatterInterface $date_formatter, TimeInterface $time, Request $request) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $entity_type_manager, $date_formatter, $time);

    $this->request = $request;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager'),
      $container->get('date.formatter'),
      $container->get('datetime.time'),
      $container->get('request_stack')->getCurrentRequest()

    );
  }

  /**
   * {@inheritdoc}
   */
  public function getRenderKey() {
    return 'created';
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $render_key = $this->getRenderKey();
    $field = $this->getFieldConfiguration();

    if($field['formatter'] == 'ds_past_date_time_ago') {
      return $this->formatTimestamp($this->entity()->{$render_key}->value);
    }
    else {
      $date_format = str_replace('ds_post_date_', '', $field['formatter']);
      return [
        '#markup' => $this->dateFormatter->format($this->entity()->{$render_key}->value, $date_format),
      ];
    }
  }

  /**
   * {@inheritdoc}
   */
  public function formatters() {
    $date_types = $this->entityTypeManager->getStorage('date_format')
      ->loadMultiple();

    $date_formatters = [];
    foreach ($date_types as $machine_name => $entity) {
      /* @var $entity \Drupal\Core\Datetime\DateFormatInterface */
      if ($entity->isLocked()) {
        continue;
      }
      $date_formatters['ds_post_date_' . $machine_name] = $entity->label() . ' (' . $this->dateFormatter->format($this->time->getRequestTime(), $entity->id()) . ')';
    }

    $date_formatters['ds_past_date_time_ago'] = $this->t('Time ago');

    return $date_formatters;
  }

  /**
   * Formats a timestamp.
   *
   * @param int $timestamp
   *   A UNIX timestamp to format.
   *
   * @return array
   *   The formatted timestamp string using the past or future format setting.
   */
  protected function formatTimestamp($timestamp) {
    $granularity = 1;
    $options = [
      'granularity' => $granularity,
      'return_as_object' => TRUE,
    ];
    $past_format = 'Hace @interval';
    $future_format = '@interval hence';

    if ($this->request->server->get('REQUEST_TIME') > $timestamp) {
      $result = $this->dateFormatter->formatTimeDiffSince($timestamp, $options);
      $build = [
        '#markup' => new FormattableMarkup($past_format, ['@interval' => $result->getString()]),
      ];
    }
    else {
      $result = $this->dateFormatter->formatTimeDiffUntil($timestamp, $options);
      $build = [
        '#markup' => new FormattableMarkup($future_format, ['@interval' => $result->getString()]),
      ];
    }
    CacheableMetadata::createFromObject($result)->applyTo($build);
    return $build;
  }

}
