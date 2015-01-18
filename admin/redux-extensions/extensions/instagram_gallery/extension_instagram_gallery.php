<?php
/**
 * A redux extension that creates an Instagram gallery for you with only a few simple
 * steps to configure!
 * @package instagram_gallery
 * @author Dennis Thompson
 * @license MIT
 * @version 1.0
 */

// TODO: Add namespacing when PHP 5.3 is forced for all redux users

// namespace InstagramGallery;

// Exit if accessed directly
if(!defined('ABSPATH')) exit;

if(!class_exists("ReduxFramework_Extension_Instagram_Gallery")) {

	class ReduxFramework_Extension_Instagram_Gallery extends ReduxFramework {

		protected $parent;
		public $extension_url;
		public $extension_dir;
		public static $theInstance;

		/**
		 * Class Constructor. Defines the args for the extions class
		 *
		 * @since 1.0.0
		 * @access public
		 * @param array $sections Panel sections.
		 * @param array $args Class constructor arguments.
		 * @param array $extra_tabs Extra panel tabs.
		 */
		public function __construct($parent) {
			$this->parent = $parent;
			if(empty($this->extension_dir)) {
				$this->extension_dir = trailingslashit(str_replace('\\', '/', dirname(__FILE__)));
			}
			$this->field_name = 'instagram_gallery';

			self::$theInstance = $this;

			add_filter('redux/'.$this->parent->args['opt_name'].'/field/class/'.$this->field_name, array(&$this, 'overload_field_path')); // Adds the local field

		}

		public function getInstance() {
			return self::$theInstance;
		}

		// Forces the use of the embeded field path vs what the core typically would use
		public function overload_field_path($field) {
			return dirname(__FILE__).'/'.$this->field_name.'/field_'.$this->field_name.'.php';
		}

	}

}