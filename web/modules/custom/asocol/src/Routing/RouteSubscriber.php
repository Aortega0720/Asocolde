<?php

namespace Drupal\asocol\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Listens to the dynamic route events.
 */
class RouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
    if ($route = $collection->get('user.login')) {
      $route->setDefault('_controller', '\Drupal\asocol\Controller\UserController::userLogin');
      $route->setDefault('_form', NULL);
    }
  }

}
