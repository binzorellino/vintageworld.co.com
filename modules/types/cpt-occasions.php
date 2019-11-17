<?php
register_via_cpt_core (
  array (
    __( 'Alkalom', TEXTDOMAIN ),
    __( 'Alkalmak', TEXTDOMAIN ),
    'occasions'
  ),
  array (
    'supports'            => array( 'title' ),
    'menu_icon'           => 'dashicons-calendar-alt',
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