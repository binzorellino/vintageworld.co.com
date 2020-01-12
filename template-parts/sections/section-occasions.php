<?php
$post_629 = get_post(icl_object_id( 629, 'editable-elements', false ));
if( $post_629 ) {
  $occasions_title = get_the_title( $post_629->ID );
  $occasions_subtitle = get_field( 'alcim', $post_629->ID );
}
wp_reset_postdata();

$args_occasions = array(
  'post_type'        => 'occasions',
  'no_found_rows'    => 1,
  'posts_per_page'   => 7,
  'suppress_filters' => false,
  'orderby'          => 'menu_order',
  'order'            => 'DESC'
);
$occasions = get_posts($args_occasions);
if ( $occasions ) :
?>
<section class="occasions-section">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <header class="occasions__heading">
          <h2 class="occasions__title break-line"><?php echo $occasions_title; ?></h2>
          <span class="occasions__subtitle break-line"><?php echo $occasions_subtitle; ?></span>
        </header>
        <div class="occasions__container">
          <?php
          $i = 0;
          foreach ( $occasions as $occasion ) :
          setup_postdata( $occasion );
          $i++;
          $bg_link = get_field( 'alkalom_-_hatter', $occasion->ID );
          if ( $bg_link == '' ) {
            if ( $i < 2 ) {
              $bg_resized = get_template_directory_uri() . '/images/no-image_occasion_306x696.png';
            } else {
              $bg_resized = get_template_directory_uri() . '/images/no-image_occasion_306x346.png';
            }
          } else {
            if ( $i < 2 ) {
              $bg_resized = aq_resize( $bg_link, 306, 696, true, true, true );
            } else {
              $bg_resized = aq_resize( $bg_link, 306, 346, true, true, true );
            }
          }
          ?>
          <figure class="occasions__item">
            <a class="occasions__link" href="<?php the_field( 'alkalom_-_link', $occasion->ID ); ?>">
              <img class="occasions__bg" src="<?php echo $bg_resized; ?>" alt="<?php echo get_the_title( $occasion->ID ); ?>" />
              <i class="occasions__overlay"></i>
              <figcaption class="occasions__caption"><?php echo get_the_title( $occasion->ID ); ?></figcaption>
            </a>
          </figure>
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
wp_reset_postdata();
?>