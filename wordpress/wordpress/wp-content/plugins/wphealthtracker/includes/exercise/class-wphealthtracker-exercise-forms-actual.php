<?php
/**
 * Class WPHEALTHTRACKER_Exercise_Forms_Actual - wphealthtracker-exercise-forms-actual.php
 *
 * @author   Jake Evans
 * @category Admin
 * @package  Includes/Exercise
 * @version  0.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPHEALTHTRACKER_Exercise_Forms_Actual', false ) ) :

	/**
	 * WPHEALTHTRACKER_Exercise_Forms_Actual class. This class holds all of the forms that will be used for entering and Viewing Exercise data on the Exercise Tracker tab.
	 */
	class WPHEALTHTRACKER_Exercise_Forms_Actual {

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
		 *  @var string $exercisestring
		 */
		public $exercisestring = '';

		/** Common member variable
		 *
		 *  @var string $imgexerciseurl
		 */
		public $imgexerciseurl = '';

		/** Common member variable
		 *
		 *  @var string $fileexerciseurl
		 */
		public $fileexerciseurl = '';

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
			$this->translations->exercise_tab_trans_strings();
			$this->translations->common_trans_strings();
			$this->translations->d3_chart_trans_strings();
			$this->translations->tab_titles_trans_strings();

			// Set the date.
			require_once WPHEALTHTRACKER_CLASSES_UTILITIES_DIR . 'class-wphealthtracker-utilities-date.php';
			$utilities_date = new WPHealthTracker_Utilities_Date();
			$this->date     = $utilities_date->wphealthtracker_get_date_via_current_time( 'mysql' );
		}

		/**
		 * Handle the splitting up of the blood pressure numbers and times recorded.
		 *
		 * @param int    $loop_num - tracks which day we're on.
		 * @param string $type - specifies if we're on today or a previous day.
		 */
		private function output_exercise_enter_config_exercise_item( $loop_num, $type ) {

			$key                   = 0;
			$final_exercise_string = '';
			$data_section          = ' data-section="' . $type . '" ';

			// If there is indeed Exercise data saved at all.
			if ( null !== $this->exercisestring ) {

				// If there are multiple exercise entries on the same date...
				if ( strpos( $this->exercisestring, ',' ) !== false ) {
					$exercisearray = explode( ',', $this->exercisestring );
					foreach ( $exercisearray as $key => $value ) {

						$exerciseitem    = '';
						$time            = '0:00';
						$duration        = '';
						$distance        = '';
						$distancemeasure = '';
						$exercisetype    = '';
						$exerdurmeasure  = '';
						$musclegroups    = '';
						$totalweightreps = '';
						$imageurl        = '';
						$fileurl         = '';

						$exercisesplit = explode( ';', $value );

						if ( count( $exercisesplit ) > 0 ) {
							$exerciseitem = $exercisesplit[0];
						}

						if ( count( $exercisesplit ) > 1 ) {
							$exercisetype = $exercisesplit[1];
						}

						if ( count( $exercisesplit ) > 2 ) {
							$time = $exercisesplit[2];
						}

						if ( count( $exercisesplit ) > 3 ) {
							$duration = $exercisesplit[3];
						}

						if ( count( $exercisesplit ) > 4 ) {
							$exerdurmeasure = $exercisesplit[4];
						}

						if ( count( $exercisesplit ) > 5 ) {
							$distance = $exercisesplit[5];
						}

						if ( count( $exercisesplit ) > 6 ) {
							$distancemeasure = $exercisesplit[6];
						}

						if ( count( $exercisesplit ) > 7 ) {
							$musclegroups = $exercisesplit[7];
						}

						if ( count( $exercisesplit ) > 8 ) {
							$totalweightreps = $exercisesplit[8];
						}

						if ( count( $exercisesplit ) > 9 ) {
							$imageurl = $exercisesplit[9];
						}

						if ( count( $exercisesplit ) > 10 ) {
							$fileurl = $exercisesplit[10];
						}

						// Build the Options for the Exercise Type Select.
						if ( $exercisetype === $this->translations->exercise_trans_9 ) {
							$exercisetype =
							'<option selected>' . $this->translations->exercise_trans_9 . '</option>
							<option>' . $this->translations->exercise_trans_10 . '</option>
							<option>' . $this->translations->exercise_trans_11 . '</option>
							<option>' . $this->translations->exercise_trans_12 . '</option>
							<option>' . $this->translations->common_trans_37 . '</option>
							<option>' . $this->translations->common_trans_47 . '</option>';
						} elseif ( $exercisetype === $this->translations->exercise_trans_10 ) {
							$exercisetype =
						'<option>' . $this->translations->exercise_trans_9 . '</option>
							<option selected>' . $this->translations->exercise_trans_10 . '</option>
							<option>' . $this->translations->exercise_trans_11 . '</option>
							<option>' . $this->translations->exercise_trans_12 . '</option>
							<option>' . $this->translations->common_trans_37 . '</option>
							<option>' . $this->translations->common_trans_47 . '</option>';
						} elseif ( $exercisetype === $this->translations->exercise_trans_11 ) {
							$exercisetype =
							'<option>' . $this->translations->exercise_trans_9 . '</option>
							<option>' . $this->translations->exercise_trans_10 . '</option>
							<option selected>' . $this->translations->exercise_trans_11 . '</option>
							<option>' . $this->translations->exercise_trans_12 . '</option>
							<option>' . $this->translations->common_trans_37 . '</option>
							<option>' . $this->translations->common_trans_47 . '</option>';
						} elseif ( $exercisetype === $this->translations->exercise_trans_12 ) {
							$exercisetype =
							'<option>' . $this->translations->exercise_trans_9 . '</option>
							<option>' . $this->translations->exercise_trans_10 . '</option>
							<option>' . $this->translations->exercise_trans_11 . '</option>
							<option selected>' . $this->translations->exercise_trans_12 . '</option>
							<option>' . $this->translations->common_trans_37 . '</option>
							<option>' . $this->translations->common_trans_47 . '</option>';
						} elseif ( $exercisetype === $this->translations->common_trans_37 ) {
							$exercisetype =
							'<option>' . $this->translations->exercise_trans_9 . '</option>
							<option>' . $this->translations->exercise_trans_10 . '</option>
							<option>' . $this->translations->exercise_trans_11 . '</option>
							<option>' . $this->translations->exercise_trans_12 . '</option>
							<option  selected>' . $this->translations->common_trans_37 . '</option>
							<option>' . $this->translations->common_trans_47 . '</option>';
						} elseif ( $exercisetype === $this->translations->common_trans_47 ) {
							$exercisetype =
							'<option>' . $this->translations->exercise_trans_9 . '</option>
							<option>' . $this->translations->exercise_trans_10 . '</option>
							<option>' . $this->translations->exercise_trans_11 . '</option>
							<option>' . $this->translations->exercise_trans_12 . '</option>
							<option>' . $this->translations->common_trans_37 . '</option>
							<option  selected>' . $this->translations->common_trans_47 . '</option>';
						} else {
							$exercisetype =
							'<option>' . $this->translations->exercise_trans_9 . '</option>
							<option>' . $this->translations->exercise_trans_10 . '</option>
							<option>' . $this->translations->exercise_trans_11 . '</option>
							<option>' . $this->translations->exercise_trans_12 . '</option>
							<option>' . $this->translations->common_trans_37 . '</option>
							<option>' . $this->translations->common_trans_47 . '</option>';
						}

						// Build the Options for the Exercise Duration Select.
						if ( $exerdurmeasure === $this->translations->common_trans_48 ) {
							$exerdurmeasure =
							'<option selected>' . $this->translations->common_trans_48 . '</option>
							<option>' . $this->translations->common_trans_49 . '</option>
							<option>' . $this->translations->common_trans_50 . '</option>';
						} elseif ( $exerdurmeasure === $this->translations->common_trans_49 ) {
							$exerdurmeasure =
							'<option>' . $this->translations->common_trans_48 . '</option>
							<option selected>' . $this->translations->common_trans_49 . '</option>
							<option>' . $this->translations->common_trans_50 . '</option>';
						} elseif ( $exerdurmeasure === $this->translations->common_trans_50 ) {
							$exerdurmeasure =
							'<option>' . $this->translations->common_trans_48 . '</option>
							<option>' . $this->translations->common_trans_49 . '</option>
							<option selected>' . $this->translations->common_trans_50 . '</option>';
						} else {
							$exerdurmeasure =
							'<option>' . $this->translations->common_trans_48 . '</option>
							<option>' . $this->translations->common_trans_49 . '</option>
							<option>' . $this->translations->common_trans_50 . '</option>';
						}

						// Build the Options for the Distance Travelled Select.
						if ( $distancemeasure === $this->translations->common_trans_51 ) {
							$distancemeasure =
							'<option selected>' . $this->translations->common_trans_51 . '</option>
							<option>' . $this->translations->common_trans_52 . '</option>
							<option>' . $this->translations->common_trans_53 . '</option>
							<option>' . $this->translations->common_trans_54 . '</option>
							<option>' . $this->translations->common_trans_55 . '</option>';
						} elseif ( $distancemeasure === $this->translations->common_trans_52 ) {
							$distancemeasure =
							'<option>' . $this->translations->common_trans_51 . '</option>
							<option selected>' . $this->translations->common_trans_52 . '</option>
							<option>' . $this->translations->common_trans_53 . '</option>
							<option>' . $this->translations->common_trans_54 . '</option>
							<option>' . $this->translations->common_trans_55 . '</option>';
						} elseif ( $distancemeasure === $this->translations->common_trans_53 ) {
							$distancemeasure =
							'<option>' . $this->translations->common_trans_51 . '</option>
							<option>' . $this->translations->common_trans_52 . '</option>
							<option selected>' . $this->translations->common_trans_53 . '</option>
							<option>' . $this->translations->common_trans_54 . '</option>
							<option>' . $this->translations->common_trans_55 . '</option>';
						} elseif ( $distancemeasure === $this->translations->common_trans_54 ) {
							$distancemeasure =
							'<option>' . $this->translations->common_trans_51 . '</option>
							<option>' . $this->translations->common_trans_52 . '</option>
							<option>' . $this->translations->common_trans_53 . '</option>
							<option selected>' . $this->translations->common_trans_54 . '</option>
							<option>' . $this->translations->common_trans_55 . '</option>';
						} elseif ( $distancemeasure === $this->translations->common_trans_55 ) {
							$distancemeasure =
							'<option>' . $this->translations->common_trans_51 . '</option>
							<option>' . $this->translations->common_trans_52 . '</option>
							<option>' . $this->translations->common_trans_53 . '</option>
							<option>' . $this->translations->common_trans_54 . '</option>
							<option selected>' . $this->translations->common_trans_55 . '</option>';
						} else {
							$distancemeasure =
							'<option>' . $this->translations->common_trans_51 . '</option>
							<option>' . $this->translations->common_trans_52 . '</option>
							<option>' . $this->translations->common_trans_53 . '</option>
							<option>' . $this->translations->common_trans_54 . '</option>
							<option>' . $this->translations->common_trans_55 . '</option>';
						}

						// Builidng all Sets/Reps/Weight HTML.
						$set_loop_num = 0;
						if ( stripos( $totalweightreps, '//' ) !== false ) {

							$totalweightrepsarray = explode( '//', $totalweightreps );

							$sets_html = '';
							foreach ( $totalweightrepsarray as $key2 => $set ) {

								$sets_removal_string = '';
								if ( 0 !== $key2 ) {
									$sets_removal_string = '<div class="wphealthtracker-response-form-exercise-set-removal-div"><p>' . $this->translations->common_trans_41 . '</p><img class="wphealthtracker-response-form-set-removal-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'garbage.svg" /></div>';
								}

								$set_loop_num = $key2;

								$weight      = '';
								$bodyweight  = 'false';
								$reps        = '';
								$measurement = $this->translations->d3_trans_19;
								if ( stripos( $set, '/' ) !== false ) {

									$set_array = explode( '/', $set );

									if ( array_key_exists( 0, $set_array ) ) {
										$weight = $set_array[0];
									}

									if ( array_key_exists( 1, $set_array ) ) {
										$bodyweight = $set_array[1];
									}

									if ( array_key_exists( 2, $set_array ) ) {
										$reps = $set_array[2];
									}

									if ( array_key_exists( 3, $set_array ) ) {
										$measurement = $set_array[3];
									}
								}

								// Creating the checked attribute.
								$bodyweight_checked = '';
								$weight_disabled    = '';
								if ( 'true' === $bodyweight ) {
									$bodyweight_checked = 'checked="true"';
									$weight_disabled    = 'disabled';
								}

								// Build the Options for the Sets weight measurement Select.
								if ( $measurement === $this->translations->d3_trans_19 ) {
									$setweightmeasure =
									'<option selected>' . $this->translations->d3_trans_19 . '</option>
									<option>' . $this->translations->d3_trans_18 . '</option>';
								} elseif ( $measurement === $this->translations->d3_trans_18 ) {
									$setweightmeasure =
									'<option>' . $this->translations->d3_trans_19 . '</option>
									<option selected>' . $this->translations->d3_trans_18 . '</option>';
								} else {
									$setweightmeasure =
									'<option>' . $this->translations->d3_trans_19 . '</option>
									<option>' . $this->translations->d3_trans_18 . '</option>';
								}

								$sets_html = $sets_html . '
								<div class="wphealthtracker-response-form-exercise-set-div"><p class="wphealthtracker-response-form-exercise-set-label">' . $this->translations->exercise_trans_17 . ' #' . ( $key2 + 1 ) . '</p><div class="wphealthtracker-response-form-exercise-innerrow-div wphealthtracker-response-form-exercise-innerrow-div-bodyweight-special">
												<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-weight" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->d3_trans_40 . '</p>
												<input ' . $weight_disabled . ' type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-setrep-weight-' . $key2 . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" value="' . $weight . '"/>
												<div class="wphealthtracker-response-form-input-checkbox-div">
													<input ' . $bodyweight_checked . ' type="checkbox" class="wphealthtracker-response-form-input-checkbox wphealthtracker-response-form-input-checkbox-exercise-bodyweight" id="wphealthtracker-response-form-input-text-setrep-bodyweight-' . $key2 . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
													<label>' . $this->translations->exercise_trans_38 . '</label>
												</div>
											</div>
											<div class="wphealthtracker-response-form-exercise-innerrow-div">
												<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-reps" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->exercise_trans_16 . '</p>
												<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-setrep-reps-' . $key2 . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" value="' . $reps . '"/>
											</div>
											<div class="wphealthtracker-response-form-exercise-innerrow-div">
												<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-set-measure" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_23 . '</p>
												<select class="wphealthtracker-response-form-select" id="wphealthtracker-response-form-input-select-setrep-measurement-' . $key2 . '-' . $loop_num . '">
													' . $setweightmeasure . '
												</select>
											</div>
											' . $sets_removal_string . '
										</div>';
							}
						} else {

							$sets_html = '
							<div class="wphealthtracker-response-form-exercise-set-div"><p class="wphealthtracker-response-form-exercise-set-label">' . $this->translations->exercise_trans_17 . ' #1</p><div class="wphealthtracker-response-form-exercise-innerrow-div wphealthtracker-response-form-exercise-innerrow-div-bodyweight-special">
												<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-weight" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->d3_trans_40 . '</p>
												<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-setrep-weight-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
												<div class="wphealthtracker-response-form-input-checkbox-div">
													<input type="checkbox" class="wphealthtracker-response-form-input-checkbox wphealthtracker-response-form-input-checkbox-exercise-bodyweight" id="wphealthtracker-response-form-input-text-setrep-bodyweight-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
													<label>' . $this->translations->exercise_trans_38 . '</label>
												</div>
											</div>
											<div class="wphealthtracker-response-form-exercise-innerrow-div">
												<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-reps" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->exercise_trans_16 . '</p>
												<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-setrep-reps-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
											</div>
											<div class="wphealthtracker-response-form-exercise-innerrow-div">
												<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-set-measure" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_23 . '</p>
												<select class="wphealthtracker-response-form-select" id="wphealthtracker-response-form-input-select-setrep-measurement-' . $key . '-' . $loop_num . '">
													<option>' . $this->translations->d3_trans_19 . '</option>
													<option>' . $this->translations->d3_trans_18 . '</option>
												</select>
											</div>
										</div>';
						}

						// Appending the 'Add a Set' Div to the $sets_html.
						$sets_html = $sets_html .
							'<div class="wphealthtracker-response-form-exercise-set-addition-div" id="wphealthtracker-response-form-exercise-set-addition-div-' . $loop_num . '" data-date="' . $this->humandate . '" data-key="' . $key . '" data-setkey="' . ( $set_loop_num + 1 ) . '" data-loopnum="' . $loop_num . '" data-exercisenum="0" data-idnum="' . $loop_num . '" data-id-to-add-after="wphealthtracker-response-form-exercise-shaded-container-' . $key . '-' . $loop_num . '">
								<p class="wphealthtracker-response-form-exercise-set-addition-p">' . $this->translations->exercise_trans_18 . '</p><img class="wphealthtracker-response-form-row-add-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'web-site.svg" />
							</div>';

						// Now building the Options string of all the muscles.
						$muscles                   = '';
						$muscle_translations_array = array(
							$this->translations->exercise_trans_20,
							$this->translations->exercise_trans_21,
							$this->translations->exercise_trans_22,
							$this->translations->exercise_trans_23,
							$this->translations->exercise_trans_24,
							$this->translations->exercise_trans_25,
							$this->translations->exercise_trans_26,
							$this->translations->exercise_trans_27,
							$this->translations->exercise_trans_28,
							$this->translations->exercise_trans_29,
							$this->translations->exercise_trans_30,
							$this->translations->exercise_trans_31,
							$this->translations->exercise_trans_32,
							$this->translations->exercise_trans_33,
							$this->translations->exercise_trans_34,
							$this->translations->exercise_trans_35,
							$this->translations->exercise_trans_36,
							$this->translations->exercise_trans_37,
						);

						// If we have more than one saved Muscle Group data.
						if ( stripos( $musclegroups, '/' ) !== false ) {
							$musclegroupsarray = explode( '/', $musclegroups );

							$foundmatch = false;
							foreach ( $muscle_translations_array as $transkey => $transvalue ) {

								foreach ( $musclegroupsarray as $selectkey => $selectvalue ) {
									if ( $transvalue === $selectvalue ) {
										$muscles    = $muscles . '<option selected>' . $transvalue . '</option>';
										$foundmatch = true;
									}
								}

								if ( ! $foundmatch ) {
									$muscles = $muscles . '<option>' . $transvalue . '</option>';
								} else {
									$foundmatch = false;
								}
							}

						// If we have one saved Muscle Group.
						} elseif ( '' !== $musclegroups ) {
							$foundmatch = false;
							foreach ( $muscle_translations_array as $transkey => $transvalue ) {

								if ( $transvalue === $musclegroups ) {
									$muscles = $muscles . '<option selected>' . $transvalue . '</option>';
								} else {
									$muscles = $muscles . '<option>' . $transvalue . '</option>';
								}
							}

						// If there are no saved Muscle Groups at all.
						} else {
							foreach ( $muscle_translations_array as $transkey => $transvalue ) {
								$muscles = $muscles . '<option>' . $transvalue . '</option>';
							}
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
							$removal_string = '<div class="wphealthtracker-response-form-exercise-row-removal-div" data-id-to-update="' . $loop_num . '" data-id-to-remove="wphealthtracker-response-form-all-data-row-parent-' . $key . '-' . $loop_num . '"><p>' . $this->translations->common_trans_41 . '</p><img class="wphealthtracker-response-form-row-removal-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'garbage.svg" /></div>';
						}

						$duplicate_string = '
						<div class="wphealthtracker-response-form-exercise-row-duplicate-div" data-date="' . $this->humandate . '" data-key="' . $key . '" data-loopnum="' . $loop_num . '" data-idnum="' . $loop_num . '" data-id-to-update="' . $loop_num . '" data-id-to-add-after="wphealthtracker-response-form-all-data-row-parent-' . $key . '-' . $loop_num . '"><p>' . $this->translations->common_trans_40 . '</p><img class="wphealthtracker-response-form-row-removal-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'duplicate.svg" />
						</div>';

						// Now put together the final HTML that the user will see and interact with .
						$final_exercise_string = $final_exercise_string . '
						<div class="wphealthtracker-response-form-all-data-row-parent" id="wphealthtracker-response-form-all-data-row-parent-' . $key . '-' . $loop_num . '">
						<div class="wphealthtracker-response-form-exercise-all-data-row" ' . $data_section . ' id="wphealthtracker-response-form-all-data-row-1" data-open="true" style="opacity: 1;">
							<div class="wphealthtracker-response-form-exercise-shaded-container-title">
								<h3><img class="wphealthtracker-icon-h2-image-exercise" data-label="exercise-weight" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'exercise.svg"> ' . $this->translations->tab_title_6 . ' #<span class="wphealthtracker-exercise-item-span">' . ( $key + 1 ) . '</span> - ' . $this->humandate . '</h3>
							</div>
							<div class="wphealthtracker-expand-minimize-div-all-data">
								<p class="wphealthtracker-expand-minimize-p" id="wphealthtracker-expand-minimize-p-enter" style="opacity: 1;">' . $this->translations->common_trans_1 . '</p>
								<img src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'rotate.svg" class="wphealthtracker-indiv-choice-img-rotate" id="wphealthtracker-indiv-choice-img-rotate-enter">
							</div>
						</div>
						<div class="wphealthtracker-response-form-exercise-shaded-container" id="wphealthtracker-response-form-exercise-shaded-container-' . $key . '-' . $loop_num . '">
							<div class="wphealthtracker-response-form-data-row-exercise-inner-cont">
								' . $this->output_exercise_enter_and_view_top_filter() . '
								<div class="wphealthtracker-response-form-data-row-exercise" id="wphealthtracker-response-form-exercise-item-row-div-' . $key . '-' . $loop_num . '">
									<div class="wphealthtracker-response-form-exercise-row-div-cal-pro">
										<div class="wphealthtracker-response-form-exercise-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-name" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->exercise_trans_7 . '</p>
											<input type="text" class="wphealthtracker-response-form-input-text wphealthtracker-response-form-input-text-exercise" id="wphealthtracker-response-form-input-text-exercise-name-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" value="' . $exerciseitem . '"/>
										</div>
										<div class="wphealthtracker-response-form-exercise-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-type" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->exercise_trans_8 . '</p>
											<select class="wphealthtracker-response-form-select" id="wphealthtracker-response-form-input-select-exercise-type-' . $key . '-' . $loop_num . '">
												' . $exercisetype . '
											</select>
										</div>
										<div class="wphealthtracker-response-form-exercise-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-time" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->exercise_trans_13 . '</p>
											<input ' . $time_input . ' class="wphealthtracker-response-form-input-time wphealthtracker-response-form-input-time-exercise" id="wphealthtracker-response-form-input-time-exercise-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" value="' . $time . '"/>
										</div>
									</div>
								</div>
								<div class="wphealthtracker-response-form-data-row-exercise" id="wphealthtracker-response-form-exercise-item-row-div-' . $key . '-' . $loop_num . '">
									<div class="wphealthtracker-response-form-exercise-row-div-cal-pro">
										<div class="wphealthtracker-response-form-exercise-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-time" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->exercise_trans_14 . '</p>
											<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-energy-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" value="' . $duration . '"/>
										</div>
										<div class="wphealthtracker-response-form-exercise-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-time-measure" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_23 . '</p>
											<select class="wphealthtracker-response-form-select" id="wphealthtracker-response-form-input-select-exercise-type-' . $key . '-' . $loop_num . '">
												' . $exerdurmeasure . '
											</select>
										</div>

										<div class="wphealthtracker-response-form-exercise-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-distance" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->exercise_trans_15 . '</p>
											<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-energy-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" value="' . $distance . '"/>
										</div>
										<div class="wphealthtracker-response-form-exercise-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-distance-measure" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_23 . '</p>
											<select class="wphealthtracker-response-form-select" id="wphealthtracker-response-form-input-select-exercise-type-' . $key . '-' . $loop_num . '">
												' . $distancemeasure . '
											</select>
										</div>
									</div>
								</div>
								<div class="wphealthtracker-response-form-data-row-exercise" id="wphealthtracker-response-form-exercise-protein-row-div-' . $key . '-' . $loop_num . '">
									<div class="wphealthtracker-response-form-exercise-row-div-cal-pro">
										<div class="wphealthtracker-response-form-exercise-innerrow-div wphealthtracker-response-form-exercise-innerrow-div-select-2">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-muscle-groups" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->exercise_trans_19 . '</p>
											<select class="wphealthtracker-response-form-select select2-input" id="select2-upsells" name="musclegroups[]" multiple="multiple">
												' . $muscles . '
											</select>
										</div>
									</div>
								</div>
								<div class="wphealthtracker-response-form-data-row-exercise" id="wphealthtracker-response-form-exercise-calories-row-div-' . $key . '-' . $loop_num . '">
									<div class="wphealthtracker-response-form-exercise-row-div-cal-pro">
										' . $sets_html . '
									</div>
								</div>
								' . $this->output_exercise_enter_and_view_bottom_filter() . '
								<div class="wphealthtracker-response-form-data-row-exercise" id="wphealthtracker-response-form-exercise-image-row-div-' . $key . '-' . $loop_num . '">
									<div class="wphealthtracker-response-form-exercise-row-div-cal-pro">
										<div class="wphealthtracker-response-form-exercise-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_28 . '</p>
											<input type="text" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-image-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" value="' . $imageurl . '" placeholder="' . $this->translations->common_trans_28 . '"/>
										</div>
										<div class="wphealthtracker-response-form-exercise-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-image-button" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_28 . '</p>
											<button class="wphealthtracker-response-form-input-button wphealthtracker-response-form-input-button-image-upload" id="wphealthtracker-response-form-input-button-image-upload-' . $key . '-' . $loop_num . '">' . $this->translations->common_trans_30 . '</button>
										</div>
									</div>
								</div>
								<div class="wphealthtracker-response-form-data-row-exercise" id="wphealthtracker-response-form-exercise-file-row-div-' . $key . '-' . $loop_num . '">
									<div class="wphealthtracker-response-form-exercise-row-div-cal-pro">
										<div class="wphealthtracker-response-form-exercise-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-file" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_32 . '</p>
											<input type="text" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-file-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" value="' . $fileurl . '" placeholder="' . $this->translations->common_trans_32 . '"/>
										</div>
										<div class="wphealthtracker-response-form-exercise-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-file-button" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_33 . '</p>
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

					// Now output a blank and open form for the user to add a new exercise item, if we're dealing with Today's data - if not, user can add additional exercise items to previous days by using the 'Add a row' circle image button thing.
					if ( 'today' === $type ) {

						$duplicate_string = '
						<div class="wphealthtracker-response-form-exercise-row-duplicate-div" data-date="' . $this->humandate . '" data-key="' . ( $key + 1 ) . '" data-loopnum="' . $loop_num . '" data-idnum="' . $loop_num . '" data-id-to-update="' . $loop_num . '" data-id-to-add-after="wphealthtracker-response-form-all-data-row-parent-' . ( $key + 1 ) . '-' . $loop_num . '"><p>' . $this->translations->common_trans_40 . '</p><img class="wphealthtracker-response-form-row-removal-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'duplicate.svg" />
						</div>';

						$muscles = '';
						foreach ( $muscle_translations_array as $transkey => $transvalue ) {
							$muscles = $muscles . '<option>' . $transvalue . '</option>';
						}

						$exerdurmeasure =
							'<option>' . $this->translations->common_trans_48 . '</option>
							<option>' . $this->translations->common_trans_49 . '</option>
							<option>' . $this->translations->common_trans_50 . '</option>';

						$exercisetype =
							'<option>' . $this->translations->exercise_trans_9 . '</option>
							<option>' . $this->translations->exercise_trans_10 . '</option>
							<option>' . $this->translations->exercise_trans_11 . '</option>
							<option>' . $this->translations->exercise_trans_12 . '</option>
							<option>' . $this->translations->common_trans_37 . '</option>
							<option>' . $this->translations->common_trans_47 . '</option>';

						$distancemeasure =
							'<option>' . $this->translations->common_trans_51 . '</option>
							<option>' . $this->translations->common_trans_52 . '</option>
							<option>' . $this->translations->common_trans_53 . '</option>
							<option>' . $this->translations->common_trans_54 . '</option>
							<option>' . $this->translations->common_trans_55 . '</option>';

						$sets_html = '<div class="wphealthtracker-response-form-exercise-set-div"><p class="wphealthtracker-response-form-exercise-set-label">' . $this->translations->exercise_trans_17 . ' #1</p><div class="wphealthtracker-response-form-exercise-innerrow-div wphealthtracker-response-form-exercise-innerrow-div-bodyweight-special">
												<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-weight" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->d3_trans_40 . '</p>
												<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-setrep-weight-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
												<div class="wphealthtracker-response-form-input-checkbox-div">
												<input type="checkbox" class="wphealthtracker-response-form-input-checkbox wphealthtracker-response-form-input-checkbox-exercise-bodyweight" id="wphealthtracker-response-form-input-text-setrep-bodyweight-' . $key2 . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
												<label>' . $this->translations->exercise_trans_38 . '</label>
											</div>
											</div>
											<div class="wphealthtracker-response-form-exercise-innerrow-div">
												<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-reps" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->exercise_trans_16 . '</p>
												<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-setrep-reps-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
											</div>
											<div class="wphealthtracker-response-form-exercise-innerrow-div">
												<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-set-measure" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_23 . '</p>
												<select class="wphealthtracker-response-form-select" id="wphealthtracker-response-form-input-select-setrep-measurement-' . $key . '-' . $loop_num . '">
													<option>' . $this->translations->d3_trans_19 . '</option>
													<option>' . $this->translations->d3_trans_18 . '</option>
												</select>
											</div>
											</div>
										<div class="wphealthtracker-response-form-exercise-set-addition-div" id="wphealthtracker-response-form-exercise-set-addition-div-' . $loop_num . '" data-date="' . $this->humandate . '" data-key="' . $key . '" data-setkey="1" data-setkey="1" data-loopnum="' . $loop_num . '" data-exercisenum="0" data-idnum="' . $loop_num . '" data-id-to-add-after="wphealthtracker-response-form-exercise-shaded-container-' . ( $key + 1 ) . '-' . $loop_num . '">
										<p class="wphealthtracker-response-form-exercise-set-addition-p">' . $this->translations->exercise_trans_18 . '</p><img class="wphealthtracker-response-form-row-add-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'web-site.svg" />
										</div>';

						$final_exercise_string = $final_exercise_string . '
						<div class="wphealthtracker-response-form-all-data-row-parent" id="wphealthtracker-response-form-all-data-row-parent-' . $key . '-' . $loop_num . '">
						<div class="wphealthtracker-response-form-exercise-all-data-row" ' . $data_section . ' id="wphealthtracker-response-form-all-data-row-1" data-open="true" style="opacity: 1;">
							<div class="wphealthtracker-response-form-exercise-shaded-container-title">
								<h3><img class="wphealthtracker-icon-h2-image-exercise" data-label="exercise-weight" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'exercise.svg"> ' . $this->translations->tab_title_6 . ' #<span class="wphealthtracker-exercise-item-span">' . ( $key + 2 ) . '</span> - ' . $this->humandate . '</h3>
							</div>
							<div class="wphealthtracker-expand-minimize-div-all-data">
								<p class="wphealthtracker-expand-minimize-p" id="wphealthtracker-expand-minimize-p-enter" style="opacity: 1;">' . $this->translations->common_trans_1 . '</p>
								<img src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'rotate.svg" class="wphealthtracker-indiv-choice-img-rotate" id="wphealthtracker-indiv-choice-img-rotate-enter">
							</div>
						</div>
						<div class="wphealthtracker-response-form-exercise-shaded-container" id="wphealthtracker-response-form-exercise-shaded-container-' . ( $key + 1 ) . '-' . $loop_num . '" style="height: 638px;">
								<div class="wphealthtracker-response-form-data-row-exercise-inner-cont">
									' . $this->output_exercise_enter_and_view_top_filter() . '
									<div class="wphealthtracker-response-form-data-row-exercise" id="wphealthtracker-response-form-exercise-item-row-div-' . $key . '-' . $loop_num . '">
										<div class="wphealthtracker-response-form-exercise-row-div-cal-pro">
											<div class="wphealthtracker-response-form-exercise-innerrow-div">
												<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-name" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->exercise_trans_7 . '</p>
												<input type="text" class="wphealthtracker-response-form-input-text wphealthtracker-response-form-input-text-exercise" id="wphealthtracker-response-form-input-text-exercise-name-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
											</div>
											<div class="wphealthtracker-response-form-exercise-innerrow-div">
												<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-type" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->exercise_trans_8 . '</p>
												<select class="wphealthtracker-response-form-select" id="wphealthtracker-response-form-input-select-exercise-type-' . $key . '-' . $loop_num . '">
													' . $exercisetype . '
												</select>
											</div>
											<div class="wphealthtracker-response-form-exercise-innerrow-div">
												<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-time" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->exercise_trans_13 . '</p>
												<input ' . $time_input . ' class="wphealthtracker-response-form-input-time wphealthtracker-response-form-input-time-exercise" id="wphealthtracker-response-form-input-time-exercise-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
											</div>
										</div>
									</div>
									<div class="wphealthtracker-response-form-data-row-exercise" id="wphealthtracker-response-form-exercise-item-row-div-' . $key . '-' . $loop_num . '">
										<div class="wphealthtracker-response-form-exercise-row-div-cal-pro">
											<div class="wphealthtracker-response-form-exercise-innerrow-div">
												<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-time" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->exercise_trans_14 . '</p>
												<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-energy-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
											</div>
											<div class="wphealthtracker-response-form-exercise-innerrow-div">
												<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-time-measure" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_23 . '</p>
												<select class="wphealthtracker-response-form-select" id="wphealthtracker-response-form-input-select-exercise-type-' . $key . '-' . $loop_num . '">
													' . $exerdurmeasure . '
												</select>
											</div>

											<div class="wphealthtracker-response-form-exercise-innerrow-div">
												<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-distance" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->exercise_trans_15 . '</p>
												<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-energy-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
											</div>
											<div class="wphealthtracker-response-form-exercise-innerrow-div">
												<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-distance-measure" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_23 . '</p>
												<select class="wphealthtracker-response-form-select" id="wphealthtracker-response-form-input-select-exercise-type-' . $key . '-' . $loop_num . '">
													' . $distancemeasure . '
												</select>
											</div>
										</div>
									</div>
									<div class="wphealthtracker-response-form-data-row-exercise" id="wphealthtracker-response-form-exercise-protein-row-div-' . $key . '-' . $loop_num . '">
										<div class="wphealthtracker-response-form-exercise-row-div-cal-pro">
											<div class="wphealthtracker-response-form-exercise-innerrow-div wphealthtracker-response-form-exercise-innerrow-div-select-2">
												<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-muscle-groups" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->exercise_trans_19 . '</p>
												<select class="wphealthtracker-response-form-select select2-input" id="select2-upsells" name="musclegroups[]" multiple="multiple">
													' . $muscles . '
												</select>
											</div>
										</div>
									</div>
									<div class="wphealthtracker-response-form-data-row-exercise" id="wphealthtracker-response-form-exercise-calories-row-div-' . $key . '-' . $loop_num . '">
										<div class="wphealthtracker-response-form-exercise-row-div-cal-pro">
											' . $sets_html . '
										</div>
									</div>
									' . $this->output_exercise_enter_and_view_bottom_filter() . '
									<div class="wphealthtracker-response-form-data-row-exercise" id="wphealthtracker-response-form-exercise-image-row-div-' . $key . '-' . $loop_num . '">
										<div class="wphealthtracker-response-form-exercise-row-div-cal-pro">
											<div class="wphealthtracker-response-form-exercise-innerrow-div">
												<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_28 . '</p>
												<input type="text" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-image-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" placeholder="' . $this->translations->common_trans_28 . '"/>
											</div>
											<div class="wphealthtracker-response-form-exercise-innerrow-div">
												<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-image-button" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_28 . '</p>
												<button class="wphealthtracker-response-form-input-button wphealthtracker-response-form-input-button-image-upload" id="wphealthtracker-response-form-input-button-image-upload-' . $key . '-' . $loop_num . '">' . $this->translations->common_trans_30 . '</button>
											</div>
										</div>
									</div>
									<div class="wphealthtracker-response-form-data-row-exercise" id="wphealthtracker-response-form-exercise-file-row-div-' . $key . '-' . $loop_num . '">
										<div class="wphealthtracker-response-form-exercise-row-div-cal-pro">
											<div class="wphealthtracker-response-form-exercise-innerrow-div">
												<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-file" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_32 . '</p>
												<input type="text" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-file-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"placeholder="' . $this->translations->common_trans_32 . '"/>
											</div>
											<div class="wphealthtracker-response-form-exercise-innerrow-div">
												<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-file-button" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_33 . '</p>
												<button class="wphealthtracker-response-form-input-button wphealthtracker-response-form-input-button-file-upload" id="wphealthtracker-response-form-input-button-file-upload-' . $key . '-' . $loop_num . '">' . $this->translations->common_trans_34 . '</button>
											</div>
										</div>
									</div>
									' . $duplicate_string . '
									' . $removal_string . '
								</div>
							</div>
						</div>';
					}
				// If there is only ONE exercise entry on this date...
				} else {

					$exerciseitem    = '';
					$time            = '0:00';
					$duration        = '';
					$distance        = '';
					$distancemeasure = '';
					$exercisetype    = '';
					$exerdurmeasure  = '';
					$musclegroups    = '';
					$totalweightreps = '';
					$imageurl        = '';
					$fileurl         = '';

					$heightstring = '';
					if ( '' === $this->exercisestring ) {
						$heightstring = 'style="height:638px;"';
					}

					$exercisesplit = explode( ';', $this->exercisestring );

					if ( count( $exercisesplit ) > 0 ) {
						$exerciseitem = $exercisesplit[0];
					}

					if ( count( $exercisesplit ) > 1 ) {
						$exercisetype = $exercisesplit[1];
					}

					if ( count( $exercisesplit ) > 2 ) {
						$time = $exercisesplit[2];
					}

					if ( count( $exercisesplit ) > 3 ) {
						$duration = $exercisesplit[3];
					}

					if ( count( $exercisesplit ) > 4 ) {
						$exerdurmeasure = $exercisesplit[4];
					}

					if ( count( $exercisesplit ) > 5 ) {
						$distance = $exercisesplit[5];
					}

					if ( count( $exercisesplit ) > 6 ) {
						$distancemeasure = $exercisesplit[6];
					}

					if ( count( $exercisesplit ) > 7 ) {
						$musclegroups = $exercisesplit[7];
					}

					if ( count( $exercisesplit ) > 8 ) {
						$totalweightreps = $exercisesplit[8];
					}

					if ( count( $exercisesplit ) > 9 ) {
						$imageurl = $exercisesplit[9];
					}

					if ( count( $exercisesplit ) > 10 ) {
						$fileurl = $exercisesplit[10];
					}

					// Build the Options for the Exercise Type Select.
					if ( $exercisetype === $this->translations->exercise_trans_9 ) {
						$exercisetype =
						'<option selected>' . $this->translations->exercise_trans_9 . '</option>
						<option>' . $this->translations->exercise_trans_10 . '</option>
						<option>' . $this->translations->exercise_trans_11 . '</option>
						<option>' . $this->translations->exercise_trans_12 . '</option>
						<option>' . $this->translations->common_trans_37 . '</option>
						<option>' . $this->translations->common_trans_47 . '</option>';
					} elseif ( $exercisetype === $this->translations->exercise_trans_10 ) {
						$exercisetype =
					'<option>' . $this->translations->exercise_trans_9 . '</option>
						<option selected>' . $this->translations->exercise_trans_10 . '</option>
						<option>' . $this->translations->exercise_trans_11 . '</option>
						<option>' . $this->translations->exercise_trans_12 . '</option>
						<option>' . $this->translations->common_trans_37 . '</option>
						<option>' . $this->translations->common_trans_47 . '</option>';
					} elseif ( $exercisetype === $this->translations->exercise_trans_11 ) {
						$exercisetype =
						'<option>' . $this->translations->exercise_trans_9 . '</option>
						<option>' . $this->translations->exercise_trans_10 . '</option>
						<option selected>' . $this->translations->exercise_trans_11 . '</option>
						<option>' . $this->translations->exercise_trans_12 . '</option>
						<option>' . $this->translations->common_trans_37 . '</option>
						<option>' . $this->translations->common_trans_47 . '</option>';
					} elseif ( $exercisetype === $this->translations->exercise_trans_12 ) {
						$exercisetype =
						'<option>' . $this->translations->exercise_trans_9 . '</option>
						<option>' . $this->translations->exercise_trans_10 . '</option>
						<option>' . $this->translations->exercise_trans_11 . '</option>
						<option selected>' . $this->translations->exercise_trans_12 . '</option>
						<option>' . $this->translations->common_trans_37 . '</option>
						<option>' . $this->translations->common_trans_47 . '</option>';
					} elseif ( $exercisetype === $this->translations->common_trans_37 ) {
						$exercisetype =
						'<option>' . $this->translations->exercise_trans_9 . '</option>
						<option>' . $this->translations->exercise_trans_10 . '</option>
						<option>' . $this->translations->exercise_trans_11 . '</option>
						<option>' . $this->translations->exercise_trans_12 . '</option>
						<option  selected>' . $this->translations->common_trans_37 . '</option>
						<option>' . $this->translations->common_trans_47 . '</option>';
					} elseif ( $exercisetype === $this->translations->common_trans_47 ) {
						$exercisetype =
						'<option>' . $this->translations->exercise_trans_9 . '</option>
						<option>' . $this->translations->exercise_trans_10 . '</option>
						<option>' . $this->translations->exercise_trans_11 . '</option>
						<option>' . $this->translations->exercise_trans_12 . '</option>
						<option>' . $this->translations->common_trans_37 . '</option>
						<option  selected>' . $this->translations->common_trans_47 . '</option>';
					} else {
						$exercisetype =
						'<option>' . $this->translations->exercise_trans_9 . '</option>
						<option>' . $this->translations->exercise_trans_10 . '</option>
						<option>' . $this->translations->exercise_trans_11 . '</option>
						<option>' . $this->translations->exercise_trans_12 . '</option>
						<option>' . $this->translations->common_trans_37 . '</option>
						<option>' . $this->translations->common_trans_47 . '</option>';
					}

					// Build the Options for the Exercise Duration Select.
					if ( $exerdurmeasure === $this->translations->common_trans_48 ) {
						$exerdurmeasure =
						'<option selected>' . $this->translations->common_trans_48 . '</option>
						<option>' . $this->translations->common_trans_49 . '</option>
						<option>' . $this->translations->common_trans_50 . '</option>';
					} elseif ( $exerdurmeasure === $this->translations->common_trans_49 ) {
						$exerdurmeasure =
						'<option>' . $this->translations->common_trans_48 . '</option>
						<option selected>' . $this->translations->common_trans_49 . '</option>
						<option>' . $this->translations->common_trans_50 . '</option>';
					} elseif ( $exerdurmeasure === $this->translations->common_trans_50 ) {
						$exerdurmeasure =
						'<option>' . $this->translations->common_trans_48 . '</option>
						<option>' . $this->translations->common_trans_49 . '</option>
						<option selected>' . $this->translations->common_trans_50 . '</option>';
					} else {
						$exerdurmeasure =
						'<option>' . $this->translations->common_trans_48 . '</option>
						<option>' . $this->translations->common_trans_49 . '</option>
						<option>' . $this->translations->common_trans_50 . '</option>';
					}

					// Build the Options for the Distance Travelled Select.
					if ( $distancemeasure === $this->translations->common_trans_51 ) {
						$distancemeasure =
						'<option selected>' . $this->translations->common_trans_51 . '</option>
						<option>' . $this->translations->common_trans_52 . '</option>
						<option>' . $this->translations->common_trans_53 . '</option>
						<option>' . $this->translations->common_trans_54 . '</option>
						<option>' . $this->translations->common_trans_55 . '</option>';
					} elseif ( $distancemeasure === $this->translations->common_trans_52 ) {
						$distancemeasure =
						'<option>' . $this->translations->common_trans_51 . '</option>
						<option selected>' . $this->translations->common_trans_52 . '</option>
						<option>' . $this->translations->common_trans_53 . '</option>
						<option>' . $this->translations->common_trans_54 . '</option>
						<option>' . $this->translations->common_trans_55 . '</option>';
					} elseif ( $distancemeasure === $this->translations->common_trans_53 ) {
						$distancemeasure =
						'<option>' . $this->translations->common_trans_51 . '</option>
						<option>' . $this->translations->common_trans_52 . '</option>
						<option selected>' . $this->translations->common_trans_53 . '</option>
						<option>' . $this->translations->common_trans_54 . '</option>
						<option>' . $this->translations->common_trans_55 . '</option>';
					} elseif ( $distancemeasure === $this->translations->common_trans_54 ) {
						$distancemeasure =
						'<option>' . $this->translations->common_trans_51 . '</option>
						<option>' . $this->translations->common_trans_52 . '</option>
						<option>' . $this->translations->common_trans_53 . '</option>
						<option selected>' . $this->translations->common_trans_54 . '</option>
						<option>' . $this->translations->common_trans_55 . '</option>';
					} elseif ( $distancemeasure === $this->translations->common_trans_55 ) {
						$distancemeasure =
						'<option>' . $this->translations->common_trans_51 . '</option>
						<option>' . $this->translations->common_trans_52 . '</option>
						<option>' . $this->translations->common_trans_53 . '</option>
						<option>' . $this->translations->common_trans_54 . '</option>
						<option selected>' . $this->translations->common_trans_55 . '</option>';
					} else {
						$distancemeasure =
						'<option>' . $this->translations->common_trans_51 . '</option>
						<option>' . $this->translations->common_trans_52 . '</option>
						<option>' . $this->translations->common_trans_53 . '</option>
						<option>' . $this->translations->common_trans_54 . '</option>
						<option>' . $this->translations->common_trans_55 . '</option>';
					}

					// Builidng all Sets/Reps/Weight HTML.
					$set_loop_num = 0;
					if ( stripos( $totalweightreps, '//' ) !== false ) {

						$totalweightrepsarray = explode( '//', $totalweightreps );

						$sets_html = '';
						foreach ( $totalweightrepsarray as $key2 => $set ) {

							$sets_removal_string = '';
							if ( 0 !== $key2 ) {
								$sets_removal_string = '<div class="wphealthtracker-response-form-exercise-set-removal-div"><p>' . $this->translations->common_trans_41 . '</p><img class="wphealthtracker-response-form-set-removal-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'garbage.svg" /></div>';
							}

							$set_loop_num = $key2;

							$weight      = '';
							$bodyweight  = 'false';
							$reps        = '';
							$measurement = $this->translations->d3_trans_19;
							if ( stripos( $set, '/' ) !== false ) {

								$set_array = explode( '/', $set );

								if ( array_key_exists( 0, $set_array ) ) {
									$weight = $set_array[0];
								}

								if ( array_key_exists( 1, $set_array ) ) {
									$bodyweight = $set_array[1];
								}

								if ( array_key_exists( 2, $set_array ) ) {
									$reps = $set_array[2];
								}

								if ( array_key_exists( 3, $set_array ) ) {
									$measurement = $set_array[3];
								}
							}

							// Creating the checked attribute.
							$bodyweight_checked = '';
							$weight_disabled    = '';
							if ( 'true' === $bodyweight ) {
								$bodyweight_checked = 'checked="true"';
								$weight_disabled    = 'disabled';
							}

							// Build the Options for the Sets weight measurement Select.
							if ( $measurement === $this->translations->d3_trans_19 ) {
								$setweightmeasure =
								'<option selected>' . $this->translations->d3_trans_19 . '</option>
								<option>' . $this->translations->d3_trans_18 . '</option>';
							} elseif ( $measurement === $this->translations->d3_trans_18 ) {
								$setweightmeasure =
								'<option>' . $this->translations->d3_trans_19 . '</option>
								<option selected>' . $this->translations->d3_trans_18 . '</option>';
							} else {
								$setweightmeasure =
								'<option>' . $this->translations->d3_trans_19 . '</option>
								<option>' . $this->translations->d3_trans_18 . '</option>';
							}

							$sets_html = $sets_html . '
							<div class="wphealthtracker-response-form-exercise-set-div"><p class="wphealthtracker-response-form-exercise-set-label">' . $this->translations->exercise_trans_17 . ' #' . ( $key2 + 1 ) . '</p><div class="wphealthtracker-response-form-exercise-innerrow-div wphealthtracker-response-form-exercise-innerrow-div-bodyweight-special">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-weight" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->d3_trans_40 . '</p>
											<input ' . $weight_disabled . ' type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-setrep-weight-' . $key2 . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" value="' . $weight . '"/>
											<div class="wphealthtracker-response-form-input-checkbox-div">
												<input ' . $bodyweight_checked . ' type="checkbox" class="wphealthtracker-response-form-input-checkbox wphealthtracker-response-form-input-checkbox-exercise-bodyweight" id="wphealthtracker-response-form-input-text-setrep-bodyweight-' . $key2 . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
												<label>' . $this->translations->exercise_trans_38 . '</label>
											</div>
										</div>
										<div class="wphealthtracker-response-form-exercise-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-reps" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->exercise_trans_16 . '</p>
											<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-setrep-reps-' . $key2 . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" value="' . $reps . '"/>
										</div>
										<div class="wphealthtracker-response-form-exercise-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-set-measure" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_23 . '</p>
											<select class="wphealthtracker-response-form-select" id="wphealthtracker-response-form-input-select-setrep-measurement-' . $key2 . '-' . $loop_num . '">
												' . $setweightmeasure . '
											</select>
										</div>
										' . $sets_removal_string . '
									</div>';
						}
					} else {
						$sets_html = '
						<div class="wphealthtracker-response-form-exercise-set-div"><p class="wphealthtracker-response-form-exercise-set-label">' . $this->translations->exercise_trans_17 . ' #1</p><div class="wphealthtracker-response-form-exercise-innerrow-div wphealthtracker-response-form-exercise-innerrow-div-bodyweight-special">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-weight" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->d3_trans_40 . '</p>
											<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-setrep-weight-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
											<div class="wphealthtracker-response-form-input-checkbox-div">
												<input type="checkbox" class="wphealthtracker-response-form-input-checkbox wphealthtracker-response-form-input-checkbox-exercise-bodyweight" id="wphealthtracker-response-form-input-text-setrep-bodyweight-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
												<label>' . $this->translations->exercise_trans_38 . '</label>
											</div>
										</div>
										<div class="wphealthtracker-response-form-exercise-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-reps" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->exercise_trans_16 . '</p>
											<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-setrep-reps-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
										</div>
										<div class="wphealthtracker-response-form-exercise-innerrow-div">
											<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-set-measure" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_23 . '</p>
											<select class="wphealthtracker-response-form-select" id="wphealthtracker-response-form-input-select-setrep-measurement-' . $key . '-' . $loop_num . '">
												<option>' . $this->translations->d3_trans_19 . '</option>
												<option>' . $this->translations->d3_trans_18 . '</option>
											</select>
										</div>
									</div>';
					}

					// Appending the 'Add a Set' Div to the $sets_html.
					$sets_html = $sets_html .
						'<div class="wphealthtracker-response-form-exercise-set-addition-div" id="wphealthtracker-response-form-exercise-set-addition-div-' . $loop_num . '" data-date="' . $this->humandate . '" data-key="' . $key . '" data-setkey="' . ( $set_loop_num + 1 ) . '" data-loopnum="' . $loop_num . '" data-exercisenum="0" data-idnum="' . $loop_num . '" data-id-to-add-after="wphealthtracker-response-form-exercise-shaded-container-' . $key . '-' . $loop_num . '">
							<p class="wphealthtracker-response-form-exercise-set-addition-p">' . $this->translations->exercise_trans_18 . '</p><img class="wphealthtracker-response-form-row-add-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'web-site.svg" />
						</div>';

					// Now building the Options string of all the muscles.
					$muscles                   = '';
					$muscle_translations_array = array(
						$this->translations->exercise_trans_20,
						$this->translations->exercise_trans_21,
						$this->translations->exercise_trans_22,
						$this->translations->exercise_trans_23,
						$this->translations->exercise_trans_24,
						$this->translations->exercise_trans_25,
						$this->translations->exercise_trans_26,
						$this->translations->exercise_trans_27,
						$this->translations->exercise_trans_28,
						$this->translations->exercise_trans_29,
						$this->translations->exercise_trans_30,
						$this->translations->exercise_trans_31,
						$this->translations->exercise_trans_32,
						$this->translations->exercise_trans_33,
						$this->translations->exercise_trans_34,
						$this->translations->exercise_trans_35,
						$this->translations->exercise_trans_36,
						$this->translations->exercise_trans_37,
					);

					// If we have more than one saved Muscle Group data.
					if ( stripos( $musclegroups, '/' ) !== false ) {
						$musclegroupsarray = explode( '/', $musclegroups );

						$foundmatch = false;
						foreach ( $muscle_translations_array as $transkey => $transvalue ) {

							foreach ( $musclegroupsarray as $selectkey => $selectvalue ) {
								if ( $transvalue === $selectvalue ) {
									$muscles    = $muscles . '<option selected>' . $transvalue . '</option>';
									$foundmatch = true;
								}
							}

							if ( ! $foundmatch ) {
								$muscles = $muscles . '<option>' . $transvalue . '</option>';
							} else {
								$foundmatch = false;
							}
						}

					// If we have one saved Muscle Group.
					} elseif ( '' !== $musclegroups ) {
						$foundmatch = false;
						foreach ( $muscle_translations_array as $transkey => $transvalue ) {

							if ( $transvalue === $musclegroups ) {
								$muscles = $muscles . '<option selected>' . $transvalue . '</option>';
							} else {
								$muscles = $muscles . '<option>' . $transvalue . '</option>';
							}
						}

					// If there are no saved Muscle Groups at all.
					} else {
						foreach ( $muscle_translations_array as $transkey => $transvalue ) {
							$muscles = $muscles . '<option>' . $transvalue . '</option>';
						}
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
						$removal_string = '<div class="wphealthtracker-response-form-exercise-row-removal-div" data-id-to-update="' . $loop_num . '" data-id-to-remove="wphealthtracker-response-form-all-data-row-parent-' . $key . '-' . $loop_num . '"><p>' . $this->translations->common_trans_41 . '</p><img class="wphealthtracker-response-form-row-removal-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'garbage.svg" /></div>';
					}

					$duplicate_string = '
					<div class="wphealthtracker-response-form-exercise-row-duplicate-div" data-date="' . $this->humandate . '" data-key="' . $key . '" data-loopnum="' . $loop_num . '" data-idnum="' . $loop_num . '" data-id-to-update="' . $loop_num . '" data-id-to-add-after="wphealthtracker-response-form-all-data-row-parent-' . $key . '-' . $loop_num . '"><p>' . $this->translations->common_trans_40 . '</p><img class="wphealthtracker-response-form-row-removal-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'duplicate.svg" />
					</div>';

					// Now put together the final HTML that the user will see and interact with .
					$final_exercise_string = $final_exercise_string . '
					<div class="wphealthtracker-response-form-all-data-row-parent" id="wphealthtracker-response-form-all-data-row-parent-' . $key . '-' . $loop_num . '">
					<div class="wphealthtracker-response-form-exercise-all-data-row" ' . $data_section . ' id="wphealthtracker-response-form-all-data-row-1" data-open="true" style="opacity: 1;">
						<div class="wphealthtracker-response-form-exercise-shaded-container-title">
							<h3><img class="wphealthtracker-icon-h2-image-exercise" data-label="exercise-weight" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'exercise.svg"> ' . $this->translations->tab_title_6 . ' #<span class="wphealthtracker-exercise-item-span">' . ( $key + 1 ) . '</span> - ' . $this->humandate . '</h3>
						</div>
						<div class="wphealthtracker-expand-minimize-div-all-data">
							<p class="wphealthtracker-expand-minimize-p" id="wphealthtracker-expand-minimize-p-enter" style="opacity: 1;">' . $this->translations->common_trans_1 . '</p>
							<img src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'rotate.svg" class="wphealthtracker-indiv-choice-img-rotate" id="wphealthtracker-indiv-choice-img-rotate-enter">
						</div>
					</div>
					<div class="wphealthtracker-response-form-exercise-shaded-container" id="wphealthtracker-response-form-exercise-shaded-container-' . $key . '-' . $loop_num . '" ' . $heightstring . '>
						<div class="wphealthtracker-response-form-data-row-exercise-inner-cont">
							' . $this->output_exercise_enter_and_view_top_filter() . '
							<div class="wphealthtracker-response-form-data-row-exercise" id="wphealthtracker-response-form-exercise-item-row-div-' . $key . '-' . $loop_num . '">
								<div class="wphealthtracker-response-form-exercise-row-div-cal-pro">
									<div class="wphealthtracker-response-form-exercise-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-name" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->exercise_trans_7 . '</p>
										<input type="text" class="wphealthtracker-response-form-input-text wphealthtracker-response-form-input-text-exercise" id="wphealthtracker-response-form-input-text-exercise-name-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" value="' . $exerciseitem . '"/>
									</div>
									<div class="wphealthtracker-response-form-exercise-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-type" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->exercise_trans_8 . '</p>
										<select class="wphealthtracker-response-form-select" id="wphealthtracker-response-form-input-select-exercise-type-' . $key . '-' . $loop_num . '">
											' . $exercisetype . '
										</select>
									</div>
									<div class="wphealthtracker-response-form-exercise-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-time" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->exercise_trans_13 . '</p>
										<input ' . $time_input . ' class="wphealthtracker-response-form-input-time wphealthtracker-response-form-input-time-exercise" id="wphealthtracker-response-form-input-time-exercise-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" value="' . $time . '"/>
									</div>
								</div>
							</div>
							<div class="wphealthtracker-response-form-data-row-exercise" id="wphealthtracker-response-form-exercise-item-row-div-' . $key . '-' . $loop_num . '">
								<div class="wphealthtracker-response-form-exercise-row-div-cal-pro">
									<div class="wphealthtracker-response-form-exercise-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-time" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->exercise_trans_14 . '</p>
										<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-energy-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" value="' . $duration . '"/>
									</div>
									<div class="wphealthtracker-response-form-exercise-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-time-measure" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_23 . '</p>
										<select class="wphealthtracker-response-form-select" id="wphealthtracker-response-form-input-select-exercise-type-' . $key . '-' . $loop_num . '">
											' . $exerdurmeasure . '
										</select>
									</div>

									<div class="wphealthtracker-response-form-exercise-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-distance" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->exercise_trans_15 . '</p>
										<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-energy-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" value="' . $distance . '"/>
									</div>
									<div class="wphealthtracker-response-form-exercise-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-distance-measure" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_23 . '</p>
										<select class="wphealthtracker-response-form-select" id="wphealthtracker-response-form-input-select-exercise-type-' . $key . '-' . $loop_num . '">
											' . $distancemeasure . '
										</select>
									</div>
								</div>
							</div>
							<div class="wphealthtracker-response-form-data-row-exercise" id="wphealthtracker-response-form-exercise-protein-row-div-' . $key . '-' . $loop_num . '">
								<div class="wphealthtracker-response-form-exercise-row-div-cal-pro">
									<div class="wphealthtracker-response-form-exercise-innerrow-div wphealthtracker-response-form-exercise-innerrow-div-select-2">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-muscle-groups" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->exercise_trans_19 . '</p>
										<select class="wphealthtracker-response-form-select select2-input" id="select2-upsells" name="musclegroups[]" multiple="multiple">
											' . $muscles . '
										</select>
									</div>
								</div>
							</div>
							<div class="wphealthtracker-response-form-data-row-exercise" id="wphealthtracker-response-form-exercise-calories-row-div-' . $key . '-' . $loop_num . '">
								<div class="wphealthtracker-response-form-exercise-row-div-cal-pro">
									' . $sets_html . '
								</div>
							</div>
							' . $this->output_exercise_enter_and_view_bottom_filter() . '
							<div class="wphealthtracker-response-form-data-row-exercise" id="wphealthtracker-response-form-exercise-image-row-div-' . $key . '-' . $loop_num . '">
								<div class="wphealthtracker-response-form-exercise-row-div-cal-pro">
									<div class="wphealthtracker-response-form-exercise-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_28 . '</p>
										<input type="text" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-image-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" value="' . $imageurl . '" placeholder="' . $this->translations->common_trans_28 . '"/>
									</div>
									<div class="wphealthtracker-response-form-exercise-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-image-button" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_28 . '</p>
										<button class="wphealthtracker-response-form-input-button wphealthtracker-response-form-input-button-image-upload" id="wphealthtracker-response-form-input-button-image-upload-' . $key . '-' . $loop_num . '">' . $this->translations->common_trans_30 . '</button>
									</div>
								</div>
							</div>
							<div class="wphealthtracker-response-form-data-row-exercise" id="wphealthtracker-response-form-exercise-file-row-div-' . $key . '-' . $loop_num . '">
								<div class="wphealthtracker-response-form-exercise-row-div-cal-pro">
									<div class="wphealthtracker-response-form-exercise-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-file" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_32 . '</p>
										<input type="text" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-file-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" value="' . $fileurl . '" placeholder="' . $this->translations->common_trans_32 . '"/>
									</div>
									<div class="wphealthtracker-response-form-exercise-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-file-button" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_33 . '</p>
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

					// Now output a blank and open form for the user to add a new exercise item, if we're dealing with Today's data - if not, user can add additional exercise items to previous days by using the 'Add a row' circle image button thing.
					if ( 'today' === $type && '' !== $this->exercisestring ) {

						$duplicate_string = '
						<div class="wphealthtracker-response-form-exercise-row-duplicate-div" data-date="' . $this->humandate . '" data-key="' . ( $key + 1 ) . '" data-loopnum="' . $loop_num . '" data-idnum="' . $loop_num . '" data-id-to-update="' . $loop_num . '" data-id-to-add-after="wphealthtracker-response-form-all-data-row-parent-' . ( $key + 1 ) . '-' . $loop_num . '"><p>' . $this->translations->common_trans_40 . '</p><img class="wphealthtracker-response-form-row-removal-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'duplicate.svg" />
						</div>';

						$key++;

						$muscles = '';
						foreach ( $muscle_translations_array as $transkey => $transvalue ) {
							$muscles = $muscles . '<option>' . $transvalue . '</option>';
						}

						$exerdurmeasure =
							'<option>' . $this->translations->common_trans_48 . '</option>
							<option>' . $this->translations->common_trans_49 . '</option>
							<option>' . $this->translations->common_trans_50 . '</option>';

						$exercisetype =
							'<option>' . $this->translations->exercise_trans_9 . '</option>
							<option>' . $this->translations->exercise_trans_10 . '</option>
							<option>' . $this->translations->exercise_trans_11 . '</option>
							<option>' . $this->translations->exercise_trans_12 . '</option>
							<option>' . $this->translations->common_trans_37 . '</option>
							<option>' . $this->translations->common_trans_47 . '</option>';

						$distancemeasure =
							'<option>' . $this->translations->common_trans_51 . '</option>
							<option>' . $this->translations->common_trans_52 . '</option>
							<option>' . $this->translations->common_trans_53 . '</option>
							<option>' . $this->translations->common_trans_54 . '</option>
							<option>' . $this->translations->common_trans_55 . '</option>';

						$sets_html = '<div class="wphealthtracker-response-form-exercise-set-div"><p class="wphealthtracker-response-form-exercise-set-label">' . $this->translations->exercise_trans_17 . ' #1</p><div class="wphealthtracker-response-form-exercise-innerrow-div wphealthtracker-response-form-exercise-innerrow-div-bodyweight-special">
												<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-weight" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->d3_trans_40 . '</p>
												<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-setrep-weight-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
												<div class="wphealthtracker-response-form-input-checkbox-div">
													<input type="checkbox" class="wphealthtracker-response-form-input-checkbox wphealthtracker-response-form-input-checkbox-exercise-bodyweight" id="wphealthtracker-response-form-input-text-setrep-bodyweight-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
													<label>' . $this->translations->exercise_trans_38 . '</label>
												</div>
											</div>
											<div class="wphealthtracker-response-form-exercise-innerrow-div">
												<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-reps" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->exercise_trans_16 . '</p>
												<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-setrep-reps-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
											</div>
											<div class="wphealthtracker-response-form-exercise-innerrow-div">
												<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-set-measure" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_23 . '</p>
												<select class="wphealthtracker-response-form-select" id="wphealthtracker-response-form-input-select-setrep-measurement-' . $key . '-' . $loop_num . '">
													<option>' . $this->translations->d3_trans_19 . '</option>
													<option>' . $this->translations->d3_trans_18 . '</option>
												</select>
											</div>
											</div>
										<div class="wphealthtracker-response-form-exercise-set-addition-div" id="wphealthtracker-response-form-exercise-set-addition-div-' . $loop_num . '" data-date="' . $this->humandate . '" data-key="' . $key . '" data-setkey="1" data-setkey="1" data-loopnum="' . $loop_num . '" data-exercisenum="0" data-idnum="' . $loop_num . '" data-id-to-add-after="wphealthtracker-response-form-exercise-shaded-container-' . $key . '-' . $loop_num . '">
										<p class="wphealthtracker-response-form-exercise-set-addition-p">' . $this->translations->exercise_trans_18 . '</p><img class="wphealthtracker-response-form-row-add-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'web-site.svg" />
										</div>';

						$final_exercise_string = $final_exercise_string . '
						<div class="wphealthtracker-response-form-all-data-row-parent" id="wphealthtracker-response-form-all-data-row-parent-' . $key . '-' . $loop_num . '">
						<div class="wphealthtracker-response-form-exercise-all-data-row" ' . $data_section . ' id="wphealthtracker-response-form-all-data-row-1" data-open="true" style="opacity: 1;">
							<div class="wphealthtracker-response-form-exercise-shaded-container-title">
								<h3><img class="wphealthtracker-icon-h2-image-exercise" data-label="exercise-weight" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'exercise.svg"> ' . $this->translations->tab_title_6 . ' #<span class="wphealthtracker-exercise-item-span">' . ( $key + 1 ) . '</span> - ' . $this->humandate . '</h3>
							</div>
							<div class="wphealthtracker-expand-minimize-div-all-data">
								<p class="wphealthtracker-expand-minimize-p" id="wphealthtracker-expand-minimize-p-enter" style="opacity: 1;">' . $this->translations->common_trans_1 . '</p>
								<img src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'rotate.svg" class="wphealthtracker-indiv-choice-img-rotate" id="wphealthtracker-indiv-choice-img-rotate-enter">
							</div>
						</div>
						<div class="wphealthtracker-response-form-exercise-shaded-container" id="wphealthtracker-response-form-exercise-shaded-container-' . $key . '-' . $loop_num . '" style="height: 638px;">
								<div class="wphealthtracker-response-form-data-row-exercise-inner-cont">
									' . $this->output_exercise_enter_and_view_top_filter() . '
									<div class="wphealthtracker-response-form-data-row-exercise" id="wphealthtracker-response-form-exercise-item-row-div-' . $key . '-' . $loop_num . '">
										<div class="wphealthtracker-response-form-exercise-row-div-cal-pro">
											<div class="wphealthtracker-response-form-exercise-innerrow-div">
												<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-name" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->exercise_trans_7 . '</p>
												<input type="text" class="wphealthtracker-response-form-input-text wphealthtracker-response-form-input-text-exercise" id="wphealthtracker-response-form-input-text-exercise-name-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
											</div>
											<div class="wphealthtracker-response-form-exercise-innerrow-div">
												<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-type" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->exercise_trans_8 . '</p>
												<select class="wphealthtracker-response-form-select" id="wphealthtracker-response-form-input-select-exercise-type-' . $key . '-' . $loop_num . '">
													' . $exercisetype . '
												</select>
											</div>
											<div class="wphealthtracker-response-form-exercise-innerrow-div">
												<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-time" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->exercise_trans_13 . '</p>
												<input ' . $time_input . ' class="wphealthtracker-response-form-input-time wphealthtracker-response-form-input-time-exercise" id="wphealthtracker-response-form-input-time-exercise-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
											</div>
										</div>
									</div>
									<div class="wphealthtracker-response-form-data-row-exercise" id="wphealthtracker-response-form-exercise-item-row-div-' . $key . '-' . $loop_num . '">
										<div class="wphealthtracker-response-form-exercise-row-div-cal-pro">
											<div class="wphealthtracker-response-form-exercise-innerrow-div">
												<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-time" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->exercise_trans_14 . '</p>
												<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-energy-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
											</div>
											<div class="wphealthtracker-response-form-exercise-innerrow-div">
												<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-time-measure" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_23 . '</p>
												<select class="wphealthtracker-response-form-select" id="wphealthtracker-response-form-input-select-exercise-type-' . $key . '-' . $loop_num . '">
													' . $exerdurmeasure . '
												</select>
											</div>

											<div class="wphealthtracker-response-form-exercise-innerrow-div">
												<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-distance" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->exercise_trans_15 . '</p>
												<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-energy-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
											</div>
											<div class="wphealthtracker-response-form-exercise-innerrow-div">
												<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-distance-measure" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_23 . '</p>
												<select class="wphealthtracker-response-form-select" id="wphealthtracker-response-form-input-select-exercise-type-' . $key . '-' . $loop_num . '">
													' . $distancemeasure . '
												</select>
											</div>
										</div>
									</div>
									<div class="wphealthtracker-response-form-data-row-exercise" id="wphealthtracker-response-form-exercise-protein-row-div-' . $key . '-' . $loop_num . '">
										<div class="wphealthtracker-response-form-exercise-row-div-cal-pro">
											<div class="wphealthtracker-response-form-exercise-innerrow-div wphealthtracker-response-form-exercise-innerrow-div-select-2">
												<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-muscle-groups" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->exercise_trans_19 . '</p>
												<select class="wphealthtracker-response-form-select select2-input" id="select2-upsells" name="musclegroups[]" multiple="multiple">
													' . $muscles . '
												</select>
											</div>
										</div>
									</div>
									<div class="wphealthtracker-response-form-data-row-exercise" id="wphealthtracker-response-form-exercise-calories-row-div-' . $key . '-' . $loop_num . '">
										<div class="wphealthtracker-response-form-exercise-row-div-cal-pro">
											' . $sets_html . '
										</div>
									</div>
									' . $this->output_exercise_enter_and_view_bottom_filter() . '
									<div class="wphealthtracker-response-form-data-row-exercise" id="wphealthtracker-response-form-exercise-image-row-div-' . $key . '-' . $loop_num . '">
										<div class="wphealthtracker-response-form-exercise-row-div-cal-pro">
											<div class="wphealthtracker-response-form-exercise-innerrow-div">
												<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_28 . '</p>
												<input type="text" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-image-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" placeholder="' . $this->translations->common_trans_28 . '"/>
											</div>
											<div class="wphealthtracker-response-form-exercise-innerrow-div">
												<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-image-button" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_28 . '</p>
												<button class="wphealthtracker-response-form-input-button wphealthtracker-response-form-input-button-image-upload" id="wphealthtracker-response-form-input-button-image-upload-' . $key . '-' . $loop_num . '">' . $this->translations->common_trans_30 . '</button>
											</div>
										</div>
									</div>
									<div class="wphealthtracker-response-form-data-row-exercise" id="wphealthtracker-response-form-exercise-file-row-div-' . $key . '-' . $loop_num . '">
										<div class="wphealthtracker-response-form-exercise-row-div-cal-pro">
											<div class="wphealthtracker-response-form-exercise-innerrow-div">
												<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-file" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_32 . '</p>
												<input type="text" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-file-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"placeholder="' . $this->translations->common_trans_32 . '"/>
											</div>
											<div class="wphealthtracker-response-form-exercise-innerrow-div">
												<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-file-button" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_33 . '</p>
												<button class="wphealthtracker-response-form-input-button wphealthtracker-response-form-input-button-file-upload" id="wphealthtracker-response-form-input-button-file-upload-' . $key . '-' . $loop_num . '">' . $this->translations->common_trans_34 . '</button>
											</div>
										</div>
									</div>
									' . $duplicate_string . '
									<div class="wphealthtracker-response-form-exercise-row-removal-div" data-id-to-update="' . $loop_num . '" data-id-to-remove="wphealthtracker-response-form-all-data-row-parent-' . $key . '-' . $loop_num . '"><p>' . $this->translations->common_trans_41 . '</p><img class="wphealthtracker-response-form-row-removal-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'garbage.svg" /></div>
								</div>
							</div>
						</div>';
					}
				}

			// If there is NO Exercise data saved whatsoever, at all, output the completely new, fresh, blank form.
			} else {

				// Now building the Options string of all the muscles.
				$muscles                   = '';
				$muscle_translations_array = array(
					$this->translations->exercise_trans_20,
					$this->translations->exercise_trans_21,
					$this->translations->exercise_trans_22,
					$this->translations->exercise_trans_23,
					$this->translations->exercise_trans_24,
					$this->translations->exercise_trans_25,
					$this->translations->exercise_trans_26,
					$this->translations->exercise_trans_27,
					$this->translations->exercise_trans_28,
					$this->translations->exercise_trans_29,
					$this->translations->exercise_trans_30,
					$this->translations->exercise_trans_31,
					$this->translations->exercise_trans_32,
					$this->translations->exercise_trans_33,
					$this->translations->exercise_trans_34,
					$this->translations->exercise_trans_35,
					$this->translations->exercise_trans_36,
					$this->translations->exercise_trans_37,
				);

				foreach ( $muscle_translations_array as $transkey => $transvalue ) {
					$muscles = $muscles . '<option>' . $transvalue . '</option>';
				}

				$exerdurmeasure =
					'<option>' . $this->translations->common_trans_48 . '</option>
					<option>' . $this->translations->common_trans_49 . '</option>
					<option>' . $this->translations->common_trans_50 . '</option>';

				$exercisetype =
					'<option>' . $this->translations->exercise_trans_9 . '</option>
					<option>' . $this->translations->exercise_trans_10 . '</option>
					<option>' . $this->translations->exercise_trans_11 . '</option>
					<option>' . $this->translations->exercise_trans_12 . '</option>
					<option>' . $this->translations->common_trans_37 . '</option>
					<option>' . $this->translations->common_trans_47 . '</option>';

				$distancemeasure =
					'<option>' . $this->translations->common_trans_51 . '</option>
					<option>' . $this->translations->common_trans_52 . '</option>
					<option>' . $this->translations->common_trans_53 . '</option>
					<option>' . $this->translations->common_trans_54 . '</option>
					<option>' . $this->translations->common_trans_55 . '</option>';

				$sets_html = '<div class="wphealthtracker-response-form-exercise-set-div"><p class="wphealthtracker-response-form-exercise-set-label">' . $this->translations->exercise_trans_17 . ' #1</p><div class="wphealthtracker-response-form-exercise-innerrow-div wphealthtracker-response-form-exercise-innerrow-div-bodyweight-special">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-weight" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->d3_trans_40 . '</p>
										<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-setrep-weight-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
										<div class="wphealthtracker-response-form-input-checkbox-div">
											<input type="checkbox" class="wphealthtracker-response-form-input-checkbox wphealthtracker-response-form-input-checkbox-exercise-bodyweight" id="wphealthtracker-response-form-input-text-setrep-bodyweight-' . $key2 . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
											<label>' . $this->translations->exercise_trans_38 . '</label>
										</div>
									</div>
									<div class="wphealthtracker-response-form-exercise-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-reps" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->exercise_trans_16 . '</p>
										<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-setrep-reps-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
									</div>
									<div class="wphealthtracker-response-form-exercise-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-set-measure" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_23 . '</p>
										<select class="wphealthtracker-response-form-select" id="wphealthtracker-response-form-input-select-setrep-measurement-' . $key . '-' . $loop_num . '">
											<option>' . $this->translations->d3_trans_19 . '</option>
											<option>' . $this->translations->d3_trans_18 . '</option>
										</select>
									</div>
									</div>
								<div class="wphealthtracker-response-form-exercise-set-addition-div" id="wphealthtracker-response-form-exercise-set-addition-div-' . $loop_num . '" data-date="' . $this->humandate . '" data-key="' . $key . '" data-setkey="1" data-setkey="1" data-loopnum="' . $loop_num . '" data-exercisenum="0" data-idnum="' . $loop_num . '" data-id-to-add-after="wphealthtracker-response-form-exercise-shaded-container-' . $key . '-' . $loop_num . '">
								<p class="wphealthtracker-response-form-exercise-set-addition-p">' . $this->translations->exercise_trans_18 . '</p><img class="wphealthtracker-response-form-row-add-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'web-site.svg" />
								</div>';

				$final_exercise_string = '
				<div class="wphealthtracker-response-form-all-data-row-parent" id="wphealthtracker-response-form-all-data-row-parent-' . $key . '-' . $loop_num . '">
				<div class="wphealthtracker-response-form-exercise-all-data-row" ' . $data_section . ' id="wphealthtracker-response-form-all-data-row-1" data-open="true" style="opacity: 1;">
					<div class="wphealthtracker-response-form-exercise-shaded-container-title">
						<h3><img class="wphealthtracker-icon-h2-image-exercise" data-label="exercise-weight" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'exercise.svg"> ' . $this->translations->tab_title_6 . ' #<span class="wphealthtracker-exercise-item-span">' . ( $key + 1 ) . '</span> - ' . $this->humandate . '</h3>
					</div>
					<div class="wphealthtracker-expand-minimize-div-all-data">
						<p class="wphealthtracker-expand-minimize-p" id="wphealthtracker-expand-minimize-p-enter" style="opacity: 1;">' . $this->translations->common_trans_1 . '</p>
						<img src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'rotate.svg" class="wphealthtracker-indiv-choice-img-rotate" id="wphealthtracker-indiv-choice-img-rotate-enter">
					</div>
				</div>
				<div class="wphealthtracker-response-form-exercise-shaded-container" id="wphealthtracker-response-form-exercise-shaded-container-' . $key . '-' . $loop_num . '" style="height: 638px;">
						<div class="wphealthtracker-response-form-data-row-exercise-inner-cont">
							' . $this->output_exercise_enter_and_view_top_filter() . '
							<div class="wphealthtracker-response-form-data-row-exercise" id="wphealthtracker-response-form-exercise-item-row-div-' . $key . '-' . $loop_num . '">
								<div class="wphealthtracker-response-form-exercise-row-div-cal-pro">
									<div class="wphealthtracker-response-form-exercise-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-name" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->exercise_trans_7 . '</p>
										<input type="text" class="wphealthtracker-response-form-input-text wphealthtracker-response-form-input-text-exercise" id="wphealthtracker-response-form-input-text-exercise-name-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
									</div>
									<div class="wphealthtracker-response-form-exercise-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-type" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->exercise_trans_8 . '</p>
										<select class="wphealthtracker-response-form-select" id="wphealthtracker-response-form-input-select-exercise-type-' . $key . '-' . $loop_num . '">
											' . $exercisetype . '
										</select>
									</div>
									<div class="wphealthtracker-response-form-exercise-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-time" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->exercise_trans_13 . '</p>
										<input ' . $time_input . ' class="wphealthtracker-response-form-input-time wphealthtracker-response-form-input-time-exercise" id="wphealthtracker-response-form-input-time-exercise-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
									</div>
								</div>
							</div>
							<div class="wphealthtracker-response-form-data-row-exercise" id="wphealthtracker-response-form-exercise-item-row-div-' . $key . '-' . $loop_num . '">
								<div class="wphealthtracker-response-form-exercise-row-div-cal-pro">
									<div class="wphealthtracker-response-form-exercise-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-time" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->exercise_trans_14 . '</p>
										<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-energy-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
									</div>
									<div class="wphealthtracker-response-form-exercise-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-time-measure" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_23 . '</p>
										<select class="wphealthtracker-response-form-select" id="wphealthtracker-response-form-input-select-exercise-type-' . $key . '-' . $loop_num . '">
											' . $exerdurmeasure . '
										</select>
									</div>

									<div class="wphealthtracker-response-form-exercise-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-distance" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->exercise_trans_15 . '</p>
										<input type="number" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-energy-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"/>
									</div>
									<div class="wphealthtracker-response-form-exercise-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-distance-measure" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_23 . '</p>
										<select class="wphealthtracker-response-form-select" id="wphealthtracker-response-form-input-select-exercise-type-' . $key . '-' . $loop_num . '">
											' . $distancemeasure . '
										</select>
									</div>
								</div>
							</div>
							<div class="wphealthtracker-response-form-data-row-exercise" id="wphealthtracker-response-form-exercise-protein-row-div-' . $key . '-' . $loop_num . '">
								<div class="wphealthtracker-response-form-exercise-row-div-cal-pro">
									<div class="wphealthtracker-response-form-exercise-innerrow-div wphealthtracker-response-form-exercise-innerrow-div-select-2">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-muscle-groups" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->exercise_trans_19 . '</p>
										<select class="wphealthtracker-response-form-select select2-input" id="select2-upsells" name="musclegroups[]" multiple="multiple">
											' . $muscles . '
										</select>
									</div>
								</div>
							</div>
							<div class="wphealthtracker-response-form-data-row-exercise" id="wphealthtracker-response-form-exercise-calories-row-div-' . $key . '-' . $loop_num . '">
								<div class="wphealthtracker-response-form-exercise-row-div-cal-pro">
									' . $sets_html . '
								</div>
							</div>
							' . $this->output_exercise_enter_and_view_bottom_filter() . '
							<div class="wphealthtracker-response-form-data-row-exercise" id="wphealthtracker-response-form-exercise-image-row-div-' . $key . '-' . $loop_num . '">
								<div class="wphealthtracker-response-form-exercise-row-div-cal-pro">
									<div class="wphealthtracker-response-form-exercise-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_28 . '</p>
										<input type="text" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-image-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);" placeholder="' . $this->translations->common_trans_28 . '"/>
									</div>
									<div class="wphealthtracker-response-form-exercise-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-image-button" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_28 . '</p>
										<button class="wphealthtracker-response-form-input-button wphealthtracker-response-form-input-button-image-upload" id="wphealthtracker-response-form-input-button-image-upload-' . $key . '-' . $loop_num . '">' . $this->translations->common_trans_30 . '</button>
									</div>
								</div>
							</div>
							<div class="wphealthtracker-response-form-data-row-exercise" id="wphealthtracker-response-form-exercise-file-row-div-' . $key . '-' . $loop_num . '">
								<div class="wphealthtracker-response-form-exercise-row-div-cal-pro">
									<div class="wphealthtracker-response-form-exercise-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-file" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_32 . '</p>
										<input type="text" class="wphealthtracker-response-form-input-text" id="wphealthtracker-response-form-input-text-file-' . $key . '-' . $loop_num . '" style="border: 1px solid rgb(221, 221, 221);"placeholder="' . $this->translations->common_trans_32 . '"/>
									</div>
									<div class="wphealthtracker-response-form-exercise-innerrow-div">
										<p><img id="wphealthtracker-icon-image-question-id-3" class="wphealthtracker-icon-image-question-enter-view-exercise" data-label="exercise-file-button" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg">' . $this->translations->common_trans_33 . '</p>
										<button class="wphealthtracker-response-form-input-button wphealthtracker-response-form-input-button-file-upload" id="wphealthtracker-response-form-input-button-file-upload-' . $key . '-' . $loop_num . '">' . $this->translations->common_trans_34 . '</button>
									</div>
								</div>
							</div>
							<div class="wphealthtracker-response-form-exercise-row-duplicate-div" data-date="' . $this->humandate . '" data-key="' . ( $key + 1 ) . '" data-loopnum="' . $loop_num . '" data-idnum="' . $loop_num . '" data-id-to-update="' . $loop_num . '" data-id-to-add-after="wphealthtracker-response-form-all-data-row-parent-' . $key . '-' . $loop_num . '"><p>' . $this->translations->common_trans_40 . '</p><img class="wphealthtracker-response-form-row-removal-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'duplicate.svg" />
							</div>
						</div>
					</div>
				</div>';
			}

			if ( 'today' === $type ) {
				$next_exercise = $key + 1;
				$class_name    = 'wphealthtracker-response-form-exercise-row-addition-p-enter';
			} else {
				$next_exercise = $key;
				$class_name    = 'wphealthtracker-response-form-exercise-row-addition-p-view';
			}

			return $final_exercise_string = $final_exercise_string . '<div class="wphealthtracker-response-form-exercise-row-addition-div" id="wphealthtracker-response-form-exercise-row-addition-div-' . $loop_num . '" data-date="' . $this->humandate . '" data-key="' . $next_exercise . '" data-loopnum="' . $loop_num . '" data-exercisenum="0" data-idnum="' . $loop_num . '" data-id-to-add-after="wphealthtracker-response-form-addexercise-row-div-' . $key . '-' . $loop_num . '">
						<p class="' . $class_name . '">' . $this->translations->exercise_trans_4 . '</p><img class="wphealthtracker-response-form-row-add-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'web-site.svg" />
					</div>
				';
		}

		/**
		 *  Filter to insert additional data capture code at the bottom of the 'Enter' container on the Exercise tab.
		 */
		private function output_exercise_enter_and_view_top_filter() {

			$filter_return = '';
			if ( has_filter( 'wphealthtracker_data_exercise_enter_and_view_top' ) ) {
				$filter_return = apply_filters( 'wphealthtracker_data_exercise_enter_and_view_top', 'placeholder' );
			}

			return $filter_return;

		}

		/**
		 *  Filter to insert additional data capture code at the bottom of every individual exercise item in both the 'Enter' and 'View & Edit' section
		 */
		private function output_exercise_enter_and_view_bottom_filter() {

			$filter_return = '';
			if ( has_filter( 'wphealthtracker_data_exercise_enter_and_view_bottom' ) ) {
				$filter_return = apply_filters( 'wphealthtracker_data_exercise_enter_and_view_bottom', 'placeholder' );
			}

			return $filter_return;

		}

		/**
		 *  Output the ending html part, with the spinner, the save button, and the response messager container
		 *
		 * @param int $type - the date.
		 * @param int $key - the loop/identifier key.
		 */
		private function output_exercise_ending( $type, $key ) {

			// If we're outputing the save button for previous days, use the 'Update data for [date]' translation string.
			if ( 'previous' === $type ) {
				return '<div class="wphealthtracker-save-spinner-response-div">
				<div class="wphealthtracker-spinner-red" id="wphealthtracker-spinner-save-exercise"></div>
				<div class="wphealthtracker-response-message-div" id="wphealthtracker-response-message-exercise-div"></div>
				<button class="wphealthtracker-save-stuff-button-exercise" id="wphealthtracker-save-daily-exercise-enter-' . $key . '" data-firstname="' . $this->firstname . '" data-lastname="' . $this->lastname . '" data-human-date="' . $this->humandate . '" data-parent-id-num="' . $key . '">' . $this->translations->exercise_trans_5 . ' ' . $this->humandate . '</button>
			</div>';
			}

			// If we're outputing the save button for previous days, use the 'Save data' translation string.
			if ( 'today' === $type ) {
				return '<div class="wphealthtracker-save-spinner-response-div">
				<div class="wphealthtracker-spinner-primary" id="wphealthtracker-spinner-save-exercise"></div>
				<div class="wphealthtracker-response-message-div" id="wphealthtracker-response-message-exercise-div"></div>
				<button class="wphealthtracker-save-stuff-button-exercise" id="wphealthtracker-save-daily-exercise-enter-' . $key . '" data-firstname="' . $this->firstname . '" data-lastname="' . $this->lastname . '" data-human-date="' . $this->humandate . '" data-parent-id-num="' . $key . '">' . $this->translations->exercise_trans_6 . '</button>
			</div>';
			}

		}

		/**
		 *  Output the wrapper that will wrap around every previous day's entry, to provide the expansion/minimization div, it's text ad image, etc.
		 *
		 * @param int $loop_num - the loop/identifier key.
		 * @param int $type - whether Today or a Previous date.
		 */
		private function output_exercise_enter_config_all_data_wrapper_html_open( $loop_num, $type ) {

			$data_section = ' data-section="' . $type . '" ';

			return '
			<div class="wphealthtracker-response-form-all-data-row-parent" id="wphealthtracker-response-form-all-data-row-parent-' . $loop_num . '">
					<div class="wphealthtracker-response-form-exercise-all-data-row" ' . $data_section . ' id="wphealthtracker-response-form-all-data-row-' . $loop_num . '">
				<img class="wphealthtracker-saved-data-indiv-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'analysis.svg" />
				<p class="wphealthtracker-all-data-p">' . $this->translations->exercise_trans_39 . ' ' . $this->humandate . '</p>
				<div class="wphealthtracker-expand-minimize-div-all-data">
					<p class="wphealthtracker-expand-minimize-p" id="wphealthtracker-expand-minimize-p-enter">' . $this->translations->common_trans_1 . '</p>
					<img src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'rotate.svg" class="wphealthtracker-indiv-choice-img-rotate" id="wphealthtracker-indiv-choice-img-rotate-enter" />
				</div>
			</div>
			<div class="wphealthtracker-response-form-all-data-row-actual wphealthtracker-response-form-all-data-row-actual-exercise"  id="wphealthtracker-response-form-data-row-actual-' . $loop_num . '">';

		}

		/**
		 *  Output the wrapper that will close every previous day's entry, to provide the expansion/minimization div, it's text ad image, etc.
		 *
		 * @param int $loop_num - the loop/identifier key.
		 */
		private function output_exercise_enter_config_all_data_wrapper_html_close( $loop_num ) {

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
					<br/>' . $this->translations->exercise_trans_3 . ' ' . $this->date . '" ' . $this->translations->common_trans_21 . '
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
										<button class="wphealthtracker-view-filter-button-exercise" id="wphealthtracker-view-filter-button-exercise-id">' . $this->translations->common_trans_13 . '</button>
										<div class="wphealthtracker-spinner-primary" id="wphealthtracker-spinner-filter-exercise"></div>
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
			$this->firstname       = $userdailydata->firstname;
			$this->lastname        = $userdailydata->lastname;
			$this->wpuserid        = $userdailydata->wpuserid;
			$this->humandate       = $userdailydata->humandate;
			$this->exercisestring  = $userdailydata->exercisestring;
			$this->imgexerciseurl  = $userdailydata->exerciseimg;
			$this->fileexerciseurl = $userdailydata->exercisefiles;

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
			if ( $currentwpuser->ID === (int) $this->wpuserid || '1' === $user_perm[18] ) {
				$proceed_flag = true;
			}

			if ( $proceed_flag ) {

				// Output the individual data items.
				$piece_one = $this->output_exercise_enter_config_exercise_item( 0, 'today' );

				// Finish up with the Spinner, response message area, and the Save button.
				$end_piece = $this->output_exercise_ending( 'today', 0 );

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
			if ( $currentwpuser->ID === (int) $wpuserid || ( '1' === $user_perm[15] && '1' === $user_perm[18] ) ) {
				$proceed_flag = 'viewandedit';
			} elseif ( '1' === $user_perm[15] && '0' === $user_perm[18] ) {
				$proceed_flag = 'viewonly';
			} else {
				$proceed_flag = 'noaccess';
			}

			// The loop that will build each individual day's final full html entry.
			foreach ( $useralldata as $key => $indiv_day ) {

				// Set class variables with data retrieved from the calling function.
				$this->firstname       = $indiv_day->firstname;
				$this->lastname        = $indiv_day->lastname;
				$this->wpuserid        = $indiv_day->wpuserid;
				$this->humandate       = $indiv_day->humandate;
				$this->exercisestring  = $indiv_day->exercisestring;
				$this->imgexerciseurl  = $indiv_day->exerciseimg;
				$this->fileexerciseurl = $indiv_day->exercisefiles;

				// Increment the $key variable by one to not conflict with the data in the 'Enter' section.
				$key++;

				if ( 'noaccess' !== $proceed_flag ) {

					// Output the individual data items.
					$piece_one = $this->output_exercise_enter_config_exercise_item( $key, 'previous' );

					// Get the HTML that will wrap each day's data, providing the div that the user will click on to expand and view that day's data.
					$piece_wrapper_html_open  = $this->output_exercise_enter_config_all_data_wrapper_html_open( $key, 'previous' );
					$piece_wrapper_html_close = $this->output_exercise_enter_config_all_data_wrapper_html_close( $key );

					if ( 'viewandedit' === $proceed_flag ) {
						$end_piece = $this->output_exercise_ending( 'previous', $key );
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
