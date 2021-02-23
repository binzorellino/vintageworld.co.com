<?php
get_header();
?>
<div class="archive__blog">
  <div class="container text-container">
    <div class="row">
      <div class="col-md-12">
        <?php wp_breadcrumbs_generator(); ?>
        <h2 class="entry-title"><?php echo get_queried_object()->name; ?></h2>
        <?php
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
        $args = array( 'post_type' => 'post', 'suppress_filters' => false, 'orderby' => 'menu_order', 'order' => 'ASC', 'paged' => $paged );
        $myposts = new WP_Query( $args );
        if ( $myposts->have_posts() ) : ?>
        <div class="archive__container">
          <?php
          while ( $myposts->have_posts() ) : $myposts->the_post(); ?>
          <div class="archive__item" itemscope itemtype="http://schema.org/Article">
            <div class="archive__item-thumb-wrapper" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
              <?php $image = ''; ?>
              <a class="archive__item-thumb-link" itemprop="url" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
              <?php if ( has_post_thumbnail( $post->ID ) ) : ?>
                <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
                <img class="archive__item-thumb" itemprop="image" src="<?php echo aq_resize( $image[0], 400, 300, true, true, true, true ); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
              <?php else : ?>
                <img class="archive__item-thumb" itemprop="image" src="<?php echo get_template_directory_uri(); ?>/images/no-thumb.png" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
              <?php endif; ?>
              </a>
              <meta itemprop="width" content="<?php echo ($image) ? $image[1] : '410'; ?>">
              <meta itemprop="height" content="<?php echo ($image) ? $image[2] : '350'; ?>">
              <meta itemprop="url" content="<?php echo ($image) ? $image[0] : get_template_directory_uri().'/images/no-thumb.png'; ?>">
            </div>
            <div class="archive__item-heading">
              <h3 class="archive__item-title" itemprop="name"><a class="archive__item-title-link" itemprop="url" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
            </div>
            <?php
              /*if( !is_category() ) {
                $terms = wp_get_post_terms( $post->ID, 'egyedi-kategoriak' );
                if ( $terms ) {
                  echo '<div class="archive__item-category-wrapper">';
                  foreach( $terms as $term ) {
                    echo '<a class="archive__item-category-link" href="'.get_term_link($term->term_id, 'egyedi-kategoriak').'">#' . $term->name . '</a>';
                  }
                  echo '</div>';
                }
              }*/
            ?>
            <div class="archive__item-text-wrapper">
              <p class="archive__item-excerpt" itemprop="description headline"><?php echo strip_tags(get_the_excerpt()); ?></p>
              <a class="more-link archive__item-link" href="<?php echo get_permalink( $post->ID ); ?>"><?php  _e('Read more', 'vintageworld'); ?></a>
            </div>
            <meta itemprop="author" content="<?php bloginfo( 'name' ); ?>">
            <meta itemprop="datePublished" content="<?php echo get_the_date( 'Y-m-d', $post->ID ); ?>">
          </div>
          <?php endwhile; ?>
          <div class="clear"></div>
        </div>
        <?php
        $GLOBALS['wp_query']->max_num_pages = $myposts->max_num_pages;
        $nav = get_the_posts_pagination(
          array(
            'mid_size'           => 1,
            'prev_text'          => '<i class="fas fa-angle-left"></i>',
            'next_text'          => '<i class="fas fa-angle-right"></i>',
            'screen_reader_text' => 'A'
          )
        );
        $nav = str_replace( '<h2 class="screen-reader-text">A</h2>', '', $nav );
        echo $nav;
        ?>
        <div class="clear"></div>
        <?php else: ?>
        <span class="archive__item-noresult"><strong><?php _e('No content to show.', 'vintageworld'); ?></strong></span>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
      </div>
    </div>
  </div>
</div>
<?php
//get_template_part( 'template-parts/sections/section', 'instagram' );

get_sidebar();

get_footer();
?>