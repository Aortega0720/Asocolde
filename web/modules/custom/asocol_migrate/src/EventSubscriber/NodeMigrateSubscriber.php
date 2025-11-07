<?php

namespace Drupal\asocol_migrate\EventSubscriber;

use Drupal\migrate\Event\MigrateEvents;
use Drupal\migrate\Event\MigratePostRowSaveEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/*
 */
class NodeMigrateSubscriber implements EventSubscriberInterface {

  /**
   * Maps the old nid to the new one in the key value collection.
   *
   * @param \Drupal\migrate\Event\MigratePostRowSaveEvent $event
   *   The migrate post row save event.
   */
  public function onPostRowSave(MigratePostRowSaveEvent $event) {
    $row = $event->getRow();

    $field_solo_para_dermatologos = $row->getSourceProperty('field_solo_para_dermatologos');

    if (!empty($field_solo_para_dermatologos[0]['value'])) {
      $destinationIdValues = $event->getDestinationIdValues();
      $nid = reset($destinationIdValues);
      if (!empty($nid)) {
        \Drupal::service('vapn.handler')->cleanEntriesByEntityId($nid);
        \Drupal::service('vapn.handler')->insertRoleEntry($nid, 'dermatologist');
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events = [];

    $events[MigrateEvents::POST_ROW_SAVE] = ['onPostRowSave'];

    return $events;
  }

}
