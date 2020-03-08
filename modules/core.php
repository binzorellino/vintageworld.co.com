<?php

  add_filter( 'script_loader_src', 'remove_script_version', 15, 1 );
  add_filter( 'style_loader_src', 'remove_script_version', 15, 1 );
  function remove_script_version( $src ) {
    return remove_query_arg( 'ver', $src );
  }

  add_image_size( 'content-thumb', 1000 );
  add_image_size( 'optimized', 1920, 1080 );

  function custom_thumb_sizes( $sizes ) {
    return array_merge( $sizes, array(
      'content-thumb' => __( 'Tartalomba szánt méret' ),
      'base-thumb'    => __( 'Bélyegkép méret' )
    ) );
  }
  add_filter( 'image_size_names_choose', 'custom_thumb_sizes' );

  function replace_uploaded_image($image_data) {
    if (!isset($image_data['sizes']['optimized'])) return $image_data;
    $upload_dir = wp_upload_dir();
    $uploaded_image_location = $upload_dir['basedir'] . '/' .$image_data['file'];
    $large_image_location = $upload_dir['path'] . '/'.$image_data['sizes']['optimized']['file'];
    unlink($uploaded_image_location);
    rename($large_image_location,$uploaded_image_location);
    $image_data['width'] = $image_data['sizes']['optimized']['width'];
    $image_data['height'] = $image_data['sizes']['optimized']['height'];
    unset($image_data['sizes']['optimized']);
    return $image_data;
  }
  add_filter('wp_generate_attachment_metadata','replace_uploaded_image');

  add_action('after_setup_theme', 'attachment_default_settings');
  function attachment_default_settings() {
    update_option('image_default_align', 'none' );
    update_option('image_default_link_type', 'none' );
    update_option('image_default_size', 'content-thumb' );
  }

  if( is_admin() ) {
    // Adminisztrációs felületen kicseréli az alapértelmezett WP szöveget a fejlesztő nevére és annak URL címére
    if ( ! empty( DEVELOPER_NAME ) ) {
      add_filter( 'admin_footer_text', 'add_developer_to_admin_footer' );
      function add_developer_to_admin_footer() {
        echo '&copy; ' . date('Y') . ' <a href=" ' . DEVELOPER_URL . ' " target="_blank">' . DEVELOPER_NAME . '</a>';
      }
    }

    // Ha a belépett felhasználó jögköre nem adminisztrátor, elrejtjük a WP verzió számát előle
    add_action( 'admin_menu', 'clear_admin_dashboard_footer_right' );
    function clear_admin_dashboard_footer_right() {
      if ( ! current_user_can( 'administrator' ) ) {
        remove_filter( 'update_footer', 'core_update_footer' );
      }
    }

    // Súgó fül eltüntetése az adminisztrációs felületről
    add_action('admin_head', 'remove_help_tabs');
    function remove_help_tabs() {
      $screen = get_current_screen();
      $screen->remove_help_tabs();
    }

    // A WP logó, keresés és testreszabás menüpontok elrejtése az admin bár-ról
    add_action( 'wp_before_admin_bar_render', 'admin_bar_remove', 999 );
    function admin_bar_remove() {
      global $wp_admin_bar;
      $wp_admin_bar->remove_menu( 'wp-logo' );
      $wp_admin_bar->remove_menu( 'customize' );
      $wp_admin_bar->remove_menu( 'search' );
    }

    add_action( 'admin_bar_menu', function ( $wp_admin_bar ) {
      if ( ! is_admin() ) { return; }
      $wp_admin_bar->remove_node( 'view-site' );
    }, 31 );

    add_action('admin_footer','customize_posts_status_color');
    function customize_posts_status_color(){
    ?>
      <style>
      .status-draft{background: #FCE3F2!important;}
      .status-pending{background: #87C5D6!important;}
      .status-publish{}
      .status-future{background: #C6EBF5!important;}
      .status-private{background:#F2D46F;}
      </style>
    <?php
    }

    add_filter( 'body_class', 'add_slug_body_class' );
    function add_slug_body_class( $classes ) {
      global $post;
      if ( isset( $post ) ) {
        $classes[] = $post->post_type . '-' . $post->post_name;
      }
      return $classes;
    }

    add_filter( 'sanitize_file_name', 'sanitize_chars_in_filename', 10 );
    function sanitize_chars_in_filename( $filename ) {
      return remove_accents( $filename );
    }

  }

  add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
  function custom_excerpt_length( $length ) {
    return EXCERPT_LENGTH;
  }

  add_filter('excerpt_more', 'change_excerpt_more');
  function change_excerpt_more( $more ) {
    return '...';
  }

  add_filter('the_content', 'filter_ptags_on_images');
  function filter_ptags_on_images($content){
    return preg_replace('/<p>(\s*)(<img .* \/>)(\s*)<\/p>/iU', '\2', $content);
  }

  if ( DISABLE_COMMENTS === TRUE ) {

    function disable_comments_post_types_support() {
      $post_types = get_post_types();
      foreach ( $post_types as $post_type ) {
        if ( post_type_supports( $post_type, 'comments' ) ) {
          remove_post_type_support( $post_type, 'comments' );
          remove_post_type_support( $post_type, 'trackbacks' );
        }
      }
    }
    add_action( 'admin_init', 'disable_comments_post_types_support' );

    function disable_comments_status() {
      return false;
    }
    add_filter( 'comments_open', 'disable_comments_status', 20, 2 );
    add_filter( 'pings_open', 'disable_comments_status', 20, 2 );

    function disable_comments_hide_existing_comments( $comments ) {
      $comments = array();
      return $comments;
    }
    add_filter( 'comments_array', 'disable_comments_hide_existing_comments', 10, 2 );

    function disable_comments_admin_menu() {
      remove_menu_page( 'edit-comments.php' );
    }
    add_action( 'admin_menu', 'disable_comments_admin_menu' );

    function disable_comments_admin_menu_redirect() {
      global $pagenow;
      if ( $pagenow === 'edit-comments.php' ) {
        wp_redirect( admin_url() ); exit;
      }
    }
    add_action( 'admin_init', 'disable_comments_admin_menu_redirect' );

    function disable_comments_dashboard() {
      remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
    }
    add_action( 'admin_init', 'disable_comments_dashboard' );

    function remove_comments_from_admin_bar() {
      global $wp_admin_bar;
      $wp_admin_bar->remove_menu('comments');
    }
    add_action( 'wp_before_admin_bar_render', 'remove_comments_from_admin_bar' );

  }

  if ( DISABLE_EMOJI === TRUE ) {
    add_action( 'init', 'disable_wp_emojicons' );
    function disable_wp_emojicons() {
      remove_action( 'admin_print_styles', 'print_emoji_styles' );
      remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
      remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
      remove_action( 'wp_print_styles', 'print_emoji_styles' );
      remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
      remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
      remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    }
  }

  if ( DISABLE_JSON === TRUE ) {
    add_filter( 'json_enabled', '__return_false' );
    add_filter( 'json_jsonp_enabled', '__return_false' );
    remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
  }

  if ( DISABLE_OEMBED === TRUE ) {
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
    remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );
    remove_action( 'wp_head', 'wp_oembed_add_host_js' );
    remove_action( 'rest_api_init', 'wp_oembed_register_route' );
    remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
  }

  if ( DISABLE_RSS === TRUE ) {
    function disable_feed() {
      wp_die( __( 'Nincs elérhető feed, kérem térjen vissza a <a href="'. esc_url( home_url( '/' ) ) .'">főoldalra</a>!', TEXTDOMAIN ) );
    }
    add_action('do_feed', 'disable_feed', 1);
    add_action('do_feed_rdf', 'disable_feed', 1);
    add_action('do_feed_rss', 'disable_feed', 1);
    add_action('do_feed_rss2', 'disable_feed', 1);
    add_action('do_feed_atom', 'disable_feed', 1);
    add_action('do_feed_rss2_comments', 'disable_feed', 1);
    add_action('do_feed_atom_comments', 'disable_feed', 1);
  }

  if ( DISABLE_SEARCH === TRUE ) {
    if ( ! is_admin() ) {
      function disable_search( $query, $error = true ) {
        if ( is_search() ) {
          $query->is_search = false;
          $query->query_vars[s] = false;
          $query->query[s] = false;
          if ( $error == true )
            wp_redirect( site_url(), 301 ); exit;
        }
      }
      add_action( 'parse_query', 'disable_search' );
      add_filter( 'get_search_form', function($a) { return null; } );
    }
  }

  if ( DISABLE_UPDATE_WP === TRUE ) {
    delete_site_transient('update_core');
    remove_action('admin_init', '_maybe_update_core');
    remove_action('wp_version_check', 'wp_version_check');
    wp_clear_scheduled_hook('wp_version_check');
    remove_action('init', 'wp_schedule_update_checks');
    if ( ! current_user_can( 'administrator' ) ) {
      add_action( 'init', function () { remove_action('init', 'wp_version_check'); }, 2 );
      add_filter( 'pre_option_update_core', function($a) { return null; } );
    }
    add_filter( 'send_core_update_notification_email', '__return_false' );
    add_filter( 'auto_core_update_send_email', 'stop_auto_update_email', 10, 4 );
    function stop_auto_update_email( $send, $type, $core_update, $result ) {
      if ( ! empty( $type ) && $type == 'success' ) {
        return false;
      }
      return true;
    }
  }

  /**
   * <link rel="EditURI" type="application/rsd+xml" title="RSD" href="http://domain.name/xmlrpc.php?rsd" />
   */
  remove_action( 'wp_head', 'rsd_link' );

  /**
   * <meta name="generator" content="WordPress 4.7.3" />
   */
  remove_action( 'wp_head', 'wp_generator' );

  /**
   * remove feed links
   */
  remove_action( 'wp_head', 'feed_links', 2 );
  remove_action( 'wp_head', 'feed_links_extra', 3 );

  /**
   * remove adjacent post links
   */
  remove_action( 'wp_head', 'index_rel_link' );
  remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
  remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );
  remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );
  remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );

  /**
   * <link rel='shortlink' href='http://domain.name/?p=1487' />
   */
  remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );

  /**
   * <link rel="wlwmanifest" type="application/wlwmanifest+xml" href="http://domain.name/wp-includes/wlwmanifest.xml" />
   */
  remove_action( 'wp_head', 'wlwmanifest_link' );

  /**
   * remove Emoji scripts
   */
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_action( 'admin_print_styles', 'print_emoji_styles' );

  remove_action( 'wp_head', 'dns-prefetch' );

  if ( defined( 'WPSEO_VERSION' ) ) {
    add_action( 'get_header', function() {
      ob_start( function ( $o ) {
        return preg_replace('/\n?<.*?yoast.*?>/mi','',$o);
      });
    });
    add_action( 'wp_head', function() {
      ob_end_flush();
    }, 999 );
  }

  if ( ! empty ( $GLOBALS['sitepress'] ) ) {
    add_action( 'wp_head', function() {
      remove_action( current_filter(), array ( $GLOBALS['sitepress'], 'meta_generator_tag' ) );
    }, 0 );
  }

  function login_logo() {
    if ( ! empty(CUSTOM_LOGIN_LOGO) ) :
      $logo_info  = unserialize(CUSTOM_LOGIN_LOGO);
      $logo_image = $logo_info[0];
      $height     = $logo_info[1];
      $width      = $logo_info[2];
    else:
      $logo_image = '';
    endif;
    if ( $logo_image == '') {
      $image = THEME_URL . '/modules/login/admin_logo.svg';
      $w = '';
      $h = '';
    } else {
      $image = THEME_URL . '/images/' . $logo_image;
      $w = 'width: ' . $width . 'px!important;';
      $h = 'height: ' . $height . 'px!important;';
    }
    echo '
    <style type="text/css">
      body.login div#login h1 a {
        background-image: url(\'' . $image . '\');
        background-size: 100%;
        margin-bottom: 10px;
        position: relative;
        '. $w .'
        '. $h .'
      }
    </style>';
  }
  add_action('login_head', 'login_logo');

  function custom_login() {
    echo '<link rel="stylesheet" type="text/css" href="' . THEME_URL . '/modules/login/custom-login-styles.min.css" />';
  }
  add_action('login_head', 'custom_login');

  function login_logo_url() {
    return get_bloginfo( 'url' );
  }
  add_filter( 'login_headerurl', 'login_logo_url' );

  function login_logo_url_title() {
    return get_bloginfo( 'sitename' );
  }
  add_filter( 'login_headertitle', 'login_logo_url_title' );

  function login_error_override() {
    return __('A megadott bejelentkezési adatok helytelenek!', TEXTDOMAIN);
  }
  add_filter('login_errors', 'login_error_override');

  function remove_wp_shake_js() {
    remove_action('login_head', 'wp_shake_js', 12);
  }
  add_action('login_head', 'remove_wp_shake_js');

  function loginfooter() {
    echo '<p id="footer-text">&copy; ' . date('Y') . ' <a href="' . DEVELOPER_URL . '" target="_blank">' . DEVELOPER_NAME . '</a> - ' . get_bloginfo( 'sitename' ) . '<br/><small>powered by <a href="https://wordpress.org/" target="_blank">WordPress</a></small></p>';
  }
  add_action('login_footer','loginfooter');

  if( current_user_can( 'administrator' ) ) {

    if( empty( DEVELOPER_NAME ) ) {
      add_action( 'admin_notices', 'showDebugMessages2' );
      function showDebugMessages2() {
        echo '<div id="message" class="notice notice-warning">';
          echo '<p><strong>' . __('FIGYELEM!', TEXTDOMAIN) . '</strong> ' . __('Nincs megadva a Fejlesztő cég neve.', TEXTDOMAIN) . '</p>';
        echo '</div>';
      }
    }

    if( empty( TEXTDOMAIN ) ) {
      add_action( 'admin_notices', 'showDebugMessages4' );
      function showDebugMessages4() {
        echo '<div id="message" class="notice notice-error">';
          echo '<p><strong>' . __('HIBA!', TEXTDOMAIN) . '</strong> ' . __('Nincs definiálva a TEXTDOMAIN a settings.php-ban!.', TEXTDOMAIN) . '</p>';
        echo '</div>';
      }
    }

    if( USE_EDITOR_STYLE == FALSE ) {
      add_action( 'admin_notices', 'showDebugMessages5' );
      function showDebugMessages5() {
        echo '<div id="message" class="notice notice-info">';
          echo '<p><strong>' . __('HELLO!', TEXTDOMAIN) . '</strong> ' . __('A Téma nem tartalmaz editor-style.css file-t. Cselekedj ma jót és készítsd el :)', TEXTDOMAIN) . '</p>';
        echo '</div>';
      }
    }

    if( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) {
      add_action( 'admin_notices', 'showDebugMessages' );
      function showDebugMessages() {
        echo '<div id="message" class="notice notice-info" style="background:#a9cce3;color:#1a5276;">';
          echo '<p><strong>FIGYELEM!</strong> A <strong><em>WP_DEBUG</em></strong> aktív.</p>';
        echo '</div>';
      }
    }

    if( ( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) && ( defined( 'WP_DEBUG_LOG' ) && true === WP_DEBUG_LOG ) ) {
      add_action( 'admin_notices', 'showDebugMessages6' );
      function showDebugMessages6() {
        echo '<div id="message" class="notice notice-warning" style="background:#e74c3c;color:#fff;border-left-color:#c0392b;">';
          echo check_is_devsite();
        echo '</div>';
      }
    }

    if( !function_exists( 'check_is_devsite' ) ) {
      function check_is_devsite() {
        if ( $_SERVER['HTTP_HOST'] == 'dev.kreativvonalak.hu' ) {
          return '<p>A <strong style="font-weight:700;">dev.kreativvonalak.hu</strong> környezetben a <strong style="font-weight:700;">debug.log</strong> nem elérhető a szerver beállításai miatt!</p>';
        } else {
          return '<p><strong>A <strong style="font-weight:700;">WP_DEBUG_LOG</strong> aktív, az alábbi helyen érhető el: <strong style="font-weight:700;">/debug.log</strong></p>';
        }
      }
    }

  }
