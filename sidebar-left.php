<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Skeleton WordPress
 */
?>

<?php if(is_active_sidebar("sidebar-1")) : ?>
<div class="sidebar widget-area sidebar-left" role="complementary">
	<?php dynamic_sidebar('sidebar-1'); ?>
</div><!-- #secondary -->
<?php endif; ?>