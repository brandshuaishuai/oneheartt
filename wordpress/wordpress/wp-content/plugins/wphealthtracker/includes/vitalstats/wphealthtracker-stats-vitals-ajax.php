<?php

/**
 * Class WPHealthTracker_Stats_Vitals_Ajax_Functions - wphealthtracker-stats-vitals-ajax.php
 *
 * @author   Jake Evans
 * @category Admin
 * @package  Includes/Vitals
 * @version  0.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPHealthTracker_Stats_Vitals_Ajax_Functions', false ) ) :
	/**
	 * WPHealthTracker_Stats_Vitals_Ajax_Functions class. Here we'll house all of the Ajax Callback functions we'll need to
	 * make the Stats Vitals tab run as expected. The initial functions that send calls to the functions in this file are
	 * located in the wphealthtracker-stats-vitals-js.js JavaScript file.
	 */
	class WPHealthTracker_Stats_Vitals_Ajax_Functions {

		// Callback function for grabbing all the selected user's saved data
		public function wphealthtracker_jre_grab_user_data_for_vitals_dashboard_action_callback() {

			global $wpdb;
			check_ajax_referer( 'wphealthtracker_jre_grab_user_data_for_vitals_dashboard_action_callback', 'security' );
			$wpuserid = filter_var( $_POST['wpuserid'], FILTER_SANITIZE_NUMBER_INT );

			// Get all of user's saved data for Dashboard generation
			// Make call to Transients class to see if Transient currently exists. If so, retrieve it, if not, make call to create_transient() with all required Parameters
			require_once WPHEALTHTRACKER_CLASSES_TRANSIENTS_DIR . 'class-wphealthtracker-transients.php';
			$transients             = new WPHealthTracker_Transients();
			$users_daily_table_name = $wpdb->prefix . 'wphealthtracker_user_daily_data_vitals';
			$transient_name         = 'wpht_' . $wpuserid . '_' . md5( 'SELECT * FROM ' . $users_daily_table_name . ' WHERE wpuserid = ' . $wpuserid );
			$transient_exists       = $transients->existing_transient_check( $transient_name );
			if ( $transient_exists ) {
				$userdata = $transient_exists;
			} else {
				$query    = $wpdb->prepare( "SELECT * FROM $users_daily_table_name WHERE wpuserid = %d", $wpuserid );
				$userdata = $transients->create_transient( $transient_name, 'wpdb->get_results', $query, MONTH_IN_SECONDS );
			}

			require_once WPHEALTHTRACKER_CLASSES_DASHBOARDS_DIR . 'class-wphealthtracker-dashboards.php';
			$dashboard = new WPHealthTracker_Dashboards( $userdata, $wpuserid, 'Vitals' );

			if ( sizeof( $userdata ) == 0 ) {
				wp_die( $dashboard->output_no_data() );
			} else {
				wp_die( $dashboard->output_vitals_backend_dashboard() );
			}

		}

		// Callback function for grabbing all the selected user's saved data
		public function wphealthtracker_jre_grab_user_data_for_vitals_d3_action_callback() {

			global $wpdb;
			check_ajax_referer( 'wphealthtracker_jre_grab_user_data_for_vitals_d3_action_callback', 'security' );
			$wpuserid = filter_var( $_POST['wpuserid'], FILTER_SANITIZE_NUMBER_INT );

			// Get ALL user's saved data for d3 chart generation
			// Make call to Transients class to see if Transient currently exists. If so, retrieve it, if not, make call to create_transient() with all required Parameters
			require_once WPHEALTHTRACKER_CLASSES_TRANSIENTS_DIR . 'class-wphealthtracker-transients.php';
			$transients             = new WPHealthTracker_Transients();
			$users_daily_table_name = $wpdb->prefix . 'wphealthtracker_user_daily_data_vitals';
			$transient_name         = 'wpht_' . $wpuserid . '_' . md5( 'SELECT * FROM ' . $users_daily_table_name . ' WHERE wpuserid = ' . $wpuserid );
			$transient_exists       = $transients->existing_transient_check( $transient_name );
			if ( $transient_exists ) {
				$userdata = $transient_exists;
			} else {
				$query    = $wpdb->prepare( "SELECT * FROM $users_daily_table_name WHERE wpuserid = %d", $wpuserid );
				$userdata = $transients->create_transient( $transient_name, 'wpdb->get_results', $query, MONTH_IN_SECONDS );
			}

			// Require the D3 Vitals class
			require_once WPHEALTHTRACKER_CLASSES_D3_VITALS_DIR . 'class-wphealthtracker-d3-vitals.php';
			$d3 = new WPHealthTracker_D3_Vitals( $userdata );

			// Getting all the data we'll need from the WPHealthTracker_D3_Vitals class - could have split up nito 3 or 4 functions, but then we'd have at least 3 or 4 transient calls, which still impact performance even though they're transients, so this is better.
			$d3_1   = $d3->build_data_1();
			$d3_2   = $d3->build_data_2();
			$d3_3   = $d3->build_data_3();
			$titles = $d3->get_title_area_html();
			$stats  = $d3->get_stats_area_html();

			// Building our return array
			$return_array = array();
			array_push( $return_array, $d3_1 );
			array_push( $return_array, $d3_2 );
			array_push( $return_array, $d3_3 );
			array_push( $return_array, $titles );
			array_push( $return_array, $stats );
			$return_array = json_encode( $return_array );

			// Returning final return array
			wp_die( $return_array );

		}



	}

endif;


