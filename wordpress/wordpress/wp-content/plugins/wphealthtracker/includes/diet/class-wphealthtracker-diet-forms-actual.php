<?php
/**
 * Class WPHEALTHTRACKER_Diet_Forms_Actual - class-wphealthtracker-diet-forms-actual.php
 *
 * @author   Jake Evans
 * @category Admin
 * @package  Includes/Diet
 * @version  0.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPHEALTHTRACKER_Diet_Forms_Actual', false ) ) :

	/**
	 * WPHEALTHTRACKER_Diet_Forms_Actual class. This class holds all of the forms that will be used for entering and Viewing Exercise data on the Exercise Tracker tab.
	 */
	class WPHEALTHTRACKER_Diet_Forms_Actual {

		/** Common member variable
		 *
		 *  @var object $translations
		 */
		public $translations;

		/** Common member variable
		 *
		 *  @var string $firstname
		 */
		public $firstname = '';

		/** Common member variable
		 *
		 *  @var string $lastname
		 */
		public $lastname = '';

		/** Common member variable
		 *
		 *  @var string $wpuserid
		 */
		public $wpuserid = '';

		/** Common member variable
		 *
		 *  @var string $humandate
		 */
		public $humandate = '';

		/** Common member variable
		 *
		 *  @var string $foodstring
		 */
		public $foodstring = '';

		/** Common member variable
		 *
		 *  @var string $imgdieturl
		 */
		public $imgdieturl = '';

		/** Common member variable
		 *
		 *  @var string $filedieturl
		 */
		public $filedieturl = '';

		/** Common member variable
		 *
		 *  @var string $date
		 */
		public $date = '';

		/**
		 * Class Constructor
		 */
		public function __construct() {

			// Require the translations file.
			require_once WPHEALTHTRACKER_CLASSES_TRANSLATIONS_DIR . 'class-wphealthtracker-translations.php';
			$this->translations = new WPHealthTracker_Translations();
			$this->translations->diet_tab_trans_strings();
			$this->translations->common_trans_strings();

			// Set the date.
			require_once WPHEALTHTRACKER_CLASSES_UTILITIES_DIR . 'class-wphealthtracker-utilities-date.php';
			$utilities_date = new WPHealthTracker_Utilities_Date();
			$this->date     = $utilities_date->wphealthtracker_get_date_via_current_time( 'mysql' );
		}


		/**
		 * Handle the configuration of the food items HTML
		 *
		 * @param int    $loop_num - tracks which day we're on.
		 * @param string $type - specifies if we're on today or a previous day.
		 */
		private function output_diet_enter_config_food_item( $loop_num, $type ) {

			$key               = 0;
			$final_food_string = '';
			$data_section      = ' data-section="' . $type . '" ';

			// If there is indeed Food data saved at all.
			if ( '' !== $this->foodstring ) {

				// If there are multiple food entries entries on the same date...
				if ( strpos( $this->foodstring, ',' ) !== false ) {
					$foodarray = explode( ',', $this->foodstring );
					foreach ( $foodarray as $key => $value ) {

						$fooditem     = '';
						$category     = '';
						$time         = '0:00';
						$energy       = 0;
						$calmeasure   = '';
						$protein      = 0;
						$proteintype  = '';
						$totalfat     = 0;
						$satfat       = 0;
						$monofat      = 0;
						$polyfat      = 0;
						$totalcarbs   = 0;
						$dietaryfiber = 0;
						$sugars       = 0;
						$imageurl     = '';
						$fileurl      = '';

						$foodsplit = explode( ';', $value );

						if ( count( $foodsplit ) > 0 ) {
							$fooditem = $foodsplit[0];
						}

						if ( count( $foodsplit ) > 1 ) {
							$category = $foodsplit[1];
						}

						if ( count( $foodsplit ) > 2 ) {
							$time = $foodsplit[2];
						}

						if ( count( $foodsplit ) > 3 ) {
							$energy = $foodsplit[3];
						}

						if ( count( $foodsplit ) > 4 ) {
							$energymeasure = $foodsplit[4];
						}

						if ( count( $foodsplit ) > 5 ) {
							$protein = $foodsplit[5];
						}

						if ( count( $foodsplit ) > 6 ) {
							$proteintype = $foodsplit[6];
						}

						if ( count( $foodsplit ) > 7 ) {
							$totalfat = $foodsplit[7];
						}

						if ( count( $foodsplit ) > 8 ) {
							$satfat = $foodsplit[8];
						}

						if ( count( $foodsplit ) > 9 ) {
							$monofat = $foodsplit[9];
						}

						if ( count( $foodsplit ) > 10 ) {
							$polyfat = $foodsplit[10];
						}

						if ( count( $foodsplit ) > 11 ) {
							$totalcarbs = $foodsplit[11];
						}

						if ( count( $foodsplit ) > 12 ) {
							$dietaryfiber = $foodsplit[12];
						}

						if ( count( $foodsplit ) > 13 ) {
							$sugars = $foodsplit[13];
						}

						if ( count( $foodsplit ) > 14 ) {
							$imageurl = $foodsplit[14];
						}

						if ( count( $foodsplit ) > 15 ) {
							$fileurl = $foodsplit[15];
						}

						// Build the Options for the Calories/Energy Select.
						if ( $energymeasure === $this->translations->diet_trans_9 ) {
							$energymeasure =
							'<option selected>' . $this->translations->diet_trans_9 . '</option>
							<option>' . $this->translations->diet_trans_10 . '</option>
							<option>' . $this->translations->diet_trans_11 . '</option>';
						} elseif ( $energymeasure === $this->translations->diet_trans_10 ) {
							$energymeasure =
							'<option>' . $this->translations->diet_trans_9 . '</option>
							<option selected>' . $this->translations->diet_trans_10 . '</option>
							<option>' . $this->translations->diet_trans_11 . '</option>';
						} elseif ( $energymeasure === $this->translations->diet_trans_11 ) {
							$energymeasure =
							'<option>' . $this->translations->diet_trans_9 . '</option>
							<option>' . $this->translations->diet_trans_10 . '</option>
							<option selected>' . $this->translations->diet_trans_11 . '</option>';
						} else {
							$energymeasure =
							'<option>' . $this->translations->diet_trans_9 . '</option>
							<option>' . $this->translations->diet_trans_10 . '</option>
							<option>' . $this->translations->diet_trans_11 . '</option>';
						}

						// Build the Options for the Protein Select.
						if ( $proteintype === $this->translations->common_trans_37 ) {
							$proteintype =
							'<option selected>' . $this->translations->common_trans_37 . '</option>
							<option>' . $this->translations->diet_trans_13 . '</option>
							<option>' . $this->translations->diet_trans_14 . '</option>
							<option>' . $this->translations->diet_trans_15 . '</option>
							<option>' . $this->translations->diet_trans_16 . '</option>
							<option>' . $this->translations->diet_trans_17 . '</option>
							<option>' . $this->translations->diet_trans_18 . '</option>
							<option>' . $this->translations->diet_trans_19 . '</option>
							<option>' . $this->translations->common_trans_38 . '</option>';
						} elseif ( $proteintype === $this->translations->diet_trans_13 ) {
							$proteintype =
							'<option>' . $this->translations->common_trans_37 . '</option>
							<option selected>' . $this->translations->diet_trans_13 . '</option>
							<option>' . $this->translations->diet_trans_14 . '</option>
							<option>' . $this->translations->diet_trans_15 . '</option>
							<option>' . $this->translations->diet_trans_16 . '</option>
							<option>' . $this->translations->diet_trans_17 . '</option>
							<option>' . $this->translations->diet_trans_18 . '</option>
							<option>' . $this->translations->diet_trans_19 . '</option>
							<option>' . $this->translations->common_trans_38 . '</option>';
						} elseif ( $proteintype === $this->translations->diet_trans_14 ) {
							$proteintype =
							'<option>' . $this->translations->common_trans_37 . '</option>
							<option>' . $this->translations->diet_trans_13 . '</option>
							<option selected>' . $this->translations->diet_trans_14 . '</option>
							<option>' . $this->translations->diet_trans_15 . '</option>
							<option>' . $this->translations->diet_trans_16 . '</option>
							<option>' . $this->translations->diet_trans_17 . '</option>
							<option>' . $this->translations->diet_trans_18 . '</option>
							<option>' . $this->translations->diet_trans_19 . '</option>
							<option>' . $this->translations->common_trans_38 . '</option>';
						} elseif ( $proteintype === $this->translations->diet_trans_15 ) {
							$proteintype =
							'<option>' . $this->translations->common_trans_37 . '</option>
							<option>' . $this->translations->diet_trans_13 . '</option>
							<option>' . $this->translations->diet_trans_14 . '</option>
							<option selected>' . $this->translations->diet_trans_15 . '</option>
							<option>' . $this->translations->diet_trans_16 . '</option>
							<option>' . $this->translations->diet_trans_17 . '</option>
							<option>' . $this->translations->diet_trans_18 . '</option>
							<option>' . $this->translations->diet_trans_19 . '</option>
							<option>' . $this->translations->common_trans_38 . '</option>';
						} elseif ( $proteintype === $this->translations->diet_trans_16 ) {
							$proteintype =
							'<option>' . $this->translations->common_trans_37 . '</option>
							<option>' . $this->translations->diet_trans_13 . '</option>
							<option>' . $this->translations->diet_trans_14 . '</option>
							<option>' . $this->translations->diet_trans_15 . '</option>
							<option selected>' . $this->translations->diet_trans_16 . '</option>
							<option>' . $this->translations->diet_trans_17 . '</option>
							<option>' . $this->translations->diet_trans_18 . '</option>
							<option>' . $this->translations->diet_trans_19 . '</option>
							<option>' . $this->translations->common_trans_38 . '</option>';
						} elseif ( $proteintype === $this->translations->diet_trans_17 ) {
							$proteintype =
							'<option>' . $this->translations->common_trans_37 . '</option>
							<option>' . $this->translations->diet_trans_13 . '</option>
							<option>' . $this->translations->diet_trans_14 . '</option>
							<option>' . $this->translations->diet_trans_15 . '</option>
							<option>' . $this->translations->diet_trans_16 . '</option>
							<option selected>' . $this->translations->diet_trans_17 . '</option>
							<option>' . $this->translations->diet_trans_18 . '</option>
							<option>' . $this->translations->diet_trans_19 . '</option>
							<option>' . $this->translations->common_trans_38 . '</option>';
						} elseif ( $proteintype === $this->translations->diet_trans_18 ) {
							$proteintype =
							'<option>' . $this->translations->common_trans_37 . '</option>
							<option>' . $this->translations->diet_trans_13 . '</option>
							<option>' . $this->translations->diet_trans_14 . '</option>
							<option>' . $this->translations->diet_trans_15 . '</option>
							<option>' . $this->translations->diet_trans_16 . '</option>
							<option>' . $this->translations->diet_trans_17 . '</option>
							<option selected>' . $this->translations->diet_trans_18 . '</option>
							<option>' . $this->translations->diet_trans_19 . '</option>
							<option>' . $this->translations->common_trans_38 . '</option>';
						} elseif ( $proteintype === $this->translations->diet_trans_19 ) {
							$proteintype =
							'<option>' . $this->translations->common_trans_37 . '</option>
							<option>' . $this->translations->diet_trans_13 . '</option>
							<option>' . $this->translations->diet_trans_14 . '</option>
							<option>' . $this->translations->diet_trans_15 . '</option>
							<option>' . $this->translations->diet_trans_16 . '</option>
							<option>' . $this->translations->diet_trans_17 . '</option>
							<option>' . $this->translations->diet_trans_18 . '</option>
							<option selected>' . $this->translations->diet_trans_19 . '</option>
							<option>' . $this->translations->common_trans_38 . '</option>';
						} elseif ( $proteintype === $this->translations->common_trans_38 ) {
							$proteintype =
							'<option>' . $this->translations->common_trans_37 . '</option>
							<option>' . $this->translations->diet_trans_13 . '</option>
							<option>' . $this->translations->diet_trans_14 . '</option>
							<option>' . $this->translations->diet_trans_15 . '</option>
							<option>' . $this->translations->diet_trans_16 . '</option>
							<option>' . $this->translations->diet_trans_17 . '</option>
							<option>' . $this->translations->diet_trans_18 . '</option>
							<option>' . $this->translations->diet_trans_19 . '</option>
							<option selected>' . $this->translations->common_trans_38 . '</option>';
						} else {
							$proteintype =
							'<option>' . $this->translations->common_trans_37 . '</option>
							<option>' . $this->translations->diet_trans_13 . '</option>
							<option>' . $this->translations->diet_trans_14 . '</option>
							<option>' . $this->translations->diet_trans_15 . '</option>
							<option>' . $this->translations->diet_trans_16 . '</option>
							<option>' . $this->translations->diet_trans_17 . '</option>
							<option>' . $this->translations->diet_trans_18 . '</option>
							<option>' . $this->translations->diet_trans_19 . '</option>
							<option>' . $this->translations->common_trans_38 . '</option>';
						}

						// Handle the switching from input="time" to input="text" for cross-browser/safari support.
						if ( strlen( $time ) !== 5 && substr( $time, -3, 1 ) !== ':' ) {
							$time_input = 'type="text"';
						} else {
							$time_input = 'type="time"';
						}

						// Build the removal string if not on first iteration of loop.
						$removal_string = '';

						if ( 0 !== $key ) {
							$removal_string = '<div class="wphealthtracker-response-form-food-row-removal-div" data-id-to-update="' . $loop_num . '" data-id-to-remove="wphealthtracker-response-form-all-data-row-parent-' . $key . '-' . $loop_num . '"><p>' . $this->translations->common_trans_41 . '</p><img class="wphealthtracker-response-form-row-removal-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'garbage.svg" /></div>';
						}

						$duplicate_string = '
					<div class="wphealthtracker-response-form-food-row-duplicate-div" data-date="' . $this->humandate . '" data-key="' . $key . '" data-loopnum="' . $loop_num . '" data-idnum="' . $loop_num . '" data-id-to-update="' . $loop_num . '" data-id-to-add-after="wphealthtracker-response-form-all-data-row-parent-' . $key . '-' . $loop_num . '"><p>' . $this->translations->common_trans_40 . '</p><img class="wphealthtracker-response-form-row-removal-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'duplicate.svg" />
					</div>';

						$final_food_string = $final_food_string . '
					<div class="wphealthtracker-response-form-all-data-row-parent" id="wphealthtracker-response-form-all-data-row-parent-' . $key . '-' . $loop_num . '">
					<div class="wphealthtracker-response-form-food-all-data-row" ' . $data_section . ' id="wphealthtracker-response-form-all-data-row-1" data-open="true" style="opacity: 1;">
						<div class="wphealthtracker-response-form-diet-shaded-container-title">
							<h3><img class="wphealthtracker-icon-h2-image-diet" data-label="diet-weight" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'groceries.svg"> ' . $this->translations->diet_trans_2 . ' #<span class="wphealthtracker-food-item-span">' . ( $key + 1 ) . '</span> - ' . $this->humandate . '</h3>
						</div>
						<div class="wphealthtracker-expand-minimize-div-all-data">
							<p class="wphealthtracker-expand-minimize-p" id="wphealthtracker-expand-minimize-p-enter" style="opacity: 1;">' . $this->translations->common_trans_1 . '</p>
							<img src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'rotate.svg" class="wphealthtracker-indiv-choice-img-rotate" id="wphealthtracker-indiv-choice-img-rotate-enter">
						</div>
					</div>
					<div class="wphealthtracker-response-form-diet-shaded-container" id="wphealthtracker-response-form-diet-shaded-container-' . $key . '-' . $loop_num . '">
							<div class="wphealthtracker-response-form-data-row-food-inner-cont">
								' . $this->output_diet_enter_and_view_top_filter() . '
								<div class="wphealthtracker-response-form-data-row-food" id="wphealthtracker-response-form-food-item-row-div-' . $key . '-' . $loop_num . '">
									<div class="wphealthtracker-response-form-diet-row-div-cal-pro">
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-item" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_2 . '</p>
											<input type="text" class="wphealthtracker-response-form-input-text wphealthtracker-response-form-input-text-food" id="wphealthtracker-response-form-input-text-food-name-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" value="' . $fooditem . '"/>
										</div>
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-category" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_35 . '</p>
											<input type="text" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-food-category-' . $key . '-' . $loop_num . '"value="' . $category . '"/>
										</div>
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-time-consumed" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_3 . '</p>
											<input ' . $time_input . ' class="wphealthtracker-response-form-input-time wphealthtracker-response-form-input-time-food" id="wphealthtracker-response-form-input-time-food-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" value="' . $time . '"/>
										</div>
									</div>
								</div>
								<div class="wphealthtracker-response-form-data-row-food" id="wphealthtracker-response-form-food-calories-row-div-' . $key . '-' . $loop_num . '">
									<div class="wphealthtracker-response-form-diet-row-div-cal-pro">
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-calories" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_8 . '</p>
											<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-energy-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" value="' . $energy . '"/>
										</div>
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-calories-measurement" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_23 . '</p>
											<select class="wphealthtracker-response-form-select" id="wphealthtracker-response-form-input-select-energy-measurement-' . $key . '-' . $loop_num . '">
												' . $energymeasure . '
											</select>
										</div>
									</div>
								</div>
								<div class="wphealthtracker-response-form-data-row-food" id="wphealthtracker-response-form-food-protein-row-div-' . $key . '-' . $loop_num . '">
									<div class="wphealthtracker-response-form-diet-row-div-cal-pro">
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-protein" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_12 . '</p>
											<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-protein-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" value="' . $protein . '"/>
										</div>
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-protein-type" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_36 . '</p>
											<select class="wphealthtracker-response-form-select" id="wphealthtracker-response-form-input-select-protein-measurement-' . $key . '-' . $loop_num . '">
												' . $proteintype . '
											</select>
										</div>
									</div>
								</div>
								<div class="wphealthtracker-response-form-data-row-food" id="wphealthtracker-response-form-food-fat-row-div-' . $key . '-' . $loop_num . '">
									<div class="wphealthtracker-response-form-diet-row-div-cal-pro">
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-fat-total" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_4 . '</p>
											<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-fat-total-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" value="' . $totalfat . '"/>
										</div>
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-fat-sat" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_5 . '</p>
											<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-fat-sat-' . $key . '-' . $loop_num . '"value="' . $satfat . '"/>
										</div>
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-fat-monounsat" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_6 . '</p>
											<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-fat-mono-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" value="' . $monofat . '"/>
										</div>
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-fat-polyunsat" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_7 . '</p>
											<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-fat-poly-' . $key . '-' . $loop_num . '"value="' . $polyfat . '"/>
										</div>
									</div>
								</div>
								<div class="wphealthtracker-response-form-data-row-food" id="wphealthtracker-response-form-food-carbs-row-div-' . $key . '-' . $loop_num . '">
									<div class="wphealthtracker-response-form-diet-row-div-cal-pro">
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-carbs-total" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_20 . '</p>
											<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-carbs-total-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" value="' . $totalcarbs . '"/>
										</div>
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-carbs-total" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_21 . '</p>
											<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-carbs-fiber-' . $key . '-' . $loop_num . '"value="' . $dietaryfiber . '"/>
										</div>
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-carbs-sugars" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_22 . '</p>
											<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-carbs-sugar-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" value="' . $sugars . '"/>
										</div>
									</div>
								</div>
								' . $this->output_diet_enter_and_view_bottom_filter() . '
								<div class="wphealthtracker-response-form-data-row-food" id="wphealthtracker-response-form-food-image-row-div-' . $key . '-' . $loop_num . '">
									<div class="wphealthtracker-response-form-diet-row-div-cal-pro">
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_28 . '</p>
											<input type="text" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-image-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" value="' . $imageurl . '" placeholder="' . $this->translations->common_trans_28 . '"/>
										</div>
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-image-button" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_29 . '</p>
											<button class="wphealthtracker-response-form-input-button wphealthtracker-response-form-input-button-image-upload" id="wphealthtracker-response-form-input-button-image-upload-' . $key . '-' . $loop_num . '">' . $this->translations->common_trans_30 . '</button>
										</div>
									</div>
								</div>
								<div class="wphealthtracker-response-form-data-row-food" id="wphealthtracker-response-form-food-file-row-div-' . $key . '-' . $loop_num . '">
									<div class="wphealthtracker-response-form-diet-row-div-cal-pro">
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-file" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_32 . '</p>
											<input type="text" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-file-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" value="' . $fileurl . '" placeholder="' . $this->translations->common_trans_32 . '"/>
										</div>
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-file-button" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_33 . '</p>
											<button class="wphealthtracker-response-form-input-button wphealthtracker-response-form-input-button-file-upload" id="wphealthtracker-response-form-input-button-file-upload-' . $key . '-' . $loop_num . '">' . $this->translations->common_trans_34 . '</button>
										</div>
									</div>
								</div>
								' . $duplicate_string . '
								' . $removal_string . '
							</div>
						</div>
						</div>
						';
					}

					// Now output a blank and open form for the user to add a new food item, if we're dealing with Today's data - if not, user can add additional food items to previous days by using the 'Add a row' circle image button thing.
					if ( 'today' === $type ) {

						$duplicate_string = '
					<div class="wphealthtracker-response-form-food-row-duplicate-div" data-date="' . $this->humandate . '" data-key="' . ( $key + 1 ) . '" data-loopnum="' . $loop_num . '" data-idnum="' . $loop_num . '" data-id-to-update="' . $loop_num . '" data-id-to-add-after="wphealthtracker-response-form-all-data-row-parent-' . ( $key + 1 ) . '-' . $loop_num . '"><p>' . $this->translations->common_trans_40 . '</p><img class="wphealthtracker-response-form-row-removal-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'duplicate.svg" />
					</div>';

						$final_food_string = $final_food_string . '<div class="wphealthtracker-response-form-all-data-row-parent" id="wphealthtracker-response-form-all-data-row-parent-' . ( $key + 1 ) . '-' . $loop_num . '">
					<div class="wphealthtracker-response-form-food-all-data-row" ' . $data_section . ' id="wphealthtracker-response-form-all-data-row-1" data-open="true" style="opacity: 1;">
						<div class="wphealthtracker-response-form-diet-shaded-container-title">
							<h3><img class="wphealthtracker-icon-h2-image-diet" data-label="diet-weight" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'groceries.svg"> ' . $this->translations->diet_trans_2 . ' #<span class="wphealthtracker-food-item-span">' . ( $key + 2 ) . '</span> - ' . $this->humandate . '</h3>
						</div>
						<div class="wphealthtracker-expand-minimize-div-all-data">
							<p class="wphealthtracker-expand-minimize-p" id="wphealthtracker-expand-minimize-p-enter" style="opacity: 1;">' . $this->translations->common_trans_39 . '</p>
							<img src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'rotate.svg" class="wphealthtracker-indiv-choice-img-rotate" id="wphealthtracker-indiv-choice-img-rotate-enter" style="transform: rotate(180deg);">
						</div>
					</div>
					<div class="wphealthtracker-response-form-diet-shaded-container" id="wphealthtracker-response-form-diet-shaded-container-' . ( $key + 1 ) . '-' . $loop_num . '" style="height:632px;">
							<div class="wphealthtracker-response-form-data-row-food-inner-cont">
								' . $this->output_diet_enter_and_view_top_filter() . '
								<div class="wphealthtracker-response-form-data-row-food" id="wphealthtracker-response-form-food-item-row-div-' . ( $key + 1 ) . '-' . $loop_num . '">
									<div class="wphealthtracker-response-form-diet-row-div-cal-pro">
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-item" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_2 . '</p>
											<input type="text" class="wphealthtracker-response-form-input-text wphealthtracker-response-form-input-text-food" id="wphealthtracker-response-form-input-text-food-name-' . ( $key + 1 ) . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
										</div>
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-category" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_35 . '</p>
											<input type="text" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-food-category-' . ( $key + 1 ) . '-' . $loop_num . '"/>
										</div>
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-time-consumed" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_3 . '</p>
											<input type="time" class="wphealthtracker-response-form-input-time wphealthtracker-response-form-input-time-food" id="wphealthtracker-response-form-input-time-food-' . ( $key + 1 ) . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
										</div>
									</div>
								</div>
								<div class="wphealthtracker-response-form-data-row-food" id="wphealthtracker-response-form-food-calories-row-div-' . ( $key + 1 ) . '-' . $loop_num . '">
									<div class="wphealthtracker-response-form-diet-row-div-cal-pro">
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-calories" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_8 . '</p>
											<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-energy-' . ( $key + 1 ) . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
										</div>
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-calories-measurement" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_23 . '</p>
											<select class="wphealthtracker-response-form-select" id="wphealthtracker-response-form-input-select-energy-measurement-' . ( $key + 1 ) . '-' . $loop_num . '">
												' . $energymeasure . '
											</select>
										</div>
									</div>
								</div>
								<div class="wphealthtracker-response-form-data-row-food" id="wphealthtracker-response-form-food-protein-row-div-' . ( $key + 1 ) . '-' . $loop_num . '">
									<div class="wphealthtracker-response-form-diet-row-div-cal-pro">
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-protein" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_12 . '</p>
											<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-protein-' . ( $key + 1 ) . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
										</div>
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-protein-type" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_36 . '</p>
											<select class="wphealthtracker-response-form-select" id="wphealthtracker-response-form-input-select-protein-measurement-' . ( $key + 1 ) . '-' . $loop_num . '">
												' . $proteintype . '
											</select>
										</div>
									</div>
								</div>
								<div class="wphealthtracker-response-form-data-row-food" id="wphealthtracker-response-form-food-fat-row-div-' . ( $key + 1 ) . '-' . $loop_num . '">
									<div class="wphealthtracker-response-form-diet-row-div-cal-pro">
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-fat-total" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_4 . '</p>
											<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-fat-total-' . ( $key + 1 ) . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
										</div>
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-fat-sat" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_5 . '</p>
											<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-fat-sat-' . ( $key + 1 ) . '-' . $loop_num . '"/>
										</div>
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-fat-monounsat" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_6 . '</p>
											<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-fat-mono-' . ( $key + 1 ) . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
										</div>
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-fat-polyunsat" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_7 . '</p>
											<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-fat-poly-' . ( $key + 1 ) . '-' . $loop_num . '"/>
										</div>
									</div>
								</div>
								<div class="wphealthtracker-response-form-data-row-food" id="wphealthtracker-response-form-food-carbs-row-div-' . ( $key + 1 ) . '-' . $loop_num . '">
									<div class="wphealthtracker-response-form-diet-row-div-cal-pro">
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-carbs-total" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_20 . '</p>
											<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-carbs-total-' . ( $key + 1 ) . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
										</div>
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-carbs-fiber" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_21 . '</p>
											<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-carbs-fiber-' . ( $key + 1 ) . '-' . $loop_num . '"/>
										</div>
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-carbs-sugars" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_22 . '</p>
											<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-carbs-sugar-' . ( $key + 1 ) . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
										</div>
									</div>
								</div>
								' . $this->output_diet_enter_and_view_bottom_filter() . '
								<div class="wphealthtracker-response-form-data-row-food" id="wphealthtracker-response-form-food-image-row-div-' . ( $key + 1 ) . '-' . $loop_num . '">
									<div class="wphealthtracker-response-form-diet-row-div-cal-pro">
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_28 . '</p>
											<input type="text" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-image-' . ( $key + 1 ) . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" placeholder="' . $this->translations->common_trans_28 . '"/>
										</div>
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-image-button" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_29 . '</p>
											<button class="wphealthtracker-response-form-input-button wphealthtracker-response-form-input-button-image-upload" id="wphealthtracker-response-form-input-button-image-upload-' . ( $key + 1 ) . '-' . $loop_num . '">' . $this->translations->common_trans_30 . '</button>
										</div>
									</div>
								</div>
								<div class="wphealthtracker-response-form-data-row-food" id="wphealthtracker-response-form-food-file-row-div-' . ( $key + 1 ) . '-' . $loop_num . '">
									<div class="wphealthtracker-response-form-diet-row-div-cal-pro">
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-file" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_32 . '</p>
											<input type="text" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-file-' . ( $key + 1 ) . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" placeholder="' . $this->translations->common_trans_32 . '"/>
										</div>
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-file-button" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_33 . '</p>
											<button class="wphealthtracker-response-form-input-button wphealthtracker-response-form-input-button-file-upload" id="wphealthtracker-response-form-input-button-file-upload-' . ( $key + 1 ) . '-' . $loop_num . '">' . $this->translations->common_trans_34 . '</button>
										</div>
									</div>
								</div>
								<div class="wphealthtracker-response-form-food-row-removal-div" data-id-to-update="' . $loop_num . '" data-id-to-remove="wphealthtracker-response-form-all-data-row-parent-' . ( $key + 1 ) . '-' . $loop_num . '"><p>' . $this->translations->common_trans_41 . '</p><img class="wphealthtracker-response-form-row-removal-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'garbage.svg" />
								</div>
								' . $duplicate_string . '
							</div>
						</div>
						</div>';
					}
				} else {

					// If there's only one saved food entry for today.
					$fooditem     = '';
					$category     = '';
					$time         = '0:00';
					$energy       = 0;
					$calmeasure   = '';
					$protein      = 0;
					$proteintype  = '';
					$totalfat     = 0;
					$satfat       = 0;
					$monofat      = 0;
					$polyfat      = 0;
					$totalcarbs   = 0;
					$dietaryfiber = 0;
					$sugars       = 0;
					$imageurl     = '';
					$fileurl      = '';

					$foodsplit = explode( ';', $this->foodstring );

					if ( count( $foodsplit ) > 0 ) {
						$fooditem = $foodsplit[0];
					}

					if ( count( $foodsplit ) > 1 ) {
						$category = $foodsplit[1];
					}

					if ( count( $foodsplit ) > 2 ) {
						$time = $foodsplit[2];
					}

					if ( count( $foodsplit ) > 3 ) {
						$energy = $foodsplit[3];
					}

					if ( count( $foodsplit ) > 4 ) {
						$energymeasure = $foodsplit[4];
					}

					if ( count( $foodsplit ) > 5 ) {
						$protein = $foodsplit[5];
					}

					if ( count( $foodsplit ) > 6 ) {
						$proteintype = $foodsplit[6];
					}

					if ( count( $foodsplit ) > 7 ) {
						$totalfat = $foodsplit[7];
					}

					if ( count( $foodsplit ) > 8 ) {
						$satfat = $foodsplit[8];
					}

					if ( count( $foodsplit ) > 9 ) {
						$monofat = $foodsplit[9];
					}

					if ( count( $foodsplit ) > 10 ) {
						$polyfat = $foodsplit[10];
					}

					if ( count( $foodsplit ) > 11 ) {
						$totalcarbs = $foodsplit[11];
					}

					if ( count( $foodsplit ) > 12 ) {
						$dietaryfiber = $foodsplit[12];
					}

					if ( count( $foodsplit ) > 13 ) {
						$sugars = $foodsplit[13];
					}

					if ( count( $foodsplit ) > 14 ) {
						$imageurl = $foodsplit[14];
					}

					if ( count( $foodsplit ) > 15 ) {
						$fileurl = $foodsplit[15];
					}

					// Build the Options for the Calories/Energy Select.
					if ( $energymeasure === $this->translations->diet_trans_9 ) {
						$energymeasure =
						'<option selected>' . $this->translations->diet_trans_9 . '</option>
						<option>' . $this->translations->diet_trans_10 . '</option>
						<option>' . $this->translations->diet_trans_11 . '</option>';
					} elseif ( $energymeasure === $this->translations->diet_trans_10 ) {
						$energymeasure =
						'<option>' . $this->translations->diet_trans_9 . '</option>
						<option selected>' . $this->translations->diet_trans_10 . '</option>
						<option>' . $this->translations->diet_trans_11 . '</option>';
					} elseif ( $energymeasure === $this->translations->diet_trans_11 ) {
						$energymeasure =
						'<option>' . $this->translations->diet_trans_9 . '</option>
						<option>' . $this->translations->diet_trans_10 . '</option>
						<option selected>' . $this->translations->diet_trans_11 . '</option>';
					} else {
						$energymeasure =
						'<option>' . $this->translations->diet_trans_9 . '</option>
						<option>' . $this->translations->diet_trans_10 . '</option>
						<option>' . $this->translations->diet_trans_11 . '</option>';
					}

					// Build the Options for the Protein Select.
					if ( $proteintype === $this->translations->common_trans_37 ) {
						$proteintype =
						'<option selected>' . $this->translations->common_trans_37 . '</option>
						<option>' . $this->translations->diet_trans_13 . '</option>
						<option>' . $this->translations->diet_trans_14 . '</option>
						<option>' . $this->translations->diet_trans_15 . '</option>
						<option>' . $this->translations->diet_trans_16 . '</option>
						<option>' . $this->translations->diet_trans_17 . '</option>
						<option>' . $this->translations->diet_trans_18 . '</option>
						<option>' . $this->translations->diet_trans_19 . '</option>
						<option>' . $this->translations->common_trans_38 . '</option>';
					} elseif ( $proteintype === $this->translations->diet_trans_13 ) {
						$proteintype =
						'<option>' . $this->translations->common_trans_37 . '</option>
						<option selected>' . $this->translations->diet_trans_13 . '</option>
						<option>' . $this->translations->diet_trans_14 . '</option>
						<option>' . $this->translations->diet_trans_15 . '</option>
						<option>' . $this->translations->diet_trans_16 . '</option>
						<option>' . $this->translations->diet_trans_17 . '</option>
						<option>' . $this->translations->diet_trans_18 . '</option>
						<option>' . $this->translations->diet_trans_19 . '</option>
						<option>' . $this->translations->common_trans_38 . '</option>';
					} elseif ( $proteintype === $this->translations->diet_trans_14 ) {
						$proteintype =
						'<option>' . $this->translations->common_trans_37 . '</option>
						<option>' . $this->translations->diet_trans_13 . '</option>
						<option selected>' . $this->translations->diet_trans_14 . '</option>
						<option>' . $this->translations->diet_trans_15 . '</option>
						<option>' . $this->translations->diet_trans_16 . '</option>
						<option>' . $this->translations->diet_trans_17 . '</option>
						<option>' . $this->translations->diet_trans_18 . '</option>
						<option>' . $this->translations->diet_trans_19 . '</option>
						<option>' . $this->translations->common_trans_38 . '</option>';
					} elseif ( $proteintype === $this->translations->diet_trans_15 ) {
						$proteintype =
						'<option>' . $this->translations->common_trans_37 . '</option>
						<option>' . $this->translations->diet_trans_13 . '</option>
						<option>' . $this->translations->diet_trans_14 . '</option>
						<option selected>' . $this->translations->diet_trans_15 . '</option>
						<option>' . $this->translations->diet_trans_16 . '</option>
						<option>' . $this->translations->diet_trans_17 . '</option>
						<option>' . $this->translations->diet_trans_18 . '</option>
						<option>' . $this->translations->diet_trans_19 . '</option>
						<option>' . $this->translations->common_trans_38 . '</option>';
					} elseif ( $proteintype === $this->translations->diet_trans_16 ) {
						$proteintype =
						'<option>' . $this->translations->common_trans_37 . '</option>
						<option>' . $this->translations->diet_trans_13 . '</option>
						<option>' . $this->translations->diet_trans_14 . '</option>
						<option>' . $this->translations->diet_trans_15 . '</option>
						<option selected>' . $this->translations->diet_trans_16 . '</option>
						<option>' . $this->translations->diet_trans_17 . '</option>
						<option>' . $this->translations->diet_trans_18 . '</option>
						<option>' . $this->translations->diet_trans_19 . '</option>
						<option>' . $this->translations->common_trans_38 . '</option>';
					} elseif ( $proteintype === $this->translations->diet_trans_17 ) {
						$proteintype =
						'<option>' . $this->translations->common_trans_37 . '</option>
						<option>' . $this->translations->diet_trans_13 . '</option>
						<option>' . $this->translations->diet_trans_14 . '</option>
						<option>' . $this->translations->diet_trans_15 . '</option>
						<option>' . $this->translations->diet_trans_16 . '</option>
						<option selected>' . $this->translations->diet_trans_17 . '</option>
						<option>' . $this->translations->diet_trans_18 . '</option>
						<option>' . $this->translations->diet_trans_19 . '</option>
						<option>' . $this->translations->common_trans_38 . '</option>';
					} elseif ( $proteintype === $this->translations->diet_trans_18 ) {
						$proteintype =
						'<option>' . $this->translations->common_trans_37 . '</option>
						<option>' . $this->translations->diet_trans_13 . '</option>
						<option>' . $this->translations->diet_trans_14 . '</option>
						<option>' . $this->translations->diet_trans_15 . '</option>
						<option>' . $this->translations->diet_trans_16 . '</option>
						<option>' . $this->translations->diet_trans_17 . '</option>
						<option selected>' . $this->translations->diet_trans_18 . '</option>
						<option>' . $this->translations->diet_trans_19 . '</option>
						<option>' . $this->translations->common_trans_38 . '</option>';
					} elseif ( $proteintype === $this->translations->diet_trans_19 ) {
						$proteintype =
						'<option>' . $this->translations->common_trans_37 . '</option>
						<option>' . $this->translations->diet_trans_13 . '</option>
						<option>' . $this->translations->diet_trans_14 . '</option>
						<option>' . $this->translations->diet_trans_15 . '</option>
						<option>' . $this->translations->diet_trans_16 . '</option>
						<option>' . $this->translations->diet_trans_17 . '</option>
						<option>' . $this->translations->diet_trans_18 . '</option>
						<option selected>' . $this->translations->diet_trans_19 . '</option>
						<option>' . $this->translations->common_trans_38 . '</option>';
					} elseif ( $proteintype === $this->translations->common_trans_38 ) {
						$proteintype =
						'<option>' . $this->translations->common_trans_37 . '</option>
						<option>' . $this->translations->diet_trans_13 . '</option>
						<option>' . $this->translations->diet_trans_14 . '</option>
						<option>' . $this->translations->diet_trans_15 . '</option>
						<option>' . $this->translations->diet_trans_16 . '</option>
						<option>' . $this->translations->diet_trans_17 . '</option>
						<option>' . $this->translations->diet_trans_18 . '</option>
						<option>' . $this->translations->diet_trans_19 . '</option>
						<option selected>' . $this->translations->common_trans_38 . '</option>';
					} else {
						$proteintype =
						'<option>' . $this->translations->common_trans_37 . '</option>
						<option>' . $this->translations->diet_trans_13 . '</option>
						<option>' . $this->translations->diet_trans_14 . '</option>
						<option>' . $this->translations->diet_trans_15 . '</option>
						<option>' . $this->translations->diet_trans_16 . '</option>
						<option>' . $this->translations->diet_trans_17 . '</option>
						<option>' . $this->translations->diet_trans_18 . '</option>
						<option>' . $this->translations->diet_trans_19 . '</option>
						<option>' . $this->translations->common_trans_38 . '</option>';
					}

					// Handle the switching from input="time" to input="text" for cross-browser/safari support.
					if ( strlen( $time ) !== 5 && substr( $time, -3, 1 ) !== ':' ) {
						$time_input = 'type="text"';
					} else {
						$time_input = 'type="time"';
					}

					$duplicate_string = '
					<div class="wphealthtracker-response-form-food-row-duplicate-div" data-date="' . $this->humandate . '" data-key="' . $key . '" data-loopnum="' . $loop_num . '" data-idnum="' . $loop_num . '" data-id-to-update="' . $loop_num . '" data-id-to-add-after="wphealthtracker-response-form-all-data-row-parent-' . $key . '-' . $loop_num . '"><p>' . $this->translations->common_trans_40 . '</p><img class="wphealthtracker-response-form-row-removal-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'duplicate.svg" />
					</div>';

					$final_food_string = $final_food_string . '
				<div class="wphealthtracker-response-form-all-data-row-parent" id="wphealthtracker-response-form-all-data-row-parent-' . $key . '-' . $loop_num . '">
					<div class="wphealthtracker-response-form-food-all-data-row" ' . $data_section . ' id="wphealthtracker-response-form-all-data-row-1" data-open="true" style="opacity: 1;">
					<div class="wphealthtracker-response-form-diet-shaded-container-title">
						<h3><img class="wphealthtracker-icon-h2-image-diet" data-label="diet-weight" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'groceries.svg"> ' . $this->translations->diet_trans_2 . ' #<span class="wphealthtracker-food-item-span">' . ( $key + 1 ) . '</span> - ' . $this->humandate . '</h3>
					</div>
					<div class="wphealthtracker-expand-minimize-div-all-data">
						<p class="wphealthtracker-expand-minimize-p" id="wphealthtracker-expand-minimize-p-enter" style="opacity: 1;">' . $this->translations->common_trans_1 . '</p>
						<img src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'rotate.svg" class="wphealthtracker-indiv-choice-img-rotate" id="wphealthtracker-indiv-choice-img-rotate-enter">
					</div>
				</div>
				<div class="wphealthtracker-response-form-diet-shaded-container" id="wphealthtracker-response-form-diet-shaded-container-' . $key . '-' . $loop_num . '">
						<div class="wphealthtracker-response-form-data-row-food-inner-cont">
							' . $this->output_diet_enter_and_view_top_filter() . '
							<div class="wphealthtracker-response-form-data-row-food" id="wphealthtracker-response-form-food-row-div-' . $key . '-' . $loop_num . '">
								<div class="wphealthtracker-response-form-diet-row-div-cal-pro">
									<div class="wphealthtracker-response-form-diet-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-item" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_2 . '</p>
										<input type="text" class="wphealthtracker-response-form-input-text wphealthtracker-response-form-input-text-food" id="wphealthtracker-response-form-input-text-food-name-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" value="' . $fooditem . '"/>
									</div>
									<div class="wphealthtracker-response-form-diet-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-category" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_35 . '</p>
										<input type="text" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-food-category-' . $key . '-' . $loop_num . '"value="' . $category . '"/>
									</div>
									<div class="wphealthtracker-response-form-diet-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-time-consumed" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_3 . '</p>
										<input ' . $time_input . ' class="wphealthtracker-response-form-input-time wphealthtracker-response-form-input-time-food" id="wphealthtracker-response-form-input-time-food-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" value="' . $time . '"/>
									</div>
								</div>
							</div>
							<div class="wphealthtracker-response-form-data-row-food" id="wphealthtracker-response-form-food-row-div-' . $key . '-' . $loop_num . '">
								<div class="wphealthtracker-response-form-diet-row-div-cal-pro">
									<div class="wphealthtracker-response-form-diet-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-calories" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_8 . '</p>
										<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-energy-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" value="' . $energy . '"/>
									</div>
									<div class="wphealthtracker-response-form-diet-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-calories-measurement" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_23 . '</p>
										<select class="wphealthtracker-response-form-select" id="wphealthtracker-response-form-input-select-energy-measurement-' . $key . '-' . $loop_num . '">
											' . $energymeasure . '
										</select>
									</div>
								</div>
							</div>
							<div class="wphealthtracker-response-form-data-row-food" id="wphealthtracker-response-form-food-row-div-' . $key . '-' . $loop_num . '">
								<div class="wphealthtracker-response-form-diet-row-div-cal-pro">
									<div class="wphealthtracker-response-form-diet-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-protein" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_12 . '</p>
										<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-protein-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" value="' . $protein . '"/>
									</div>
									<div class="wphealthtracker-response-form-diet-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-protein-type" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_36 . '</p>
										<select class="wphealthtracker-response-form-select" id="wphealthtracker-response-form-input-select-protein-measurement-' . $key . '-' . $loop_num . '">
											' . $proteintype . '
										</select>
									</div>
								</div>
							</div>
							<div class="wphealthtracker-response-form-data-row-food" id="wphealthtracker-response-form-food-row-div-' . $key . '-' . $loop_num . '">
								<div class="wphealthtracker-response-form-diet-row-div-cal-pro">
									<div class="wphealthtracker-response-form-diet-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-fat-total" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_4 . '</p>
										<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-fat-total-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" value="' . $totalfat . '"/>
									</div>
									<div class="wphealthtracker-response-form-diet-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-fat-sat" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_5 . '</p>
										<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-fat-sat-' . $key . '-' . $loop_num . '"value="' . $satfat . '"/>
									</div>
									<div class="wphealthtracker-response-form-diet-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-fat-monounsat" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_6 . '</p>
										<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-fat-mono-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" value="' . $monofat . '"/>
									</div>
									<div class="wphealthtracker-response-form-diet-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-fat-polyunsat" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_7 . '</p>
										<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-fat-poly-' . $key . '-' . $loop_num . '"value="' . $polyfat . '"/>
									</div>
								</div>
							</div>
							<div class="wphealthtracker-response-form-data-row-food" id="wphealthtracker-response-form-food-row-div-' . $key . '-' . $loop_num . '">
								<div class="wphealthtracker-response-form-diet-row-div-cal-pro">
									<div class="wphealthtracker-response-form-diet-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-carbs-total" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_20 . '</p>
										<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-carbs-total-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" value="' . $totalcarbs . '"/>
									</div>
									<div class="wphealthtracker-response-form-diet-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-carbs-fiber" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_21 . '</p>
										<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-carbs-fiber-' . $key . '-' . $loop_num . '"value="' . $dietaryfiber . '"/>
									</div>
									<div class="wphealthtracker-response-form-diet-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-carbs-sugars" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_22 . '</p>
										<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-carbs-sugar-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" value="' . $sugars . '"/>
									</div>
								</div>
							</div>
							' . $this->output_diet_enter_and_view_bottom_filter() . '
							<div class="wphealthtracker-response-form-data-row-food" id="wphealthtracker-response-form-food-row-div-' . $key . '-' . $loop_num . '">
								<div class="wphealthtracker-response-form-diet-row-div-cal-pro">
									<div class="wphealthtracker-response-form-diet-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_28 . '</p>
										<input type="text" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-image-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" value="' . $imageurl . '" placeholder="' . $this->translations->common_trans_28 . '"/>
									</div>
									<div class="wphealthtracker-response-form-diet-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-image-button" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_29 . '</p>
										<button class="wphealthtracker-response-form-input-button wphealthtracker-response-form-input-button-image-upload" id="wphealthtracker-response-form-input-button-image-upload-' . $key . '-' . $loop_num . '">' . $this->translations->common_trans_30 . '</button>
									</div>
								</div>
							</div>
							<div class="wphealthtracker-response-form-data-row-food" id="wphealthtracker-response-form-food-row-div-' . $key . '-' . $loop_num . '">
								<div class="wphealthtracker-response-form-diet-row-div-cal-pro">
									<div class="wphealthtracker-response-form-diet-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-file" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_32 . '</p>
										<input type="text" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-file-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" value="' . $fileurl . '" placeholder="' . $this->translations->common_trans_32 . '"/>
									</div>
									<div class="wphealthtracker-response-form-diet-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-file-button" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_33 . '</p>
										<button class="wphealthtracker-response-form-input-button wphealthtracker-response-form-input-button-file-upload" id="wphealthtracker-response-form-input-button-file-upload-' . $key . '-' . $loop_num . '">' . $this->translations->common_trans_34 . '</button>
									</div>
								</div>
							</div>
							' . $duplicate_string . '
						</div>
					</div>
					</div>';

					// Now output a blank and open form for the user to add a new food item, if we're dealing with Today's data - if not, user can add additional food items to previous days by using the 'Add a row' circle image button thing.
					if ( 'today' === $type ) {

						$duplicate_string = '
						<div class="wphealthtracker-response-form-food-row-duplicate-div" data-date="' . $this->humandate . '" data-key="' . ( $key + 1 ) . '" data-loopnum="' . $loop_num . '" data-idnum="' . $loop_num . '" data-id-to-update="' . $loop_num . '" data-id-to-add-after="wphealthtracker-response-form-all-data-row-parent-' . ( $key + 1 ) . '-' . $loop_num . '"><p>' . $this->translations->common_trans_40 . '</p><img class="wphealthtracker-response-form-row-removal-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'duplicate.svg" />
						</div>';

						$final_food_string = $final_food_string . '<div class="wphealthtracker-response-form-all-data-row-parent" id="wphealthtracker-response-form-all-data-row-parent-' . ( $key + 1 ) . '-' . $loop_num . '">
					<div class="wphealthtracker-response-form-food-all-data-row" ' . $data_section . ' id="wphealthtracker-response-form-all-data-row-1" data-open="true" style="opacity: 1;">
						<div class="wphealthtracker-response-form-diet-shaded-container-title">
							<h3><img class="wphealthtracker-icon-h2-image-diet" data-label="diet-weight" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'groceries.svg"> ' . $this->translations->diet_trans_2 . ' #<span class="wphealthtracker-food-item-span">' . ( $key + 2 ) . '</span> - ' . $this->humandate . '</span></h3>
						</div>
						<div class="wphealthtracker-expand-minimize-div-all-data">
							<p class="wphealthtracker-expand-minimize-p" id="wphealthtracker-expand-minimize-p-enter" style="opacity: 1;">' . $this->translations->common_trans_39 . '</p>
							<img src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'rotate.svg" class="wphealthtracker-indiv-choice-img-rotate" id="wphealthtracker-indiv-choice-img-rotate-enter" style="transform: rotate(180deg);">
						</div>
						</div>
						<div class="wphealthtracker-response-form-diet-shaded-container" id="wphealthtracker-response-form-diet-shaded-container-' . ( $key + 1 ) . '-' . $loop_num . '" style="height:632px;">
							<div class="wphealthtracker-response-form-data-row-food-inner-cont">
								' . $this->output_diet_enter_and_view_top_filter() . '
								<div class="wphealthtracker-response-form-data-row-food" id="wphealthtracker-response-form-food-row-div-' . ( $key + 1 ) . '-' . $loop_num . '">
									<div class="wphealthtracker-response-form-diet-row-div-cal-pro">
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-item" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_2 . '</p>
											<input type="text" class="wphealthtracker-response-form-input-text wphealthtracker-response-form-input-text-food" id="wphealthtracker-response-form-input-text-food-name-' . ( $key + 1 ) . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
										</div>
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-category" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_35 . '</p>
											<input type="text" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-food-category-' . ( $key + 1 ) . '-' . $loop_num . '"/>
										</div>
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-time-consumed" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_3 . '</p>
											<input type="time" class="wphealthtracker-response-form-input-time wphealthtracker-response-form-input-time-food" id="wphealthtracker-response-form-input-time-food-' . ( $key + 1 ) . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
										</div>
									</div>
								</div>
								<div class="wphealthtracker-response-form-data-row-food" id="wphealthtracker-response-form-food-row-div-' . ( $key + 1 ) . '-' . $loop_num . '">
									<div class="wphealthtracker-response-form-diet-row-div-cal-pro">
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-calories" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_8 . '</p>
											<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-energy-' . ( $key + 1 ) . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
										</div>
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-calories-measurement" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_23 . '</p>
											<select class="wphealthtracker-response-form-select" id="wphealthtracker-response-form-input-select-energy-measurement-' . ( $key + 1 ) . '-' . $loop_num . '">
												' . $energymeasure . '
											</select>
										</div>
									</div>
								</div>
								<div class="wphealthtracker-response-form-data-row-food" id="wphealthtracker-response-form-food-row-div-' . ( $key + 1 ) . '-' . $loop_num . '">
									<div class="wphealthtracker-response-form-diet-row-div-cal-pro">
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-protein" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_12 . '</p>
											<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-protein-' . ( $key + 1 ) . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
										</div>
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-protein-type" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_36 . '</p>
											<select class="wphealthtracker-response-form-select" id="wphealthtracker-response-form-input-select-protein-measurement-' . ( $key + 1 ) . '-' . $loop_num . '">
												' . $proteintype . '
											</select>
										</div>
									</div>
								</div>
								<div class="wphealthtracker-response-form-data-row-food" id="wphealthtracker-response-form-food-row-div-' . ( $key + 1 ) . '-' . $loop_num . '">
									<div class="wphealthtracker-response-form-diet-row-div-cal-pro">
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-fat-total" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_4 . '</p>
											<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-fat-total-' . ( $key + 1 ) . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
										</div>
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-fat-sat" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_5 . '</p>
											<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-fat-sat-' . ( $key + 1 ) . '-' . $loop_num . '"/>
										</div>
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-fat-monounsat" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_6 . '</p>
											<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-fat-mono-' . ( $key + 1 ) . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
										</div>
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-fat-polyunsat" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_7 . '</p>
											<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-fat-poly-' . ( $key + 1 ) . '-' . $loop_num . '"/>
										</div>
									</div>
								</div>
								<div class="wphealthtracker-response-form-data-row-food" id="wphealthtracker-response-form-food-row-div-' . ( $key + 1 ) . '-' . $loop_num . '">
									<div class="wphealthtracker-response-form-diet-row-div-cal-pro">
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-carbs-total" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_20 . '</p>
											<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-carbs-total-' . ( $key + 1 ) . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
										</div>
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-carbs-fiber" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_21 . '</p>
											<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-carbs-fiber-' . ( $key + 1 ) . '-' . $loop_num . '"/>
										</div>
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-carbs-sugars" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_22 . '</p>
											<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-carbs-sugar-' . ( $key + 1 ) . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
										</div>
									</div>
								</div>
								' . $this->output_diet_enter_and_view_bottom_filter() . '
								<div class="wphealthtracker-response-form-data-row-food" id="wphealthtracker-response-form-food-row-div-' . ( $key + 1 ) . '-' . $loop_num . '">
									<div class="wphealthtracker-response-form-diet-row-div-cal-pro">
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_28 . '</p>
											<input type="text" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-image-' . ( $key + 1 ) . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" placeholder="' . $this->translations->common_trans_28 . '"/>
										</div>
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-image-button" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_29 . '</p>
											<button class="wphealthtracker-response-form-input-button wphealthtracker-response-form-input-button-image-upload" id="wphealthtracker-response-form-input-button-image-upload-' . ( $key + 1 ) . '-' . $loop_num . '">' . $this->translations->common_trans_30 . '</button>
										</div>
									</div>
								</div>
								<div class="wphealthtracker-response-form-data-row-food" id="wphealthtracker-response-form-food-row-div-' . ( $key + 1 ) . '-' . $loop_num . '">
									<div class="wphealthtracker-response-form-diet-row-div-cal-pro">
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-file" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_32 . '</p>
											<input type="text" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-file-' . ( $key + 1 ) . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" placeholder="' . $this->translations->common_trans_32 . '"/>
										</div>
										<div class="wphealthtracker-response-form-diet-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-file-button" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_33 . '</p>
											<button class="wphealthtracker-response-form-input-button wphealthtracker-response-form-input-button-file-upload" id="wphealthtracker-response-form-input-button-file-upload-' . ( $key + 1 ) . '-' . $loop_num . '">' . $this->translations->common_trans_34 . '</button>
										</div>
									</div>
								</div>
								<div class="wphealthtracker-response-form-food-row-removal-div" data-id-to-update="' . $loop_num . '" data-id-to-remove="wphealthtracker-response-form-all-data-row-parent-' . ( $key + 1 ) . '-' . $loop_num . '"><p>' . $this->translations->common_trans_41 . '</p><img class="wphealthtracker-response-form-row-removal-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'garbage.svg" />
								</div>
								' . $duplicate_string . '
							</div>
							</div>
							</div>';
					}
				}
			} else {
				// Now output a blank and open form for the user to add a new food item, if we're dealing with Today's data - if not, user can add additional food items to previous days by using the 'Add a row' circle image button thing.
				if ( 'today' === $type ) {

					$duplicate_string = '
				<div style="left:0px; right:0px;" class="wphealthtracker-response-form-food-row-duplicate-div" data-date="' . $this->humandate . '" data-key="' . ( $key + 1 ) . '" data-loopnum="' . $loop_num . '" data-idnum="' . $loop_num . '" data-id-to-update="' . $loop_num . '" data-id-to-add-after="wphealthtracker-response-form-all-data-row-parent-' . ( $key + 1 ) . '-' . $loop_num . '"><p>' . $this->translations->common_trans_40 . '</p><img class="wphealthtracker-response-form-row-removal-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'duplicate.svg" />
				</div>';

					$final_food_string = $final_food_string . '
				<div class="wphealthtracker-response-form-all-data-row-parent" id="wphealthtracker-response-form-all-data-row-parent-' . $key . '-' . $loop_num . '">
					<div class="wphealthtracker-response-form-food-all-data-row" ' . $data_section . ' id="wphealthtracker-response-form-all-data-row-1" data-open="true" style="opacity: 1;">
					<div class="wphealthtracker-response-form-diet-shaded-container-title">
						<h3><img class="wphealthtracker-icon-h2-image-diet" data-label="diet-weight" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'groceries.svg"> ' . $this->translations->diet_trans_2 . ' #<span class="wphealthtracker-food-item-span">1</span> - ' . $this->humandate . '</h3>
					</div>
					<div class="wphealthtracker-expand-minimize-div-all-data">
						<p class="wphealthtracker-expand-minimize-p" id="wphealthtracker-expand-minimize-p-enter" style="opacity: 1;">' . $this->translations->common_trans_39 . '</p>
						<img src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'rotate.svg" class="wphealthtracker-indiv-choice-img-rotate" id="wphealthtracker-indiv-choice-img-rotate-enter" style="transform: rotate(180deg);">
					</div>
				</div>
				<div class="wphealthtracker-response-form-diet-shaded-container" id="wphealthtracker-response-form-diet-shaded-container-' . $key . '-' . $loop_num . '" style="height:632px;">
					<div class="wphealthtracker-response-form-data-row-food-inner-cont">
						' . $this->output_diet_enter_and_view_top_filter() . '
						<div class="wphealthtracker-response-form-data-row-food" id="wphealthtracker-response-form-food-row-div-' . $key . '-' . $loop_num . '">
							<div class="wphealthtracker-response-form-diet-row-div-cal-pro">
								<div class="wphealthtracker-response-form-diet-innerrow-div">
									<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-item" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_2 . '</p>
									<input type="text" class="wphealthtracker-response-form-input-text wphealthtracker-response-form-input-text-food" id="wphealthtracker-response-form-input-text-food-name-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
								</div>
								<div class="wphealthtracker-response-form-diet-innerrow-div">
									<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-category" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_35 . '</p>
									<input type="text" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-food-category-' . $key . '-' . $loop_num . '"/>
								</div>
								<div class="wphealthtracker-response-form-diet-innerrow-div">
									<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-time-consumed" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_3 . '</p>
									<input type="time" class="wphealthtracker-response-form-input-time wphealthtracker-response-form-input-time-food" id="wphealthtracker-response-form-input-time-food-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
								</div>
							</div>
						</div>
						<div class="wphealthtracker-response-form-data-row-food" id="wphealthtracker-response-form-food-row-div-' . $key . '-' . $loop_num . '">
							<div class="wphealthtracker-response-form-diet-row-div-cal-pro">
								<div class="wphealthtracker-response-form-diet-innerrow-div">
									<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-calories" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_8 . '</p>
									<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-energy-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
								</div>
								<div class="wphealthtracker-response-form-diet-innerrow-div">
									<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-calories-measurement" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_23 . '</p>
									<select class="wphealthtracker-response-form-select" id="wphealthtracker-response-form-input-select-energy-measurement-' . $key . '-' . $loop_num . '">
										<option>' . $this->translations->diet_trans_9 . '</option>
										<option>' . $this->translations->diet_trans_10 . '</option>
										<option>' . $this->translations->diet_trans_11 . '</option>
									</select>
								</div>
							</div>
						</div>
						<div class="wphealthtracker-response-form-data-row-food" id="wphealthtracker-response-form-food-row-div-' . $key . '-' . $loop_num . '">
							<div class="wphealthtracker-response-form-diet-row-div-cal-pro">
								<div class="wphealthtracker-response-form-diet-innerrow-div">
									<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-protein" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_12 . '</p>
									<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-protein-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
								</div>
								<div class="wphealthtracker-response-form-diet-innerrow-div">
									<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-protein-type" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_36 . '</p>
									<select class="wphealthtracker-response-form-select" id="wphealthtracker-response-form-input-select-protein-measurement-' . $key . '-' . $loop_num . '">
										<option>' . $this->translations->common_trans_37 . '</option>
										<option>' . $this->translations->diet_trans_13 . '</option>
										<option>' . $this->translations->diet_trans_14 . '</option>
										<option>' . $this->translations->diet_trans_15 . '</option>
										<option>' . $this->translations->diet_trans_16 . '</option>
										<option>' . $this->translations->diet_trans_17 . '</option>
										<option>' . $this->translations->diet_trans_18 . '</option>
										<option>' . $this->translations->diet_trans_19 . '</option>
										<option>' . $this->translations->common_trans_38 . '</option>
									</select>
								</div>
							</div>
						</div>
						<div class="wphealthtracker-response-form-data-row-food" id="wphealthtracker-response-form-food-row-div-' . $key . '-' . $loop_num . '">
							<div class="wphealthtracker-response-form-diet-row-div-cal-pro">
								<div class="wphealthtracker-response-form-diet-innerrow-div">
									<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-fat-total" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_4 . '</p>
									<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-fat-total-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
								</div>
								<div class="wphealthtracker-response-form-diet-innerrow-div">
									<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-fat-sat" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_5 . '</p>
									<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-fat-sat-' . $key . '-' . $loop_num . '"/>
								</div>
								<div class="wphealthtracker-response-form-diet-innerrow-div">
									<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-fat-monounsat" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_6 . '</p>
									<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-fat-mono-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
								</div>
								<div class="wphealthtracker-response-form-diet-innerrow-div">
									<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-fat-polyunsat" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_7 . '</p>
									<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-fat-poly-' . $key . '-' . $loop_num . '"/>
								</div>
							</div>
						</div>
						<div class="wphealthtracker-response-form-data-row-food" id="wphealthtracker-response-form-food-row-div-' . $key . '-' . $loop_num . '">
							<div class="wphealthtracker-response-form-diet-row-div-cal-pro">
								<div class="wphealthtracker-response-form-diet-innerrow-div">
									<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-carbs-total" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_20 . '</p>
									<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-carbs-total-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
								</div>
								<div class="wphealthtracker-response-form-diet-innerrow-div">
									<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-carbs-fiber" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_21 . '</p>
									<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-carbs-fiber-' . $key . '-' . $loop_num . '"/>
								</div>
								<div class="wphealthtracker-response-form-diet-innerrow-div">
									<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-carbs-sugars" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->diet_trans_22 . '</p>
									<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-carbs-sugar-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
								</div>
							</div>
						</div>
						' . $this->output_diet_enter_and_view_bottom_filter() . '
						<div class="wphealthtracker-response-form-data-row-food" id="wphealthtracker-response-form-food-row-div-' . $key . '-' . $loop_num . '">
							<div class="wphealthtracker-response-form-diet-row-div-cal-pro">
								<div class="wphealthtracker-response-form-diet-innerrow-div">
									<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_28 . '</p>
									<input type="text" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-image-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" placeholder="' . $this->translations->common_trans_28 . '"/>
								</div>
								<div class="wphealthtracker-response-form-diet-innerrow-div">
									<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-image-button" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_29 . '</p>
									<button class="wphealthtracker-response-form-input-button wphealthtracker-response-form-input-button-image-upload" id="wphealthtracker-response-form-input-button-image-upload-' . $key . '-' . $loop_num . '">' . $this->translations->common_trans_30 . '</button>
								</div>
							</div>
						</div>
						<div class="wphealthtracker-response-form-data-row-food" id="wphealthtracker-response-form-food-row-div-' . $key . '-' . $loop_num . '">
							<div class="wphealthtracker-response-form-diet-row-div-cal-pro">
								<div class="wphealthtracker-response-form-diet-innerrow-div">
									<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-file" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_32 . '</p>
									<input type="text" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-file-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" placeholder="' . $this->translations->common_trans_32 . '"/>
								</div>
								<div class="wphealthtracker-response-form-diet-innerrow-div">
									<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-food" data-label="diet-food-file-button" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_33 . '</p>
									<button class="wphealthtracker-response-form-input-button wphealthtracker-response-form-input-button-file-upload" id="wphealthtracker-response-form-input-button-file-upload-' . $key . '-' . $loop_num . '">' . $this->translations->common_trans_34 . '</button>
								</div>
							</div>
						</div>
						' . $duplicate_string . '
					</div>
					</div>
					</div>';
				}
			}

			if ( 'today' === $type ) {
				$next_food  = $key + 1;
				$class_name = 'wphealthtracker-response-form-food-row-addition-p-enter';
			} else {
				$next_food  = $key;
				$class_name = 'wphealthtracker-response-form-food-row-addition-p-view';
			}

			return $final_food_string = $final_food_string . '<div class="wphealthtracker-response-form-food-row-addition-div" id="wphealthtracker-response-form-food-row-addition-div-' . $loop_num . '" data-date="' . $this->humandate . '" data-key="' . $next_food . '" data-loopnum="' . $loop_num . '" data-foodnum="0" data-idnum="' . $loop_num . '" data-id-to-add-after="wphealthtracker-response-form-addfood-row-div-' . $key . '-' . $loop_num . '">
						<p class="' . $class_name . '">' . $this->translations->diet_trans_31 . '</p><img class="wphealthtracker-response-form-row-add-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'web-site.svg" />
					</div>
				';
		}


		/**
		 *  Filter to insert additional data capture code at the bottom of the 'Enter' container on the Exercise tab.
		 */
		private function output_diet_enter_and_view_top_filter() {

			$filter_return = '';
			if ( has_filter( 'wphealthtracker_data_diet_enter_and_view_top' ) ) {
				$filter_return = apply_filters( 'wphealthtracker_data_diet_enter_and_view_top', 'placeholder' );
			}

			return $filter_return;

		}


		/**
		 *  Filter to insert additional data capture code at the bottom of every individual exercise item in both the 'Enter' and 'View & Edit' section
		 */
		private function output_diet_enter_and_view_bottom_filter() {

			$filter_return = '';
			if ( has_filter( 'wphealthtracker_data_diet_enter_and_view_bottom' ) ) {
				$filter_return = apply_filters( 'wphealthtracker_data_diet_enter_and_view_bottom', 'placeholder' );
			}

			return $filter_return;

		}

		/**
		 *  Output the ending html part, with the spinner, the save button, and the response messager container
		 *
		 * @param int $type - the date.
		 * @param int $key - the loop/identifier key.
		 */
		private function output_diet_ending( $type, $key ) {

			// If we're outputing the save button for previous days, use the 'Update data for [date]' translation string.
			if ( 'previous' === $type ) {
				return '<div class="wphealthtracker-save-spinner-response-div">
				<div class="wphealthtracker-spinner-red" id="wphealthtracker-spinner-save-diet"></div>
				<div class="wphealthtracker-response-message-div" id="wphealthtracker-response-message-diet-div"></div>
				<button class="wphealthtracker-save-stuff-button-diet" id="wphealthtracker-save-daily-diet-enter-' . $key . '" data-firstname="' . $this->firstname . '" data-lastname="' . $this->lastname . '" data-human-date="' . $this->humandate . '" data-parent-id-num="' . $key . '">' . $this->translations->diet_trans_28 . ' ' . $this->humandate . '</button>
			</div>';
			}

			// If we're outputing the save button for previous days, use the 'Save data' translation string.
			if ( 'today' === $type ) {
				return '<div class="wphealthtracker-save-spinner-response-div">
				<div class="wphealthtracker-spinner-primary" id="wphealthtracker-spinner-save-diet"></div>
				<div class="wphealthtracker-response-message-div" id="wphealthtracker-response-message-diet-div"></div>
				<button class="wphealthtracker-save-stuff-button-diet" id="wphealthtracker-save-daily-diet-enter-' . $key . '" data-firstname="' . $this->firstname . '" data-lastname="' . $this->lastname . '" data-human-date="' . $this->humandate . '" data-parent-id-num="' . $key . '">' . $this->translations->diet_trans_24 . '</button>
			</div>';
			}

		}

		/**
		 *  Output the wrapper that will wrap around every previous day's entry, to provide the expansion/minimization div, it's text ad image, etc.
		 *
		 * @param int $loop_num - the loop/identifier key.
		 * @param int $type - whether Today or a Previous date.
		 */
		private function output_diet_enter_config_all_data_wrapper_html_open( $loop_num, $type ) {

			$data_section = ' data-section="' . $type . '" ';

			return '
			<div class="wphealthtracker-response-form-all-data-row-parent" id="wphealthtracker-response-form-all-data-row-parent-' . $loop_num . '-' . $loop_num . '">
					<div class="wphealthtracker-response-form-food-all-data-row" ' . $data_section . ' id="wphealthtracker-response-form-all-data-row-' . $loop_num . '">
				<img class="wphealthtracker-saved-data-indiv-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'analysis.svg" />
				<p class="wphealthtracker-all-data-p">' . $this->translations->diet_trans_29 . ' ' . $this->humandate . '</p>
				<div class="wphealthtracker-expand-minimize-div-all-data">
					<p class="wphealthtracker-expand-minimize-p" id="wphealthtracker-expand-minimize-p-enter">' . $this->translations->common_trans_1 . '</p>
					<img src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'rotate.svg" class="wphealthtracker-indiv-choice-img-rotate" id="wphealthtracker-indiv-choice-img-rotate-enter" />
				</div>
			</div>
			<div class="wphealthtracker-response-form-all-data-row-actual wphealthtracker-response-form-all-data-row-actual-diet"  id="wphealthtracker-response-form-data-row-actual-' . $loop_num . '">';

		}

		/**
		 *  Output the wrapper that will close every previous day's entry, to provide the expansion/minimization div, it's text ad image, etc.
		 *
		 * @param int $loop_num - the loop/identifier key.
		 */
		private function output_diet_enter_config_all_data_wrapper_html_close( $loop_num ) {

			return '</div></div>';

		}

		/**
		 *  Output the message for the user if no previously-saved data was found
		 *
		 * @param int $userfirst - user first name.
		 * @param int $userlast - user last name.
		 */
		private function output_no_data_html( $userfirst, $userlast ) {

			$no_data_html = '<div class="wphealthtracker-no-saved-data-div">
				<p>
					<img class="wphealthtracker-shocked-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'shocked.svg"/>
					<span class="wphealthtracker-no-saved-span1">' . $this->translations->common_trans_18 . '</span>
					<br/>
					' . $this->translations->common_trans_19 . ' ' . $userfirst . ' ' . $userlast . '!
					<br/>' . $this->translations->diet_trans_27 . ' ' . $this->date . '" ' . $this->translations->common_trans_21 . '
					<br/><br/>
					<span class="wphealthtracker-no-saved-span2">' . $this->translations->common_trans_22 . '</span>
				</p>
			</div>';

			return $no_data_html;

		}

		/**
		 *  Output the data filter html if previously-saved data was found
		 */
		private function output_data_filter_html() {

			$filter_html = '<div class="wphealthtracker-selected-user-response-view-filter-div">
								<div class="wphealthtracker-view-search-inner-div">
								<img class="wphealthtracker-filter-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'funnel.svg" />
									<p class="wphealthtracker-view-search-inner-title">' . $this->translations->common_trans_12 . '</p>
									<div class="wphealthtracker-view-search-inner-input-div">
										<select id="wphealthtracker-view-search-select">
											<option value="7">' . $this->translations->common_trans_8 . '</option>
											<option value="30">' . $this->translations->common_trans_9 . '</option>
											<option value="60">' . $this->translations->common_trans_10 . '</option>
											<option value="90">' . $this->translations->common_trans_11 . '</option>
										</select>
										<button class="wphealthtracker-view-filter-button-diet" id="wphealthtracker-view-filter-button-diet-id">' . $this->translations->common_trans_13 . '</button>
										<div class="wphealthtracker-spinner-primary" id="wphealthtracker-spinner-filter-diet"></div>
									</div>
								</div>
							</div>';

			return $filter_html;

		}




		/**
		 *  Build the final form for the 'Enter' container, taking into account that the user already has data saved for today.
		 *
		 * @param array $userdailydata - user's array of exercise data.
		 */
		public function output_today_data( $userdailydata ) {

			// Set class variables with data retrieved (or explicitly set) from the calling function.
			$this->firstname   = $userdailydata->firstname;
			$this->lastname    = $userdailydata->lastname;
			$this->wpuserid    = $userdailydata->wpuserid;
			$this->humandate   = $userdailydata->humandate;
			$this->foodstring  = $userdailydata->foodstring;
			$this->imgdieturl  = $userdailydata->dietimg;
			$this->filedieturl = $userdailydata->dietfiles;

			// Now make access check to see if user can access this part of WPHealthTRacker - get the users permissions
			// Make call to Transients class to see if Transient currently exists. If so, retrieve it, if not, make call to create_transient() with all required Parameters.
			global $wpdb;
			$currentwpuser    = wp_get_current_user();
			$users_table_name = $wpdb->prefix . 'wphealthtracker_users';
			require_once WPHEALTHTRACKER_CLASSES_TRANSIENTS_DIR . 'class-wphealthtracker-transients.php';
			$transients       = new WPHealthTracker_Transients();
			$transient_name   = 'wpht_' . md5( 'SELECT * FROM ' . $users_table_name . ' WHERE wpuserid == ' . $currentwpuser->ID );
			$transient_exists = $transients->existing_transient_check( $transient_name );
			if ( $transient_exists ) {
				$this->user_data = $transient_exists;
			} else {
				$query           = 'SELECT * FROM ' . $users_table_name . '  WHERE wpuserid = ' . $currentwpuser->ID;
				$this->user_data = $transients->create_transient( $transient_name, 'wpdb->get_row', $query, MONTH_IN_SECONDS );
			}

			// Now get the user's permissions.
			$user_perm = explode( ',', $this->user_data->permissions );

			// If the currently logged-in WordPress user is trying to access his own data, proceed, otherwise, check and see if this WordPress userhas the permissions to view or edit other's data.
			$proceed_flag = false;
			if ( $currentwpuser->ID === (int) $this->wpuserid || '1' === $user_perm[17] ) {
				$proceed_flag = true;
			}

			if ( $proceed_flag ) {

				// Output the individual data items.
				$piece_one = $this->output_diet_enter_config_food_item( 0, 'today' );

				// Finish up with the Spinner, response message area, and the Save button.
				$end_piece = $this->output_diet_ending( 'today', 0 );

				// Assemble the final output.
				$this->final_complete_output = $piece_one . $end_piece;
			} else {

				// Output the No Acess message.
				require_once WPHEALTHTRACKER_CLASSES_UTILITIES_DIR . 'class-wphealthtracker-utilities-accesscheck.php';
				$this->access = new WPHealthTracker_Utilities_Accesscheck();
				$this->final_complete_output = $this->access->wphealthtracker_accesscheck_no_permission_message();
			}

		}

		/**
		 *  Build the final form for the 'View' container
		 *
		 * @param array $useralldata - user's array of exercise data.
		 * @param int   $userfirst - user first name.
		 * @param int   $userlast - user last name.
		 */
		public function output_previous_data( $useralldata, $userfirst, $userlast, $wpuserid ) {

			$this->final_complete_output = '';

			// Now make access check to see if user can access this part of WPHealthTRacker - get the users permissions
			// Make call to Transients class to see if Transient currently exists. If so, retrieve it, if not, make call to create_transient() with all required Parameters.
			global $wpdb;
			$currentwpuser    = wp_get_current_user();
			$users_table_name = $wpdb->prefix . 'wphealthtracker_users';
			require_once WPHEALTHTRACKER_CLASSES_TRANSIENTS_DIR . 'class-wphealthtracker-transients.php';
			$transients       = new WPHealthTracker_Transients();
			$transient_name   = 'wpht_' . md5( 'SELECT * FROM ' . $users_table_name . ' WHERE wpuserid == ' . $currentwpuser->ID );
			$transient_exists = $transients->existing_transient_check( $transient_name );
			if ( $transient_exists ) {
				$this->user_data = $transient_exists;
			} else {
				$query           = 'SELECT * FROM ' . $users_table_name . '  WHERE wpuserid = ' . $currentwpuser->ID;
				$this->user_data = $transients->create_transient( $transient_name, 'wpdb->get_row', $query, MONTH_IN_SECONDS );
			}

			// Now get the user's permissions.
			$user_perm = explode( ',', $this->user_data->permissions );

			// If the currently logged-in WordPress user is trying to access his own data, proceed, otherwise, check and see if this WordPress userhas the permissions to view or edit other's data.
			$proceed_flag = false;
			if ( $currentwpuser->ID === (int) $wpuserid || ( '1' === $user_perm[14] && '1' === $user_perm[17] ) ) {
				$proceed_flag = 'viewandedit';
			} elseif ( '1' === $user_perm[14] && '0' === $user_perm[17] ) {
				$proceed_flag = 'viewonly';
			} else {
				$proceed_flag = 'noaccess';
			}

			// The loop that will build each individual day's final full html entry.
			foreach ( $useralldata as $key => $indiv_day ) {

				// Set class variables with data retrieved from the calling function.
				$this->firstname   = $indiv_day->firstname;
				$this->lastname    = $indiv_day->lastname;
				$this->wpuserid    = $indiv_day->wpuserid;
				$this->humandate   = $indiv_day->humandate;
				$this->foodstring  = $indiv_day->foodstring;
				$this->imgdieturl  = $indiv_day->dietimg;
				$this->filedieturl = $indiv_day->dietfiles;

				// Increment the $key variable by one to not conflict with the data in the 'Enter' section.
				$key++;

				if ( 'noaccess' !== $proceed_flag ) {

					// Output the individual data items.
					$piece_one = $this->output_diet_enter_config_food_item( $key, 'previous' );

					// Get the HTML that will wrap each day's data, providing the div that the user will click on to expand and view that day's data.
					$piece_wrapper_html_open  = $this->output_diet_enter_config_all_data_wrapper_html_open( $key, 'previous' );
					$piece_wrapper_html_close = $this->output_diet_enter_config_all_data_wrapper_html_close( $key );

					if ( 'viewandedit' === $proceed_flag ) {
						$end_piece = $this->output_diet_ending( 'previous', $key );
					} else {
						$end_piece = '<div style="margin-top:-25px;"></div>';
					}

					$this->final_complete_output = $this->final_complete_output . $piece_wrapper_html_open . $piece_one . $end_piece . $piece_wrapper_html_close;

				} else {

					// Output the No Acess message.
					require_once WPHEALTHTRACKER_CLASSES_UTILITIES_DIR . 'class-wphealthtracker-utilities-accesscheck.php';
					$this->access                = new WPHealthTracker_Utilities_Accesscheck();
					$this->final_complete_output = $this->access->wphealthtracker_accesscheck_no_permission_message();

				}
			}

			// If $this->final_complete_output != '', indicating that previously-saved data WAS found for this user, add the data 'Filter' HTML.
			if ( '' !== $this->final_complete_output ) {
				$data_filter_html            = $this->output_data_filter_html();
				$this->final_complete_output = $data_filter_html . $this->final_complete_output;
			}

			// If $this->final_complete_output === '', indicating that previously-saved data WAS NOT found for this user, output the 'No Data Found' message.
			if ( '' === $this->final_complete_output ) {
				$no_data_html                = $this->output_no_data_html( $userfirst, $userlast );
				$this->final_complete_output = $no_data_html . $this->final_complete_output;
			}

		}
	}

endif;

