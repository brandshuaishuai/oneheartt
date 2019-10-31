<?php
/**
 * Class WPHealthTracker_D3_Diet - class-d3-diet.php
 *
 * @author   Jake Evans
 * @category Transients
 * @package  Includes/Classes/D3/D3_diet
 * @version  0.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPHealthTracker_D3_Diet', false ) ) :
	/**
	 * WPHealthTracker_D3_Diet class. This class will hold all of the logic needed to create the d3 charts on the Vital Stats tab of the Stats menu page.
	 */
	class WPHealthTracker_D3_Diet {

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

		/** Member variables for use between the build_data_1(), build_stats_data_1(), and get_stats_area_html() functions
		 *
		 *  @var array $unique_food_items_array;
		 */
		public $unique_food_items_array = array();

		/** Member variables for use between the build_data_1(), build_stats_data_1(), and get_stats_area_html() functions
		 *
		 *  @var array $top_five_food_items;
		 */
		public $top_five_food_items = array();

		/** Member variables for use between the build_data_1(), build_stats_data_1(), and get_stats_area_html() functions
		 *
		 *  @var float $unique_foods_count;
		 */
		public $unique_foods_count = 0;

		/** Member variables for use between the build_data_1(), build_stats_data_1(), and get_stats_area_html() functions
		 *
		 *  @var float $total_cals;
		 */
		public $total_cals = 0;

		/** Member variables for use between the build_data_1(), build_stats_data_1(), and get_stats_area_html() functions
		 *
		 *  @var float $total_kcals;
		 */
		public $total_kcals = 0;

		/** Member variables for use between the build_data_1(), build_stats_data_1(), and get_stats_area_html() functions
		 *
		 *  @var float $total_kjoules;
		 */
		public $total_kjoules = 0;

		/** Member variables for use between the build_data_1(), build_stats_data_1(), and get_stats_area_html() functions
		 *
		 *  @var float $average_daily_protein;
		 */
		public $average_daily_protein = 0;

		/** Member variables for use between the build_data_1(), build_stats_data_1(), and get_stats_area_html() functions
		 *
		 *  @var float $protein_total;
		 */
		public $protein_total = 0;

		/** Member variables for use between the build_data_1(), build_stats_data_1(), and get_stats_area_html() functions
		 *
		 *  @var float $average_daily_carbs;
		 */
		public $average_daily_carbs = 0;

		/** Member variables for use between the build_data_1(), build_stats_data_1(), and get_stats_area_html() functions
		 *
		 *  @var float $this->carbs_total_total;
		 */
		public $carbs_total = 0;

		/** Member variables for use between the build_data_1(), build_stats_data_1(), and get_stats_area_html() functions
		 *
		 *  @var float $average_daily_sugars;
		 */
		public $average_daily_sugars = 0;

		/** Member variables for use between the build_data_1(), build_stats_data_1(), and get_stats_area_html() functions
		 *
		 *  @var float $average_daily_fiber;
		 */
		public $average_daily_fiber = 0;

		/** Member variables for use between the build_data_1(), build_stats_data_1(), and get_stats_area_html() functions
		 *
		 *  @var float $average_daily_fats;
		 */
		public $average_daily_fats = 0;

		/** Member variables for use between the build_data_1(), build_stats_data_1(), and get_stats_area_html() functions
		 *
		 *  @var float $fats_total;
		 */
		public $fats_total = 0;

		/** Member variables for use between the build_data_1(), build_stats_data_1(), and get_stats_area_html() functions
		 *
		 *  @var float $average_daily_satfats;
		 */
		public $average_daily_satfats = 0;

		/** Member variables for use between the build_data_1(), build_stats_data_1(), and get_stats_area_html() functions
		 *
		 *  @var float $average_daily_monounsatfats;
		 */
		public $average_daily_monounsatfats = 0;

		/** Member variables for use between the build_data_1(), build_stats_data_1(), and get_stats_area_html() functions
		 *
		 *  @var float $average_daily_polyunsatfats;
		 */
		public $average_daily_polyunsatfats = 0;

		/** Member variables for use between the build_data_2(), build_stats_data_2(), and get_stats_area_html() functions
		 *
		 *  @var int $energy_day_counter;
		 */
		public $energy_day_counter = 0;

		/** Member variables for use between the build_data_2(), build_stats_data_2(), and get_stats_area_html() functions
		 *
		 *  @var float $average_daily_calories;
		 */
		public $average_daily_calories = 0.00;

		/** Member variables for use between the build_data_2(), build_stats_data_2(), and get_stats_area_html() functions
		 *
		 *  @var float $average_daily_kilojoules;
		 */
		public $average_daily_kilojoules = 0.00;

		/** Member variables for use between the build_data_2(), build_stats_data_2(), and get_stats_area_html() functions
		 *
		 *  @var string $average_daily_calories;
		 */
		public $first_energy_date = '';

		/** Member variables for use between the build_data_2(), build_stats_data_2(), and get_stats_area_html() functions
		 *
		 *  @var string $highest_caloric_item
		 */
		public $highest_caloric_item = '';

		/** Member variables for use between the build_data_2(), build_stats_data_2(), and get_stats_area_html() functions
		 *
		 *  @var int $conseq_caloric_increase
		 */
		public $conseq_caloric_increase = '';

		/** Member variables for use between the build_data_2(), build_stats_data_2(), and get_stats_area_html() functions
		 *
		 *  @var int $conseq_caloric_decrease
		 */
		public $conseq_caloric_decrease = '';





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
			$this->translations->diet_tab_trans_strings();
			$this->translations->dashboard_trans_strings();
			$this->translations->tab_titles_trans_strings();
			$this->translations->common_trans_strings();
		}

		/**
		 *  Builds data array for first D3 chart
		 */
		public function build_data_1() {

			// Build array of food items.
			$food_items_array       = array();
			$food_calories_array    = array();
			$food_carbs_array       = array();
			$food_sugars_array      = array();
			$food_fiber_array       = array();
			$food_protein_array     = array();
			$food_fats_array        = array();
			$food_satfats_array     = array();
			$food_monosatfats_array = array();
			$food_polysatfats_array = array();
			foreach ( $this->alluserdata as $key => $indiv_day ) {

				// If we have multiple food items per day...
				if ( stripos( $indiv_day->foodstring, ',' ) !== false ) {
					$split_day = explode( ',', $indiv_day->foodstring );
					foreach ( $split_day as $key => $value ) {
						$split_day_items    = explode( ';', $value );
						$split_day_items[0] = ucfirst( $split_day_items[0] );
						array_push( $food_items_array, $split_day_items[0] . ';' . $split_day_items[1] );
						array_push( $food_calories_array, $split_day_items[3] . ';' . $split_day_items[4] );
						array_push( $food_carbs_array, $split_day_items[11] );
						array_push( $food_protein_array, $split_day_items[5] );
						array_push( $food_fats_array, $split_day_items[7] );
						array_push( $food_sugars_array, $split_day_items[13] );
						array_push( $food_fiber_array, $split_day_items[12] );
						array_push( $food_satfats_array, $split_day_items[8] );
						array_push( $food_monosatfats_array, $split_day_items[9] );
						array_push( $food_polysatfats_array, $split_day_items[10] );

					}
				} else {
					// One food item per day.
					$split_day_items = explode( ';', $indiv_day->foodstring );
					array_push( $food_items_array, $split_day_items[0] . ';' . $split_day_items[1] );
					array_push( $food_calories_array, $split_day_items[3] . ';' . $split_day_items[4] );
					array_push( $food_carbs_array, $split_day_items[11] );
					array_push( $food_protein_array, $split_day_items[5] );
					array_push( $food_fats_array, $split_day_items[7] );
					array_push( $food_sugars_array, $split_day_items[13] );
					array_push( $food_fiber_array, $split_day_items[12] );
					array_push( $food_satfats_array, $split_day_items[8] );
					array_push( $food_monosatfats_array, $split_day_items[9] );
					array_push( $food_polysatfats_array, $split_day_items[10] );
				}
			}

			// Making copy of food array.
			$temp_food_items_array   = $food_items_array;
			$unique_food_items_array = $food_items_array;
			$occurance_array         = array();
			$occurance_counter       = 0;

			foreach ( $unique_food_items_array as $key => $value ) {
				foreach ( $temp_food_items_array as $key2 => $value2 ) {
					if ( $value2 === $value ) {
						$occurance_counter++;
					}
				}

				// Record how many times that food item occurred, then reset counter.
				array_push( $occurance_array, $occurance_counter );
				$occurance_counter = 0;

			}

			// Now let's convert our energy to calories, kcals, and kJs.
			foreach ( $food_calories_array as $key => $value ) {

				$value    = explode( ';', $value );
				$calories = 0;
				$kcals    = 0;
				$kjs      = 0;

				if ( 'Calories' === $value[1] ) {
					$calories = $value[0];
					$kcals    = $value[0];
					$kjs      = round( ( $value[0] * 4.184 ), 2 );
				}

				if ( 'kcal' === $value[1] ) {
					$calories = $value[0];
					$kcals    = $value[0];
					$kjs      = round( ( $value[0] * 4.184 ), 2 );
				}

				if ( 'kJ' === $value[1] ) {
					if ( 0 !== $value[0] ) {
						$calories = round( ( $value[0] / 4.184 ), 2 );
						$kcals    = round( ( $value[0] / 4.184 ), 2 );
					}
					$kjs = $value[0];
				}

				$food_calories_array[ $key ] = number_format( $calories, 2 ) . ';' . number_format( $kcals, 2 ) . ';' . number_format( $kjs, 2 );
			}

			// Sort alphabetically, and keeping corresponding values if subsequent arrays matched up with their food item.
			array_multisort( $unique_food_items_array, $occurance_array, $food_calories_array, $food_carbs_array, $food_protein_array, $food_fats_array, $food_satfats_array, $food_monosatfats_array, $food_polysatfats_array, $food_sugars_array, $food_fiber_array );

			foreach ( $unique_food_items_array as $key => $value ) {
				array_push( $this->data_1_array, array(
					'letter'      => $value,
					'frequency'   => $occurance_array[ $key ],
					'calories'    => $food_calories_array[ $key ],
					'carbs'       => $food_carbs_array[ $key ],
					'protein'     => $food_protein_array[ $key ],
					'fats'        => $food_fats_array[ $key ],
					'satfats'     => $food_satfats_array[ $key ],
					'monosatfats' => $food_monosatfats_array[ $key ],
					'polysatfats' => $food_polysatfats_array[ $key ],
					'sugars'      => $food_sugars_array[ $key ],
					'fiber'       => $food_fiber_array[ $key ],
				));
			}

			// Set some class-wide variables to use in the build_stats_data_1() function.
			$this->unique_food_items_array = $unique_food_items_array;

			// If there was no saved Diet data at all, return an array holding the 'No Data Found' Html.
			if ( count( $this->data_1_array ) === 0 ) {
				return '<div class="wphealthtracker-no-saved-data-div">
				<p>
					<img class="wphealthtracker-shocked-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'shocked.svg">
					<span class="wphealthtracker-no-saved-span1">' . $this->translations->d3_trans_15 . '</span>
					<br>
					' . $this->translations->d3_trans_58 . '
					<br>' . $this->translations->d3_trans_60 . '
				</p>
			</div>';
			} else {
				return $this->data_1_array;
			}
		}

		/**
		 *  Builds data array for second D3 chart
		 */
		public function build_data_2() {

			// Build energy array of arrays.
			$temp_array = array();
			foreach ( $this->alluserdata as $key => $value ) {

				$this->energy_day_counter++;

				// If we have multiple food items per day...
				if ( stripos( $value->foodstring, ',' ) !== false ) {
					// Split up energy from it's measurement.
					$indiv_day = explode( ',', $value->foodstring );

					$total_cals = 0.00;
					$total_kjs  = 0.00;
					foreach ( $indiv_day as $key => $day ) {

						$day    = explode( ';', $day );
						$energy = $day[3];

						// If a energy has been recorded for this loop iteration...
						if ( '' !== $energy ) {

							if ( '' === $this->first_energy_date ) {
								$this->first_energy_date = $value->humandate;
							}

							// split up and format date.
							$date = explode( '-', $value->humandate );

							// Build final formatted date.
							$date = $date[2] . '-' . $date[0] . '-' . $date[1];

							// Build Energy.
							$energy_measurement = $day[4];

							// Build both Calories and Kilojoules.
							if ( $energy_measurement === $this->translations->d3_trans_9 ) {
								$energy_calories   = (float) $energy;
								$energy_kilojoules = '';
							} else {
								$energy_calories   = '';
								$energy_kilojoules = (float) $energy;
							}

							// Now convert Pounds to Kilograms.
							if ( '' !== $energy_calories ) {
								if ( 0 !== $energy ) {
									$energy_kilojoules = round( ( $energy / 4.184 ), 2 );
								}
							}

							// Now convert Kilograms to Pounds.
							if ( '' !== $energy_kilojoules ) {
								$energy_calories = round( ( $energy * 4.184 ), 2 );
							}

							$total_cals += round( $energy_calories, 2 );
							$total_kjs  += round( $energy_kilojoules, 2 );
						}
					}

					// Now push total calorie per day data into array.
					$temp_array = array(
						'date'                             => $date,
						$this->translations->diet_trans_34 => $total_cals,
						$this->translations->diet_trans_9  => $total_kjs,
					);

					// Push into final return array.
					array_push( $this->data_2_array, $temp_array );
					$total_cals = 0.00;
					$total_kjs  = 0.00;

				} else {

					$day    = explode( ';', $value->foodstring );
					$energy = $day[3];

					// If a energy has been recorded for this loop iteration...
					if ( '' !== $energy ) {

						if ( '' === $this->first_energy_date ) {
							$this->first_energy_date = $value->humandate;
						}

						// split up and format date.
						$date = explode( '-', $value->humandate );

						// Build final formatted date.
						$date = $date[2] . '-' . $date[0] . '-' . $date[1];

						// Build Energy.
						$energy_measurement = $day[4];

						// Build both Calories and Kilojoules.
						if ( $energy_measurement === $this->translations->d3_trans_9 ) {
							$energy_calories   = (float) $energy;
							$energy_kilojoules = '';
						} else {
							$energy_calories   = '';
							$energy_kilojoules = (float) $energy;
						}

						// Now convert Pounds to Kilograms.
						if ( '' !== $energy_calories ) {
							if ( 0 !== $energy ) {
								$energy_kilojoules = round( ( $energy / 4.184 ), 2 );
							}
						}

						// Now convert Kilograms to Pounds.
						if ( '' !== $energy_kilojoules ) {
							$energy_calories = round( ( $energy * 4.184 ), 2 );
						}

						$total_cals = round( $energy_calories, 2 );
						$total_kjs  = round( $energy_kilojoules, 2 );

					}

					// Now push total calorie per day data into array.
					$temp_array = array(
						'date'                             => $date,
						$this->translations->diet_trans_34 => $total_cals,
						$this->translations->diet_trans_9  => $total_kjs,
					);

					// Push into final return array.
					array_push( $this->data_2_array, $temp_array );
					$total_cals = 0.00;
					$total_kjs  = 0.00;
				}
			}

			// If there was no saved Diet data at all, return an array holding the 'No Data Found' Html.
			if ( count( $this->data_2_array ) === 0 ) {
				return '<div class="wphealthtracker-no-saved-data-div">
				<p>
					<img class="wphealthtracker-shocked-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'shocked.svg">
					<span class="wphealthtracker-no-saved-span1">' . $this->translations->d3_trans_15 . '</span>
					<br>
					' . $this->translations->d3_trans_64 . '
					<br>' . $this->translations->d3_trans_67 . '
				</p>
			</div>';
			} elseif ( count( $this->data_2_array ) === 1 ) {
				return '<div class="wphealthtracker-no-saved-data-div">
				<p>
					<img class="wphealthtracker-shocked-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'shocked.svg">
					<span class="wphealthtracker-no-saved-span1">' . $this->translations->d3_trans_15 . '</span>
					<br>
					' . $this->translations->d3_trans_68 . '
					<br>' . $this->translations->d3_trans_67 . '
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

			// Building average protein per day.
			$this->protein_total = 0;
			$protein_counter     = 0;
			foreach ( $this->alluserdata as $key => $value ) {
				// If we have saved data...
				if ( '' !== $value->foodstring ) {
					// Increment counter for averages and whatnot.
					$protein_counter++;

					if ( stripos( $value->foodstring, ',' ) !== false ) {
						$indiv_day = explode( ',', $value->foodstring );
						foreach ( $indiv_day as $key2 => $value2 ) {

							$indiv_day2 = explode( ';', $value2 );
							if ( '' !== $indiv_day2[5] ) {
								$this->protein_total += $indiv_day2[5];
							}
						}
					} else {
						$indiv_day = explode( ';', $value->foodstring );
						if ( '' !== $indiv_day[5] ) {
							$this->protein_total += $indiv_day[5];
						}
					}
				}
			}

			if ( 0 !== $this->protein_total && 0 !== $protein_counter ) {
				$this->average_daily_protein = round( ( $this->protein_total / $protein_counter ), 2 );
			}

			// Building average carbs per day.
			$this->carbs_total         = 0;
			$this->carbs_total_counter = 0;
			foreach ( $this->alluserdata as $key => $value ) {
				// If we have saved data...
				if ( '' !== $value->foodstring ) {
					// Increment counter for averages and whatnot.
					$this->carbs_total_counter++;

					if ( stripos( $value->foodstring, ',' ) !== false ) {
						$indiv_day = explode( ',', $value->foodstring );
						foreach ( $indiv_day as $key2 => $value2 ) {

							$indiv_day2 = explode( ';', $value2 );
							if ( '' !== $indiv_day2[11] ) {
								$this->carbs_total += $indiv_day2[11];
							}
						}
					} else {
						$indiv_day = explode( ';', $value->foodstring );
						if ( '' !== $indiv_day[11] ) {
							$this->carbs_total += $indiv_day[11];
						}
					}
				}
			}

			if ( 0 !== $this->carbs_total && 0 !== $this->carbs_total_counter ) {
				$this->average_daily_carbs = round( ( $this->carbs_total / $this->carbs_total_counter ), 2 );
			}

			// Building average fats per day.
			$this->fats_total = 0;
			$fats_counter     = 0;
			foreach ( $this->alluserdata as $key => $value ) {
				// If we have saved data...
				if ( '' !== $value->foodstring ) {
					// Increment counter for averages and whatnot.
					$fats_counter++;

					if ( stripos( $value->foodstring, ',' ) !== false ) {
						$indiv_day = explode( ',', $value->foodstring );
						foreach ( $indiv_day as $key2 => $value2 ) {

							$indiv_day2 = explode( ';', $value2 );
							if ( '' !== $indiv_day2[7] ) {
								$this->fats_total += $indiv_day2[7];
							}
						}
					} else {
						$indiv_day = explode( ';', $value->foodstring );
						if ( '' !== $indiv_day[7] ) {
							$this->fats_total += $indiv_day[7];
						}
					}
				}
			}

			if ( 0 !== $this->fats_total && 0 !== $fats_counter ) {
				$this->average_daily_fats = round( ( $this->fats_total / $fats_counter ), 2 );
			}

			$carb_array1 = array(
				'cat' => $this->translations->diet_trans_35,
				'val' => $this->average_daily_carbs,
			);

			$protein_array1 = array(
				'cat' => $this->translations->diet_trans_12,
				'val' => $this->average_daily_protein,
			);

			$fats_array1 = array(
				'cat' => $this->translations->diet_trans_36,
				'val' => $this->average_daily_fats,
			);

			$macro_array1 = array();
			array_push( $macro_array1, $carb_array1 );
			array_push( $macro_array1, $protein_array1 );
			array_push( $macro_array1, $fats_array1 );

			// Now push total calorie per day data into array.
			$temp_array1 = array(
				'type'  => $this->translations->d3_trans_71,
				'unit'  => $this->translations->dashboard_trans_40,
				'data'  => $macro_array1,
				'total' => round( $this->average_daily_carbs + $this->average_daily_protein + $this->average_daily_fats, 2 ),
			);

			$carb_array2 = array(
				'cat' => $this->translations->diet_trans_35,
				'val' => $this->carbs_total,
			);

			$protein_array2 = array(
				'cat' => $this->translations->diet_trans_12,
				'val' => $this->protein_total,
			);

			$fats_array2 = array(
				'cat' => $this->translations->diet_trans_36,
				'val' => $this->fats_total,
			);

			$macro_array2 = array();
			array_push( $macro_array2, $carb_array2 );
			array_push( $macro_array2, $protein_array2 );
			array_push( $macro_array2, $fats_array2 );

			// Now push total calorie per day data into array.
			$temp_array2 = array(
				'type'  => $this->translations->d3_trans_70,
				'unit'  => $this->translations->dashboard_trans_40,
				'data'  => $macro_array2,
				'total' => round( $this->carbs_total + $this->protein_total + $this->fats_total, 2 ),
			);

			array_push( $this->data_3_array, $temp_array1 );
			array_push( $this->data_3_array, $temp_array2 );

			// If there was no saved Diet data at all, return an array holding the 'No Data Found' Html.
			if ( count( $this->alluserdata ) === 0 ) {
				return '<div class="wphealthtracker-no-saved-data-div">
				<p>
					<img class="wphealthtracker-shocked-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'shocked.svg">
					<span class="wphealthtracker-no-saved-span1">' . $this->translations->d3_trans_15 . '</span>
					<br>
					' . $this->translations->d3_trans_102 . '
					<br>' . $this->translations->d3_trans_103 . '
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
			<img class="wphealthtracker-d3-chart-title-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'groceries.svg"/>		
			<img class="wphealthtracker-icon-image-question" id="wphealthtracker-icon-image-question-d3-chart-title" data-label="d3-diet-foodchartandstats" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg" /><p class="wphealthtracker-d3-chart-title-actual">' . $this->translations->d3_trans_53 . '</p>
			<div class="wphealthtracker-d3-chart-title-line"></div>';

			$title_2 = '
			<img class="wphealthtracker-d3-chart-title-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'bolt.svg"/>		
			<img class="wphealthtracker-icon-image-question" id="wphealthtracker-icon-image-question-d3-chart-title" data-label="d3-diet-energychartandstats" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg" /><p class="wphealthtracker-d3-chart-title-actual">' . $this->translations->d3_trans_62 . '</p>
			<div class="wphealthtracker-d3-chart-title-line"></div>';

			$title_3 = '
			<img class="wphealthtracker-d3-chart-title-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'scales.svg"/>		
			<img class="wphealthtracker-icon-image-question" id="wphealthtracker-icon-image-question-d3-chart-title" data-label="d3-diet-macrobutrientschartandstats" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg" /><p class="wphealthtracker-d3-chart-title-actual">' . $this->translations->d3_trans_63 . '</p>
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

			// Build total Unique Food Items and most eaten food.
			$orig_unique_foods        = $this->unique_food_items_array;
			$final_unique_foods       = array_unique( $this->unique_food_items_array );
			$this->unique_foods_count = count( $final_unique_foods );
			$values                   = array_count_values( $orig_unique_foods );
			arsort( $values );
			$this->top_five_food_items = array_slice( array_keys( $values ), 0, 5, true );

			if ( isset( $this->top_five_food_items[0] ) ) {
				$temp_top_food_item        = explode( ';', $this->top_five_food_items[0] );
				$this->top_five_food_items = $temp_top_food_item[0];
			}

			$total_cals = 0;
			foreach ( $this->alluserdata as $key => $value ) {
				// If we have multiple food items per day...
				if ( stripos( $value->foodstring, ',' ) !== false ) {
					$split_day = explode( ',', $value->foodstring );
					foreach ( $split_day as $key2 => $value2 ) {
						$split_day_items = explode( ';', $value2 );

						// Now convert energy.
						$calories = 0;
						$kcals    = 0;
						$kjs      = 0;

						if ( 'Calories' === $split_day_items[4] ) {
							$calories = $split_day_items[3];
							$kcals    = $split_day_items[3];
							$kjs      = round( ( $split_day_items[3] * 4.184 ), 2 );
						}

						if ( 'kcal' === $split_day_items[4] ) {
							$calories = $split_day_items[3];
							$kcals    = $split_day_items[3];
							$kjs      = round( ( $split_day_items[3] * 4.184 ), 2 );
						}

						if ( 'kJ' === $split_day_items[4] ) {
							if ( 0 !== $split_day_items[3] ) {
								$calories = round( ( $split_day_items[3] / 4.184 ), 2 );
								$kcals    = round( ( $split_day_items[3] / 4.184 ), 2 );
							}

							$kjs = $split_day_items[3];
						}

						$this->total_cals    += $calories;
						$this->total_kcals   += $kcals;
						$this->total_kjoules += $kjs;
					}
				} else {
					// One food item per day.
					$split_day_items = explode( ';', $value->foodstring );

					// Now convert energy.
					$calories = 0;
					$kcals    = 0;
					$kjs      = 0;

					if ( 'Calories' === $split_day_items[4] ) {
						$calories = $split_day_items[3];
						$kcals    = $split_day_items[3];
						$kjs      = round( ( $split_day_items[3] * 4.184 ), 2 );
					}

					if ( 'kcal' === $split_day_items[4] ) {
						$calories = $split_day_items[3];
						$kcals    = $split_day_items[3];
						$kjs      = round( ( $split_day_items[3] * 4.184 ), 2 );
					}

					if ( 'kJ' === $split_day_items[4] ) {
						if ( 0 !== $split_day_items[3] ) {
							$calories = round( ( $split_day_items[3] / 4.184 ), 2 );
							$kcals    = round( ( $split_day_items[3] / 4.184 ), 2 );
						}
						$kjs = $split_day_items[3];
					}

					$this->total_cals    += $calories;
					$this->total_kcals   += $kcals;
					$this->total_kjoules += $kjs;
				}
			}
			$this->total_cals = number_format( round( $this->total_cals, 2 ), 2 );

			// Building average protein per day.
			$protein         = 0;
			$protein_counter = 0;
			foreach ( $this->alluserdata as $key => $value ) {
				// If we have saved data...
				if ( '' !== $value->foodstring ) {
					// Increment counter for averages and whatnot.
					$protein_counter++;

					if ( stripos( $value->foodstring, ',' ) !== false ) {
						$indiv_day = explode( ',', $value->foodstring );
						foreach ( $indiv_day as $key2 => $value2 ) {

							$indiv_day2 = explode( ';', $value2 );
							if ( '' !== $indiv_day2[5] ) {
								$protein += $indiv_day2[5];
							}
						}
					} else {
						$indiv_day = explode( ';', $value->foodstring );
						if ( '' !== $indiv_day[5] ) {
							$protein += $indiv_day[5];
						}
					}
				}
			}

			if ( 0 !== $protein && 0 !== $protein_counter ) {
				$this->average_daily_protein = round( ( $protein / $protein_counter ), 2 );
			}

			// Building average carbs per day.
			$this->carbs_total         = 0;
			$this->carbs_total_counter = 0;
			foreach ( $this->alluserdata as $key => $value ) {
				// If we have saved data...
				if ( '' !== $value->foodstring ) {
					// Increment counter for averages and whatnot.
					$this->carbs_total_counter++;

					if ( stripos( $value->foodstring, ',' ) !== false ) {
						$indiv_day = explode( ',', $value->foodstring );
						foreach ( $indiv_day as $key2 => $value2 ) {

							$indiv_day2 = explode( ';', $value2 );
							if ( '' !== $indiv_day2[11] ) {
								$this->carbs_total += $indiv_day2[11];
							}
						}
					} else {
						$indiv_day = explode( ';', $value->foodstring );
						if ( '' !== $indiv_day[11] ) {
							$this->carbs_total += $indiv_day[11];
						}
					}
				}
			}

			if ( 0 !== $this->carbs_total && 0 !== $this->carbs_total_counter ) {
				$this->average_daily_carbs = round( ( $this->carbs_total / $this->carbs_total_counter ), 2 );
			}

			// Building average sugars per day.
			$sugars         = 0;
			$sugars_counter = 0;
			foreach ( $this->alluserdata as $key => $value ) {
				// If we have saved data...
				if ( '' !== $value->foodstring ) {
					// Increment counter for averages and whatnot.
					$sugars_counter++;

					if ( stripos( $value->foodstring, ',' ) !== false ) {
						$indiv_day = explode( ',', $value->foodstring );
						foreach ( $indiv_day as $key2 => $value2 ) {

							$indiv_day2 = explode( ';', $value2 );
							if ( '' !== $indiv_day2[13] ) {
								$sugars += $indiv_day2[13];
							}
						}
					} else {
						$indiv_day = explode( ';', $value->foodstring );
						if ( '' !== $indiv_day[13] ) {
							$sugars += $indiv_day[13];
						}
					}
				}
			}

			if ( 0 !== $sugars && 0 !== $sugars_counter ) {
				$this->average_daily_sugars = round( ( $sugars / $sugars_counter ), 2 );
			}

			// Building average fiber per day.
			$fiber         = 0;
			$fiber_counter = 0;
			foreach ( $this->alluserdata as $key => $value ) {
				// If we have saved data...
				if ( '' !== $value->foodstring ) {
					// Increment counter for averages and whatnot.
					$fiber_counter++;

					if ( stripos( $value->foodstring, ',' ) !== false ) {
						$indiv_day = explode( ',', $value->foodstring );
						foreach ( $indiv_day as $key2 => $value2 ) {

							$indiv_day2 = explode( ';', $value2 );
							if ( '' !== $indiv_day2[12] ) {
								$fiber += $indiv_day2[12];
							}
						}
					} else {
						$indiv_day = explode( ';', $value->foodstring );
						if ( '' !== $indiv_day[12] ) {
							$fiber += $indiv_day[12];
						}
					}
				}
			}

			if ( 0 !== $fiber && 0 !== $fiber_counter ) {
				$this->average_daily_fiber = round( ( $fiber / $fiber_counter ), 2 );
			}

			// Building average fats per day.
			$this->fats_total = 0;
			$fats_counter     = 0;
			foreach ( $this->alluserdata as $key => $value ) {
				// If we have saved data...
				if ( '' !== $value->foodstring ) {
					// Increment counter for averages and whatnot.
					$fats_counter++;

					if ( stripos( $value->foodstring, ',' ) !== false ) {
						$indiv_day = explode( ',', $value->foodstring );
						foreach ( $indiv_day as $key2 => $value2 ) {

							$indiv_day2 = explode( ';', $value2 );
							if ( '' !== $indiv_day2[7] ) {
								$this->fats_total += $indiv_day2[7];
							}
						}
					} else {
						$indiv_day = explode( ';', $value->foodstring );
						if ( '' !== $indiv_day[7] ) {
							$this->fats_total += $indiv_day[7];
						}
					}
				}
			}

			if ( 0 !== $this->fats_total && 0 !== $fats_counter ) {
				$this->average_daily_fats = round( ( $this->fats_total / $fats_counter ), 2 );
			}

			// Building average satfats per day.
			$satfats         = 0;
			$satfats_counter = 0;
			foreach ( $this->alluserdata as $key => $value ) {
				// If we have saved data...
				if ( '' !== $value->foodstring ) {
					// Increment counter for averages and whatnot.
					$satfats_counter++;

					if ( stripos( $value->foodstring, ',' ) !== false ) {
						$indiv_day = explode( ',', $value->foodstring );
						foreach ( $indiv_day as $key2 => $value2 ) {

							$indiv_day2 = explode( ';', $value2 );
							if ( '' !== $indiv_day2[8] ) {
								$satfats += $indiv_day2[8];
							}
						}
					} else {
						$indiv_day = explode( ';', $value->foodstring );
						if ( '' !== $indiv_day[8] ) {
							$satfats += $indiv_day[8];
						}
					}
				}
			}

			if ( 0 !== $satfats && 0 !== $satfats_counter ) {
				$this->average_daily_satfats = round( ( $satfats / $satfats_counter ), 2 );
			}

			// Building average monounsatfats per day.
			$monounsatfats         = 0;
			$monounsatfats_counter = 0;
			foreach ( $this->alluserdata as $key => $value ) {
				// If we have saved data...
				if ( '' !== $value->foodstring ) {
					// Increment counter for averages and whatnot.
					$monounsatfats_counter++;

					if ( stripos( $value->foodstring, ',' ) !== false ) {
						$indiv_day = explode( ',', $value->foodstring );
						foreach ( $indiv_day as $key2 => $value2 ) {

							$indiv_day2 = explode( ';', $value2 );
							if ( '' !== $indiv_day2[9] ) {
								$monounsatfats += $indiv_day2[9];
							}
						}
					} else {
						$indiv_day = explode( ';', $value->foodstring );
						if ( '' !== $indiv_day[9] ) {
							$monounsatfats += $indiv_day[9];
						}
					}
				}
			}

			if ( 0 !== $monounsatfats && 0 !== $monounsatfats_counter ) {
				$this->average_daily_monounsatfats = round( ( $monounsatfats / $monounsatfats_counter ), 2 );
			}

			// Building average polyunsatfats per day.
			$polyunsatfats         = 0;
			$polyunsatfats_counter = 0;
			foreach ( $this->alluserdata as $key => $value ) {
				// If we have saved data...
				if ( '' !== $value->foodstring ) {
					// Increment counter for averages and whatnot.
					$polyunsatfats_counter++;

					if ( stripos( $value->foodstring, ',' ) !== false ) {
						$indiv_day = explode( ',', $value->foodstring );
						foreach ( $indiv_day as $key2 => $value2 ) {

							$indiv_day2 = explode( ';', $value2 );
							if ( '' !== $indiv_day2[10] ) {
								$polyunsatfats += $indiv_day2[10];
							}
						}
					} else {
						$indiv_day = explode( ';', $value->foodstring );
						if ( '' !== $indiv_day[10] ) {
							$polyunsatfats += $indiv_day[10];
						}
					}
				}
			}

			if ( 0 !== $polyunsatfats && 0 !== $polyunsatfats_counter ) {
				$this->average_daily_polyunsatfats = round( ( $polyunsatfats / $polyunsatfats_counter ), 2 );
			}
		}

		/**
		 *  Builds the stats data variables to be later used in the Stats HTML for the second section
		 */
		public function build_stats_data_2() {

			// Building average calories per day.
			$calories                 = 0;
			$calories_counter         = 0;
			$highest_caloric_food     = '';
			$highest_calories_counter = 0;
			$daily_cal_total          = 0;
			$daily_cal_array          = array();
			$conseq_increase_array    = array();
			$conseq_decrease_array    = array();
			$conseq_increase_counter  = 0;
			$conseq_decrease_counter  = 0;
			foreach ( $this->alluserdata as $key => $value ) {
				// If we have saved data...
				if ( '' !== $value->foodstring ) {
					// Increment counter for averages and whatnot.
					$calories_counter++;

					if ( stripos( $value->foodstring, ',' ) !== false ) {
						$indiv_day = explode( ',', $value->foodstring );
						foreach ( $indiv_day as $key2 => $value2 ) {

							$indiv_day2 = explode( ';', $value2 );
							if ( '' !== $indiv_day2[3] ) {
								$calories += $indiv_day2[3];

								$energy = 0;
								if ( 'kJ' === $indiv_day2[4] ) {
									if ( 0 !== $indiv_day2[3] ) {
										$energy = round( ( $indiv_day2[3] / 4.184 ), 2 );
									}
								} else {
									$energy = $indiv_day2[3];
								}
								if ( $energy > $highest_calories_counter ) {
									$highest_calories_counter = $energy;
									$highest_caloric_food     = $indiv_day2[0] . ';' . $indiv_day2[1];
								}

								$daily_cal_total += $energy;

							}
						}
					} else {
						$indiv_day = explode( ';', $value->foodstring );
						if ( '' !== $indiv_day[3] ) {
							$calories += $indiv_day[3];

							$energy = 0;
							if ( 'kJ' === $indiv_day[4] ) {
								if ( 0 !== $indiv_day[3] ) {
									$energy = round( ( $indiv_day[3] / 4.184 ), 2 );
								}
							} else {
								$energy = $indiv_day[3];
							}
							if ( $energy > $highest_calories_counter ) {
								$highest_calories_counter = $energy;
								$highest_caloric_food     = $indiv_day[0] . ';' . $indiv_day[1];
							}

							$daily_cal_total += $energy;

						}
					}

					if ( 0 !== $key ) {

						if ( $daily_cal_total > $daily_cal_array[ count( $daily_cal_array ) - 1 ] ) {
							$conseq_increase_counter++;
							array_push( $conseq_increase_array, $conseq_increase_counter );
							$conseq_decrease_counter = 0;
						}

						if ( $daily_cal_total < $daily_cal_array[ count( $daily_cal_array ) - 1 ] ) {
							$conseq_decrease_counter++;
							array_push( $conseq_decrease_array, $conseq_decrease_counter );
							$conseq_increase_counter = 0;
						}

						array_push( $daily_cal_array, $daily_cal_total );
					} else {
						array_push( $daily_cal_array, $daily_cal_total );
					}

					$daily_cal_total = 0;
				}
			}

			rsort( $conseq_increase_array );
			rsort( $conseq_decrease_array );

			// Calculating final averages.
			if ( 0 !== $calories && 0 !== $calories_counter ) {
				$this->average_daily_calories = round( ( $calories / $calories_counter ), 2 );
			}
			$this->average_daily_kilojoules = round( ( $this->average_daily_calories * 4.184 ), 2 );
			$this->highest_caloric_item     = explode( ';', $highest_caloric_food );
			$this->highest_caloric_item     = $this->highest_caloric_item[0] . ' <span class="wphealthtracker-diet-span">(' . $highest_calories_counter . ' ' . $this->translations->diet_trans_41 . '/' . ( round( ( $highest_calories_counter * 4.184 ), 0 ) ) . ' ' . $this->translations->diet_trans_42 . ')</span>';

			if ( count( $conseq_increase_array ) === 0 ) {
				$this->conseq_caloric_increase = 0;
			} else {
				$this->conseq_caloric_increase = $conseq_increase_array[0];
			}

			if ( count( $conseq_decrease_array ) === 0 ) {
				$this->conseq_caloric_decrease = 0;
			} else {
				$this->conseq_caloric_decrease = $conseq_decrease_array[0];
			}

		}

		/**
		 *  Builds the stats data variables to be later used in the Stats HTML for the third section
		 */
		public function build_stats_data_3() {

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

			// If there is more than 1 day of Diet data saved...
			$stats_1 = '';
			if ( count( $this->alluserdata ) > 0 ) {
				$stats_1 = '
			<img class="wphealthtracker-d3-chart-title-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'computer.svg"/>		
			<p class="wphealthtracker-d3-chart-subtitle-actual">' . $this->translations->tab_title_5 . '</p>
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
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-totalunique" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->d3_trans_55 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->unique_foods_count . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-diet-mostconsumedfood" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->d3_trans_56 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->top_five_food_items . ' </span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-diet-totalcalsconsumed" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->d3_trans_57 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->total_cals . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-diet-totalkilojoulesconsumed" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->d3_trans_61 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->total_kjoules . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-averagedailyprotein" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_35 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->average_daily_protein . ' ' . $this->translations->dashboard_trans_40 . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-averagedailycarbs" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_36 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->average_daily_carbs . ' ' . $this->translations->dashboard_trans_40 . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-averagedailysugars" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_37 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->average_daily_sugars . ' ' . $this->translations->dashboard_trans_40 . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-averagedailyfiber" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_39 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->average_daily_fiber . ' ' . $this->translations->dashboard_trans_40 . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-averagedailytotalfats" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_38 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->average_daily_fats . ' ' . $this->translations->dashboard_trans_40 . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-diet-averagesatfat" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_44 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->average_daily_satfats . ' ' . $this->translations->dashboard_trans_40 . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-diet-averagemonosatfat" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_45 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->average_daily_monounsatfats . ' ' . $this->translations->dashboard_trans_40 . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-diet-averagepolysatfat" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_46 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->average_daily_polyunsatfats . ' ' . $this->translations->dashboard_trans_40 . '</span>
						</p>
					</div>
				</div>
			</div>';

			}

			// If there's no diet data saved, display the 'No Data' message.
			if ( count( $this->alluserdata ) === 0 ) {
				$stats_1 = '<div class="wphealthtracker-no-saved-data-div">
				<p>
					<img class="wphealthtracker-shocked-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'shocked.svg">
					<span class="wphealthtracker-no-saved-span1">' . $this->translations->d3_trans_15 . '</span>
					<br>
					' . $this->translations->d3_trans_58 . '
					<br>' . $this->translations->d3_trans_59 . '
				</p>
			</div>';
			}

			// If there is 1 or more day of Food data with Calories data saved...
			$stats_2 = '';
			if ( $this->energy_day_counter > 0 ) {
				$stats_2 = '
			<img class="wphealthtracker-d3-chart-title-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'computer.svg"/>		
			<p class="wphealthtracker-d3-chart-subtitle-actual">' . $this->translations->d3_trans_66 . '</p>
			<div class="wphealthtracker-d3-chart-title-line"></div>
			<div class="wphealthtracker-dashboard-actual-info">
				<div class="wphealthtracker-dashboard-row">
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-firstdaytracked" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->d3_trans_3 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->first_energy_date . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-diet-totalcalsconsumed" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->d3_trans_57 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->total_cals . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-diet-totalkilojoulesconsumed" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->d3_trans_61 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->total_kjoules . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-averagedailycals" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_42 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->average_daily_calories . '
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-averagedailykilojoules" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_43 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->average_daily_kilojoules . '
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-diet-highestsinglefood" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->diet_trans_43 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->highest_caloric_item . '
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-diet-highestconseqdecrease" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->diet_trans_44 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->conseq_caloric_decrease . ' ' . $this->translations->common_trans_46 . '
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-diet-highestconseqincrease" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->diet_trans_45 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->conseq_caloric_increase . ' ' . $this->translations->common_trans_46 . '
						</p>
					</div>
				</div>
			</div>';

			}

			// If there is no Food data with Calories data saved, display the the 'No Data' message.
			if ( 0 === $this->energy_day_counter ) {
				$stats_2 = '<div class="wphealthtracker-no-saved-data-div">
				<p>
					<img class="wphealthtracker-shocked-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'shocked.svg">
					<span class="wphealthtracker-no-saved-span1">' . $this->translations->d3_trans_15 . '</span>
					<br>
					' . $this->translations->d3_trans_64 . '
					<br>' . $this->translations->d3_trans_65 . '
				</p>
			</div>';
			}

			// If there is 1 or more days of Diet data saved...
			$stats_3 = '';
			if ( count( $this->alluserdata ) > 0 ) {
				$stats_3 = '
			<img class="wphealthtracker-d3-chart-title-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'computer.svg"/>		
			<p class="wphealthtracker-d3-chart-subtitle-actual">' . $this->translations->d3_trans_73 . '</p>
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
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-averagedailycarbs" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_36 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->average_daily_carbs . ' ' . $this->translations->dashboard_trans_40 . '
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-averagedailyprotein" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_35 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->average_daily_protein . ' ' . $this->translations->dashboard_trans_40 . '
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-averagedailytotalfats" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_38 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->average_daily_fats . ' ' . $this->translations->dashboard_trans_40 . '
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-diet-totalprotein" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_48 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->protein_total . ' ' . $this->translations->dashboard_trans_40 . '
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-diet-totalcarbs" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_47 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->carbs_total . ' ' . $this->translations->dashboard_trans_40 . '
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-diet-totalfats" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_49 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->fats_total . ' ' . $this->translations->dashboard_trans_40 . '
						</p>
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
					' . $this->translations->d3_trans_102 . '
					<br>' . $this->translations->d3_trans_104 . '
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
