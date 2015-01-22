<?php

/**
 * @package Skeleton WordPress
 */

/**
 * A functions that is used to get the number of active footer regions
 * @param int $regions
 * @param string $id = "footer-regions-"
 * @return array
 * @author Dennis Thompson
 * @version 1.0
 */
function skeleton_wp_count_active_sidebars($regions, $id = "footer-region") {
	$active = array();
	for($i = 1; $i <= $regions; $i++) {
		$footer_id = $id . "-" . $i;
		if($i == 1) { // FIXME: This seems sloppy, see if there's a better way...
			$footer_id = $id;
		}

		if(is_active_sidebar($footer_id)) {
			$active[] = $i;
		}
	}

	return $active;
}

/**
 * A function that uses WordPress to convert an uploaded image to a favicon
 * @param string $image
 * @return mixed
 * @author Evan Tam
 * @version 1.0
 * @uses WP_Image_Editor
 */
function skeleton_wp_convert_image($image) {
	$editor = wp_get_image_editor($image);
	if(!is_wp_error($editor)) {
		$editor->resize(16,16,true);
		$editor->save($editor->generate_filename(), 'image/x-icon');
	} // TODO: if there is an error, we need to let the user know
	var_dump($editor);

	return $editor;
}