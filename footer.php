<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package eve
 */

?>

</div>
<footer class="site-footer footer">
	<div class="ctn max">
		<div class="footer__brand">
			<div class="brand">
				<a class="brand-uri" href="<?php echo get_site_url(); ?>">
					<svg width="90" height="90"><use xlink:href="#9aid-logo-light"></use></svg>
				</a>
			</div>
			<div class="footer__brand-motto">Providing information and fighting fake news.</div>
		</div>
		<div class="footer__by fbx fbx-c">
			<svg width="20" height="20"><use xlink:href="#9gag-logo"></use></svg>
			<div>Created by 9GAG with ❤️</div>
		</div>
		<div class="footer__content">This website is maintained by the community.</div>
		<div class="footer__help">
			<h2 class="footer__help-title">Would you like to help?</h2>
			<div class="footer__help-menu"><?php

				wp_nav_menu( array(
					'theme_location' => 'footer-menu',
					'menu_id'        => 'footer-menu',
					'container'      => false
				) );

			?></div>
		</div>
		<div class="footer__ver fbx fbx-csb">
			<div><?= date('Y') ?> ver. 0.0.12</div>
			<div>Last updated 1 day ago</div>
		</div>
	</div>
</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>