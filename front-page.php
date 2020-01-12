<?php

  get_header();

  get_template_part( 'template-parts/sections/section', 'hero-slider' );

  get_template_part( 'template-parts/sections/section', 'occasions' );

  get_template_part( 'template-parts/sections/section', 'benefits' );

  get_template_part( 'template-parts/sections/section', 'about-products' );

  get_template_part( 'template-parts/sections/section', 'favourites' );

  get_template_part( 'template-parts/sections/section', 'subscribe' );
  
  get_template_part( 'template-parts/sections/section', 'instagram' );

  get_sidebar();

  get_footer();
  
?>
