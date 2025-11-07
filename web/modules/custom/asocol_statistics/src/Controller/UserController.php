<?php

namespace Drupal\asocol_statistics\Controller;

use Drupal\user\Entity\User;
use Drupal\Core\Datetime\DateHelper;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\asocol_statistics\UserStatisticsDatabaseStorage;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;

/**
 * Controller routines for user routes.
 */
class UserController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Stores the current logged in user or anonymous account.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * Constructs an UserController object.
   *
   * @param \Drupal\Core\Session\AccountProxyInterface $current_account
   *   An instance of the current logged in user or anonymous account.
   *   The session manager service.
   */
  public function __construct(AccountProxyInterface $current_user, UserStatisticsDatabaseStorage $user_statistics) {
    $this->currentUser = $current_user;
    $this->currentAccount = User::load($this->currentUser->id());
    $this->userStatistics = $user_statistics;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('current_user'),
      $container->get('asocol_statistics.storage.user')
    );
  }

  public function StatisticsPage(Request $request) {
    $total = 0;
    $year_current = date('Y');
    $years = [];
    $years_statistics = [];
    $monthNamesAbbr = [
      'Ene',
      'Feb',
      'Mar',
      'Abr',
      'May',
      'Jun',
      'Jul',
      'Ago',
      'Sep',
      'Oct',
      'Nov',
      'Dic',
    ];

    $years_rows_compare = [];
    $statistics = $this->userStatistics->fetchViews($this->currentUser->id());
    foreach($statistics as $year => $month_data) {
      $years[] = $year;
      for($x=0; $x<12; $x++) {
        if (!empty($month_data[$x])) {
          $count = (int) $month_data[$x];
        }
        else {
          $count = 0;
        }
        $years_statistics[$year][] = [
          $monthNamesAbbr[$x],
          $count,
          $count >= 500 ? '#008b8f' : '#00c1c7',
          (string) $count,
        ];

        if ((isset($years[0]) && $years[0] == $year) || (isset($years[1]) && $years[1] == $year)) {
          $years_rows_compare[$year][$x] = $count;
        }
      }

      foreach($month_data as $count) {
        $total += $count;
      }
    }

    $first_year = array_shift($years_rows_compare);
    $second_year = array_shift($years_rows_compare);
    $years_rows = [];
    for($x=0; $x<12; $x++) {
      $years_rows[] = [
        'c' => [
          [
            'v' => $monthNamesAbbr[$x],
            'f' => null,
          ],
          [
            'v' => $first_year[$x],
            'f' => null,
          ],
          [
            'v' => $first_year[$x],
            'f' => null,
          ],
          [
            'v' => $second_year[$x],
            'f' => null,
          ],
          [
            'v' => $second_year[$x],
            'f' => null,
          ],
        ],
      ];
    }

    $years_compare = [
      'cols' => [
        [
          'id' => '',
          'label' => 'Mes',
          'type' => 'string',
        ],
        [
          'id' => '',
          'label' => $years[0],
          'type' => 'number',
        ],
        [
          'id' => '',
          'role' => 'annotation',
          'type' => 'string',
        ],
        [
          'id' => '',
          'label' => $years[1],
          'type' => 'number',
        ],
        [
          'id' => '',
          'role' => 'annotation',
          'type' => 'string',
        ],
      ],
      'rows' => $years_rows,
    ];

    $statistics_year = [];
    $year_total = 0;
    for($x=0; $x<12; $x++) {
      $count = $statistics[$year_current][$x+1] ?? 0;
      $year_total += $count;
      $statistics_year[] = [
        $monthNamesAbbr[$x],
        (int) $count,
        $count >= 500 ? '#008b8f' : '#00c1c7',
        (string) $count,
      ];
    }

    $build['content'] = [
      '#theme' => 'dermatologist_statistics',
      '#years' => $years,
      '#years_statistics' => $years_statistics,
      '#year_current' => $year_current,
      '#year_before' => $year_current - 1,
      '#year_total' => $year_total,
      '#total' => $total,
      '#user_link' => $this->currentAccount->toLink('Vista actual de mi perfil'),
      '#attached' => [
        'library' => [
          'asocol_statistics/asocol_statistics.google_charts',
        ],
        'drupalSettings' => [
          'asocol_statistics' => [
            'years_statistics' => $years_statistics,
            'years_compare' => $years_compare,
            'years_compare_label' => "{$years[0]} - {$years[1]}",
            'years' => $years,
            'statistics_year' => $statistics_year,
          ],
        ],
      ],
    ];

    return $build;
  }

}
