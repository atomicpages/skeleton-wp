<?php
/**
 * Skeleton WordPress functions and definitions
 *
 * @package Skeleton WordPress
 */

define("ASSETS_DIR", get_template_directory() . "/assets");
define("NUMBER_OF_FOOTER_REGIONS", 4);

// Add Redux Framework & extras
require get_template_directory() . '/admin/admin-init.php';
// require get_template_directory() . '/inc/custom-header.php';
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/extras.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/jetpack.php';
require get_template_directory() . '/assets/functions/functions-workers.php';

// Set the content width based on the theme's design and stylesheet
if(!isset($content_width)) {
	$content_width = 960; // in pixels
}

if(!function_exists('skeleton_wp_setup')) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function skeleton_wp_setup() {

		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Skeleton WordPress, use a find and replace
		 * to change 'skeleton-wp' to the name of your theme in all the template files
		 */
		load_theme_textdomain('skeleton-wp', get_template_directory() . '/languages');

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		// TODO: Add user generated thumbnail sizes
		add_theme_support('post-thumbnails');
		set_post_thumbnail_size(150, 150, true);

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		//add_theme_support('post-thumbnails');

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(array(
			'primary' => __('Primary Menu', 'skeleton-wp'),
			'secondary' => __("Secondary Menu", "skeleton-wp")
		));

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));

		/*
		 * Enable support for Post Formats.
		 * See http://codex.wordpress.org/Post_Formats
		 */
		add_theme_support('post-formats', array('status', 'quote', 'gallery', 'image', 'video', 'audio', 'link', 'aside', 'chat'));

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background', apply_filters('skeleton_wp_custom_background_args', array(
				'default-color' => 'ffffff',
				'default-image' => ''
			))
		);
	}
}

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function skeleton_wp_widgets_init() {
	$args = array(
		'name'          => __('Sidebar %d'),
		'id'            => 'sidebar',
		'description'   => 'Sidebars only visible when active and appropriate content layout is active',
		'class'         => 'sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<p class="widget-title sidebar-widget-title">',
		'after_title'   => '</p>'
	);
	register_sidebars(2, $args);

}

function skeleton_wp_footer_wigets_init() {
	$args = array(
		'name'          => __('Footer Region %d'),
		'id'            => 'footer-region',
		'description'   => 'Use up to four footer regions for your custom footer!',
		'class'         => 'footer-region',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<p class="widget-title footer-widget-title">',
		'after_title'   => '</p>'
	);
	register_sidebars(NUMBER_OF_FOOTER_REGIONS, $args);
}

/**
 * Enqueue scripts and styles.
 */
function skeleton_wp_scripts() {
	// TODO: if use fancybox option is true, load scripts here
	wp_enqueue_style('skeleton-wp-style', get_stylesheet_uri());
	wp_enqueue_script('skeleton-wp-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true);
	wp_enqueue_script('skeleton-wp-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true);

	if(is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}

function skeleton_wp_styles() {
	// enqueue custom styles here...
	// TODO: If fancybox is enabled, load styles here
}

/**
 * Generates the footer regions and displays them with the appropriate HTML
 * @return bool
 * @uses skeleton_wp_count_active_sidebars()
 * @see assets/functions/functions-workers.php
 * @author Dennis Thompson
 */
function skeleton_wp_get_footer_regions() {
	$active_regions = skeleton_wp_count_active_sidebars(NUMBER_OF_FOOTER_REGIONS);
	$columns = 16 / count($active_regions); // FIXME: causing a division by zero warning
	// FIXME: There should be better error handling here. We need to let the user know what happened
	if($columns > 1) return false; // we have a problem that we can't recover from
	$column_map = array(
		16 => "sixteen",
		8 => "eight",
		5 => "five",
		4 => "four"
	);

	for($i = 0; $i < count($active_regions); $i++) {
		$classes = array($column_map[$columns]);
		if(count($active_regions) == 1) {
			array_push($classes, "alpha", "omega");
		} elseif($i == 0) {
			array_push($classes, "alpha");
		} elseif($i == count($active_regions)) {
			array_push($classes, "omega");
		}
		print '<div class="' . implode(" ", $classes) . '">' . dynamic_sidebar("footer-region-" . $active_regions[$i]) . '</div>';
	}

}

add_action('widgets_init', 'skeleton_wp_widgets_init');
add_action('widgets_init', 'skeleton_wp_footer_wigets_init');
add_action('after_setup_theme', 'skeleton_wp_setup');
add_action('wp_enqueue_scripts', 'skeleton_wp_scripts');
add_action("wp_enqueue_style", "skeleton_wp_styles");
