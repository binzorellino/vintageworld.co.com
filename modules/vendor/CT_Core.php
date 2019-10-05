<?php

if ( ! class_exists( 'Taxonomy_Core' ) ) :

  /**
   * Plugin class for generating/registering custom Taxonomies.
   * @since 1.0.7
   * @version 0.2.3
   * @author  Justin Sternberg <https://github.com/WebDevStudios/Taxonomy_Core>
   */
  class Taxonomy_Core {

    private $singular;
    private $plural;
    private $taxonomy;
    private $arg_overrides = array();
    private $taxonomy_args = array();
    private $object_types;
    private static $taxonomies = array();

    public function __construct( $taxonomy, $arg_overrides = array(), $object_types = array( 'post' ) ) {

      if ( ! is_array( $taxonomy ) ) {
        wp_die( __( 'A single, plural és slug megadása kötelező a működéshez', 'kvbf' ) );
      }

      if ( ! isset( $taxonomy[0], $taxonomy[1], $taxonomy[2] ) ) {
        wp_die( __( 'A single, plural és slug megadása kötelező a működéshez', 'kvbf' ) );
      }

      if ( ! is_string( $taxonomy[0] ) || ! is_string( $taxonomy[1] ) || ! is_string( $taxonomy[2] ) ) {
        wp_die( __( 'A single, plural és slug megadása kötelező a működéshez', 'kvbf' ) );
      }

      $this->singular      = $taxonomy[0];
      $this->plural        = ! isset( $taxonomy[1] ) || ! is_string( $taxonomy[1] ) ? $taxonomy[0] .'s' : $taxonomy[1];
      $this->taxonomy      = ! isset( $taxonomy[2] ) || ! is_string( $taxonomy[2] ) ? sanitize_title( $this->plural ) : $taxonomy[2];
      $this->arg_overrides = (array) $arg_overrides;
      $this->object_types  = (array) $object_types;

      add_action( 'init', array( $this, 'register_taxonomy' ), 5 );
    }

    public function get_args() {
      if ( ! empty( $this->taxonomy_args ) ) {
        return $this->taxonomy_args;
      }

      $hierarchical = true;
      if ( isset( $this->arg_overrides['hierarchical'] ) ) {
        $hierarchical = (bool) $this->arg_overrides['hierarchical'];
      }

      $labels = array(
        'name'                       => $this->plural,
        'singular_name'              => $this->singular,
        'search_items'               => sprintf( __( 'Keresés a %s között', 'kvbf' ), $this->plural ),
        'all_items'                  => sprintf( __( 'Összes %s', 'kvbf' ), $this->plural ),
        'edit_item'                  => sprintf( __( '%s szerkesztése', 'kvbf' ), $this->singular ),
        'view_item'                  => sprintf( __( '%s megtekintése', 'kvbf' ), $this->singular ),
        'update_item'                => sprintf( __( '%s frissítése', 'kvbf' ), $this->singular ),
        'add_new_item'               => sprintf( __( 'Új %s létrehozása', 'kvbf' ), $this->singular ),
        'new_item_name'              => sprintf( __( 'Új %s név', 'kvbf' ), $this->singular ),
        'not_found'                  => sprintf( __( 'Nincsenek létrehozott %s', 'kvbf' ), $this->plural ),
        'no_terms'                   => sprintf( __( 'Nincs %s', 'kvbf' ), $this->plural ),

        // Hierarchical stuff
        'parent_item'       => $hierarchical ? sprintf( __( '%s szülője', 'kvbf' ), $this->singular ) : null,
        'parent_item_colon' => $hierarchical ? sprintf( __( '%s szülője:', 'kvbf' ), $this->singular ) : null,

        // Non-hierarchical stuff
        'popular_items'              => $hierarchical ? null : sprintf( __( 'Népszerű %s elem(ek)', 'kvbf' ), $this->plural ),
        'separate_items_with_commas' => $hierarchical ? null : sprintf( __( '%s elemek vesszővel elválasztva', 'kvbf' ), $this->plural ),
        'add_or_remove_items'        => $hierarchical ? null : sprintf( __( '%s elem hozzáadása vagy eltávolítása', 'kvbf' ), $this->plural ),
        'choose_from_most_used'      => $hierarchical ? null : sprintf( __( 'Válaszd a leghasználtabb %s elemet', 'kvbf' ), $this->plural ),
      );

      $defaults = array(
        'labels'            => array(),
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'rewrite'           => array( 'hierarchical' => $hierarchical, 'slug' => $this->taxonomy ),
      );

      $this->taxonomy_args           = wp_parse_args( $this->arg_overrides, $defaults );
      $this->taxonomy_args['labels'] = wp_parse_args( $this->taxonomy_args['labels'], $labels );

      return $this->taxonomy_args;
    }

    public function register_taxonomy() {
      global $wp_taxonomies;

      $args = register_taxonomy( $this->taxonomy, $this->object_types, $this->get_args() );

      if ( is_wp_error( $args ) ) {
        wp_die( $args->get_error_message() );
      }

      $this->taxonomy_args = $wp_taxonomies[ $this->taxonomy ];

      self::$taxonomies[ $this->taxonomy ] = $this;
    }

    public function taxonomy( $key = 'taxonomy' ) {

      return isset( $this->$key ) ? $this->$key : array(
        'singular'     => $this->singular,
        'plural'       => $this->plural,
        'taxonomy'     => $this->taxonomy,
        'object_types' => $this->object_types,
      );
    }

    public static function taxonomies( $taxonomy = '' ) {
      if ( true === $taxonomy && ! empty( self::$taxonomies ) ) {
        return array_keys( self::$taxonomies );
      }
      return isset( self::$taxonomies[ $taxonomy ] ) ? self::$taxonomies[ $taxonomy ] : self::$taxonomies;
    }

    public function __toString() {
      return $this->taxonomy();
    }

  }

  if ( ! function_exists( 'register_via_taxonomy_core' ) ) {
    function register_via_taxonomy_core( $taxonomy, $arg_overrides = array(), $object_types = array( 'post' ) ) {
      return new Taxonomy_Core( $taxonomy, $arg_overrides, $object_types );
    }
  }

endif;

?>
