<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Skeleton WordPress
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
<?php wp_head(); ?>
<!-- TEMPORARY -->
<link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700,100' rel='stylesheet' type='text/css'>
</head>

<body <?php body_class(); ?>>
<div class="wrapper header">
	<div class="container header">
		<a class="skip-link screen-reader-text" href="#content"><?php _( 'Skip to content', 'skeleton-wp' ); ?></a>
		<header role="banner">
			<div class="sixteen columns inner-header">
				<div class="branding">
					<h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
					<h2 class="site-description"><?php bloginfo('description'); ?></h2>
				</div>

				<nav class="main-navigation" role="navigation">
					<button class="menu-toggle" aria-controls="menu" aria-expanded="false"><?php _e('Primary Menu', 'skeleton-wp'); ?></button>
					<?php wp_nav_menu(array('theme_location' => 'primary')); ?>
				</nav>
			</div> <!-- /.sixteen.columns.inner-header -->
		</header> <!-- /header -->
	</div><!-- /.container.header -->
</div><!-- /.wrapper.header -->

<div class="wapper main">
	<main class="content">
