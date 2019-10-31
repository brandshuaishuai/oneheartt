<?php
/**
 * WPHEALTHTRACKER Create Pop-Up Form Class
 *
 * @author   Jake Evans
 * @category Display
 * @package  Includes/Classes/UI/Display
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPHEALTHTRACKER_Create_General_Settings_Form', false ) ) :
	/**
	 * WPHEALTHTRACKER_Create_General_Settings_Form.
	 */
	class WPHEALTHTRACKER_Create_General_Settings_Form {


		/**
		 *  Class constructor.
		 */
		public function __construct() {

			// Now we'll determine access, and stop all execution if user isn't allowed in.
			require_once WPHEALTHTRACKER_CLASSES_UTILITIES_DIR . 'class-wphealthtracker-utilities-accesscheck.php';
			// Set the current WordPress user.
			$currentwpuser = wp_get_current_user();
			$this->access  = new WPHealthTracker_Utilities_Accesscheck();
			$this->access->wphealthtracker_get_user_role_and_perms( $currentwpuser->ID );
			$this->output_create_general_settings_form();

		}


		/**
		 *  Outputs the HTML.
		 */
		private function output_create_general_settings_form() {

			require_once WPHEALTHTRACKER_CLASSES_TRANSLATIONS_DIR . 'class-wphealthtracker-translations.php';
			$trans = new WPHealthTracker_Translations();
			$trans->welcome_tab_trans_strings();

			$string1 = '
				<div id="wphealthtracker-general-inner-container">
					<div class="wphealthtracker-general-intro-para">
						' . $trans->welcome_trans_1 . ' <span class="wphealthtracker-branded-text">' . $trans->welcome_trans_11 . '</span> - ' . $trans->welcome_trans_10 . '
					</div>	
					<div class="wphealthtracker-general-buttons-wrapper">';

			if ( 'godmode' === $this->access->userrole ) {
				$string1 = $string1 .
					'<div>
						<div class="wphealthtracker-general-button-container-div">
							<a href="' . admin_url( 'admin.php?page=WPHealthTracker-users' ) . '" class="wphealthtracker-general-button-a">' . $trans->welcome_trans_3 . '</a>
						</div>
						<div class="wphealthtracker-general-button-container-div">
							<a href="' . admin_url( 'admin.php?page=WPHealthTracker-users' ) . '" class="wphealthtracker-general-button-a">' . $trans->welcome_trans_2 . '</a>
						</div>
					</div>';
			}

			$string1 = $string1 . '
					<div>
						<div class="wphealthtracker-general-button-container-div">
							<a href="' . admin_url( 'admin.php?page=WPHealthTracker-stats&tab=vitalstats' ) . '" class="wphealthtracker-general-button-a">' . $trans->welcome_trans_4 . '</a>
						</div>
						<div class="wphealthtracker-general-button-container-div">
							<a href="' . admin_url( 'admin.php?page=WPHealthTracker-stats&tab=dietstats' ) . '" class="wphealthtracker-general-button-a">' . $trans->welcome_trans_5 . '</a>
						</div>
						<div class="wphealthtracker-general-button-container-div">
							<a href="' . admin_url( 'admin.php?page=WPHealthTracker-stats&tab=exercisestats' ) . '" class="wphealthtracker-general-button-a">' . $trans->welcome_trans_6 . '</a>
						</div>
					</div>
					<div>
						<div class="wphealthtracker-general-button-container-div">
							<a href="' . admin_url( 'admin.php?page=WPHealthTracker-stats&tab=vitalstats' ) . '" class="wphealthtracker-general-button-a">' . $trans->welcome_trans_7 . '</a>
						</div>
						<div class="wphealthtracker-general-button-container-div">
							<a href="' . admin_url( 'admin.php?page=WPHealthTracker-stats&tab=dietstats' ) . '" class="wphealthtracker-general-button-a">' . $trans->welcome_trans_8 . '</a>
						</div>
						<div class="wphealthtracker-general-button-container-div">
							<a href="' . admin_url( 'admin.php?page=WPHealthTracker-stats&tab=exercisestats' ) . '" class="wphealthtracker-general-button-a">' . $trans->welcome_trans_9 . '</a>
						</div>
					</div>
					<div>
						<div class="wphealthtracker-general-button-container-div">
							<a href="' . admin_url( 'admin.php?page=WPHealthTracker-stats&tab=vitalstats' ) . '" class="wphealthtracker-general-button-a">' . $trans->welcome_trans_12 . '</a>
						</div>
						<div class="wphealthtracker-general-button-container-div">
							<a href="' . admin_url( 'admin.php?page=WPHealthTracker-stats&tab=dietstats' ) . '" class="wphealthtracker-general-button-a">' . $trans->welcome_trans_13 . '</a>
						</div>
					</div>
				</div>
			</div>';

			$this->initial_output = $string1;

		}




	}

endif;
