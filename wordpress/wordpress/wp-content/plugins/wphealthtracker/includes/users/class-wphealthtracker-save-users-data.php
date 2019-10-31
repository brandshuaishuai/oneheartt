<?php
/**
 * Class WPHealthTracker_Save_Users_Data - class-save-users-data.php
 *
 * @author   Jake Evans
 * @category Admin
 * @package  Includes/Users
 * @version  0.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPHEALTHTRACKER_Save_Users_Data', false ) ) :

	/**
	 * WPHEALTHTRACKER_Save_Users_Data class. This class will hold all of the logic needed to save the user's Users data.
	 */
	class WPHEALTHTRACKER_Save_Users_Data {

		/** Common member variable
		 *
		 *  @var string $human_date
		 */
		public $email = '';

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
		 *  @var string $users_table
		 */
		public $users_table = '';

		/** Common member variable
		 *
		 *  @var array $users_save_array
		 */
		public $users_save_array = array();

		/** Common member variable
		 *
		 *  @var string $db_result
		 */
		public $db_result = '';

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
		 *  @param array $users_save_array - The user's array of data to save - all users items.
		 */
		public function __construct( $users_save_array = array() ) {

			global $wpdb;
			$this->users_save_array = $users_save_array;
			$this->email            = $users_save_array['email'];
			$this->wpuserid         = $users_save_array['wpuserid'];
			$this->first_name       = $users_save_array['firstname'];
			$this->last_name        = $users_save_array['lastname'];
			$this->users_table      = $wpdb->prefix . 'wphealthtracker_users';

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
			$query = $wpdb->prepare( "SELECT * FROM $this->users_table WHERE (wpuserid = %d)", $this->wpuserid );
			$wpdb->get_row( $query );

			if ( $wpdb->num_rows > 0 ) {
				$this->dbmode = 'update';
			} else {
				$this->dbmode = 'insert';
			}

			return $this->dbmode;

		}

		/**
		 *  Actually save the user's Users data.
		 */
		public function wphealthtracker_jre_save_users_actual() {

			global $wpdb;

			// Also make the God check here - if role is godmode...
			$this->prev_god = '';
			if ( 'SuperAdmin' === $this->users_save_array['role'] ) {
				$godmode        = 'godmode';
				$this->prev_god = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $this->users_table WHERE role = %s", $godmode ) );

				$this->users_save_array['role'] = 'godmode';
			}

			// If we already have a row of saved data for this user on humandate, just update.
			if ( 'update' === $this->dbmode ) {

				error_log( print_r( $this->users_save_array, true ) );

				// Update the existing WPHealthtracker User.
				$format          = array( '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s' );
				$where           = array( 'wpuserid' => $this->users_save_array['wpuserid'] );
				$where_format    = array( '%d' );
				$this->db_result = $wpdb->update( $this->users_table, $this->users_save_array, $where, $format, $where_format );

				// If we modified the DB in any way (if there were no errors and if more than 0 rows were affected), then update the actual WordPress User.
				if ( $this->db_result > 0 ) {

					$user_id = wp_update_user( array( 'ID' => $this->users_save_array['wpuserid'], 'user_email' => $this->users_save_array['email'], 'first_name' => $this->users_save_array['firstname'], 'last_name' => $this->users_save_array['lastname'] ) );
				}
			}

			// If we don't have data saved for this user.
			if ( 'insert' === $this->dbmode ) {

				// Determine individual permissions based on role
				if ( 'godmode' === $this->users_save_array['role'] ) {
					$this->users_save_array['permissions'] = '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1';
				} else if ( 'Admin' === $this->users_save_array['role'] ) {
					$this->users_save_array['permissions'] = '1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1';
				} else if ( 'Reviewer' === $this->users_save_array['role'] ) {
					$this->users_save_array['permissions'] = '1,1,1,1,0,0,1,1,1,1,1,1,0,1,1,1,0,0,0,1,1,1';
				} else {
					$this->users_save_array['permissions'] = '1,1,1,1,0,0,1,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0';
				}

				$this->db_result = $wpdb->insert( $this->users_table, $this->users_save_array, array( '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s' ) );
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
				$transient_name1 = 'wpht_' . md5( 'SELECT * FROM ' . $this->users_table . ' ORDER BY firstname' );

				// Actually attempting to delete transients.
				$result1 = $transients->delete_transient( $transient_name1 );

				// Recording results of transient deletion (which were actually deleted, if any).
				if ( $result1 ) {
					$this->transients_deleted = '';
				}
				if ( $result1 ) {
					$this->transients_deleted = $this->transients_deleted . 'SELECT * FROM ' . $this->users_table . ' ORDER BY firstname';
				}

				if ( '' !== $this->prev_god && $this->prev_god->wpuserid !== $this->users_save_array['wpuserid'] ) {

					// Resetting God.
					$data_format           = array( '%s' );
					$where                 = array(
						'wpuserid' => $this->prev_god->wpuserid,
					);
					$where_format          = array( '%d' );
					$this->prev_god_result = $wpdb->update( $this->users_table, array( 'role' => 'Admin', 'permissions' => '1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1' ), $where, $data_format, $where_format );
				}
			}

			return $this->db_result;
		}
	}
endif;

