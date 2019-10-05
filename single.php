<?php

  get_header();

  while ( have_posts() ) : the_post();
    get_template_part( 'template-parts/content', get_post_type() );
  endwhile; wp_reset_postdata();

  get_sidebar();

  get_footer();

?>
