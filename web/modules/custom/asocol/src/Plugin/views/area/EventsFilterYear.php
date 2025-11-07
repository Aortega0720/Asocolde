<?php

namespace Drupal\asocol\Plugin\views\area;

use Drupal\Core\Url;
use Drupal\views\Plugin\views\area\AreaPluginBase;
/**
 * Views area events filter year.
 *
 * @ingroup views_area_handlers
 *
 * @ViewsArea("events_filter_year")
 */
class EventsFilterYear extends AreaPluginBase {

  /**
   * {@inheritdoc}
   */
  public function render($empty = FALSE) {
    $current_year = date('Y');
    $next_year = $current_year + 1;

    return [
      '#type' => 'container',
      '#attributes' => [
        'class' => ['events-years'],
      ],
      'current_year' => [
        '#type' => 'link',
        '#title' => $this->t('Next year @current_year', ['@current_year'=>$current_year]),
        '#url' => Url::fromRoute('view.events.page'),
        '#attributes' => [
          'class' => ['events-current-year'],
        ],
      ],
      'next_year' => [
        '#type' => 'link',
        '#title' => $this->t('Future events @next_year', ['@next_year'=>$next_year]),
        '#url' => Url::fromRoute(
          'view.events.page', [], ['query'=>['fecha_inicio'=>"$next_year-01-01",'fecha_final'=>"$next_year-12-31"]]
        ),
        '#attributes' => [
          'class' => ['events-next-year'],
        ],
      ],
    ];
  }

}
