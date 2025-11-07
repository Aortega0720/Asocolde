<?php

/**
 * @file
 * Contains \Drupal\asocol_migrate\Plugin\migrate\source\AsocoldermaNodeVideo.
 */

namespace Drupal\asocol_migrate\Plugin\migrate\source;

use Drupal\migrate\Row;
use Drupal\media\Entity\Media;
use Drupal\file\Entity\File;
use Drupal\taxonomy\Entity\Term;
use Drupal\Core\File\FileSystemInterface;
use Drupal\node\Plugin\migrate\source\d7\Node;
use Drupal\Core\Database\Query\SelectInterface;
use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Extract videos nodes from Drupal 7 database.
 *
 * @MigrateSource(
 *   id = "asocolderma_node_video"
 * )
 */
class AsocoldermaNodeVideo extends AsocoldermaNode {

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

    // field_tags
    $row->setSourceProperty(
      'field_tags',
      $this->getFieldTaxonomyTerm('field_data_field_tags', 'field_tags_tid', 'node', $nid, 'tags', TRUE)
    );

    // field_tipo_enfermedad
    $row->setSourceProperty(
      'field_tipo_enfermedad',
      $this->getFieldTaxonomyTerm('field_data_field_tipo_enfermedad', 'field_tipo_enfermedad_tid', 'node', $nid, 'diseases_types', TRUE)
    );

    // field_video_mid
    // $field_video_url = $row->getSourceProperty('field_video_url');
    // print_r($field_video_url);
    // if(!empty($field_video_url[0]['video_url'])) {
    //   $media = Media::create([
    //     'bundle'      => 'remote_video',
    //     'uid'         => $uid,
    //     'field_media_oembed_video' => [
    //       'value' => $field_video_url[0]['video_url'],
    //     ],
    //   ]);
    //   try {
    //     $source = $media->getSource();
    //     $url = $source->getSourceFieldValue($media);
    //     if (empty($url)) {
    //       print "Error en el video del proveedor";
    //     } else {
    //       $media->save();
    //       $row->setSourceProperty('field_video_mid', $media->id());
    //     }
    //   } catch (Exception $e) {
    //     print "Error en el video del proveedor try ";
    //     print_r($e->getMessage());
    //   }
    // }




    return $isPrepareRow;
  }

}
