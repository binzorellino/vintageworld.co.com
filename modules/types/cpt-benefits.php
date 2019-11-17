<?php
register_via_cpt_core (
  array (
    __( 'Előny', TEXTDOMAIN ),
    __( 'Előnyök', TEXTDOMAIN ),
    'benefits'
  ),
  array (
    'supports'            => array( 'title' ),
    'menu_icon'           => 'dashicons-yes-alt',
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