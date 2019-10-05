<?php

if ( ! class_exists( 'CPT_Core' ) ) :

  /**
   * Class for generating Custom Post Types.
   * @since 1.0.1
   * @version 1.0.0
   * @author  Justin Sternberg <https://github.com/Mte90/CPT_Core>
   */

  class CPT_Core {

    private $singular;

    private $plural;

    private $post_type;

    private $arg_overrides = array();

    private $cpt_args = array();

    private static $custom_post_types = array();

    public function __construct( array $cpt, $arg_overrides = array() ) {

      if ( ! is_array( $cpt ) ) {
        wp_die( __( 'A single, plural és slug megadása kötelező a működéshez', 'kvbf' ) );
      }

      if ( ! isset( $cpt[0], $cpt[1], $cpt[2] ) ) {
        wp_die( __( 'A single, plural és slug megadása kötelező a működéshez', 'kvbf' ) );
      }

      if ( ! is_string( $cpt[0] ) || ! is_string( $cpt[1] ) || ! is_string( $cpt[2] ) ) {
        wp_die( __( 'A single, plural és slug megadása kötelező a működéshez', 'kvbf' ) );
      }

      $this->singular  = $cpt[0];
      $this->plural    = ! isset( $cpt[1] ) || ! is_string( $cpt[1] ) ? $cpt[0] .'s' : $cpt[1];
      $this->post_type = ! isset( $cpt[2] ) || ! is_string( $cpt[2] ) ? sanitize_title( $this->plural ) : $cpt[2];

      $this->arg_overrides = (array) $arg_overrides;

      add_action( 'init', array( $this, 'register_post_type' ) );
      add_filter( 'post_updated_messages', array( $this, 'messages' ) );
      add_filter( 'enter_title_here', array( $this, 'title' ) );
    }

    public function get_arg( $arg ) {
      $args = $this->get_args();
      if ( isset( $args->{$arg} ) ) {
        return $args->{$arg};
      }
      if ( is_array( $args ) && isset( $args[ $arg ] ) ) {
        return $args[ $arg ];
      }
    }

    public function get_args() {
      if ( ! empty( $this->cpt_args ) )
        return $this->cpt_args;

      $labels = array(
        'name'               => $this->plural,
        'singular_name'      => $this->singular,
        'add_new'            => sprintf( __( 'Új %s létrehozása', 'kvbf' ), $this->singular ),
        'add_new_item'       => sprintf( __( 'Új %s létrehozása', 'kvbf' ), $this->singular ),
        'edit_item'          => sprintf( __( '%s szerkesztése', 'kvbf' ), $this->singular ),
        'new_item'           => sprintf( __( 'Új %s létrehozása', 'kvbf' ), $this->singular ),
        'all_items'          => sprintf( __( 'Összes %s', 'kvbf' ), $this->plural ),
        'view_item'          => sprintf( __( '%s megtekintése', 'kvbf' ), $this->singular ),
        'search_items'       => sprintf( __( 'Keresés a %s között', 'kvbf' ), $this->plural ),
        'not_found'          => sprintf( __( 'Nincsenek létrehozott %s', 'kvbf' ), $this->plural ),
        'not_found_in_trash' => sprintf( __( 'Nem található %s a lomtárban', 'kvbf' ), $this->plural ),
        'parent_item_colon'  => isset( $this->arg_overrides['hierarchical'] ) && $this->arg_overrides['hierarchical'] ? sprintf( __( 'Szülő %s:', 'kvbf' ), $this->singular ) : null,
        'menu_name'          => $this->plural,
      );

      $defaults = array(
        'labels'             => array(),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'has_archive'        => true,
        'supports'           => array( 'title', 'editor' ),
      );

      $this->cpt_args = wp_parse_args( $this->arg_overrides, $defaults );
      $this->cpt_args['labels'] = wp_parse_args( $this->cpt_args['labels'], $labels );

      return $this->cpt_args;
    }

    public function register_post_type() {
      $args = register_post_type( $this->post_type, $this->get_args() );
      if ( is_wp_error( $args ) )
        wp_die( $args->get_error_message() );

      $this->cpt_args = $args;

      self::$custom_post_types[ $this->post_type ] = $this;
    }

    public function messages( $messages ) {
      global $post, $post_ID;


      $cpt_messages = array(
        0 => '',
        2 => __( 'Custom field frissítésre került.' ),
        3 => __( 'Custom field törölve.' ),
        4 => sprintf( __( '%1$s frissítve.', 'kvbf' ), $this->singular ),
        5 => isset( $_GET['revision'] ) ? sprintf( __( '%1$s elem visszaállítva a következő verzióra %2$s', 'kvbf' ), $this->singular , wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
        7 => sprintf( __( '%1$s elemen mentve.', 'kvbf' ), $this->singular ),
      );

      if ( $this->get_arg( 'public' ) ) {

        $cpt_messages[1] = sprintf( __( '%1$s elem frissítve.', 'kvbf' ), $this->singular, esc_url( get_permalink( $post_ID ) ) );
        $cpt_messages[6] = sprintf( __( '%1$s elem közzétéve.', 'kvbf' ), $this->singular, esc_url( get_permalink( $post_ID ) ) );
        $cpt_messages[8] = sprintf( __( '%1$s submitted.', 'kvbf' ), $this->singular, esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) );
        $cpt_messages[9] = sprintf( __( '%1$s elem időzítve: <strong>%2$s</strong>.', 'kvbf' ), $this->singular, date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink( $post_ID ) ) );
        $cpt_messages[10] = sprintf( __( '%1$s vázlat frissítve.', 'kvbf' ), $this->singular, esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) );

      } else {

        $cpt_messages[1] = sprintf( __( '%1$s elem frissítve.', 'kvbf' ), $this->singular );
        $cpt_messages[6] = sprintf( __( '%1$s elem közzétéve.', 'kvbf' ), $this->singular );
        $cpt_messages[8] = sprintf( __( '%1$s submitted.', 'kvbf' ), $this->singular );
        $cpt_messages[9] = sprintf( __( '%1$s elem időzítve: <strong>%2$s</strong>.', 'kvbf' ), $this->singular, date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ) );
        $cpt_messages[10] = sprintf( __( '%1$s vázlat frissítve.', 'kvbf' ), $this->singular );

      }

      $messages[ $this->post_type ] = $cpt_messages;
      return $messages;
    }


    public function title( $title ){

      $screen = get_current_screen();
      if ( isset( $screen->post_type ) && $screen->post_type == $this->post_type )
        return sprintf( __( '%s Title', 'kvbf' ), $this->singular );

      return $title;
    }

    public function post_type( $key = 'post_type' ) {

      return isset( $this->$key ) ? $this->$key : array(
        'singular'  => $this->singular,
        'plural'    => $this->plural,
        'post_type' => $this->post_type,
      );
    }

    public static function post_types( $post_type = '' ) {
      if ( $post_type === true && ! empty( self::$custom_post_types ) ) {
        return array_keys( self::$custom_post_types );
      }
      return isset( self::$custom_post_types[ $post_type ] ) ? self::$custom_post_types[ $post_type ] : self::$custom_post_types;
    }

    public function __toString() {
      return $this->post_type();
    }


  }

  if ( ! function_exists( 'register_via_cpt_core' ) ) {
    function register_via_cpt_core( $cpt, $arg_overrides = array() ) {
      return new CPT_Core( $cpt, $arg_overrides );
    }
  }

endif;
