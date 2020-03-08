<?php

  /**
   * KVwpBaseFunctions - Shortcodes
   *
   * @author Kreatív Vonalak - Istvan Krucsanyica <https://github.com/istvankrucsanyica/KVwpBaseFunctions>
   * @copyright (c) 2017, GNUv2
   * @package KVwpBaseFunctions
   * @since 1.0
   * @version 1.0
   */

  /**
   * Google térkép beágyazása
   *
   * Szükséges a helyes megjelenítéshez a .embed-container beépítése a CSS file-ba
   *
   * @usage [googlemaps src="https://www.google.com...."]
   */
  add_shortcode('piktogram-rovid-leirassal', 'custom_embend_picwithtext');
  function custom_embend_picwithtext( $atts ) {
    $atts = shortcode_atts(array('kep' => '', 'leiras' => ''), $atts);
    return '<div class="picwithext__container"><div class="picwithext__pic">' . $atts['kep'] . '</div><div class="picwithext__text">' . $atts['leiras'] . '</div></div>';
  }


  /**
   * Google térkép beágyazása
   *
   * Szükséges a helyes megjelenítéshez a .embed-container beépítése a CSS file-ba
   *
   * @usage [googlemaps src="https://www.google.com...."]
   */
  add_shortcode('googlemaps', 'custom_embend_googlemaps');
  function custom_embend_googlemaps( $atts ) {
    $atts = shortcode_atts(array('src' => ''), $atts);
    return '<div class="mapouter"><div class="gmap_canvas"><iframe id="gmap_canvas" src="' . $atts['src'] . '" width="500" height="500" frameborder="0" allowfullscreen="allowfullscreen"></iframe></div></div>';
  }


  /**
   * Youtube videó beágyazása
   *
   * Szükséges a helyes megjelenítéshez a .embed-container beépítése a CSS file-ba
   *
   * @usage [youtube videoid="xxxxxxxxxx"]
   */
  add_shortcode('youtube', 'custom_embend_youtube');
  function custom_embend_youtube( $atts ) {
    $atts = shortcode_atts(array('videoid' => ''), $atts);
    return '<div class="embed-container"><iframe src="http://www.youtube.com/embed/' . $atts['videoid'] . '" frameborder="0" allowfullscreen></iframe></div>';
  }


  /**
   * Button shortcode
   * @usage [button link="http://valami.hu" szoveg="Gomb szövege" ujoldal="igen/nem"]
   */
  add_shortcode( 'button', 'custom_button_shortcode' );
  function custom_button_shortcode( $attrs ) {
    $button_attrs = shortcode_atts( array( 'link' => '', 'szoveg' => '', 'ujoldal' => 'igen' ), $attrs );
    if ( $button_attrs['ujoldal'] == 'igen' ) { $new_window = ' target="_blank"'; } else { $new_window = ''; }
    return '<a href="' . $button_attrs['link'] . '"' . $new_window . ' class="btn btn-inlineblock btn-rounded btn-bordered btn-green">' . $button_attrs['szoveg'] . ' &raquo;</a>';
  }


  /**
   * Accordion shortcode
   * @usage [accordion title="Fül címe"]SZÖVEG[/accordion]
   */
  function accordion_shortcode($atts = [], $content = null) {
    $atts = array_change_key_case((array)$atts, CASE_LOWER);
    $accordion_atts = shortcode_atts([ 'title' => '', ], $atts);
    $o = '';
    $o .= '<div class="accordion__wrapper">';
    $o .= '<div class="accordion__heading">';
    $o .= '<span class="accordion__title">&raquo; ' . esc_html__($accordion_atts['title'], 'accordion') . '</span>';
    $o .= '<i class="accordion__arrow">;</i>';
    $o .= '</div>';
    $o .= '<div class="accordion__body" style="display: none;">';
    $o .= do_shortcode($content);
    $o .= '</div>';
    $o .= '<div style="clear:both;float:none;"></div>';
    $o .= '</div>';

    return $o;
  }

  function accordion_shortcodes_init() {
    add_shortcode('accordion', 'accordion_shortcode');
  }

  add_action('init', 'accordion_shortcodes_init');

?>
