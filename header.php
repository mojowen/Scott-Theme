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
    	<h1><a href="/">Scott Riker Duncombe</a> :: <span id="title"><?php echo srd_title(false); ?></span></h1> <!-- should change depending on the subpage -->
    </header>
    <sidebar id="side">
        <a id="photo" href="/about"><img src="<?php echo get_stylesheet_directory_uri(); ?>/stuff/me.jpeg"></a>
    	<h4 id="description"><?php echo get_bloginfo('description'); ?></h4>
    	<a id="about" href="/about">What does that mean?</a>
        <a id="projects_link" href="/">Here's some cool stuff I've built</a>
    	<div id="social">
    		<a href="https://github.com/mojowen" target='_blank'>github</a>
            <a href="http://sduncombe.tumblr.com/" target='_blank'>blog</a>
    		<a href="/resume" target='_blank'>resume</a>
    		<a href="https://facebook.com/srduncombe" target='_blank'>fb</a>
    		<a href="https://twitter.com/sduncombe" target='_blank'>tw</a>
    		<a href="https://www.linkedin.com/in/scottduncombe/" target='_blank'>ln</a>
    	</div>
    	<div id="ask">
			<h5>Want to Build Something</h5>
			<a href="/contact"><h4>Awesome</h4></a>
			<h5>Together?</h5>
    		</h5>
    	</div>
    	<div id="peeps">
    		<h5>Some of the cats I work with<br/>to make amazing things:</h5>
            <a href="http://mollieruskin.com/" target="_blank"><div><img src="<?php echo get_stylesheet_directory_uri(); ?>/stuff/mollie.png"><br/>Mollie Ruskin,<br/>Washington DC</div></a>
            <a href="http://noahmanger.com/" target="_blank"><div><img src="<?php echo get_stylesheet_directory_uri(); ?>/stuff/noah.jpeg"><br/>Noah Manger,<br/>Portland OR</div></a>
            <a href="http://cargocollective.com/bryanchiem/" target="_blank"><div><img src="<?php echo get_stylesheet_directory_uri(); ?>/stuff/bryan.JPG"><br/>Bryan Chiêm,<br/>California</div></a>
    	</div>
    </sidebar>
