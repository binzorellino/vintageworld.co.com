<?php
register_via_cpt_core (
  array (
    __( 'Kedvenc kollekció', TEXTDOMAIN ),
    __( 'Kedvenc kollekciók', TEXTDOMAIN ),
    'favourites'
  ),
  array (
    'supports'            => array( 'title', 'thumbnail' ),
    'menu_icon'           => 'dashicons-heart',
    'public'              => false,
    'publicly_queriable'  => true,
    'show_ui'             => true,
    'exclude_from_search' => true,
    'show_in_menu'        => true,
    'show_in_nav_menus'   => true,
    'has_archive'         => false,
    'rewrite'             => true
  )
);