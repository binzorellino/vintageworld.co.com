<?php
$post_632 = get_post( 632 );
if( $post_632 ) {
  $favourites_title = get_the_title( $post_632->ID );
  $favourites_subtitle = get_field( 'alcim', $post_632->ID );
}
wp_reset_postdata();

$args_favourites = array(
  'post_type'        => 'favourites',
  'no_found_rows'    => 1,
  'posts_per_page'   => 4,
  'suppress_filters' => false,
  'orderby'          => 'menu_order',
  'order'            => 'DESC'
);
$favourites = get_posts($args_favourites);
if ( $favourites ) :
?>
<section class="favourites-section">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <header class="favourites__header">
          <h2 class="favourites__title break-line"><?php echo $favourites_title; ?></h2>
          <span class="favourites__subtitle break-line"><?php echo $favourites_subtitle; ?></span>
        </header>
        <div class="favourites__container">

          <!-- start - kedvenc kollekció -->
          <?php
          foreach ( $favourites as $favourite ) :
          setup_postdata( $favourite );
          ?>
          <div class="favourites__item">
            <div class="favourites__item-inner">
              <div class="favourites__cover-wrapper favourites__item-part">
                <?php
                $favourites_title = get_the_title( $favourite->ID );
                $favourites_cover_img_url = get_the_post_thumbnail_url( $favourite->ID );
                $favourites_cover_img_url = aq_resize( $favourites_cover_img_url, 268, 350, true, true, true );
                if ( !$favourites_cover_img_url ) $favourites_cover_img_url = get_template_directory_uri() . '/images/no-image_favourites_268x350.jpg';
                ?>
                <img class="favourites__cover" src="<?php echo $favourites_cover_img_url; ?>" />
              </div>
              <div class="favourites__products-container favourites__item-part">

                <!-- start - kedvenc kollekció termék -->
                <div class="favourites__products-inner">
                <?php
                $product_ids = array();
                for ($i = 1; $i <= 4; $i++) :
                  $product_obj = get_field('termek_' . $i, $favourite->ID);
                  $product_ids[$i] = $product_obj->ID;
                endfor;
                $args_products = array(
                  'post_type'      => 'product',
                  'posts_per_page' => 4,
                  'orderby'        => 'post__in',
                  'post__in'       => $product_ids
                );
                $query_products = new WP_Query( $args_products );
                if ( $query_products->have_posts() ) :
                while ( $query_products->have_posts() ) :
                  $query_products->the_post();
                  $product = wc_get_product( $query_products->post->ID );

                  global $product;

                  $pruduct_url = get_permalink( $product->get_id() );
                  if ( has_post_thumbnail( $product->get_id() ) ):
                    $product_img = wp_get_attachment_image_src( get_post_thumbnail_id(  $product->get_id()  ), 'shop_catalog' );
                    $pruduct_img_url = aq_resize( $product_img[0], 250, 250, true, true, true );
                  else :
                    $pruduct_img_url = get_template_directory_uri() . '/images/no-image_small-product-thumb_250x250.jpg';
                  endif;
                  ?>
                  <div <?php wc_product_class( 'favourites__product', $product ); ?>>
                    <a class="favourites__thumb-wrapper" href="<?php echo $pruduct_url; ?>" title="<?php the_title(); ?>">
                      <span class="favourites__thumb" style="background-image: url('<?php echo $pruduct_img_url; ?>');"></span>
                    </a>
                    <div class="favourites__product-info">
                      <div class="favourites__product-text">
                        <h3 class="favourites__collection"><?php echo $favourites_title; ?></h3>
                        <a class="favourites__title" href="<?php echo $pruduct_url; ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                      </div>
                      <div class="favourites__cart-wrapper">
                        <?php
                        if( !my_custom_cart_contains( $product->get_id() ) ) :
                        ?>
                        <a class="favourites__cart" title="<?php _e('Add to cart', 'vintageworld'); ?>" data-product-id="<?php echo $product->get_id(); ?>"></a>
                        <?php
                        else :
                        ?>
                        <a class="favourites__cart" title="<?php _e('Add to cart', 'vintageworld'); ?>" data-product-id="<?php echo $product->get_id(); ?>" disabled="disabled"></a>
                        <?php
                        endif;
                        ?>
                      </div>
                    </div>
                  </div>
                  <?php
                endwhile;
                endif;
                ?>
                </div>
                <!-- kedvenc kollekció termék - end -->

              </div>
            </div>
          </div>
          <?php
          endforeach;
          ?>
          <!-- kedvenc kollekció - end -->

        </div>
      </div>
    </div>
  </div>
</section>
<?php 
endif;
wp_reset_postdata(); ?>