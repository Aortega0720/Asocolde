<?php

/**
 * @file
 * Handles counts of node views via AJAX with minimal bootstrap.
 */

use Drupal\Core\DrupalKernel;
use Symfony\Component\HttpFoundation\Request;

chdir('../../..');

$autoloader = require_once 'autoload.php';

$kernel = DrupalKernel::createFromRequest(Request::createFromGlobals(), $autoloader, 'prod');
$kernel->boot();
$container = $kernel->getContainer();

$views = $container
  ->get('config.factory')
  ->get('statistics.settings')
  ->get('count_content_views');

if ($views) {
  $uid = filter_input(INPUT_POST, 'uid', FILTER_VALIDATE_INT);
  if ($uid) {
    $container->get('request_stack')->push(Request::createFromGlobals());
    $test = $container->get('asocol_statistics.storage.user')->recordView($uid);
  }
}
