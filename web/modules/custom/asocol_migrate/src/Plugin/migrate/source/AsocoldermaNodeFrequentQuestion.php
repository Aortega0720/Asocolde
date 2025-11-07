<?php

/**
 * @file
 * Contains \Drupal\asocol_migrate\Plugin\migrate\source\AsocoldermaNodeFrequentQuestion.
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
 * Extract frequents questions nodes from Drupal 7 database.
 *
 * @MigrateSource(
 *   id = "asocolderma_node_frequent_question"
 * )
 */
class AsocoldermaNodeFrequentQuestion extends AsocoldermaNode {

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    $isPrepareRow = parent::prepareRow($row);

    $uid = $row->getSourceProperty('node_uid');
    $nid = $row->getSourceProperty('nid');

    // body
    $body = $row->getSourceProperty('body');
    if(!empty($body[0]['value'])) {
      $body[0]['value'] = str_replace('/sites/default/files/', '/sites/default/files_d7/', $body[0]['value']);
      $row->setSourceProperty('body', $body);
    }

    // field_tipo_enfermedad
    $row->setSourceProperty(
      'field_tipo_enfermedad',
      $this->getFieldTaxonomyTerm('field_data_field_tipo_enfermedad', 'field_tipo_enfermedad_tid', 'node', $nid, 'diseases_types', TRUE)
    );

    // field_body_en_ingles
    $field_body_en_ingles = $row->getSourceProperty('field_body_en_ingles');
    if(!empty($field_body_en_ingles[0]['value'])) {
      $field_body_en_ingles[0]['value'] = str_replace('/sites/default/files/', '/sites/default/files_d7/', $field_body_en_ingles[0]['value']);
      $row->setSourceProperty('field_body_en_ingles', $field_body_en_ingles);
    }

    return $isPrepareRow;
  }

}
