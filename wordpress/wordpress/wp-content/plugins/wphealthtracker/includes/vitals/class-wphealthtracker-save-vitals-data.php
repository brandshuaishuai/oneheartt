<?php
/**
 * Class WPHealthTracker_Save_Vitals_Data - class-save-vitals-data.php
 *
 * @author   Jake Evans
 * @category Admin
 * @package  Includes/Vitals
 * @version  0.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPHEALTHTRACKER_Save_Vitals_Data', false ) ) :

	/**
	 * WPHEALTHTRACKER_Save_Vitals_Data class. This class will hold all of the logic needed to save the user's Vitals data.
	 */
	class WPHEALTHTRACKER_Save_Vitals_Data {

		/** Common member variable
		 *
		 *  @var string $human_date
		 */
		public $human_date = '';

		/** Common member variable
		 *
		 *  @var string $first_name
		 */
		public $first_name = '';

		/** Common member variable
		 *
		 *  @var string $last_name
		 */
		public $last_name = '';

		/** Common member variable
		 *
		 *  @var string $wpuserid
		 */
		public $wpuserid = '';

		/** Common member variable
		 *
		 *  @var object $transients
		 */
		public $transients = '';

		/** Common member variable
		 *
		 *  @var string $dbmode
		 */

		public $dbmode = '';

		/** Common member variable
		 *
		 *  @var string $db_result
		 */
		public $db_result = '';

		/** Common member variable
		 *
		 *  @var string $vitals_table
		 */
		public $vitals_table = '';

		/** Common member variable
		 *
		 *  @var array $vitals_save_array
		 */
		public $vitals_save_array = array();

		/** Common member variable
		 *
		 *  @var string $last_query
		 */
		public $last_query = '';

		/** Common member variable
		 *
		 *  @var string $transients_deleted
		 */
		public $transients_deleted = 'No Transients Deleted';

		/** Class Constructor
		 *
		 *  @param array $vitals_save_array - The user's array of data to save - all diet items.
		 */
		public function __construct( $vitals_save_array = array() ) {

			global $wpdb;
			$this->vitals_save_array = $vitals_save_array;
			$this->human_date        = $vitals_save_array['humandate'];
			$this->wpuserid          = $vitals_save_array['wpuserid'];
			$this->first_name        = $vitals_save_array['firstname'];
			$this->last_name         = $vitals_save_array['lastname'];
			$this->vitals_table      = $wpdb->prefix . 'wphealthtracker_user_daily_data_vitals';

			// Require the Transients file.
			require_once WPHEALTHTRACKER_CLASSES_TRANSIENTS_DIR . 'class-wphealthtracker-transients.php';
			$this->transients = new WPHealthTracker_Transients();

			// Determine if we're updating a row or inserting a new row.
			$this->wphealthtracker_jre_determine_insert_or_update();

		}

		/**
		 *  Determine if we're updating a row or inserting a new row.
		 */
		public function wphealthtracker_jre_determine_insert_or_update() {

			global $wpdb;
			$query = $wpdb->prepare( "SELECT * FROM $this->vitals_table WHERE (wpuserid = %d AND humandate = %s)", $this->wpuserid, $this->human_date );
			$wpdb->get_row( $query );

			if ( $wpdb->num_rows > 0 ) {
				$this->dbmode = 'update';
			} else {
				$this->dbmode = 'insert';
			}

			return $this->dbmode;

		}

		/**
		 *  Actually save the user's Vitals data.
		 */
		public function wphealthtracker_jre_save_vitals_actual() {

			global $wpdb;
			// If we already have a row of saved data for this user on humandate, just update.
			if ( 'update' === $this->dbmode ) {

				$data_format     = array( '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d' );
				$where           = array(
					'wpuserid'  => $this->wpuserid,
					'humandate' => $this->human_date,
				);
				$where_format    = array( '%d', '%s' );
				$this->db_result = $wpdb->update( $this->vitals_table, $this->vitals_save_array, $where, $data_format, $where_format );
			}

			// If we don't have data saved for this user on this date, save it.
			if ( 'insert' === $this->dbmode ) {

				$this->db_result = $wpdb->insert( $this->vitals_table, $this->vitals_save_array, array( '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d' ) );

			}

			$this->last_query = $wpdb->last_query;
			if ( false === $this->db_result ) {
				$this->db_result = $wpdb->last_error;
			}

			// If we modified the DB in any way (if there were no errors and if more than 0 rows were affected), then check for an existing applicable Transient and delete it.
			if ( $this->db_result > 0 ) {
				require_once WPHEALTHTRACKER_CLASSES_TRANSIENTS_DIR . 'class-wphealthtracker-transients.php';
				$transients = new WPHealthTracker_Transients();

				// Transients to check for and delete if they exist.
				$transient_name1 = 'wpht_' . $this->wpuserid . '_' . md5( 'SELECT * FROM ' . $this->vitals_table . ' WHERE wpuserid = ' . $this->wpuserid . ' ORDER BY humandate DESC LIMIT 8' );
				$transient_name2 = 'wpht_' . $this->wpuserid . '_' . md5( 'SELECT * FROM ' . $this->vitals_table . ' WHERE wpuserid = ' . $this->wpuserid . ' ORDER BY humandate DESC LIMIT 31' );
				$transient_name3 = 'wpht_' . $this->wpuserid . '_' . md5( 'SELECT * FROM ' . $this->vitals_table . ' WHERE wpuserid = ' . $this->wpuserid . ' ORDER BY humandate DESC LIMIT 61' );
				$transient_name4 = 'wpht_' . $this->wpuserid . '_' . md5( 'SELECT * FROM ' . $this->vitals_table . ' WHERE wpuserid = ' . $this->wpuserid . ' ORDER BY humandate DESC LIMIT 91' );
				$transient_name5 = 'wpht_' . $this->wpuserid . '_' . md5( 'SELECT * FROM ' . $this->vitals_table . ' WHERE wpuserid = ' . $this->wpuserid );

				// Actually attempting to delete transients.
				$result1 = $transients->delete_transient( $transient_name1 );
				$result2 = $transients->delete_transient( $transient_name2 );
				$result3 = $transients->delete_transient( $transient_name3 );
				$result4 = $transients->delete_transient( $transient_name4 );
				$result5 = $transients->delete_transient( $transient_name5 );

				// Recording results of transient deletion (which were actually deleted, if any).
				if ( $result1 || $result2 || $result3 || $result4 || $result5 ) {
					$this->transients_deleted = '';
				}
				if ( $result1 ) {
					$this->transients_deleted = $this->transients_deleted . 'SELECT * FROM ' . $this->vitals_table . ' WHERE wpuserid = ' . $this->wpuserid . ' ORDER BY humandate DESC LIMIT 8 ---- ';
				}
				if ( $result2 ) {
					$this->transients_deleted = $this->transients_deleted . ' --- SELECT * FROM ' . $this->vitals_table . ' WHERE wpuserid = ' . $this->wpuserid . ' ORDER BY humandate DESC LIMIT 31 ---- ';
				}
				if ( $result3 ) {
					$this->transients_deleted = $this->transients_deleted . ' --- SELECT * FROM ' . $this->vitals_table . ' WHERE wpuserid = ' . $this->wpuserid . ' ORDER BY humandate DESC LIMIT 61 ---- ';
				}
				if ( $result4 ) {
					$this->transients_deleted = $this->transients_deleted . ' --- SELECT * FROM ' . $this->vitals_table . ' WHERE wpuserid = ' . $this->wpuserid . ' ORDER BY humandate DESC LIMIT 91';
				}
				if ( $result5 ) {
					$this->transients_deleted = $this->transients_deleted . ' --- SELECT * FROM ' . $this->vitals_table . ' WHERE wpuserid = ' . $this->wpuserid;
				}
			}
			return $this->db_result;
		}
	}
endif;

