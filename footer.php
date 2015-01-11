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

		</div><!-- /.sixteen.columns.inner-footer -->
		<div class="sixteen columns copyright">
			<!-- TODO: if copyright not set in admin options, show the default copyright -->
			<p class="copyright">&copy; <?php print date("Y"); ?> <?php bloginfo("name") ?></p>
		</div><!-- /.sixteen.columns.copyright -->
	</footer><!-- /.container.footer -->
</div><!-- /.wrapper.footer -->
<?php wp_footer(); ?>
</body>
</html>
