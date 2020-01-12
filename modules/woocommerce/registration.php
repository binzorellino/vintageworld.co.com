<?php

  function input($id, $label, $position, $req, $class = NULL, $type = 'text') {

    if ($req) {
      $required = ' required="required"';
      $required_class = ' validate-required';
      $required_label = ' <abbr class="required" title="kötelező">*</abbr>';
    } else {
      $required = '';
      $required_class = '';
      $required_label = '';
    }

    if ( ! empty( $_POST[$id] ) ) { $v = esc_attr( $_POST[$id] ); } else { $v = ''; }

    echo '
    <p id="' . $id . '_field" class="form-row form-row-' . $position . $required_class . '">
      <label  class="" for="' . $id . '"> ' . $label . $required_label . '</label>
      <input type="' . $type . '" class="input-text " name="' . $id . '" id="'. $id .'" value="' . $v . '">
    </p>';
  }

  function input2($id, $label, $position, $req, $class = NULL, $type = 'text') {

    if ($req) {
      $required_label = ' <abbr class="required" title="required">*</abbr>';
    } else {
      $required_label = '';
    }

    if ( ! empty( $_POST[$id] ) ) { $v = esc_attr( $_POST[$id] ); } else { $v = ''; }

    echo '
    <p id="' . $id . '_field" class="form-row form-row-' . $position . '">
      <label  class="" for="' . $id . '"> ' . $label . $required_label . '</label>
      <input type="' . $type . '" class="input-text " name="' . $id . '" id="'. $id .'" value="' . $v . '">
    </p>';
  }

  function validate_password($reg_errors, $sanitized_user_login, $user_email) {

    global $woocommerce;

    extract( $_POST );

    if( strcmp( $password, $password2 ) !== 0 ) {
      return new WP_Error( 'registration-error', __( 'The passwords you entered do not match', TEXTDOMAIN ) );
    }

    return $reg_errors;

  }
  add_filter( 'woocommerce_registration_errors', 'validate_password', 10, 3 );


  function validate_extra_register_fields( $errors ) {

    if( isset( $_POST['billing_last_name'] ) && empty( $_POST['billing_last_name'] ) ) {
      $errors->add( 'billing_last_name_error', __( 'Last name is a required field.', TEXTDOMAIN ) );
    }

    if( isset( $_POST['billing_first_name'] ) && empty( $_POST['billing_first_name'] ) ) {
      $errors->add( 'billing_first_name_error', __( 'First name is a required field.', TEXTDOMAIN ) );
    }

    if( isset( $_POST['password'] ) && empty( $_POST['password'] ) ) {
      $errors->add( 'password_error', __( 'Password is required.', TEXTDOMAIN ) );
    }

    if ( isset( $_POST['billing_country'] ) && empty( $_POST['billing_country'] ) ) {
      $errors->add( 'billing_country_error', __( 'Country is a required field.', TEXTDOMAIN ) );
    }

    if ( isset( $_POST['billing_city'] ) && empty( $_POST['billing_city'] ) ) {
      $errors->add( 'billing_city_error', __( 'Town / City is a required field.', TEXTDOMAIN ) );
    }

    if ( isset( $_POST['billing_address_1'] ) && empty( $_POST['billing_address_1'] ) ) {
      $errors->add( 'billing_address_1_error', __( 'Street address is a required field.', TEXTDOMAIN ) );
    }

    if ( isset( $_POST['billing_postcode'] ) && empty( $_POST['billing_postcode'] ) ) {
      $errors->add( 'billing_postcode_error', __( 'Postcode / ZIP is a required field.', TEXTDOMAIN ) );
    }

    if ( isset( $_POST['billing_phone'] ) && empty( $_POST['billing_phone'] ) ) {
      $errors->add( 'billing_phone_error', __( 'Phone is a required field.', TEXTDOMAIN ) );
    }

    if ( isset( $_POST['ship_to_different_address'] ) ) {

      if ( isset( $_POST['shipping_first_name'] ) && empty( $_POST['shipping_first_name'] ) ) {
        $errors->add( 'shipping_first_name_error', __( 'Shipping address: First name is a required field.', TEXTDOMAIN ) );
      }

      if ( isset( $_POST['shipping_last_name'] ) && empty( $_POST['shipping_last_name'] ) ) {
        $errors->add( 'shipping_last_name_error', __( 'Shipping address: Last name is a required field.', TEXTDOMAIN ) );
      }

      if ( isset( $_POST['shipping_country'] ) && empty( $_POST['shipping_country'] ) ) {
        $errors->add( 'shipping_country_error', __( 'Shipping address: Country is a required field.', TEXTDOMAIN ) );
      }

      if ( isset( $_POST['shipping_city'] ) && empty( $_POST['shipping_city'] ) ) {
        $errors->add( 'shipping_city_error', __( 'Shipping address: Town / City is a required field.', TEXTDOMAIN ) );
      }

      if ( isset( $_POST['shipping_address_1'] ) && empty( $_POST['shipping_address_1'] ) ) {
        $errors->add( 'shipping_address_1_error', __( 'Shipping address: Street address is a required field.', TEXTDOMAIN ) );
      }

      if ( isset( $_POST['shipping_postcode'] ) && empty( $_POST['shipping_postcode'] ) ) {
        $errors->add( 'shipping_postcode_error', __( 'Shipping address: Postcode / ZIP is a required field.', TEXTDOMAIN ) );
      }

    }

    if( !isset( $_POST['terms'] ) ) {
      $errors->add( 'terms_error', __( 'Legal documents must be accepted', TEXTDOMAIN ) );
    }

    return $errors;

  }
  add_action( 'woocommerce_process_registration_errors', 'validate_extra_register_fields', 10, 3 );


  add_action( 'woocommerce_created_customer', 'wooc_save_extra_register_fields' );
  function wooc_save_extra_register_fields( $customer_id ) {

    if ( isset( $_POST['billing_first_name'] ) ) {
      update_user_meta( $customer_id, 'first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
      update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
    }
    if ( isset( $_POST['billing_last_name'] ) ) {
      update_user_meta( $customer_id, 'last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
      update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
    }

    // BILLING INFORMATION
    if ( isset( $_POST['billing_country'] ) ) {
      update_user_meta( $customer_id, 'billing_country', sanitize_text_field( $_POST['billing_country'] ) );
    }
    if ( isset( $_POST['billing_company'] ) ) {
      update_user_meta( $customer_id, 'billing_company', sanitize_text_field( $_POST['billing_company'] ) );
    }
    if ( isset( $_POST['billing_vatnumber'] ) ) {
      update_user_meta( $customer_id, 'billing_vatnumber', sanitize_text_field( $_POST['billing_vatnumber'] ) );
    }
    if ( isset( $_POST['billing_address_1'] ) ) {
      update_user_meta( $customer_id, 'billing_address_1', sanitize_text_field( $_POST['billing_address_1'] ) );
    }
    if ( isset( $_POST['billing_address_2'] ) ) {
      update_user_meta( $customer_id, 'billing_address_2', sanitize_text_field( $_POST['billing_address_2'] ) );
    }
    if ( isset( $_POST['billing_country'] ) ) {
      update_user_meta( $customer_id, 'billing_country', sanitize_text_field( $_POST['billing_country'] ) );
    }
    if ( isset( $_POST['billing_city'] ) ) {
      update_user_meta( $customer_id, 'billing_city', sanitize_text_field( $_POST['billing_city'] ) );
    }
    if ( isset( $_POST['billing_state'] ) ) {
      update_user_meta( $customer_id, 'billing_state', sanitize_text_field( $_POST['billing_state'] ) );
    }
    if ( isset( $_POST['billing_postcode'] ) ) {
      update_user_meta( $customer_id, 'billing_postcode', sanitize_text_field( $_POST['billing_postcode'] ) );
    }
    if ( isset( $_POST['email'] ) ) {
      update_user_meta( $customer_id, 'billing_email', sanitize_text_field( $_POST['email'] ) );
    }
    if ( isset( $_POST['billing_phone'] ) ) {
      update_user_meta( $customer_id, 'billing_phone', sanitize_text_field( $_POST['billing_phone'] ) );
    }

    // SHIPPING INFORMATION
    if ( isset( $_POST['ship_to_different_address'] ) ) {

      if ( isset( $_POST['shipping_country'] ) ) {
        update_user_meta( $customer_id, 'shipping_country', sanitize_text_field( $_POST['shipping_country'] ) );
      }
      if ( isset( $_POST['shipping_first_name'] ) ) {
        update_user_meta( $customer_id, 'shipping_first_name', sanitize_text_field( $_POST['shipping_first_name'] ) );
      }
      if ( isset( $_POST['shipping_last_name'] ) ) {
        update_user_meta( $customer_id, 'shipping_last_name', sanitize_text_field( $_POST['shipping_last_name'] ) );
      }
      if ( isset( $_POST['shipping_company'] ) ) {
        update_user_meta( $customer_id, 'shipping_company', sanitize_text_field( $_POST['shipping_company'] ) );
      }
      if ( isset( $_POST['shipping_country'] ) ) {
        update_user_meta( $customer_id, 'shipping_country', sanitize_text_field( $_POST['shipping_country'] ) );
      }
      if ( isset( $_POST['shipping_address_1'] ) ) {
        update_user_meta( $customer_id, 'shipping_address_1', sanitize_text_field( $_POST['shipping_address_1'] ) );
      }
      if ( isset( $_POST['shipping_address_2'] ) ) {
        update_user_meta( $customer_id, 'shipping_address_2', sanitize_text_field( $_POST['shipping_address_2'] ) );
      }
      if ( isset( $_POST['shipping_city'] ) ) {
        update_user_meta( $customer_id, 'shipping_city', sanitize_text_field( $_POST['shipping_city'] ) );
      }
      if ( isset( $_POST['shipping_state'] ) ) {
        update_user_meta( $customer_id, 'shipping_state', sanitize_text_field( $_POST['shipping_state'] ) );
      }
      if ( isset( $_POST['shipping_postcode'] ) ) {
        update_user_meta( $customer_id, 'shipping_postcode', sanitize_text_field( $_POST['shipping_postcode'] ) );
      }

    } else {

      if ( isset( $_POST['billing_country'] ) ) {
        update_user_meta( $customer_id, 'shipping_country', sanitize_text_field( $_POST['billing_country'] ) );
      }
      if ( isset( $_POST['billing_first_name'] ) ) {
        update_user_meta( $customer_id, 'shipping_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
      }
      if ( isset( $_POST['billing_last_name'] ) ) {
        update_user_meta( $customer_id, 'shipping_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
      }
      if ( isset( $_POST['billing_company'] ) ) {
        update_user_meta( $customer_id, 'shipping_company', sanitize_text_field( $_POST['billing_company'] ) );
      }
      if ( isset( $_POST['billing_country'] ) ) {
        update_user_meta( $customer_id, 'shipping_country', sanitize_text_field( $_POST['billing_country'] ) );
      }
      if ( isset( $_POST['billing_address_1'] ) ) {
        update_user_meta( $customer_id, 'shipping_address_1', sanitize_text_field( $_POST['billing_address_1'] ) );
      }
      if ( isset( $_POST['billing_address_2'] ) ) {
        update_user_meta( $customer_id, 'shipping_address_2', sanitize_text_field( $_POST['billing_address_2'] ) );
      }
      if ( isset( $_POST['billing_city'] ) ) {
        update_user_meta( $customer_id, 'shipping_city', sanitize_text_field( $_POST['billing_city'] ) );
      }
      if ( isset( $_POST['billing_state'] ) ) {
        update_user_meta( $customer_id, 'shipping_state', sanitize_text_field( $_POST['billing_state'] ) );
      }
      if ( isset( $_POST['billing_postcode'] ) ) {
        update_user_meta( $customer_id, 'shipping_postcode', sanitize_text_field( $_POST['billing_postcode'] ) );
      }

    }

  }


  add_filter('woocommerce_registration_redirect', 'wc_registration_redirect');
  function wc_registration_redirect( $redirect_to ) {
    $redirect_to = get_permalink( icl_object_id( 228, 'page', false ) );
    return $redirect_to;
  }
