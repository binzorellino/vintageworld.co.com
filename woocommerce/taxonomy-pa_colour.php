<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header();

$exclusion_id_list  = array();

$term               = get_queried_object();
$term_title         = $term->name;
$term_link          = get_term_link( $term->term_id );
$term_thumb         = get_field('kep','pa_colour_'.$term->term_id);
$term_thumb_resized = aq_resize( $term_thumb, 536, 700, true, true, true, true );
$term_assigned_list = get_field('kollekcio_lista','pa_colour_'.$term->term_id);
$term_assigned_main = get_field('kiemelt_kollekcio','pa_colour_'.$term->term_id);


//-------------------------------------------------------------------------------------------------
//-- KIEMELT KOLLEKCIÓ ----------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------

if ( $term_assigned_main ) :
$args_products_main = array(
  'post_type'      => 'product',
  'posts_per_page' => 4,
  'orderby'        => 'date',
  'order'          => 'ASC',
  'tax_query'      => array(
    array(
      'taxonomy'     => 'pa_collection',
      'field'        => 'ID',
      'terms'        =>  $term_assigned_main,
      'operator'     => 'IN'
    )
  )
);
$query_products_main = new WP_Query( $args_products_main );
if ( $query_products_main->have_posts() ) :

?>
<div class="procuct_card-section">
  <div class="container text-container">
    <div class="row">
      <div class="col-md-12">
        <div class="procuct_card__container">
          <div class="procuct_card__item">
            <?php woocommerce_breadcrumb(); ?>
            <h2 class="entry-title procuct_card__item-title"><?php echo $term_title; ?></h2>
            <div class="procuct_card__item-inner">
              <div class="procuct_card__cover-wrapper procuct_card__item-part">
                <?php
                $procuct_card_title = $term_title;
                $procuct_card_cover_img_url = $term_thumb_resized;
                if ( !$procuct_card_cover_img_url ) $procuct_card_cover_img_url = get_template_directory_uri() . '/images/no-image_favourites_268x350.jpg';
                ?>
                <a href="<?php echo $term_link; ?>" title="<?php echo $procuct_card_title; ?>">
                  <img class="procuct_card__cover" src="<?php echo $procuct_card_cover_img_url; ?>" />
                </a>
              </div>
              <div class="procuct_card__products-container procuct_card__item-part">
                <div class="procuct_card__products-inner">
                <?php

                while ( $query_products_main->have_posts() ) :
                  $query_products_main->the_post();
                  $product = wc_get_product( $query_products_main->post->ID );

                  global $product;

                  $product_id  = $product->get_id();
                  $pruduct_url = get_permalink( $product_id );
                  array_push($exclusion_id_list, $product_id);

                  $attributes      = $product->get_attributes();
                  $collection_name = $product->get_attribute( 'pa_collection' );
                  $collection_id   = $attributes["pa_collection"]["options"][0];
                  $collection_url  = get_term_link($collection_id);

                  if ( has_post_thumbnail( $product->get_id() ) ) :
                    $product_img = wp_get_attachment_image_src( get_post_thumbnail_id(  $product->get_id()  ), 'shop_catalog' );
                    $pruduct_img_url = aq_resize( $product_img[0], 500, 500, true, true, true );
                  else :
                    $pruduct_img_url = get_template_directory_uri() . '/images/no-image_small-product-thumb_250x250.jpg';
                  endif; // ( has_post_thumbnail( $product->get_id() ) )

                  ?>
                  <div <?php wc_product_class( 'procuct_card__product', $product ); ?>>
                    <a class="procuct_card__thumb-wrapper" href="<?php echo $pruduct_url; ?>" title="<?php the_title(); ?>">
                      <span class="procuct_card__thumb" style="background-image: url('<?php echo $pruduct_img_url; ?>');"></span>
                    </a>
                    <span class="procuct_card__cart-message added"><?php _e('Added to cart', 'vintageworld'); ?></span>
                    <span class="procuct_card__cart-message already-in"><?php _e('Already in cart', 'vintageworld'); ?></span>
                    <div class="procuct_card__product-info">
                      <div class="procuct_card__product-text">
                        <a class="procuct_card__collection" href="<?php echo $collection_url; ?>"><?php echo $collection_name; ?></a>
                        <a class="procuct_card__title" href="<?php echo $pruduct_url; ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                      </div>
                      <div class="procuct_card__cart-wrapper">
                        <?php
                        if( !my_custom_cart_contains( $product->get_id() ) ) :
                        ?>
                        <a class="procuct_card__cart vw-add-to-cart" title="<?php _e('Add to cart', 'vintageworld'); ?>" data-product-id="<?php echo $product->get_id(); ?>">
                          <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="30" height="40" viewBox="0 0 376.000000 500.000000" preserveAspectRatio="xMidYMid meet"> <g transform="translate(0.000000,500.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none"> <path d="M1720 4840 c-160 -40 -286 -116 -407 -243 -91 -98 -149 -199 -188 -332 -24 -81 -28 -111 -32 -292 l-6 -203 -403 0 -404 0 0 -1785 0 -1785 1615 0 1615 0 0 1785 0 1785 -374 0 -373 0 -6 198 c-4 151 -10 215 -25 273 -42 160 -117 285 -240 401 -89 83 -180 138 -302 179 -88 30 -106 33 -245 36 -122 2 -164 -1 -225 -17z m341 -296 c187 -56 326 -197 374 -381 10 -40 15 -109 15 -225 l0 -168 -525 0 -525 0 0 173 c0 252 29 339 154 462 73 72 147 116 233 140 69 19 208 18 274 -1z m-971 -1219 l0 -145 155 0 155 0 0 145 0 145 525 0 525 0 0 -145 0 -145 155 0 155 0 0 145 0 145 225 0 225 0 0 -1485 0 -1485 -1315 0 -1315 0 0 1485 0 1485 255 0 255 0 0 -145z"/> </g> </svg>
                        </a>
                        <?php
                        else :
                        ?>
                        <a class="procuct_card__cart vw-add-to-cart" title="<?php _e('Add to cart', 'vintageworld'); ?>" data-product-id="<?php echo $product->get_id(); ?>" disabled="disabled">
                          <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="30" height="40" viewBox="0 0 376.000000 500.000000" preserveAspectRatio="xMidYMid meet"> <g transform="translate(0.000000,500.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none"> <path d="M1720 4840 c-160 -40 -286 -116 -407 -243 -91 -98 -149 -199 -188 -332 -24 -81 -28 -111 -32 -292 l-6 -203 -403 0 -404 0 0 -1785 0 -1785 1615 0 1615 0 0 1785 0 1785 -374 0 -373 0 -6 198 c-4 151 -10 215 -25 273 -42 160 -117 285 -240 401 -89 83 -180 138 -302 179 -88 30 -106 33 -245 36 -122 2 -164 -1 -225 -17z m341 -296 c187 -56 326 -197 374 -381 10 -40 15 -109 15 -225 l0 -168 -525 0 -525 0 0 173 c0 252 29 339 154 462 73 72 147 116 233 140 69 19 208 18 274 -1z m-971 -1219 l0 -145 155 0 155 0 0 145 0 145 525 0 525 0 0 -145 0 -145 155 0 155 0 0 145 0 145 225 0 225 0 0 -1485 0 -1485 -1315 0 -1315 0 0 1485 0 1485 255 0 255 0 0 -145z"/> </g> </svg>
                        </a>
                        <?php
                        endif;
                        ?>
                      </div>
                    </div>
                    <i class="add-to-cart-loader"></i>
                  </div>
                <?php

                endwhile; // ( $query_products->have_posts() )
                ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php

endif; // ( $query_products_main->have_posts() )
wp_reset_postdata();

endif; // ( $term_assigned_main )


//-------------------------------------------------------------------------------------------------
//-- HOZZÁRENDELT KOLLEKCIÓK ----------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------

if ( $term_assigned_list ) :
$args_products = array(
  'post_type'      => 'product',
  'posts_per_page' => -1,
  'orderby'        => 'date',
  'order'          => 'ASC',
  'tax_query'      => array(
    'relation'       => 'AND',
    array(
      'taxonomy'      => 'pa_collection',
      'field'         => 'ID',
      'terms'         =>  $term_assigned_list,
      'operator'      => 'IN'
    ),
    array(
      'taxonomy'      => 'pa_collection',
      'field'         => 'ID',
      'terms'         =>  $term_assigned_main,
      'operator'      => 'NOT IN'
    )
  )
);
$query_products = new WP_Query( $args_products );
if ( $query_products->have_posts() ) :

?>
<div class="procuct_after-card-section">
  <div class="container text-container">
    <div class="row">
      <div class="col-md-12">
        <?php
        include 'loop/loop-start.php';

        while ( $query_products->have_posts() ) :
          $query_products->the_post();
          $product = wc_get_product( $query_products->post->ID );
          global $product;

          $product_id  = $product->get_id();
          array_push($exclusion_id_list, $product_id);

          include 'content-product.php';

        endwhile; // ( $query_products->have_posts() )

        include 'loop/loop-end.php';
        ?>
      </div>
    </div>
  </div>
</div>
<?php

endif; // ( $query_products->have_posts() )
wp_reset_postdata();

endif; // ( $term_assigned_list )


//-------------------------------------------------------------------------------------------------
//-- HOZZÁRENDELT TERMÉKEK ------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------

$args_products_rest = array(
  'post_type'      => 'product',
  'posts_per_page' => -1,
  'orderby'        => 'date',
  'order'          => 'ASC',
  'post__not_in'   => $exclusion_id_list,
  'tax_query'      => array(
    array(
      'taxonomy'     => $term->taxonomy,
      'field'        => 'slug',
      'terms'        =>  $term->slug,
      'operator'     => 'IN'
    )
  )
);
$query_products_rest = new WP_Query( $args_products_rest );
if ( $query_products_rest->have_posts() ) :

?>
<div class="procuct_after-card-section">
  <div class="container text-container">
    <div class="row">
      <div class="col-md-12">
        <?php
        include 'loop/loop-start.php';

        while ( $query_products_rest->have_posts() ) :
          $query_products_rest->the_post();
          $product = wc_get_product( $query_products_rest->post->ID );
          global $product;

          include 'content-product.php';

        endwhile; // ( $query_products_rest->have_posts() )

        include 'loop/loop-end.php';
        ?>
      </div>
    </div>
  </div>
</div>
<?php

endif; // ( $query_products_rest->have_posts() )
wp_reset_postdata();

get_footer();

?>
