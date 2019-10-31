<?php
/**
 * Class WPHEALTHTRACKER_Users_Form - class-wphealhtrackers-users-form.php
 *
 * @author   Jake Evans
 * @category Display
 * @package  Includes/Classes/UI/Display
 * @version  0.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPHEALTHTRACKER_Users_Form', false ) ) :
	/**
	 * WPHEALTHTRACKER_Users_Form.
	 */
	class WPHEALTHTRACKER_Users_Form {

		/** Common member variable
		 *
		 *  @var string $userstring
		 */
		public $userstring = '';

		/** Common member variable
		 *
		 *  @var object $currentwpuser
		 */
		public $currentwpuser = '';

		/** Common member variable
		 *
		 *  @var int $currentwphtuser
		 */
		public $currentwphtuser = '';

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
		 *  @var string $role_select_string
		 */
		public $role_select_string = '';

		/** Common member variable
		 *
		 *  @var string $role_warning
		 */
		public $role_warning = '';

		/** Common member variable
		 *
		 *  @var object $trans
		 */
		public $trans;

		/** Common member variable
		 *
		 *  @var string $create_form_part_the_beginning
		 */
		public $create_form_part_the_beginning = '';

		/** Common member variable
		 *
		 *  @var string $create_form_part_one
		 */
		public $create_form_part_one = '';

		/** Common member variable
		 *
		 *  @var string $create_form_part_two
		 */
		public $create_form_part_two = '';

		/** Common member variable
		 *
		 *  @var string $create_form_part_three
		 */
		public $create_form_part_three = '';

		/** Common member variable
		 *
		 *  @var string $create_form_part_the_ending
		 */
		public $create_form_part_the_ending = '';


		/** Common member variable
		 *
		 *  @var string create_form_part_save
		 */
		public $create_form_part_save = '';

		/** Common member variable
		 *
		 *  @var boolean user_logged_in
		 */
		public $user_logged_in = false;


		/**
		 * Class Constructor
		 */
		public function __construct() {

			global $wpdb;

			// First we'll get all the translations for this tab.
			require_once WPHEALTHTRACKER_CLASSES_TRANSLATIONS_DIR . 'class-wphealthtracker-translations.php';
			$this->trans = new WPHealthTracker_Translations();
			$this->trans->common_trans_strings();
			$this->trans->dashboard_trans_strings();
			$this->trans->users_tab_trans_strings();
			$this->trans->exercise_tab_trans_strings();

			// Set the current WordPress user.
			$currentwpuser = wp_get_current_user();

			// Make call to Transients class to see if Transient currently exists. If so, retrieve it, if not, make call to create_transient() with all required Parameters.
			$users_table_name = $wpdb->prefix . 'wphealthtracker_users';
			require_once WPHEALTHTRACKER_CLASSES_TRANSIENTS_DIR . 'class-wphealthtracker-transients.php';
			$transients       = new WPHealthTracker_Transients();
			$transient_name   = 'wpht_' . md5( 'SELECT * FROM ' . $users_table_name . ' WHERE wpuserid == ' . $currentwpuser->ID );
			$transient_exists = $transients->existing_transient_check( $transient_name );
			if ( $transient_exists ) {
				$user = $transient_exists;
			} else {
				$query = 'SELECT * FROM ' . $users_table_name . '  WHERE wpuserid = ' . $currentwpuser->ID;
				$user  = $transients->create_transient( $transient_name, 'wpdb->get_row', $query, MONTH_IN_SECONDS );
			}

			// if user is logged in and we're not outputing to the frontend.
			if ( null !== $user ) {
				$this->user_logged_in = true;
			}

			// if user is logged in and we're not outputing to the frontend.
			if ( true === $this->user_logged_in ) {

				// Now get the user's permissions.
				$user_perm = explode( ',', $user->permissions );

				// Now we'll determine access, and stop all execution if user isn't allowed in.
				require_once WPHEALTHTRACKER_CLASSES_UTILITIES_DIR . 'class-wphealthtracker-utilities-accesscheck.php';
				$this->access          = new WPHealthTracker_Utilities_Accesscheck();
				$this->currentwphtuser = $this->access->wphealthtracker_accesscheck( $currentwpuser->ID, $user_perm[4] );

				// If we received false from accesscheck class, display permissions message.
				if ( false === $this->currentwphtuser ) {

					// Outputs the 'No Permission!' message.
					$this->initial_output = $this->access->wphealthtracker_accesscheck_no_permission_message();
					return false;
				}

			}

			// Enqueue WordPress media scripts.
			wp_enqueue_media();

			// Set the date.
			require_once WPHEALTHTRACKER_CLASSES_UTILITIES_DIR . 'class-wphealthtracker-utilities-date.php';
			$utilities_date = new WPHealthTracker_Utilities_Date();
			$this->date     = $utilities_date->wphealthtracker_get_date_via_current_time( 'mysql' );

			// Grabs all user info from DB to make checks for usernames already taken, autofills, etc.
			$this->wphealthtracker_get_all_saved_users();

			// if user is logged in and we're not outputing to the frontend.
			if ( true === $this->user_logged_in ) {

				// Creates the User Roles Drop-down (makes superadmin check).
				$this->wphealthtracker_create_role_dropdown_and_warning();

			}

			// Creating the beginning HTML.
			$this->create_form_part_the_beginning();

			// Creating 'The Basics' form part.
			$this->create_form_part_the_basics();

			// Creating the Contact Info form part.
			$this->create_form_part_contact_info();

			// Creating the Profile Info form part.
			$this->create_form_part_profile_info();

			// Creating the save button and response div.
			$this->create_form_part_save_response();

			// Creating the ending HTML.
			$this->create_form_part_the_ending();

			// Output final HTML.
			$this->output_create_users_form();

		}

		/**
		 *  Get all saved Users from the WPHealthTracker Users table.
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

		public function wphealthtracker_create_role_dropdown_and_warning() {

			// If user is godmode, give option to grant a different user godmode status.
			if ( 'godmode' === $this->currentwphtuser->role ) {
				$options_string =
					'<option selected default disabled>' . $this->trans->user_trans_44 . '</option>
					<option>' . $this->trans->user_trans_41 . '</option>
					<option>' . $this->trans->user_trans_42 . '</option>
					<option>' . $this->trans->user_trans_43 . '</option>
					<option>' . $this->trans->user_trans_45 . '</option>';

				$this->role_warning =
					'<div id="wphealthtracker-create-user-godmode-warning-message">
						<p id="wphealthtracker-create-user-godmode-warning-message-title">' . $this->trans->user_trans_46 . '</p>
						<img id="wphealthtracker-create-user-godmode-warning-message-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'warning.svg">
						<p id="wphealthtracker-create-user-godmode-warning-message-body">' . $this->trans->user_trans_47 . '</p>
					</div>';

			} else {
				$options_string = 
					'<option selected default disabled>' . $this->trans->user_trans_44 . '</option>
					<option>' . $this->trans->user_trans_41 . '</option>
					<option>' . $this->trans->user_trans_42 . '</option>
					<option>' . $this->trans->user_trans_43 . '</option>';
			}

			$this->role_select_string =
				'<select class="wphealthtracker-response-form-select" id="wphealthtracker-response-form-select-create-user-role">
					' . $options_string . '
				</select>';

		}

		public function create_form_part_the_beginning() {
			$this->create_form_part_the_beginning = '
			<div id="wphealthtracker-indiv-choice-create-user">
				<div class="wphealthtracker-indiv-choice" id="wphealthtracker-indiv-choice-enter">
					<div class="wphealthtracker-expansion-div-create-user">
						<img src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'data-entry.svg" class="wphealthtracker-indiv-choice-img" />
						<p class="wphealthtracker-indiv-choice-p">' . $this->trans->common_trans_74 . '</p>
						<p class="wphealthtracker-indiv-choice-sub-p">' . $this->trans->user_trans_82 . '</p>
						<ul class="wphealthtracker-indiv-choice-sub-ul">
							<li>' . $this->trans->user_trans_2 . '</li>
							<li>' . $this->trans->user_trans_4 . '</li>
							<li>' . $this->trans->user_trans_6 . '</li>
							<li>' . $this->trans->user_trans_8 . '</li>
						</ul>
						<p class="wphealthtracker-indiv-choice-sub-p">' . $this->trans->user_trans_83 . ' 
							<img class="wphealthtracker-stats-indiv-choice-good-data-smile" data-label="user-basics" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'happy.svg">
						</p>
					</div>
					<div class="wphealthtracker-create-user-div" id="wphealthtracker-response-form-data-row-actual-0">';
		}

		public function create_form_part_the_ending() {
			$this->create_form_part_the_ending = '</div></div></div>';
		}

		public function create_form_part_the_basics() {

			$this->create_form_part_one = '
			<div class="wphealthtracker-response-form-entry-row">
				<h2 class="wphealthtracker-response-form-heading-black">
				<img id="wphealthtracker-icon-image-question-id-2" class="wphealthtracker-icon-image-question-enter-view" data-label="user-basics" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">
				' . $this->trans->user_trans_1 . '<img class="wphealthtracker-icon-h2-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'list.svg"></h2>
				<div class="wphealthtracker-response-form-data-row-text" id="wphealthtracker-response-form-firstname-row-div">
					<div class="wphealthtracker-response-form-div-row-create-users">
						<p class="wphealthtracker-response-form-users-label-row"><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="user-firstname" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->trans->user_trans_2 . '</p>
						<div class="wphealthtracker-decorative-red-underline-create-users"></div>
						<input class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-firstname" type="text" placeholder="' . $this->trans->user_trans_30 . '">
					</div>
					<div class="wphealthtracker-response-form-div-row-create-users">
						<p class="wphealthtracker-response-form-users-label-row"><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="user-lastname" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->trans->user_trans_3 . '</p>
						<div class="wphealthtracker-decorative-red-underline-create-users"></div>
						<input class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-lastname" type="text" placeholder="' . $this->trans->user_trans_31 . '">
					</div>
				</div>
				<div class="wphealthtracker-response-form-data-row-text" id="wphealthtracker-response-form-email-row-div">
					<div class="wphealthtracker-response-form-div-row-create-users">
						<p class="wphealthtracker-response-form-users-label-row"><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="user-email" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->trans->user_trans_4 . '</p>
						<div class="wphealthtracker-decorative-red-underline-create-users"></div>
						<input class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-email" type="text" placeholder="' . $this->trans->user_trans_32 . '">
					</div>
					<div class="wphealthtracker-response-form-div-row-create-users">
						<p class="wphealthtracker-response-form-users-label-row"><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="user-emailconfirm" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->trans->user_trans_5 . '</p>
						<div class="wphealthtracker-decorative-red-underline-create-users"></div>
						<input class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-emailconfirm" type="text" placeholder="' . $this->trans->user_trans_33 . '">
						<div class="wphealthracker-create-users-match-response-div" id="wphealthracker-create-users-match-response-div-email">
							<p id="wphealthracker-create-users-match-response-p-email"></p>
						</div>
					</div>
				</div>
				<div class="wphealthtracker-response-form-data-row-text" id="wphealthtracker-response-form-password-row-div">
					<div class="wphealthtracker-response-form-div-row-create-users" id="wphealthtracker-response-form-password1-row-div">
						<p class="wphealthtracker-response-form-users-label-row" id="wphealthtracker-response-form-users-label-row-password"><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="user-password" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->trans->user_trans_6 . '</p>
						<p id="wphealthtracker-create-user-show-password">' . $this->trans->user_trans_79 . '</p>
						<div class="wphealthtracker-decorative-red-underline-create-users"></div>
						<input class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-password" type="password" placeholder="' . $this->trans->user_trans_34 . '">
					</div>
					<div class="wphealthtracker-response-form-div-row-create-users" id="wphealthtracker-response-form-password2-row-div">
						<p class="wphealthtracker-response-form-users-label-row"><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="user-passwordconfirm" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->trans->user_trans_7 . '</p>
						<div class="wphealthtracker-decorative-red-underline-create-users"></div>
						<input class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-passwordconfirm" type="password" placeholder="' . $this->trans->user_trans_35 . '">
						<div class="wphealthracker-create-users-match-response-div" id="wphealthracker-create-users-match-response-div-password">
							<p id="wphealthracker-create-users-match-response-p-password"></p>
					</div>
				</div>
				<div class="wphealthtracker-response-form-data-row-text" id="wphealthtracker-response-form-usernamerole-row-div">
					<div class="wphealthtracker-response-form-div-row-create-users">
						<p class="wphealthtracker-response-form-users-label-row"><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="user-username" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->trans->user_trans_8 . '</p>
						<div class="wphealthtracker-decorative-red-underline-create-users"></div>
						<input class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-username" type="text" placeholder="' . $this->trans->user_trans_36 . '">
					</div>';

					// if user is logged in and we're not outputing to the frontend.
					if ( true === $this->user_logged_in ) {
						$this->create_form_part_one = $this->create_form_part_one . '<div class="wphealthtracker-response-form-div-row-create-users">
							<p class="wphealthtracker-response-form-users-label-row"><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="user-role" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->trans->user_trans_9 . '</p>
							<div class="wphealthtracker-decorative-red-underline-create-users"></div>
							 ' . $this->role_select_string . '
							</div>
						</div>';
					}

				$this->create_form_part_one = $this->create_form_part_one . '</div>
				' . $this->role_warning . '
			</div>';

		}

		public function create_form_part_contact_info() {
			$this->create_form_part_two = '
			<div class="wphealthtracker-response-form-entry-row">
				<h2 class="wphealthtracker-response-form-heading-black">
				<img id="wphealthtracker-icon-image-question-id-2" class="wphealthtracker-icon-image-question-enter-view" data-label="user-contactinfo" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">
				' . $this->trans->user_trans_48 . '<img class="wphealthtracker-icon-h2-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'phonebook.svg"></h2>
				<div class="wphealthtracker-response-form-data-row-text" id="wphealthtracker-response-form-firstname-row-div">
					<div class="wphealthtracker-response-form-div-row-create-users">
						<p class="wphealthtracker-response-form-users-label-row"><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="user-country" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->trans->user_trans_11 . '</p>
						<div class="wphealthtracker-decorative-red-underline-create-users"></div>
						<input class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-country" type="text" placeholder="' . $this->trans->user_trans_49 . '">
					</div>
					<div class="wphealthtracker-response-form-div-row-create-users">
						<p class="wphealthtracker-response-form-users-label-row"><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="user-street1" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->trans->user_trans_12 . '</p>
						<div class="wphealthtracker-decorative-red-underline-create-users"></div>
						<input class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-street1" type="text" placeholder="' . $this->trans->user_trans_50 . '">
					</div>
				</div>
				<div class="wphealthtracker-response-form-data-row-text" id="wphealthtracker-response-form-firstname-row-div">
					<div class="wphealthtracker-response-form-div-row-create-users">
						<p class="wphealthtracker-response-form-users-label-row"><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="user-street2" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->trans->user_trans_13 . '</p>
						<div class="wphealthtracker-decorative-red-underline-create-users"></div>
						<input class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-street2" type="text" placeholder="' . $this->trans->user_trans_51 . '">
					</div>
					<div class="wphealthtracker-response-form-div-row-create-users">
						<p class="wphealthtracker-response-form-users-label-row"><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="user-city" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->trans->user_trans_14 . '</p>
						<div class="wphealthtracker-decorative-red-underline-create-users"></div>
						<input class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-city" type="text" placeholder="' . $this->trans->user_trans_52 . '">
					</div>
				</div>
				<div class="wphealthtracker-response-form-data-row-text" id="wphealthtracker-response-form-firstname-row-div">
					<div class="wphealthtracker-response-form-div-row-create-users">
						<p class="wphealthtracker-response-form-users-label-row"><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="user-state" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->trans->user_trans_15 . '</p>
						<div class="wphealthtracker-decorative-red-underline-create-users"></div>
						<input class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-state" type="text" placeholder="' . $this->trans->user_trans_53 . '">
					</div>
					<div class="wphealthtracker-response-form-div-row-create-users">
						<p class="wphealthtracker-response-form-users-label-row"><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="user-zip" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->trans->user_trans_16 . '</p>
						<div class="wphealthtracker-decorative-red-underline-create-users"></div>
						<input class="wphealthtracker-response-form-input-number" id="wphealthtracker-response-form-input-text-zip" type="number" placeholder="' . $this->trans->user_trans_54 . '">
					</div>
				</div>
				<div class="wphealthtracker-response-form-data-row-text" id="wphealthtracker-response-form-firstname-row-div">
					<div class="wphealthtracker-response-form-div-row-create-users">
						<p class="wphealthtracker-response-form-users-label-row"><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="user-phone" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->trans->user_trans_17 . '</p>
						<div class="wphealthtracker-decorative-red-underline-create-users"></div>
						<input class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-phone" type="text" placeholder="' . $this->trans->user_trans_55 . '">
					</div>
				</div>
			</div>';
		}

		public function create_form_part_profile_info() {

			$this->create_form_part_three = '
			<div class="wphealthtracker-response-form-entry-row">
				<h2 class="wphealthtracker-response-form-heading-black">
				<img id="wphealthtracker-icon-image-question-id-2" class="wphealthtracker-icon-image-question-enter-view" data-label="user-profile" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">
				' . $this->trans->user_trans_56 . '<img style="width:40px;" class="wphealthtracker-icon-h2-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'conversation.svg"></h2>
				<div class="wphealthtracker-response-form-data-row-text" id="wphealthtracker-response-form-firstname-row-div">
					<div id="wphealthtracker-create-users-profile-img-div"></div>
					<div class="wphealthtracker-response-form-div-row-create-users">
						<p class="wphealthtracker-response-form-users-label-row"><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="user-profileimage" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->trans->user_trans_57 . '</p>
						<div class="wphealthtracker-decorative-red-underline-create-users"></div>
						<input class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-profileimage-url" type="text" placeholder="' . $this->trans->user_trans_58 . '">
						<button class="wphealthtracker-response-form-input-button" id="wphealthtracker-response-form-input-text-profileimage-button">Select Profile Image</button>
					</div>
				</div>
				<div class="wphealthtracker-response-form-data-row-text" id="wphealthtracker-response-form-firstname-row-div">
					<div class="wphealthtracker-response-form-div-row-create-users">
						<p class="wphealthtracker-response-form-users-label-row"><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="user-profilebirthday" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->trans->user_trans_59 . '</p>
						<div class="wphealthtracker-decorative-red-underline-create-users"></div>
						<input class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-date-birthday" type="date" placeholder="' . $this->trans->user_trans_51 . '">
					</div>
					<div class="wphealthtracker-response-form-div-row-create-users">
						<p class="wphealthtracker-response-form-users-label-row"><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="user-profilegender" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->trans->user_trans_60 . '</p>
						<div class="wphealthtracker-decorative-red-underline-create-users"></div>
						<select class="wphealthtracker-response-form-select" id="wphealthtracker-response-form-select-create-user-gender">
							<option selected disabled default>' . $this->trans->user_trans_63 . '</option>
							<option>' . $this->trans->user_trans_61 . '</option>
							<option>' . $this->trans->user_trans_62 . '</option>
						</select>
					</div>
				</div>
				<div class="wphealthtracker-response-form-data-row-text" id="wphealthtracker-response-form-firstname-row-div">
					<div class="wphealthtracker-response-form-div-row-create-users">
						<p class="wphealthtracker-response-form-users-label-row"><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="user-profileheight" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->trans->user_trans_64 . '
						<div class="wphealthtracker-decorative-red-underline-create-users"></div>
						<select class="wphealthtracker-response-form-select" id="wphealthtracker-response-form-select-create-user-height-feet">
							<option selected disabled default>' . $this->trans->user_trans_66 . '</option>
							<option>3</option>
							<option>4</option>
							<option>5</option>
							<option>6</option>
							<option>7</option>
						</select>
						<select class="wphealthtracker-response-form-select" id="wphealthtracker-response-form-select-create-user-height-inches">
							<option selected disabled default>' . $this->trans->user_trans_67 . '</option>
							<option>0</option>
							<option>1</option>
							<option>2</option>
							<option>3</option>
							<option>4</option>
							<option>5</option>
							<option>6</option>
							<option>7</option>
							<option>8</option>
							<option>9</option>
							<option>10</option>
							<option>11</option>
						</select>
					</div>
					<div class="wphealthtracker-response-form-div-row-create-users">
						<p class="wphealthtracker-response-form-users-label-row"><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="user-profilemainfocus" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->trans->user_trans_65 . '</p>
						<div class="wphealthtracker-decorative-red-underline-create-users"></div>
						<select class="wphealthtracker-response-form-select" id="wphealthtracker-response-form-select-create-user-mainfocus">
							<option selected disabled default>' . $this->trans->user_trans_68 . '</option>
							<option>' . $this->trans->user_trans_70 . '</option>
							<option>' . $this->trans->user_trans_71 . '</option>
							<option>' . $this->trans->user_trans_72 . '</option>
							<option>' . $this->trans->user_trans_69 . '</option>
							<option>' . $this->trans->exercise_trans_9 . '</option>
							<option>' . $this->trans->exercise_trans_10 . '</option>
							<option>' . $this->trans->exercise_trans_11 . '</option>
							<option>' . $this->trans->exercise_trans_12 . '</option>
							<option>' . $this->trans->common_trans_47 . '</option>
						</select>
					</div>
				</div>
				<div class="wphealthtracker-response-form-data-row-text" id="wphealthtracker-response-form-firstname-row-div">
					<div class="wphealthtracker-response-form-div-row-create-users">
						<p class="wphealthtracker-response-form-users-label-row"><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="user-profilemotivationalquote" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->trans->user_trans_75 . '</p>
						<div class="wphealthtracker-decorative-red-underline-create-users"></div>
						<textarea class="wphealthtracker-response-form-input-textarea" id="wphealthtracker-response-form-input-textarea-motivational-quote" placeholder="' . $this->trans->user_trans_76 . '"></textarea>
					</div>
					<div class="wphealthtracker-response-form-div-row-create-users">
						<p class="wphealthtracker-response-form-users-label-row"><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="user-profilebio" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->trans->user_trans_77 . '</p>
						<div class="wphealthtracker-decorative-red-underline-create-users"></div>
						<textarea class="wphealthtracker-response-form-input-textarea" id="wphealthtracker-response-form-input-textarea-bio" placeholder="' . $this->trans->user_trans_78 . '"></textarea>
					</div>
				</div>
			</div>';
		}

		public function create_form_part_save_response() {

			$this->create_form_part_save =
			'<div class="wphealthtracker-save-spinner-response-div">
				<div class="wphealthtracker-spinner-primary" id="wphealthtracker-spinner-save-users"></div>
				<div class="wphealthtracker-response-message-div" id="wphealthtracker-response-message-users-div"></div>
				<button id="wphealthtracker-save-new-users">' . $this->trans->user_trans_81 . '</button>
			</div>';
		}







		/**
		 * Creates the form user fills out for creating new user
		 */
		public function output_create_users_form() {
			$this->initial_output = $this->create_form_part_the_beginning . $this->create_form_part_one . $this->create_form_part_two . $this->create_form_part_three . $this->create_form_part_save . $this->create_form_part_the_ending;
		}
	}
endif;
