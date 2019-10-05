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
