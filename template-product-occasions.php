<?php

/**
 * Template Name: Alkalmak felsorolása termékekkel a tartalom alá
 */

get_header();

GLOBAL $post;
$product_occasions = get_terms( 'pa_occasion', array( 'hide_empty' => false, 'parent' => 0 ) );
if ( $product_occasions ) :
?>
<header class="entry-header">
  <div class="container text-container">
    <div class="row">
      <div class="col-md-12">
        <?php wp_breadcrumbs_generator(); ?>
        <h2 class="entry-title"><?php echo get_the_title( $post->ID ); ?></h2>
      </div>
    </div>
  </div>
</header>
<div class="procuct_card-section">
  <div class="container text-container">
    <div class="row">
      <div class="col-md-12">
        <div class="procuct_card__container">
        <?php
        foreach ( $product_occasions as $term ) :
        $term_title         = $term->name;
        $term_link          = get_term_link( $term->term_id );
        $term_thumb         = get_field('kep', 'pa_occasion_'.$term->term_id);
        $term_assigned_list = get_field('kollekcio_lista','pa_occasion_'.$term->term_id);
        $term_assigned_main = get_field('kiemelt_kollekcio','pa_occasion_'.$term->term_id);
        $term_thumb_resized = aq_resize( $term_thumb, 536, 700, true, true, true, true );

        if ($term_assigned_main) {
          $args_products = array(
            'post_type'      => 'product',
            'posts_per_page' => 4,
            'orderby'        => 'date',
            'order'          => 'ASC',
            'tax_query'      => array(
              array(
                'taxonomy'        => 'pa_collection',
                'field'           => 'ID',
                'terms'           =>  $term_assigned_main,
                'operator'        => 'IN',
              ),
            )
          );

        } elseif ($term_assigned_list) {
          $args_products = array(
            'post_type'      => 'product',
            'posts_per_page' => 4,
            'orderby'        => 'date',
            'order'          => 'ASC',
            'tax_query'      => array(
              array(
                'taxonomy'        => 'pa_collection',
                'field'           => 'ID',
                'terms'           =>  $term_assigned_list,
                'operator'        => 'IN',
              ),
            )
          );
        } else {
          $args_products = array(
            'post_type'      => 'product',
            'posts_per_page' => 4,
            'orderby'        => 'date',
            'order'          => 'ASC',
            'tax_query'      => array(
              array(
                'taxonomy'        => $term->taxonomy,
                'field'           => 'slug',
                'terms'           =>  $term->slug,
                'operator'        => 'IN',
              ),
            )
          );
        }
        $query_products = new WP_Query( $args_products );
        if ( $query_products->have_posts() ) :
        ?>
          <div class="procuct_card__item">
            <h3 class="procuct_card__item-title"><?php echo $term_title; ?></h3>
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
                while ( $query_products->have_posts() ) :
                  $query_products->the_post();
                  $product = wc_get_product( $query_products->post->ID );

                  global $product;

                  $pruduct_url = get_permalink( $product->get_id() );

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
                    <div class="procuct_card__product-info">
                      <div class="procuct_card__product-text">
                      <a class="procuct_card__collection" href="<?php echo $product->get_attribute( 'pa_collection' ); ?>"><?php echo $product->get_attribute( 'pa_collection' ); ?></a>
                        <a class="procuct_card__title" href="<?php echo $pruduct_url; ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                      </div>
                      <div class="procuct_card__cart-wrapper">
                        <?php
                        if( !my_custom_cart_contains( $product->get_id() ) ) :
                        ?>
                        <a class="procuct_card__cart" title="<?php _e('Add to cart', 'vintageworld'); ?>" data-product-id="<?php echo $product->get_id(); ?>">
                          <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="30" height="40" viewBox="0 0 376.000000 500.000000" preserveAspectRatio="xMidYMid meet"> <g transform="translate(0.000000,500.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none"> <path d="M1720 4840 c-160 -40 -286 -116 -407 -243 -91 -98 -149 -199 -188 -332 -24 -81 -28 -111 -32 -292 l-6 -203 -403 0 -404 0 0 -1785 0 -1785 1615 0 1615 0 0 1785 0 1785 -374 0 -373 0 -6 198 c-4 151 -10 215 -25 273 -42 160 -117 285 -240 401 -89 83 -180 138 -302 179 -88 30 -106 33 -245 36 -122 2 -164 -1 -225 -17z m341 -296 c187 -56 326 -197 374 -381 10 -40 15 -109 15 -225 l0 -168 -525 0 -525 0 0 173 c0 252 29 339 154 462 73 72 147 116 233 140 69 19 208 18 274 -1z m-971 -1219 l0 -145 155 0 155 0 0 145 0 145 525 0 525 0 0 -145 0 -145 155 0 155 0 0 145 0 145 225 0 225 0 0 -1485 0 -1485 -1315 0 -1315 0 0 1485 0 1485 255 0 255 0 0 -145z"/> </g> </svg>
                        </a>
                        <?php
                        else :
                        ?>
                        <a class="procuct_card__cart" title="<?php _e('Add to cart', 'vintageworld'); ?>" data-product-id="<?php echo $product->get_id(); ?>" disabled="disabled">
                          <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="30" height="40" viewBox="0 0 376.000000 500.000000" preserveAspectRatio="xMidYMid meet"> <g transform="translate(0.000000,500.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none"> <path d="M1720 4840 c-160 -40 -286 -116 -407 -243 -91 -98 -149 -199 -188 -332 -24 -81 -28 -111 -32 -292 l-6 -203 -403 0 -404 0 0 -1785 0 -1785 1615 0 1615 0 0 1785 0 1785 -374 0 -373 0 -6 198 c-4 151 -10 215 -25 273 -42 160 -117 285 -240 401 -89 83 -180 138 -302 179 -88 30 -106 33 -245 36 -122 2 -164 -1 -225 -17z m341 -296 c187 -56 326 -197 374 -381 10 -40 15 -109 15 -225 l0 -168 -525 0 -525 0 0 173 c0 252 29 339 154 462 73 72 147 116 233 140 69 19 208 18 274 -1z m-971 -1219 l0 -145 155 0 155 0 0 145 0 145 525 0 525 0 0 -145 0 -145 155 0 155 0 0 145 0 145 225 0 225 0 0 -1485 0 -1485 -1315 0 -1315 0 0 1485 0 1485 255 0 255 0 0 -145z"/> </g> </svg>
                        </a>
                        <?php
                        endif;
                        ?>
                      </div>
                    </div>
                  </div>
                  <?php

                endwhile; // ( $query_products->have_posts() )
                ?>
                </div>
              </div>
            </div>
          </div>
        <?php
        endif; // ( $query_products->have_posts() )
        wp_reset_postdata();
        endforeach; // ( $product_occasions as $term )
        ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
endif; // ( $product_occasions )
wp_reset_postdata();

get_footer();
?>
