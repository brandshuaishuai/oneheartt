<?php

/**
 * Class WPHealthTracker_Vitals_Ajax_Functions - wphealthtracker-vitals-ajax.php
 *
 * @author   Jake Evans
 * @category Admin
 * @package  Includes/Vitals
 * @version  0.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPHealthTracker_Vitals_Ajax_Functions', false ) ) :
	/**
	 * WPHealthTracker_Vitals_Ajax_Functions class. Here we'll house all of the Ajax Callback functions we'll need to
	 * make the Vitals tab run as expected. The initial functions that send calls to the functions in this file are
	 * located in the wphealthtracker-vitals-js.js JavaScript file.
	 */
	class WPHealthTracker_Vitals_Ajax_Functions {

		/**
		 * Class Constructor
		 */
		public function __construct() {

			// Set the date.
			require_once WPHEALTHTRACKER_CLASSES_UTILITIES_DIR . 'class-wphealthtracker-utilities-date.php';
			$utilities_date = new WPHealthTracker_Utilities_Date();
			$this->date     = $utilities_date->wphealthtracker_get_date_via_current_time( 'mysql' );
		}

		// Callback function for populating the tab with the selected user's saved data and/or the blank form.
		public function wphealthtracker_jre_selecteduser_vitals_enter_action_callback() {
			global $wpdb;
			check_ajax_referer( 'wphealthtracker_jre_selecteduser_vitals_enter_action_callback', 'security' );
			$wpuserid = filter_var( $_POST['wpuserid'], FILTER_SANITIZE_NUMBER_INT );
			$offset   = filter_var( $_POST['offset'], FILTER_SANITIZE_NUMBER_INT );

			// Get the user's name for messaging
			$users_master_table = $wpdb->prefix . 'wphealthtracker_users';

			// Make call to Transients class to see if Transient currently exists. If so, retrieve it, if not, make call to create_transient() with all required Parameters
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

			// Setting the first and last name of user
			$userfirst = $username->firstname;
			$userlast  = $username->lastname;

			// Get user's DATA FOR TODAY ONLY, if it exists
			$userdailydata          = array();
			$users_daily_table_name = $wpdb->prefix . 'wphealthtracker_user_daily_data_vitals';
			// Make call to Transients class to see if Transient currently exists. If so, retrieve it, if not, make call to create_transient() with all required Parameters
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
				if ( $value->humandate == $this->date ) {
					$todayflag     = true;
					$userdailydata = $value;
				}
			}

			// If no data for today was found, create the userdailydata object that 'class-vitals-forms-actual.php' will use just to be verbose, prevent PHP error messages, and to pass today's date and first and last name.
			if ( ! $todayflag ) {
				$userdailydata                = new \stdClass();
				$userdailydata->humandate     = $this->date;
				$userdailydata->firstname     = $userfirst;
				$userdailydata->lastname      = $userlast;
				$userdailydata->wpuserid      = $wpuserid;
				$userdailydata->weight        = '';
				$userdailydata->bloodpressure = '';
				$userdailydata->bloodoxygen   = '';
				$userdailydata->bodytemp      = '';
				$userdailydata->cholesterol   = '';
				$userdailydata->heartrate     = '';
				$userdailydata->bloodsugar    = '';
				$userdailydata->vitalsimg     = '';
				$userdailydata->vitalsfiles   = '';
			}

			// Require the file that contains the class that will output the forms needed for the Vitals tab
			require_once WPHEALTHTRACKER_VITALS_DIR . 'class-wphealthtracker-vitals-forms-actual.php';

			// Instantiate the class and get the final output for the current day's data.
			$tabformclass_today = new WPHEALTHTRACKER_Vitals_Forms_Actual();
			$tabformclass_today->output_today_data( $userdailydata );

			// Build array of values to return to browser
			$return_array = array(
				$tabformclass_today->final_complete_output,
				json_encode( $userdailydata ),
				$userfirst,
				$userlast,
				$this->date,
				$wpuserid,
			);

			// Serialize array
			$return_array = json_encode( $return_array );

			// Return and die.
			wp_die( $return_array );
		}


		// Callback function for populating the 'View' Container
		public function wphealthtracker_jre_selecteduser_vitals_view_action_callback() {
			global $wpdb;
			check_ajax_referer( 'wphealthtracker_jre_selecteduser_vitals_view_action_callback', 'security' );
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

			// Setting the first and last name of user
			$userfirst = $username->firstname;
			$userlast  = $username->lastname;

			// Get ALL DATA saved for this user from every previous date
			$useralldata            = array();
			$users_daily_table_name = $wpdb->prefix . 'wphealthtracker_user_daily_data_vitals';
			// Make call to Transients class to see if Transient currently exists. If so, retrieve it, if not, make call to create_transient() with all required Parameters
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
				if ( $value->humandate == $this->date ) {
					unset( $useralldata[ $key ] );
					$unset_flag = true;
				}
			}

			// If we didn't find today's date, we need to remove one entry to ensure user only sees past 7 days, to comply with the filter drop-down value, but only if the results are greater than 7
			if ( $unset_flag === false && sizeof( $useralldata ) > 7 ) {
				array_pop( $useralldata );
			}

			// Require the file that contains the class that will output the forms needed for the Vitals tab
			require_once WPHEALTHTRACKER_VITALS_DIR . 'class-wphealthtracker-vitals-forms-actual.php';

			// Instantiate the class and get the final output for the current day's data
			$tabformclass_previous = new WPHEALTHTRACKER_Vitals_Forms_Actual();
			$tabformclass_previous->output_previous_data( $useralldata, $userfirst, $userlast, $wpuserid );

			// Build array of values to return to browser
			$return_array = array(
				$tabformclass_previous->final_complete_output,
				json_encode( $useralldata ),
				$userfirst,
				$userlast,
				$this->date,
				$wpuserid,
			);

			// Serialize array
			$return_array = json_encode( $return_array );

			// Return and die.
			wp_die( $return_array );
		}

		// Callback function for the wphealthtracker_jre_save_vitals_data() function found in wphealthtracker-vitals-js.js - for saving user's data.
		public function wphealthtracker_jre_save_vitals_data_action_callback() {
			global $wpdb;
			check_ajax_referer( 'wphealthtracker_jre_save_vitals_data_action_callback', 'security' );

			$finalWeightString = filter_var( $_POST['finalWeight'], FILTER_SANITIZE_STRING );
			$finalChString     = filter_var( $_POST['finalCholesterol'], FILTER_SANITIZE_STRING );
			$finalBpString     = filter_var( $_POST['finalBp'], FILTER_SANITIZE_STRING );
			$finalBsString     = filter_var( $_POST['finalBs'], FILTER_SANITIZE_STRING );
			$finalBoString     = filter_var( $_POST['finalBo'], FILTER_SANITIZE_STRING );
			$finalBtString     = filter_var( $_POST['finalBt'], FILTER_SANITIZE_STRING );
			$finalHrString     = filter_var( $_POST['finalHr'], FILTER_SANITIZE_STRING );
			$finalImagesString = filter_var( $_POST['finalImg'], FILTER_SANITIZE_STRING );
			$finalFilesString  = filter_var( $_POST['finalFiles'], FILTER_SANITIZE_STRING );
			$humanDate         = filter_var( $_POST['humanDate'], FILTER_SANITIZE_STRING );
			$firstName         = filter_var( $_POST['firstName'], FILTER_SANITIZE_STRING );
			$lastName          = filter_var( $_POST['lastName'], FILTER_SANITIZE_STRING );
			$wpUserId          = filter_var( $_POST['wpUserId'], FILTER_SANITIZE_NUMBER_INT );

			$vitals_save_array = array(
				'weight'        => $finalWeightString,
				'cholesterol'   => $finalChString,
				'bloodpressure' => $finalBpString,
				'bloodsugar'    => $finalBsString,
				'bloodoxygen'   => $finalBoString,
				'bodytemp'      => $finalBtString,
				'heartrate'     => $finalHrString,
				'vitalsimg'     => $finalImagesString,
				'vitalsfiles'   => $finalFilesString,
				'humandate'     => $humanDate,
				'firstname'     => $firstName,
				'lastname'      => $lastName,
				'wpuserid'      => $wpUserId,
			);

			// Requiring & Calling the file/class that will insert or update our data
			require_once WPHEALTHTRACKER_VITALS_DIR . 'class-wphealthtracker-save-vitals-data.php';
			$save_class      = new WPHEALTHTRACKER_Save_Vitals_Data( $vitals_save_array );
			$db_write_result = $save_class->wphealthtracker_jre_save_vitals_actual();

			// Build array of values to return to browser
			$return_array = array(
				$db_write_result,
				$save_class->dbmode,
				$save_class->humandate,
				$save_class->wpuserid,
				$save_class->last_query,
				$save_class->transients_deleted,
				json_encode( $save_class->vitals_save_array ),
			);

			// Serialize array
			$return_array = json_encode( $return_array );

			// Return and die.
			wp_die( $return_array );
		}

		// Callback function for the wphealthtracker_jre_selecteduser_vitals_filter_data() function found in wphealthtracker-vitals-js.js - For grabbing and outputting data when the 'Filter' button is clicked...
		public function wphealthtracker_jre_selecteduser_vitals_filter_data_action_callback() {
			global $wpdb;
			check_ajax_referer( 'wphealthtracker_jre_selecteduser_vitals_filter_data_action_callback', 'security' );

			$wpuserid  = filter_var( $_POST['wpuserid'], FILTER_SANITIZE_NUMBER_INT );
			$filterval = filter_var( $_POST['filterval'], FILTER_SANITIZE_NUMBER_INT ) + 1;

			// Get the user's name for messaging
			$users_master_table = $wpdb->prefix . 'wphealthtracker_users';

			// Make call to Transients class to see if Transient currently exists. If so, retrieve it, if not, make call to create_transient() with all required Parameters
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

			// Setting the first and last name of user
			$userfirst = $username->firstname;
			$userlast  = $username->lastname;

			// Get data saved for this user based on $filterval
			$useralldata            = array();
			$users_daily_table_name = $wpdb->prefix . 'wphealthtracker_user_daily_data_vitals';
			// Make call to Transients class to see if Transient currently exists. If so, retrieve it, if not, make call to create_transient() with all required Parameters
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
				if ( $value->humandate == $this->date ) {
					unset( $useralldata[ $key ] );
					$unset_flag = true;
				}
			}

			// If we didn't find today's date, we need to remove one entry to ensure user only sees past $filterval days, to comply with the filter drop-down value, but only if size of results are greater than $filterval-1
			if ( $unset_flag === false && sizeof( $useralldata ) > ( $filterval - 1 ) ) {
				array_pop( $useralldata );
			}

			// Require the file that contains the class that will output the forms needed for the Vitals tab
			require_once WPHEALTHTRACKER_VITALS_DIR . 'class-wphealthtracker-vitals-forms-actual.php';

			// Instantiate the class and get the final output for the current day's data
			$tabformclass_previous = new WPHEALTHTRACKER_Vitals_Forms_Actual();
			$tabformclass_previous->output_previous_data( $useralldata, $userfirst, $userlast, $wpuserid );

			// Build array of values to return to browser
			$return_array = array(
				$tabformclass_previous->final_complete_output,
				json_encode( $useralldata ),
				$userfirst,
				$userlast,
				$this->date,
				$wpuserid,
			);

			// Serialize array
			$return_array = json_encode( $return_array );

			// Return and die.
			wp_die( $return_array );

		}

	}

endif;


