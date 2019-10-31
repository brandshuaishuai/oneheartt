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

if ( ! class_exists( 'WPHEALTHTRACKER_Vitals_Tab', false ) ) :
	/**
	 * WPHEALTHTRACKER_Vitals_Tab.
	 */
	class WPHEALTHTRACKER_Vitals_Tab {

		/**
		 * Constructor that calls all of the Classes functions upon instantiation.
		 */
		public function __construct() {
			require_once WPHEALTHTRACKER_CLASSES_UI_DISPLAY_DIR . 'class-ui-display-template.php';
			require_once WPHEALTHTRACKER_CLASSES_UI_DISPLAY_DIR . 'class-wphealthtracker-vitals-form.php';

			// Instantiate the class.
			$this->template = new WPHEALTHTRACKER_UI_Display_Template();
			$this->form     = new WPHEALTHTRACKER_Vitals_Form();
			$this->output_open_display_container();
			$this->output_tab_content();
			$this->output_close_display_container();
			$this->output_display_template_advert();
		}

		/**
		 * Outputs the Title and image for this tab.
		 */
		public function output_open_display_container() {
			$icon_url = WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'cardiogram.svg';

			require_once WPHEALTHTRACKER_CLASSES_TRANSLATIONS_DIR . 'class-wphealthtracker-translations.php';
			$trans = new WPHealthTracker_Translations();
			$trans->tab_titles_trans_strings();
			$title = $trans->tab_title_2;

			$return = $this->template->output_open_display_container( $title, $icon_url );
			echo $return;
			return $return;
		}

		/**
		 * Outputs the actual HTML content for this tab.
		 */
		public function output_tab_content() {
			$result = $this->form->initial_output;
			echo $result;
			return $result;
		}

		/**
		 * Simply closes open HTML elements.
		 */
		public function output_close_display_container() {
			$result = $this->template->output_close_display_container();
			echo $result;
			return $result;
		}

		/**
		 * Adds in the default advertisment at the bottom of each tab
		 */
		public function output_display_template_advert() {
			$result = $this->template->output_template_advert();
			echo $result;
			return $result;
		}

	}

endif;

// Instantiate the class.
$am = new WPHEALTHTRACKER_Vitals_Tab();
