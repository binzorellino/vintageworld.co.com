<?php
$post_632 = get_post( 632 );
if( $post_632 ) {
  $favourites_title = get_the_title( $post_632->ID );
  $favourites_subtitle = get_field( 'alcim', $post_632->ID );
}
wp_reset_postdata();

$product_collections = get_terms( 'pa_collection', array( 'hide_empty' => false, 'parent' => 0 ) );
if ( $product_collections ) :
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

          <?php
          foreach ( $product_collections as $term ) :
          $term_title              = $term->name;
          $term_link               = get_term_link( $term->term_id );
          $term_thumb              = get_field('kep','pa_collection_'.$term->term_id);
          $term_thumb_resized      = aq_resize( $term_thumb, 268, 350, true, true, true, true );
          $collection_is_favourite = get_field('kedvenc_kollekcio','pa_collection_'.$term->term_id);

          if ( $collection_is_favourite === true ) :
          ?>
          <div class="favourites__item">
            <div class="favourites__item-inner">
              <div class="favourites__cover-wrapper favourites__item-part">
                <?php
                $favourites_title = get_the_title( $favourite->ID );
                $favourites_cover_img_url = $term_thumb_resized;
                if ( !$favourites_cover_img_url ) $favourites_cover_img_url = get_template_directory_uri() . '/images/no-image_favourites_268x350.jpg';
                ?>
                <a href="<?php echo $term_link; ?>" title="<?php echo $term_title; ?>">
                  <img class="favourites__cover" src="<?php echo $favourites_cover_img_url; ?>" />
                </a>
              </div>
              <div class="favourites__products-container favourites__item-part">
                <div class="favourites__products-inner">
                <?php
                $args_products = array(
                  'post_type'      => 'product',
                  'posts_per_page' => 4,
                  'orderby'        => 'date',
                  'order'          => 'ASC',
                  'tax_query'      => array(
                    array(
                      'taxonomy'        => 'pa_collection',
                      'field'           => 'slug',
                      'terms'           =>  array( $term->slug ),
                      'operator'        => 'IN'
                    )
                  )
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
                    <span class="procuct_card__cart-message added"><?php _e('Added to cart', 'vintageworld'); ?></span>
                    <span class="procuct_card__cart-message already-in"><?php _e('Already in cart', 'vintageworld'); ?></span>
                    <div class="favourites__product-info">
                      <div class="favourites__product-text">
                      <a class="favourites__collection" href="<?php echo $term_link; ?>"><?php echo $term_title; ?></a>
                        <a class="favourites__title" href="<?php echo $pruduct_url; ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                      </div>
                      <div class="favourites__cart-wrapper">
                        <?php
                        if( !my_custom_cart_contains( $product->get_id() ) ) :
                        ?>
                        <a class="favourites__cart vw-add-to-cart" title="<?php _e('Add to cart', 'vintageworld'); ?>" data-product-id="<?php echo $product->get_id(); ?>">
                          <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="15" height="20" viewBox="0 0 376.000000 500.000000" preserveAspectRatio="xMidYMid meet"> <g transform="translate(0.000000,500.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none"> <path d="M1720 4840 c-160 -40 -286 -116 -407 -243 -91 -98 -149 -199 -188 -332 -24 -81 -28 -111 -32 -292 l-6 -203 -403 0 -404 0 0 -1785 0 -1785 1615 0 1615 0 0 1785 0 1785 -374 0 -373 0 -6 198 c-4 151 -10 215 -25 273 -42 160 -117 285 -240 401 -89 83 -180 138 -302 179 -88 30 -106 33 -245 36 -122 2 -164 -1 -225 -17z m341 -296 c187 -56 326 -197 374 -381 10 -40 15 -109 15 -225 l0 -168 -525 0 -525 0 0 173 c0 252 29 339 154 462 73 72 147 116 233 140 69 19 208 18 274 -1z m-971 -1219 l0 -145 155 0 155 0 0 145 0 145 525 0 525 0 0 -145 0 -145 155 0 155 0 0 145 0 145 225 0 225 0 0 -1485 0 -1485 -1315 0 -1315 0 0 1485 0 1485 255 0 255 0 0 -145z"/> </g> </svg>
                        </a>
                        <?php
                        else :
                        ?>
                        <a class="favourites__cart vw-add-to-cart" title="<?php _e('Add to cart', 'vintageworld'); ?>" data-product-id="<?php echo $product->get_id(); ?>" disabled="disabled">
                          <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="15" height="20" viewBox="0 0 376.000000 500.000000" preserveAspectRatio="xMidYMid meet"> <g transform="translate(0.000000,500.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none"> <path d="M1720 4840 c-160 -40 -286 -116 -407 -243 -91 -98 -149 -199 -188 -332 -24 -81 -28 -111 -32 -292 l-6 -203 -403 0 -404 0 0 -1785 0 -1785 1615 0 1615 0 0 1785 0 1785 -374 0 -373 0 -6 198 c-4 151 -10 215 -25 273 -42 160 -117 285 -240 401 -89 83 -180 138 -302 179 -88 30 -106 33 -245 36 -122 2 -164 -1 -225 -17z m341 -296 c187 -56 326 -197 374 -381 10 -40 15 -109 15 -225 l0 -168 -525 0 -525 0 0 173 c0 252 29 339 154 462 73 72 147 116 233 140 69 19 208 18 274 -1z m-971 -1219 l0 -145 155 0 155 0 0 145 0 145 525 0 525 0 0 -145 0 -145 155 0 155 0 0 145 0 145 225 0 225 0 0 -1485 0 -1485 -1315 0 -1315 0 0 1485 0 1485 255 0 255 0 0 -145z"/> </g> </svg>
                        </a>
                        <?php
                        endif;
                        ?>
                      </div>
                    </div>
                    <i class="add-to-cart-loader"></i>
                  </div>
                  <?php
                endwhile;
                endif;
                ?>
                </div>

              </div>
            </div>
          </div>
          <?php
          endif; // ( $collection_is_favourite === true )
          endforeach; // ( $product_collections as $term )
          ?>

        </div>
      </div>
    </div>
  </div>
</section>
<?php

endif; // ( $product_collections )
wp_reset_postdata();
?>
