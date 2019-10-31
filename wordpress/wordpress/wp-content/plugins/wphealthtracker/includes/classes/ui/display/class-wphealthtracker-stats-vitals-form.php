<?php
/**
 * Class WPHEALTHTRACKER_Stats_Vitals_Form - class-stats-vitals-form.php
 *
 * @author   Jake Evans
 * @category Display
 * @package  Includes/Classes/UI/Display
 * @version  0.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPHEALTHTRACKER_Stats_Vitals_Form', false ) ) :
	/**
	 * WPHEALTHTRACKER_Stats_Vitals_Form.
	 */
	class WPHEALTHTRACKER_Stats_Vitals_Form {

		/** Common member variable
		 *
		 *  @var object $allusers
		 */
		public $allusers = null;

		/** Common member variable
		 *
		 *  @var object $general_settings
		 */
		public $general_settings = null;

		/** Common member variable
		 *
		 *  @var object $default_user
		 */
		public $default_user = null;

		/** Common member variable
		 *
		 *  @var string $userstring
		 */
		public $userstring = '';

		/** Common member variable
		 *
		 *  @var object $trans
		 */
		public $trans;

		/**
		 * Constructor that calls all of the Classes functions upon instantiation.
		 */
		public function __construct() {

			global $wpdb;

			// First we'll get all the translations for this tab.
			require_once WPHEALTHTRACKER_CLASSES_TRANSLATIONS_DIR . 'class-wphealthtracker-translations.php';
			$this->trans = new WPHealthTracker_Translations();
			$this->trans->common_trans_strings();

			// Get all the saved users we have.
			$this->wphealthtracker_get_all_saved_users();

			// Get default user.
			$this->wphealthtracker_get_default_user();

			// Output either the drop-down or the 'No Users' message.
			$this->wphealthtracker_output_all_saved_users();

			// Output final HTML.
			$this->output_create_vitals_stats_form();

		}

		/**
		 * Get all saved Users from the WPHealthTracker Users table
		 */
		public function wphealthtracker_get_all_saved_users() {

			global $wpdb;

			// Get all saved Users from the WPHealthTracker Users table.
			$users_table_name = $wpdb->prefix . 'wphealthtracker_users';

			// Make call to Transients class to see if Transient currently exists. If so, retrieve it, if not, make call to create_transient() with all required Parameters.
			require_once WPHEALTHTRACKER_CLASSES_TRANSIENTS_DIR . 'class-wphealthtracker-transients.php';
			$transients       = new WPHealthTracker_Transients();
			$transient_name   = 'wpht_' . md5( 'SELECT * FROM ' . $users_table_name . ' ORDER BY firstname' );
			$transient_exists = $transients->existing_transient_check( $transient_name );
			if ( $transient_exists ) {
				$this->allusers = $transient_exists;
			} else {
				$query          = 'SELECT * FROM ' . $users_table_name . ' ORDER BY firstname';
				$this->allusers = $transients->create_transient( $transient_name, 'wpdb->get_results', $query, MONTH_IN_SECONDS );
			}
		}

		/**
		 * Function that will get default user, if one exists
		 */
		public function wphealthtracker_get_default_user() {

			// First grab entry in wphealthtracker_general_settings, then look that user up in wphealthtracker_users.
			global $wpdb;

			// Make call to Transients class to see if Transient currently exists. If so, retrieve it, if not, make call to create_transient() with all required Parameters.
			require_once WPHEALTHTRACKER_CLASSES_TRANSIENTS_DIR . 'class-wphealthtracker-transients.php';
			$transients          = new WPHealthTracker_Transients();
			$settings_table_name = $wpdb->prefix . 'wphealthtracker_general_settings';
			$transient_name      = 'wpht_' . md5( 'SELECT * FROM ' . $settings_table_name );
			$transient_exists    = $transients->existing_transient_check( $transient_name );
			if ( $transient_exists ) {
				$this->general_settings = $transient_exists;
			} else {
				$query                  = 'SELECT * FROM ' . $settings_table_name;
				$this->general_settings = $transients->create_transient( $transient_name, 'wpdb->get_row', $query, MONTH_IN_SECONDS );
			}

			// If the 'defaultwpuser' column isn't null...
			if ( null !== $this->general_settings->defaultwpuser ) {
				$this->default_user = $this->general_settings->defaultwpuser;
			}
		}

		/**
		 * Build the 'Select a User' drop-down
		 */
		public function wphealthtracker_output_all_saved_users() {

			// Create string of Users for the 'Select a User' dropdown, or display a 'No users yet' message.
			if ( null !== $this->allusers ) {

				$this->userstring = '<select autocomplete="off" class="wphealthtracker-user-dropdown-select" id="wphealthtracker-user-dropdown-select-vital-stats" data-select-tab="vitals"><option selected default disabled>' . $this->trans->common_trans_16 . '</option>';

				// This entire if/else section deals with checking whether the user has permissions or not.
				global $wpdb;
				if ( null === $this->default_user ) {
					// Set the current WordPress user.
					$currentwpuser = wp_get_current_user();

					// Make call to Transients class to see if Transient currently exists. If so, retrieve it, if not, make call to create_transient() with all required Parameters.
					$users_table_name = $wpdb->prefix . 'wphealthtracker_users';
					require_once WPHEALTHTRACKER_CLASSES_TRANSIENTS_DIR . 'class-wphealthtracker-transients.php';
					$transients       = new WPHealthTracker_Transients();
					$transient_name   = 'wpht_' . md5( 'SELECT * FROM ' . $users_table_name . ' WHERE wpuserid == ' . $currentwpuser->ID );
					$transient_exists = $transients->existing_transient_check( $transient_name );
					if ( $transient_exists ) {
						$this->default_user_data = $transient_exists;
					} else {
						$query                    = 'SELECT * FROM ' . $users_table_name . '  WHERE wpuserid = ' . $currentwpuser->ID;
						$this->default_user_data  = $transients->create_transient( $transient_name, 'wpdb->get_row', $query, MONTH_IN_SECONDS );
					}
				} else {
					// Make call to Transients class to see if Transient currently exists. If so, retrieve it, if not, make call to create_transient() with all required Parameters.
					$users_table_name = $wpdb->prefix . 'wphealthtracker_users';
					require_once WPHEALTHTRACKER_CLASSES_TRANSIENTS_DIR . 'class-wphealthtracker-transients.php';
					$transients       = new WPHealthTracker_Transients();
					$transient_name   = 'wpht_' . md5( 'SELECT * FROM ' . $users_table_name . ' WHERE wpuserid == ' . $this->default_user );
					$transient_exists = $transients->existing_transient_check( $transient_name );
					if ( $transient_exists ) {
						$this->default_user_data = $transient_exists;
					} else {
						$query                    = 'SELECT * FROM ' . $users_table_name . '  WHERE wpuserid = ' . $this->default_user;
						$this->default_user_data  = $transients->create_transient( $transient_name, 'wpdb->get_row', $query, MONTH_IN_SECONDS );
					}
				}

				// Now get the user's permissions.
				$user_perm = explode( ',', $this->default_user_data->permissions );

				if ( '1' === $user_perm[13] ) {

					foreach ( $this->allusers as $key => $user ) {

						if ( $this->default_user === $user->wpuserid ) {
							$this->userstring = $this->userstring . '<option selected value="' . $user->wpuserid . '">' . $user->firstname . ' ' . $user->lastname . '</option>';
						} else {
							$this->userstring = $this->userstring . '<option value="' . $user->wpuserid . '">' . $user->firstname . ' ' . $user->lastname . '</option>';
						}
					}
				} else {
					$this->userstring = $this->userstring . '<option selected value="' . $this->default_user_data->wpuserid . '">' . $this->default_user_data->firstname . ' ' . $this->default_user_data->lastname . '</option>';
				}

				$this->userstring = $this->userstring . '</select>';

			} else {
				$this->userstring = '<img class="wphealthtracker-shocked-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'shocked.svg"><p class="wphealthtracker-user-dropdown-p">' . $this->trans->common_trans_14 . '<br/><a href="' . menu_page_url( 'WPHEALTHTRACKER-Options-users', false ) . '">' . $this->trans->common_trans_15 . '</a></p>';
			}
		}

		/**
		 * Outputting the default 'Enter' and 'View' containers for the 'Tracker' tabs
		 */
		public function output_create_vitals_stats_form() {
			$string1              = '<div class="wphealthtracker-select-user-container">	
						<div class="wphealthtracker-user-dropdown-div">
							<p class="wphealthtracker-user-dropdown-p wphealthtracker-p-title"><img class="wphealthtracker-icon-image-question" id="wphealthtracker-icon-image-question-id-1" data-label="selectauser" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg" />' . $this->trans->common_trans_16 . ':</p>
								' . $this->userstring . '
						</div>
						<div class="wphealthtracker-spinner-primary" id="wphealthtracker-spinner-1"></div>
						<div class="wphealthtracker-stats-actual-top-div" id="wphealthtracker-stats-actual-top-div-1">

							<div class="wphealthtracker-stats-actual-inner-div" id="wphealthtracker-stats-actual-inner-div-1">

							</div>
						</div>

						<div class="wphealthtracker-stats-actual-top-div-d3 wphealthtracker-stats-actual-vitals-top-div" id="wphealthtracker-stats-inner-d3-1">
							<div class="wphealthtracker-spinner-primary-d3-await" id="wphealthtracker-spinner-d3-await-1"></div>
							<div class="wphealthtracker-d3-chart-title-div" id="wphealthtracker-d3-chart-title-div-1-1">

							</div>
							<div class="wphealthtracker-stats-actual-top-div-inner-left" id="wphealthtracker-stats-actual-inner-d3-1-1">

							</div>
							<div class="wphealthtracker-stats-actual-top-div-inner-right" id="wphealthtracker-stats-actual-inner-d3-2-1">

							</div>

						</div>
						<div class="wphealthtracker-stats-actual-top-div-d3 wphealthtracker-stats-actual-vitals-top-div" id="wphealthtracker-stats-inner-d3-2">
							<div class="wphealthtracker-spinner-primary-d3-await" id="wphealthtracker-spinner-d3-await-2"></div>
							<div class="wphealthtracker-d3-chart-title-div" id="wphealthtracker-d3-chart-title-div-1-2">

							</div>
							<div class="wphealthtracker-stats-actual-top-div-inner-left" id="wphealthtracker-stats-actual-inner-d3-1-2">

							</div>
							<div class="wphealthtracker-stats-actual-top-div-inner-right" id="wphealthtracker-stats-actual-inner-d3-2-2">

							</div>

						</div>
						<div class="wphealthtracker-stats-actual-top-div-d3 wphealthtracker-stats-actual-vitals-top-div" id="wphealthtracker-stats-inner-d3-3">
							<div class="wphealthtracker-spinner-primary-d3-await" id="wphealthtracker-spinner-d3-await-3"></div>
							<div class="wphealthtracker-d3-chart-title-div" id="wphealthtracker-d3-chart-title-div-1-3">

							</div>
							<div class="wphealthtracker-stats-actual-top-div-inner-left" id="wphealthtracker-stats-actual-inner-d3-1-3">

							</div>
							<div class="wphealthtracker-stats-actual-top-div-inner-right" id="wphealthtracker-stats-actual-inner-d3-2-3">

							</div>

						</div>
					</div>';
			$this->initial_output = $string1;
		}
	}
endif;
