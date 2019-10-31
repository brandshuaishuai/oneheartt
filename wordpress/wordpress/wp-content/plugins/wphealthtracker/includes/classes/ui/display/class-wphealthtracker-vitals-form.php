<?php
/**
 * Class WPHEALTHTRACKER_Vitals_Form - class-vitals-form.php
 *
 * @author   Jake Evans
 * @category Display
 * @package  Includes/Classes/UI/Display
 * @version  0.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPHEALTHTRACKER_Vitals_Form', false ) ) :
	/**
	 * WPHEALTHTRACKER_Vitals_Form.
	 */
	class WPHEALTHTRACKER_Vitals_Form {

		/** Common member variable
		 *
		 *  @var string $userstring
		 */
		public $userstring = '';

		/** Common member variable
		 *
		 *  @var string $date
		 */
		public $date = '';

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
		 *  @var object $default_user_data
		 */
		public $default_user_data = null;

		/** Common member variable
		 *
		 *  @var object $trans
		 */
		public $trans;

		/**
		 * Class Constructor
		 */
		public function __construct() {

			global $wpdb;

			// First we'll get all the translations for this tab.
			require_once WPHEALTHTRACKER_CLASSES_TRANSLATIONS_DIR . 'class-wphealthtracker-translations.php';
			$this->trans = new WPHealthTracker_Translations();
			$this->trans->common_trans_strings();

			// Set the date.
			require_once WPHEALTHTRACKER_CLASSES_UTILITIES_DIR . 'class-wphealthtracker-utilities-date.php';
			$utilities_date = new WPHealthTracker_Utilities_Date();
			$this->date     = $utilities_date->wphealthtracker_get_date_via_current_time( 'mysql' );

			// Get all the saved users we have.
			$this->wphealthtracker_get_all_saved_users();

			// Get default user.
			$this->wphealthtracker_get_default_user();

			// Output either the drop-down or the 'No Users' message.
			$this->wphealthtracker_output_all_saved_users();

			// Output final HTML.
			$this->output_create_vitals_form();

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
		 * Get all saved Users from the WPHealthTracker Users table.
		 */
		public function wphealthtracker_output_all_saved_users() {

			// Create string of Users for the 'Select a User' dropdown, or display a 'No users yet' message.
			if ( null !== $this->allusers ) {

				$this->userstring = '<select autocomplete="off" class="wphealthtracker-user-dropdown-select" id="wphealthtracker-user-dropdown-select-vitals" data-select-tab="vitals"><option selected default disabled value="default">' . $this->trans->common_trans_16 . '</option>';


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
						$query = 'SELECT * FROM ' . $users_table_name . '  WHERE wpuserid = ' . $currentwpuser->ID;
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

				if ( '1' === $user_perm[9] ) {

					foreach ( $this->allusers as $key => $user ) {

						if ( $this->default_user == $user->wpuserid ) {
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
		 * Creates the Enter and View containers
		 */
		public function output_create_vitals_form() {
			$string1 = '<div class="wphealthtracker-select-user-container">	
						<div class="wphealthtracker-user-dropdown-div">
							<p class="wphealthtracker-user-dropdown-p wphealthtracker-p-title"><img class="wphealthtracker-icon-image-question" id="wphealthtracker-icon-image-question-id-1" data-label="selectauser" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg" />' . $this->trans->common_trans_16 . ':</p>
								' . $this->userstring . '
						</div>
						<div class="wphealthtracker-spinner-primary" id="wphealthtracker-spinner-1"></div>
						<div class="wphealthtracker-p-title" id="wphealthtracker-choose-title">' . $this->trans->common_trans_17 . '</div>
					</div>
					<div id="wphealthtracker-choice-container">
						<div class="wphealthtracker-indiv-choice" id="wphealthtracker-indiv-choice-enter">
							<div class="wphealthtracker-expansion-div" id="wphealthtracker-expansion-div-enter">
								<div class="wphealthtracker-expand-minimize-div">
									<p class="wphealthtracker-expand-minimize-p" id="wphealthtracker-expand-minimize-p-enter">' . $this->trans->common_trans_1 . '</p>
									<img src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'rotate.svg" class="wphealthtracker-indiv-choice-img-rotate" id="wphealthtracker-indiv-choice-img-rotate-enter" />
								</div>
								<img src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'data-entry.svg" class="wphealthtracker-indiv-choice-img" />
								<p class="wphealthtracker-indiv-choice-p">' . $this->trans->common_trans_5 . ' ' . $this->date . '</p>
							</div>
							<div class="wphealthtracker-selected-user-response-enter-div" id="wphealthtracker-response-form-data-row-actual-0">
							</div>
						</div>
						<div class="wphealthtracker-indiv-choice" id="wphealthtracker-indiv-choice-view">
							<div class="wphealthtracker-expansion-div" id="wphealthtracker-expansion-div-view">
								<div class="wphealthtracker-expand-minimize-div">
									<p class="wphealthtracker-expand-minimize-p" id="wphealthtracker-expand-minimize-p-view">' . $this->trans->common_trans_1 . '</p>
									<img src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'rotate.svg" class="wphealthtracker-indiv-choice-img-rotate" id="wphealthtracker-indiv-choice-img-rotate-view" />
								</div>
								<img src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'saved-data.svg" class="wphealthtracker-indiv-choice-img" />
								<p class="wphealthtracker-indiv-choice-p">' . $this->trans->common_trans_7 . '</p>
							</div>
							<div class="wphealthtracker-selected-user-response-view-div" id="wphealthtracker-selected-user-response-id-view">
							</div>
						</div>
					</div>';
			$this->initial_output = $string1;
		}
	}
endif;
