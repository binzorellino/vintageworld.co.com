<?php

  add_action( 'after_setup_theme', 'woocommerce_support' );
  function woocommerce_support() {
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-lightbox' );
  }

  add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

  add_action( 'wp_enqueue_scripts', 'custom_woocommerce_scripts' );
  function custom_woocommerce_scripts() {
    wp_enqueue_script( TEXTDOMAIN.'-wc-main', THEME_URL . '/modules/woocommerce/assets/js/main.wc.min.js', array(), '', false );
  }

  if ( ! is_admin() ):
    function dequeue_script() {
      wp_dequeue_script( 'select2' );
    }
    add_action( 'wp_print_scripts', 'dequeue_script', 100 );

    add_action( 'wp_enqueue_scripts', 'dequeue_stylesandscripts_select2', 100 );
    function dequeue_stylesandscripts_select2() {
      if ( class_exists( 'woocommerce' ) ) {

        wp_dequeue_style( 'select2' );
        wp_deregister_style( 'select2' );

        wp_dequeue_script( 'select2');
        wp_deregister_script('select2');

      }
    }
  endif;

  add_filter( 'woocommerce_account_menu_items', 'custom_woocommerce_account_menu_items' );
  function custom_woocommerce_account_menu_items( $items ) {
    if ( isset( $items['downloads'] ) ) unset( $items['downloads'] );
    return $items;
  }

  add_filter( 'woocommerce_billing_fields' , 'change_billing_fields' );
  function change_billing_fields( $fields ) {
    $fields['billing_address_1']['class'] = array('form-row-first');
    $fields['billing_address_2']['label'] = '&nbsp;';
    $fields['billing_address_2']['class'] = array('form-row-last');
    unset($fields['billing_state']);
    $fields['billing_email']['class'] = array('form-row-first');
    $fields['billing_email']['priority'] = 20;
    $fields['billing_company']['class'] = array('form-row-first');
    $fields['billing_phone']['class'] = array('form-row-last');
    $fields['billing_phone']['priority'] = 20;
    $fields['billing_city']['class'] = array('form-row-first');
    $fields['billing_postcode']['class'] = array('form-row-last');
    return $fields;
  }

  add_filter( 'woocommerce_shipping_fields' , 'change_shipping_fields' );
  function change_shipping_fields( $fields ) {
    $fields['shipping_address_1']['class'] = array('form-row-first');
    $fields['shipping_address_2']['label'] = '&nbsp;';
    $fields['shipping_address_2']['class'] = array('form-row-last');
    unset($fields['shipping_state']);
    return $fields;
  }

  add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
  function custom_override_checkout_fields( $fields ) {
    $fields['billing']['billing_vatnumber'] = array(
    'label'     =>  __('Tax number', 'vintageworld'),
    'placeholder'   => '',
    'required'  => false,
    'class'     => array('form-row-last'),
    'clear'     => true,
    'priority'  => 30
    );
    $fields['order']['order_comments']['label'] = __( 'Order notes', 'vintageworld' );
    return $fields;
  }

  add_filter('woocommerce_default_address_fields', 'override_address_fields');
  function override_address_fields( $address_fields ) {
    $address_fields['address_1']['placeholder'] = '';
    return $address_fields;
  }

  add_filter('password_change_email', 'wpse207879_change_password_mail_message', 10, 3);
  function wpse207879_change_password_mail_message($pass_change_mail, $user, $userdata) {
    $new_message_txt = __( '<h3>Kedves Felhasználónk!</h3><br/><p>Ezzel az emlékeztetővel is felhívjuk a figyelmét arra, hogy az Vintage World honlapon a jelszavát kérésének megfelelően módosítottuk.</p><p>Amennyiben ezt a módosítást nem szerette volna, kérjük lépjen kapcsolatba a honlap üzemeltetőjével az hello@vintageworld.col.com címen.</p><br/><p>Jelen email címzettje: ###EMAIL###</p><p><strong>Köszönettel:</strong><br/>A Vintage World csapata</p>', 'vintageworld' );
    $pass_change_mail[ 'message' ] = $new_message_txt;
    return $pass_change_mail;
  }

  add_filter( 'woocommerce_formatted_address_force_country_display', '__return_true' );

  /**
   * Hide shipping rates when free shipping is available.
   * Updated to support WooCommerce 2.6 Shipping Zones.
   *
   * @param array $rates Array of rates found for the package.
   * @return array
   */
  function my_hide_shipping_when_free_is_available( $rates ) {
    $free = array();
    foreach ( $rates as $rate_id => $rate ) {
      if ( 'free_shipping' === $rate->method_id ) {
        $free[ $rate_id ] = $rate;
        break;
      }
    }
    return ! empty( $free ) ? $free : $rates;
  }
  add_filter( 'woocommerce_package_rates', 'my_hide_shipping_when_free_is_available', 100 );

  function free_shipping_cart_notice() {

    global $woocommerce;

    if ( ! is_cart() && ! is_checkout() ) {
      return;
    }

    if( WC()->cart->get_shipping_total() <= 0 ) {
      return;
    }

    $default_zone = new WC_Shipping_Zone(0);
    $default_methods = $default_zone->get_shipping_methods();

    foreach( $default_methods as $key => $value ) {
      if ( $value->id === "free_shipping" ) {
        if ( $value->min_amount > 0 ) $min_amounts[] = $value->min_amount;
      }
    }

    $delivery_zones = WC_Shipping_Zones::get_zones();

    foreach ( $delivery_zones as $key => $delivery_zone ) {
      foreach ( $delivery_zone['shipping_methods'] as $key => $value ) {
        if ( $value->id === "free_shipping" ) {
          if ( $value->min_amount > 0 ) $min_amounts[] = $value->min_amount;
        }
      }
    }

    if ( is_array($min_amounts) ) {

      $min_amount = min($min_amounts);
      $current = WC()->cart->subtotal;

      if ( $current < $min_amount ) {
        $text = '<p class="free-shipping-notice">'. sprintf( __( 'Purchase another %s FOR FREE SHIPPING!', 'vintageworld' ), wc_price( $min_amount - $current ) ) .'</p>';
        return $text;
      }

    }

  }

  require( 'login.php' );
  require( 'registration.php' );

?>
