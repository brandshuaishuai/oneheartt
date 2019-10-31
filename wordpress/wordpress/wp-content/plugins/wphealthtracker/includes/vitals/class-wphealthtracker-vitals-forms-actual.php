<?php
/**
 * Class WPHEALTHTRACKER_Vitals_Forms_Actual - wphealthtracker-vitals-forms-actual.php
 *
 * @author   Jake Evans
 * @category Admin
 * @package  Includes/Vitals
 * @version  0.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPHEALTHTRACKER_Vitals_Forms_Actual', false ) ) :

	/**
	 * WPHEALTHTRACKER_Exercise_Vitals_Actual class. This class holds all of the forms that will be used for entering and Viewing Vitals data on the Vitals Tracker tab.
	 */
	class WPHEALTHTRACKER_Vitals_Forms_Actual {

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
		 *  @var string $weight
		 */
		public $weight = '';

		/** Common member variable
		 *
		 *  @var string $bloodpressure
		 */
		public $bloodpressure = '';

		/** Common member variable
		 *
		 *  @var string $bloodoxygen
		 */
		public $bloodoxygen = '';

		/** Common member variable
		 *
		 *  @var string $bodytemp
		 */
		public $bodytemp = '';

		/** Common member variable
		 *
		 *  @var string $cholesterol
		 */
		public $cholesterol = '';

		/** Common member variable
		 *
		 *  @var string $heartrate
		 */
		public $heartrate = '';

		/** Common member variable
		 *
		 *  @var string $bloodsugar
		 */
		public $bloodsugar = '';

		/** Common member variable
		 *
		 *  @var string $imgvitalsurl
		 */
		public $imgvitalsurl = '';

		/** Common member variable
		 *
		 *  @var string $filevitalsurl
		 */
		public $filevitalsurl = '';

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
			$this->translations->vitals_tab_trans_strings();
			$this->translations->common_trans_strings();

			// Set the date.
			require_once WPHEALTHTRACKER_CLASSES_UTILITIES_DIR . 'class-wphealthtracker-utilities-date.php';
			$utilities_date = new WPHealthTracker_Utilities_Date();
			$this->date     = $utilities_date->wphealthtracker_get_date_via_current_time( 'mysql' );
		}

		/**
		 * Handle the splitting up of the weight number and the measurement used.
		 *
		 * @param int $loop_num - tracks which day we're on.
		 */
		private function output_vitals_enter_config_weight( $loop_num ) {
			// For unit testing, feed into the function the loop_num of zero, and set $this->weight to '', 'somenumericalvalue;Pounds', and 'somenumericalvalue;Kilograms'.
			$key = 0;

			$weight_num  = '';
			$measurement = '';
			if ( '' !== $this->weight && null !== $this->weight ) {

				$temp        = explode( ';', $this->weight );
				$weight_num  = $temp[0];
				$measurement = $temp[1];
			}

			// Build the Options for the Select.
			if ( $measurement === $this->translations->vitals_trans_12 ) {
				$option_string =
				'<option selected>' . $this->translations->vitals_trans_2 . '</option>
				 <option>' . $this->translations->vitals_trans_3 . '</option>';
			} elseif ( $measurement === $this->translations->vitals_trans_13 ) {
				$option_string =
				'<option>' . $this->translations->vitals_trans_2 . '</option>
				 <option  selected>' . $this->translations->vitals_trans_3 . '</option>';
			} else {
				$option_string =
				'<option>' . $this->translations->vitals_trans_2 . '</option>
				 <option>' . $this->translations->vitals_trans_3 . '</option>';
			}

			return '<div class="wphealthtracker-response-form-entry-row">
					<h2 class="wphealthtracker-response-form-heading-black">
					<img id="wphealthtracker-icon-image-question-id-2" class="wphealthtracker-icon-image-question-enter-view" data-label="vitals-weight" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg" />
					' . $this->translations->vitals_trans_1 . '<img class="wphealthtracker-icon-h2-image"  src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'scale.svg" /></h2>
					<div class="wphealthtracker-response-form-data-row-weight" id="wphealthtracker-response-form-weight-row-div-' . $key . '-' . $loop_num . '">
						<div class="wphealthtracker-response-form-div-row">
							<p>' . $this->translations->vitals_trans_1 . '</p>
							<input class="wphealthtracker-response-form-input" id="wphealthtracker-response-form-input-number-weight" type="number" value="' . $weight_num . '"></input>
						</div>
						<div class="wphealthtracker-response-form-div-row">
							<p>' . $this->translations->common_trans_23 . '</p>
							<select class="wphealthtracker-response-form-select" id="wphealthtracker-response-form-select-weight">
								' . $option_string . '
							</select>
						</div>
					</div>
				</div>';
		}

		/**
		 * Handle the splitting up of the cholesterol numbers.
		 *
		 * @param int $loop_num - tracks which day we're on.
		 */
		private function output_vitals_enter_config_cholesterol( $loop_num ) {
			// For unit testing, feed into the function the loop_num of zero, and set $this->cholesterol to '', and 'somenumber,somenumber,somenumber,somenumber'.
			$key = 0;

			// Handle the splitting up of the cholesterol number.
			$ldl   = '';
			$hdl   = '';
			$tri   = '';
			$total = '';

			if ( '' !== $this->cholesterol && null !== $this->cholesterol ) {
				$ch_array = explode( ',', $this->cholesterol );
				$ldl      = $ch_array[0];
				$hdl      = $ch_array[1];
				$tri      = $ch_array[2];
				$total    = $ch_array[3];
			}

			return '<div class="wphealthtracker-response-form-entry-row">
					<div class="wphealthtracker-response-form-ch-div">
						<h2 class="wphealthtracker-response-form-heading-black"><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view" data-label="vitals-cholesterol" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg" />' . $this->translations->vitals_trans_4 . '
						<img class="wphealthtracker-icon-h2-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'heartbeat.svg" />
						</h2>
						<div class="wphealthtracker-response-form-data-row-cholesterol" id="wphealthtracker-response-form-cholesterol-row-div-' . $key . '-' . $loop_num . '">
							<div class="wphealthtracker-response-form-div-row">
								<p>' . $this->translations->vitals_trans_5 . '</p>
								<input type="number" class="wphealthtracker-response-form-input-number" id="wphealthtracker-response-form-input-number-ldl-' . $loop_num . '" value="' . $ldl . '"></input>
							</div>
							<div class="wphealthtracker-response-form-div-row">
								<p>' . $this->translations->vitals_trans_6 . '</p>
								<input type="number" class="wphealthtracker-response-form-input-number" id="wphealthtracker-response-form-input-number-hdl-' . $loop_num . '" value="' . $hdl . '"></input>
							</div>
							<div class="wphealthtracker-response-form-div-row">
								<p>' . $this->translations->vitals_trans_7 . '</p>
								<input type="number" class="wphealthtracker-response-form-input-number" id="wphealthtracker-response-form-input-number-tri-' . $loop_num . '" value="' . $tri . '"></input>
							</div>
							<div class="wphealthtracker-response-form-div-row">
								<p>' . $this->translations->common_trans_24 . '</p>
								<input type="number" class="wphealthtracker-response-form-input-number" id="wphealthtracker-response-form-input-number-tot-' . $loop_num . '" value="' . $total . '"></input>
							</div>
						</div>
					</div>
				</div>';
		}

		/**
		 * Handle the splitting up of the blood pressure numbers and times recorded.
		 *
		 * @param int $loop_num - tracks which day we're on.
		 */
		private function output_vitals_enter_config_blood_pressure( $loop_num ) {

			// For unit testing, feed into the function the loop_num of zero, and set $this->bloodpressure to '', 'somenumber/somenumber/some:time', and 'somenumber/somenumber/some:time,somenumber/somenumber/some:time'.
			$key = 0;

			$final_bp_string = '<div class="wphealthtracker-response-form-entry-row">
					<h2 class="wphealthtracker-response-form-heading-black"><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view" data-label="vitals-bp" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg" />' . $this->translations->vitals_trans_8 . '
					<img class="wphealthtracker-icon-h2-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'pressure.svg" /></h2>';

			// If there is indeed Blood Pressure data saved at all.
			if ( '' !== $this->bloodpressure ) {
				// If there are multiple blood pressure entries on the same date...
				if ( strpos( $this->bloodpressure, ',' ) !== false ) {
					$bparray = explode( ',', $this->bloodpressure );
					foreach ( $bparray as $key => $value ) {

						$sys  = 0;
						$dis  = 0;
						$time = '0:00';

						$bpsplit = explode( '/', $value );

						if ( count( $bpsplit ) > 0 ) {
							$sys = $bpsplit[0];
						}

						if ( count( $bpsplit ) > 1 ) {
							$dis = $bpsplit[1];
						}

						if ( count( $bpsplit ) > 2 ) {
							$time = $bpsplit[2];
						}

						// Handle the switching from input="time" to input="text" for cross-browser/safari support.
						if ( strlen( $time ) !== 5 && substr( $time, -3, 1 ) !== ':' ) {
							$time_input = 'type="text"';
						} else {
							$time_input = 'type="time"';
						}

						// If we're not on the first iteration of this loop, include the row removal html.
						$removal_string = '';
						if ( $key > 0 ) {
							$removal_string = '<div class="wphealthtracker-response-form-row-removal-div" data-id-to-remove="wphealthtracker-response-form-bp-row-div-' . $key . '-' . $loop_num . '">
									<p>' . $this->translations->common_trans_41 . '</p><img class="wphealthtracker-response-form-row-removal-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'garbage.svg" />
								</div>';
						}

						$final_bp_string = $final_bp_string . '<div class="wphealthtracker-response-form-data-row-bp" id="wphealthtracker-response-form-bp-row-div-' . $key . '-' . $loop_num . '">
							<div class="wphealthtracker-response-form-div-row">
								<p>' . $this->translations->vitals_trans_9 . '</p>
								<input type="number" class="wphealthtracker-response-form-input-number" id="wphealthtracker-response-form-input-number-bp-sys-' . $key . '-' . $loop_num . '" value="' . $sys . '"></input>
							</div>
							<div class="wphealthtracker-response-form-div-row">
								<p>' . $this->translations->vitals_trans_10 . '</p>
								<input type="number" class="wphealthtracker-response-form-input-number" id="wphealthtracker-response-form-input-number-bp-dis-' . $key . '-' . $loop_num . '" value="' . $dis . '"></input>
							</div>
							<div class="wphealthtracker-response-form-div-row">
								<p>' . $this->translations->common_trans_25 . '</p>
								<input ' . $time_input . ' class="wphealthtracker-response-form-input-time wphealthtracker-response-form-input-time-bp" id="wphealthtracker-response-form-input-time-bp-' . $key . '-' . $loop_num . '" value="' . $time . '"></input>
								' . $removal_string . '
							</div>
						</div>';
					}
				} else {
					$sys  = 0;
					$dis  = 0;
					$time = '0:00';

					$bpsplit = explode( '/', $this->bloodpressure );

					if ( count( $bpsplit ) > 0 ) {
						$sys = $bpsplit[0];
					}

					if ( count( $bpsplit ) > 1 ) {
						$dis = $bpsplit[1];
					}

					if ( count( $bpsplit ) > 2 ) {
						$time = $bpsplit[2];
					}

					// Handle the switching from input="time" to input="text" for cross-browser/safari support.
					if ( strlen( $time ) !== 5 && substr( $time, -3, 1 ) !== ':' ) {
						$time_input = 'type="text"';
					} else {
						$time_input = 'type="time"';
					}

					$final_bp_string = $final_bp_string . '<div class="wphealthtracker-response-form-data-row-bp" id="wphealthtracker-response-form-bp-row-div-' . $key . '-' . $loop_num . '">
							<div class="wphealthtracker-response-form-div-row">
								<p>' . $this->translations->vitals_trans_9 . '</p>
								<input type="number" class="wphealthtracker-response-form-input-number" id="wphealthtracker-response-form-input-number-bp-sys-' . $key . '-' . $loop_num . '" value="' . $sys . '"></input>
							</div>
							<div class="wphealthtracker-response-form-div-row">
								<p>' . $this->translations->vitals_trans_10 . '</p>
								<input type="number" class="wphealthtracker-response-form-input-number" id="wphealthtracker-response-form-input-number-bp-dis-' . $key . '-' . $loop_num . '" value="' . $dis . '"></input>
							</div>
							<div class="wphealthtracker-response-form-div-row">
								<p>' . $this->translations->common_trans_25 . '</p>
								<input ' . $time_input . ' class="wphealthtracker-response-form-input-time wphealthtracker-response-form-input-time-bp" id="wphealthtracker-response-form-input-time-bp-' . $key . '-' . $loop_num . '" value="' . $time . '"></input>
							</div>
						</div>';
				}
			} else {
				// If there is no Blood Pressure Data Saved at all...
				$final_bp_string = $final_bp_string . '<div class="wphealthtracker-response-form-data-row-bp" id="wphealthtracker-response-form-bp-row-div-' . $key . '-' . $loop_num . '">
						<div class="wphealthtracker-response-form-div-row">
							<p>' . $this->translations->vitals_trans_9 . '</p>
							<input type="number" class="wphealthtracker-response-form-input-number" id="wphealthtracker-response-form-input-number-bp-sys-' . $key . '-' . $loop_num . '"></input>
						</div>
						<div class="wphealthtracker-response-form-div-row">
							<p>' . $this->translations->vitals_trans_10 . '</p>
							<input type="number" class="wphealthtracker-response-form-input-number" id="wphealthtracker-response-form-input-number-bp-dis-' . $key . '-' . $loop_num . '"></input>
						</div>
						<div class="wphealthtracker-response-form-div-row">
							<p>' . $this->translations->common_trans_25 . '</p>
							<input type="time" class="wphealthtracker-response-form-input-time wphealthtracker-response-form-input-time-bp" id="wphealthtracker-response-form-input-time-bp-' . $key . '-' . $loop_num . '" ></input>
						</div>
					</div>';
			}

			return $final_bp_string = $final_bp_string . '<div class="wphealthtracker-response-form-row-addition-div" data-key="' . $key . '" data-loopnum="' . $loop_num . '" data-id-to-add-after="wphealthtracker-response-form-bp-row-div-' . $key . '-' . $loop_num . '">
						<p>' . $this->translations->common_trans_42 . '</p><img class="wphealthtracker-response-form-row-add-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'web-site.svg" />
					</div>
				</div>';

		}

		/**
		 * Handle the splitting up of the blood pressure numbers and times recorded.
		 *
		 * @param int $loop_num - tracks which day we're on.
		 */
		private function output_vitals_enter_config_blood_sugar( $loop_num ) {

			// For unit testing, feed into the function the loop_num of zero, and set $this->bloodsugar to '', 'somenumber-mmol/L-some:time', 'somenumber-mg/dl-some:time', 'somenumber-mmol/L-some:time,somenumber-mmol/L-some:time' and 'somenumber-mg/dl-some:time,somenumber-mg/dl-some:time'.
			$key = 0;

			$final_bs_string = '<div class="wphealthtracker-response-form-entry-row">
					<h2 class="wphealthtracker-response-form-heading-black"><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view" data-label="vitals-bs" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg" />' . $this->translations->vitals_trans_11 . '
					<img class="wphealthtracker-icon-h2-image" data-label="vitals-weight" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'injury.svg" /></h2>';

			// If there is indeed Blood sugar data saved at all.
			if ( '' !== $this->bloodsugar ) {
				// If there are multiple blood oxygen entries on the same date...
				if ( strpos( $this->bloodsugar, ',' ) !== false ) {
					$bsarray = explode( ',', $this->bloodsugar );

					foreach ( $bsarray as $key => $value ) {

						$temp_num         = 0;
						$temp_measurement = 0;
						$time             = '0:00';

						$bssplit = explode( '-', $value );

						if ( count( $bssplit ) > 0 ) {
							$temp_num = $bssplit[0];
						}

						if ( count( $bssplit ) > 1 ) {
							$temp_measurement = $bssplit[1];
						}

						if ( count( $bssplit ) > 2 ) {
							$time = $bssplit[2];
						}

						// Handle the switching from input="time" to input="text" for cross-browser/safari support.
						if ( strlen( $time ) !== 5 && substr( $time, -3, 1 ) !== ':' ) {
							$time_input = 'type="text"';
						} else {
							$time_input = 'type="time"';
						}

						// Build the Options for the Select.
						if ( $temp_measurement === $this->translations->vitals_trans_13 ) {
							$option_string =
							'<option selected>' . $this->translations->vitals_trans_13 . '</option>
							 <option>' . $this->translations->vitals_trans_14 . '</option>';
						} elseif ( $temp_measurement === $this->translations->vitals_trans_14 ) {
							$option_string =
							'<option>' . $this->translations->vitals_trans_13 . '</option>
							 <option  selected>' . $this->translations->vitals_trans_14 . '</option>';
						} else {
							$option_string =
							'<option>' . $this->translations->vitals_trans_13 . '</option>
							 <option>' . $this->translations->vitals_trans_14 . '</option>';
						}

						// If we're not on the first iteration of this loop, include the row removal html.
						$removal_string = '';
						if ( $key > 0 ) {
							$removal_string = '<div class="wphealthtracker-response-form-row-removal-div" data-id-to-remove="wphealthtracker-response-form-bs-row-div-' . $key . '-' . $loop_num . '">
									<p>' . $this->translations->common_trans_41 . '</p><img class="wphealthtracker-response-form-row-removal-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'garbage.svg" />
								</div>';
						}

						$final_bs_string = $final_bs_string . '<div class="wphealthtracker-response-form-data-row-bs" id="wphealthtracker-response-form-bs-row-div-' . $key . '-' . $loop_num . '">
						<div class="wphealthtracker-response-form-div-row">
							<p>' . $this->translations->vitals_trans_12 . '</p>
							<input type="number" step="0.1" class="wphealthtracker-response-form-input-number" id="wphealthtracker-response-form-input-number-bs-' . $key . '-' . $loop_num . '" value="' . $temp_num . '"></input>
						</div>
						<div class="wphealthtracker-response-form-div-row">
							<p>' . $this->translations->common_trans_23 . '</p>
							<select class="wphealthtracker-response-form-select" id="wphealthtracker-response-form-select-bs-' . $key . '-' . $loop_num . '">">
								' . $option_string . '
							</select>
						</div>
						<div class="wphealthtracker-response-form-div-row">
							<p>' . $this->translations->common_trans_25 . '</p>
							<input ' . $time_input . ' class="wphealthtracker-response-form-input-time" id="wphealthtracker-response-form-input-time-bs-' . $key . '-' . $loop_num . '" value="' . $time . '"></input>
							' . $removal_string . '
						</div>
					</div>';

					}
				} else {

					$temp_num         = 0;
					$temp_measurement = 0;
					$time             = '0:00';

					$bssplit = explode( '-', $this->bloodsugar );

					if ( count( $bssplit ) > 0 ) {
						$temp_num = $bssplit[0];
					}

					if ( count( $bssplit ) > 1 ) {
						$temp_measurement = $bssplit[1];
					}

					if ( count( $bssplit ) > 2 ) {
						$time = $bssplit[2];
					}

					// Handle the switching from input="time" to input="text" for cross-browser/safari support.
					if ( strlen( $time ) !== 5 && substr( $time, -3, 1 ) !== ':' ) {
						$time_input = 'type="text"';
					} else {
						$time_input = 'type="time"';
					}

					// Build the Options for the Select.
					if ( $temp_measurement === $this->translations->vitals_trans_13 ) {
						$option_string =
						'<option selected>' . $this->translations->vitals_trans_13 . '</option>
						 <option>' . $this->translations->vitals_trans_14 . '</option>';
					} elseif ( $temp_measurement === $this->translations->vitals_trans_14 ) {
						$option_string =
						'<option>' . $this->translations->vitals_trans_13 . '</option>
						 <option  selected>' . $this->translations->vitals_trans_14 . '</option>';
					} else {
						$option_string =
						'<option>' . $this->translations->vitals_trans_13 . '</option>
						 <option>' . $this->translations->vitals_trans_14 . '</option>';
					}

					$final_bs_string = $final_bs_string . '<div class="wphealthtracker-response-form-data-row-bs" id="wphealthtracker-response-form-bs-row-div-' . $key . '-' . $loop_num . '">
						<div class="wphealthtracker-response-form-div-row">
							<p>' . $this->translations->vitals_trans_12 . '</p>
							<input type="number" step="0.1" class="wphealthtracker-response-form-input-number" id="wphealthtracker-response-form-input-number-bs-' . $key . '-' . $loop_num . '" value="' . $temp_num . '"></input>
						</div>
						<div class="wphealthtracker-response-form-div-row">
							<p>' . $this->translations->common_trans_23 . '</p>
							<select class="wphealthtracker-response-form-select" id="wphealthtracker-response-form-select-bs-' . $key . '-' . $loop_num . '">">
								' . $option_string . '
							</select>
						</div>
						<div class="wphealthtracker-response-form-div-row">
							<p>' . $this->translations->common_trans_25 . '</p>
							<input ' . $time_input . ' class="wphealthtracker-response-form-input-time" id="wphealthtracker-response-form-input-time-bs-' . $key . '-' . $loop_num . '" value="' . $time . '"></input>
						</div>
					</div>';
				}
			} else {
				// If there is no Blood Sugar Data Saved at all...
				$final_bs_string = $final_bs_string . '<div class="wphealthtracker-response-form-data-row-bs" id="wphealthtracker-response-form-bs-row-div-' . $key . '-' . $loop_num . '">
						<div class="wphealthtracker-response-form-div-row">
							<p>' . $this->translations->vitals_trans_12 . '</p>
							<input type="number" step="0.1" class="wphealthtracker-response-form-input-number" id="wphealthtracker-response-form-input-number-bs-' . $key . '-' . $loop_num . '"></input>
						</div>
						<div class="wphealthtracker-response-form-div-row">
							<p>' . $this->translations->common_trans_23 . '</p>
							<select class="wphealthtracker-response-form-select" id="wphealthtracker-response-form-select-bs-' . $key . '-' . $loop_num . '">">
								<option>' . $this->translations->vitals_trans_13 . '</option>
						 		<option>' . $this->translations->vitals_trans_14 . '</option>
							</select>
						</div>
						<div class="wphealthtracker-response-form-div-row">
							<p>' . $this->translations->common_trans_25 . '</p>
							<input type="time" class="wphealthtracker-response-form-input-time" id="wphealthtracker-response-form-input-time-bs-' . $key . '-' . $loop_num . '"></input>
						</div>
					</div>';
			}

			return $final_bs_string = $final_bs_string . '<div class="wphealthtracker-response-form-row-addition-div" data-key="' . $key . '" data-loopnum="' . $loop_num . '" data-id-to-add-after="wphealthtracker-response-form-bs-row-div-' . $key . '-' . $loop_num . '">
						<p>' . $this->translations->common_trans_42 . '</p><img class="wphealthtracker-response-form-row-add-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'web-site.svg" />
					</div>
				</div>';
		}

		/**
		 * Handle the splitting up of the blood oxygen numbers and times recorded.
		 *
		 * @param int $loop_num - tracks which day we're on.
		 */
		private function output_vitals_enter_config_blood_oxygen( $loop_num ) {

			// For unit testing, feed into the function the loop_num of zero, and set $this->bloodoxygen to '', 'somenumber/mm HG/some:time', 'somenumber/Percent/some:time', 'somenumber/mm HG/some:time,somenumber/mm HG/some:time' and 'somenumber/Percent/some:time,somenumber/Percent/some:time'.
			$key = 0;

			$final_bo_string = '<div class="wphealthtracker-response-form-entry-row">
							<h2 class="wphealthtracker-response-form-heading-black"><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view" data-label="vitals-bo" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg" />' . $this->translations->vitals_trans_15 . '<img class="wphealthtracker-icon-h2-image" data-label="vitals-weight" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'oxygen.svg" /></h2>';

			// If there is indeed Blood oxygen data saved at all.
			if ( '' !== $this->bloodoxygen ) {
				// If there are multiple blood oxygen entries on the same date...
				if ( strpos( $this->bloodoxygen, ',' ) !== false ) {
					$boarray = explode( ',', $this->bloodoxygen );

					foreach ( $boarray as $key => $value ) {

						$ox_level       = 0;
						$ox_measurement = 0;
						$time           = '0:00';

						$bosplit = explode( '/', $value );

						if ( count( $bosplit ) > 0 ) {
							$ox_level = $bosplit[0];
						}

						if ( count( $bosplit ) > 1 ) {
							$ox_measurement = $bosplit[1];
						}

						if ( count( $bosplit ) > 2 ) {
							$time = $bosplit[2];
						}

						// Handle the switching from input="time" to input="text" for cross-browser/safari support.
						if ( strlen( $time ) !== 5 && substr( $time, -3, 1 ) !== ':' ) {
							$time_input = 'type="text"';
						} else {
							$time_input = 'type="time"';
						}

						// Build the Options for the Select.
						if ( $ox_measurement === $this->translations->common_trans_26 ) {
							$option_string =
							'<option selected>' . $this->translations->common_trans_26 . '</option>
							 <option>' . $this->translations->vitals_trans_17 . '</option>';
						} elseif ( $ox_measurement === $this->translations->vitals_trans_17 ) {
							$option_string =
							'<option>' . $this->translations->common_trans_26 . '</option>
							 <option selected>' . $this->translations->vitals_trans_17 . '</option>';
						} else {
							$option_string =
							'<option>' . $this->translations->common_trans_26 . '</option>
							 <option>' . $this->translations->vitals_trans_17 . '</option>';
						}

						// If we're not on the first iteration of this loop, include the row removal html.
						$removal_string = '';
						if ( $key > 0 ) {
							$removal_string = '<div class="wphealthtracker-response-form-row-removal-div" data-id-to-remove="wphealthtracker-response-form-bo-row-div-' . $key . '-' . $loop_num . '">
									<p>' . $this->translations->common_trans_41 . '</p><img class="wphealthtracker-response-form-row-removal-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'garbage.svg" />
								</div>';
						}

						$final_bo_string = $final_bo_string . '
								<div class="wphealthtracker-response-form-data-row-bo" id="wphealthtracker-response-form-bo-row-div-' . $key . '-' . $loop_num . '">
									<div class="wphealthtracker-response-form-div-row">
										<p>' . $this->translations->vitals_trans_16 . '</p>
										<input type="number" class="wphealthtracker-response-form-input-number" id="wphealthtracker-response-form-input-number-bo-' . $key . '-' . $loop_num . '" value="' . $ox_level . '"></input>
									</div>
									<div class="wphealthtracker-response-form-div-row">
										<p>' . $this->translations->common_trans_23 . '</p>
										<select class="wphealthtracker-response-form-select wphealthtracker-response-form-select-bo" id="wphealthtracker-response-form-select-bo-' . $key . '-' . $loop_num . '">
											' . $option_string . '
										</select>
									</div>
									<div class="wphealthtracker-response-form-div-row">
										<p>' . $this->translations->common_trans_25 . '</p>
										<input ' . $time_input . ' class="wphealthtracker-response-form-input-time" id="wphealthtracker-response-form-input-time-bo-' . $key . '-' . $loop_num . '" value="' . $time . '"></input>
										' . $removal_string . '
									</div>
								</div>';
					}
				} else {
					$ox_level       = 0;
					$ox_measurement = 0;
					$time           = '0:00';

					$bosplit = explode( '/', $this->bloodoxygen );

					if ( count( $bosplit ) > 0 ) {
						$ox_level = $bosplit[0];
					}

					if ( count( $bosplit ) > 1 ) {
						$ox_measurement = $bosplit[1];
					}

					if ( count( $bosplit ) > 2 ) {
						$time = $bosplit[2];
					}

					// Handle the switching from input="time" to input="text" for cross-browser/safari support.
					if ( strlen( $time ) !== 5 && substr( $time, -3, 1 ) !== ':' ) {
						$time_input = 'type="text"';
					} else {
						$time_input = 'type="time"';
					}

					// Build the Options for the Select.
					if ( $ox_measurement === $this->translations->common_trans_26 ) {
						$option_string =
						'<option selected>' . $this->translations->common_trans_26 . '</option>
						 <option>' . $this->translations->vitals_trans_17 . '</option>';
					} elseif ( $ox_measurement === $this->translations->vitals_trans_17 ) {
						$option_string =
						'<option>' . $this->translations->common_trans_26 . '</option>
						 <option selected>' . $this->translations->vitals_trans_17 . '</option>';
					} else {
						$option_string =
						'<option>' . $this->translations->common_trans_26 . '</option>
						 <option>' . $this->translations->vitals_trans_17 . '</option>';
					}

					$final_bo_string = $final_bo_string . '
							<div class="wphealthtracker-response-form-data-row-bo" id="wphealthtracker-response-form-bo-row-div-' . $key . '-' . $loop_num . '">
								<div class="wphealthtracker-response-form-div-row">
									<p>' . $this->translations->vitals_trans_16 . '</p>
									<input type="number" class="wphealthtracker-response-form-input-number" id="wphealthtracker-response-form-input-number-bo-' . $key . '-' . $loop_num . '" value="' . $ox_level . '"></input>
								</div>
								<div class="wphealthtracker-response-form-div-row">
									<p>' . $this->translations->common_trans_23 . '</p>
									<select class="wphealthtracker-response-form-select wphealthtracker-response-form-select-bo" id="wphealthtracker-response-form-select-bo-' . $key . '-' . $loop_num . '">
										' . $option_string . '
									</select>
								</div>
								<div class="wphealthtracker-response-form-div-row">
									<p>' . $this->translations->common_trans_25 . '</p>
									<input ' . $time_input . ' class="wphealthtracker-response-form-input-time" id="wphealthtracker-response-form-input-time-bo-' . $key . '-' . $loop_num . '" value="' . $time . '"></input>
								</div>
							</div>';
				}
			} else {
				// If there is no Blood Oxygen Data Saved at all...
				$final_bo_string = $final_bo_string . '
							<div class="wphealthtracker-response-form-data-row-bo" id="wphealthtracker-response-form-bo-row-div-' . $key . '-' . $loop_num . '">
								<div class="wphealthtracker-response-form-div-row">
									<p>' . $this->translations->vitals_trans_16 . '</p>
									<input type="number" class="wphealthtracker-response-form-input-number" id="wphealthtracker-response-form-input-number-bo-' . $key . '-' . $loop_num . '"></input>
								</div>
								<div class="wphealthtracker-response-form-div-row">
									<p>' . $this->translations->common_trans_23 . '</p>
									<select class="wphealthtracker-response-form-select wphealthtracker-response-form-select-bo" id="wphealthtracker-response-form-select-bo-' . $key . '-' . $loop_num . '">
										<option>' . $this->translations->common_trans_26 . '</option>
						 				<option>' . $this->translations->vitals_trans_17 . '</option>
									</select>
								</div>
								<div class="wphealthtracker-response-form-div-row">
									<p>' . $this->translations->common_trans_25 . '</p>
									<input type="time" class="wphealthtracker-response-form-input-time" id="wphealthtracker-response-form-input-time-bo-' . $key . '-' . $loop_num . '"></input>
								</div>
							</div>';

			}

			return $final_bo_string = $final_bo_string . '<div class="wphealthtracker-response-form-row-addition-div" data-key="' . $key . '" data-loopnum="' . $loop_num . '" data-id-to-add-after="wphealthtracker-response-form-bo-row-div-' . $key . '-' . $loop_num . '">
						<p>' . $this->translations->common_trans_42 . '</p><img class="wphealthtracker-response-form-row-add-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'web-site.svg" />
					</div>
				</div>';
		}

		/**
		 * Handle the splitting up of the body numbers and times recorded.
		 *
		 * @param int $loop_num - tracks which day we're on.
		 */
		private function output_vitals_enter_config_body_temp( $loop_num ) {

			// For unit testing, feed into the function the loop_num of zero, and set $this->bloodoxygen to '', 'somenumber/Celcius/some:time', 'somenumber/Fahrenheit/some:time', 'somenumber/Celcius/some:time,somenumber/Celcius/some:time' and 'somenumber/Fahrenheit/some:time,somenumber/Fahrenheit/some:time'.
			$key = 0;

			$final_bt_string = '<div class="wphealthtracker-response-form-entry-row">
					<h2 class="wphealthtracker-response-form-heading-black"><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view" data-label="vitals-bt" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg" />' . $this->translations->vitals_trans_18 . '<img class="wphealthtracker-icon-h2-image" data-label="vitals-weight" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'thermometer.svg" /></h2>';

			// If there is indeed Blood oxygen.
			if ( '' !== $this->bloodoxygen ) {
				// If there are multiple blood oxygen entries on the same date...
				if ( strpos( $this->bodytemp, ',' ) !== false ) {
					$btarray = explode( ',', $this->bodytemp );

					foreach ( $btarray as $key => $value ) {

						$temp_num         = 0;
						$temp_measurement = 0;
						$time             = '0:00';

						$btsplit = explode( '/', $value );

						if ( count( $btsplit ) > 0 ) {
							$temp_num = $btsplit[0];
						}

						if ( count( $btsplit ) > 1 ) {
							$temp_measurement = $btsplit[1];
						}

						if ( count( $btsplit ) > 2 ) {
							$time = $btsplit[2];
						}

						// Handle the switching from input="time" to input="text" for cross-browser/safari support.
						if ( strlen( $time ) !== 5 && substr( $time, -3, 1 ) !== ':' ) {
							$time_input = 'type="text"';
						} else {
							$time_input = 'type="time"';
						}

						// Build the Options for the Select.
						if ( $temp_measurement === $this->translations->vitals_trans_20 ) {
							$option_string =
							'<option selected>' . $this->translations->vitals_trans_20 . '</option>
							 <option>' . $this->translations->vitals_trans_21 . '</option>';
						} elseif ( $temp_measurement === $this->translations->vitals_trans_21 ) {
							$option_string =
							'<option>' . $this->translations->vitals_trans_20 . '</option>
							 <option selected>' . $this->translations->vitals_trans_21 . '</option>';
						} else {
							$option_string =
							'<option>' . $this->translations->vitals_trans_20 . '</option>
							 <option>' . $this->translations->vitals_trans_21 . '</option>';
						}

						// If we're not on the first iteration of this loop, include the row removal html.
						$removal_string = '';
						if ( $key > 0 ) {
							$removal_string = '<div class="wphealthtracker-response-form-row-removal-div" data-id-to-remove="wphealthtracker-response-form-bt-row-div-' . $key . '-' . $loop_num . '">
									<p>' . $this->translations->common_trans_41 . '</p><img class="wphealthtracker-response-form-row-removal-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'garbage.svg" />
								</div>';
						}

						$final_bt_string = $final_bt_string . '<div class="wphealthtracker-response-form-data-row-bt" id="wphealthtracker-response-form-bt-row-div-' . $key . '-' . $loop_num . '">
							<div class="wphealthtracker-response-form-div-row">
								<p>' . $this->translations->vitals_trans_19 . '</p>
								<input type="number" class="wphealthtracker-response-form-input-number" id="wphealthtracker-response-form-input-number-bt-' . $key . '-' . $loop_num . '" value="' . $temp_num . '"></input>
							</div>
							<div class="wphealthtracker-response-form-div-row">
								<p>' . $this->translations->common_trans_23 . '</p>
								<select class="wphealthtracker-response-form-select wphealthtracker-response-form-select-bo" id="wphealthtracker-response-form-select-bt-' . $key . '-' . $loop_num . '">
									' . $option_string . '
								</select>
							</div>
							<div class="wphealthtracker-response-form-div-row">
								<p>' . $this->translations->common_trans_25 . '</p>
								<input ' . $time_input . ' class="wphealthtracker-response-form-input-time" id="wphealthtracker-response-form-input-time-bt-' . $key . '-' . $loop_num . '" value="' . $time . '"></input>
								' . $removal_string . '
							</div>
						</div>';
					}
				} else {

					$temp_num         = 0;
					$temp_measurement = 0;
					$time             = '0:00';

					$btsplit = explode( '/', $this->bodytemp );

					if ( count( $btsplit ) > 0 ) {
						$temp_num = $btsplit[0];
					}

					if ( count( $btsplit ) > 1 ) {
						$temp_measurement = $btsplit[1];
					}

					if ( count( $btsplit ) > 2 ) {
						$time = $btsplit[2];
					}

					// Handle the switching from input="time" to input="text" for cross-browser/safari support.
					if ( strlen( $time ) !== 5 && substr( $time, -3, 1 ) !== ':' ) {
						$time_input = 'type="text"';
					} else {
						$time_input = 'type="time"';
					}

					// Handle the switching from input="time" to input="text" for cross-browser/safari support.
					if ( strlen( $time ) !== 5 && substr( $time, -3, 1 ) !== ':' ) {
						$time_input = 'type="text"';
					} else {
						$time_input = 'type="time"';
					}

					// Build the Options for the Select.
					if ( $temp_measurement === $this->translations->vitals_trans_20 ) {
						$option_string =
						'<option selected>' . $this->translations->vitals_trans_20 . '</option>
						 <option>' . $this->translations->vitals_trans_21 . '</option>';
					} elseif ( $temp_measurement === $this->translations->vitals_trans_21 ) {
						$option_string =
						'<option>' . $this->translations->vitals_trans_20 . '</option>
						 <option selected>' . $this->translations->vitals_trans_21 . '</option>';
					} else {
						$option_string =
						'<option>' . $this->translations->vitals_trans_20 . '</option>
						 <option>' . $this->translations->vitals_trans_21 . '</option>';
					}

					$final_bt_string = $final_bt_string . '<div class="wphealthtracker-response-form-data-row-bt" id="wphealthtracker-response-form-bt-row-div-' . $key . '-' . $loop_num . '">
						<div class="wphealthtracker-response-form-div-row">
							<p>' . $this->translations->vitals_trans_19 . '</p>
							<input type="number" class="wphealthtracker-response-form-input-number" id="wphealthtracker-response-form-input-number-bt-' . $key . '-' . $loop_num . '" value="' . $temp_num . '"></input>
						</div>
						<div class="wphealthtracker-response-form-div-row">
							<p>' . $this->translations->common_trans_23 . '</p>
							<select class="wphealthtracker-response-form-select wphealthtracker-response-form-select-bo" id="wphealthtracker-response-form-select-bt-' . $key . '-' . $loop_num . '">
								' . $option_string . '
							</select>
						</div>
						<div class="wphealthtracker-response-form-div-row">
							<p>' . $this->translations->common_trans_25 . '</p>
							<input ' . $time_input . ' class="wphealthtracker-response-form-input-time" id="wphealthtracker-response-form-input-time-bt-' . $key . '-' . $loop_num . '" value="' . $time . '"></input>
						</div>
					</div>';

				}
			} else {

				// If there is no Blood Temp Data Saved at all...
				$final_bt_string = $final_bt_string . '<div class="wphealthtracker-response-form-data-row-bt" id="wphealthtracker-response-form-bt-row-div-' . $key . '-' . $loop_num . '">
							<div class="wphealthtracker-response-form-div-row">
								<p>' . $this->translations->vitals_trans_19 . '</p>
								<input type="number" class="wphealthtracker-response-form-input-number" id="wphealthtracker-response-form-input-number-bt-' . $key . '-' . $loop_num . '"></input>
							</div>
							<div class="wphealthtracker-response-form-div-row">
								<p>' . $this->translations->common_trans_23 . '</p>
								<select class="wphealthtracker-response-form-select wphealthtracker-response-form-select-bo" id="wphealthtracker-response-form-select-bt-' . $key . '-' . $loop_num . '">
									<option>' . $this->translations->vitals_trans_20 . '</option>
							 		<option>' . $this->translations->vitals_trans_21 . '</option>
								</select>
							</div>
							<div class="wphealthtracker-response-form-div-row">
								<p>' . $this->translations->common_trans_25 . '</p>
								<input type="time" class="wphealthtracker-response-form-input-time" id="wphealthtracker-response-form-input-time-bt-' . $key . '-' . $loop_num . '"></input>
							</div>
						</div>';

			}

			return $final_bt_string = $final_bt_string . '<div class="wphealthtracker-response-form-row-addition-div" data-key="' . $key . '" data-loopnum="' . $loop_num . '" data-id-to-add-after="wphealthtracker-response-form-bt-row-div-' . $key . '-' . $loop_num . '">
						<p>' . $this->translations->common_trans_42 . '</p><img class="wphealthtracker-response-form-row-add-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'web-site.svg" />
					</div>
				</div>';

		}

		/**
		 * Handle the splitting up of the heart rate and times recorded.
		 *
		 * @param int $loop_num - tracks which day we're on.
		 */
		private function output_vitals_enter_config_heart_rate( $loop_num ) {

			// For unit testing, feed into the function the loop_num of zero, and set $this->heartrate to '', 'somenumber/some:time', 'somenumber/some:time,somenumber/some:time'.
			$key = 0;

			$final_hr_string = '<div class="wphealthtracker-response-form-entry-row">
					<h2 class="wphealthtracker-response-form-heading-black"><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view" data-label="vitals-hr" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg" />' . $this->translations->vitals_trans_22 . '<img class="wphealthtracker-icon-h2-image" data-label="vitals-weight" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'monitor.svg" /></h2>';

			// If there is indeed Heart Rate Data...
			if ( '' !== $this->heartrate ) {
				// If there are multiple heart rate entries on the same date...
				if ( strpos( $this->heartrate, ',' ) !== false ) {
					$hrarray = explode( ',', $this->heartrate );

					foreach ( $hrarray as $key => $value ) {

						$rate_num = 0;
						$time     = '0:00';

						$hrsplit = explode( '/', $value );

						if ( count( $hrsplit ) > 0 ) {
							$rate_num = $hrsplit[0];
						}

						if ( count( $hrsplit ) > 1 ) {
							$time = $hrsplit[1];
						}

						// Handle the switching from input="time" to input="text" for cross-browser/safari support.
						if ( strlen( $time ) !== 5 && substr( $time, -3, 1 ) !== ':' ) {
							$time_input = 'type="text"';
						} else {
							$time_input = 'type="time"';
						}

						// If we're not on the first iteration of this loop, include the row removal html.
						$removal_string = '';
						if ( $key > 0 ) {
							$removal_string = '<div class="wphealthtracker-response-form-row-removal-div" data-id-to-remove="wphealthtracker-response-form-bt-row-div-' . $key . '-' . $loop_num . '">
									<p>' . $this->translations->common_trans_41 . '</p><img class="wphealthtracker-response-form-row-removal-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'garbage.svg" />
								</div>';
						}

						$final_hr_string = $final_hr_string . '<div class="wphealthtracker-response-form-data-row-hr" id="wphealthtracker-response-form-hr-row-div-' . $key . '-' . $loop_num . '">
							<div class="wphealthtracker-response-form-div-row">
								<p>' . $this->translations->vitals_trans_23 . '</p>
								<input type="number" class="wphealthtracker-response-form-input-number" id="wphealthtracker-response-form-input-number-hr-' . $key . '-' . $loop_num . '" value="' . $rate_num . '"></input>
							</div>
							<div class="wphealthtracker-response-form-div-row">
								<p>' . $this->translations->common_trans_25 . '</p>
								<input ' . $time_input . ' class="wphealthtracker-response-form-input-time wphealthtracker-response-form-input-time-hr" id="wphealthtracker-response-form-input-time-hr-' . $key . '-' . $loop_num . '" value="' . $time . '"></input>
							' . $removal_string . '
						</div>
					</div>';

					}
				} else {

					$rate_num = 0;
					$time     = '0:00';

					$hrsplit = explode( '/', $this->heartrate );

					if ( count( $hrsplit ) > 0 ) {
						$rate_num = $hrsplit[0];
					}

					if ( count( $hrsplit ) > 1 ) {
						$time = $hrsplit[1];
					}

					// Handle the switching from input="time" to input="text" for cross-browser/safari support.
					if ( strlen( $time ) !== 5 && substr( $time, -3, 1 ) !== ':' ) {
						$time_input = 'type="text"';
					} else {
						$time_input = 'type="time"';
					}

					$final_hr_string = $final_hr_string . '<div class="wphealthtracker-response-form-data-row-hr" id="wphealthtracker-response-form-hr-row-div-' . $key . '-' . $loop_num . '">
							<div class="wphealthtracker-response-form-div-row">
								<p>' . $this->translations->vitals_trans_23 . '</p>
								<input type="number" class="wphealthtracker-response-form-input-number" id="wphealthtracker-response-form-input-number-hr-' . $key . '-' . $loop_num . '" value="' . $rate_num . '"></input>
							</div>
							<div class="wphealthtracker-response-form-div-row">
								<p>' . $this->translations->common_trans_25 . '</p>
								<input ' . $time_input . ' class="wphealthtracker-response-form-input-time wphealthtracker-response-form-input-time-hr" id="wphealthtracker-response-form-input-time-hr-' . $key . '-' . $loop_num . '" value="' . $time . '"></input>
							</div>
						</div>';

				}
			} else {
				// If there is no Heart Rate Data Saved at all...
				$final_hr_string = $final_hr_string . '<div class="wphealthtracker-response-form-data-row-hr" id="wphealthtracker-response-form-hr-row-div-' . $key . '-' . $loop_num . '">
							<div class="wphealthtracker-response-form-div-row">
								<p>' . $this->translations->vitals_trans_23 . '</p>
								<input type="number" class="wphealthtracker-response-form-input-number" id="wphealthtracker-response-form-input-number-hr-' . $key . '-' . $loop_num . '"></input>
							</div>
							<div class="wphealthtracker-response-form-div-row">
								<p>' . $this->translations->common_trans_25 . '</p>
								<input type="time" class="wphealthtracker-response-form-input-time wphealthtracker-response-form-input-time-hr" id="wphealthtracker-response-form-input-time-hr-' . $key . '-' . $loop_num . '"></input>
							</div>
						</div>';
			}

			return $final_hr_string = $final_hr_string . '<div class="wphealthtracker-response-form-row-addition-div" data-key="' . $key . '" data-loopnum="' . $loop_num . '" data-id-to-add-after="wphealthtracker-response-form-hr-row-div-' . $key . '-' . $loop_num . '">
						<p>' . $this->translations->common_trans_42 . '</p><img class="wphealthtracker-response-form-row-add-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'web-site.svg" />
					</div>
				</div>';

		}

		/**
		 * Handle the configuring of the images
		 *
		 * @param int $loop_num - tracks which day we're on.
		 */
		private function output_vitals_enter_config_images( $loop_num ) {

			// For unit testing, feed into the function the loop_num of zero, and set $this->imgvitalsurl to '', 'someurl', 'someurl,someurl'.
			$key = 0;

			$final_img_string = '<div class="wphealthtracker-response-form-entry-row">
					<h2 class="wphealthtracker-response-form-heading-black"><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view" data-label="vitals-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg" />' . $this->translations->common_trans_27 . '<img class="wphealthtracker-icon-h2-image" data-label="vitals-weight" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'image.svg" /></h2>';

			// If there is indeed Image Data...
			if ( '' !== $this->imgvitalsurl ) {
				// If there are multiple image entries on the same date...
				if ( strpos( $this->imgvitalsurl, ',' ) !== false ) {
					$imgvitalsurlarray = explode( ',', $this->imgvitalsurl );

					foreach ( $imgvitalsurlarray as $key => $value ) {

						// If we're not on the first iteration of this loop, include the row removal html.
						$removal_string = '';
						if ( $key > 0 ) {
							$removal_string = '<div class="wphealthtracker-response-form-row-removal-div" data-id-to-remove="wphealthtracker-response-form-img-row-div-' . $key . '-' . $loop_num . '">
									<p>' . $this->translations->common_trans_41 . '</p><img class="wphealthtracker-response-form-row-removal-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'garbage.svg" />
								</div>';
						}

						$final_img_string = $final_img_string . '<div class="wphealthtracker-response-form-data-row-img" id="wphealthtracker-response-form-img-row-div-' . $key . '-' . $loop_num . '">
							<div class="wphealthtracker-response-form-div-row">
								<p>' . $this->translations->common_trans_28 . '</p>
								<input type="text" placeholder="' . $this->translations->common_trans_28 . '" class="wphealthtracker-response-form-input-text wphealthtracker-response-form-input-text-image-upload" id="wphealthtracker-response-form-input-text-image-upload-' . $key . '-' . $loop_num . '" value="' . $value . '"></input>
							</div>
							<div class="wphealthtracker-response-form-div-row">
								<p>' . $this->translations->common_trans_29 . '</p>
								<button class="wphealthtracker-response-form-input-button wphealthtracker-response-form-input-button-image-upload" id="wphealthtracker-response-form-input-button-image-upload-' . $key . '-' . $loop_num . '">' . $this->translations->common_trans_30 . '</button>
							' . $removal_string . '
						</div>
					</div>';

					}
				} else {

					$final_img_string = $final_img_string . '<div class="wphealthtracker-response-form-data-row-img" id="wphealthtracker-response-form-img-row-div-' . $key . '-' . $loop_num . '">
						<div class="wphealthtracker-response-form-div-row">
							<p>' . $this->translations->common_trans_28 . '</p>
							<input type="text" placeholder="' . $this->translations->common_trans_28 . '" class="wphealthtracker-response-form-input-text wphealthtracker-response-form-input-text-image-upload" id="wphealthtracker-response-form-input-text-image-upload-' . $key . '-' . $loop_num . '" value="' . $this->imgvitalsurl . '"></input>
						</div>
						<div class="wphealthtracker-response-form-div-row">
							<p>' . $this->translations->common_trans_29 . '</p>
							<button class="wphealthtracker-response-form-input-button wphealthtracker-response-form-input-button-image-upload" id="wphealthtracker-response-form-input-button-image-upload-' . $key . '-' . $loop_num . '">' . $this->translations->common_trans_30 . '</button>
						</div>
					</div>';

				}
			} else {
				// If there is no Image Data Saved at all...
				$final_img_string = $final_img_string . '<div class="wphealthtracker-response-form-data-row-img" id="wphealthtracker-response-form-img-row-div-' . $key . '-' . $loop_num . '">
						<div class="wphealthtracker-response-form-div-row">
							<p>' . $this->translations->common_trans_28 . '</p>
							<input type="text" placeholder="' . $this->translations->common_trans_28 . '" class="wphealthtracker-response-form-input-text wphealthtracker-response-form-input-text-image-upload" id="wphealthtracker-response-form-input-text-image-upload-' . $key . '-' . $loop_num . '"></input>
						</div>
						<div class="wphealthtracker-response-form-div-row">
							<p>' . $this->translations->common_trans_29 . '</p>
							<button class="wphealthtracker-response-form-input-button wphealthtracker-response-form-input-button-image-upload" id="wphealthtracker-response-form-input-button-image-upload-' . $key . '-' . $loop_num . '">' . $this->translations->common_trans_30 . '</button>
						</div>
					</div>';

			}

			return $final_img_string = $final_img_string . '<div class="wphealthtracker-response-form-row-addition-div" data-key="' . $key . '" data-loopnum="' . $loop_num . '" data-id-to-add-after="wphealthtracker-response-form-img-row-div-' . $key . '-' . $loop_num . '">
						<p>' . $this->translations->common_trans_42 . '</p><img class="wphealthtracker-response-form-row-add-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'web-site.svg" />
					</div>
				</div>';
		}

		/**
		 * Handle the configuring of the files
		 *
		 * @param int $loop_num - tracks which day we're on.
		 */
		private function output_vitals_enter_config_files( $loop_num ) {

			// For unit testing, feed into the function the loop_num of zero, and set $this->filevitalsurl to '', 'someurl', 'someurl,someurl'.
			$key = 0;

			$final_file_string = '<div class="wphealthtracker-response-form-entry-row">
					<h2 class="wphealthtracker-response-form-heading-black"><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view" data-label="vitals-files" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg" />' . $this->translations->common_trans_31 . '<img class="wphealthtracker-icon-h2-image" data-label="vitals-weight" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'upload-file.svg" /></h2>';

			// If there is indeed file Data...
			if ( '' !== $this->filevitalsurl ) {
				// If there are multiple file entries on the same date...
				if ( strpos( $this->filevitalsurl, ',' ) !== false ) {
					$imgvitalsurlarray = explode( ',', $this->filevitalsurl );

					foreach ( $imgvitalsurlarray as $key => $value ) {

						// If we're not on the first iteration of this loop, include the row removal html.
						$removal_string = '';
						if ( $key > 0 ) {
							$removal_string = '<div class="wphealthtracker-response-form-row-removal-div" data-id-to-remove="wphealthtracker-response-form-file-row-div-' . $key . '-' . $loop_num . '">
									<p>' . $this->translations->common_trans_41 . '</p><img class="wphealthtracker-response-form-row-removal-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'garbage.svg" />
								</div>';
						}

						$final_file_string = $final_file_string . '<div class="wphealthtracker-response-form-data-row-file" id="wphealthtracker-response-form-file-row-div-' . $key . '-' . $loop_num . '">
							<div class="wphealthtracker-response-form-div-row">
								<p>' . $this->translations->common_trans_32 . '</p>
								<input type="text" placeholder="' . $this->translations->common_trans_32 . '" class="wphealthtracker-response-form-input-text wphealthtracker-response-form-input-text-file-upload" id="wphealthtracker-response-form-input-text-file-upload-' . $key . '-' . $loop_num . '" value="' . $value . '"></input>
							</div>
							<div class="wphealthtracker-response-form-div-row">
								<p>' . $this->translations->common_trans_33 . '</p>
								<button class="wphealthtracker-response-form-input-button wphealthtracker-response-form-input-button-file-upload" id="wphealthtracker-response-form-input-button-file-upload-' . $key . '-' . $loop_num . '">' . $this->translations->common_trans_34 . '</button>
							' . $removal_string . '
						</div>
					</div>';

					}
				} else {

					$final_file_string = $final_file_string . '<div class="wphealthtracker-response-form-data-row-file" id="wphealthtracker-response-form-file-row-div-' . $key . '-' . $loop_num . '">
						<div class="wphealthtracker-response-form-div-row">
							<p>' . $this->translations->common_trans_32 . '</p>
							<input type="text" placeholder="' . $this->translations->common_trans_32 . '" class="wphealthtracker-response-form-input-text wphealthtracker-response-form-input-text-file-upload" id="wphealthtracker-response-form-input-text-file-upload-' . $key . '-' . $loop_num . '" value="' . $this->filevitalsurl . '"></input>
						</div>
						<div class="wphealthtracker-response-form-div-row">
							<p>' . $this->translations->common_trans_33 . '</p>
							<button class="wphealthtracker-response-form-input-button wphealthtracker-response-form-input-button-file-upload" id="wphealthtracker-response-form-input-button-file-upload-' . $key . '-' . $loop_num . '">' . $this->translations->common_trans_34 . '</button>
						</div>
					</div>';

				}
			} else {
				// If there is no File Data Saved at all...
				$final_file_string = $final_file_string . '<div class="wphealthtracker-response-form-data-row-file" id="wphealthtracker-response-form-file-row-div-' . $key . '-' . $loop_num . '">
						<div class="wphealthtracker-response-form-div-row">
							<p>' . $this->translations->common_trans_32 . '</p>
							<input type="text" placeholder="' . $this->translations->common_trans_32 . '" class="wphealthtracker-response-form-input-text wphealthtracker-response-form-input-text-file-upload" id="wphealthtracker-response-form-input-text-file-upload-' . $key . '-' . $loop_num . '"></input>
						</div>
						<div class="wphealthtracker-response-form-div-row">
							<p>' . $this->translations->common_trans_33 . '</p>
							<button class="wphealthtracker-response-form-input-button wphealthtracker-response-form-input-button-file-upload" id="wphealthtracker-response-form-input-button-file-upload-' . $key . '-' . $loop_num . '">' . $this->translations->common_trans_34 . '</button>
						</div>
					</div>';

			}

			return $final_file_string = $final_file_string . '<div class="wphealthtracker-response-form-row-addition-div" data-key="' . $key . '" data-loopnum="' . $loop_num . '" data-id-to-add-after="wphealthtracker-response-form-file-row-div-' . $key . '-' . $loop_num . '">
						<p>' . $this->translations->common_trans_42 . '</p><img class="wphealthtracker-response-form-row-add-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'web-site.svg" />
					</div>
				</div>';

		}

		/**
		 * Filter to insert additional data capture code at the bottom of the 'Enter' container on the Vitals tab.
		 */
		private function output_vitals_enter_bottom_filter() {

			$filter_return = '';
			if ( has_filter( 'wphealthtracker_data_vitals_enter_and_view' ) ) {
				$filter_return = apply_filters( 'wphealthtracker_data_vitals_enter_and_view', 'placeholder' );
			}

			return $filter_return;

		}

		/**
		 * Output the ending html part, with the spinner, the save button, and the response messager container
		 *
		 * @param int $type - whether it's a previous day or today.
		 * @param int $key - tracks which loop we're on.
		 */
		private function output_vitals_ending( $type, $key ) {

			// If we're outputing the save button for previous days, use the 'Update data for [date]' translation string.
			if ( 'previous' === $type ) {
				return '<div class="wphealthtracker-save-spinner-response-div">
				<div class="wphealthtracker-spinner-red" id="wphealthtracker-spinner-save-vitals"></div>
				<div class="wphealthtracker-response-message-div" id="wphealthtracker-response-message-vitals-div"></div>
				<button class="wphealthtracker-save-stuff-button" id="wphealthtracker-save-daily-vitals-enter-' . $key . '" data-firstname="' . $this->firstname . '" data-lastname="' . $this->lastname . '" data-human-date="' . $this->humandate . '" data-parent-id-num="' . $key . '">' . $this->translations->common_trans_3 . ' ' . $this->humandate . '</button>
			</div>';
			}

			// If we're outputing the save button for previous days, use the 'Save data' translation string.
			if ( 'today' === $type ) {
				return '<div class="wphealthtracker-save-spinner-response-div">
				<div class="wphealthtracker-spinner-primary" id="wphealthtracker-spinner-save-vitals"></div>
				<div class="wphealthtracker-response-message-div" id="wphealthtracker-response-message-vitals-div"></div>
				<button class="wphealthtracker-save-stuff-button" id="wphealthtracker-save-daily-vitals-enter-' . $key . '" data-firstname="' . $this->firstname . '" data-lastname="' . $this->lastname . '" data-human-date="' . $this->humandate . '" data-parent-id-num="' . $key . '">' . $this->translations->vitals_trans_24 . '</button>
			</div>';
			}

		}

		/**
		 * Output the wrapper that will wrap around every previous day's entry, to provide the expansion/minimization div, it's text ad image, etc.
		 *
		 * @param int $loop_num - tracks which day we're on.
		 */
		private function output_vitals_enter_config_all_data_wrapper_html_open( $loop_num ) {

			return '
			<div class="wphealthtracker-response-form-all-data-row" id="wphealthtracker-response-form-all-data-row-' . $loop_num . '">
				<img class="wphealthtracker-saved-data-indiv-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'analysis.svg" />
				<p class="wphealthtracker-all-data-p">' . $this->translations->common_trans_2 . ' ' . $this->humandate . '</p>
				<div class="wphealthtracker-expand-minimize-div-all-data">
					<p class="wphealthtracker-expand-minimize-p" id="wphealthtracker-expand-minimize-p-enter">Expand</p>
					<img src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'rotate.svg" class="wphealthtracker-indiv-choice-img-rotate" id="wphealthtracker-indiv-choice-img-rotate-enter" />
				</div>
			</div>
			<div class="wphealthtracker-response-form-all-data-row-actual" id="wphealthtracker-response-form-data-row-actual-' . $loop_num . '">';

		}

		/**
		 * Output the wrapper that will close every previous day's entry, to provide the expansion/minimization div, it's text ad image, etc.
		 *
		 * @param int $loop_num - tracks which day we're on.
		 */
		private function output_vitals_enter_config_all_data_wrapper_html_close( $loop_num ) {

			return '</div>';

		}

		/**
		 * Output the message for the user if no previously-saved data was found
		 *
		 * @param string $userfirst - User's first name.
		 * @param string $userlast - User's last name.
		 */
		private function output_no_data_html( $userfirst, $userlast ) {

			$no_data_html = '<div class="wphealthtracker-no-saved-data-div">
				<p>
					<img class="wphealthtracker-shocked-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'shocked.svg"/>
					<span class="wphealthtracker-no-saved-span1">' . $this->translations->common_trans_18 . '</span>
					<br/>
					' . $this->translations->common_trans_19 . ' ' . $userfirst . ' ' . $userlast . '!
					<br/>' . $this->translations->common_trans_20 . ' ' . $this->date . '" ' . $this->translations->common_trans_21 . '
					<br/><br/>
					<span class="wphealthtracker-no-saved-span2">' . $this->translations->common_trans_22 . '</span>
				</p>
			</div>';

			return $no_data_html;

		}

		/**
		 * Output the data filter html if previously-saved data was found
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
										<button class="wphealthtracker-view-filter-button-vitals" id="wphealthtracker-view-filter-button-vitals-id">' . $this->translations->common_trans_13 . '</button>
										<div class="wphealthtracker-spinner-primary" id="wphealthtracker-spinner-filter-vitals"></div>
									</div>
								</div>
							</div>';

			return $filter_html;

		}

		/**
		 * Build the final form for the 'Enter' container, taking into account that the user already has data saved for today.
		 *
		 * @param object $userdailydata - user's daily data.
		 */
		public function output_today_data( $userdailydata ) {

			// Set class variables with data retrieved (or explicitly set) from the calling function.
			$this->firstname     = $userdailydata->firstname;
			$this->lastname      = $userdailydata->lastname;
			$this->wpuserid      = $userdailydata->wpuserid;
			$this->humandate     = $userdailydata->humandate;
			$this->weight        = $userdailydata->weight;
			$this->bloodpressure = $userdailydata->bloodpressure;
			$this->bloodoxygen   = $userdailydata->bloodoxygen;
			$this->bodytemp      = $userdailydata->bodytemp;
			$this->cholesterol   = $userdailydata->cholesterol;
			$this->heartrate     = $userdailydata->heartrate;
			$this->bloodsugar    = $userdailydata->bloodsugar;
			$this->imgvitalsurl  = $userdailydata->vitalsimg;
			$this->filevitalsurl = $userdailydata->vitalsfiles;

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
			if ( $currentwpuser->ID === (int) $this->wpuserid || '1' === $user_perm[16] ) {
				$proceed_flag = true;
			}

			if ( $proceed_flag ) {
				// Output the individual data items.
				$piece_one   = $this->output_vitals_enter_config_weight( 0 );
				$piece_two   = $this->output_vitals_enter_config_cholesterol( 0 );
				$piece_three = $this->output_vitals_enter_config_blood_pressure( 0 );
				$piece_four  = $this->output_vitals_enter_config_blood_sugar( 0 );
				$piece_five  = $this->output_vitals_enter_config_blood_oxygen( 0 );
				$piece_six   = $this->output_vitals_enter_config_body_temp( 0 );
				$piece_seven = $this->output_vitals_enter_config_heart_rate( 0 );
				$piece_eight = $this->output_vitals_enter_config_images( 0 );
				$piece_nine  = $this->output_vitals_enter_config_files( 0 );

				// Finish up with the Filter for the bottom of the Enter container, the Spinner, response message area, and the Save button.
				$filter_piece = $this->output_vitals_enter_bottom_filter();
				$end_piece    = $this->output_vitals_ending( 'today', 0 );

				// Assemble the final output.
				$this->final_complete_output = $piece_one . $piece_two . $piece_three . $piece_four . $piece_five . $piece_six . $piece_seven . $piece_eight . $piece_nine . $filter_piece . $end_piece;

			} else {

				// Output the No Acess message.
				require_once WPHEALTHTRACKER_CLASSES_UTILITIES_DIR . 'class-wphealthtracker-utilities-accesscheck.php';
				$this->access = new WPHealthTracker_Utilities_Accesscheck();
				$this->final_complete_output = $this->access->wphealthtracker_accesscheck_no_permission_message();

			}

		}

		/**
		 * Build the final form for the 'View' container.
		 *
		 * @param object $useralldata - All user's data.
		 * @param string $userfirst - User's first name.
		 * @param string $userlast - User's last name.
		 */
		public function output_previous_data( $useralldata, $userfirst, $userlast, $wpuserid ) {

			$this->final_complete_output = '';

			// Now make access check to see if user can access this part of WPHealthTRacker - get the users permissions
			// Make call to Transients class to see if Transient currently exists. If so, retrieve it, if not, make call to create_transient() with all required Parameters.
			global $wpdb;
			$currentwpuser = wp_get_current_user();
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
			if ( $currentwpuser->ID === (int) $wpuserid || ( '1' === $user_perm[13] && '1' === $user_perm[16] ) ) {
				$proceed_flag = 'viewandedit';
			} elseif ( '1' === $user_perm[13] && '0' === $user_perm[16] ) {
				$proceed_flag = 'viewonly';
			} else {
				$proceed_flag = 'noaccess';
			}

			// The loop that will build each individual day's final full html entry.
			foreach ( $useralldata as $key => $indiv_day ) {

				// Set class variables with data retrieved from the calling function.
				$this->firstname     = $indiv_day->firstname;
				$this->lastname      = $indiv_day->lastname;
				$this->wpuserid      = $indiv_day->wpuserid;
				$this->humandate     = $indiv_day->humandate;
				$this->weight        = $indiv_day->weight;
				$this->bloodpressure = $indiv_day->bloodpressure;
				$this->bloodoxygen   = $indiv_day->bloodoxygen;
				$this->bodytemp      = $indiv_day->bodytemp;
				$this->cholesterol   = $indiv_day->cholesterol;
				$this->heartrate     = $indiv_day->heartrate;
				$this->bloodsugar    = $indiv_day->bloodsugar;
				$this->imgvitalsurl  = $indiv_day->vitalsimg;
				$this->filevitalsurl = $indiv_day->vitalsfiles;

				// Increment the $key variable by one to not conflict with the data in the 'Enter' section.
				$key++;

				if ( 'noaccess' !== $proceed_flag ) {

					// Output the individual data items.
					$piece_one   = $this->output_vitals_enter_config_weight( $key );
					$piece_two   = $this->output_vitals_enter_config_cholesterol( $key );
					$piece_three = $this->output_vitals_enter_config_blood_pressure( $key );
					$piece_four  = $this->output_vitals_enter_config_blood_sugar( $key );
					$piece_five  = $this->output_vitals_enter_config_blood_oxygen( $key );
					$piece_six   = $this->output_vitals_enter_config_body_temp( $key );
					$piece_seven = $this->output_vitals_enter_config_heart_rate( $key );
					$piece_eight = $this->output_vitals_enter_config_images( $key );
					$piece_nine  = $this->output_vitals_enter_config_files( $key );

					// Get the HTML that will wrap each day's data, providing the div that the user will click on to expand and view that day's data.
					$piece_wrapper_html_open  = $this->output_vitals_enter_config_all_data_wrapper_html_open( $key );
					$piece_wrapper_html_close = $this->output_vitals_enter_config_all_data_wrapper_html_close( $key );

					// Finish up with the Filter for the bottom of the Enter container, the Spinner, response message area, and the Save button.
					$filter_piece = $this->output_vitals_enter_bottom_filter();


					if ( 'viewandedit' === $proceed_flag ) {
						$end_piece = $this->output_vitals_ending( 'previous', $key );
					} else {
						$end_piece = '';
					}

					$this->final_complete_output = $this->final_complete_output . $piece_wrapper_html_open . $piece_one . $piece_two . $piece_three . $piece_four . $piece_five . $piece_six . $piece_seven . $piece_eight . $piece_nine . $filter_piece . $end_piece . $piece_wrapper_html_close;

				} else {

					// Output the No Acess message.
					require_once WPHEALTHTRACKER_CLASSES_UTILITIES_DIR . 'class-wphealthtracker-utilities-accesscheck.php';
					$this->access                = new WPHealthTracker_Utilities_Accesscheck();
					$this->final_complete_output = $this->access->wphealthtracker_accesscheck_no_permission_message();

				}
			}

			// If $this->final_complete_output !== '', indicating that previously-saved data WAS found for this user, add the data 'Filter' HTML.
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

