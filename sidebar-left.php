<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Skeleton WordPress
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<div class="sidebar widget-area sidebar-left" role="complementary">
	<?php dynamic_sidebar('sidebar-1'); ?>
</div><!-- #secondary -->
