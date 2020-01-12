<?php
$heroSliderArgs = array(
  'posts_per_page'   => -1,
  'category_name'    => '',
  'orderby'          => 'menu_order',
  'order'            => 'ASC',
  'post_type'        => 'heroslider',
  'post_status'      => 'publish',
  'suppress_filters' => false,
  'fields'           => '',
);
global $post;
$heroSlides = get_posts( $heroSliderArgs );
if ( have_posts() ) : ?>
<section class="heroslider-section">
  <div class="heroslider__container">
    <?php
    foreach ( $heroSlides as $post ) :
    setup_postdata( $post ); ?>
    <div class="heroslider__item">
      <!--img class="heroslider__bg" src="<?php the_field( 'slide_hatterkep', $post->ID ); ?>" /-->
      <div class="heroslider__content" style="background-image: url('<?php the_field( 'slide_hatterkep', $post->ID ); ?>')">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <p class="heroslider__text break-line"><?php the_field( 'slide_szoveg', $post->ID ); ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
    endforeach; 
    wp_reset_postdata();?>
  </div>
  <div class="heroslider__bottom">
    <span class="heroslider__bottom-text"><?php _e('Roses that lasts forever', 'vintageworld') ?></span>
  </div>
</section>
<?php endif; ?>