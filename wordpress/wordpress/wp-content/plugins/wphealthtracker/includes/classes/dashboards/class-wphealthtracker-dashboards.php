<?php
/**
 * Class WPHealthTracker_Dashboards - class-dashboards.php
 *
 * @author   Jake Evans
 * @category Transients
 * @package  Includes/Classes/Dashboards
 * @version  0.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPHealthTracker_Dashboards', false ) ) :
	/**
	 * WPHealthTracker_Dashboards class. This class will hold all of the logic needed to create the dashboards on the various Stats tabs, as well as outputting those dashboards to the front-end via shortcode
	 */
	class WPHealthTracker_Dashboards {


		// Common class variables.
		public $wpuserid           = null;
		public $tab                = null;
		public $title_area         = '';
		public $allsavedusersdata   = array();
		public $displayname        = '';
		public $userstablerow      = array();
		public $users_table        = '';
		public $profileimg         = '';
		public $total_days_tracked = 0;
		public $most_conseq_days   = 0;
		public $largest_gap        = 0;
		public $num_of_gaps        = 0;
		public $first_date_tracked = '';
		public $last_date_tracked  = '';
		public $final_output       = '';


		// Unique to Vitals Stats
		public $starting_weight = '';
		public $recent_weight   = '';
		public $starting_chol   = '';
		public $recent_chol     = '';
		public $starting_bp     = '';
		public $ending_bp       = '';

		// Unique to Diet Stats
		public $average_daily_cals    = '';
		public $average_daily_kcals   = '';
		public $average_daily_kjs     = '';
		public $unique_foods_count    = 0;
		public $top_five_food_items   = array();
		public $average_daily_protein = 0;
		public $average_daily_carbs   = 0;
		public $average_daily_sugars  = 0;
		public $average_daily_fats    = 0;
		public $average_daily_fiber =  0;
		public $average_daily_calories =  0;
		public $average_daily_kilojoules =  0;

		// Unique to Exercise Stats
		public $total_seconds = 0;
		public $total_hours   = 0;
		public $total_minutes = 0;
		public $top_five_exercise_items = array();
		public $unique_exercises_count = 0;

		/** Class Constructor
		 *
		 *  @param array  $userdata - The user's complete data set - all food items.
		 *  @param int    $wpuserid - The user's WordPress ID.
		 *  @param string $tab - The tab that is requesting the dashboard.
		 */
		public function __construct( $userdata, $wpuserid = null, $tab = null ) {

			// Setting some class variables.
			global $wpdb;
			$this->wpuserid          = $wpuserid;
			$this->tab               = $tab;
			$this->allsavedusersdata = $userdata;
			$this->users_table       = $wpdb->prefix . 'wphealthtracker_users';

			// Require the translations file.
			require_once WPHEALTHTRACKER_CLASSES_TRANSLATIONS_DIR . 'class-wphealthtracker-translations.php';
			$this->translations = new WPHealthTracker_Translations();
			$this->translations->dashboard_trans_strings();
			$this->translations->common_trans_strings();

			// If data was found for the user...
			if ( count( $this->allsavedusersdata ) > 0 ) {

				// Calculate all common data.
				$this->calculate_common_data();

				// A switch to build values specific to each tab.
				switch ( $tab ) {
					case 'Vitals':
						$this->calculate_vitals_data();
						break;
					case 'Diet':
						$this->calculate_diet_data();
						break;
					case 'Exercise':
						$this->calculate_exercise_data();
						break;

					default:
						// code...
						break;
				}
			}

		}

		/**
		 *  Function that handles outputting the no data message, if no data is found for the user
		 */
		public function output_no_data() {

			// Getting the user's display name.
			$this->get_user_name();

			// Build final output, including the no data message.
			$this->final_output = '<div class="wphealthtracker-no-saved-data-stats-div">
				<p>
					<img class="wphealthtracker-shocked-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'shocked.svg"/>
					<span class="wphealthtracker-no-saved-span-stats-1">' . $this->translations->dashboard_trans_21 . '</span>
					<br/>
					' . $this->translations->dashboard_trans_22 . ' ' . $this->displayname . '!
					<br/><a href="' . admin_url( 'admin.php?page=WPHealthTracker-tracker' ) . '&tab=' . $this->tab . '">' . $this->translations->dashboard_trans_23 . '</a>
					<br/><br/>
				</p>
			</div>';

			return $this->final_output;
		}

		/**
		 *  Function that get's the user's name.
		 */
		public function get_user_name() {

			global $wpdb;

			// Make call to Transients class to see if Transient currently exists. If so, retrieve it, if not, make call to create_transient() with all required Parameters.
			require_once WPHEALTHTRACKER_CLASSES_TRANSIENTS_DIR . 'class-wphealthtracker-transients.php';
			$transients       = new WPHealthTracker_Transients();
			$transient_name   = 'wpht_' . $this->wpuserid . '_' . md5( 'SELECT * FROM ' . $this->users_table . ' WHERE wpuserid = ' . $this->wpuserid );
			$transient_exists = $transients->existing_transient_check( $transient_name );
			if ( $transient_exists ) {
				$userstablerow = $transient_exists;
			} else {
				$query = $wpdb->prepare( "SELECT * FROM $this->users_table WHERE wpuserid = %d", $this->wpuserid );

				$userstablerow = $transients->create_transient( $transient_name, 'wpdb->get_row', $query, MONTH_IN_SECONDS );
			}

			$this->displayname = $userstablerow->firstname . ' ' . $userstablerow->lastname;
			$this->profileimg  = $userstablerow->profileimage;
		}

		/**
		 *  Function that sets the common data common to all dashboards regardless of tab.
		 */
		public function calculate_common_data() {

			$this->total_days_tracked = count( $this->allsavedusersdata );
			$this->first_date_tracked = $this->allsavedusersdata[0]->humandate;
			$this->last_date_tracked  = $this->allsavedusersdata[ ( $this->total_days_tracked - 1 ) ]->humandate;

			// Now modify the humandate in each of the saved dates to convert to day of the year instead of a date.
			$first_day_of_year = 0;
			$prev_day_of_year  = 0;
			$gap_tracker       = 0;
			$gap_array         = array();

			// Building Gap array.
			foreach ( $this->allsavedusersdata as $key => $indiv_day ) {
				$indiv_day->humandate = str_replace( '-', '/', $indiv_day->humandate );
				$day_of_year          = date( 'z', strtotime( $indiv_day->humandate ) );

				if ( 0 !== $key ) {
					$prev_day_of_year = $this->allsavedusersdata[ $key - 1 ]->humandate;
					$prev_day_of_year = date( 'z', strtotime( $prev_day_of_year ) );
				}

				if ( ( 1 !== $day_of_year - $prev_day_of_year ) && ( 0 !== $prev_day_of_year ) ) {
					$gap_tracker = $day_of_year - $prev_day_of_year;
				} else {
					if ( 0 !== $gap_tracker ) {
						array_push( $gap_array, $gap_tracker );
					}
					$gap_tracker = 0;
				}
			}

			// Push last possible value if needed.
			if ( $gap_tracker > 0 ) {
				array_push( $gap_array, $gap_tracker );
			}

			// Reset values.
			$first_day_of_year = 0;
			$prev_day_of_year  = 0;

			// Set new values.
			$conseq_tracker = 1;
			$conseq_array   = array();

			// Building Consecutive array.
			foreach ( $this->allsavedusersdata as $key => $indiv_day ) {
				$indiv_day->humandate = str_replace( '-', '/', $indiv_day->humandate );
				$day_of_year          = date( 'z', strtotime( $indiv_day->humandate ) );

				if ( 0 !== $key ) {
					$prev_day_of_year = $this->allsavedusersdata[ $key - 1 ]->humandate;
					$prev_day_of_year = date( 'z', strtotime( $prev_day_of_year ) );
				}

				if ( 1 === $day_of_year - $prev_day_of_year ) {
					$conseq_tracker++;
				} else {
					if ( 1 !== $conseq_tracker ) {
						array_push( $conseq_array, $conseq_tracker );
					}
					$conseq_tracker = 1;
				}
			}

			// Push last possible value if needed.
			if ( $conseq_tracker > 1 ) {
				array_push( $conseq_array, $conseq_tracker );
			}

			$conseq_array = array_unique( $conseq_array );
			$gap_array    = array_unique( $gap_array );

			rsort( $conseq_array );
			rsort( $gap_array );

			if ( count( $conseq_array ) > 0 ) {
				$this->most_conseq_days = $conseq_array[0] . ' ' . $this->translations->dashboard_trans_3;
			} else {
				$this->most_conseq_days = $this->translations->dashboard_trans_31 . '<img class="wphealthtracker-stats-good-data-smile"src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'shocked.svg"/>';
			}

			if ( 0 === count( $gap_array ) ) {
				$this->largest_gap = $this->translations->dashboard_trans_24 . '<img class="wphealthtracker-stats-good-data-smile"src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'happy.svg"/>';
				$this->num_of_gaps = $this->translations->dashboard_trans_24 . '<img class="wphealthtracker-stats-good-data-smile"src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'happy.svg"/>';
			} else {
				$this->largest_gap = $gap_array[0] . ' ' . $this->translations->dashboard_trans_3;
				$this->num_of_gaps = count( $gap_array ) . ' ' . $this->translations->dashboard_trans_32;
			}

		}

		/**
		 *  Function that sets the Vitals data
		 */
		public function calculate_vitals_data() {

			// Create Starting Weight.
			foreach ( $this->allsavedusersdata as $key => $value ) {
				if ( substr( $value->weight, 0, 1 ) !== ';' ) {
					$this->starting_weight = $this->allsavedusersdata[0]->weight;
					$this->starting_weight = str_replace( ';', ' ', $this->starting_weight );
					break;
				}
			}
			if ( '' === $this->starting_weight ) {
				$this->starting_weight = $this->translations->dashboard_trans_25 . '<img class="wphealthtracker-stats-good-data-smile"src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'shocked.svg"/>';
			}

			// Create Ending Weight.
			$temp_array = array_reverse( $this->allsavedusersdata );
			foreach ( $temp_array as $key => $value ) {
				if ( ';' !== substr( $value->weight, 0, 1 ) ) {
					$this->recent_weight = $value->weight;
					$this->recent_weight = str_replace( ';', ' ', $this->recent_weight );
					break;
				}
			}

			if ( '' === $this->recent_weight ) {
				$this->recent_weight = $this->translations->dashboard_trans_26 . '<img class="wphealthtracker-stats-good-data-smile"src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'shocked.svg"/>';
			}

			// Create Starting Cholesterol Value.
			foreach ( $this->allsavedusersdata as $key => $value ) {
				if ( ',,,' === $value->cholesterol ) {
					$this->starting_chol = $this->translations->dashboard_trans_27 . '<img class="wphealthtracker-stats-good-data-smile"src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'shocked.svg"/>';
				} else {
					$this->starting_chol = $value->cholesterol;
					$this->starting_chol = explode( ',', $this->starting_chol );
					$this->starting_chol = $this->starting_chol[0] . '<span class="wphealthtracker-chol-span">(' . $this->translations->dashboard_trans_15 . ')</span> ' . $this->starting_chol[1] . '<span class="wphealthtracker-chol-span">(' . $this->translations->dashboard_trans_16 . ')</span> ' . $this->starting_chol[2] . '<span class="wphealthtracker-chol-span">(' . $this->translations->dashboard_trans_17 . ')</span> ' . $this->starting_chol[3] . '<span class="wphealthtracker-chol-span">(' . $this->translations->dashboard_trans_18 . ')</span>';
					break;
				}
			}

			// Create Ending Cholesterol Value.
			$temp_array = array_reverse( $this->allsavedusersdata );
			foreach ( $temp_array as $key => $value ) {
				if ( ',,,' === $value->cholesterol ) {
					$this->ending_chol = $this->translations->dashboard_trans_28 . '<img class="wphealthtracker-stats-good-data-smile"src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'shocked.svg"/>';
				} else {
					$this->ending_chol = $value->cholesterol;
					$this->ending_chol = explode( ',', $this->ending_chol );
					$this->ending_chol = $this->ending_chol[0] . '<span class="wphealthtracker-chol-span">(' . $this->translations->dashboard_trans_15 . ')</span> ' . $this->ending_chol[1] . '<span class="wphealthtracker-chol-span">(' . $this->translations->dashboard_trans_16 . ')</span> ' . $this->ending_chol[2] . '<span class="wphealthtracker-chol-span">(' . $this->translations->dashboard_trans_17 . ')</span> ' . $this->ending_chol[3] . '<span class="wphealthtracker-chol-span">(' . $this->translations->dashboard_trans_18 . ')</span>';
					break;
				}
			}

			// Create Starting Blood Pressure Value.
			foreach ( $this->allsavedusersdata as $key => $value ) {
				if ( '//' === $value->bloodpressure ) {
					$this->starting_bp = $this->translations->dashboard_trans_29 . '<img class="wphealthtracker-stats-good-data-smile"src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'shocked.svg"/>';
				} else {
					if ( stripos( $value->bloodpressure, ',' ) !== false ) {
						$this->starting_bp = explode( ',', $value->bloodpressure );
						$this->starting_bp = explode( '/', $this->starting_bp[0] );
					} else {
						$this->starting_bp = explode( '/', $value->bloodpressure );
					}

					$this->starting_bp = $this->starting_bp[0] . '<span class="wphealthtracker-chol-span">(' . $this->translations->dashboard_trans_19 . ')</span>/  ' . $this->starting_bp[1] . '<span class="wphealthtracker-chol-span">(' . $this->translations->dashboard_trans_20 . ')</span>';
					break;
				}
			}

			// Create ending Blood Pressure Value.
			$temp_array = array_reverse( $this->allsavedusersdata );
			foreach ( $temp_array as $key => $value ) {
				if ( '//' === $value->bloodpressure ) {
					$this->ending_bp = $this->translations->dashboard_trans_30 . '<img class="wphealthtracker-stats-good-data-smile"src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'shocked.svg"/>';
				} else {
					if ( stripos( $value->bloodpressure, ',' ) !== false ) {
						$this->ending_bp = explode( ',', $value->bloodpressure );
						$this->ending_bp = explode( '/', $this->ending_bp[ ( count( $this->ending_bp ) - 1 ) ] );
					} else {
						$this->ending_bp = explode( '/', $value->bloodpressure );
					}

					$this->ending_bp = $this->ending_bp[0] . '<span class="wphealthtracker-chol-span">(' . $this->translations->dashboard_trans_19 . ')</span>/  ' . $this->ending_bp[1] . '<span class="wphealthtracker-chol-span">(' . $this->translations->dashboard_trans_20 . ')</span>';
					break;
				}
			}
		}

		/**
		 *  Function that sets the Diet data
		 */
		public function calculate_diet_data() {

			// Calculating Daily Calorie Averages.
			$cal_counter = 0;
			$cals        = 0;
			foreach ( $this->allsavedusersdata as $key => $value ) {
				// If we have saved data...
				if ( '' !== $value->foodstring ) {

					// Increment counter for averages and whatnot.
					$cal_counter++;

					// Multiple food items per day.
					if ( stripos( $value->foodstring, ',' ) !== false ) {
						$indiv_day = explode( ',', $value->foodstring );
						foreach ( $indiv_day as $key2 => $value2 ) {
							$indiv_day = explode( ';', $value2 );
							if ( '' !== $indiv_day[3] ) {

								// Convert to Calories.
								if ( 'kcal' === $indiv_day[4] ) {
									$cals += $indiv_day[3];
								}
								if ( 'kJ' === $indiv_day[4] ) {
									$cals += round( ( $indiv_day[3] / 4.184 ), 2 );
								}
								if ( 'Calories' === $indiv_day[4] ) {
									$cals += $indiv_day[3];
								}
							}
						}
					} else {
						$indiv_day = explode( ';', $value->foodstring );
						if ( '' !== $indiv_day[3] ) {

							// Convert to Calories.
							if ( 'kcal' === $indiv_day[4] ) {
								$cals += $indiv_day[3];
							}
							if ( 'kJ' === $indiv_day[4] ) {
								$cals += round( ( $indiv_day[3] / 4.184 ), 2 );
							}
							if ( 'Calories' === $indiv_day[4] ) {
								$cals += $indiv_day[3];
							}
						}
					}
				}
			}

			// Building # of unique food items.
			$unique_foods = array();
			foreach ( $this->allsavedusersdata as $key => $value ) {
				// If we have saved data...
				if ( '' !== $value->foodstring ) {
					if ( stripos( $value->foodstring, ',' ) !== false ) {
						$indiv_day = explode( ',', $value->foodstring );
						foreach ( $indiv_day as $key2 => $value2 ) {

							$indiv_day2 = explode( ';', $value2 );
							if ( '' !== $indiv_day2[0] ) {
								array_push( $unique_foods, $indiv_day2[0] );
							}
						}
					} else {
						$indiv_day = explode( ';', $value->foodstring );
						if ( '' !== $indiv_day[0] ) {
							array_push( $unique_foods, $indiv_day[0] );
						}
					}
				}
			}

			// Building average protein per day.
			$protein         = 0;
			$protein_counter = 0;
			foreach ( $this->allsavedusersdata as $key => $value ) {
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

			// Building average carbs per day.
			$carbs_counter = 0;
			$carbs         = 0;
			foreach ( $this->allsavedusersdata as $key => $value ) {
				// If we have saved data...
				if ( '' !== $value->foodstring ) {

					// Increment counter for averages and whatnot.
					$carbs_counter++;

					if ( stripos( $value->foodstring, ',' ) !== false ) {
						$indiv_day = explode( ',', $value->foodstring );
						foreach ( $indiv_day as $key2 => $value2 ) {

							$indiv_day2 = explode( ';', $value2 );
							if ( '' !== $indiv_day2[11] ) {
								$carbs += $indiv_day2[11];
							}
						}
					} else {
						$indiv_day = explode( ';', $value->foodstring );
						if ( '' !== $indiv_day[11] ) {
							$carbs += $indiv_day[11];
						}
					}
				}
			}

			// Building average sugars per day.
			$sugars_counter = 0;
			$sugars         = 0;
			foreach ( $this->allsavedusersdata as $key => $value ) {
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

			// Building average fiber per day.
			$fiber_counter = 0;
			$fiber         = 0;
			foreach ( $this->allsavedusersdata as $key => $value ) {

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

			// Building average fats per day.
			$fats_counter = 0;
			$fats         = 0;
			foreach ( $this->allsavedusersdata as $key => $value ) {

				// If we have saved data...
				if ( '' !== $value->foodstring ) {

					// Increment counter for averages and whatnot.
					$fats_counter++;

					if ( stripos( $value->foodstring, ',' ) !== false ) {
						$indiv_day = explode( ',', $value->foodstring );
						foreach ( $indiv_day as $key2 => $value2 ) {

							$indiv_day2 = explode( ';', $value2 );
							if ( '' !== $indiv_day2[7] ) {
								$fats += $indiv_day2[7];
							}
						}
					} else {
						$indiv_day = explode( ';', $value->foodstring );
						if ( '' !== $indiv_day[7] ) {
							$fats += $indiv_day[7];
						}
					}
				}
			}

			// Building average calories per day.
			$calories         = 0;
			$calories_counter = 0;
			foreach ( $this->allsavedusersdata as $key => $value ) {
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
							}
						}
					} else {
						$indiv_day = explode( ';', $value->foodstring );
						if ( '' !== $indiv_day[3] ) {
							$calories += $indiv_day[3];
						}
					}
				}
			}

			// Calculating some final Calorie values.
			$tempcals                  = round( ( $cals / $cal_counter ), 2 );
			$this->average_daily_cals  = number_format( $tempcals );
			$this->average_daily_kcals = number_format( round( ( $tempcals * 1000 ), 2 ) );
			$this->average_daily_kjs   = number_format( round( ( $tempcals * 239.006 ), 2 ) );

			// Calculating some final food item values.
			$orig_unique_foods        = $unique_foods;
			$final_unique_foods       = array_unique( $unique_foods );
			$this->unique_foods_count = count( $final_unique_foods );
			$values                   = array_count_values( $orig_unique_foods );
			arsort( $values );
			$this->top_five_food_items = array_slice( array_keys( $values ), 0, 5, true );

			// Calculating final averages.
			$this->average_daily_protein    = round( ( $protein / $protein_counter ), 2 );
			$this->average_daily_carbs      = round( ( $carbs / $carbs_counter ), 2 );
			$this->average_daily_sugars     = round( ( $sugars / $sugars_counter ), 2 );
			$this->average_daily_fats       = round( ( $fats / $fats_counter ), 2 );
			$this->average_daily_fiber      = round( ( $fiber / $fiber_counter ), 2 );
			$this->average_daily_calories   = round( ( $calories / $calories_counter ), 2 );
			$this->average_daily_kilojoules = round( ( $this->average_daily_calories * 4.184 ), 2 );

		}

		/**
		 *  Function that sets the Exercise data
		 */
		public function calculate_exercise_data() {

			// Building # of unique exercise items.
			$unique_exercises = array();
			foreach ( $this->allsavedusersdata as $key => $value ) {
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
			foreach ( $this->allsavedusersdata as $key => $value ) {
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
			foreach ( $this->allsavedusersdata as $key => $value ) {
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

			// Building the total minutes exercised.
			$total_seconds = 0;
			$total_minutes = 0;
			$total_hours   = 0;
			foreach ( $this->allsavedusersdata as $key => $value ) {

				// If we have saved data...
				if ( '' !== $value->exercisestring ) {
					if ( stripos( $value->exercisestring, ',' ) !== false ) {
						$indiv_day = explode( ',', $value->exercisestring );
						foreach ( $indiv_day as $key2 => $value2 ) {
							$indiv_day2 = explode( ';', $value2 );
							if ( '' !== $indiv_day2[3] ) {
								if ( $this->translations->common_trans_48 === $indiv_day2[4] ) {
									$total_seconds += $indiv_day2[3];
								}

								if ( $this->translations->common_trans_49 === $indiv_day2[4] ) {
									$total_minutes += $indiv_day2[3];
								}

								if ( $this->translations->common_trans_50 === $indiv_day2[4] ) {
									$total_hours += $indiv_day2[3];
								}
							}
						}
					}
				} else {
					$indiv_day = explode( ';', $value->exercisestring );
					if ( '' !== $indiv_day[0] ) {
						if ( '' !== $indiv_day[3] ) {
							if ( $this->translations->common_trans_48 === $indiv_day[4] ) {
								$total_seconds += $indiv_day[3];
							}

							if ( $this->translations->common_trans_49 === $indiv_day[4] ) {
								$total_minutes += $indiv_day[3];
							}

							if ( $this->translations->common_trans_50 === $indiv_day[4] ) {
								$total_hours += $indiv_day[3];
							}
						}
					}
				}
			}

			// Convert everything into seconds.
			$total_seconds       = $total_seconds + ( $total_hours * 3600 );
			$this->total_seconds = $total_seconds + ( $total_minutes * 60 );

			// Now take those total seconds and create our minutes and hours values.
			$this->total_minutes = number_format( ( $this->total_seconds / 60 ), 2 );
			$this->total_hours   = number_format( ( $this->total_seconds / 3600 ), 2 );

			// Now format total seconds.
			$this->total_seconds = number_format( $this->total_seconds, 2 );

			// Calculating some final exercises item values.
			$orig_unique_exercises        = $unique_exercises;
			$final_unique_exercises       = array_unique( $unique_exercises );
			$this->unique_exercises_count = count( $final_unique_exercises );
			$values                       = array_count_values( $orig_unique_exercises );
			arsort( $values );
			$this->top_five_exercise_items = array_slice( array_keys( $values ), 0, 5, true );

			$orig_exercise_categories        = $exercise_categories;
			$final_exercise_categories       = array_unique( $exercise_categories );
			$this->exercise_categories_count = count( $final_exercise_categories );
			$values                          = array_count_values( $orig_exercise_categories );
			arsort( $values );
			$this->top_five_exercise_categories = array_slice( array_keys( $values ), 0, 5, true );

			$orig_exercise_muscles        = $exercise_muscles;
			$final_exercise_muscles       = array_unique( $exercise_muscles );
			$this->exercise_muscles_count = count( $final_exercise_muscles );
			$values                       = array_count_values( $orig_exercise_muscles );
			arsort( $values );
			$this->top_five_exercise_muscles = array_slice( array_keys( $values ), 0, 5, true );
		}

		/**
		 *  This function builds and outputs the title/profile image/username area
		 */
		public function output_title_area() {

			// Build profile Image div.
			$profimgstring = '';
			if ( null !== $this->profileimg && '' !== $this->profileimg ) {
				$profimgstring = '
				<div class="wphealthtracker-prof-img-div">
					<img class="wphealthtracker-prof-img-actual" src="' . $this->profileimg . '" />
				</div>';
			}

			// Build Title/Name div.
			$this->title_area = '
			<div class="wphealthtracker_dashboard_title_div">
				<div class="wphealthtracker-dashboard-p-title-div">
					<p class="wphealthtracker-dashboard-p-title">' . $this->tab . ' ' . $this->translations->dashboard_trans_1 . '</p><p class="wphealthtracker-dashboard-p-name">' . $this->displayname . '</p>
				</div>
				' . $profimgstring . '
				<div class="wphealthtracker-dashboard-title-line"></div>
			</div>';

		}

		/**
		 *  This function assembles and outputs the final built HTML for the Vitals Quickstats/Dashaboard.
		 */
		public function output_vitals_backend_dashboard() {

			// Getting the user's display name.
			$this->get_user_name();

			// Getting the title area.
			$this->output_title_area();

			$this->final_output = $this->title_area . '

			<div class="wphealthtracker-dashboard-actual-info">
				<div class="wphealthtracker-dashboard-row">
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-daystracked" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_2 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->total_days_tracked . ' ' . $this->translations->dashboard_trans_3 . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-conseqdaystracked" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_4 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->most_conseq_days . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-firstdaytracked" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_5 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->first_date_tracked . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-lastdaytracked" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_6 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->last_date_tracked . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-largestgap" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_7 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->largest_gap . '</span>
						</p>
					</div>

					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-numberofgaps" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_14 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->num_of_gaps . '</span>
						</p>
					</div>

					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-startingweight" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_8 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->starting_weight . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-recentweight" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_9 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->recent_weight . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-startingbp" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_12 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->starting_bp . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-recentbp" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_13 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->ending_bp . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-startingcho" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_10 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data" id="wphealthtracker-dashboard-row-entry-data-start-chol">' . $this->starting_chol . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-recentcho" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_11 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->ending_chol . '</span>
						</p>
					</div>
				</div>
			</div>
			<div class="wphealthtracker-dashboard-title-line" id="wphealthtracker-dashboard-title-line-bottom"></div>
		';
			return $this->final_output;
		}

		/**
		 *  This function assembles and outputs the final built HTML for the Diet Quickstats/Dashaboard.
		 */
		public function output_diet_backend_dashboard() {

			// Getting the user's display name.
			$this->get_user_name();

			// Getting the title area.
			$this->output_title_area();

			// Building top 3 food item string.
			if ( count( $this->top_five_food_items ) > 2 ) {
				$top_3_food_items = $this->top_five_food_items[0] . ', ' . $this->top_five_food_items[1] . ', ' . $this->top_five_food_items[2];
			}
			if ( 2 === count( $this->top_five_food_items ) ) {
				$top_3_food_items = $this->top_five_food_items[0] . ', ' . $this->top_five_food_items[1];
			}
			if ( 1 === count( $this->top_five_food_items ) ) {
				$top_3_food_items = $this->top_five_food_items[0];
			}

			$this->final_output = $this->title_area . '

			<div class="wphealthtracker-dashboard-actual-info">
				<div class="wphealthtracker-dashboard-row">
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-daystracked" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_2 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->total_days_tracked . ' ' . $this->translations->dashboard_trans_3 . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-conseqdaystracked" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_4 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->most_conseq_days . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-firstdaytracked" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_5 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->first_date_tracked . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-lastdaytracked" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_6 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->last_date_tracked . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-largestgap" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_7 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->largest_gap . '</span>
						</p>
					</div>

					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-numberofgaps" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_14 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->num_of_gaps . '</span>
						</p>
					</div>

					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-totalunique" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_33 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->unique_foods_count . ' ' . $this->translations->dashboard_trans_41 . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-top3consumedfoods" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_34 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $top_3_food_items . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-averagedailycals" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_42 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->average_daily_calories . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-averagedailykilojoules" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_43 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->average_daily_kilojoules . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-averagedailyprotein" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_35 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->average_daily_protein . ' ' . $this->translations->dashboard_trans_40 . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-averagedailycarbs" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_36 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->average_daily_carbs . ' ' . $this->translations->dashboard_trans_40 . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-averagedailysugars" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_37 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data" id="wphealthtracker-dashboard-row-entry-data-start-chol">' . $this->average_daily_sugars . ' ' . $this->translations->dashboard_trans_40 . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-averagedailytotalfats" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_38 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->average_daily_fats . ' ' . $this->translations->dashboard_trans_40 . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-averagedailyfiber" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_39 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->average_daily_fiber . ' ' . $this->translations->dashboard_trans_40 . '</span>
						</p>
					</div>
				</div>
			</div>
			<div class="wphealthtracker-dashboard-title-line" id="wphealthtracker-dashboard-title-line-bottom"></div>
		';
			return $this->final_output;
		}

		/**
		 *  This function assembles and outputs the final built HTML for the Exercise Quickstats/Dashaboard.
		 */
		public function output_exercise_backend_dashboard() {

			// Getting the user's display name.
			$this->get_user_name();

			// Getting the title area.
			$this->output_title_area();

			// Building top exercise item string.
			$top_3_exercise_items = $this->top_five_exercise_items[0];

			// Building top exercise categories string.
			$top_3_exercise_categories = $this->top_five_exercise_categories[0];

			// Building top 3 exercise muscles groups string.
			if ( count( $this->top_five_exercise_muscles ) > 2 ) {
				$top_3_exercise_muscles = $this->top_five_exercise_muscles[0] . ', ' . $this->top_five_exercise_muscles[1] . ', ' . $this->top_five_exercise_muscles[2];
			}
			if ( count( $this->top_five_exercise_muscles ) === 2 ) {
				$top_3_exercise_muscles = $this->top_five_exercise_muscles[0] . ', ' . $this->top_five_exercise_muscles[1];
			}
			if ( count( $this->top_five_exercise_muscles ) === 1 ) {
				$top_3_exercise_muscles = $this->top_five_exercise_muscles[0];
			}

			$this->final_output = $this->title_area . '

			<div class="wphealthtracker-dashboard-actual-info">
				<div class="wphealthtracker-dashboard-row">
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-daystracked" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_2 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->total_days_tracked . ' ' . $this->translations->dashboard_trans_3 . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-conseqdaystracked" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_4 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->most_conseq_days . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-firstdaytracked" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_5 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->first_date_tracked . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-lastdaytracked" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_6 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->last_date_tracked . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-largestgap" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_7 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->largest_gap . '</span>
						</p>
					</div>

					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-numberofgaps" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_14 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->num_of_gaps . '</span>
						</p>
					</div>

					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-totaluniqueexercises" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_50 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->unique_exercises_count . ' ' . $this->translations->dashboard_trans_51 . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-topexercise" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_52 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $top_3_exercise_items . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-totalexercisecategories" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_57 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->exercise_categories_count . ' ' . $this->translations->common_trans_57 . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-topexercisecategory" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_56 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $top_3_exercise_categories . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-daystracked" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_58 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->exercise_muscles_count . ' ' . $this->translations->dashboard_trans_60 . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-topmusclegroups" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_59 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $top_3_exercise_muscles . '</span>
						</p>
					</div>	
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-totalsecondsexercised" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_53 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->total_seconds . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-totalminutesexercised" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_54 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->total_minutes . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-totalhoursexercised" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->dashboard_trans_55 . '</span><br/>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->total_hours . '</span>
						</p>
					</div>

				</div>
			</div>
			<div class="wphealthtracker-dashboard-title-line" id="wphealthtracker-dashboard-title-line-bottom"></div>
		';
			return $this->final_output;
		}

	}
endif;
