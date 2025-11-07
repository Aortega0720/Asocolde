<?php

namespace Drupal\commerce_payu_colombia\Plugin\Commerce\PaymentGateway;

use Drupal\commerce_payment\CreditCard;
use Drupal\commerce_payment\Entity\PaymentInterface;
use Drupal\commerce_payment\Entity\PaymentMethodInterface;
use Drupal\commerce_payment\Exception\HardDeclineException;
use Drupal\commerce_payment\PaymentMethodTypeManager;
use Drupal\commerce_payment\PaymentTypeManager;
use Drupal\commerce_payment\Plugin\Commerce\PaymentGateway\OnsitePaymentGatewayBase;
use Drupal\commerce_price\MinorUnitsConverterInterface;
use Drupal\commerce_price\Price;
use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides the PayU Colombia On-site payment gateway.
 *
 * @CommercePaymentGateway(
 *   id = "commerce_payu_colombia_onsite",
 *   label = "Commerce PayU Latam Colombia (On-site)",
 *   display_label = "Commerce PayU Latam Colombia (On-site)",
 *   forms = {
 *     "add-payment-method" = "Drupal\commerce_payu_colombia\PluginForm\Onsite\PaymentMethodAddForm",
 *     "edit-payment-method" = "Drupal\commerce_payment\PluginForm\PaymentMethodEditForm",
 *   },
 *   payment_method_types = {"credit_card"},
 *   credit_card_types = {
 *     "amex", "dinersclub", "discover", "jcb", "maestro", "mastercard", "visa",
 *   },
 *   requires_billing_information = FALSE,
 * )
 */
class Onsite extends OnsitePaymentGatewayBase implements OnsiteInterface {

  const API_KEY_TEST = '4Vj8eK4rloUd272L48hsrarnUA';
  const API_LOGIN_TEST = 'pRRXKOl8ikMmt9u';
  const MERCHANT_ID_TEST = '508029';
  const ACCOUNT_ID_TEST = '512321';
  const ENDPOINT_TEST = 'https://sandbox.api.payulatam.com/payments-api/4.0/service.cgi';
  const ENDPOINT_PROD = 'https://api.payulatam.com/payments-api/4.0/service.cgi';

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager, PaymentTypeManager $payment_type_manager, PaymentMethodTypeManager $payment_method_type_manager, TimeInterface $time, MinorUnitsConverterInterface $minor_units_converter) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $entity_type_manager, $payment_type_manager, $payment_method_type_manager, $time, $minor_units_converter);

    // You can create an instance of the SDK here and assign it to $this->api.
    // Or inject Guzzle when there's no suitable SDK.
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'account_id' => self::ACCOUNT_ID_TEST,
      'api_key' => self::API_KEY_TEST,
      'api_login' => self::API_LOGIN_TEST,
      'merchant_id' => self::MERCHANT_ID_TEST,
      'endpoint_prod' => self::ENDPOINT_TEST,
      'endpoint_test' => self::ENDPOINT_PROD,
    ] + parent::defaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildConfigurationForm($form, $form_state);

    $form['api_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('API key'),
      '#description' => $this->t('Your API Key provided by PayU.'),
      '#default_value' => $this->configuration['api_key'],
      '#required' => TRUE,
    ];
    $form['api_login'] = [
      '#type' => 'textfield',
      '#title' => $this->t('API Login'),
      '#description' => $this->t('Your API Login provided by PayU.'),
      '#default_value' => $this->configuration['api_login'],
      '#required' => TRUE,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    parent::submitConfigurationForm($form, $form_state);

    if (!$form_state->getErrors()) {
      $values = $form_state->getValue($form['#parents']);
      $this->configuration['api_key'] = $values['api_key'];
      $this->configuration['api_login'] = $values['api_login'];
    }
  }

  /**
   * {@inheritdoc}
   */
  public function createPayment(PaymentInterface $payment, $capture = TRUE) {
    $this->assertPaymentState($payment, ['new']);
    $payment_method = $payment->getPaymentMethod();
    $this->assertPaymentMethod($payment_method);

    $amount = $payment->getAmount();
    $currency_code = $payment->getAmount()->getCurrencyCode();

    $order = $payment->getOrder();

    $customer = $order->getCustomer();
    $billing_profile = $order->getBillingProfile();

    $data =  [
      "language" => "es",
      "command" => "SUBMIT_TRANSACTION",
      "merchant" => [
        "apiKey" => $this->configuration['api_key'],
        "apiLogin" => $this->configuration['api_login'],
      ],
      "transaction" => [
        "order" => [
          "accountId" => $this->configuration['account_id'],
          "referenceCode" => $this->getPayUReference($payment),
          "description" =>$this->t('Purchase from @sitename', [
            '@sitename' => '[site:name]',
          ]),
          "language" => "es",
          "signature" => $this->getPayUSignature($payment),
          "notifyUrl" => "https://new.asocolderma.org.co/notify",
          "additionalValues" => [
            "TX_VALUE" => [
              "value" => $ammount,
              "currency" => $currency_code,
            ],
            "TX_TAX" => [
              "value" => 0,
              "currency" => $currency_code,
            ],
            "TX_TAX_RETURN_BASE" => [
              "value" => 0,
              "currency" => $currency_code,
            ]
          ],
          "buyer" => [
            "merchantBuyerId" => $order->getCustomerId(),
            "fullName" => "First name and second buyer name",
            "emailAddress" => "buyer_test@test.com",
            "contactPhone" => "7563126",
            "dniNumber" => "123456789",
            "shippingAddress" => [
              "street1" => "Cr 23 No. 53-50",
              "street2" => "5555487",
              "city" => "Bogotá",
              "state" => "Bogotá D.C.",
              "country" => "CO",
              "postalCode" => "000000",
              "phone" => "7563126"
            ]
          ],
        ],
        "payer" => [
            "merchantPayerId" => "1",
            "fullName" => "First name and second payer name",
            "emailAddress" => "payer_test@test.com",
            "contactPhone" => "7563126",
            "dniNumber" => "5415668464654",
            "billingAddress" => [
                "street1" => "Cr 23 No. 53-50",
                "street2" => "125544",
                "city" => "Bogotá",
                "state" => "Bogotá D.C.",
                "country" => "CO",
                "postalCode" => "000000",
                "phone" => "7563126"
            ]
          ],
        "creditCard" => [
          "number" => "4037997623271984",
          "securityCode" => "321",
          "expirationDate" => "2030/12",
          "name" => "APPROVED"
        ],
        "extraParameters" => [
          "INSTALLMENTS_NUMBER" => 1
        ],
        "type" => "AUTHORIZATION_AND_CAPTURE",
        "paymentMethod" => "VISA",
        "paymentCountry" => "CO",
        "deviceSessionId" => md5(session_id().microtime()),
        "ipAddress" => $order->getIpAddress(),
        "cookie" => "pt1t38347bs6jc9ruv2ecpv7o2",
        "userAgent" => "Mozilla/5.0 (Windows NT 5.1; rv:18.0) Gecko/20100101 Firefox/18.0",
        "threeDomainSecure" => [
          "embedded" => false,
          "eci" => "01",
          "cavv" => "AOvG5rV058/iAAWhssPUAAADFA==",
          "xid" => "Nmp3VFdWMlEwZ05pWGN3SGo4TDA=",
          "directoryServerTransactionId" => "00000-70000b-5cc9-0000-000000000cb"
        ],
      ],
      "test" => true,
   ];

   dpm($data);

   $client = \Drupal::httpClient();
   $url = $this->getMode() == 'test' ? $this->configuration['endpoint_test'] : $this->configuration['endpoint_prod'];
   try {
    $response = $this->httpClient->post($url, [
      'body' => $data,
      'headers' => [
        'Content-type' => 'application/json',
        'Accept' => 'application/json'
      ],
    ]);
    dpm($response->getBody()->getContents());
    // $response_data = json_decode($response->getBody()->getContents(), TRUE);

    // do something with data
  }
  catch (RequestException $e) {
    // log exception
  }


    $next_state = $capture ? 'completed' : 'authorization';

    $payment->setState($next_state);
    $payment->setRemoteId($remote_id);

    $payment->save();
  }

  /**
   * {@inheritdoc}
   */
  public function capturePayment(PaymentInterface $payment, Price $amount = NULL) {
    $this->assertPaymentState($payment, ['authorization']);
    // If not specified, capture the entire amount.
    $amount = $amount ?: $payment->getAmount();

    // Perform the capture request here, throw an exception if it fails.
    // See \Drupal\commerce_payment\Exception for the available exceptions.
    $remote_id = $payment->getRemoteId();
    $number = $amount->getNumber();

    $payment->setState('completed');
    $payment->setAmount($amount);
    $payment->save();
  }

  /**
   * {@inheritdoc}
   */
  public function voidPayment(PaymentInterface $payment) {
    $this->assertPaymentState($payment, ['authorization']);
    // Perform the void request here, throw an exception if it fails.
    // See \Drupal\commerce_payment\Exception for the available exceptions.
    $remote_id = $payment->getRemoteId();

    $payment->setState('authorization_voided');
    $payment->save();
  }

  /**
   * {@inheritdoc}
   */
  public function refundPayment(PaymentInterface $payment, Price $amount = NULL) {
    $this->assertPaymentState($payment, ['completed', 'partially_refunded']);
    // If not specified, refund the entire amount.
    $amount = $amount ?: $payment->getAmount();
    $this->assertRefundAmount($payment, $amount);

    // Perform the refund request here, throw an exception if it fails.
    // See \Drupal\commerce_payment\Exception for the available exceptions.
    $remote_id = $payment->getRemoteId();
    $number = $amount->getNumber();

    $old_refunded_amount = $payment->getRefundedAmount();
    $new_refunded_amount = $old_refunded_amount->add($amount);
    if ($new_refunded_amount->lessThan($payment->getAmount())) {
      $payment->setState('partially_refunded');
    }
    else {
      $payment->setState('refunded');
    }

    $payment->setRefundedAmount($new_refunded_amount);
    $payment->save();
  }

  /**
   * {@inheritdoc}
   */
  public function createPaymentMethod(PaymentMethodInterface $payment_method, array $payment_details) {
    $required_keys = [
      'type', 'number', 'expiration',
    ];
    foreach ($required_keys as $required_key) {
      if (empty($payment_details[$required_key])) {
        throw new \InvalidArgumentException(sprintf('$payment_details must contain the %s key.', $required_key));
      }
    }
    // Add a built in test for testing decline exceptions.
    // Note: Since requires_billing_information is FALSE, the payment method
    // is not guaranteed to have a billing profile. Confirm tha
    // $payment_method->getBillingProfile() is not NULL before trying to use it.
    if ($billing_profile = $payment_method->getBillingProfile()) {
      /** @var \Drupal\address\Plugin\Field\FieldType\AddressItem $billing_address */
      $billing_address = $billing_profile->get('address')->first();
      if ($billing_address->getPostalCode() == '53141') {
        throw new HardDeclineException('The payment method was declined');
      }
    }

    // If the remote API needs a remote customer to be created.
    $owner = $payment_method->getOwner();
    if ($owner && !$owner->isAnonymous()) {
      $customer_id = $this->getRemoteCustomerId($owner);
      // If $customer_id is empty, create the customer remotely and then do
      // $this->setRemoteCustomerId($owner, $customer_id);
      // $owner->save();
    }

    // Perform the create request here, throw an exception if it fails.
    // See \Drupal\commerce_payment\Exception for the available exceptions.
    // You might need to do different API requests based on whether the
    // payment method is reusable: $payment_method->isReusable().
    // Non-reusable payment methods usually have an expiration timestamp.
    $payment_method->card_type = $payment_details['type'];
    // Only the last 4 numbers are safe to store.
    $payment_method->card_number = substr($payment_details['number'], -4);
    $payment_method->card_exp_month = $payment_details['expiration']['month'];
    $payment_method->card_exp_year = $payment_details['expiration']['year'];
    $expires = CreditCard::calculateExpirationTimestamp($payment_details['expiration']['month'], $payment_details['expiration']['year']);
    // The remote ID returned by the request.
    $remote_id = '789';

    $payment_method->setRemoteId($remote_id);
    $payment_method->setExpiresTime($expires);
    $payment_method->save();
  }

  /**
   * {@inheritdoc}
   */
  public function deletePaymentMethod(PaymentMethodInterface $payment_method) {
    // Delete the remote record here, throw an exception if it fails.
    // See \Drupal\commerce_payment\Exception for the available exceptions.
    // Delete the local entity.
    $payment_method->delete();
  }

  /**
   * {@inheritdoc}
   */
  public function updatePaymentMethod(PaymentMethodInterface $payment_method) {
    // Note: Since requires_billing_information is FALSE, the payment method
    // is not guaranteed to have a billing profile. Confirm that
    // $payment_method->getBillingProfile() is not NULL before trying to use it.
    //
    // Perform the update request here, throw an exception if it fails.
    // See \Drupal\commerce_payment\Exception for the available exceptions.
  }

  /**
   * {@inheritdoc}
   */
  public function buildAvsResponseCodeLabel($avs_response_code, $card_type) {
    if ($card_type == 'dinersclub' || $card_type == 'jcb') {
      if ($avs_response_code == 'A') {
        return $this->t('Approved.');
      }
      return NULL;
    }
    return parent::buildAvsResponseCodeLabel($avs_response_code, $card_type);
  }

  private function getPayUSignature($payment) {
    return md5($this->getPayUReference($payment));
  }

  private function getPayUReference($payment) {
    $amount = $payment->getAmount();
    $currency = $payment->getAmount()->getCurrencyCode();
    $reference = "Compra Asocolderma {$payment->getOrderId()} - {$payment->id()}";
    return "{$this->configuration['api_key']}~{$this->configuration['merchant_id']}~{$reference}~{$amount}~{$currency}";
  }

}
