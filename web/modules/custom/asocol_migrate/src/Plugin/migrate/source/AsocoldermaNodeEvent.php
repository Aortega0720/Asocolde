<?php

/**
 * @file
 * Contains \Drupal\asocol_migrate\Plugin\migrate\source\AsocoldermaNodeArticle.
 */

namespace Drupal\asocol_migrate\Plugin\migrate\source;

use Drupal\migrate\Row;
use Drupal\file\Entity\File;
use Drupal\taxonomy\Entity\Term;
use Drupal\Core\File\FileSystemInterface;
use Drupal\node\Plugin\migrate\source\d7\Node;
use Drupal\Core\Database\Query\SelectInterface;
use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Extract events nodes from Drupal 7 database.
 *
 * @MigrateSource(
 *   id = "asocolderma_node_event"
 * )
 */
class AsocoldermaNodeEvent extends AsocoldermaNode {

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    $isPrepareRow = parent::prepareRow($row);

    $uid = $row->getSourceProperty('node_uid');
    $nid = $row->getSourceProperty('nid');

    // field_fecha
    $date_text = $this->getFieldValue('field_data_field_fecha', 'field_fecha_value', 'node', $nid);
    if(!empty($date_text)) {
      $row->setSourceProperty('field_fecha_value1', str_replace(' ', 'T', $date_text));
    }
    $date_text = $this->getFieldValue('field_data_field_fecha', 'field_fecha_value2', 'node', $nid);
    if(!empty($date_text)) {
      $row->setSourceProperty('field_fecha_value2', str_replace(' ', 'T', $date_text));
    }

    // body
    $body = $row->getSourceProperty('body');
    if(!empty($body[0]['value'])) {
      $body[0]['value'] = str_replace('/sites/default/files/', '/sites/default/files_d7/', $body[0]['value']);
      $row->setSourceProperty('body', $body);
    }

    // field_ubicacion_portada
    $row->setSourceProperty(
      'field_ubicacion_portada',
      $this->getFieldTaxonomyTerm('field_data_field_ubicacion_portada', 'field_ubicacion_portada_tid', 'node', $nid, 'event_location', TRUE)
    );

    // field_image
    $image_data = $this->getFieldImage(
      'field_data_field_image',
      'field_image_fid',
      'field_image_title',
      'field_image_alt',
      'node',
      $nid,
      $uid,
      'public://event'
    );
    if ($image_data) {
      $row->setSourceProperty(
        'field_image_fid',
        $image_data['fid']
      );
      $row->setSourceProperty(
        'field_image_alt',
        $image_data['alt']
      );
      $row->setSourceProperty(
        'field_image_title',
        $image_data['title']
      );
    }

    // field_categoria_del_evento
    $row->setSourceProperty(
      'field_categoria_del_evento',
      $this->getFieldTaxonomyTerm('field_data_field_categoria_del_evento', 'field_categoria_del_evento_tid', 'node', $nid, 'event')
    );

    // field_tags
    $row->setSourceProperty(
      'field_tags',
      $this->getFieldTaxonomyTerm('field_data_field_tags', 'field_tags_tid', 'node', $nid, 'tags', TRUE)
    );

    return $isPrepareRow;
  }

}
