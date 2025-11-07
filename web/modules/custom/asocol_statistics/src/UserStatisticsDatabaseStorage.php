<?php

namespace Drupal\asocol_statistics;

use Drupal\Core\Database\Connection;
use Drupal\Core\State\StateInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Provides the default database storage backend for statistics.
 */
class UserStatisticsDatabaseStorage implements StatisticsStorageInterface {

  /**
   * The database connection used.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $connection;

  /**
   * The state service.
   *
   * @var \Drupal\Core\State\StateInterface
   */
  protected $state;

  /**
   * The request stack.
   *
   * @var \Symfony\Component\HttpFoundation\RequestStack
   */
  protected $requestStack;

  /**
   * Constructs the statistics storage.
   *
   * @param \Drupal\Core\Database\Connection $connection
   *   The database connection for the node view storage.
   * @param \Drupal\Core\State\StateInterface $state
   *   The state service.
   * @param \Symfony\Component\HttpFoundation\RequestStack $request_stack
   *   The request stack.
   */
  public function __construct(Connection $connection, StateInterface $state, RequestStack $request_stack) {
    $this->connection = $connection;
    $this->state = $state;
    $this->requestStack = $request_stack;
  }

  /**
   * {@inheritdoc}
   */
  public function recordView($id) {
    $month = date('n');
    $year = date('Y');
    $test = (bool) $this->connection
      ->merge('dermatologist_statistics')
      ->key([
        'uid' => $id,
        'month' => $month,
        'year' => $year,
      ])
      ->expression('total', '[total] + 1')
      ->execute();
  }

  /**
   * {@inheritdoc}
   */
  public function fetchViews($id) {
    $views = $this->connection
      ->select('dermatologist_statistics', 'ds')
      ->fields('ds', ['month', 'year', 'total'])
      ->condition('uid', $id)
      ->orderBy('year', 'DESC')
      ->execute()
      ->fetchAll();

    $data = [];
    foreach ($views as $id => $view) {
      $data[$view->year][$view->month] = $view->total;
    }

    return $data;
  }

  /**
   * {@inheritdoc}
   */
  public function fetchView($id) {
    $views = $this->fetchViews([$id]);
    return reset($views);
  }

  /**
   * {@inheritdoc}
   */
  public function fetchAll($order = 'totalcount', $limit = 5) {
    assert(in_array($order, ['totalcount', 'daycount', 'timestamp']), "Invalid order argument.");

    return $this->connection
      ->select('node_counter', 'nc')
      ->fields('nc', ['nid'])
      ->orderBy($order, 'DESC')
      ->range(0, $limit)
      ->execute()
      ->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function maxTotalCount() {
    $query = $this->connection->select('node_counter', 'nc');
    $query->addExpression('MAX([totalcount])');
    $max_total_count = (int) $query->execute()->fetchField();
    return $max_total_count;
  }

}
