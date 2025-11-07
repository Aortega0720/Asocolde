<?php

namespace Drupal\asocol\Form;

use Drupal\Core\Url;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

 /**
 * Implements a Search Dermatologist Form.
 */
class SearchDermatologistForm extends FormBase {

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
    return 'search_dermatologist_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['text'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Search'),
      '#title_display' => 'invisible',
      '#attributes' => [
        'placeholder' => $this->t('Search by name or surname'),
      ],
    );
    $form['city'] = array(
      '#type' => 'select',
      '#title' => $this->t('City'),
      '#title_display' => 'invisible',
      '#options' => $this->getCities(),
    );
    $form['actions'] = [
      '#type' => 'actions',
    ];
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Search dermatologist'),
    );

    return $form;
  }

  /**
   * @param array $form
   * @param FormStateInterface $form_state
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $query = [
      'nombre' => $form_state->getValue('text'),
      'ciudad' => $form_state->getValue('city'),
    ];
    $url = Url::fromRoute('view.dermatologists.page', [], ['query' => $query]);
    $form_state->setRedirectUrl($url);
  }

  private function getCities() {
    $options = ['' => $this->t('City')];
    $terms = $this->entityTypeManager->getStorage('taxonomy_term')->loadTree('city');
    foreach ($terms as $item) {
      $options[$item->tid] = $item->name;
    }

    return $options;
  }

}
