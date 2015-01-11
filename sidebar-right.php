<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Skeleton WordPress
 */

if ( ! is_active_sidebar( 'sidebar-2' ) ) {
	return;
}
?>

<div class="sidebar widget-area sidebar-right" role="complementary">
	<?php dynamic_sidebar('sidebar-2'); ?>
</div><!-- #secondary -->
