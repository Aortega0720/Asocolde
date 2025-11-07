<?php

namespace Drupal\commerce_payu_webcheckout;

use Drupal\commerce_order\Entity\OrderInterface;
use Drupal\commerce_payment\Entity\PaymentGatewayInterface;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * A class to act on related entity events.
 */
final class EntityOperations implements ContainerInjectionInterface {

  /**
   * The Hash entity storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  private $hashStorage;

  /**
   * Builds a new EntityOperations object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->hashStorage = $entity_type_manager->getStorage('payu_hash');
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * Act on a Commerce Order delete action.
   *
   * Removes all hashes associated to an order.
   *
   * @param \Drupal\commerce_order\Entity\OrderInterface $order
   *   The Order object being deleted.
   */
  public function onOrderDelete(OrderInterface $order) {
    $hashes = $this->hashStorage->loadByProperties([
      'commerce_order' => $order->id(),
    ]);
    $this->hashStorage->delete($hashes);
  }

  /**
   * Act on a Commerce Gateway delete action.
   *
   * Removes all hashes associated to a gateway.
   *
   * @param \Drupal\commerce_payment\Entity\PaymentGatewayInterface $gateway
   *   The gateway object being deleted.
   */
  public function onGatewayDelete(PaymentGatewayInterface $gateway) {
    $hashes = $this->hashStorage->loadByProperties([
      'commerce_payment_gateway' => $gateway->id(),
    ]);
    $this->hashStorage->delete($hashes);
  }

}
