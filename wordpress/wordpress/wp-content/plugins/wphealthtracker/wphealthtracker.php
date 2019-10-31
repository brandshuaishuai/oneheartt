<?php
/**
 * WordPress Health Tracker
 *
 * @package     WordPress Health Tracker
 * @author      Jake Evans
 * @copyright   2018 Jake Evans
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: WordPress Health Tracker
 * Plugin URI: https://www.jakerevans.com
 * Description: The Ultimate Health, Fitness, Diet, and Goal-Tracking Plugin for WordPress!
 * Author: Jake Evans
 * Version: 1.0.3
 * Author URI: https://www.jakerevans.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}  // Exit if accessed directly

/* FILTERS */

	/*
		----GENERIC/MULTI-LOCATION FILTERS----

		---SPECIFIC ONE-OFF FILTERS---
			1. wphealthtracker-data-vitals-enter-and-view - class-vitals-forms-actual.php - output_vitals_enter_content() - allows ability to add content at the bottom of the 'Enter Data For' Section, and each individual entry in the 'View & Edit Saved Data' Section of the Vitals tab.

			2. wphealthtracker-data-diet-enter-and-view-bottom - wphealthtracker-diet-ajax.php - wphealthtracker_selecteduser_diet_action_callback() - allows ability to add content directly below the 'Files' row on each individual food item. Mainly intended for the 'Vitamins & Minerals' Extension.

			3. wphealthtracker-data-diet-enter-and-view-top - wphealthtracker-diet-ajax.php - wphealthtracker_selecteduser_diet_action_callback() - allows ability to add content directly above the 'Food Item' row on each individual food item. Mainly intended for the 'Nutrition Lookup' Extension.
	*/

/* END OF FILTERS */

/* TRANSIENTS */

	/*
		*****NOTES*****
			1. Any DB Query that has the wpuserid in it will have it's corresponding transient prefixed with that wpuserid, like: 'wpht_'.$wpuserid.'_' .blahblahblah...
		*****END NOTES*****


		---class-stats-vitals-form.php---
			$transient_name = 'wpht_' . md5('SELECT * FROM 'wphealthtracker_users' ORDER BY firstname');

			$transient_name = 'wpht_' . md5('SELECT * FROM wphealthtracker_general_settings');
		---end class-stats-vitals-form.php---

		---class-vitals-form.php---
			$transient_name = 'wpht_' . md5('SELECT * FROM 'wphealthtracker_users' ORDER BY firstname');

			$transient_name = 'wpht_' . md5('SELECT * FROM wphealthtracker_general_settings');
		---end class-vitals-form.php---

		---class-diet-form.php---
			$transient_name = 'wpht_' . md5('SELECT * FROM 'wphealthtracker_users' ORDER BY firstname');

			$transient_name = 'wpht_' . md5('SELECT * FROM wphealthtracker_general_settings');
		---end class-diet-form.php---


		---class-save-vitals-data.php---
			$transient_name = 'wpht_'.$wpuserid.'_' . md5( 'SELECT * FROM '.wphealthtracker_user_daily_data_vitals.' WHERE wpuserid = '.$wpuserid);
		---end class-save-vitals-data.php---

		---wphealthtracker-vitals-ajax.php---

			$transient_name = 'wpht_'.$wpuserid.'_' . md5( 'SELECT * FROM '.wphealthtracker_users.' WHERE wpuserid = '.$wpuserid);

			$transient_name = 'wpht_'.$wpuserid.'_' . md5( 'SELECT * FROM '.wphealthtracker_user_daily_data_vitals.' WHERE wpuserid = '.$wpuserid.' ORDER BY humandate DESC LIMIT 8');

			$transient_name = 'wpht_' . md5( 'SELECT * FROM '.wphealthtracker_user_daily_data_vitals.' WHERE wpuserid = '.$wpuserid);

			// Special Cases - there are 3 possible transients that could be created in the wphealthtracker_jre_selecteduser_vitals_filter_data_action_callback() function, all based on the 'Filter Data' Drop-down box. The only difference is the LIMIT number. The LIMIT number is always one more than each of the three options in the drop-down box, to account for the removal of the current day's data entry, if retrieved.

			$transient_name = 'wpht_'.$wpuserid.'_' . md5( 'SELECT * FROM '.wphealthtracker_user_daily_data_vitals.' WHERE wpuserid = '.$wpuserid.' ORDER BY humandate DESC LIMIT 31');

			$transient_name = 'wpht_'.$wpuserid.'_' . md5( 'SELECT * FROM '.wphealthtracker_user_daily_data_vitals.' WHERE wpuserid = '.$wpuserid.' ORDER BY humandate DESC LIMIT 61');

			$transient_name = 'wpht_'.$wpuserid.'_' . md5( 'SELECT * FROM '.wphealthtracker_user_daily_data_vitals.' WHERE wpuserid = '.$wpuserid.' ORDER BY humandate DESC LIMIT 91');
		---end wphealthtracker-vitals-ajax.php---

		---wphealthtracker-diet-ajax.php---

			$transient_name = 'wpht_'.$wpuserid.'_' . md5( 'SELECT * FROM '.wphealthtracker_users.' WHERE wpuserid = '.$wpuserid);

			$transient_name = 'wpht_'.$wpuserid.'_' . md5( 'SELECT * FROM '.wphealthtracker_user_daily_data_diet.' WHERE wpuserid = '.$wpuserid);

		---end wphealthtracker-diet-ajax.php---

		---wphealthtracker-stats-vitals-ajax.php---
			$transient_name = 'wpht_' . md5( 'SELECT * FROM '.wphealthtracker_user_daily_data_vitals.' WHERE wpuserid = '.$wpuserid);
		---end wphealthtracker-stats-vitals-ajax.php---

		---class-dashboards.php---
			$transient_name = 'wpht_'.$wpuserid.'_' . md5( 'SELECT * FROM 'wphealthtracker_users' WHERE wpuserid = '.$userid);
		---end class-dashboards.php---
	*/

/* END OF TRANSIENTS */

global $wpdb;

/* REQUIRE STATEMENTS */
	require_once 'includes/class-wphealthtracker-general-functions.php';
	require_once 'includes/class-wphealthtracker-general-ajax-functions.php';
	require_once 'includes/vitals/wphealthtracker-vitals-ajax.php';
	require_once 'includes/diet/class-wphealthtracker-diet-ajax-functions.php';
	require_once 'includes/users/class-wphealthtracker-users-ajax-functions.php';
	require_once 'includes/exercise/class-wphealthtracker-exercise-ajax-functions.php';
	require_once 'includes/diet/wphealthtracker-diet-functions.php';
	require_once 'includes/users/wphealthtracker-users-functions.php';
	require_once 'includes/exercise/wphealthtracker-exercise-functions.php';
	require_once 'includes/vitalstats/wphealthtracker-stats-vitals-ajax.php';
	require_once 'includes/dietstats/class-wphealthtracker-stats-diet-ajax-functions.php';
	require_once 'includes/exercisestats/class-wphealthtracker-stats-exercise-ajax-functions.php';
/* END REQUIRE STATEMENTS */

// CONSTANT DEFINITIONS //
	// Plugin Version Number.
	define( 'WPHEALTHTRACKER_VERSION_NUM', '1.0.3' );

	// Root plugin folder URL of this plugin.
	define( 'WPHEALTHTRACKER_ROOT_URL', plugins_url() . '/wphealthtracker/' );

	// Grabbing database prefix.
	define( 'WPHEALTHTRACKER_PREFIX', $wpdb->prefix );

	// Root plugin folder directory for this plugin
	// define( 'WPHEALTHTRACKER_ROOT_DIR', ABSPATH.'wp-content/plugins/wphealthtracker/' ).
	define( 'WPHEALTHTRACKER_ROOT_DIR', plugin_dir_path( __FILE__ ) );

	// Root Classes Directory for this plugin.
	define( 'WPHEALTHTRACKER_CLASS_DIR', WPHEALTHTRACKER_ROOT_DIR . 'includes/classes/' );

	// Root Vitals Directory for this plugin.
	define( 'WPHEALTHTRACKER_VITALS_DIR', WPHEALTHTRACKER_ROOT_DIR . 'includes/vitals/' );

	// Root Diet & Meds Directory for this plugin.
	define( 'WPHEALTHTRACKER_DIET_DIR', WPHEALTHTRACKER_ROOT_DIR . 'includes/diet/' );

	// Root Users Directory for this plugin.
	define( 'WPHEALTHTRACKER_USERS_DIR', WPHEALTHTRACKER_ROOT_DIR . 'includes/users/' );

	// Root Exercise Directory for this plugin.
	define( 'WPHEALTHTRACKER_EXERCISE_DIR', WPHEALTHTRACKER_ROOT_DIR . 'includes/exercise/' );

	// Root Includes Directory for this plugin.
	define( 'WPHEALTHTRACKER_INCLUDES_DIR', WPHEALTHTRACKER_ROOT_DIR . 'includes/' );

	// Root Translations directory.
	define( 'WPHEALTHTRACKER_CLASSES_TRANSLATIONS_DIR', WPHEALTHTRACKER_CLASS_DIR . 'translations/' );

	// Root Transients directory.
	define( 'WPHEALTHTRACKER_CLASSES_TRANSIENTS_DIR', WPHEALTHTRACKER_CLASS_DIR . 'transients/' );

	// Root D3 directory.
	define( 'WPHEALTHTRACKER_CLASSES_D3_DIR', WPHEALTHTRACKER_CLASS_DIR . 'D3/' );

	// Root D3 Vitals directory.
	define( 'WPHEALTHTRACKER_CLASSES_D3_VITALS_DIR', WPHEALTHTRACKER_CLASSES_D3_DIR . 'D3_vitals/' );

	// Root D3 Vitals directory.
	define( 'WPHEALTHTRACKER_CLASSES_D3_DIET_DIR', WPHEALTHTRACKER_CLASSES_D3_DIR . 'D3_diet/' );

	// Root D3 Vitals directory.
	define( 'WPHEALTHTRACKER_CLASSES_D3_EXERCISE_DIR', WPHEALTHTRACKER_CLASSES_D3_DIR . 'D3_exercise/' );

	// Root Dashboards directory.
	define( 'WPHEALTHTRACKER_CLASSES_DASHBOARDS_DIR', WPHEALTHTRACKER_CLASS_DIR . 'dashboards/' );

	// Root Utilities directory.
	define( 'WPHEALTHTRACKER_CLASSES_UTILITIES_DIR', WPHEALTHTRACKER_CLASS_DIR . 'utilities/' );

	// Root UI Admin directory.
	define( 'WPHEALTHTRACKER_CLASSES_UI_ADMIN_DIR', WPHEALTHTRACKER_CLASS_DIR . 'ui/admin/' );

	// Root UI Display directory.
	define( 'WPHEALTHTRACKER_CLASSES_UI_DISPLAY_DIR', WPHEALTHTRACKER_CLASS_DIR . 'ui/display/' );

	// Root Image Icons URL of this plugin.
	define( 'WPHEALTHTRACKER_ROOT_IMG_URL', WPHEALTHTRACKER_ROOT_URL . 'assets/img/' );

	// Root Image Icons URL of this plugin.
	define( 'WPHEALTHTRACKER_ROOT_IMG_ICONS_URL', WPHEALTHTRACKER_ROOT_URL . 'assets/img/icons/' );

	// Root CSS URL for this plugin.
	define( 'WPHEALTHTRACKER_ROOT_CSS_URL', WPHEALTHTRACKER_ROOT_URL . 'assets/css/' );

	// Root JS URL for this plugin.
	define( 'WPHEALTHTRACKER_ROOT_JS_URL', WPHEALTHTRACKER_ROOT_URL . 'assets/js/' );

	// Root JS URL for this plugin.
	define( 'WPHEALTHTRACKER_ROOT_JS_FRONTEND_URL', WPHEALTHTRACKER_ROOT_URL . 'assets/js/frontend/' );

	// Define the Uploads base directory.
	$uploads     = wp_upload_dir();
	$upload_path = $uploads['basedir'];
	define( 'WPHEALTHTRACKER_UPLOADS_BASE_DIR', $upload_path . '/' );

	$upload_url = $uploads['baseurl'];
	define( 'WPHEALTHTRACKER_UPLOADS_BASE_URL', $upload_url . '/' );

	// Root WordPress Plugin Directory.
	define( 'WPHEALTHTRACKER_ROOT_WP_PLUGINS_DIR', str_replace( '/wphealthtracker', '', plugin_dir_path( __FILE__ ) ) );

	// Default submenu pages.
	define( 'WPHEALTHTRACKER_SUBMENU_ARRAY',
		wp_json_encode(array(
			'Tracker',
			'Users',
			'Stats',
		))
	);

	// Nonces array.
	define( 'WPHEALTHTRACKER_NONCES_ARRAY',
		wp_json_encode(array(
			'vitalsnonce1'        => 'wphealthtracker_jre_selecteduser_vitals_enter_action_callback',
			'vitalsnonce2'        => 'wphealthtracker_jre_selecteduser_vitals_view_action_callback',
			'vitalsnonce3'        => 'wphealthtracker_jre_save_vitals_data_action_callback',
			'vitalsnonce4'        => 'wphealthtracker_jre_selecteduser_vitals_filter_data_action_callback',
			'statsvitalsnonce1'   => 'wphealthtracker_jre_grab_user_data_for_vitals_dashboard_action_callback',
			'statsvitalsnonce2'   => 'wphealthtracker_jre_grab_user_data_for_vitals_d3_action_callback',
			'dietnonce1'          => 'wphealthtracker_jre_selecteduser_diet_enter_action_callback',
			'dietnonce2'          => 'wphealthtracker_jre_selecteduser_diet_view_action_callback',
			'dietnonce3'          => 'wphealthtracker_jre_save_diet_data_action_callback',
			'dietnonce4'          => 'wphealthtracker_jre_selecteduser_diet_filter_data_action_callback',
			'usersnonce1'         => 'wphealthtracker_jre_save_users_data_action_callback',
			'usersnonce2'         => 'wphealthtracker_jre_create_wp_users_data_action',
			'statsdietnonce1'     => 'wphealthtracker_jre_grab_user_data_for_diet_dashboard_action_callback',
			'statsdietnonce2'     => 'wphealthtracker_jre_grab_user_data_for_diet_d3_action_callback',
			'exercisenonce1'      => 'wphealthtracker_jre_selecteduser_exercise_enter_action_callback',
			'exercisenonce2'      => 'wphealthtracker_jre_selecteduser_exercise_view_action_callback',
			'exercisenonce3'      => 'wphealthtracker_jre_save_exercise_data_action_callback',
			'exercisenonce4'      => 'wphealthtracker_jre_selecteduser_exercise_filter_data_action_callback',
			'statsexercisenonce1' => 'wphealthtracker_jre_grab_user_data_for_exercise_dashboard_action_callback',
			'statsexercisenonce2' => 'wphealthtracker_jre_grab_user_data_for_exercise_d3_action_callback',
			'editusersnonce1'     => 'wphealthtracker_jre_selecteduser_edit_user_populate_action_callback',
			'editusersnonce2'     => 'wphealthtracker_jre_edit_users_data_action_callback',
			'editusersnonce3'     => 'wphealthtracker_jre_selecteduser_delete_user_actual_action_callback',
		))
	);

	// Server timezone.
	define( 'CONST_SERVER_TIMEZONE', 'UTC' );

	// Server dateformat.
	define( 'CONST_SERVER_DATEFORMAT', 'm/d/Y' );

/* END OF CONSTANT DEFINITIONS */

// CLASS INSTANTIATIONS */
	// Call the class found in wphealthtracker-functions.php.
	$wp_health_tracker_general_functions = new WPHealthTracker_General_Functions();

	// Call the class found in wphealthtracker-vitals-ajax.php.
	$wp_health_tracker_vitals_ajax_functions = new WPHealthTracker_Vitals_Ajax_Functions();

	// Call the class found in wphealthtracker-diet-functions.php.
	$wp_health_tracker_diet_functions = new WPHealthTracker_Diet_Functions();

	// Call the class found in wphealthtracker-diet-ajax.php.
	$wp_health_tracker_diet_ajax_functions = new WPHealthTracker_Diet_Ajax_Functions();

	// Call the class found in wphealthtracker-users-functions.php.
	$wp_health_tracker_users_functions = new WPHealthTracker_Users_Functions();

	// Call the class found in wphealthtracker-users-ajax.php.
	$wp_health_tracker_users_ajax_functions = new WPHealthTracker_Users_Ajax_Functions();

	// Call the class found in wphealthtracker-exercise-functions.php.
	$wp_health_tracker_exercise_functions = new WPHealthTracker_Exercise_Functions();

	// Call the class found in wphealthtracker-exercise-ajax.php.
	$wp_health_tracker_exercise_ajax_functions = new WPHealthTracker_Exercise_Ajax_Functions();

	// Call the class found in wphealthtracker-stats-vitals-ajax.php.
	$wp_health_tracker_stats_vitals_ajax_functions = new WPHealthTracker_Stats_Vitals_Ajax_Functions();

	// Call the class found in wphealthtracker-stats-diet-ajax.php.
	$wp_health_tracker_stats_diet_ajax_functions = new WPHealthTracker_Stats_Diet_Ajax_Functions();

	// Call the class found in wphealthtracker-stats-exercise-ajax.php.
	$wp_health_tracker_stats_exercise_ajax_functions = new WPHealthTracker_Stats_Exercise_Ajax_Functions();
/* END CLASS INSTANTIATIONS */



/* FUNCTIONS FOUND IN WPHEALTHTRACKER-FUNCTIONS.PHP THAT APPLY PLUGIN-WIDE */

	// For the admin pages.
	add_action( 'admin_menu', array( $wp_health_tracker_general_functions, 'wphealthtracker_jre_admin_menu' ) );
	add_action( 'admin_menu', array( $wp_health_tracker_general_functions, 'wphealthtracker_jre_my_subadmin_menu' ) );

	// Adding AJAX JavaScript.
	add_action( 'wp_head', array( $wp_health_tracker_general_functions, 'wphealthtracker_jre_add_ajax_library' ) );

	// Adding jQuery Effects Library that ships with WordPress.
	add_action( 'admin_enqueue_scripts', array( $wp_health_tracker_general_functions, 'wphealthtracker_jre_add_jquery_effects_library' ) );

	// Adding the admin js file.
	add_action( 'admin_enqueue_scripts', array( $wp_health_tracker_general_functions, 'wphealthtracker_jre_admin_js' ) );

	// Adding the frontend Diet Stats JS file, if the [] shortcode is present on page.
	add_action( 'wp_enqueue_scripts', array( $wp_health_tracker_general_functions, 'wphealthtracker_jre_frontend_dietstats_js' ) );

	// Adding the frontend Vitals Stats JS file, if the [] shortcode is present on page.
	add_action( 'wp_enqueue_scripts', array( $wp_health_tracker_general_functions, 'wphealthtracker_jre_frontend_vitalsstats_js' ) );

	// Adding the frontend Exercise Stats JS file, if the [] shortcode is present on page.
	add_action( 'wp_enqueue_scripts', array( $wp_health_tracker_general_functions, 'wphealthtracker_jre_frontend_exercisestats_js' ) );

	// Adding the front-end Diet Stats shortcode.
	add_shortcode( 'wphealthtracker_dietstats', array( $wp_health_tracker_general_functions, 'wphealthtracker_dietstats_frontend_shortcode_function' ) );

	// Adding the front-end Vitals Stats shortcode.
	add_shortcode( 'wphealthtracker_vitalstats', array( $wp_health_tracker_general_functions, 'wphealthtracker_vitalsstats_frontend_shortcode_function' ) );

	// Adding the front-end Vitals Exercise shortcode.
	add_shortcode( 'wphealthtracker_exercisestats', array( $wp_health_tracker_general_functions, 'wphealthtracker_exercisestats_frontend_shortcode_function' ) );

	// Adding the front-end User Dashboard shortcode.
	add_shortcode( 'wphealthtracker_user_dashboard', array( $wp_health_tracker_general_functions, 'wphealthtracker_user_dashboard_frontend_shortcode_function' ) );

	// Adding the d3 js file to the backend.
	add_action( 'admin_enqueue_scripts', array( $wp_health_tracker_general_functions, 'wphealthtracker_jre_d3_js' ) );

	// Adding the d3 js file to the backend.
	add_action( 'wp_enqueue_scripts', array( $wp_health_tracker_general_functions, 'wphealthtracker_jre_frontend_dashboard_account_js' ) );

	// Adding the d3 js file to the frontend, if needed.
	add_action( 'wp_enqueue_scripts', array( $wp_health_tracker_general_functions, 'wphealthtracker_jre_frontend_d3_js' ) );

	// Admin CSS.
	add_action( 'admin_enqueue_scripts', array( $wp_health_tracker_general_functions, 'wphealthtracker_jre_admin_style' ) );

	// Frontend CSS.
	add_action( 'wp_enqueue_scripts', array( $wp_health_tracker_general_functions, 'wphealthtracker_jre_frontend_style' ) );

	// Registers table names.
	add_action( 'init', array( $wp_health_tracker_general_functions, 'wphealthtracker_jre_register_table_names' ), 1 );

	// Creates basic WPHealthTracker User role on activation.
	register_activation_hook( __FILE__, array( $wp_health_tracker_general_functions, 'wphealthtracker_add_wphealthtracker_role_on_plugin_activation' ) );

	// Creates User table upon activation.
	register_activation_hook( __FILE__, array( $wp_health_tracker_general_functions, 'wphealthtracker_jre_create_user_table' ) );

	// Creates General Settings table upon activation.
	register_activation_hook( __FILE__, array( $wp_health_tracker_general_functions, 'wphealthtracker_jre_create_general_settings_table' ) );

	// Runs once upon plugin activation and creates the Daily Data - Vitals table.
	register_activation_hook( __FILE__, array( $wp_health_tracker_general_functions, 'wphealthtracker_jre_create_daily_data_vitals_table' ) );

	// Runs once upon plugin activation and creates the Daily Data - Diet table.
	register_activation_hook( __FILE__, array( $wp_health_tracker_general_functions, 'wphealthtracker_jre_create_daily_data_diet_table' ) );

	// Runs once upon plugin activation and creates the Daily Data - Exercise table.
	register_activation_hook( __FILE__, array( $wp_health_tracker_general_functions, 'wphealthtracker_jre_create_daily_data_exercise_table' ) );

	// Adding the function that will allow the displaying of the Adminpointers when question marks are hovered over.
	add_action( 'admin_footer', array( $wp_health_tracker_general_functions, 'wphealthtracker_jre_admin_pointers_javascript' ) );

	// Adding the function that will take our WPHEALTHTRACKER_NONCES_ARRAY Constant from below and create actual nonces to be passed to Javascript functions.
	add_action( 'init', array( $wp_health_tracker_general_functions, 'wphealthtracker_jre_create_nonces' ) );

	// For adding the default jQuery-Ui-Autocomplete script taht ships with WordPress Core for the Autocomplete function for each unique food item.
	add_action( 'admin_footer', array( $wp_health_tracker_general_functions, 'wphealthtracker_jre_add_core_jquery_ui' ) );

/* END OF FUNCTIONS FOUND IN WPHEALTHTRACKER-FUNCTIONS.PHP THAT APPLY PLUGIN-WIDE */



/* AJAX FUNCTIONS FOUND IN WPHEALTHTRACKER-VITALS-AJAX.PHP THAT ARE SPECIFIC TO THE VITALS TAB */

	// For populating the 'Enter' container on the Vitals tab with the selected user's data and/or the blank form.
	add_action( 'wp_ajax_wphealthtracker_jre_selecteduser_vitals_enter_action', array( $wp_health_tracker_vitals_ajax_functions, 'wphealthtracker_jre_selecteduser_vitals_enter_action_callback' ) );
	add_action( 'wp_ajax_nopriv_wphealthtracker_jre_selecteduser_vitals_enter_action', array( $wp_health_tracker_vitals_ajax_functions, 'wphealthtracker_jre_selecteduser_vitals_enter_action_callback' ) );

	// For populating the 'View' container on the Vitals tab with the selected user's data and/or the blank form.
	add_action( 'wp_ajax_wphealthtracker_jre_selecteduser_vitals_view_action', array( $wp_health_tracker_vitals_ajax_functions, 'wphealthtracker_jre_selecteduser_vitals_view_action_callback' ) );
	add_action( 'wp_ajax_nopriv_wphealthtracker_jre_selecteduser_vitals_view_action', array( $wp_health_tracker_vitals_ajax_functions, 'wphealthtracker_jre_selecteduser_vitals_view_action_callback' ) );

	// For saving and/or updating existing user data on the Vitals tab.
	add_action( 'wp_ajax_wphealthtracker_jre_save_vitals_data_action', array( $wp_health_tracker_vitals_ajax_functions, 'wphealthtracker_jre_save_vitals_data_action_callback' ) );
	add_action( 'wp_ajax_nopriv_wphealthtracker_jre_save_vitals_data_action', array( $wp_health_tracker_vitals_ajax_functions, 'wphealthtracker_jre_save_vitals_data_action_callback' ) );

	// For grabbing and outputting data when the 'Filter' button is clicked...
	add_action( 'wp_ajax_wphealthtracker_jre_selecteduser_vitals_filter_data_action', array( $wp_health_tracker_vitals_ajax_functions, 'wphealthtracker_jre_selecteduser_vitals_filter_data_action_callback' ) );
	add_action( 'wp_ajax_nopriv_wphealthtracker_jre_selecteduser_vitals_filter_data_action', array( $wp_health_tracker_vitals_ajax_functions, 'wphealthtracker_jre_selecteduser_vitals_filter_data_action_callback' ) );

/* END OF AJAX FUNCTIONS FOUND IN WPHEALTHTRACKER-VITALS-AJAX.PHP THAT ARE SPECIFIC TO THE VITALS TAB */

/* NON-AJAX FUNCTIONS FOUND IN WPHEALTHTRACKER-DIET-FUNCTIONS.PHP THAT ARE SPECIFIC TO THE DIET TAB */

/* END OF NON-AJAX FUNCTIONS FOUND IN WPHEALTHTRACKER-DIET-FUNCTIONS.PHP THAT ARE SPECIFIC TO THE DIET TAB */

/* AJAX FUNCTIONS FOUND IN WPHEALTHTRACKER-DIET-AJAX.PHP THAT ARE SPECIFIC TO THE DIET TAB */

	// For populating the 'Enter' container on the Diet tab with the selected user's data and/or the blank form.
	add_action( 'wp_ajax_wphealthtracker_jre_selecteduser_diet_enter_action', array( $wp_health_tracker_diet_ajax_functions, 'wphealthtracker_jre_selecteduser_diet_enter_action_callback' ) );
	add_action( 'wp_ajax_nopriv_wphealthtracker_jre_selecteduser_diet_enter_action', array( $wp_health_tracker_diet_ajax_functions, 'wphealthtracker_jre_selecteduser_diet_enter_action_callback' ) );

	// Populates the Edit User form area after a user has been selected.
	add_action( 'wp_ajax_wphealthtracker_jre_selecteduser_edit_user_populate_action', array( $wp_health_tracker_users_ajax_functions, 'wphealthtracker_jre_selecteduser_edit_user_populate_action_callback' ) );
	add_action( 'wp_ajax_nopriv_wphealthtracker_jre_selecteduser_edit_user_populate_action', array( $wp_health_tracker_users_ajax_functions, 'wphealthtracker_jre_selecteduser_edit_user_populate_action_callback' ) );

	// For deleting a user and all their associated data.
	add_action( 'wp_ajax_wphealthtracker_jre_selecteduser_delete_user_actual_action', array( $wp_health_tracker_users_ajax_functions, 'wphealthtracker_jre_selecteduser_delete_user_actual_action_callback' ) );
	add_action( 'wp_ajax_nopriv_wphealthtracker_jre_selecteduser_delete_user_actual_action', array( $wp_health_tracker_users_ajax_functions, 'wphealthtracker_jre_selecteduser_delete_user_actual_action_callback' ) );

	// For populating the 'View' container on the Diet tab with the selected user's data and/or the blank form.
	add_action( 'wp_ajax_wphealthtracker_jre_selecteduser_diet_view_action', array( $wp_health_tracker_diet_ajax_functions, 'wphealthtracker_jre_selecteduser_diet_view_action_callback' ) );
	add_action( 'wp_ajax_nopriv_wphealthtracker_jre_selecteduser_diet_view_action', array( $wp_health_tracker_diet_ajax_functions, 'wphealthtracker_jre_selecteduser_diet_view_action_callback' ) );

	// For saving and/or updating existing user data on the Diet tab.
	add_action( 'wp_ajax_wphealthtracker_jre_save_diet_data_action', array( $wp_health_tracker_diet_ajax_functions, 'wphealthtracker_jre_save_diet_data_action_callback' ) );
	add_action( 'wp_ajax_nopriv_wphealthtracker_jre_save_diet_data_action', array( $wp_health_tracker_diet_ajax_functions, 'wphealthtracker_jre_save_diet_data_action_callback' ) );

	// For grabbing and outputting data when the 'Filter' button is clicked...
	add_action( 'wp_ajax_wphealthtracker_jre_selecteduser_diet_filter_data_action', array( $wp_health_tracker_diet_ajax_functions, 'wphealthtracker_jre_selecteduser_diet_filter_data_action_callback' ) );
	add_action( 'wp_ajax_nopriv_wphealthtracker_jre_selecteduser_diet_filter_data_action', array( $wp_health_tracker_diet_ajax_functions, 'wphealthtracker_jre_selecteduser_diet_filter_data_action_callback' ) );

/* END OF AJAX FUNCTIONS FOUND IN WPHEALTHTRACKER-DIET-AJAX.PHP THAT ARE SPECIFIC TO THE DIET TAB */

/* AJAX FUNCTIONS FOUND IN WPHEALTHTRACKER-USERS-AJAX.PHP THAT ARE SPECIFIC TO THE USERS TAB */

	// For saving a new user on the Create Users tab.
	add_action( 'wp_ajax_wphealthtracker_jre_create_wp_users_data_action', array( $wp_health_tracker_users_ajax_functions, 'wphealthtracker_jre_create_wp_users_data_action_callback' ) );
	add_action( 'wp_ajax_nopriv_wphealthtracker_jre_create_wp_users_data_action', array( $wp_health_tracker_users_ajax_functions, 'wphealthtracker_jre_create_wp_users_data_action_callback' ) );

	// For creating a new wphealthtracker user on the Users tab.
	add_action( 'wp_ajax_wphealthtracker_jre_save_users_data_action', array( $wp_health_tracker_users_ajax_functions, 'wphealthtracker_jre_save_users_data_action_callback' ) );
	add_action( 'wp_ajax_nopriv_wphealthtracker_jre_save_users_data_action', array( $wp_health_tracker_users_ajax_functions, 'wphealthtracker_jre_save_users_data_action_callback' ) );

	// For editing a new wphealthtracker user on the Users tab.
	add_action( 'wp_ajax_wphealthtracker_jre_edit_users_data_action', array( $wp_health_tracker_users_ajax_functions, 'wphealthtracker_jre_edit_users_data_action_callback' ) );
	add_action( 'wp_ajax_nopriv_wphealthtracker_jre_edit_users_data_action', array( $wp_health_tracker_users_ajax_functions, 'wphealthtracker_jre_edit_users_data_action_callback' ) );

/* END OF AJAX FUNCTIONS FOUND IN WPHEALTHTRACKER-USERS-AJAX.PHP THAT ARE SPECIFIC TO THE USERS TAB */

/* NON-AJAX FUNCTIONS FOUND IN WPHEALTHTRACKER-EXERCISE-FUNCTIONS.PHP THAT ARE SPECIFIC TO THE EXERCISE TAB */

/* END OF NON-AJAX FUNCTIONS FOUND IN WPHEALTHTRACKER-EXERCISE-FUNCTIONS.PHP THAT ARE SPECIFIC TO THE EXERCISE TAB */

/* AJAX FUNCTIONS FOUND IN WPHEALTHTRACKER-EXERCISE-AJAX.PHP THAT ARE SPECIFIC TO THE EXERCISE TAB */

	// For populating the 'Enter' container on the Exercise tab with the selected user's data and/or the blank form.
	add_action( 'wp_ajax_wphealthtracker_jre_selecteduser_exercise_enter_action', array( $wp_health_tracker_exercise_ajax_functions, 'wphealthtracker_jre_selecteduser_exercise_enter_action_callback' ) );
	add_action( 'wp_ajax_nopriv_wphealthtracker_jre_selecteduser_exercise_enter_action', array( $wp_health_tracker_exercise_ajax_functions, 'wphealthtracker_jre_selecteduser_exercise_enter_action_callback' ) );

	// For populating the 'View' container on the Exercise tab with the selected user's data and/or the blank form.
	add_action( 'wp_ajax_wphealthtracker_jre_selecteduser_exercise_view_action', array( $wp_health_tracker_exercise_ajax_functions, 'wphealthtracker_jre_selecteduser_exercise_view_action_callback' ) );
	add_action( 'wp_ajax_nopriv_wphealthtracker_jre_selecteduser_exercise_view_action', array( $wp_health_tracker_exercise_ajax_functions, 'wphealthtracker_jre_selecteduser_exercise_view_action_callback' ) );

	// For saving and/or updating existing user data on the Exercise tab.
	add_action( 'wp_ajax_wphealthtracker_jre_save_exercise_data_action', array( $wp_health_tracker_exercise_ajax_functions, 'wphealthtracker_jre_save_exercise_data_action_callback' ) );
	add_action( 'wp_ajax_nopriv_wphealthtracker_jre_save_exercise_data_action', array( $wp_health_tracker_exercise_ajax_functions, 'wphealthtracker_jre_save_exercise_data_action_callback' ) );

	// For grabbing and outputting data when the 'Filter' button is clicked...
	add_action( 'wp_ajax_wphealthtracker_jre_selecteduser_exercise_filter_data_action', array( $wp_health_tracker_exercise_ajax_functions, 'wphealthtracker_jre_selecteduser_exercise_filter_data_action_callback' ) );
	add_action( 'wp_ajax_nopriv_wphealthtracker_jre_selecteduser_exercise_filter_data_action', array( $wp_health_tracker_exercise_ajax_functions, 'wphealthtracker_jre_selecteduser_exercise_filter_data_action_callback' ) );

/* END OF AJAX FUNCTIONS FOUND IN WPHEALTHTRACKER-EXERCISE-AJAX.PHP THAT ARE SPECIFIC TO THE EXERCISE TAB */

/* AJAX FUNCTIONS FOUND IN WPHEALTHTRACKER-STATS-VITALS-AJAX.PHP THAT ARE SPECIFIC TO THE STATS-VITALS TAB */


	// For populating the 'Dashboard section of the Vital Stats tab.
	add_action( 'wp_ajax_wphealthtracker_jre_grab_user_data_for_vitals_dashboard_action', array( $wp_health_tracker_stats_vitals_ajax_functions, 'wphealthtracker_jre_grab_user_data_for_vitals_dashboard_action_callback' ) );
	add_action( 'wp_ajax_nopriv_wphealthtracker_jre_grab_user_data_for_vitals_dashboard_action', array( $wp_health_tracker_stats_vitals_ajax_functions, 'wphealthtracker_jre_grab_user_data_for_vitals_dashboard_action_callback' ) );

	// For populating the D3 charts sections of the Vital Stats tab.
	add_action( 'wp_ajax_wphealthtracker_jre_grab_user_data_for_vitals_d3_action', array( $wp_health_tracker_stats_vitals_ajax_functions, 'wphealthtracker_jre_grab_user_data_for_vitals_d3_action_callback' ) );
	add_action( 'wp_ajax_nopriv_wphealthtracker_jre_grab_user_data_for_vitals_d3_action', array( $wp_health_tracker_stats_vitals_ajax_functions, 'wphealthtracker_jre_grab_user_data_for_vitals_d3_action_callback' ) );


/* END OF AJAX FUNCTIONS FOUND IN WPHEALTHTRACKER-VITALS-AJAX.PHP THAT ARE SPECIFIC TO THE VITALS TAB */

/* AJAX FUNCTIONS FOUND IN WPHEALTHTRACKER-STATS-DIET-AJAX.PHP THAT ARE SPECIFIC TO THE STATS-DIET TAB */


	// For populating the 'Dashboard section of the Diet Stats tab.
	add_action( 'wp_ajax_wphealthtracker_jre_grab_user_data_for_diet_dashboard_action', array( $wp_health_tracker_stats_diet_ajax_functions, 'wphealthtracker_jre_grab_user_data_for_diet_dashboard_action_callback' ) );
	add_action( 'wp_ajax_nopriv_wphealthtracker_jre_grab_user_data_for_diet_dashboard_action', array( $wp_health_tracker_stats_diet_ajax_functions, 'wphealthtracker_jre_grab_user_data_for_diet_dashboard_action_callback' ) );

	// For populating the D3 charts sections of the Diet Stats tab.
	add_action( 'wp_ajax_wphealthtracker_jre_grab_user_data_for_diet_d3_action', array( $wp_health_tracker_stats_diet_ajax_functions, 'wphealthtracker_jre_grab_user_data_for_diet_d3_action_callback' ) );
	add_action( 'wp_ajax_nopriv_wphealthtracker_jre_grab_user_data_for_diet_d3_action', array( $wp_health_tracker_stats_diet_ajax_functions, 'wphealthtracker_jre_grab_user_data_for_diet_d3_action_callback' ) );


/* END OF AJAX FUNCTIONS FOUND IN WPHEALTHTRACKER-DIET-AJAX.PHP THAT ARE SPECIFIC TO THE DIET TAB */


/* AJAX FUNCTIONS FOUND IN WPHEALTHTRACKER-STATS-EXERCISE-AJAX.PHP THAT ARE SPECIFIC TO THE STATS-EXERCISE TAB */


	// For populating the 'Dashboard section of the Exercise Stats tab.
	add_action( 'wp_ajax_wphealthtracker_jre_grab_user_data_for_exercise_dashboard_action', array( $wp_health_tracker_stats_exercise_ajax_functions, 'wphealthtracker_jre_grab_user_data_for_exercise_dashboard_action_callback' ) );
	add_action( 'wp_ajax_nopriv_wphealthtracker_jre_grab_user_data_for_exercise_dashboard_action', array( $wp_health_tracker_stats_exercise_ajax_functions, 'wphealthtracker_jre_grab_user_data_for_exercise_dashboard_action_callback' ) );

	// For populating the D3 charts sections of the Exercise Stats tab.
	add_action( 'wp_ajax_wphealthtracker_jre_grab_user_data_for_exercise_d3_action', array( $wp_health_tracker_stats_exercise_ajax_functions, 'wphealthtracker_jre_grab_user_data_for_exercise_d3_action_callback' ) );
	add_action( 'wp_ajax_nopriv_wphealthtracker_jre_grab_user_data_for_exercise_d3_action', array( $wp_health_tracker_stats_exercise_ajax_functions, 'wphealthtracker_jre_grab_user_data_for_exercise_d3_action_callback' ) );


/* END OF AJAX FUNCTIONS FOUND IN WPHEALTHTRACKER-EXERCISE-AJAX.PHP THAT ARE SPECIFIC TO THE EXERCISE TAB */


add_action( 'admin_enqueue_scripts', 'include_password_in_admin_page' );
function include_password_in_admin_page($hook){
	error_log('fdsfd');
    //wp_enqueue_script( 'password-strength-meter' );
    //wp_enqueue_script( 'user-profile' );
}