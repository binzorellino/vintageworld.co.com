<?php
$post_629 = get_post(icl_object_id( 629, 'editable-elements', false ));
if( $post_629 ) {
  $occasions_title = get_the_title( $post_629->ID );
  $occasions_subtitle = get_field( 'alcim', $post_629->ID );
}
wp_reset_postdata();

$product_occasions = get_terms( 'pa_occasion', array( 'hide_empty' => false, 'parent' => 0 ) );
if ( $product_occasions ) :
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

          foreach ( $product_occasions as $term ) :

          $term_title = $term->name;
          $term_link  = get_term_link( $term->term_id );
          $term_thumb = get_field('kep','pa_occasion_'.$term->term_id);
          $i++;

          if ( $term_thumb == '' ) {
            if ( $i < 2 ) {
              $term_thumb_resized = get_template_directory_uri() . '/images/no-image_occasion_306x616.png';
            } else {
              $term_thumb_resized = get_template_directory_uri() . '/images/no-image_occasion_306x306.png';
            }
          } else {
            if ( $i < 2 ) {
              $term_thumb_resized = aq_resize( $term_thumb, 306, 616, true, true, true );
            } else {
              $term_thumb_resized = aq_resize( $term_thumb, 306, 306, true, true, true );
            }
          }
          ?>
          <figure class="occasions__item">
            <a class="occasions__link" href="<?php echo $term_link; ?>">
              <img class="occasions__bg" src="<?php echo $term_thumb_resized; ?>" alt="<?php echo $term_title; ?>" />
              <i class="occasions__overlay"></i>
              <figcaption class="occasions__caption"><?php echo $term_title; ?></figcaption>
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
endif; // ( $product_occasions )
wp_reset_postdata();
?>