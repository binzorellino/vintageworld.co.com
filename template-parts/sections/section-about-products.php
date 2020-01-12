<?php
$post_435 = get_post(icl_object_id( 435, 'editable-elements', false ));
if ( $post_435 ) :
?>
<section class="about-products-section">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="about-products__conatiner">
          <?php
          $about_img_url = get_the_post_thumbnail_url( $post_435->ID );
          $about_img_url = aq_resize( $about_img_url, 584, 730, true, true, true );
          if ( !$about_img_url ) $about_img_url = get_template_directory_uri() . '/images/no-image_about-product_584x730.jpg';
          ?>
          <div class="about-products__img-wrap" style="background-image: url('<?php echo $about_img_url; ?>');">
            <img class="about-products__img" src="<?php echo $about_img_url; ?>" />
          </div>
          <div class="about-products__text-wrap">
            <header class="about-products__heading">
              <h2 class="about-products__title break-line"><?php echo get_the_title( $post_435->ID ); ?></h2>
            </header>
            <div class="about-products__content-wrap">
              <?php the_field( 'szerkeztheto_tartalom', $post_435->ID ); ?>
            </div>
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