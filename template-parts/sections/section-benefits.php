<?php
$args_benefits = array(
  'post_type'        => 'benefits',
  'no_found_rows'    => 1,
  'posts_per_page'   => 3,
  'suppress_filters' => false,
  'orderby'          => 'menu_order',
  'order'            => 'DESC'
);
$benefits = get_posts($args_benefits);
if ( $benefits ) :
?>
<section class="benefits-section">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="benefits__container">
          <?php
          foreach ( $benefits as $benefit ) :
          setup_postdata( $benefit );
          ?>
          <div class="benefits__item">
            <img class="benefits__thumb" src="<?php the_field( 'elony_-_ikon', $benefit->ID ); ?>" />
            <h2 class="benefits__title"><?php echo get_the_title( $benefit->ID ); ?></h2>
            <p class="benefits__desc"><?php the_field( 'elony_-_leiras', $benefit->ID ); ?></p>
          </div>
          <?php
          endforeach;
          ?>
        </div>
      </div>
    </div>
  </div>
</section>
<?php 
endif;
wp_reset_postdata(); ?>