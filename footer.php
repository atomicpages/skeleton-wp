<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Skeleton WordPress
 */
?>
		</div><!-- /sixteen columns inner-content -->
	</div><!-- /main.container.content -->
</div><!-- /.wrapper.main -->

<div class="wrapper footer">
	<footer class="container footer" role="contentinfo">
		<div class="sixteen columns inner-footer">
			<?php skeleton_wp_get_footer_regions() ?>
		</div><!-- /.sixteen.columns.inner-footer -->
		<div class="sixteen columns copyright">
			<?php if($copyright = skeleton_wp_get_option("skeleton_wp_copyright")) : ?>
				<p class="copyright"><?php print do_shortcode($copyright) ?></p>
			<?php endif; ?>
		</div><!-- /.sixteen.columns.copyright -->
	</footer><!-- /.container.footer -->
</div><!-- /.wrapper.footer -->
<?php wp_footer(); ?>
</body>
</html>
