<?php

namespace Drupal\asocol\Plugin\views\field;

use Drupal\views\ResultRow;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\commerce_product\Entity\ProductInterface;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * A handler to provide membership status by year.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("asocol_membership_status")
 */
class AsocolMembershipStatus extends FieldPluginBase {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $currentUser;

  /**
   * Constructs a new AsocolMembershipStatus object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param array $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(array $configuration, $plugin_id, array $plugin_definition, EntityTypeManagerInterface $entity_type_manager, AccountInterface $current_user) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->entityTypeManager = $entity_type_manager;
    $this->currentUser = $current_user;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager'),
      $container->get('current_user')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function query() {
    // This function exists to override parent query function.
    // Do nothing.
  }

  /**
   * {@inheritdoc}
   */
  public function render(ResultRow $values) {
    $entity = $this->getEntity($values);
    $term = $this->entityTypeManager->getStorage('taxonomy_term')->load($values->commerce_product__field_year_field_year_target_id);
    $year_current = date('Y');
    if ($entity instanceof ProductInterface) {
      $membership = $this->entityTypeManager->getStorage('membership')->loadByProperties([
        'uid' => $this->currentUser->id(),
        'field_product' => $entity->id(),
      ]);
      if (is_array($membership) && count($membership) > 0) {
        $membership = reset($membership);
        $allowed_values = $membership->field_membership_status->getSetting('allowed_values');
        $key = $membership->field_membership_status->getString();
        if ($term->label() == $year_current  &&  $key == 'no_vinculado') {
          return \Drupal::formBuilder()->getForm('Drupal\asocol\Form\MembershipPayForm', $entity);
        }
        return $allowed_values[$key];
      }
    }

    if ($term->label() == $year_current) {
      return \Drupal::formBuilder()->getForm('Drupal\asocol\Form\MembershipPayForm');
    }

    return 'No vinculado';
  }

}
