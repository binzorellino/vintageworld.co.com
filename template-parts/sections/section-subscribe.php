<?php
$post_636 = get_post(icl_object_id( 636, 'editable-elements', false ));
if ( $post_636 ) :
$subscribe_title = get_the_title( $post_636->ID );
$subscribe_subtitle = get_field( 'alcim', $post_636->ID );
?>
<section class="subscribe-section">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="subscribe__heading">
          <h2 class="subscribe__title break-line"><?php echo $subscribe_title; ?></h2>
          <span class="subscribe__subtitle break-line"><?php echo $subscribe_subtitle; ?></span>
        </div>
        <div class="subscribe__content">
          <form class="subscribe__form" action="">
            <label class="subscribe__label" for="subscribe-email"><?php _e('Sign up for our Newsletter!', 'vintageworld'); ?></label>
            <input class="subscribe__field" id="subscribe-email" type="email" placeholder="<?php _e('Your e-mail adress', 'vintageworld'); ?>" required />
            <input class="subscribe__submit" type="submit" value="<?php _e('Join!', 'vintageworld'); ?>" />
          </form>
          <div class="subscribe__desc">
            <?php the_field( 'szerkeztheto_tartalom', $post_636->ID ); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php 
endif;
wp_reset_postdata();
?>