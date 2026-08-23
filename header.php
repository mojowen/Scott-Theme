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
    <link rel="icon" href="<?php echo get_stylesheet_directory_uri(); ?>/stuff/favicons/favicon.svg" type="image/svg+xml">
    <link rel="icon" href="<?php echo get_stylesheet_directory_uri(); ?>/stuff/favicons/favicon-32.png" sizes="32x32">
    <link rel="apple-touch-icon" href="<?php echo get_stylesheet_directory_uri(); ?>/stuff/favicons/favicon-180.png">
  <?php wp_head(); ?>
  <?php open_graph_crap(); ?>
</head>

<body <?php body_class(); ?>>

  <div id="page" >

    <header id="menu">
        <h1><a href="/"><?php echo get_bloginfo('title'); ?></a> :: <span id="title"><?php echo srd_title(false); ?></span></h1> <!-- should change depending on the subpage -->
    </header>
    <sidebar id="side">
        <a id="photo" href="/about"><img src="<?php echo esc_url( get_theme_mod( 'scott_profile_photo', get_stylesheet_directory_uri() . '/stuff/me.jpg' ) ); ?>"></a>
        <h4 id="description"><?php echo get_bloginfo('description'); ?></h4>
        <a id="projects_link" href="/">Here's some cool stuff I've built</a>
        <div id="social">
            <?php foreach ( scott_social_links() as $link ) : ?>
                <a href="<?php echo esc_url( $link['url'] ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $link['label'] ); ?></a>
            <?php endforeach; ?>
        </div>
    </sidebar>
