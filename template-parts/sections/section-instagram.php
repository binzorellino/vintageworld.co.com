<?php
$post_994 = get_post(icl_object_id( 994, 'editable-elements', false ));
if ( $post_994 ) :
?>
<section class="instagram-section">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="instagram__title"><?php echo get_the_title( $post_994->ID ); ?></h2>
        <?php echo do_shortcode('[elfsight_instagram_feed id="1"]'); ?>
      </div>
    </div>
  </div>
</section>
<?php
endif;
wp_reset_postdata();
?>
