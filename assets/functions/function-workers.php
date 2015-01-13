<?php

/**
 * A functions that is used to get the number of active footer regions
 * @param int $regions
 * @param string $id = "footer-regions-"
 * @return array
 * @author Dennis Thompson
 * @version 1.0
 */
function skeleton_wp_count_active_sidebars($regions, $id = "footer-region-") {
	$active = array();
	for($i = 1; $i <= $regions; $i++) {
		if(is_active_sidebar($id . $i)) {
			$active[] = $i;
		}
	}

	return $active;
}