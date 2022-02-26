<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package eve
 */

do_action('eve_about');

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="dns-prefetch" href="//www.googletagmanager.com">
<link rel="dns-prefetch" href="//ajax.googleapis.com">
<?php wp_head(); ?>
<meta name="theme-color" content="#2679D8">
<link rel="icon" sizes="192x192" href="<?php echo get_template_directory_uri(); ?>/img/eve-highres.png?v=<?php echo eve_verison_control(); ?>">
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="site">

<header class="site-header header">
	<div class="ctn max">
		<div class="header__top">
			<div class="brand">
				<a class="brand-uri" href="<?php echo get_site_url(); ?>">
					<svg width="60" height="60"><use xlink:href="#9aid-logo"></use></svg>
				</a>
			</div>
			<div></div>
		</div>
		<!-- <nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><span></span><span></span><span></span></button>
			<?php
			wp_nav_menu( array(
				'theme_location' => 'header-menu',
				'menu_id'        => 'header-menu',
				'container'      => false
			) );
			?>
		</nav> -->
	</div>
</header>

<div class="site-content">
