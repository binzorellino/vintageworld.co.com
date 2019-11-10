<?php

  if( !current_user_can( 'administrator' ) ):

    $url = get_site_url() . '/coming-soon';
    wp_redirect($url);
    exit();

  else:

  get_header();

  get_template_part( 'template-parts/sections/section', 'hero-slider' );

  get_sidebar();

  get_footer();

  endif;
  
?>
