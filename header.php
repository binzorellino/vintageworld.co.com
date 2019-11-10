<!DOCTYPE html>
<html lang="<?php bloginfo( 'language' ); ?>">

<head>

<meta charset="utf-8" />
<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge" /><![endif]-->
<meta name="author" content="<?php bloginfo( 'name' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<link rel="profile" href="http://gmpg.org/xfn/11">

<link rel="schema.DCTERMS" href="http://purl.org/dc/terms/"/>
<meta name="DC.title" lang="<?php bloginfo( 'language' ); ?>" content="<?php ( is_home() ) ? bloginfo( 'name' ) : wp_title( '-', true, 'right' ); ?>">
<meta name="DC.creator" content=""/>
<meta name="DC.creator.Address" content=""/>
<meta name="DC.publisher" content=""/>
<meta name="DC.publisher.Address" content=""/>
<meta name="DC.language" content="<?php bloginfo( 'language' ); ?>"/>

<meta name="format-detection" content="telephone=no">

<!--[if lt IE 9]>
  <script src="<?php echo THEME_URL; ?>/javascripts/vendor/html5shiv.min.js"></script>
<![endif]-->

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
<main id="main">
<div id="site-canvas">

<header class="site-header">
  <div class="site-header__top">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <span class="site-header__message">Get your rosebox just in 1 day!</span>
        </div>
      </div>
    </div>
  </div>
  <div class="site-header__bottom">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="site-header__logo">
            <a class="site-header__logo-link" href="<?php echo home_url('/'); ?>" title="<?php _e('Home', TEXTDOMAIN) ?> - Vintage World">
              <h1 class="site-header__logo-title"><?php _e('Vintage World', TEXTDOMAIN) ?></h1>
            </a>
          </div>
          <nav class="site-header__menu-container">
            <?php wp_nav_menu( array( 'theme_location' => 'fomenu', 'depth' => 1, 'menu_id' => 'fejlec-menu' ) ); ?>

          </nav>
          <a class="site-header__button-search" href="javascript:;" title="<?php _e('SEARCH', TEXTDOMAIN) ?>"></a>
          <a class="site-header__button-favorites" href="javascript:;" title="<?php _e('FAVORITES', TEXTDOMAIN) ?>"></a>
          <a class="site-header__button-member" href="javascript:;" title="<?php _e('ACCOUNT', TEXTDOMAIN) ?>"></a>
          <a class="site-header__button-cart" href="javascript:;" title="<?php _e('CART', TEXTDOMAIN) ?>">
            <span class="site-header__button-cart-badge">0</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</header>