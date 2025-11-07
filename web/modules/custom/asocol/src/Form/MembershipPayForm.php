<?php

namespace Drupal\asocol\Form;

use Drupal\Core\Url;
use Drupal\file\Entity\File;
use Drupal\Core\Form\FormBase;
use Drupal\commerce_order\Entity\Order;
use Drupal\Core\Form\FormStateInterface;
use Drupal\commerce_order\Entity\OrderItem;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

 /**
 * Implements a Memberships Import Form.
 */
class MembershipPayForm extends FormBase {

  /**
   * Stores an entity type manager instance.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Stores the current user.
   *
   * @var \Drupal\user\Entity\User
   */
  protected $currentUser;

  /**
   * Constructs a MenuLinkEditForm object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManager $entity_type_manager
   *   An instance of the entity type manager.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, AccountProxyInterface $current_user) {
    $this->entityTypeManager = $entity_type_manager;
    $this->currentUser = $current_user;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager'),
      $container->get('current_user')
    );
  }

  public function getFormId() {
    return 'membership_pay_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['actions'] = [
      '#type' => 'actions',
    ];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => 'Pagar aquí',
    ];

    return $form;
  }

  /**
   * @param array $form
   * @param FormStateInterface $form_state
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $product_variation = $this->getCurrentProductVariation();

    $order_item = OrderItem::create([
      'type' => 'membership',
      'purchased_entity' => $product_variation->id(),
      'quantity' => 1,
    ]);
    $order_item->save();

    $order = Order::create([
      'type' => 'default',
      'mail' => $this->currentUser->getEmail(),
      'uid' => $this->currentUser->id(),
      'store_id' => 1,
      'order_items' => [$order_item],
      // 'placed' => \Drupal::time()->getCurrentTime(),
      // 'payment_gateway' => 'payu_webcheckout',
      // 'checkout_step' => 'payment',
      'state' => 'draft',
      'cart' => True,
    ]);
    $order->recalculateTotalPrice();
    $order->save();
    $order->set('order_number', $order->id());
    $order->save();

    $form_state->setRedirect('commerce_checkout.form', ['commerce_order' => $order->id()]);
  }

  private function getCurrentProductVariation() {
    $year_current = date('Y');
    $term = $this->entityTypeManager->getStorage('taxonomy_term')->loadByProperties([
      'name' => $year_current,
      'vid' => 'membership_year',
    ]);
    if ($term) {
      $term = reset($term);
      $product = $this->entityTypeManager->getStorage('commerce_product')->loadByProperties([
        'field_year' => $term->id(),
        'type' => 'membership',
      ]);
      if ($product) {
        $product = reset($product);
        return $product->getDefaultVariation();
      }
    }
  }

}
