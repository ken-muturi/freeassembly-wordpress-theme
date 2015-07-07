<?php
/**
 * The Header for our theme.
 * Displays all of the <head> section and everything up till <div id="main">
 */
?>

<!DOCTYPE html>
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
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo esc_attr( get_bloginfo( 'name', 'display' ) );?> </title>
<meta name="description" content="">
<meta name="author" content="">

<link href='http://fonts.googleapis.com/css?family=Arvo:400|Open+Sans:400,700,300' rel='stylesheet' type='text/css'>
<!--[if IE]>
	<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400" rel="stylesheet" type="text/css">
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300" rel="stylesheet" type="text/css">
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:700" rel="stylesheet" type="text/css">
<![endif]-->

<link href="<?php echo get_template_directory_uri(); ?>/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo get_template_directory_uri(); ?>/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo get_template_directory_uri(); ?>/style.css" rel="stylesheet">
<link href="<?php echo get_template_directory_uri(); ?>/css/prettyPhoto.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo get_template_directory_uri(); ?>/css/zocial.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo get_template_directory_uri(); ?>/css/mscrollbar.css" rel="stylesheet" type="text/css"/>

<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!--[if IE 7]>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/font-awesome-ie7.min.css">
<![endif]-->

<?php wp_head(); ?>

</head>
<body>
<!--header-->
<div class="header">
	<div class="top-bar">
	<div class='container'>
		<div class="span6 soc_icons pull-right">
			<?php get_search_form(); ?>
			<a title="facebook" href="https://www.facebook.com/mainakiai.sr" target="_blank"><div class="icon_facebook"></div></a>
			<a title="twitter" href="http://twitter.com/MainaKiai_UNSR" target="_blank"><div class="icon_t"></div></a>
			<a title="flickr" href="http://www.flickr.com/photos/mainakiai/" target="_blank"><div class="icon_flickr"></div></a>
			<a title="rss" href="<?php echo bloginfo('rss2_url'); ?>" target="_blank"><div class="icon_rss"></div></a>
		</div>
	</div>
	</div>


	<div class="container">
		<!--logo-->
		<div id='logo' class="logo">
			 <a href="<?php echo bloginfo('url'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/logo.png" alt="" /></a>  
		</div>		
		<!--menu-->
		<nav id="main_menu">
		<div class="menu_wrap">
			<?php wp_nav_menu( array( 'menu' => 'Main Menu', 'container' => '', 'menu_class' => 'nav sf-menu',  'menu_id' => 'main-menu') ); ?>   					
		</div>
		</nav>			
	</div>
</div>
<!--//header-->
<!--container wrapper-->
<div class="container wrapper">