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
		if($i == 1) { // FIXME: Sloppy, see if there's a better way...
			$footer_id = $id;
		}

		if(is_active_sidebar($footer_id)) {
			$active[] = $i;
		}
	}

	return $active;
}


/**
 * @param string $image
 * @return mixed
 * @author Evan Tam
 * @version 1.0
 */

function skeleton_wp_convert_image($image) {
	$editor = wp_get_image_editor($image);
	if(!is_wp_error($editor)) {
		$editor->resize(16,16,true);
		$editor->save(null, 'image/x-icon'); //find another way to convert file formats
		var_dump($editor);
	}

	return $editor;
}