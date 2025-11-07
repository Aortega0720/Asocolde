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
 * Extract articles nodes from Drupal 7 database.
 *
 * @MigrateSource(
 *   id = "asocolderma_node_article"
 * )
 */
class AsocoldermaNodeArticle extends AsocoldermaNode {

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

    // field_image
    $image_data = $this->getFieldImage(
      'field_data_field_image',
      'field_image_fid',
      'field_image_title',
      'field_image_alt',
      'node',
      $nid,
      $uid,
      'public://article'
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

    // field_categoria_tid
    $row->setSourceProperty(
      'field_categoria_tid',
      $this->getFieldTaxonomyTerm('field_data_field_categoria', 'field_categoria_tid', 'node', $nid, 'article')
    );

    // field_tipo_enfermedad
    $row->setSourceProperty(
      'field_tipo_enfermedad',
      $this->getFieldTaxonomyTerm('field_data_field_tipo_enfermedad', 'field_tipo_enfermedad_tid', 'node', $nid, 'diseases_types', TRUE)
    );

    // field_tags
    $row->setSourceProperty(
      'field_tags',
      $this->getFieldTaxonomyTerm('field_data_field_tags', 'field_tags_tid', 'node', $nid, 'tags', TRUE)
    );

    // field_ubicacion_en_el_home
    $row->setSourceProperty(
      'field_ubicacion_en_el_home',
      $this->getFieldTaxonomyTerm('field_data_field_ubicacion_en_el_home', 'field_ubicacion_en_el_home_tid', 'node', $nid, 'content_location', TRUE)
    );

    return $isPrepareRow;
  }

}
