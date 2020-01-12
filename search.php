<?php get_header(); ?>
  <div class="breadcr">
    <div class="container">
      <div class="row">
        <?php // custom_breadcrumbs(); ?>
      </div>
    </div>
  </div>
<div class="entry-content" itemprop="text">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="list-single">
          <header class="entry-header">
            <h2 class="entry-title" itemprop="name headline"><?php printf( esc_html__( 'Search results for: %s', 'vintageworld' ), '<span>"' . get_search_query() . '"</span>' ); ?></h2>
          </header>
          <?php
          if ( have_posts() && strlen( trim(get_search_query()) ) != 0 ):
            echo '<div class="search-result-wrapper">';
            while ( have_posts() ) : the_post();
              get_template_part( "template-parts/items/item", "search-result" );
            endwhile; wp_reset_postdata();
            echo '</div>';
            $nav = get_the_posts_pagination( array(
              'mid_size'           => 2,
              'prev_text'          => '<',
              'next_text'          => '>',
              'screen_reader_text' => 'A'
            ) );
            $nav = str_replace('<h2 class="screen-reader-text">A</h2>', '', $nav);
            echo $nav;
          else:
          ?>
            <span class="no-result"><h3><?php _e('Nothing found for this phrase.<br>Try another!', 'vintageworld'); ?></h3></span>
          <?php endif; ?>

        </div>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>
