<?php

if (!class_exists('WP_Sheet_Editor_CORE_Modules_Init')) {

	class WP_Sheet_Editor_CORE_Modules_Init {

		var $product_directory = null;
		var $freemius_instance = null;

		function __construct($product_directory, $freemius_instance = null, $auto_init = true) {
			$this->product_directory = $product_directory;
			$this->freemius_instance = $freemius_instance;

			if ($auto_init) {
				$this->init();
			}
		}

		/**
		 * Get all modules in the folder
		 * @return array
		 */
		function get_modules_list() {
			$directories = glob($this->product_directory . '/modules/*', GLOB_ONLYDIR);

			if (!empty($directories)) {
				$directories = array_map('basename', $directories);
			}
			$plugin_slug = basename($this->product_directory);
			$package_file = WP_PLUGIN_DIR . '/' . $plugin_slug . '/package.json';
			$package_settings = (file_exists($package_file)) ? json_decode(file_get_contents($package_file), true) : array();

			if (!empty($package_settings['sheetEditorModules'])) {
				// If we're developing locally and the package.json file exists, only load the defined modules
				$directories = array_intersect($directories, array_merge($package_settings['sheetEditorModules']['free'], $package_settings['sheetEditorModules']['pro']));

				// If we're developing locally and the package.json file exists, only load the allowed modules according to the freemius license
				if (is_object($this->freemius_instance) && !$this->freemius_instance->can_use_premium_code__premium_only()) {
					$directories = array_intersect($directories, $package_settings['sheetEditorModules']['free']);
				}
			}

			$parent_plugin_slug = str_replace(array('-premium'), '', $plugin_slug);
			return apply_filters('vg_sheet_editor/modules/' . $parent_plugin_slug . '/list', $directories);
		}

		function init() {

			$modules = $this->get_modules_list();
			if (empty($modules)) {
				return;
			}

			// Load all modules
			foreach ($modules as $module) {
				$paths = array($this->product_directory . "/modules/$module/$module.php");
				if ($module === 'wp-sheet-editor') {
					$paths[] = $this->product_directory . "/modules/$module/dev/$module.php";
				}

				foreach ($paths as $path) {
					if (file_exists($path)) {
						require_once $path;
					}
				}
			}

			$plugin_inc_files = glob(untrailingslashit($this->product_directory) . '/inc/*.php');
			$inc_files = array_merge(glob(untrailingslashit(__DIR__) . '/*.php'), $plugin_inc_files);
			foreach ($inc_files as $inc_file) {
				if (!is_file($inc_file)) {
					continue;
				}

				require_once $inc_file;
			}

			// Not like register_uninstall_hook(), you do NOT have to use a static function.
			$this->freemius_instance->add_action('after_uninstall', array($this, 'on_uninstall'));
		}

		function on_uninstall() {
			do_action('vg_sheet_editor/on_uninstall', $this->product_directory, $this->freemius_instance);
		}

		/**
		 * Creates or returns an instance of this class.
		 *
		 * @return  Foo A single instance of this class.
		 */
		static function get_instance() {
			if (null == WP_Sheet_Editor_CORE_Modules_Init::$instance) {
				WP_Sheet_Editor_CORE_Modules_Init::$instance = new WP_Sheet_Editor_CORE_Modules_Init();
				WP_Sheet_Editor_CORE_Modules_Init::$instance->init();
			}
			return WP_Sheet_Editor_CORE_Modules_Init::$instance;
		}

		function __set($name, $value) {
			$this->$name = $value;
		}

		function __get($name) {
			return $this->$name;
		}

	}

}