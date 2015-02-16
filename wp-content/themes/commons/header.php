<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

  <head>
    <meta charset="utf-8">

    <?php // force Internet Explorer to use the latest rendering engine available ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title><?php wp_title(''); ?></title>

    <?php // mobile meta (hooray!) ?>
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <?php // icons & favicons (for more: http://www.jonathantneal.com/blog/understand-the-favicon/) ?>
    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-touch.png">
    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png?v=2">
    <!--[if IE]>
      <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
    <![endif]-->
    <!-- or, set /favicon.ico for IE10 win -->
    <meta name="msapplication-TileColor" content="#f01d4f">
    <meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/win8-tile-icon.png">

    <link href='http://fonts.googleapis.com/css?family=Raleway:400,700|Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

    <?php // wordpress head functions ?>
    <?php wp_head(); ?>
    <?php // end of wordpress head ?>

    <?php // drop Google Analytics Here ?>
    <?php // end analytics ?>

  </head>

  <body <?php body_class(); ?>>

    <div id="container">

      <header class="header" role="banner">

        <div id="inner-header" class="wrap clearfix">


        </div> <!-- end #inner-header -->

        <div class="mobile-menu">
          <div class="wrap">
            <?php if ( is_user_logged_in() ) { ?>
              <div class="inner">
                <?php
                  $current_user = wp_get_current_user();
                  $url = get_bloginfo( 'url' );
                  echo "<div class='username'><a href='".$url."/people/".$current_user->user_login."'>".$current_user->display_name."</a> <span class='logout-link'>(<a href='".wp_logout_url()."'>log out</a>)</span></div>";
                ?>
                <?php wp_nav_menu( array('theme_location' => 'main-nav' )); ?>
              </div>
              <div class="clearfix bar">
                <div class="mobile-site-title"><?php echo get_bloginfo('name'); ?></div>
                <div class="nav-toggle"><div></div></div>
              </div>
            <?php } else { ?>
              <div class="clearfix bar">
                <div class="mobile-site-title"><?php echo get_bloginfo('name'); ?></div>
                <div class="login"><a href="<?php bloginfo( 'url' ); ?>/wordpress/wp-login.php">Login To The Commons</a></div>
              </div>
            <?php } ?>
          </div>
        </div>

      </header> <!-- end header -->
