<?php

namespace Drupal\asocol\Form;

use Drupal\Core\Url;
use Drupal\file\Entity\File;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

 /**
 * Implements a User Statistics Import Import Form.
 */
class UserStatisticsImportForm extends FormBase {

  /**
   * Stores an entity type manager instance.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a MenuLinkEditForm object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManager $entity_type_manager
   *   An instance of the entity type manager.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  public function getFormId() {
    return 'memberships_import_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['file'] = [
      '#type' => 'managed_file',
      '#title' => 'Archivo de importación csv',
      '#required' => TRUE,
      '#upload_location' => 'public://import',
      '#upload_validators' => [
        'file_validate_extensions' => ['csv'],
      ],
    ];
    $form['actions'] = [
      '#type' => 'actions',
    ];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Import'),
    ];

    return $form;
  }

  /**
   * @param array $form
   * @param FormStateInterface $form_state
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $file_value = $form_state->getValue('file');
    $file = File::load($file_value[0]);
    $file_url = $file->createFileUrl(TRUE);
    $file_url = substr($file_url, 1);

    $operations = [];
    if (($handle = fopen($file_url, 'r')) !== FALSE) {
      while (($line = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $line[2] = unserialize($line[2]);
        $operations[] = [
          '\Drupal\asocol\Batch\UserStatisticsImportBatch::csvimportImportLine',
          [$line],
        ];
      }
      fclose($handle);
    }

    if(!empty($operations)) {
      $batch = [
        'title'            => $this->t('Importing memberships...'),
        'operations'       => $operations,
        'init_message'     => $this->t('Starting'),
        'progress_message' => $this->t('Processed @current out of @total.'),
        'error_message'    => $this->t('An error occurred during processing'),
        'finished'         => '\Drupal\asocol\Batch\UserStatisticsImportBatch::csvImportFinished',
      ];
      batch_set($batch);
    }
  }

}
