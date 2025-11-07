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
class SearchSkinIllnessForm extends FormBase {

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
    return 'search_skin_illness_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['text'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Search'),
      '#title_display' => 'invisible',
      '#attributes' => [
        'placeholder' => $this->t('¿Qué enfermedad busca?'),
      ],
    );
    $form['category'] = array(
      '#type' => 'select',
      '#title' => $this->t('By category'),
      '#title_display' => 'invisible',
      '#options' => $this->getCategories(),
    );
    $form['actions'] = [
      '#type' => 'actions',
    ];
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Search'),
    );

    return $form;
  }

  /**
   * @param array $form
   * @param FormStateInterface $form_state
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $query = [
      'buscar' => $form_state->getValue('text'),
      'enfermedad' => $form_state->getValue('category'),
    ];
    $url = Url::fromRoute('view.skin_illness.page_1', [], ['query' => $query]);
    $form_state->setRedirectUrl($url);
  }

  private function getCategories() {
    $options = ['' => $this->t('By category')];
    $terms = $this->entityTypeManager->getStorage('taxonomy_term')->loadTree('diseases_types');
    foreach ($terms as $item) {
      $options[$item->tid] = $item->parents[0] == 0 ? $item->name : str_repeat('-', count($item->parents)) . $item->name;
    }

    return $options;
  }

}
