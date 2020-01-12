<?php

if( !current_user_can( 'admin' ) && !current_user_can( 'administrator' ) ) :

  $url = get_site_url() . '/coming-soon';
  wp_redirect($url);
  exit();

else :

?>
<!DOCTYPE html>
<html lang="<?php bloginfo( 'language' ); ?>">

<head>

  <meta charset="utf-8" />
  <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge" /><![endif]-->
  <meta name="author" content="<?php bloginfo( 'name' ); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <link rel="profile" href="http://gmpg.org/xfn/11" />

  <link rel="schema.DCTERMS" href="http://purl.org/dc/terms/" />
  <meta name="DC.title" lang="<?php bloginfo( 'language' ); ?>" content="<?php ( is_front_page() ) ? bloginfo( 'name' ) : wp_title( '-', true, 'right' ); ?>" />
  <meta name="DC.creator" content="" />
  <meta name="DC.creator.Address" content="" />
  <meta name="DC.publisher" content="" />
  <meta name="DC.publisher.Address" content="" />
  <meta name="DC.language" content="<?php bloginfo( 'language' ); ?>" />

  <meta name="format-detection" content="telephone=no" />

  <!--[if lt IE 9]>
    <script src="<?php echo THEME_URL; ?>/javascripts/vendor/html5shiv.min.js"></script>
  <![endif]-->

  <meta name="ajax-url" content="<?php echo esc_attr( admin_url( 'admin-ajax.php' ) ); ?>" />

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
  <div class="site-header__middle">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="site-header__search">
            <form class="site-header__search-form" role="search" method="get" action="<?php echo home_url(); ?>">
              <input class="site-header__search-field" type="text" name="s" id="s" placeholder="<?php _e( 'Search', 'vintageworld' ); ?>" value="<?php echo get_search_query(); ?>" />
              <input class="site-header__search-button" type="submit" value="L" />
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="site-header__bottom">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="site-header__logo">
            <a class="site-header__logo-link" href="<?php echo home_url('/'); ?>" title="<?php _e('Home', 'vintageworld') ?> - Vintage World">
              <h1 class="site-header__logo-title"><?php _e('Vintage World', 'vintageworld') ?></h1>
            </a>
          </div>
          <nav class="site-header__menu-container">
            <?php wp_nav_menu( array( 'theme_location' => 'fomenu', 'depth' => 1, 'menu_id' => 'fejlec-menu' ) ); ?>

          </nav>
          <nav class="site-header__languages-wrapper">
            <?php
            $languages = icl_get_languages('skip_missing=0&orderby=code');
            if(!empty($languages)) :
            ?>
            <ul class="site-header__languages-menu">
              <?php
              foreach($languages as $language) :
              ?>
              <li class="site-header__languages-item">
                <?php
                if(!$language['active']) :
                ?>
                <a class="site-header__languages-link" href="<?php echo $language['url']; ?>" title="<?php echo  icl_disp_language($language['native_name']); ?>"><?php echo icl_disp_language($language['language_code']); ?></a>
                <?php
                endif;
                ?>
                <?php
                if($language['active']) :
                ?>
                <span class="site-header__languages-current" title="<?php echo icl_disp_language($language['native_name']) . '&nbsp;(' . __('current', 'vintageworld') . ')'; ?>"><?php echo icl_disp_language($language['language_code']); ?></span>
                <?php
                endif;
                ?>
              </li>
              <?php
              endforeach;
              ?>
            </ul>
            <?php
            endif;
            ?>
          </nav>
          <a class="site-header__button-search" href="javascript:;" title="<?php _e('Search', 'vintageworld') ?>"></a>
          <a class="site-header__button-favorites" href="<?php echo get_page_link( 806 ); ?>" title="<?php _e('Favorites', 'vintageworld') ?>"></a>
          <a class="site-header__button-member" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('My account', 'vintageworld') ?>"></a>
          <a class="site-header__button-cart" href="<?php echo wc_get_cart_url(); ?>" title="<?php _e('Cart', 'vintageworld') ?>">
            <span class="site-header__button-cart-badge"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
          </a>
          <a id="open-menu" class="site-header__hamburger-icon" href="#menu">
            <span class="hamburger-icon__bar"></span>
          </a>
        </div>
      </div>
    </div>
  </div>
</header>
<?php
endif;
?>