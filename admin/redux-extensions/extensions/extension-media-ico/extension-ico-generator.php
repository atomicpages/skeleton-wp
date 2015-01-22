<?php
/**
 * A redux extension that generates a .ico file using PHP GD library
 * @package ico_generator
 * @author Dennis Thompson
 * @license MIT
 * @version 1.0
 * @see PHP_ICO
 */

// Exit if accessed directly
if(!defined('ABSPATH')) exit;

if(!class_exists("ReduxFramework_Extension_Ico_Media")) {

	class ReduxFramework_Extension_Ico_Media extends ReduxFramework {

		protected $parent;
		public $extension_url;
		public $extension_dir;
		public static $theInstance;

		/**
		 * Class Constructor. Defines the args for the extensions class
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
			$this->field_name = 'ico_media';

			self::$theInstance = $this;

			add_filter('redux/'.$this->parent->args['opt_name'].'/field/class/'.$this->field_name, array(&$this, 'overload_field_path')); // Adds the local field

		}

		public function getInstance() {
			return self::$theInstance;
		}

		// Forces the use of the embedded field path vs what the core typically would use
		public function overload_field_path($field) {
			return dirname(__FILE__).'/'.$this->field_name.'/field_'.$this->field_name.'.php';
		}

	}

}