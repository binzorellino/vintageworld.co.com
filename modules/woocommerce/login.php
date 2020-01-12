<?php

  // BEJELENTKEZÉS
  function ajax_login_init() {
    wp_register_script('ajax-login-script', THEME_URL . '/includes/woocommerce/assets/js/ajax-login-script.min.js',  array('jquery'), '', false );
    wp_enqueue_script('ajax-login-script');
    wp_localize_script( 'ajax-login-script', 'ajax_login_object', array(
      'ajaxurl' => admin_url( 'admin-ajax.php' ),
      'redirecturl' => 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],
      'loadingmessage' => __('Sign in ...', 'vintageworld')
    ));
    add_action( 'wp_ajax_nopriv_ajaxlogin', 'ajax_login');
  }

  if (!is_user_logged_in()) {
    add_action('init', 'ajax_login_init');
    function ajax_login(){
      check_ajax_referer( 'ajax-login-nonce', 'security' );
      $info = array();
      $info['user_login'] = $_POST['username'];
      $info['user_password'] = $_POST['password'];
      $info['remember'] = $_POST['rememberme'];
      $user_signon = wp_signon( $info, false );
      if ( is_wp_error($user_signon) == true) {
        echo json_encode(array('loggedin'=>false, 'message'=> __('Incorrect login! Please try again!', 'vintageworld')));
      } else {
        echo json_encode(array('loggedin'=>true, 'message'=> __('Login successful!', 'vintageworld')));
      }
      die();
    }
  }

  function my_front_end_login_fail( $username ) {
    $referrer = $_SERVER['HTTP_REFERER'];
    if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {
      wp_redirect( $referrer . '?login=failed' );
      exit;
    }
  }
