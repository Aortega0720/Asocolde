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

abstract class AsocoldermaNode extends Node {

  protected $sourceDirectory = 'sites/default/files_d7';

  /**
   * {@inheritdoc}
   */
  public function entityTypeId() {
    return 'node';
  }

  protected function getFieldValue($table, $field, $entity_type, $entity_id) {
    $value = NULL;
    $result = $this->getDatabase()->query(
      "
      SELECT fld.$field as value FROM {$table} fld
      WHERE fld.entity_type = :entity_type AND fld.entity_id = :entity_id
      ",
      [':entity_id' => $entity_id, ':entity_type' => $entity_type]
    );
    foreach ($result as $record) {
      $value = $record->value;
    }

    return $value;
  }

  protected function getFieldImage($table, $field_fid, $field_title, $field_alt, $entity_type, $entity_id, $uid, $directory) {
    $value = NULL;
    $result = $this->getDatabase()->query(
      "
      SELECT fld.$field_fid as fid, fld.$field_title as title, fld.$field_alt as alt, fm.uri as uri FROM {$table} fld
      INNER JOIN file_managed as fm  ON fm.fid = fld.$field_fid
      WHERE fld.entity_type = :entity_type AND fld.entity_id = :entity_id
      ",
      [':entity_id' => $entity_id, ':entity_type' => $entity_type]
    );

    foreach ($result as $record) {
      $filepath = $this->sourceDirectory . '/' . str_replace('public://', '', $record->uri);
      $uri = $directory . '/' . basename($filepath);
      /** @var \Drupal\Core\File\FileSystemInterface $file_system */
      $file_system = \Drupal::service('file_system');
      $file_system->copy($filepath, $uri, FileSystemInterface::EXISTS_REPLACE);

      $file = File::create([
        'filename' => basename($filepath),
        'uri' => $uri,
        'status' => 1,
        'uid' => $uid,
      ]);
      $file->save();

      return [
        'fid' => $file->id(),
        'title' => $record->title,
        'alt' => $record->alt,
      ];
    }

    return NULL;
  }

  protected function getFieldTaxonomyTerm($table, $field, $entity_type, $entity_id, $vid, $multiple=FALSE) {
    $terms_id = [];
    $result = $this->getDatabase()->query("
      SELECT td.name as name FROM {$table} fld
      INNER JOIN taxonomy_term_data as td  ON td.tid = fld.$field
      WHERE fld.entity_type = :entity_type AND fld.entity_id = :entity_id
      ",
      [':entity_id' => $entity_id, ':entity_type' => $entity_type]
    );
    foreach ($result as $record) {
      $name = trim($record->name);
      $term_id = $this->getTidByName($name, $vid);
      if($term_id == 0) {
        $term_id = $this->createTerm($name, $vid);
      }

      if($multiple) {
        $terms_id[] = ['tid' => $term_id];
      }
      else {
        return $term_id;
      }
    }

    return empty($terms_id) ? NULL : $terms_id;
  }

  protected function getTidByName($name, $vid) {
    $properties = [];
    if (!empty($name)) {
      $properties['name'] = $name;
    }
    if (!empty($vid)) {
      $properties['vid'] = $vid;
    }
    $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadByProperties($properties);
    $term = reset($terms);

    return !empty($term) ? $term->id() : 0;
  }

  protected function createTerm($name, $vid) {
    $term = Term::create([
      'vid' => $vid,
      'name' => $name,
    ]);

    $term->enforceIsNew();
    $term->save();

    return $term->id();
  }

}
