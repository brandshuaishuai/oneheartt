<?php
/**
 * Class WPHealthTracker_Diet_Ajax_Functions - wphealthtracker-diet-ajax.php
 *
 * @author   Jake Evans
 * @category Admin
 * @package  Includes/Diet
 * @version  0.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPHealthTracker_Diet_Ajax_Functions', false ) ) :
	/**
	 * WPHealthTracker_Diet_Ajax_Functions class. Here we'll house all of the Ajax Callback functions we'll need to
	 * make the Diet tab run as expected. The initial functions that send calls to the functions in this file are
	 * located in the wphealthtracker-diet-js.js JavaScript file.
	 */
	class WPHealthTracker_Diet_Ajax_Functions {

		/**
		 * Class Constructor
		 */
		public function __construct() {

			// Set the date.
			require_once WPHEALTHTRACKER_CLASSES_UTILITIES_DIR . 'class-wphealthtracker-utilities-date.php';
			$utilities_date = new WPHealthTracker_Utilities_Date();
			$this->date     = $utilities_date->wphealthtracker_get_date_via_current_time( 'mysql' );

		}

		/**
		 * Callback function for populating the tab with the selected user's saved data and/or the blank form
		 */
		public function wphealthtracker_jre_selecteduser_diet_enter_action_callback() {
			global $wpdb;
			check_ajax_referer( 'wphealthtracker_jre_selecteduser_diet_enter_action_callback', 'security' );
			$wpuserid = filter_var( $_POST['wpuserid'], FILTER_SANITIZE_NUMBER_INT );
			$offset   = filter_var( $_POST['offset'], FILTER_SANITIZE_NUMBER_INT );

			// Get the user's name for messaging.
			$users_master_table = $wpdb->prefix . 'wphealthtracker_users';

			// Make call to Transients class to see if Transient currently exists. If so, retrieve it, if not, make call to create_transient() with all required Parameters.
			require_once WPHEALTHTRACKER_CLASSES_TRANSIENTS_DIR . 'class-wphealthtracker-transients.php';
			$transients       = new WPHealthTracker_Transients();
			$transient_name   = 'wpht_' . $wpuserid . '_' . md5( 'SELECT * FROM ' . $users_master_table . ' WHERE wpuserid = ' . $wpuserid );
			$transient_exists = $transients->existing_transient_check( $transient_name );
			if ( $transient_exists ) {
				$username = $transient_exists;
			} else {
				$query    = $wpdb->prepare( "SELECT * FROM $users_master_table WHERE wpuserid = %d", $wpuserid );
				$username = $transients->create_transient( $transient_name, 'wpdb->get_row', $query, MONTH_IN_SECONDS );
			}

			// Setting the first and last name of user.
			$userfirst = $username->firstname;
			$userlast  = $username->lastname;

			// Get user's DATA FOR TODAY ONLY, if it exists.
			$userdailydata          = array();
			$users_daily_table_name = $wpdb->prefix . 'wphealthtracker_user_daily_data_diet';
			// Make call to Transients class to see if Transient currently exists. If so, retrieve it, if not, make call to create_transient() with all required Parameters.
			$transient_name   = 'wpht_' . $wpuserid . '_' . md5( 'SELECT * FROM ' . $users_daily_table_name . ' WHERE wpuserid = ' . $wpuserid );
			$transient_exists = $transients->existing_transient_check( $transient_name );
			if ( $transient_exists ) {
				$userdailydata = $transient_exists;
			} else {
				$query         = $wpdb->prepare( "SELECT * FROM $users_daily_table_name WHERE wpuserid = %d", $wpuserid );
				$userdailydata = $transients->create_transient( $transient_name, 'wpdb->get_results', $query, MONTH_IN_SECONDS );
			}

			// Now loop through all results and look for today's date - if found, set userdailydata equal to today's entry, losing all other entries.
			$todayflag = false;
			foreach ( $userdailydata as $key => $value ) {
				if ( $value->humandate === $this->date ) {
					$todayflag     = true;
					$userdailydata = $value;
				}
			}

			// If no data for today was found, create the userdailydata object that 'class-diet-forms-actual.php' will use just to be verbose, prevent PHP error messages, and to pass today's date and first and last name.
			if ( ! $todayflag ) {
				$userdailydata             = new \stdClass();
				$userdailydata->humandate  = $this->date;
				$userdailydata->firstname  = $userfirst;
				$userdailydata->lastname   = $userlast;
				$userdailydata->wpuserid   = $wpuserid;
				$userdailydata->foodstring = '';
				$userdailydata->dietimg    = '';
				$userdailydata->dietfiles  = '';
			}

			// Require the file that contains the class that will output the forms needed for the Diet tab.
			require_once WPHEALTHTRACKER_DIET_DIR . 'class-wphealthtracker-diet-forms-actual.php';

			// Instantiate the class and get the final output for the current day's data.
			$tabformclass_today = new WPHEALTHTRACKER_Diet_Forms_Actual();
			$tabformclass_today->output_today_data( $userdailydata );

			// Build array of values to return to browser.
			$return_array = array(
				$tabformclass_today->final_complete_output,
				wp_json_encode( $userdailydata ),
				$userfirst,
				$userlast,
				$this->date,
				$wpuserid,
			);

			// Serialize array.
			$return_array = wp_json_encode( $return_array );
			wp_die( $return_array );
		}


		/**
		 * Callback function for populating the 'View' Container.
		 */
		public function wphealthtracker_jre_selecteduser_diet_view_action_callback() {
			global $wpdb;
			check_ajax_referer( 'wphealthtracker_jre_selecteduser_diet_view_action_callback', 'security' );
			$wpuserid = filter_var( $_POST['wpuserid'], FILTER_SANITIZE_NUMBER_INT );
			$offset   = filter_var( $_POST['offset'], FILTER_SANITIZE_NUMBER_INT );

			// Get the user's name for messaging.
			$users_master_table = $wpdb->prefix . 'wphealthtracker_users';

			// Make call to Transients class to see if Transient currently exists. If so, retrieve it, if not, make call to create_transient() with all required Parameters.
			require_once WPHEALTHTRACKER_CLASSES_TRANSIENTS_DIR . 'class-wphealthtracker-transients.php';
			$transients       = new WPHealthTracker_Transients();
			$transient_name   = 'wpht_' . $wpuserid . '_' . md5( 'SELECT * FROM ' . $users_master_table . ' WHERE wpuserid = ' . $wpuserid );
			$transient_exists = $transients->existing_transient_check( $transient_name );
			if ( $transient_exists ) {
				$username = $transient_exists;
			} else {
				$query    = $wpdb->prepare( "SELECT * FROM $users_master_table WHERE wpuserid = %d", $wpuserid );
				$username = $transients->create_transient( $transient_name, 'wpdb->get_row', $query, MONTH_IN_SECONDS );
			}

			// Setting the first and last name of user.
			$userfirst = $username->firstname;
			$userlast  = $username->lastname;

			// Get ALL DATA saved for this user from every previous date.
			$useralldata            = array();
			$users_daily_table_name = $wpdb->prefix . 'wphealthtracker_user_daily_data_diet';
			// Make call to Transients class to see if Transient currently exists. If so, retrieve it, if not, make call to create_transient() with all required Parameters.
			$transient_name   = 'wpht_' . $wpuserid . '_' . md5( 'SELECT * FROM ' . $users_daily_table_name . ' WHERE wpuserid = ' . $wpuserid . ' ORDER BY humandate DESC LIMIT 8' );
			$transient_exists = $transients->existing_transient_check( $transient_name );
			if ( $transient_exists ) {
				$useralldata = $transient_exists;
			} else {
				$query       = $wpdb->prepare( "SELECT * FROM $users_daily_table_name WHERE wpuserid = %d ORDER BY humandate DESC LIMIT 8", $wpuserid );
				$useralldata = $transients->create_transient( $transient_name, 'wpdb->get_results', $query, MONTH_IN_SECONDS );
			}

			// Now loop through all results and look for today's date - if found, remove it.
			$unset_flag = false;
			foreach ( $useralldata as $key => $value ) {
				if ( $value->humandate === $this->date ) {
					unset( $useralldata[ $key ] );
					$unset_flag = true;
				}
			}

			// If we didn't find today's date, we need to remove one entry to ensure user only sees past 7 days, to comply with the filter drop-down value, but only if the results are greater than 7.
			if ( false === $unset_flag && count( $useralldata ) > 7 ) {
				array_pop( $useralldata );
			}

			// Require the file that contains the class that will output the forms needed for the Diet tab.
			require_once WPHEALTHTRACKER_DIET_DIR . 'class-wphealthtracker-diet-forms-actual.php';

			// Instantiate the class and get the final output for the current day's data.
			$tabformclass_previous = new WPHEALTHTRACKER_Diet_Forms_Actual();
			$tabformclass_previous->output_previous_data( $useralldata, $userfirst, $userlast, $wpuserid );

			// Build array of values to return to browser.
			$return_array = array(
				$tabformclass_previous->final_complete_output,
				wp_json_encode( $useralldata ),
				$userfirst,
				$userlast,
				$this->date,
				$wpuserid,
			);

			// Serialize array.
			$return_array = wp_json_encode( $return_array );
			wp_die( $return_array );
		}

		/**
		 * Callback function for the wphealthtracker_jre_selecteduser_diet_filter_data() function found in wphealthtracker-diet-js.js - For grabbing and outputting data when the 'Filter' button is clicked...
		 */
		public function wphealthtracker_jre_selecteduser_diet_filter_data_action_callback() {
			global $wpdb;
			check_ajax_referer( 'wphealthtracker_jre_selecteduser_diet_filter_data_action_callback', 'security' );

			$wpuserid  = filter_var( $_POST['wpuserid'], FILTER_SANITIZE_NUMBER_INT );
			$filterval = filter_var( $_POST['filterval'], FILTER_SANITIZE_NUMBER_INT ) + 1;

			// Get the user's name for messaging.
			$users_master_table = $wpdb->prefix . 'wphealthtracker_users';

			// Make call to Transients class to see if Transient currently exists. If so, retrieve it, if not, make call to create_transient() with all required Parameters.
			require_once WPHEALTHTRACKER_CLASSES_TRANSIENTS_DIR . 'class-wphealthtracker-transients.php';
			$transients       = new WPHealthTracker_Transients();
			$transient_name   = 'wpht_' . $wpuserid . '_' . md5( 'SELECT * FROM ' . $users_master_table . ' WHERE wpuserid = ' . $wpuserid );
			$transient_exists = $transients->existing_transient_check( $transient_name );
			if ( $transient_exists ) {
				$username = $transient_exists;
			} else {
				$query    = $wpdb->prepare( "SELECT * FROM $users_master_table WHERE wpuserid = %d", $wpuserid );
				$username = $transients->create_transient( $transient_name, 'wpdb->get_row', $query, MONTH_IN_SECONDS );
			}

			// Setting the first and last name of user.
			$userfirst = $username->firstname;
			$userlast  = $username->lastname;

			// Get data saved for this user based on $filterval.
			$useralldata            = array();
			$users_daily_table_name = $wpdb->prefix . 'wphealthtracker_user_daily_data_diet';
			// Make call to Transients class to see if Transient currently exists. If so, retrieve it, if not, make call to create_transient() with all required Parameters.
			$transient_name   = 'wpht_' . $wpuserid . '_' . md5( 'SELECT * FROM ' . $users_daily_table_name . ' WHERE wpuserid = ' . $wpuserid . ' ORDER BY humandate DESC LIMIT ' . $filterval );
			$transient_exists = $transients->existing_transient_check( $transient_name );
			if ( $transient_exists ) {
				$useralldata = $transient_exists;
			} else {
				$query       = $wpdb->prepare( "SELECT * FROM $users_daily_table_name WHERE wpuserid = %d ORDER BY humandate DESC LIMIT %d", $wpuserid, $filterval );
				$useralldata = $transients->create_transient( $transient_name, 'wpdb->get_results', $query, MONTH_IN_SECONDS );
			}

			// Now loop through all results and look for today's date - if found, remove it.
			$unset_flag = false;
			foreach ( $useralldata as $key => $value ) {
				if ( $value->humandate === $this->date ) {
					unset( $useralldata[ $key ] );
					$unset_flag = true;
				}
			}

			// If we didn't find today's date, we need to remove one entry to ensure user only sees past $filterval days, to comply with the filter drop-down value, but only if size of results are greater than $filterval-1.
			if ( $unset_flag === false && count( $useralldata ) > ( $filterval - 1 ) ) {
				array_pop( $useralldata );
			}

			// Require the file that contains the class that will output the forms needed for the Diet tab.
			require_once WPHEALTHTRACKER_DIET_DIR . 'class-wphealthtracker-diet-forms-actual.php';

			// Instantiate the class and get the final output for the current day's data.
			$tabformclass_previous = new WPHEALTHTRACKER_Diet_Forms_Actual();
			$tabformclass_previous->output_previous_data( $useralldata, $userfirst, $userlast, $wpuserid );

			// Build array of values to return to browser.
			$return_array = array(
				$tabformclass_previous->final_complete_output,
				wp_json_encode( $useralldata ),
				$userfirst,
				$userlast,
				$this->date,
				$wpuserid,
			);

			// Serialize array.
			$return_array = wp_json_encode( $return_array );
			wp_die( $return_array );

		}

		/**
		 * Callback function for the wphealthtracker_jre_save_diet_data() function found in wphealthtracker-diet-js.js - for saving user's data.
		 */
		public function wphealthtracker_jre_save_diet_data_action_callback() {
			global $wpdb;
			check_ajax_referer( 'wphealthtracker_jre_save_diet_data_action_callback', 'security' );

			$food_data  = filter_var( $_POST['foodData'], FILTER_SANITIZE_STRING );
			$human_date = filter_var( $_POST['humanDate'], FILTER_SANITIZE_STRING );
			$first_name = filter_var( $_POST['firstName'], FILTER_SANITIZE_STRING );
			$last_name  = filter_var( $_POST['lastName'], FILTER_SANITIZE_STRING );
			$wpuserid   = filter_var( $_POST['wpUserId'], FILTER_SANITIZE_NUMBER_INT );

			$diet_save_array = array(
				'foodstring' => $food_data,
				'humandate'  => $human_date,
				'firstname'  => $first_name,
				'lastname'   => $last_name,
				'wpuserid'   => $wpuserid,
			);

			// Requiring & Calling the file/class that will insert or update our data.
			require_once WPHEALTHTRACKER_DIET_DIR . 'class-wphealthtracker-save-diet-data.php';
			$save_class      = new WPHEALTHTRACKER_Save_Diet_Data( $diet_save_array );
			$db_write_result = $save_class->wphealthtracker_jre_save_diet_actual();

			// Build array of values to return to browser.
			$return_array = array(
				$db_write_result,
				$save_class->dbmode,
				$save_class->human_date,
				$save_class->wpuserid,
				$save_class->last_query,
				$save_class->transients_deleted,
				wp_json_encode( $save_class->diet_save_array ),
			);

			// Serialize array.
			$return_array = wp_json_encode( $return_array );
			wp_die( $return_array );
		}
	}

endif;


