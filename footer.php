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
		<div class="footer__by fbx fbx-c">
			<svg width="20" height="20"><use xlink:href="#9gag-logo"></use></svg>
			<div>Created by 9GAG with ❤️</div>
		</div>
		<div class="footer__content">This website is maintained by the community.</div>
		<div class="footer__help">
			<h2 class="footer__help-title">Would you like to help?</h2>
			<div><a href="https://discord.gg/kVX8z86Y">Discord</a></div>
		</div>
		<div class="footer__ver"><?= date('Y') ?> ver. 0.0.12</div>
	</div>
</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>