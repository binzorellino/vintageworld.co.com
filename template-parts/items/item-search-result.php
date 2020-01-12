<?php
$post_type = get_post_type();

if( $post_type == 'product' ):
  $product = wc_get_product($post->ID );
endif;

?>
<div class="post-item-wide">
  <?php if( $post_type == 'product' ):
    $is_new_product = get_field( 'uj_termek', $post->ID ); ?>
  <div class="post-item-wide__thumb<?php echo ($product->is_on_sale() || $is_new_product == 1 ) ? ' pt-realtive' : ''; ?>">
  <?php else: ?>
  <div class="post-item-wide__thumb">
  <?php endif; ?>
    <?php
    if( $post_type == 'product' ):
      if( $is_new_product == 1 ): ?>
      <span class="badge new<?php echo ($product->is_on_sale()) ? ' with-onsale' : ''; ?>">ÚJ</span>
      <?php endif; ?>
      <?php if( $product->is_on_sale() ): ?>
      <span class="badge onsale<?php echo ($is_new_product == 1) ? ' with-new' : ''; ?>">%</span><?php
      endif;
    endif; ?>
    <a href="<?php the_permalink(); ?>">
      <?php $image = ''; ?>
      <?php if (has_post_thumbnail( $post->ID ) ): ?>
        <?php
          if( $post_type == 'product' ):
            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'woocommerce_thumbnail' );
          else:
            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'base-thumb' );
          endif;
        ?>
        <img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
      <?php else:/*
          if( $post_type == 'product' ): ?>
            <img class="product-image wp-post-image" src="<?php echo THEME_URL; ?>/images/no-thumb-product_300.jpg" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" /><?php
          else: ?>
            <img src="<?php echo THEME_URL; ?>/images/deffault_post_300.jpg" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" /><?php
          endif;*/
      endif; ?>
    </a>
  </div>
  <div class="post-item-wide__descr">
    <h3 class="post-item__descr-title<?php echo ($post_type == 'product') ? ' with-product' : ''; ?>"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    <?php
    if( $post_type == 'product' ): ?>

      <div class="price-container">
        <strong>Ár:</strong> <?php echo $product->get_price_html(); ?>
      </div><?php

    endif; ?>
    <p class="post-item__descr-summary"><?php echo strip_tags(get_the_excerpt()); ?></p>
    <?php if( $post_type == 'product' ): ?>
        <a class="post-item__descr-btn" href="<?php echo get_permalink( $post->ID ); ?>"><?php _e('Megnézem', 'vintageworld'); ?> &raquo;</a><?php
      else: ?>
        <div class="moreLink"><a class="post-item__descr-btn" href="<?php echo get_permalink( $post->ID ); ?>"><?php _e('Elolvasom', 'vintageworld'); ?> &raquo;</a></div><?php
      endif; ?>
  </div>
</div>
