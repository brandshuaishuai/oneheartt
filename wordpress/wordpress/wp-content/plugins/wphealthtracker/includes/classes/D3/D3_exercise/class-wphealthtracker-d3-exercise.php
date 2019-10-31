<?php
/**
 * Class WPHealthTracker_D3_Exercise - class-wphealthtracker-d3-exercise.php
 *
 * @author   Jake Evans
 * @category Transients
 * @package  Includes/Classes/D3/D3_exercise
 * @version  0.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPHealthTracker_D3_Exercise', false ) ) :
	/**
	 * WPHealthTracker_D3_Exercise class. This class will hold all of the logic needed to create the d3 charts on the Vital Stats tab of the Stats menu page.
	 */
	class WPHealthTracker_D3_Exercise {

		/** Common member variable
		 *
		 *  @var array $alluserdata
		 */
		public $alluserdata = array();

		/** Common member variable
		 *
		 *  @var object $translations
		 */
		public $translations;

		/** Member variables that return d3 data
		 *
		 *  @var array $data_1_array
		 */
		public $data_1_array = array();

		/** Member variables that return d3 data
		 *
		 *  @var array $data_2_array
		 */
		public $data_2_array = array();

		/** Member variables that return d3 data
		 *
		 *  @var array $data_3_array
		 */
		public $data_3_array = array();

		/** Member variables that return d3 data
		 *
		 *  @var array $titles_array
		 */
		public $titles_array = array();

		/** Member variables that return d3 data
		 *
		 *  @var array $stats_array
		 */
		public $stats_array = array();

		/** Member variables that return d3 data
		 *
		 *  @var array $muscle_name_array
		 */
		public $muscle_name_array = array();

		/** Member variables that return d3 data
		 *
		 *  @var string $muscle_name_array
		 */
		public $first_muscle_date = '';

		/** Class Constructor
		 *
		 *  @param array $userdata - The user's complete data set - all food items.
		 */
		public function __construct( $userdata ) {

			$this->alluserdata = $userdata;

			// Get Translations.
			require_once WPHEALTHTRACKER_CLASSES_TRANSLATIONS_DIR . 'class-wphealthtracker-translations.php';
			$this->translations = new WPHealthTracker_Translations();
			$this->translations->d3_chart_trans_strings();
			$this->translations->exercise_tab_trans_strings();
			$this->translations->dashboard_trans_strings();
			$this->translations->tab_titles_trans_strings();
			$this->translations->common_trans_strings();
		}

		/**
		 *  Builds data array for first D3 chart
		 */
		public function build_data_1() {

			$this->miles_running_total = 0;

			foreach ( $this->alluserdata as $key => $indiv_day ) {

				// If we have multiple exercise for one day...
				if ( false !== stripos( $indiv_day->exercisestring, ',' ) ) {

					$indiv_exer = explode( ',', $indiv_day->exercisestring );

					foreach ( $indiv_exer as $key => $exercise ) {

						$exercise = explode( ';', $exercise );

						// Convert everything to miles, if we have a value other than null or zero.
						if ( 0 !== $exercise[5] && null !== $exercise[5] && '' !== $exercise[5] ) {
							if ( $this->translations->common_trans_51 === $exercise[6] ) {
								$this->miles_running_total += $exercise[5] * 0.000189394;
							}

							if ( $this->translations->common_trans_52 === $exercise[6] ) {
								$this->miles_running_total += $exercise[5] * 0.000568182;
							}

							if ( $this->translations->common_trans_53 === $exercise[6] ) {
								$this->miles_running_total += $exercise[5];
							}

							if ( $this->translations->common_trans_54 === $exercise[6] ) {
								$this->miles_running_total += $exercise[5] * 0.000621371;
							}

							if ( $this->translations->common_trans_55 === $exercise[6] ) {
								$this->miles_running_total += $exercise[5] * 0.621371;
							}
						}
					}
				} else {

					$indiv_exer = explode( ';', $indiv_day->exercisestring );

					// Convert everything to miles, if we have a value other than null or zero.
					if ( 0 !== $indiv_exer[5] && null !== $indiv_exer[5] && '' !== $indiv_exer[5] ) {
						if ( $this->translations->common_trans_51 === $indiv_exer[6] ) {
							$this->miles_running_total += $indiv_exer[5] * 0.000189394;
						}

						if ( $this->translations->common_trans_52 === $indiv_exer[6] ) {
							$this->miles_running_total += $indiv_exer[5] * 0.000568182;
						}

						if ( $this->translations->common_trans_53 === $indiv_exer[6] ) {
							$this->miles_running_total += $indiv_exer[5];
						}

						if ( $this->translations->common_trans_54 === $indiv_exer[6] ) {
							$this->miles_running_total += $indiv_exer[5] * 0.000621371;
						}

						if ( $this->translations->common_trans_55 === $indiv_exer[6] ) {
							$this->miles_running_total += $indiv_exer[5] * 0.621371;
						}
					}
				}
			}

			// Now convert to other values.
			$this->feet_running_total       = number_format( ( $this->miles_running_total * 5280 ), 2 );
			$this->yards_running_total      = number_format( ( $this->miles_running_total * 1760 ), 2 );
			$this->meters_running_total     = number_format( ( $this->miles_running_total * 1609.34 ), 2 );
			$this->kilometers_running_total = number_format( ( $this->miles_running_total * 1.60934 ), 2 );

			$this->perc_around_world = number_format( ( ( $this->miles_running_total / 24901 ) * 100 ), 6 );

			// Determine at what signifigant digit to format around the world to.
			$sig_dig = 2;
			for ( $i = 4; $i <= 7; $i++ ) {
				if ( 0 < $this->perc_around_world[ $i ] ) {
					$sig_dig = $i - 1;
					break;
				}
			}

			// If we've travelled around the world at least once, just display 100%.
			if ( 100 <= $this->perc_around_world ) {
				$this->perc_around_world = '100%';
			} else {
				$this->perc_around_world = number_format( $this->perc_around_world, $sig_dig ) . '%';
			}

			$this->perc_to_moon = number_format( ( ( $this->miles_running_total / 238900 ) * 100 ), 2 );

			// Determine at what signifigant digit to format from earth to moon to.
			$sig_dig = 2;
			for ( $i = 4; $i <= 7; $i++ ) {
				if ( isset( $this->perc_to_moon[ $i ] ) ) {
					if ( 0 < $this->perc_to_moon[ $i ] ) {
						$sig_dig = $i - 1;
						break;
					}
				}
			}

			// If we've travelled from the earth to the moon at least once, just display 100%.
			if ( 100 <= $this->perc_to_moon ) {
				$this->perc_to_moon = '100%';
			} else {
				$this->perc_to_moon = number_format( $this->perc_to_moon, $sig_dig ) . '%';
			}

			// If there was no saved distance data at all, return an array holding the 'No Data Found' Html.
			if ( 0 >= $this->miles_running_total ) {
				return '<div class="wphealthtracker-no-saved-data-div">
				<p>
					<img class="wphealthtracker-shocked-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'shocked.svg">
					<span class="wphealthtracker-no-saved-span1">' . $this->translations->d3_trans_15 . '</span>
					<br>
					' . $this->translations->d3_trans_85 . '
					<br>' . $this->translations->d3_trans_86 . '
				</p>
			</div>';
			} else {
				$this->miles_running_total = (string) $this->miles_running_total;
				return $this->miles_running_total;
			}
		}

		/**
		 *  Builds data array for second D3 chart
		 */
		public function build_data_2() {

			$this->muscle_name_array = array();
			$exers_array             = array();

			foreach ( $this->alluserdata as $key => $indiv_day ) {

				// If we have multiple exercises for one day...
				if ( false !== stripos( $indiv_day->exercisestring, ',' ) ) {

					$indiv_exer = explode( ',', $indiv_day->exercisestring );

					foreach ( $indiv_exer as $key => $exercise ) {

						$exercise = explode( ';', $exercise );

						// If we have muscle groups saved at all...
						if ( null !== $exercise[7] && '' !== $exercise[7] ) {

							// Set first date.
							if ( '' === $this->first_muscle_date ) {
								$this->first_muscle_date = $indiv_day->humandate;
							}

							// If we have multiple muscle groups saved.
							if ( false !== stripos( $exercise[7], '/' ) ) {

								$indiv_muscle = explode( '/', $exercise[7] );

								foreach ( $indiv_muscle as $key => $value ) {

									$temp_array = array(
										'name'  => $value,
										'exers' => $exercise[0],
										'date'  => $indiv_day->humandate,
									);

									array_push( $this->muscle_name_array, $temp_array );
								};

							} else {

								$temp_array = array(
									'name'  => $exercise[7],
									'exers' => $exercise[0],
									'date'  => $indiv_day->humandate,
								);

								array_push( $this->muscle_name_array, $temp_array );
							};

						};
					}
				} else {

					$exercise = explode( ';', $indiv_day->exercisestring );

					// If we have muscle groups saved at all...
					if ( null !== $exercise[7] && '' !== $exercise[7] ) {

						// Set first date.
						if ( '' === $this->first_muscle_date ) {
							$this->first_muscle_date = $indiv_day->humandate;
						}

						// If we have multiple muscle groups saved.
						if ( false !== stripos( $exercise[7], '/' ) ) {

							$indiv_muscle = explode( '/', $exercise[7] );

							foreach ( $indiv_muscle as $key => $value ) {

								$temp_array = array(
									'name'  => $value,
									'exers' => $exercise[0],
									'date'  => $indiv_day->humandate,
								);

								array_push( $this->muscle_name_array, $temp_array );
							};

						} else {

							$temp_array = array(
								'name'  => $exercise[7],
								'exers' => $exercise[0],
								'date'  => $indiv_day->humandate,
							);

							array_push( $this->muscle_name_array, $temp_array );
						};

					};
				}
			}

			$biceps_counter = 0;
			$biceps_exers   = '';
			$biceps_first   = '';
			$biceps_last    = '';

			$deltoids_counter = 0;
			$deltoids_exers   = '';
			$deltoids_first   = '';
			$deltoids_last    = '';

			$forearms_counter = 0;
			$forearms_exers   = '';
			$forearms_first   = '';
			$forearms_last    = '';

			$triceps_counter = 0;
			$triceps_exers   = '';
			$triceps_first   = '';
			$triceps_last    = '';

			$trapezius_counter = 0;
			$trapezius_exers   = '';
			$trapezius_first   = '';
			$trapezius_last    = '';

			$lats_counter = 0;
			$lats_exers   = '';
			$lats_first   = '';
			$lats_last    = '';

			$abs_counter = 0;
			$abs_exers   = '';
			$abs_first   = '';
			$abs_last    = '';

			$obliques_counter = 0;
			$obliques_exers   = '';
			$obliques_first   = '';
			$obliques_last    = '';

			$pectorals_counter = 0;
			$pectorals_exers   = '';
			$pectorals_first   = '';
			$pectorals_last    = '';

			$adductors_counter = 0;
			$adductors_exers   = '';
			$adductors_first   = '';
			$adductors_last    = '';

			$calves_counter = 0;
			$calves_exers   = '';
			$calves_first   = '';
			$calves_last    = '';

			$hamstrings_counter = 0;
			$hamstrings_exers   = '';
			$hamstrings_first   = '';
			$hamstrings_last    = '';

			$glutes_counter = 0;
			$glutes_exers   = '';
			$glutes_first   = '';
			$glutes_last    = '';

			$quads_counter = 0;
			$quads_exers   = '';
			$quads_first   = '';
			$quads_last    = '';

			foreach ( $this->muscle_name_array as $key => $value ) {
				switch ( $value['name'] ) {
					case 'Biceps':
						if ( 0 === $biceps_counter ) {
							$biceps_last = $value['date'];
						} else {
							$biceps_first = $value['date'];
						}

						$biceps_counter++;

						if ( false === stripos( $biceps_exers, $value['exers'] ) ) {
							$biceps_exers .= ', ' . $value['exers'];
							$biceps_exers  = ltrim( $biceps_exers, ',' );
							$biceps_exers  = ltrim( $biceps_exers, ' ' );
						}
						break;
					case 'Deltoids':
						if ( 0 === $deltoids_counter ) {
							$deltoids_last = $value['date'];
						} else {
							$deltoids_first = $value['date'];
						}

						$deltoids_counter++;

						if ( false === stripos( $deltoids_exers, $value['exers'] ) ) {
							$deltoids_exers .= ', ' . $value['exers'];
							$deltoids_exers  = ltrim( $deltoids_exers, ',' );
							$deltoids_exers  = ltrim( $deltoids_exers, ' ' );
						}
						break;
					case 'Forearms':
						if ( 0 === $forearms_counter ) {
							$forearms_last = $value['date'];
						} else {
							$forearms_first = $value['date'];
						}

						$forearms_counter++;

						if ( false === stripos( $forearms_exers, $value['exers'] ) ) {
							$forearms_exers .= ', ' . $value['exers'];
							$forearms_exers  = ltrim( $forearms_exers, ',' );
							$forearms_exers  = ltrim( $forearms_exers, ' ' );
						}
						break;
					case 'Triceps':
						if ( 0 === $triceps_counter ) {
							$triceps_last = $value['date'];
						} else {
							$triceps_first = $value['date'];
						}

						$triceps_counter++;

						if ( false === stripos( $triceps_exers, $value['exers'] ) ) {
							$triceps_exers .= ', ' . $value['exers'];
							$triceps_exers  = ltrim( $triceps_exers, ',' );
							$triceps_exers  = ltrim( $triceps_exers, ' ' );
						}
						break;
					case 'Trapezius':
						if ( 0 === $trapezius_counter ) {
							$trapezius_last = $value['date'];
						} else {
							$trapezius_first = $value['date'];
						}

						$trapezius_counter++;

						if ( false === stripos( $trapezius_exers, $value['exers'] ) ) {
							$trapezius_exers .= ', ' . $value['exers'];
							$trapezius_exers  = ltrim( $trapezius_exers, ',' );
							$trapezius_exers  = ltrim( $trapezius_exers, ' ' );
						}
						break;
					case 'Lats':
						if ( 0 === $lats_counter ) {
							$lats_last = $value['date'];
						} else {
							$lats_first = $value['date'];
						}

						$lats_counter++;

						if ( false === stripos( $lats_exers, $value['exers'] ) ) {
							$lats_exers .= ', ' . $value['exers'];
							$lats_exers  = ltrim( $lats_exers, ',' );
							$lats_exers  = ltrim( $lats_exers, ' ' );
						}
						break;
					case 'Abs':
						if ( 0 === $abs_counter ) {
							$abs_last = $value['date'];
						} else {
							$abs_first = $value['date'];
						}

						$abs_counter++;

						if ( false === stripos( $abs_exers, $value['exers'] ) ) {
							$abs_exers .= ', ' . $value['exers'];
							$abs_exers  = ltrim( $abs_exers, ',' );
							$abs_exers  = ltrim( $abs_exers, ' ' );
						}
						break;
					case 'Obliques':
						if ( 0 === $obliques_counter ) {
							$obliques_last = $value['date'];
						} else {
							$obliques_first = $value['date'];
						}

						$obliques_counter++;

						if ( false === stripos( $obliques_exers, $value['exers'] ) ) {
							$obliques_exers .= ', ' . $value['exers'];
							$obliques_exers  = ltrim( $obliques_exers, ',' );
							$obliques_exers  = ltrim( $obliques_exers, ' ' );
						}
						break;
					case 'Chest':
						if ( 0 === $pectorals_counter ) {
							$pectorals_last = $value['date'];
						} else {
							$pectorals_first = $value['date'];
						}

						$pectorals_counter++;

						if ( false === stripos( $pectorals_exers, $value['exers'] ) ) {
							$pectorals_exers .= ', ' . $value['exers'];
							$pectorals_exers  = ltrim( $pectorals_exers, ',' );
							$pectorals_exers  = ltrim( $pectorals_exers, ' ' );
						}
						break;
					case 'Adductors':
						if ( 0 === $adductors_counter ) {
							$adductors_last = $value['date'];
						} else {
							$adductors_first = $value['date'];
						}

						$adductors_counter++;

						if ( false === stripos( $adductors_exers, $value['exers'] ) ) {
							$adductors_exers .= ', ' . $value['exers'];
							$adductors_exers  = ltrim( $adductors_exers, ',' );
							$adductors_exers  = ltrim( $adductors_exers, ' ' );
						}
						break;
					case 'Calves':
						if ( 0 === $calves_counter ) {
							$calves_last = $value['date'];
						} else {
							$calves_first = $value['date'];
						}

						$calves_counter++;

						if ( false === stripos( $calves_exers, $value['exers'] ) ) {
							$calves_exers .= ', ' . $value['exers'];
							$calves_exers  = ltrim( $calves_exers, ',' );
							$calves_exers  = ltrim( $calves_exers, ' ' );
						}
						break;
					case 'Hamstrings':
						if ( 0 === $hamstrings_counter ) {
							$hamstrings_last = $value['date'];
						} else {
							$hamstrings_first = $value['date'];
						}

						$hamstrings_counter++;

						if ( false === stripos( $hamstrings_exers, $value['exers'] ) ) {
							$hamstrings_exers .= ', ' . $value['exers'];
							$hamstrings_exers  = ltrim( $hamstrings_exers, ',' );
							$hamstrings_exers  = ltrim( $hamstrings_exers, ' ' );
						}
						break;
					case 'Glutes':
						if ( 0 === $glutes_counter ) {
							$glutes_last = $value['date'];
						} else {
							$glutes_first = $value['date'];
						}

						$glutes_counter++;

						if ( false === stripos( $glutes_exers, $value['exers'] ) ) {
							$glutes_exers .= ', ' . $value['exers'];
							$glutes_exers  = ltrim( $glutes_exers, ',' );
							$glutes_exers  = ltrim( $glutes_exers, ' ' );
						}
						break;
					case 'Quads':
						if ( 0 === $quads_counter ) {
							$quads_last = $value['date'];
						} else {
							$quads_first = $value['date'];
						}

						$quads_counter++;

						if ( false === stripos( $quads_exers, $value['exers'] ) ) {
							$quads_exers .= ', ' . $value['exers'];
							$quads_exers  = ltrim( $quads_exers, ',' );
							$quads_exers  = ltrim( $quads_exers, ' ' );
						}
						break;
					default:
						break;
				}
			}

			$temp = array(
				'name'      => 'Biceps',
				'frequency' => $biceps_counter,
				'first'     => $biceps_first,
				'last'      => $biceps_last,
				'exers'     => $biceps_exers,
			);
			array_push( $this->data_2_array, $temp );

			$temp = array(
				'name'      => 'Deltoids',
				'frequency' => $deltoids_counter,
				'first'     => $deltoids_first,
				'last'      => $deltoids_last,
				'exers'     => $deltoids_exers,
			);
			array_push( $this->data_2_array, $temp );

			$temp = array(
				'name'      => 'Forearms',
				'frequency' => $forearms_counter,
				'first'     => $forearms_first,
				'last'      => $forearms_last,
				'exers'     => $forearms_exers,
			);
			array_push( $this->data_2_array, $temp );

			$temp = array(
				'name'      => 'Triceps',
				'frequency' => $triceps_counter,
				'first'     => $triceps_first,
				'last'      => $triceps_last,
				'exers'     => $triceps_exers,
			);
			array_push( $this->data_2_array, $temp );

			$temp = array(
				'name'      => 'Trapezius',
				'frequency' => $trapezius_counter,
				'first'     => $trapezius_first,
				'last'      => $trapezius_last,
				'exers'     => $trapezius_exers,
			);
			array_push( $this->data_2_array, $temp );

			$temp = array(
				'name'      => 'Lats',
				'frequency' => $lats_counter,
				'first'     => $lats_first,
				'last'      => $lats_last,
				'exers'     => $lats_exers,
			);
			array_push( $this->data_2_array, $temp );

			$temp = array(
				'name'      => 'Abs',
				'frequency' => $abs_counter,
				'first'     => $abs_first,
				'last'      => $abs_last,
				'exers'     => $abs_exers,
			);
			array_push( $this->data_2_array, $temp );

			$temp = array(
				'name'      => 'Obliques',
				'frequency' => $obliques_counter,
				'first'     => $obliques_first,
				'last'      => $obliques_last,
				'exers'     => $obliques_exers,
			);
			array_push( $this->data_2_array, $temp );

			$temp = array(
				'name'      => 'Pectorals',
				'frequency' => $pectorals_counter,
				'first'     => $pectorals_first,
				'last'      => $pectorals_last,
				'exers'     => $pectorals_exers,
			);
			array_push( $this->data_2_array, $temp );

			$temp = array(
				'name'      => 'Adductors',
				'frequency' => $adductors_counter,
				'first'     => $adductors_first,
				'last'      => $adductors_last,
				'exers'     => $adductors_exers,
			);
			array_push( $this->data_2_array, $temp );

			$temp = array(
				'name'      => 'Calves',
				'frequency' => $calves_counter,
				'first'     => $calves_first,
				'last'      => $calves_last,
				'exers'     => $calves_exers,
			);
			array_push( $this->data_2_array, $temp );

			$temp = array(
				'name'      => 'Hamstrings',
				'frequency' => $hamstrings_counter,
				'first'     => $hamstrings_first,
				'last'      => $hamstrings_last,
				'exers'     => $hamstrings_exers,
			);
			array_push( $this->data_2_array, $temp );

			$temp = array(
				'name'      => 'Glutes',
				'frequency' => $glutes_counter,
				'first'     => $glutes_first,
				'last'      => $glutes_last,
				'exers'     => $glutes_exers,
			);
			array_push( $this->data_2_array, $temp );

			$temp = array(
				'name'      => 'Quads',
				'frequency' => $quads_counter,
				'first'     => $quads_first,
				'last'      => $quads_last,
				'exers'     => $quads_exers,
			);
			array_push( $this->data_2_array, $temp );

			// If there was no saved Exercise data at all, return an array holding the 'No Data Found' Html.
			if ( count( $this->muscle_name_array ) === 0 ) {
				return '<div class="wphealthtracker-no-saved-data-div">
					<p>
						<img class="wphealthtracker-shocked-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'shocked.svg">
						<span class="wphealthtracker-no-saved-span1">' . $this->translations->d3_trans_15 . '</span>
						<br>
						' . $this->translations->d3_trans_93 . '
						<br>' . $this->translations->d3_trans_94 . '
					</p>
				</div>';
			} else {
				return $this->data_2_array;
			}
		}

		/**
		 *  Builds data array for third D3 chart
		 */
		public function build_data_3() {

			$temp_array = array();

			$data_flag = 0;
			foreach ( $this->alluserdata as $key => $indiv_day ) {

				// If we have multiple exercises for one day...
				if ( false !== stripos( $indiv_day->exercisestring, ',' ) ) {

					$indiv_exer = explode( ',', $indiv_day->exercisestring );

					foreach ( $indiv_exer as $key2 => $exercise ) {

						$exercise = explode( ';', $exercise );

						// Convert humandate to day of week.
						$t   = explode( '-', $this->alluserdata[ $key ]->humandate );
						$t   = $t[1] . '-' . $t[0] . '-' . $t[2];
						$day = date( 'N', strtotime( $t ) );

						// Convert time to hour of day.
						$hour = explode( ':', $exercise[2] );
						$hour = $hour[0];
						$hour = ltrim( $hour, '0' );

						// If we've saved data at 12:00 AM.
						if ( '' === $hour || null === $hour || 0 === $hour || '0' === $hour ) {
							$hour = '24';
						}

						$hour = (int) $hour + 1;
						$hour = (string) $hour;

						if ( '25' === $hour ) {
							$hour = '1';
						}

						$temp = array(
							'day'  => $day,
							'hour' => $hour,
						);

						array_push( $temp_array, $temp );
					}
				} else {

					$exercise = explode( ';', $indiv_day->exercisestring );

					// Convert humandate to day of week.
					$t   = explode( '-', $this->alluserdata[ $key ]->humandate );
					$t   = $t[1] . '-' . $t[0] . '-' . $t[2];
					$day = date( 'N', strtotime( $t ) );

					// Convert time to hour of day.
					$hour = explode( ':', $exercise[2] );
					$hour = $hour[0];
					$hour = ltrim( $hour, '0' );

					// If we've saved data at 12:00 AM.
					if ( '' === $hour || null === $hour || 0 === $hour || '0' === $hour ) {
						$hour = '24';
					}

					$hour = (int) $hour + 1;
					$hour = (string) $hour;

					if ( '25' === $hour ) {
						$hour = '1';
					}

					$temp = array(
						'day'  => $day,
						'hour' => $hour,
					);

					array_push( $temp_array, $temp );
				}
			}

			$temp_array_copy = $temp_array;
			$temp_array_copy = array_unique( $temp_array_copy, SORT_REGULAR );
			$counter         = 0;

			foreach ( $temp_array_copy as $key => $value ) {
				foreach ( $temp_array as $key2 => $value2 ) {
					if ( $value['day'] === $value2['day'] && $value['hour'] === $value2['hour'] ) {
						$counter++;
					}
				}

				$temp_array[ $key ]['value'] = $counter;
				$counter                     = 0;
			}

			foreach ( $temp_array as $key => $value ) {
				if ( ! isset( $value['value'] ) ) {
					unset( $temp_array[ $key ] );
				}
			}

			foreach ( $temp_array as $key => $value ) {
				array_push( $this->data_3_array, $value );
			}

			// Only run this if we've actually geenrated data by this point.
			if ( count( $this->data_3_array ) > 0 ) {
				for ( $day = 1; $day <= 7; $day++ ) {

					for ( $hour = 1; $hour <= 24; $hour++ ) {

						$add_entry = true;
						foreach ( $this->data_3_array as $key => $value ) {
							if ( (string) $day === $value['day'] && (string) $hour === $value['hour'] ) {
								$add_entry = false;
								break;
							}
						}

						if ( $add_entry ) {

							$temp = array(
								'day'   => (string) $day,
								'hour'  => (string) $hour,
								'value' => 0,
							);

							array_push( $this->data_3_array, $temp );
						}
					}
				}
			}

			// If there was no saved Exercise data at all, return an array holding the 'No Data Found' Html.
			if ( count( $this->data_3_array ) === 0 ) {
				return '<div class="wphealthtracker-no-saved-data-div">
					<p>
						<img class="wphealthtracker-shocked-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'shocked.svg">
						<span class="wphealthtracker-no-saved-span1">' . $this->translations->d3_trans_15 . '</span>
						<br>
						' . $this->translations->d3_trans_95 . '
						<br>' . $this->translations->d3_trans_96 . '
					</p>
				</div>';
			} else {
				return $this->data_3_array;
			}
		}

		/**
		 *  Builds title area HTML for each of the 3 sections
		 */
		public function get_title_area_html() {

			$title_1 = '
			<img class="wphealthtracker-d3-chart-title-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'runner.svg"/>		
			<img class="wphealthtracker-icon-image-question" id="wphealthtracker-icon-image-question-d3-chart-title" data-label="d3-exercise-distancechartandstats" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg" /><p class="wphealthtracker-d3-chart-title-actual">' . $this->translations->d3_trans_74 . '</p>
			<div class="wphealthtracker-d3-chart-title-line"></div>';

			$title_2 = '
			<img class="wphealthtracker-d3-chart-title-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'strong.svg"/>		
			<img class="wphealthtracker-icon-image-question" id="wphealthtracker-icon-image-question-d3-chart-title" data-label="d3-exercise-musclegroupschartandstats" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg" /><p class="wphealthtracker-d3-chart-title-actual">' . $this->translations->d3_trans_90 . '</p>
			<div class="wphealthtracker-d3-chart-title-line"></div>';

			$title_3 = '
			<img class="wphealthtracker-d3-chart-title-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'stopwatch.svg"/>		
			<img class="wphealthtracker-icon-image-question" id="wphealthtracker-icon-image-question-d3-chart-title" data-label="d3-exercise-durationchartandstats" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg" /><p class="wphealthtracker-d3-chart-title-actual">' . $this->translations->d3_trans_99 . '</p>
			<div class="wphealthtracker-d3-chart-title-line"></div>';

			array_push( $this->titles_array, $title_1 );
			array_push( $this->titles_array, $title_2 );
			array_push( $this->titles_array, $title_3 );

			return $this->titles_array;

		}

		/**
		 *  Builds the stats data variables to be later used in the Stats HTML for the first section
		 */
		public function build_stats_data_1() {

		}

		/**
		 *  Builds the stats data variables to be later used in the Stats HTML for the second section
		 */
		public function build_stats_data_2() {

			// Building # of unique exercise items.
			$unique_exercises = array();
			foreach ( $this->alluserdata as $key => $value ) {
				// If we have saved data...
				if ( '' !== $value->exercisestring ) {
					if ( stripos( $value->exercisestring, ',' ) !== false ) {
						$indiv_day = explode( ',', $value->exercisestring );
						foreach ( $indiv_day as $key2 => $value2 ) {

							$indiv_day2 = explode( ';', $value2 );
							if ( '' !== $indiv_day2[0] ) {
								array_push( $unique_exercises, $indiv_day2[0] );
							}
						}
					} else {
						$indiv_day = explode( ';', $value->exercisestring );
						if ( '' !== $indiv_day[0] ) {
							array_push( $unique_exercises, $indiv_day[0] );
						}
					}
				}
			}

			// Building # of unique exercise categories.
			$exercise_categories = array();
			foreach ( $this->alluserdata as $key => $value ) {
				// If we have saved data...
				if ( '' !== $value->exercisestring ) {
					if ( stripos( $value->exercisestring, ',' ) !== false ) {
						$indiv_day = explode( ',', $value->exercisestring );
						foreach ( $indiv_day as $key2 => $value2 ) {

							$indiv_day2 = explode( ';', $value2 );
							if ( '' !== $indiv_day2[1] ) {
								array_push( $exercise_categories, $indiv_day2[1] );
							}
						}
					} else {
						$indiv_day = explode( ';', $value->exercisestring );
						if ( '' !== $indiv_day[1] ) {
							array_push( $exercise_categories, $indiv_day[1] );
						}
					}
				}
			}

			// Building # of unique Muscles Groups.
			$exercise_muscles = array();
			foreach ( $this->alluserdata as $key => $value ) {
				// If we have saved data...
				if ( '' !== $value->exercisestring ) {
					if ( stripos( $value->exercisestring, ',' ) !== false ) {
						$indiv_day = explode( ',', $value->exercisestring );
						foreach ( $indiv_day as $key2 => $value2 ) {

							$indiv_day2 = explode( ';', $value2 );
							if ( '' !== $indiv_day2[7] ) {

								if ( stripos( $indiv_day2[7], '/' ) !== false ) {
									$temp = explode( '/', $indiv_day2[7] );

									foreach ( $temp as $key => $muscle_indiv ) {
										array_push( $exercise_muscles, $muscle_indiv );
									}
								} else {
									array_push( $exercise_muscles, $indiv_day2[7] );
								}
							}
						}
					} else {
						$indiv_day = explode( ';', $value->exercisestring );
						if ( '' !== $indiv_day[7] ) {

							if ( '' !== $indiv_day[7] ) {

								if ( stripos( $indiv_day[7], '/' ) !== false ) {
									$temp = explode( '/', $indiv_day[7] );

									foreach ( $temp as $key => $muscle_indiv ) {
										array_push( $exercise_muscles, $muscle_indiv );
									}
								} else {
									array_push( $exercise_muscles, $indiv_day[7] );
								}
							}
						}
					}
				}
			}

			// Calculating some final exercises item values.
			$orig_unique_exercises        = $unique_exercises;
			$final_unique_exercises       = array_unique( $unique_exercises );
			$this->unique_exercises_count = count( $final_unique_exercises );
			$values                       = array_count_values( $orig_unique_exercises );
			arsort( $values );
			$top_five_exercise_items = array_slice( array_keys( $values ), 0, 5, true );

			$orig_exercise_categories        = $exercise_categories;
			$final_exercise_categories       = array_unique( $exercise_categories );
			$this->exercise_categories_count = count( $final_exercise_categories );
			$values                          = array_count_values( $orig_exercise_categories );
			arsort( $values );
			$top_five_exercise_categories = array_slice( array_keys( $values ), 0, 5, true );

			$orig_exercise_muscles  = $exercise_muscles;
			$final_exercise_muscles = array_unique( $exercise_muscles );
			$exercise_muscles_count = count( $final_exercise_muscles );
			$values                 = array_count_values( $orig_exercise_muscles );
			arsort( $values );
			$top_five_exercise_muscles = array_slice( array_keys( $values ), 0, 5, true );

			// Building top exercise item string.
			if ( isset( $top_five_exercise_items[0] ) ) {
				$this->top_3_exercise_items = $top_five_exercise_items[0];
			}

			// Building top exercise categories string.
			if ( isset( $top_five_exercise_categories[0] ) ) {
				$this->top_3_exercise_categories = $top_five_exercise_categories[0];
			}

			// Building top 3 exercise muscles groups string.
			if ( count( $top_five_exercise_muscles ) > 2 ) {
				$this->top_3_exercise_muscles = $top_five_exercise_muscles[0] . ', ' . $top_five_exercise_muscles[1] . ', ' . $top_five_exercise_muscles[2];
			}
			if ( count( $top_five_exercise_muscles ) === 2 ) {
				$this->top_3_exercise_muscles = $top_five_exercise_muscles[0] . ', ' . $top_five_exercise_muscles[1];
			}
			if ( count( $top_five_exercise_muscles ) === 1 ) {
				$this->top_3_exercise_muscles = $top_five_exercise_muscles[0];
			}
		}

		/**
		 *  Builds the stats data variables to be later used in the Stats HTML for the third section
		 */
		public function build_stats_data_3() {

			// Building # of total exercises performed.
			$total_exercises           = array();
			$this->first_exercise_date = '';
			foreach ( $this->alluserdata as $key => $value ) {
				// If we have saved data...
				if ( '' !== $value->exercisestring ) {

					if ( '' === $this->first_exercise_date ) {
						$this->first_exercise_date = $value->humandate;
					}

					if ( stripos( $value->exercisestring, ',' ) !== false ) {

						$indiv_day = explode( ',', $value->exercisestring );
						foreach ( $indiv_day as $key2 => $value2 ) {

							$indiv_day2 = explode( ';', $value2 );
							if ( '' !== $indiv_day2[0] ) {
								array_push( $total_exercises, $indiv_day2[0] );
							}
						}
					} else {
						$indiv_day = explode( ';', $value->exercisestring );
						if ( '' !== $indiv_day[0] ) {
							array_push( $total_exercises, $indiv_day[0] );
						}
					}
				}
			}

			// Vars for calculating longest single exercise.
			$longest_hours         = 0;
			$longest_minutes       = 0;
			$longest_seconds       = 0;
			$total_seconds         = 0;
			$total_hours           = 0;
			$total_minutes         = 0;
			$total_average_seconds = 0;

			// Now calculate total time spent exercising.
			foreach ( $this->alluserdata as $key => $value ) {

				// If we have saved data...
				if ( '' !== $value->exercisestring ) {
					if ( stripos( $value->exercisestring, ',' ) !== false ) {
						$indiv_day = explode( ',', $value->exercisestring );
						foreach ( $indiv_day as $key2 => $value2 ) {
							$indiv_day2 = explode( ';', $value2 );
							if ( '' !== $indiv_day2[3] ) {
								if ( $this->translations->common_trans_48 === $indiv_day2[4] ) {
									$total_seconds += $indiv_day2[3];

									if ( $longest_seconds < $indiv_day2[3] ) {
										$longest_seconds = $indiv_day2[3];
									}
								}

								if ( $this->translations->common_trans_49 === $indiv_day2[4] ) {
									$total_minutes += $indiv_day2[3];

									if ( $longest_minutes < $indiv_day2[3] ) {
										$longest_minutes = $indiv_day2[3];
									}
								}

								if ( $this->translations->common_trans_50 === $indiv_day2[4] ) {
									$total_hours += $indiv_day2[3];

									if ( $longest_hours < $indiv_day2[3] ) {
										$longest_hours = $indiv_day2[3];
									}
								}

								// Convert time to hour of day.
								$hour    = explode( ':', $indiv_day2[2] );
								$hour[0] = ltrim( $hour[0], '0' );

								if ( '00' === $hour[1] ) {
									$hour[1] = '0';
								} else {
									$hour[1] = ltrim( $hour[1], '0' );
								}

								// If we've saved data at 12:00 AM.
								if ( '' === $hour[0] || null === $hour[0] || 0 === $hour[0] || '0' === $hour[0] ) {
									$hour[0] = 24;
								}

								$average_seconds       = $hour[0] * 3600;
								$total_average_seconds = $total_average_seconds + $average_seconds + ( $hour[1] * 60 );

							}
						}
					} else {
						$indiv_day = explode( ';', $value->exercisestring );
						if ( '' !== $indiv_day[0] ) {

							if ( '' !== $indiv_day[3] ) {
								if ( $this->translations->common_trans_48 === $indiv_day[4] ) {
									$total_seconds += $indiv_day[3];

									if ( $longest_seconds < $indiv_day[3] ) {
										$longest_seconds = $indiv_day[3];
									}
								}

								if ( $this->translations->common_trans_49 === $indiv_day[4] ) {
									$total_minutes += $indiv_day[3];

									if ( $longest_minutes < $indiv_day[3] ) {
										$longest_minutes = $indiv_day[3];
									}
								}

								if ( $this->translations->common_trans_50 === $indiv_day[4] ) {
									$total_hours += $indiv_day[3];

									if ( $longest_hours < $indiv_day[3] ) {
										$longest_hours = $indiv_day[3];
									}
								}

									// Convert time to hour of day.
									$hour    = explode( ':', $indiv_day[2] );
									$hour[0] = ltrim( $hour[0], '0' );
									if ( '00' === $hour[1] ) {
										$hour[1] = '0';
									} else {
										$hour[1] = ltrim( $hour[1], '0' );
									}

									// If we've saved data at 12:00 AM.
									if ( '' === $hour[0] || null === $hour[0] || 0 === $hour[0] || '0' === $hour[0] ) {
										$hour[0] = 24;
									}

									$average_seconds       = $hour[0] * 3600;
									$total_average_seconds = $total_average_seconds + $average_seconds + ( $hour[1] * 60 );
							}
						}
					}
				}
			}

			// Build longest single exercise - first convert everything to seconds.
			$longest_seconds       = $longest_seconds + ( $longest_hours * 3600 );
			$this->longest_seconds = $longest_seconds + ( $longest_minutes * 60 );

			if ( 0 !== $this->longest_seconds ) {
				$this->longest_minutes = number_format( ( $this->longest_seconds / 60 ), 2 );
			}

			if ( 0 !== $this->longest_seconds ) {
				$this->longest_hours = number_format( ( $this->longest_seconds / 3600 ), 2 );
			}

			// Convert everything into seconds.
			$total_seconds       = $total_seconds + ( $total_hours * 3600 );
			$this->total_seconds = $total_seconds + ( $total_minutes * 60 );

			// Now take those total seconds and create our minutes and hours values.
			if ( 0 !== $this->total_seconds ) {
				$this->total_minutes = number_format( ( $this->total_seconds / 60 ), 2 );
				$this->total_hours   = number_format( ( $this->total_seconds / 3600 ), 2 );
			}

			// Now format total seconds.
			$this->total_seconds = number_format( $this->total_seconds, 2 );

			$this->total_exercises = count( $total_exercises );

			$temp1 = 0;
			$temp2 = 0;
			if ( 0 !== $total_average_seconds && $this->total_exercises ) {
				$temp1 = intval( ( ( $total_average_seconds / $this->total_exercises ) / 3600 ) );
				$temp2 = intval( ( ( $total_average_seconds / $this->total_exercises ) % 3600 ) );
			}

			if ( 0 !== $temp2 ) {
				$temp2 = intval( ( $temp2 / 60 ) );
			}

			if ( 0 === $temp2 ) {
				$temp2 = '00';
			}

			if ( $temp1 >= 12 ) {
				$temp1    = $temp1 - 11;
				$meridiem = $this->translations->common_trans_66;
			} else {
				$meridiem = $this->translations->common_trans_65;
			}

			$this->human_average_time = $temp1 . ':' . $temp2 . ' ' . $meridiem;

		}

		/**
		 *  Builds the Stats HTML for each of the 3 sections utilizing the
		 *  member variables created in the 3 previous functions.
		 */
		public function get_stats_area_html() {

			// Build data for the Food Items area.
			$this->build_stats_data_1();

			// Build data for the Blood Pressure area.
			$this->build_stats_data_2();

			// Build data for the Cholesterol area.
			$this->build_stats_data_3();

			// If there is more than 1 day of Exercise data saved...
			$stats_1 = '';
			(float) $this->miles_running_total;
			if ( 0 < $this->miles_running_total ) {

				$this->miles_running_total = number_format( $this->miles_running_total, 2 );

				$stats_1 = '
			<img class="wphealthtracker-d3-chart-title-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'computer.svg"/>		
			<p class="wphealthtracker-d3-chart-subtitle-actual">' . $this->translations->d3_trans_84 . '</p>
			<div class="wphealthtracker-d3-chart-title-line"></div>
			<div class="wphealthtracker-dashboard-actual-info">
				<div class="wphealthtracker-dashboard-row">
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-firstdaytracked" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->d3_trans_3 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->alluserdata[0]->humandate . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-exercise-totalmiles" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->d3_trans_79 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->miles_running_total . ' ' . $this->translations->common_trans_53 . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-exercise-totalkilometers" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->d3_trans_80 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->kilometers_running_total . ' ' . $this->translations->common_trans_55 . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-exercise-totalmeters" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->d3_trans_81 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->meters_running_total . ' ' . $this->translations->common_trans_54 . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-exercise-totalyards" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->d3_trans_82 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->yards_running_total . ' ' . $this->translations->common_trans_52 . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-exercise-totalfeet" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->d3_trans_83 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->feet_running_total . ' ' . $this->translations->common_trans_51 . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-exercise-aroundearth" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->d3_trans_88 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->perc_around_world . ' ' . $this->translations->d3_trans_75 . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-exercise-earthtomoon" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->d3_trans_89 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->perc_to_moon . ' ' . $this->translations->d3_trans_75 . '</span>
						</p>
					</div>
					
					
				</div>
			</div>';

			} else {
				$stats_1 = '<div class="wphealthtracker-no-saved-data-div">
				<p>
					<img class="wphealthtracker-shocked-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'shocked.svg">
					<span class="wphealthtracker-no-saved-span1">' . $this->translations->d3_trans_15 . '</span>
					<br>
					' . $this->translations->d3_trans_85 . '
					<br>' . $this->translations->d3_trans_87 . '
				</p>
			</div>';
			}

			// If there is 1 or more day of Muscle Group data saved...
			$stats_2 = '';
			if ( count( $this->muscle_name_array ) > 0 ) {
				$stats_2 = '
				<img class="wphealthtracker-d3-chart-title-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'computer.svg"/>		
				<p class="wphealthtracker-d3-chart-subtitle-actual">' . $this->translations->d3_trans_91 . '</p>
				<div class="wphealthtracker-d3-chart-title-line"></div>
				<div class="wphealthtracker-dashboard-actual-info">
					<div class="wphealthtracker-dashboard-row">
						<div class="wphealthtracker-dashboard-row-entry">
							<p>
								<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-firstdaytracked" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
								<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->d3_trans_3 . '</span>
								<span class="wphealthtracker-dashboard-row-entry-data">' . $this->first_muscle_date . '</span>
							</p>
						</div>
						<div class="wphealthtracker-dashboard-row-entry">
							<p>
								<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-topmusclegroups" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
								<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_59 . '</span>
								<span class="wphealthtracker-dashboard-row-entry-data">' . $this->top_3_exercise_muscles . '</span>
							</p>
						</div>
						<div class="wphealthtracker-dashboard-row-entry">
							<p>
								<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-topexercisecategory" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
								<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_56 . '</span>
								<span class="wphealthtracker-dashboard-row-entry-data">' . $this->top_3_exercise_categories . '</span>
							</p>
						</div>
						<div class="wphealthtracker-dashboard-row-entry">
							<p>
								<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-topexercise" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
								<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_52 . '</span>
								<span class="wphealthtracker-dashboard-row-entry-data">' . $this->top_3_exercise_items . '
							</p>
						</div>
						<div class="wphealthtracker-dashboard-row-entry">
							<p>
								<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-totaluniqueexercises" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
								<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_50 . '</span>
								<span class="wphealthtracker-dashboard-row-entry-data">' . $this->unique_exercises_count . ' ' . $this->translations->dashboard_trans_51 . '</span>
							</p>
						</div>
						<div class="wphealthtracker-dashboard-row-entry">
							<p>
								<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-totalexercisecategories" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
								<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_57 . '</span>
								<span class="wphealthtracker-dashboard-row-entry-data">' . $this->exercise_categories_count . ' ' . $this->translations->common_trans_57 . '</span>
							</p>
						</div>
					</div>
				</div>';

			} else {
				$stats_2 = '<div class="wphealthtracker-no-saved-data-div">
					<p>
						<img class="wphealthtracker-shocked-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'shocked.svg">
						<span class="wphealthtracker-no-saved-span1">' . $this->translations->d3_trans_15 . '</span>
						<br>
						' . $this->translations->d3_trans_93 . '
						<br>' . $this->translations->d3_trans_97 . '
					</p>
				</div>';
			}

			// If there is 1 or more days of Exercise data saved...
			$stats_3 = '';
			if ( count( $this->alluserdata ) > 0 ) {
				$stats_3 = '<img class="wphealthtracker-d3-chart-title-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'computer.svg"/>		
				<p class="wphealthtracker-d3-chart-subtitle-actual">' . $this->translations->d3_trans_101 . '</p>
				<div class="wphealthtracker-d3-chart-title-line"></div>
				<div class="wphealthtracker-dashboard-actual-info">
					<div class="wphealthtracker-dashboard-row">
						<div class="wphealthtracker-dashboard-row-entry">
							<p>
								<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-firstdaytracked" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
								<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->d3_trans_3 . '</span>
								<span class="wphealthtracker-dashboard-row-entry-data">' . $this->first_exercise_date . '</span>
							</p>
						</div>
						<div class="wphealthtracker-dashboard-row-entry">
							<p>
								<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-exercise-totalperformed" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
								<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_61 . '</span>
								<span class="wphealthtracker-dashboard-row-entry-data">' . $this->total_exercises . '</span>
							</p>
						</div>
						<div class="wphealthtracker-dashboard-row-entry">
							<p>
								<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-totalhoursexercised" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
								<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_55 . '</span>
								<span class="wphealthtracker-dashboard-row-entry-data">' . $this->total_hours . ' ' . $this->translations->common_trans_50 . '</span>
							</p>
						</div>
						<div class="wphealthtracker-dashboard-row-entry">
							<p>
								<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-totalminutesexercised" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
								<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_54 . '</span>
								<span class="wphealthtracker-dashboard-row-entry-data">' . $this->total_minutes . ' ' . $this->translations->common_trans_49 . '</span>
							</p>
						</div>
						<div class="wphealthtracker-dashboard-row-entry">
							<p>
								<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-totalsecondsexercised" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
								<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_53 . '</span>
								<span class="wphealthtracker-dashboard-row-entry-data">' . $this->total_seconds . ' ' . $this->translations->common_trans_48 . '</span>
							</p>
						</div>
						<div class="wphealthtracker-dashboard-row-entry">
							<p>
								<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-exercise-longesthours" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
								<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_62 . '</span>
								<span class="wphealthtracker-dashboard-row-entry-data">' . $this->longest_hours . ' ' . $this->translations->common_trans_50 . '</span>
							</p>
						</div>
						<div class="wphealthtracker-dashboard-row-entry">
							<p>
								<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-exercise-longestminutes" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
								<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_63 . '</span>
								<span class="wphealthtracker-dashboard-row-entry-data">' . $this->longest_minutes . ' ' . $this->translations->common_trans_49 . '</span>
							</p>
						</div>
						<div class="wphealthtracker-dashboard-row-entry">
							<p>
								<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-exercise-longestseconds" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
								<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_64 . '</span>
								<span class="wphealthtracker-dashboard-row-entry-data">' . $this->longest_seconds . ' ' . $this->translations->common_trans_48 . '</span>
							</p>
						</div>
						<div class="wphealthtracker-dashboard-row-entry">
							<p>
								<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-exercise-averageoccurance" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
								<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_65 . '</span>
								<span class="wphealthtracker-dashboard-row-entry-data">' . $this->human_average_time .
							'</p>
						</div>
					</div>
				</div>';

			}

			// If there's no blood pressure data saved, display the 'No Data' message.
			if ( count( $this->alluserdata ) === 0 ) {
				$stats_3 = '<div style="bottom:58px;" class="wphealthtracker-no-saved-data-div">
				<p>
					<img class="wphealthtracker-shocked-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'shocked.svg">
					<span class="wphealthtracker-no-saved-span1">' . $this->translations->d3_trans_15 . '</span>
					<br>
					' . $this->translations->d3_trans_95 . '
					<br>' . $this->translations->d3_trans_98 . '
				</p>
			</div>';
			}

			array_push( $this->stats_array, $stats_1 );
			array_push( $this->stats_array, $stats_2 );
			array_push( $this->stats_array, $stats_3 );

			return $this->stats_array;

		}

	}
endif;
