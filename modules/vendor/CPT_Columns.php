<?php

if ( ! class_exists( 'CPT_Columns' ) ) {

  /**
   * CPT_Columns
   * Simple class to add remove and manage admin post columns
   * @author Ohad Raz <admin@bainternet.info>
   * @since  1.0.1
   * @version 1.0.2
   * @copyright 2013 Ohad Raz
   */

  class CPT_Columns {

    public $cpt_columns = array();

    public $cpt_remove_columns = array();

    public $cpt_sortable_columns = array();

    public $cpt_name = '';

    public $replace = false;

    function __construct( $cpt = '', $replace = false ) {
      $this->cpt_name = $cpt;
      $this->replace = $replace;
      add_filter( "manage_{$cpt}_posts_columns", array( $this, '_cpt_columns' ), 50 );
      add_filter( "manage_{$cpt}_posts_columns", array( $this, '_cpt_columns_remove' ), 60 );
      add_action( "manage_{$cpt}_posts_custom_column", array( $this, '_cpt_custom_column'), 50, 2 );
      add_filter( "manage_edit-{$cpt}_sortable_columns", array( $this, "_sortable_columns" ), 50 );
      add_filter( 'pre_get_posts', array( $this, '_column_orderby' ), 50 );
    }

    function _cpt_columns( $defaults ) {
      global $typenow;
      if ( $this->cpt_name == $typenow ) {
        $tmp = array();
        foreach ( $this->cpt_columns as $key => $args ) {
          $tmp[$key] = $args['label'];
        }
        if ( $this->replace )
          return $tmp;
        else
          $defaults = array_merge( $defaults, $tmp );
      }
      return $defaults;
    }

    function _cpt_columns_remove( $columns ) {
      foreach ( $this->cpt_remove_columns as $key ) {
        if ( isset($columns[$key]) )
          unset( $columns[$key] );
      }
      return $columns;
    }

    function _sortable_columns( $columns ) {
      global $typenow;
      if ( $this->cpt_name == $typenow ) {
        foreach ( $this->cpt_sortable_columns as $key => $args ) {
          $columns[$key] = $key;
        }
      }
      return $columns;
    }

    function _cpt_custom_column( $column_name, $post_id ) {
      if ( isset( $this->cpt_columns[$column_name] ) )
        $this->do_column( $post_id, $this->cpt_columns[$column_name], $column_name );
    }

    function do_column( $post_id, $column, $column_name ) {
      if ( in_array( $column['type'], array( 'text', 'thumb', 'post_meta', 'custom_tax', 'custom_thumb', 'post_id', 'translations', 'special_post_meta' ) ) )
        echo $column['prefix'];
      switch ( $column['type'] ) {
        case 'text':
          echo apply_filters( 'cpt_columns_text_'.$column_name, $column['text'], $post_id, $column, $column_name );
          break;
        case 'post_id':
          echo $post_id;
          break;
        case 'thumb':
          if ( has_post_thumbnail( $post_id ) ) {
              the_post_thumbnail( $column['size'] );
            }else {
              echo 'N/A';
            }
          break;
        case 'translations':
          echo $column['icl_translations'];
          break;
        case 'custom_thumb':
          $tmp = get_post_meta( $post_id, $column['meta_key'], true );
          $image = wp_get_attachment_url( $tmp );
          if ( $image ) {
            if ( ! empty( $column['image_width'] ) ) { $iw = $column['image_width']; } else { $iw ='150'; }
            echo '<img src="' . $image . '" alt="" width="'. $iw .'" />';
          } else {
            echo 'N/A';
          }
          break;
        case 'post_meta':
          $tmp = get_post_meta( $post_id, $column['meta_key'], true );
          echo ( ! empty( $tmp ) )? $tmp : $column['std'];
          break;
        case 'special_post_meta':
          $tmp = get_post_meta( $post_id, $column['meta_key'], true );
          if($tmp == 1):
            $r = 'Eszköz';
          elseif($tmp == 2):
            $r = 'Szoftver';
          elseif($tmp == 3):
            $r = 'Hardver';
          else:
            $r = 'N/A';
          endif;
          echo ( ! empty( $tmp ) )? $r : $column['std'];
          break;
        case 'custom_tax':
          $post_type = get_post_type( $post_id );
            $terms = get_the_terms( $post_id, $column['taxonomy'] );
            if ( ! empty( $terms ) ) {
                foreach ( $terms as $term ) {
                  $href = "edit.php?post_type={$post_type}&{$column['taxonomy']}={$term->slug}";
                  $name = esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, $column['taxonomy'], 'edit' ) );
                  $post_terms[] = "<a href='{$href}'>{$name}</a>";
                }
                echo join( ', ', $post_terms );
            }
            else echo '';
          break;
      }
      if ( in_array( $column['type'], array( 'text', 'thumb', 'post_meta', 'custom_tax', 'custom_thumb', 'post_id', 'translations', 'special_post_meta' ) ) )
        echo $column['suffix'];
    }

    function _column_orderby( $query ) {
      if( ! is_admin() )
        return;

      $orderby = $query->get( 'orderby' );
      $keys = array_keys( (array)$this->cpt_sortable_columns );
      if ( in_array( $orderby, $keys ) ) {
        if ( 'post_meta' == $this->cpt_sortable_columns[$orderby]['type'] ) {
          $query->set( 'meta_key', $orderby );
          $query->set( 'orderby', $this->cpt_sortable_columns[$orderby]['orderby'] );
        }
      }
    }

    function add_column( $key, $args ) {
      $def = array(
        'label'       => 'column label',
        'size'        => array('80','80'),
        'taxonomy'    => '',
        'meta_key'    => '',
        'sortable'    => false,
        'text'        => '',
        'type'        => 'native', //'native','post_meta','custom_tax','custom_thumb','post_id',text
        'orderby'     => 'meta_value',
        'prefix'      => '',
        'suffix'      => '',
        'std'         => '',
        'image_width' => '',
        'icl_translations' => '',
      );
      $this->cpt_columns[$key] = array_merge( $def, $args );
      if ( $this->cpt_columns[$key]['sortable'] )
        $this->cpt_sortable_columns[$key] = $this->cpt_columns[$key];
    }

    function remove_column( $key ) {
      $this->cpt_remove_columns[] = $key;
    }

  }

}
