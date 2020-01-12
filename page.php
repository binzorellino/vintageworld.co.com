<?php
get_header();
?>
<div class="tamplate-page">
  <div class="container text-container">
    <div class="row">
      <div class="col-md-12">
        <?php
        wp_breadcrumbs_generator();
        while ( have_posts() ) : the_post();
          get_template_part( 'template-parts/content', get_post_type() );
        endwhile; wp_reset_postdata();
        ?>
      </div>
    </div>
  </div>
</div>
<?php
get_sidebar();
get_footer();
?>
