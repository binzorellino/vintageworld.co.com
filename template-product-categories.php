<?php

/**
 * Template Name: Termékkategóriák felsorolása a tartalom alá
 */

get_header();

GLOBAL $post;
$product_categories = get_terms( 'product_cat', array( 'hide_empty' => false, 'parent' => 0 ) );
if ( $product_categories ) :
?>
<section class="section-prod_cats">
  <div class="container text-container">
    <div class="row">
      <div class="col-md-12">
        <?php wp_breadcrumbs_generator(); ?>
        <h2 class="entry-title"><?php echo get_the_title( $post->ID ); ?></h2>
        <ul class="prod_cats--list">
          <?php
          foreach ( $product_categories as $term ) :

          $term_title         = $term->name;
          $term_desc          = $term->description;
          $term_link          = get_term_link( $term->term_id );
          $term_thumb_id      = get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
          $term_thumb         = wp_get_attachment_url( $term_thumb_id );
          $term_thumb_resized = aq_resize( $term_thumb, 1000, 600, true, true, true, true );

          ?>
          <li class="prod_cats--list-item">
            <a class="prod_cats--list-title-link" href="<?php echo $term_link; ?>">
              <h3 class="prod_cats--list-title"><?php echo $term_title; ?></h3>
            </a>
            <a class="prod_cats--list-thumb-link" href="<?php echo $term_link; ?>">
              <img class="prod_cats--list-thumb" src="<?php echo $term_thumb_resized; ?>" />
            </a>
            <p class="prod_cats--list-item-desc"><?php echo $term_desc; ?></p>
          </li>
          <?php

          endforeach; // ( $product_categories as $term )
        ?>
        </ul>
      </div>
    </div>
  </div>
</section>
<?php
endif; // ( $product_categories )
wp_reset_postdata();

get_footer();
?>
