<!DOCTYPE html>
<html lang="<?php bloginfo( 'language' ); ?>">

<head>

<meta charset="utf-8" />
<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge" /><![endif]-->
<meta name="author" content="<?php bloginfo( 'name' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<meta name="format-detection" content="telephone=no">
<link rel="profile" href="http://gmpg.org/xfn/11">

<!-- Dublin Core META Tags -->
<link rel="schema.DCTERMS" href="http://purl.org/dc/terms/"/>
<meta name="DC.title" lang="<?php bloginfo( 'language' ); ?>" content="<?php ( is_front_page() ) ? bloginfo( 'name' ) : wp_title( '-', true, 'right' ); ?>">
<meta name="DC.language" content="<?php bloginfo( 'language' ); ?>"/>
<meta name="DC.Publisher" content="<?php echo get_option('general_option_companyname'); ?>" />
<meta name="DC.Creator" content="<?php echo get_option('general_option_creator'); ?>" />
<meta name="DC.Type" content="Text" />
<meta name="DC.Format" content="text/html" />
<meta name="DC.Format.MIME" content="text/html" />
<meta name="DC.Format.SysReq" content="Internet browser" />
<meta name="DC.Source" content="<?php echo home_url( '/' ); ?>">
<meta name="DC.Coverage" content="World">
<meta name="DC.Identifier" content="<?php echo home_url( '/' ); ?>" />
<?php $keyword = get_option( 'general_option_keyword' ); ?>
<?php if( $keyword ): ?>
<meta name="DC.Subject.Keyword" content="<?php echo $keyword; ?>" />
<?php endif; ?>

<?php if( $keyword && is_home() ): ?>
<meta name="keywords" content="<?php echo $keyword; ?>" />
<?php endif; ?>
<!--[if lt IE 9]>
  <script src="<?php echo THEME_URL; ?>/javascripts/vendor/html5shiv.min.js"></script>
<![endif]-->
<?php wp_head(); ?>
<style type="text/css" media="print">
  @media print { body { background:white; color:black; margin:0; } }
</style>
</head>

<body <?php body_class(); ?>>
<main id="main">
<div id="site-canvas">

<section class="comingsoon-section">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="comingsoon__container">
          <div class="comingsoon__logo-wrapper">
            <img class="comingsoon__logo-img" src="<?php echo get_template_directory_uri(); ?>/images/comingsoon-logo.png" />
            <span class="comingsoon__logo-text">roses</span>
          </div>
          <div class="comingsoon__title-wrapper">
            <h1 class="comingsoon__title">Coming Soon</h1>
          </div>
          <?php if( current_user_can( 'administrator' ) || current_user_can( 'admin' ) ):?>
          <div class="comingsoon__subscribe">
            <h2 class="comingsoon__subtitle">Early bird discount</h2>
            <span class="comingsoon__divider"></span>
            <span class="comingsoon__offer">Join us and get 20% off your first purchase!</span>
            <p class="comingsoon__desc">Sign up to our newsletter now, and we send you a coupon code providing you 20% off from your first purchase! </p>
            <form class="comingsoon__newsletter" action="#" method="POST">
              <label class="comingsoon__formlabel">Sign up to our Newsletter!</label>
              <input type="email" class="comingsoon__forminput" placeholder="Your e-mail adress" required>
              <input type="submit" value="Join!" class="comingsoon__formsubmit">
            </form>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="comingsoon__footer">
  <img class="comingsoon__footer-img" src="<?php echo get_template_directory_uri(); ?>/images/comingsoon-footer.jpg" />
</div>

</div><!-- #site-canvas -->
</main><!-- #main -->
</body>