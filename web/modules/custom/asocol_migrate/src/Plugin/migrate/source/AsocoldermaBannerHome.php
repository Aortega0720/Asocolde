<?php

/**
 * @file
 * Contains \Drupal\asocol_migrate\Plugin\migrate\source\AsocoldermaBannerHome.
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
 * Extract banner home nodes from Drupal 7 database.
 *
 * @MigrateSource(
 *   id = "asocolderma_banner_home"
 * )
 */
class AsocoldermaBannerHome extends AsocoldermaNode {

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    $isPrepareRow = parent::prepareRow($row);

    $uid = $row->getSourceProperty('node_uid');
    $nid = $row->getSourceProperty('nid');

    // field_url_enlace_uri
    $row->setSourceProperty(
      'field_url_enlace_uri',
      $this->getFieldValue('field_data_field_url_enlace', 'field_url_enlace_value', 'node', $nid)
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
      'public://banner'
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

    // field_ubicacion_del_banner_fid
    $row->setSourceProperty(
      'field_ubicacion_del_banner_fid',
      $this->getFieldTaxonomyTerm('field_data_field_ubicacion_del_banner', 'field_ubicacion_del_banner_tid', 'node', $nid, 'banner_location')
    );

    return $isPrepareRow;
  }

}
