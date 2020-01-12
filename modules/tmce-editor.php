<?php

  /**
   * KVwpBaseFunctions - Editor functions, add shortcodes to the tinyMCE
   *
   * @author Kreatív Vonalak - Istvan Krucsanyica <https://github.com/istvankrucsanyica/KVwpBaseFunctions>
   * @copyright (c) 2017, GNUv2
   * @package KVwpBaseFunctions
   * @since 1.0
   * @version 1.0
   */



  if ( USE_EDITOR_STYLE == TRUE ) {

    add_action( 'after_setup_theme', 'kvbf_add_editor_styles' );
    function kvbf_add_editor_styles() {
      add_editor_style( 'editor-style.css' );
    }

  }


  add_action( 'admin_head', 'kvbf_add_shortcodes' );
  function kvbf_add_shortcodes() {
    if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) return;
    if ( get_user_option('rich_editing') == 'true') {
      add_filter( 'mce_external_plugins', 'kvbf_add_shortcode_tinymce_plugin', 20 );
      add_filter( 'mce_buttons', 'kvbf_register_shortcode_button',20 );
    }
  }


  function kvbf_register_shortcode_button( $buttons ) {
    array_push($buttons, "|", "kvbf_shortcodes_button");
    return $buttons;
  }


  function kvbf_add_shortcode_tinymce_plugin( $plugin_array ) {
    $plugin_array['KvbfShortcodes'] = get_template_directory_uri() .'/modules/tinymce/shortcode_mce.js';
    return $plugin_array;
  }


// -- editor-style.css kényszerített frissítése-------------------------------------------------
  add_filter( 'mce_css', 't5_fresh_editor_style' );
  
  function t5_fresh_editor_style( $css ) {
    global $editor_styles;
    if ( empty ( $css ) or empty ( $editor_styles ) ) {
        return $css;
    }
    $mce_css   = array();
    $style_uri = get_stylesheet_directory_uri();
    $style_dir = get_stylesheet_directory();
    if ( is_child_theme() ) {
      $template_uri = get_template_directory_uri();
      $template_dir = get_template_directory();
      foreach ( $editor_styles as $key => $file ) {
        if ( $file && file_exists( "$template_dir/$file" ) ) {
          $mce_css[] = add_query_arg(
            'version',
            filemtime( "$template_dir/$file" ),
            "$template_uri/$file"
          );
        }
      }
    }
    foreach ( $editor_styles as $file ) {
      if ( $file && file_exists( "$style_dir/$file" ) ) {
        $mce_css[] = add_query_arg(
          'version',
          filemtime( "$style_dir/$file" ),
          "$style_uri/$file"
        );
      }
    }
    return implode( ',', $mce_css );
  }
// ---------------------------------------------------------------------------------------------


// -- h1, h2 eltávolítása a menüből ------------------------------------------------------------
  add_filter('tiny_mce_before_init', 'tiny_mce_remove_unused_formats' );
  function tiny_mce_remove_unused_formats($init) {
    $init['block_formats'] = 'Paragraph=p;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6;Address=address;Pre=pre';
    return $init;
  }
// ---------------------------------------------------------------------------------------------

?>