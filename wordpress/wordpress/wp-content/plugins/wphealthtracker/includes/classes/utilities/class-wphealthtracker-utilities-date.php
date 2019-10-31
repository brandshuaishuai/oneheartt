<?php
/**
 * Class WPHealthTracker_Utilities_Date - class-wphealthtracker-utilities-date.php
 *
 * @author   Jake Evans
 * @category Admin
 * @package  Includes/Exercise
 * @version  0.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPHealthTracker_Utilities_Date', false ) ) :
	/**
	 * WPHealthTracker_Utilities_Date class. Here we'll house everything to do with getting the current date.
	 */
	class WPHealthTracker_Utilities_Date {

		/** Common member variable
		 *
		 *  @var string $human_date
		 */
		public $returndate = '';

		/**
		 * Returns the current date using the WordPress 'current_time()' function and accepts a time format
		 *
		 * @param string $format - The format for the date.
		 */
		public function wphealthtracker_get_date_via_current_time( $format ) {

			$blogtime = current_time( $format );
			list( $today_year, $today_month, $today_day, $hour, $minute, $second ) = preg_split( '([^0-9])', $blogtime );
			return $this->return_date = $today_month . '-' . $today_day . '-' . $today_year;

		}

	}

endif;
