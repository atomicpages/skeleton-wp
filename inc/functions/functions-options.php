<?php

// code for image loaders (e.g. colorbox, fancybox, any other developer additions)
// code for sliders (e.g. flexslider, responsiveslides, any other developer additions)
// any other code that needs to be loaded from the administrative panel goes in here...

global $skeleton_wp; // connects redux goodness

/**
 * Determines if an options exists or is set to something other than a blank value
 * @param string $option
 * @return bool
 */
function skeleton_wp_option_isset($option) {
	global $skeleton_wp;
	if(array_key_exists($option, $skeleton_wp) && isset($skeleton_wp[$option])) return true;
	return false;
}

function skeleton_wp_get_option($id) {
	global $skeleton_wp;
	if(skeleton_wp_option_isset($id)) return $skeleton_wp[$id];
	return null;
}