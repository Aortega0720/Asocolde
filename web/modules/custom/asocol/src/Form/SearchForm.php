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
class SearchForm extends FormBase {

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
    return 'search_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['text'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Search'),
      '#title_display' => 'invisible',
      '#attributes' => [
        'placeholder' => $this->t('Search...'),
      ],
    ];
    $form['option'] = [
      '#type' => 'select',
      '#options' => [
        'dermatologists' => 'Dermatólogos',
        'skinillness' => 'Enfermedades dermatológicas',
        // 'congress' => 'Congresos y eventos académicos',
        'microsites' => 'Micrositios',
        'courses' => 'Cursos virtuales',
        'fq' => 'Preguntas frecuentes al dermatólogo',
      ],
      '#attributes' => [
        'onchange' => 'this.form.submit();',
      ],
    ];
    $form['actions'] = [
      '#type' => 'actions',
    ];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Search'),
    ];

    return $form;
  }

  /**
   * @param array $form
   * @param FormStateInterface $form_state
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $text = $form_state->getValue('text');
    $option = $form_state->getValue('option');
    switch($option) {
      case 'dermatologists':
        $url = Url::fromRoute('view.dermatologists.page', [], ['query' => ['nombre' => $text]]);
        break;
      case 'skinillness':
        $url = Url::fromRoute('view.skin_illness.page_1', [], ['query' => ['buscar' => $text]]);
        break;
      // case 'congress':
      //   $url = Url::fromUri('https://dermatologiaecuatoriana.com/');
      //   break;
      case 'microsites':
        $url = Url::fromUri('internal:/micrositios');
        break;
      case 'courses':
        $url = Url::fromRoute('view.courses_virtual.page', [], ['query' => ['buscar' => $text]]);
        break;
      case 'fq':
        $url = Url::fromRoute('view.fq.page', [], ['query' => ['buscar' => $text]]);
        break;
    }

    $form_state->setRedirectUrl($url);
  }

}
