<?php

/**
 * Returns the current year from the server
 * @return bool|string
 * @version 1.0
 * @since 1.0
 */
function skeleton_wp_sc_current_year() {
	return date("Y");
}

/**
 * Returns the name of the WordPress site as stored in the database
 * @return string
 * @version 1.0
 * @since 1.0
 */
function skeleton_wp_sc_site_title() {
	return get_bloginfo("name");
}

/**
 * Returns the URL to WordPress site
 * @return string|void
 */
function skeleton_wp_sc_site_url() {
	return get_bloginfo("url");
}

/**
 * @return string|void
 */
function skeleton_wp_sc_wp_url() {
	return get_bloginfo("wpurl");
}

/**
 * @return string|void
 */
function skeleton_wp_sc_theme_url() {
	return get_bloginfo("template_url");
}

/**
 * @return string
 */
function skeleton_wp_sc_login_url() {
	return wp_login_url();
}

/**
 * @return string
 */
function skeleton_wp_sc_logout_url() {
	return wp_logout_url();
}

/**
 * @return string|void
 */
function skeleton_wp_sc_site_tagline() {
	return get_bloginfo("description");
}

add_shortcode("wp-url", "skeleton_wp_sc_wp_url");
add_shortcode("theme-url", "skeleton_wp_sc_theme_url");
add_shortcode("login-url", "skeleton_wp_sc_login_url");
add_shortcode("logout-url", "skeleton_wp_sc_logout_url");
add_shortcode("site-tagline", "skeleton_wp_sc_site_tagline");
add_shortcode("current-year", "skeleton_wp_sc_current_year");
add_shortcode("site-title", "skeleton_wp_sc_site_title");