<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
    <html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
    <html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
    <html <?php language_attributes(); ?>>
<!--<![endif]-->

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width">
    <title><?php echo srd_title(); ?></title>
    <link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri();?>/stuff/icon.ico" />
  <?php wp_head(); ?>
  <?php open_graph_crap(); ?>
</head>

<body <?php body_class(); ?>>

  <div id="page" >

    <header id="menu">
        <h1><a href="/"><?php echo get_bloginfo('title'); ?></a> :: <span id="title"><?php echo srd_title(false); ?></span></h1> <!-- should change depending on the subpage -->
    </header>
    <sidebar id="side">
        <a id="photo" href="/about"><img src="<?php echo get_stylesheet_directory_uri(); ?>/stuff/me.jpg"></a>
        <h4 id="description"><?php echo get_bloginfo('description'); ?></h4>
        <a id="projects_link" href="/">Here's some cool stuff I've built</a>
        <div id="social">
            <a href="https://github.com/" target='_blank'>github</a>
            <a href="http://tumblr.com/" target='_blank'>blog</a>
            <!-- <a href="/" target='_blank'>resume</a> -->
            <a href="https://facebook.com/" target='_blank'>fb</a>
            <a href="https://twitter.com/" target='_blank'>tw</a>
            <a href="https://www.linkedin.com/in//" target='_blank'>ln</a>
        </div>
        <div id="peeps">
            <h5>Some of the cats I work with<br/>to make amazing things:</h5>
            <a href="/" target="_blank"><div><img src="<?php echo get_stylesheet_directory_uri(); ?>/stuff/friend_1.jpg"><br/>One Friend,<br/>Friend's Place</div></a>
            <a href="/" target="_blank"><div><img src="<?php echo get_stylesheet_directory_uri(); ?>/stuff/friend_2.jpg"><br/>Two Friend,<br/>Friend's Place</div></a>
            <a href="/" target="_blank"><div><img src="<?php echo get_stylesheet_directory_uri(); ?>/stuff/friend_3.jpg"><br/>Three Friend,<br/>Friend's Place</div></a>
        </div>
    </sidebar>
