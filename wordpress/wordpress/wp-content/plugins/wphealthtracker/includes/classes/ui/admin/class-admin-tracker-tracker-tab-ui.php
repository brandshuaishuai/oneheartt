<?php
/**
 * Class WPHealthTracker_Vitals_Tab - class-admin-tracker-vitals-tab-ui.php
 *
 * @author   Jake Evans
 * @category Admin
 * @package  Includes/Classes/UI/Admin
 * @version  0.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPHEALTHTRACKER_General_Settings_Tab', false ) ) :
	/**
	 * WPHEALTHTRACKER_General_Settings_Tab.
	 */
	class WPHEALTHTRACKER_General_Settings_Tab {

		/**
		 * Constructor that calls all of the Classes functions upon instantiation.
		 */
		public function __construct() {
			require_once WPHEALTHTRACKER_CLASSES_UI_DISPLAY_DIR . 'class-ui-display-template.php';
			require_once WPHEALTHTRACKER_CLASSES_UI_DISPLAY_DIR . 'class-general-settings-form.php';

			// Instantiate the class.
			$this->template = new WPHEALTHTRACKER_UI_Display_Template();
			$this->form     = new WPHEALTHTRACKER_Create_General_Settings_Form();
			$this->output_open_display_container();
			$this->output_tab_content();
			$this->output_close_display_container();
			$this->output_display_template_advert();
		}

		/**
		 * Outputs the Title and image for this tab.
		 */
		private function output_open_display_container() {
			$icon_url = WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'greeting.svg';

			require_once WPHEALTHTRACKER_CLASSES_TRANSLATIONS_DIR . 'class-wphealthtracker-translations.php';
			$trans = new WPHealthTracker_Translations();
			$trans->tab_titles_trans_strings();
			$title = $trans->tab_title_1;

			echo $this->template->output_open_display_container( $title, $icon_url ) . '<div style="display:none;" id="wphealthtracker-special-for-editor"></div>';
		}

		/**
		 * Outputs the actual HTML content for this tab.
		 */
		private function output_tab_content() {
			echo $this->form->initial_output;
		}

		/**
		 * Simply closes open HTML elements.
		 */
		private function output_close_display_container() {
			echo $this->template->output_close_display_container();
		}

		/**
		 * Adds in the default advertisment at the bottom of each tab
		 */
		private function output_display_template_advert() {
			echo $this->template->output_template_advert();
		}

	}

endif;


// Instantiate the class.
$am = new WPHEALTHTRACKER_General_Settings_Tab();
