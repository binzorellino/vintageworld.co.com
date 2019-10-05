<article  id="page-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="http://schema.org/Article">

  <header class="entry-header">
    <h2 class="entry-title"><?php the_title(); ?></h2>
  </header>

  <div class="entry-content" itemprop="articleBody">

    <?php the_content(); ?>

  </div>

  <meta itemprop="datePublished" content="<?php echo get_the_date( 'Y-m-d H:i:s', $post->ID ); ?>">
  <meta itemprop="dateModified" content="<?php echo get_the_modified_date( 'Y-m-d H:i:s', $post->ID ); ?>">
  <meta itemprop="author" content="<?php echo bloginfo( 'name' ); ?>">
  <meta itemprop="url" content="<?php echo get_permalink( $post->ID ); ?>">

</article>

<div class="clear"></div>
