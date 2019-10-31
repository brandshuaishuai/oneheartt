<?php
/**
 * Class WPHealthTracker_D3_Vitals - class-wphealthtracker-d3-vitals.php
 *
 * @author   Jake Evans
 * @category Transients
 * @package  Includes/Classes/D3/D3_vitals
 * @version  0.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPHealthTracker_D3_Vitals', false ) ) :
	/**
	 * WPHealthTracker_D3_Vitals class. This class will hold all of the logic needed to create the d3 charts on the Vital Stats tab of the Stats menu page.
	 */
	class WPHealthTracker_D3_Vitals {

		/** Common member variable
		 *
		 *  @var array $first_weight
		 */
		public $alluserdata = array();

		/** Common member variable
		 *
		 *  @var string $translations
		 */
		public $translations = '';

		/** Common member variable
		 *
		 *  @var string $first_weight
		 */
		public $first_weight = '';

		/** Common member variable
		 *
		 *  @var string $first_bp
		 */
		public $first_bp = '';

		/** Common member variable
		 *
		 *  @var int $highest_weight_pounds
		 */
		public $highest_weight_pounds = 0;

		/** Common member variable
		 *
		 *  @var int $highest_weight_kilograms
		 */
		public $highest_weight_kilograms = 0;

		/** Common member variable
		 *
		 *  @var int $lowest_weight_pounds
		 */
		public $lowest_weight_pounds = 0;

		/** Common member variable
		 *
		 *  @var int $lowest_weight_kilograms
		 */
		public $lowest_weight_kilograms = 0;

		/** Common member variable
		 *
		 *  @var string $highest_single_bp_read
		 */
		public $highest_single_bp_read = '0/0';

		/** Common member variable
		 *
		 *  @var string $lowest_single_bp_read
		 */
		public $lowest_single_bp_read = '10000/10000';

		/** Common member variable
		 *
		 *  @var int $highest_sys
		 */
		public $highest_sys = 0;

		/** Common member variable
		 *
		 *  @var int $highest_dys
		 */
		public $highest_dys = 0;

		/** Common member variable
		 *
		 *  @var int $lowest_sys
		 */
		public $lowest_sys = 100000;

		/** Common member variable
		 *
		 *  @var int $lowest_dys
		 */
		public $lowest_dys = 100000;

		/** Common member variable
		 *
		 *  @var int $average_dys
		 */
		public $average_dys = 0;

		/** Common member variable
		 *
		 *  @var int $average_sys
		 */
		public $average_sys = 0;

		/** Common member variable
		 *
		 *  @var int $total_sys
		 */
		public $total_sys = 0;

		/** Common member variable
		 *
		 *  @var int $total_dys
		 */
		public $total_dys = 0;

		/** Common member variable
		 *
		 *  @var int $average_weight_pounds
		 */
		public $average_weight_pounds = 0;

		/** Common member variable
		 *
		 *  @var int $average_weight_kilograms
		 */
		public $average_weight_kilograms = 0;

		/** Common member variable
		 *
		 *  @var int $weight_entry_counter
		 */
		public $weight_entry_counter = 0;

		/** Common member variable
		 *
		 *  @var int $bp_entry_counter
		 */
		public $bp_entry_counter = 0;

		/** Common member variable
		 *
		 *  @var int $bp_day_counter
		 */
		public $bp_day_counter = 0;

		/** Common member variable
		 *
		 *  @var int $ch_day_counter
		 */
		public $ch_day_counter = 0;

		/** Common member variable
		 *
		 *  @var int $twl_kilograms
		 */
		public $twl_kilograms = 0;

		/** Common member variable
		 *
		 *  @var int $twl_pounds
		 */
		public $twl_pounds = 0;

		/** Common member variable
		 *
		 *  @var int $first_chol
		 */
		public $first_chol = '';

		/** Common member variable
		 *
		 *  @var int $average_ch_ldl
		 */
		public $average_ch_ldl = 0;

		/** Common member variable
		 *
		 *  @var int $average_ch_hdl
		 */
		public $average_ch_hdl = 0;

		/** Common member variable
		 *
		 *  @var int $average_ch_tri
		 */
		public $average_ch_tri = 0;

		/** Common member variable
		 *
		 *  @var int $average_ch_total
		 */
		public $average_ch_total = 0;

		/** Common member variable
		 *
		 *  @var int $highest_ch
		 */
		public $highest_ch = 0;

		/** Common member variable
		 *
		 *  @var int $lowest_ch
		 */
		public $lowest_ch = 10000;


		/** Common member variable
		 *
		 *  @var array data_1_array
		 */
		public $data_1_array = array();

		/** Common member variable
		 *
		 *  @var array data_2_array
		 */
		public $data_2_array = array();

		/** Common member variable
		 *
		 *  @var array data_3_array
		 */
		public $data_3_array = array();

		/** Common member variable
		 *
		 *  @var array $titles_array
		 */
		public $titles_array = array();

		/** Common member variable
		 *
		 *  @var array $stats_array
		 */
		public $stats_array = array();

		/** Class Constructor
		 *
		 *  @param array $userdata - The user's complete data set - all vitals data.
		 */
		public function __construct( $userdata ) {

			$this->alluserdata = $userdata;

			// Get Translations.
			require_once WPHEALTHTRACKER_CLASSES_TRANSLATIONS_DIR . 'class-wphealthtracker-translations.php';
			$this->translations = new WPHealthTracker_Translations();
			$this->translations->d3_chart_trans_strings();
		}

		/**
		 *  Builds data array for first D3 chart
		 */
		public function build_data_1() {

			// Here's the format we're going for: [{date: '08-jul-18', close: 185},{date: '08-jul-19', close: 285}] - Build weight array of arrays.
			$temp_array = array();
			foreach ( $this->alluserdata as $key => $value ) {

				// Split up weight from it's measurement.
				$weight = explode( ';', $value->weight );
				$weight = $weight[0];

				// If a weight has been recorded for this loop iteration...
				if ( '' !== $weight ) {

					// Split up and format date.
					$date = explode( '-', $value->humandate );

					// Build final formatted date.
					$date = $date[2] . '-' . $date[0] . '-' . $date[1];

					// Build Weight.
					$weight             = explode( ';', $value->weight );
					$weight_value       = $weight[0];
					$weight_measurement = $weight[1];

					// Build both Pounds and Kilograms.
					if ( $weight_measurement === $this->translations->d3_trans_19 ) {
						$weight_pounds = (float) $weight_value;
						$weight_kilos  = '';
					} else {
						$weight_pounds = '';
						$weight_kilos  = (float) $weight_value;
					}

					// Now convert Pounds to Kilograms.
					if ( '' !== $weight_pounds ) {
						$weight_kilos = $weight_pounds / 2.20462;
					}

					// Now convert Kilograms to Pounds.
					if ( '' !== $weight_kilos ) {
						$weight_pounds = $weight_kilos * 2.20462;
					}

					// Push date and weight into array which will be pushed into final return array.
					$temp_array = array(
						'date'                           => $date,
						$this->translations->d3_trans_19 => round( $weight_pounds, 2 ),
						$this->translations->d3_trans_18 => round( $weight_kilos, 2 ),
					);

					// Push into final return array.
					array_push( $this->data_1_array, $temp_array );
				}
			}

			// If there was no saved weight data at all, return an array holding the 'No Data Found' Html.
			if ( 0 === count( $this->data_1_array ) ) {
				return '<div class="wphealthtracker-no-saved-data-div">
				<p>
					<img class="wphealthtracker-shocked-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'shocked.svg">
					<span class="wphealthtracker-no-saved-span1">' . $this->translations->d3_trans_15 . '</span>
					<br>
					' . $this->translations->d3_trans_12 . '
					<br>' . $this->translations->d3_trans_13 . '
				</p>
			</div>';
			} elseif ( 1 === count( $this->data_1_array ) ) {
				return '<div class="wphealthtracker-no-saved-data-div">
				<p>
					<img class="wphealthtracker-shocked-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'shocked.svg">
					<span class="wphealthtracker-no-saved-span1">' . $this->translations->d3_trans_15 . '</span>
					<br>
					' . $this->translations->d3_trans_16 . '
					<br>' . $this->translations->d3_trans_13 . '
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

			$temp_array = array();
			foreach ( $this->alluserdata as $key => $indiv_day ) {

				$daily_first_sys   = 0;
				$daily_first_dys   = 0;
				$daily_last_sys    = 0;
				$daily_last_dys    = 0;
				$daily_average_sys = 0;
				$daily_average_dys = 0;

				// First, determine if there is data saved on this day at all.
				if ( '//' !== $indiv_day->bloodpressure ) {

					// Determine if there's more than one reading per day.
					if ( stripos( $indiv_day->bloodpressure, ',' ) !== false ) {

						$mult_reading = explode( ',', $indiv_day->bloodpressure );

						// Loop through each reading on this one day.
						$total_sys = 0;
						$total_dys = 0;
						$counter   = 0;
						foreach ( $mult_reading as $key => $reading ) {
							$reading = explode( '/', $reading );

							// Record the first entry's values.
							if ( 0 === $key ) {
								$daily_first_sys = $reading[0];
								$daily_first_dys = $reading[1];
							}

							// Record the last entry.
							if ( ( count( $mult_reading ) - 1 ) === $key ) {
								$daily_last_sys = $reading[0];
								$daily_last_dys = $reading[1];
							}

							// Things for building an average.
							$total_sys += $reading[0];
							$total_dys += $reading[1];
							$counter++;
						}

						// Build the averages.
						$daily_average_sys = $total_sys / $counter;
						$daily_average_dys = $total_dys / $counter;

					} else {
						$reading           = explode( '/', $indiv_day->bloodpressure );
						$daily_first_sys   = $reading[0];
						$daily_first_dys   = $reading[1];
						$daily_last_sys    = $reading[0];
						$daily_last_dys    = $reading[1];
						$daily_average_sys = $reading[0];
						$daily_average_dys = $reading[1];
					}

					// This is the date format we need: '2018-02-11T17:00:00.000';.
					$datetime = new DateTime( str_replace( '-', '/', $indiv_day->humandate ) );
					$datetime = $datetime->format( DateTime::ATOM );
					$datetime = str_replace( '+00:00', '.000', $datetime );

					// Now build our one completed daily array.
					$temp_array_day = array(
						array(
							'linetype'  => 'sys',
							'variable'  => 'First Daily Reading',
							'date'      => $datetime,
							'value'     => (float) $daily_first_sys,
							'name'      => 'Systolic',
							'region_id' => 4,
						),
						array(
							'linetype'  => 'sys',
							'variable'  => 'Last Daily Reading',
							'date'      => $datetime,
							'value'     => (float) $daily_last_sys,
							'name'      => 'Systolic',
							'region_id' => 4,
						),
						array(
							'linetype'  => 'sys',
							'variable'  => 'Average Daily Reading',
							'date'      => $datetime,
							'value'     => (float) $daily_average_sys,
							'name'      => 'Systolic',
							'region_id' => 4,
						),
						array(
							'linetype'  => 'dys',
							'variable'  => 'First Daily Reading',
							'date'      => $datetime,
							'value'     => (float) $daily_first_dys,
							'name'      => 'Diastolic',
							'region_id' => 4,
						),
						array(
							'linetype'  => 'dys',
							'variable'  => 'Last Daily Reading',
							'date'      => $datetime,
							'value'     => (float) $daily_last_dys,
							'name'      => 'Diastolic',
							'region_id' => 4,
						),
						array(
							'linetype'  => 'dys',
							'variable'  => 'Average Daily Reading',
							'date'      => $datetime,
							'value'     => (float) $daily_average_dys,
							'name'      => 'Diastolic',
							'region_id' => 4,
						),
					);

					array_push( $this->data_2_array, $temp_array_day );

				}
			}

			// If there was no saved Blood Pressure data at all, return an array holding the 'No Data Found' Html.
			if ( 0 === count( $this->data_2_array ) ) {
				return '<div class="wphealthtracker-no-saved-data-div">
				<p>
					<img class="wphealthtracker-shocked-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'shocked.svg">
					<span class="wphealthtracker-no-saved-span1">' . $this->translations->d3_trans_15 . '</span>
					<br>
					' . $this->translations->d3_trans_22 . '
					<br>' . $this->translations->d3_trans_23 . '
				</p>
			</div>';
			} elseif ( 1 === count( $this->data_2_array ) ) {
				return '<div class="wphealthtracker-no-saved-data-div">
				<p>
					<img class="wphealthtracker-shocked-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'shocked.svg">
					<span class="wphealthtracker-no-saved-span1">' . $this->translations->d3_trans_15 . '</span>
					<br>
					' . $this->translations->d3_trans_24 . '
					<br>' . $this->translations->d3_trans_23 . '
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

			// Here's the format we're going for: [{date: '08-jul-18', close: 185},{date: '08-jul-19', close: 285}] - Build Cholesterol array of arrays.
			$temp_array = array();
			foreach ( $this->alluserdata as $key => $value ) {

				// If cholesterol has been recorded for this loop iteration...
				if ( ',,,' !== $value->cholesterol && '' !== $value->cholesterol && null !== $value->cholesterol ) {

					// Split up weight from it's measurement.
					$cholesterol   = explode( ',', $value->cholesterol );
					$ldl           = $cholesterol[0];
					$hdl           = $cholesterol[1];
					$triglycerides = $cholesterol[2];
					$total         = $cholesterol[3];

					// split up and format date.
					$date = explode( '-', $value->humandate );

					// Build final formatted date.
					$date = $date[2] . '-' . $date[0] . '-' . $date[1];

					// Push date and values into array which will be pushed into final return array.
					$temp_array = array(
						'date'                           => $date,
						$this->translations->d3_trans_34 => round( $ldl, 2 ),
						$this->translations->d3_trans_35 => round( $hdl, 2 ),
						$this->translations->d3_trans_36 => round( $triglycerides, 2 ),
						$this->translations->d3_trans_37 => round( $total, 2 ),
					);

					// Push into final return array.
					array_push( $this->data_3_array, $temp_array );
				}
			}

			// If there was no saved Cholesterol data at all, return an array holding the 'No Data Found' Html.
			if ( 0 === count( $this->data_3_array ) ) {
				return '<div class="wphealthtracker-no-saved-data-div">
				<p>
					<img class="wphealthtracker-shocked-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'shocked.svg">
					<span class="wphealthtracker-no-saved-span1">' . $this->translations->d3_trans_15 . '</span>
					<br>
					' . $this->translations->d3_trans_51 . '
					<br>' . $this->translations->d3_trans_50 . '
				</p>
			</div>';
			} elseif ( 1 === count( $this->data_3_array ) ) {
				return '<div class="wphealthtracker-no-saved-data-div">
				<p>
					<img class="wphealthtracker-shocked-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'shocked.svg">
					<span class="wphealthtracker-no-saved-span1">' . $this->translations->d3_trans_15 . '</span>
					<br>
					' . $this->translations->d3_trans_49 . '
					<br>' . $this->translations->d3_trans_50 . '
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
			<img class="wphealthtracker-d3-chart-title-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'scale.svg"/>		
			<img class="wphealthtracker-icon-image-question" id="wphealthtracker-icon-image-question-d3-chart-title" data-label="d3-vitals-weightchartandstats" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg" /><p class="wphealthtracker-d3-chart-title-actual">' . $this->translations->d3_trans_1 . '</p>
			<div class="wphealthtracker-d3-chart-title-line"></div>';

			$title_2 = '
			<img class="wphealthtracker-d3-chart-title-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'pressure.svg"/>		
			<img class="wphealthtracker-icon-image-question" id="wphealthtracker-icon-image-question-d3-chart-title" data-label="d3-vitals-bloodpressurechartandstats" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg" /><p class="wphealthtracker-d3-chart-title-actual">' . $this->translations->d3_trans_21 . '</p>
			<div class="wphealthtracker-d3-chart-title-line"></div>';

			$title_3 = '
			<img class="wphealthtracker-d3-chart-title-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'heartbeat.svg"/>		
			<img class="wphealthtracker-icon-image-question" id="wphealthtracker-icon-image-question-d3-chart-title" data-label="d3-vitals-cholesterolchartandstats" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-black.svg" /><p class="wphealthtracker-d3-chart-title-actual">' . $this->translations->d3_trans_38 . '</p>
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

			$highest_kg_weight        = 0;
			$highest_lbs_weight       = 0;
			$highest_weight           = 0;
			$lowest_kg_weight         = 10000000;
			$lowest_lbs_weight        = 10000000;
			$lowest_weight            = 10000000;
			$total_weight_pounds      = 0;
			$total_weight_kilograms   = 0;
			$total_weight             = 0;
			$twl_kilograms            = 0;
			$twl_pounds               = 0;
			$total_weight_lost        = 0;
			$prev_weight_lost_value   = null;
			$twg_kilograms            = 0;
			$twg_pounds               = 0;
			$total_weight_gained      = 0;
			$prev_weight_gained_value = null;
			$twsl_kilograms           = 0;
			$twsl_pounds              = 0;
			$twsl                     = 0;
			$pwsl_value               = null;
			$twsg_kilograms           = 0;
			$twsg_pounds              = 0;
			$twsg                     = 0;
			$pwsg_value               = null;

			foreach ( $this->alluserdata as $key => $indiv_day ) {

				// Split up weight for various uses.
				$weight             = explode( ';', $indiv_day->weight );
				$weight_value       = $weight[0];
				$weight_measurement = $weight[1];

				if ( '' !== $weight_value ) {

					// Get date that Weight was first recorded.
					if ( '' === $this->first_weight ) {
						$this->first_weight = $indiv_day->humandate;
					}

					// Build Highest Kilogram Weight.
					if ( $weight_measurement === $this->translations->d3_trans_18 ) {

						// Convert to Pounds so we can compare.
						$temp_value = round( $weight_value * 2.20462, 2 );
						if ( $temp_value > $highest_weight ) {
							$highest_weight = round( $temp_value, 2 );
						}
					}
					// Build Highest Pounds Weight.
					if ( $weight_measurement === $this->translations->d3_trans_19 ) {
						if ( $weight_value > $highest_weight ) {
							$highest_weight = round( $weight_value, 2 );
						}
					}

					// Build lowest Kilogram Weight.
					if ( $weight_measurement === $this->translations->d3_trans_18 ) {
						// Convert to Pounds so we can compare.
						$temp_value = round( $weight_value * 2.20462, 2 );
						if ( $temp_value < $lowest_weight ) {
							$lowest_weight = round( $temp_value, 2 );
						}
					}
					// Build lowest Pounds Weight.
					if ( $weight_measurement === $this->translations->d3_trans_19 ) {
						if ( $weight_value < $lowest_weight ) {
							$lowest_weight = round( $weight_value, 2 );
						}
					}

					// Build average weight.
					$this->weight_entry_counter++;
					if ( $weight_measurement === $this->translations->d3_trans_19 ) {
						$total_weight += $weight_value;
					} else {

						// Convert to Pounds so we can compare.
						$temp_value    = round( $weight_value * 2.20462, 2 );
						$total_weight += $temp_value;
					}
				}

				// Here we're building the Total Weight Lost.
				if ( null === $prev_weight_lost_value ) {
					$prev_weight_lost_value       = $weight_value;
					$prev_weight_lost_measurement = $weight_measurement;
				} else {
					$prev_weight_lost_temp = $this->alluserdata[ $key - 1 ]->weight;
					$prev_weight_lost_temp = explode( ';', $prev_weight_lost_temp );
					if ( '' !== $prev_weight_lost_temp[0] && null !== $prev_weight_lost_temp[0] ) {
						$prev_weight_lost_value       = $prev_weight_lost_temp[0];
						$prev_weight_lost_measurement = $prev_weight_lost_temp[1];
					}
				}
				if ( 0 !== $key ) {
					if ( '' !== $prev_weight_lost_value && null !== $prev_weight_lost_value && '' !== $weight_value ) {

						// Convert everything to pounds so we can compare.
						if ( $weight_measurement === $this->translations->d3_trans_18 ) {
							$temp_lost_value = round( $weight_value * 2.20462, 2 );
						} else {
							$temp_lost_value = $weight_value;
						}

						if ( $prev_weight_lost_measurement === $this->translations->d3_trans_18 ) {
							$temp_lost_previous_value = round( $prev_weight_lost_value * 2.20462, 2 );
						} else {
							$temp_lost_previous_value = $prev_weight_lost_value;
						}

						if ( $temp_lost_previous_value > $temp_lost_value ) {
							$total_weight_lost += ( $temp_lost_previous_value - $temp_lost_value );
						}
					}
				}

				// Here we're building the Total Weight Gained.
				if ( null === $prev_weight_gained_value ) {
					$prev_weight_gained_value       = $weight_value;
					$prev_weight_gained_measurement = $weight_measurement;
				} else {
					$prev_weight_gained_temp = $this->alluserdata[ $key - 1 ]->weight;
					$prev_weight_gained_temp = explode( ';', $prev_weight_gained_temp );
					if ( '' !== $prev_weight_gained_temp[0] && null !== $prev_weight_gained_temp[0] ) {
						$prev_weight_gained_value       = $prev_weight_gained_temp[0];
						$prev_weight_gained_measurement = $prev_weight_gained_temp[1];
					}
				}
				if ( 0 !== $key ) {
					if ( '' !== $prev_weight_gained_value && null !== $prev_weight_gained_value && '' !== $weight_value ) {

						// Convert everything to pounds so we can compare.
						if ( $weight_measurement === $this->translations->d3_trans_18 ) {
							$temp_gained_value = round( $weight_value * 2.20462, 2 );
						} else {
							$temp_gained_value = $weight_value;
						}

						if ( $prev_weight_gained_measurement === $this->translations->d3_trans_18 ) {
							$temp_gained_previous_value = round( $prev_weight_gained_value * 2.20462, 2 );
						} else {
							$temp_gained_previous_value = $prev_weight_gained_value;
						}

						if ( $temp_gained_previous_value < $temp_gained_value ) {
							$total_weight_gained += ( $temp_gained_value - $temp_gained_previous_value );
						}
					}
				}

				// Now we're building the Largest Single Weight Loss value.
				if ( null === $pwsl_value ) {
					$pwsl_value       = $weight_value;
					$pwsl_measurement = $weight_measurement;
				} else {
					$pwsl_temp = $this->alluserdata[ $key - 1 ]->weight;
					$pwsl_temp = explode( ';', $pwsl_temp );
					if ( '' !== $pwsl_temp[0] && null !== $pwsl_temp[0] ) {
						$pwsl_value       = $pwsl_temp[0];
						$pwsl_measurement = $pwsl_temp[1];
					}
				}
				if ( 0 !== $key ) {
					if ( '' !== $pwsl_value && null !== $pwsl_value && '' !== $weight_value ) {

						// Convert everything to pounds so we can compare.
						if ( $weight_measurement === $this->translations->d3_trans_18 ) {
							$temp_single_lost_value = round( $weight_value * 2.20462, 2 );
						} else {
							$temp_single_lost_value = $weight_value;
						}

						if ( $pwsl_measurement === $this->translations->d3_trans_18 ) {
							$temp_single_lost_previous_value = round( $pwsl_value * 2.20462, 2 );
						} else {
							$temp_single_lost_previous_value = $pwsl_value;
						}

						if ( $temp_single_lost_previous_value > $temp_single_lost_value ) {
							$single_lost_temp = ( $temp_single_lost_previous_value - $temp_single_lost_value );

							if ( $single_lost_temp > $twsl ) {
								$twsl = $single_lost_temp;
							}
						}
					}
				}

				// Now we're building the Largest Single Weight Loss value.
				if ( null === $pwsg_value ) {
					$pwsg_value       = $weight_value;
					$pwsg_measurement = $weight_measurement;
				} else {
					$pwsg_temp = $this->alluserdata[ $key - 1 ]->weight;
					$pwsg_temp = explode( ';', $pwsg_temp );
					if ( '' !== $pwsg_temp[0] && null !== $pwsg_temp[0] ) {
						$pwsg_value       = $pwsg_temp[0];
						$pwsg_measurement = $pwsg_temp[1];
					}
				}
				if ( 0 !== $key ) {
					if ( '' !== $pwsg_value && null !== $pwsg_value && '' !== $weight_value ) {

						// Convert everything to pounds so we can compare.
						if ( $weight_measurement === $this->translations->d3_trans_18 ) {
							$temp_single_gained_value = round( $weight_value * 2.20462, 2 );
						} else {
							$temp_single_gained_value = $weight_value;
						}

						if ( $pwsg_measurement === $this->translations->d3_trans_18 ) {
							$temp_single_gained_previous_value = round( $pwsg_value * 2.20462, 2 );
						} else {
							$temp_single_gained_previous_value = $pwsg_value;
						}

						if ( $temp_single_gained_previous_value < $temp_single_gained_value ) {
							$single_gained_temp = ( $temp_single_gained_value - $temp_single_gained_previous_value );

							if ( $single_gained_temp > $twsg ) {
								$twsg = $single_gained_temp;
							}
						}
					}
				}
			}

			// Set some ending variables.
			$this->highest_weight_kilograms = round( $highest_weight / 2.20462, 2 );
			$this->highest_weight_pounds    = $highest_weight;
			$this->lowest_weight_kilograms  = round( $lowest_weight / 2.20462, 2 );
			$this->lowest_weight_pounds     = $lowest_weight;

			// Converting weight if user only ever used one measurement.
			if ( 0 === $this->highest_weight_kilograms ) {
				$this->highest_weight_kilograms = round( $this->highest_weight_pounds / 2.20462, 2 );
			}
			// Converting weight if user only ever used one measurement.
			if ( 0 === $this->highest_weight_pounds ) {
				$this->highest_weight_pounds = round( $this->highest_weight_kilograms * 2.20462, 2 );
			}

			// Converting weight if user only ever used one measurement.
			if ( 10000000 === $this->lowest_weight_kilograms ) {
				$this->lowest_weight_kilograms = round( $this->lowest_weight_pounds / 2.20462, 2 );
			}
			// Converting weight if user only ever used one measurement.
			if ( 10000000 === $this->lowest_weight_pounds ) {
				$this->lowest_weight_pounds = round( $this->lowest_weight_kilograms * 2.20462, 2 );
			}

			// Finishing the build of the average weight.
			if ( 0 !== $this->weight_entry_counter ) {
				$this->average_weight_pounds    = round( $total_weight / $this->weight_entry_counter, 2 );
				$this->average_weight_kilograms = round( round( $total_weight / 2.20462, 2 ) / $this->weight_entry_counter, 2 );
				if ( 0 === $this->average_weight_pounds ) {
					$this->average_weight_pounds = round( $this->lowest_weight_kilograms * 2.20462, 2 );
				}
				if ( 0 === $this->average_weight_kilograms ) {
					$this->average_weight_kilograms = round( $this->lowest_weight_pounds / 2.20462, 2 );
				}
			}

			// Finishing build of total weight lost.
			$this->twl_kilograms = round( $total_weight_lost / 2.20462, 2 );
			$this->twl_pounds    = $total_weight_lost;

			if ( 0 === $this->twl_kilograms && 0 !== $this->twl_pounds ) {
				$this->twl_kilograms = round( $this->twl_pounds / 2.20462, 2 );
			}
			if ( 0 === $this->twl_pounds && 0 !== $this->twl_kilograms ) {
				$this->twl_pounds = round( $this->twl_kilograms * 2.20462, 2 );
			}

			// Finishing build of total weight gained.
			$this->twg_kilograms = round( $total_weight_gained / 2.20462, 2 );
			$this->twg_pounds    = $total_weight_gained;

			if ( 0 === $this->twg_kilograms && 0 !== $this->twg_pounds ) {
				$this->twg_kilograms = round( $this->twg_pounds / 2.20462, 2 );
			}
			if ( 0 === $this->twg_pounds && 0 !== $this->twg_kilograms ) {
				$this->twg_pounds = round( $this->twg_kilograms * 2.20462, 2 );
			}

			// Finishing build of the Largest Single Weight Loss value.
			$this->twsl_kilograms = round( $twsl / 2.20462, 2 );
			$this->twsl_pounds    = $twsl;

			if ( 0 === $this->twsl_kilograms && 0 !== $this->twsl_pounds ) {
				$this->twsl_kilograms = round( $this->twsl_pounds / 2.20462, 2 );
			}
			if ( 0 === $this->twsl_pounds && 0 !== $this->twsl_kilograms ) {
				$this->twsl_pounds = round( $this->twsl_kilograms * 2.20462, 2 );
			}

			// Finishing build of the Largest Single Weight Gained value.
			$this->twsg_kilograms = round( $twsg / 2.20462, 2 );
			$this->twsg_pounds    = $twsg;

			if ( 0 === $this->twsg_kilograms && 0 !== $this->twsg_pounds ) {
				$this->twsg_kilograms = round( $this->twsg_pounds / 2.20462, 2 );
			}
			if ( 0 === $this->twsg_pounds && 0 !== $this->twsg_kilograms ) {
				$this->twsg_pounds = round( $this->twsg_kilograms * 2.20462, 2 );
			}

		}

		/**
		 *  Builds the stats data variables to be later used in the Stats HTML for the second section
		 */
		public function build_stats_data_2() {

			$temp_total_sys = 0;
			$temp_total_dys = 0;
			foreach ( $this->alluserdata as $key => $indiv_day ) {

				// 142/90/10:41,143/84/02:42 OR //
				// If there is any blood pressure data saved for this day whatsoever...
				if ( '//' !== $indiv_day->bloodpressure ) {

					$this->bp_day_counter++;

					// Get first recorded date of Blood Pressure.
					if ( '' === $this->first_bp ) {
						$this->first_bp = $indiv_day->humandate;
					}

					// If there are MULTIPLE ENTRIES of Blood Pressure data on one day...
					if ( stripos( $indiv_day->bloodpressure, ',' ) !== false ) {

						$tempbparray = explode( ',', $indiv_day->bloodpressure );
						foreach ( $tempbparray as $key => $value ) {

							// Iterate overall counter.
							$this->bp_entry_counter++;

							$tempbparray2 = explode( '/', $value );

							$temp_total_sys += $tempbparray2[0];
							$temp_total_dys += $tempbparray2[1];

							// Checking for highest Individual BP readings.
							if ( $tempbparray2[0] > $this->highest_sys ) {
								$this->highest_sys = round( $tempbparray2[0], 2 );
							}
							if ( $tempbparray2[1] > $this->highest_dys ) {
								$this->highest_dys = round( $tempbparray2[1], 2 );
							}

							// Checking for lowest Individual BP readings.
							if ( $tempbparray2[0] < $this->lowest_sys ) {
								$this->lowest_sys = round( $tempbparray2[0], 2 );
							}
							if ( $tempbparray2[1] < $this->lowest_dys ) {
								$this->lowest_dys = round( $tempbparray2[1], 2 );
							}

							// Working on highest Single reading.
							$temp_single_highest_read = explode( '/', $this->highest_single_bp_read );
							if ( ( $tempbparray2[0] > (int) $temp_single_highest_read[0] ) && ( $tempbparray2[1] > (int) $temp_single_highest_read[1] ) ) {
								$this->highest_single_bp_read = $tempbparray2[0] . '/' . $tempbparray2[1];
							}

							// Working on lowest Single reading.
							$temp_single_lowest_read = explode( '/', $this->lowest_single_bp_read );
							if ( ( $tempbparray2[0] < (int) $temp_single_lowest_read[0] ) && ( $tempbparray2[1] < (int) $temp_single_lowest_read[1] ) ) {
								$this->lowest_single_bp_read = $tempbparray2[0] . '/' . $tempbparray2[1];
							}
						}
					} else {

						// Iterate overall counter.
						$this->bp_entry_counter++;

						$tempbparray1 = explode( '/', $indiv_day->bloodpressure );

						// Checking for highest Individual BP readings.
						if ( $tempbparray1[0] > $this->highest_sys ) {
							$this->highest_sys = round( $tempbparray1[0], 2 );
						}
						if ( $tempbparray1[1] > $this->highest_dys ) {
							$this->highest_dys = round( $tempbparray1[1], 2 );
						}

						// Checking for lowest Individual BP readings.
						if ( $tempbparray1[0] < $this->lowest_sys ) {
							$this->lowest_sys = round( $tempbparray1[0], 2 );
						}
						if ( $tempbparray1[1] < $this->lowest_dys ) {
							$this->lowest_dys = round( $tempbparray1[1], 2 );
						}

						$temp_total_sys += $tempbparray1[0];
						$temp_total_dys += $tempbparray1[1];

						// Working on highest Single reading.
						$temp_single_highest_read = explode( '/', $this->highest_single_bp_read );
						if ( ( $tempbparray1[0] > (int) $temp_single_highest_read[0] ) && ( $tempbparray1[1] > (int) $temp_single_highest_read[1] ) ) {
							$this->highest_single_bp_read = $tempbparray1[0] . '/' . $tempbparray1[1];
						}

						// Working on lowest Single reading.
						$temp_single_lowest_read = explode( '/', $this->lowest_single_bp_read );
						if ( ( $tempbparray1[0] < (int) $temp_single_lowest_read[0] ) && ( $tempbparray1[1] < (int) $temp_single_lowest_read[1] ) ) {
							$this->lowest_single_bp_read = $tempbparray1[0] . '/' . $tempbparray1[1];
						}
					}
				}
			}

			if ( 0 !== $this->bp_entry_counter ) {
				$this->average_sys = round( $temp_total_sys / $this->bp_entry_counter, 0 );
			}

			if ( 0 !== $this->bp_entry_counter ) {
				$this->average_dys = round( $temp_total_dys / $this->bp_entry_counter, 0 );
			}
		}

		/**
		 *  Builds the stats data variables to be later used in the Stats HTML for the third section
		 */
		public function build_stats_data_3() {
			// 123,32,4,32
			// Values for creating averages
			$temp_total_ldl   = 0;
			$temp_total_hdl   = 0;
			$temp_total_tri   = 0;
			$temp_total_total = 0;

			foreach ( $this->alluserdata as $key => $indiv_day ) {

				// If Cholesterol has been recorded for the day.
				if ( ',,,' !== $indiv_day->cholesterol ) {

					$chol_array = explode( ',', $indiv_day->cholesterol );

					// Record first Chol. date.
					if ( '' === $this->first_chol ) {
						$this->first_chol = $indiv_day->humandate;
					}

					// Add up values for averages.
					$temp_total_ldl   += $chol_array[0];
					$temp_total_hdl   += $chol_array[1];
					$temp_total_tri   += $chol_array[2];
					$temp_total_total += $chol_array[3];

					// Calculate highest total reading.
					if ( $this->highest_ch < $chol_array[3] ) {
						$this->highest_ch = $chol_array[3];
					}

					// Calculate lowest total reading.
					if ( $this->lowest_ch > $chol_array[3] ) {
						$this->lowest_ch = $chol_array[3];
					}

					$this->ch_day_counter++;

				}
			}

			// Some final calcs.
			if ( 0 !== $temp_total_ldl && 0 !== $this->ch_day_counter ) {
				$this->average_ch_ldl = round( $temp_total_ldl / $this->ch_day_counter, 2 );
			}

			if ( 0 !== $temp_total_hdl && 0 !== $this->ch_day_counter ) {
				$this->average_ch_hdl = round( $temp_total_hdl / $this->ch_day_counter, 2 );
			}

			if ( 0 !== $temp_total_tri && 0 !== $this->ch_day_counter ) {
				$this->average_ch_tri = round( $temp_total_tri / $this->ch_day_counter, 2 );
			}

			if ( 0 !== $temp_total_total && 0 !== $this->ch_day_counter ) {
				$this->average_ch_total = round( $temp_total_total / $this->ch_day_counter, 2 );
			}

		}

		/**
		 *  Builds the Stats HTML for each of the 3 sections utilizing the
		 *  member variables created in the 3 previous functions.
		 */
		public function get_stats_area_html() {

			// Build data for the Weight area.
			$this->build_stats_data_1();

			// Build data for the Blood Pressure area.
			$this->build_stats_data_2();

			// Build data for the Cholesterol area.
			$this->build_stats_data_3();

			// If there is more than 1 day of Weight data saved...
			$stats_1 = '';
			if ( $this->weight_entry_counter > 1 ) {
				$stats_1 = '
			<img class="wphealthtracker-d3-chart-title-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'computer.svg"/>		
			<p class="wphealthtracker-d3-chart-subtitle-actual">' . $this->translations->d3_trans_2 . '</p>
			<div class="wphealthtracker-d3-chart-title-line"></div>
			<div class="wphealthtracker-dashboard-actual-info">
				<div class="wphealthtracker-dashboard-row">
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-firstdaytracked" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->d3_trans_3 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->first_weight . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-vitals-highestweight" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->d3_trans_6 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->highest_weight_pounds . ' ' . $this->translations->d3_trans_4 . '/' . $this->highest_weight_kilograms . ' ' . $this->translations->d3_trans_5 . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-vitals-lowestweight" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->d3_trans_7 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->lowest_weight_pounds . ' ' . $this->translations->d3_trans_4 . '/' . $this->lowest_weight_kilograms . ' ' . $this->translations->d3_trans_5 . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-vitals-averageweight" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->d3_trans_8 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->average_weight_pounds . ' ' . $this->translations->d3_trans_4 . '/' . $this->average_weight_kilograms . ' ' . $this->translations->d3_trans_5 . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-vitals-totalweightlost" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->d3_trans_9 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->twl_pounds . ' ' . $this->translations->d3_trans_4 . '/' . $this->twl_kilograms . ' ' . $this->translations->d3_trans_5 . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-vitals-totalweightgained" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->d3_trans_17 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->twg_pounds . ' ' . $this->translations->d3_trans_4 . '/' . $this->twg_kilograms . ' ' . $this->translations->d3_trans_5 . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-vitals-largestsingleweightloss" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->d3_trans_10 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->twsl_pounds . ' ' . $this->translations->d3_trans_4 . '/' . $this->twsl_kilograms . ' ' . $this->translations->d3_trans_5 . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-vitals-largestsingleweightgain" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->d3_trans_11 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->twsg_pounds . ' ' . $this->translations->d3_trans_4 . '/' . $this->twsg_kilograms . ' ' . $this->translations->d3_trans_5 . '</span>
						</p>
					</div>
				</div>
			</div>';

			}

			// If there's just one day of weight data saved, display the 'No Enough Data' message.
			if ( 1 === $this->weight_entry_counter ) {
				$stats_1 = '<div style="bottom:58px;" class="wphealthtracker-no-saved-data-div">
				<p>
					<img class="wphealthtracker-shocked-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'shocked.svg">
					<span class="wphealthtracker-no-saved-span1">' . $this->translations->d3_trans_15 . '</span>
					<br>
					' . $this->translations->d3_trans_16 . '
					<br>' . $this->translations->d3_trans_14 . '
				</p>
			</div>';
			}

			// If there's no weight data saved, display the 'No Data' message.
			if ( 0 === $this->weight_entry_counter ) {
				$stats_1 = '<div style="bottom:58px;" class="wphealthtracker-no-saved-data-div">
				<p>
					<img class="wphealthtracker-shocked-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'shocked.svg">
					<span class="wphealthtracker-no-saved-span1">' . $this->translations->d3_trans_15 . '</span>
					<br>
					' . $this->translations->d3_trans_12 . '
					<br>' . $this->translations->d3_trans_14 . '
				</p>
			</div>';
			}

			// If there is more than 1 day of Blood Pressure data saved...
			$stats_2 = '';
			if ( $this->bp_day_counter > 1 ) {
				$stats_2 = '
			<img class="wphealthtracker-d3-chart-title-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'computer.svg"/>		
			<p class="wphealthtracker-d3-chart-subtitle-actual">' . $this->translations->d3_trans_25 . '</p>
			<div class="wphealthtracker-d3-chart-title-line"></div>
			<div class="wphealthtracker-dashboard-actual-info">
				<div class="wphealthtracker-dashboard-row">
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-firstdaytracked" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->d3_trans_3 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->first_bp . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-vitals-averagebpreading" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->d3_trans_30 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->average_sys . '/' . $this->average_dys . '
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-vitals-highestbpreading" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->d3_trans_31 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->highest_single_bp_read . '
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-vitals-lowestbpreading" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->d3_trans_32 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->lowest_single_bp_read . '
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-vitals-highestsys" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->d3_trans_26 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->highest_sys . '
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-vitals-lowestsys" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->d3_trans_27 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->lowest_sys . '
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-vitals-highestdys" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->d3_trans_28 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->highest_dys . '
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-vitals-lowestdys" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->d3_trans_29 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->lowest_dys . '
						</p>
					</div>
				</div>
			</div>';

			}

			// If there's just one day of blood pressure data saved, display the 'Not Enough Data' message.
			if ( 1 === $this->bp_day_counter ) {
				$stats_2 = '<div class="wphealthtracker-no-saved-data-div">
				<p>
					<img class="wphealthtracker-shocked-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'shocked.svg">
					<span class="wphealthtracker-no-saved-span1">' . $this->translations->d3_trans_15 . '</span>
					<br>
					' . $this->translations->d3_trans_24 . '
					<br>' . $this->translations->d3_trans_33 . '
				</p>
			</div>';
			}

			// If there's no blood pressure data saved, display the 'No Data' message.
			if ( 0 === $this->bp_day_counter ) {
				$stats_2 = '<div class="wphealthtracker-no-saved-data-div">
				<p>
					<img class="wphealthtracker-shocked-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'shocked.svg">
					<span class="wphealthtracker-no-saved-span1">' . $this->translations->d3_trans_15 . '</span>
					<br>
					' . $this->translations->d3_trans_22 . '
					<br>' . $this->translations->d3_trans_33 . '
				</p>
			</div>';
			}

			// If there is more than 1 day of Cholesterol data saved...
			$stats_3 = '';
			if ( $this->ch_day_counter > 1 ) {
				$stats_3 = '
			<img class="wphealthtracker-d3-chart-title-img" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'computer.svg"/>		
			<p class="wphealthtracker-d3-chart-subtitle-actual">' . $this->translations->d3_trans_41 . '</p>
			<div class="wphealthtracker-d3-chart-title-line"></div>
			<div class="wphealthtracker-dashboard-actual-info">
				<div class="wphealthtracker-dashboard-row">
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="dash-firstdaytracked" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->d3_trans_3 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->first_chol . '</span>
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-vitals-averageldl" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->d3_trans_42 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->average_ch_ldl . '
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-vitals-averagehdl" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->d3_trans_43 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->average_ch_hdl . '
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-vitals-averagetri" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->d3_trans_44 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->average_ch_tri . '
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-vitals-averagetotalcho" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->d3_trans_45 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->average_ch_total . '
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-vitals-highesttotalcho" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->d3_trans_46 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->highest_ch . '
						</p>
					</div>
					<div class="wphealthtracker-dashboard-row-entry">
						<p>
							<img class="wphealthtracker-icon-image-question-dashboard" data-label="d3-vitals-lowesttotalcho" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'question-red.svg" />
							<span class="wphealthtracker-dashboard-row-entry-label">' . $this->translations->d3_trans_47 . '</span>
							<span class="wphealthtracker-dashboard-row-entry-data">' . $this->lowest_ch . '
						</p>
					</div>
				</div>
			</div>';

			}

			// If there's just one day of Cholesterol data saved, display the 'Not Enough Data' message.
			if ( 1 === $this->ch_day_counter ) {
				$stats_3 = '<div style="bottom:58px;" class="wphealthtracker-no-saved-data-div">
				<p>
					<img class="wphealthtracker-shocked-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'shocked.svg">
					<span class="wphealthtracker-no-saved-span1">' . $this->translations->d3_trans_15 . '</span>
					<br>
					' . $this->translations->d3_trans_49 . '
					<br>' . $this->translations->d3_trans_52 . '
				</p>
			</div>';
			}

			// If there's no blood pressure data saved, display the 'No Data' message.
			if ( 0 === $this->ch_day_counter ) {
				$stats_3 = '<div style="bottom:58px;" class="wphealthtracker-no-saved-data-div">
				<p>
					<img class="wphealthtracker-shocked-image" src="' . WPHEALTHTRACKER_ROOT_IMG_ICONS_URL . 'shocked.svg">
					<span class="wphealthtracker-no-saved-span1">' . $this->translations->d3_trans_15 . '</span>
					<br>
					' . $this->translations->d3_trans_51 . '
					<br>' . $this->translations->d3_trans_52 . '
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
