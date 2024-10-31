<?php 

/**
* Shortcodes
*
* @package    Quaderno
* @copyright  Copyright (c) 2015, Quaderno
* @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
* @since      1.0.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

function quaderno_checkout_shortcode( $attr, $content = null ) {
  extract(shortcode_atts(array(
  'type' => 'charge',
  'gateway' => 'stripe',
  'amount' => 500,
  'currency' => 'USD',
  'plan' => '',
  'item_code' => '',
  'transaction_type' => 'eservice',
  'taxes' => 'excluded',
  'description' => 'Checkout',
  'label' => 'Pay Now',
  'panel_label' => 'Pay {{amount}}',
  'color' => '#4C7800',
  'locale' => 'en',
  'country' => '',
  'customer_type' => 'both',
  'coupon' => '',
  'billing_address' => false,
  'subscription_duration' => 1,
  'subscription_unit' => 'M',
  'recurring_duration' => '',
  'trial_price' => '',
  'trial_duration' => '',
  'trial_unit' => 'M',
  'redirect_url' => '',
  'style' => ''
  ), $attr));

  if ( ! empty ( $item_code ) ) {
    $transaction_info = 'data-item-code="' . $item_code . '"';
  } else if ( $type == 'charge' ) {
    $token = array(
      'iat' => time(),
      'amount' => $amount,
      'currency' => $currency,
      'description' => $description,
      'taxes' => $taxes,
      'transaction_type' => $transaction_type
    );

    $transaction_info = 'data-charge="' . JWT::encode($token, get_option('quaderno_private_key')) . '"';    
  } else if ( $type == 'subscription' && $gateway == 'paypal' ) {
    $token = array(
      'iat' => time(),
      'amount' => $amount,
      'currency' => $currency,
      'description' => $description,
      'subscription_unit' => $subscription_unit,
      'subscription_duration' => $subscription_duration,
      'recurring_duration' => $recurring_duration,
      'a1' => $trial_price,
      'p1' => $trial_duration,
      't1' => $trial_unit
    );

    $transaction_info = 'data-charge="' . JWT::encode($token, get_option('quaderno_private_key')) . '"';
  }else {
    $transaction_info = 'data-plan="' . $plan . '"';    
  }

  $html = '<form action="' . $redirect_url . '" method="POST">
    <script
    data-cfasync="false" src="https://checkout.quaderno.io/checkout.js" class="quaderno-button"
    data-key="' . get_option('quaderno_public_key') . '"
    data-type="' . $type . '"
    data-gateway="' . $gateway . '"
    data-description="' . $description . '"
    data-amount="' . $amount . '"
    data-currency="' . $currency . '"
    data-transaction-type="' . $transaction_type . '"
    data-taxes="' . $taxes . '"
    data-label="' . $label . '"
    data-panel-label="'. $panel_label . '"
    data-color="' . $color . '"
    data-locale="' . $locale . '"
    data-country="' . $country . '"
    data-coupon="' . $coupon . '"
    data-customer-type="' . $customer_type . '"
    data-billing-address="' . $billing_address . '" ' . $transaction_info . '></script>
  </form>';

  if ( ! empty($style) ) {
    $html .= '<style>.quaderno-button-el { ' . $style . ' }</style>';
  }

  return $html;
}
add_shortcode('quaderno', 'quaderno_checkout_shortcode');
