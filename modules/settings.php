<?php


  define( 'THEME_DIR', get_template_directory() );
  define( 'THEME_URL', get_template_directory_uri() );

  define( 'TEXTDOMAIN', '' );

  add_action( 'after_setup_theme', 'theme_setup' );
  function theme_setup() {
    load_theme_textdomain( TEXTDOMAIN, THEME_URL . '/languages' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array(
      'gallery',
      'caption'
      )
    );
  }

  add_action( 'init', 'register_custom_menu' );
  function register_custom_menu() {
    register_nav_menus(
      array(
        'fomenu' => 'Fejléc menü'
      )
    );
  }

  add_action( 'wp_enqueue_scripts', 'template_scripts' );
  function template_scripts() {
    wp_enqueue_style( TEXTDOMAIN.'-style', get_stylesheet_uri() );
    wp_enqueue_script('jquery');
    wp_enqueue_script( TEXTDOMAIN.'-bxslider-js', THEME_URL . '/javascripts/plugins/bxslider/jquery.bxslider.min.js', array(), '', false );
    wp_enqueue_script( TEXTDOMAIN.'-main', THEME_URL . '/javascripts/main.min.js', array(), '', false );
  }

  add_image_size( 'base-thumb', 397, 265, true );

  define( 'DEVELOPER_NAME', 'Kreatív Vonalak' );
  define( 'DEVELOPER_URL', 'http://www.kreativvonalak.hu/' );

  define( 'DISABLE_COMMENTS', TRUE );
  define( 'DISABLE_EMOJI', TRUE );
  define( 'DISABLE_JSON', TRUE );
  define( 'DISABLE_OEMBED', TRUE );
  define( 'DISABLE_RSS', TRUE );
  define( 'DISABLE_SEARCH', TRUE );
  define( 'DISABLE_UPDATE_WP', FALSE );

  define( 'ENABLE_CUSTOM_POST_TYPES', TRUE );
  define( 'ENABLE_CUSTOM_TAXONOMY', TRUE );
  define( 'ENABLE_CUSTOM_POST_TYPES_COLUMNS', TRUE );

  define( 'USE_EDITOR_STYLE', FALSE );

  /**
   * Használat:
   * Ha jó a beépített, akkor hagyjuk üresen a CUSTOM_LOGIN_LOGO-t.
   * Ha szeretnénk egyedi logót, akkor használjuk a következő formulát:
   * KÉPFILE_NEVE - pl.: custom_logo.png
   * define( 'CUSTOM_LOGIN_LOGO', serialize(array('KÉPFILE_NEVE', 'KÉPFILE_MAGASSÁGA', 'KÉPFILE_SZÉLESSÉGE')) );
   * KÉPFILE_MAGASSÁGA és KÉPFILE_SZÉLESSÉGE - pl.: 55, a px kiterjesztést nem kell hozzáteni
   */
  define( 'CUSTOM_LOGIN_LOGO', '');

  // Rödid leírás hossza szavakban
  define( 'EXCERPT_LENGTH', '22');

  define( 'ENABLE_DEVELOPER_WIDGET', TRUE );

  // Info: https://github.com/syamilmj/Aqua-Resizer
  // aq_resize( $url, $width, $height, $crop, $single, $upscale );
  define( 'ENABLE_RESIZER', TRUE );

  // Közösségi média linkek
  define( 'FACEBOOK', '' );
  define( 'YOUTUBE', '' );
  define( 'TWITTER', '' );
  define( 'INSTAGRAM', '' );
  define( 'GOOGLEPLUS', '' );
  define( 'LINKEDIN', '' );
