<?php
/**
 * Class WPHealthTracker_Translations - wphealthtracker-translations.php
 *
 * @author   Jake Evans
 * @category Translations
 * @package  Includes/Classes/Translations
 * @version  0.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPHealthTracker_Translations', false ) ) :
	/**
	 * WPHealthTracker_Translations class. This class will house all the translations we may ever need...
	 */
	class WPHealthTracker_Translations {

		/**
		 *  This function will house all the strings needed for the Welcome Tab.
		 */
		public function edit_users_tab_trans_strings() {

			$this->edituser_trans_1 = __( 'Select a User to Edit & Delete', 'wphealthtracker-textdomain' );
			$this->edituser_trans_2 = __( 'Edit & Delete Existing Users Below', 'wphealthtracker-textdomain' );
			$this->edituser_trans_3 = __( 'Select This User', 'wphealthtracker-textdomain' );
			$this->edituser_trans_4 = __( 'Save Changes to This User', 'wphealthtracker-textdomain' );
			$this->edituser_trans_5 = __( 'You\'ve just edited this WPHealthTracker User', 'wphealthtracker-textdomain' );
			$this->edituser_trans_6 = __( 'Delete This User', 'wphealthtracker-textdomain' );
			$this->edituser_trans_7 = __( 'Delete User', 'wphealthtracker-textdomain' );
			$this->edituser_trans_8 = __( 'Cancel', 'wphealthtracker-textdomain' );
			$this->edituser_trans_9 = __( 'Are you sure? Once deleted, all associated data will be removed forever for this user!', 'wphealthtracker-textdomain' );

			return $translation_array = array(
				'editusertrans1' => $this->edituser_trans_1,
				'editusertrans2' => $this->edituser_trans_2,
				'editusertrans3' => $this->edituser_trans_3,
				'editusertrans4' => $this->edituser_trans_4,
				'editusertrans5' => $this->edituser_trans_5,
				'editusertrans6' => $this->edituser_trans_6,
				'editusertrans7' => $this->edituser_trans_7,
				'editusertrans8' => $this->edituser_trans_8,
				'editusertrans9' => $this->edituser_trans_9,
			);
		}

		/**
		 *  This function will house all the strings needed for the Welcome Tab.
		 */
		public function welcome_tab_trans_strings() {

			$this->welcome_trans_1  = __( 'Welcome to', 'wphealthtracker-textdomain' );
			$this->welcome_trans_2  = __( 'Create a User', 'wphealthtracker-textdomain' );
			$this->welcome_trans_3  = __( 'Settings', 'wphealthtracker-textdomain' );
			$this->welcome_trans_4  = __( 'Track Vitals Data', 'wphealthtracker-textdomain' );
			$this->welcome_trans_5  = __( 'Track Diet Data', 'wphealthtracker-textdomain' );
			$this->welcome_trans_6  = __( 'Track Exercise Data', 'wphealthtracker-textdomain' );
			$this->welcome_trans_7  = __( 'View Vitals Stats', 'wphealthtracker-textdomain' );
			$this->welcome_trans_8  = __( 'View Diet Stats', 'wphealthtracker-textdomain' );
			$this->welcome_trans_9  = __( 'View Exercise Stats', 'wphealthtracker-textdomain' );
			$this->welcome_trans_10 = __( 'The #1 WordPress Plugin for Achieving Health and Fitness Goals!', 'wphealthtracker-textdomain' );
			$this->welcome_trans_11 = __( 'WPHealthTracker', 'wphealthtracker-textdomain' );
			$this->welcome_trans_12 = __( 'Extensions & Add-ons', 'wphealthtracker-textdomain' );
			$this->welcome_trans_13 = __( 'Guides & Tutorials', 'wphealthtracker-textdomain' );

			return $translation_array = array(
				'welcometrans1' => $this->welcome_trans_1,
			);
		}

		/**
		 *  This function will house all the strings needed for the Welcome Tab.
		 */
		public function front_dashboard_trans_strings() {

			$this->frontdashboard_trans_1 = __( 'Welcome', 'wphealthtracker-textdomain' );
			$this->frontdashboard_trans_2 = __( 'Last Login', 'wphealthtracker-textdomain' );
			$this->frontdashboard_trans_3 = __( 'Favorite Motivational Quote', 'wphealthtracker-textdomain' );
			$this->frontdashboard_trans_4 = __( 'Login', 'wphealthtracker-textdomain' );
			$this->frontdashboard_trans_5 = __( 'Create an Account', 'wphealthtracker-textdomain' );
			$this->frontdashboard_trans_6 = __( 'Email / Username', 'wphealthtracker-textdomain' );
			$this->frontdashboard_trans_7 = __( 'Password', 'wphealthtracker-textdomain' );
			$this->frontdashboard_trans_8 = __( 'Don\'t have an Account yet? Just click the \'Create an Account\' button below to get started! ', 'wphealthtracker-textdomain' );

			return $translation_array = array(
				'frontdashboard1' => $this->frontdashboard_trans_1,
				'frontdashboard2' => $this->frontdashboard_trans_2,
				'frontdashboard3' => $this->frontdashboard_trans_3,
				'frontdashboard4' => $this->frontdashboard_trans_4,
				'frontdashboard5' => $this->frontdashboard_trans_5,
				'frontdashboard6' => $this->frontdashboard_trans_6,
				'frontdashboard7' => $this->frontdashboard_trans_7,
				'frontdashboard8' => $this->frontdashboard_trans_8,
			);
		}

		/**
		 *  This function will house all the strings that would need translations specifically in the wphealthtracker-admin-js.js JavaScript file.
		 */
		public function admin_js_trans_strings() {
			return $translation_array = array(
				'adminjstransstring1'   => __( 'Select a User', 'wphealthtracker-textdomain' ),
				'adminjstransstring2'   => __( 'Choose a User from the Drop-Down list below to view today\'s information, as well as any past days of information, if they exist.  ', 'wphealthtracker-textdomain' ),
				'adminjstransstring3'   => __( 'Weight', 'wphealthtracker-textdomain' ),
				'adminjstransstring4'   => __( 'Enter your Weight here, in either Pounds or Kilograms. This will be used to generate a graph of your Weight change over time, among other things.', 'wphealthtracker-textdomain' ),
				'adminjstransstring5'   => __( 'Blood Pressure', 'wphealthtracker-textdomain' ),
				'adminjstransstring6'   => __( 'Enter your Blood Pressure readings here. This will be used in a graph to track your blood pressure readings over time. Click the \'Add Row\' button to add additional Blood Pressure readings, and enter a time of day to see at what times your Blood Pressure is higher or lower.', 'wphealthtracker-textdomain' ),
				'adminjstransstring7'   => __( 'Blood Oxygen Level', 'wphealthtracker-textdomain' ),
				'adminjstransstring8'   => __( 'Blah', 'wphealthtracker-textdomain' ),
				'adminjstransstring9'   => __( 'Expand', 'wphealthtracker-textdomain' ),
				'adminjstransstring10'  => __( 'Minimize', 'wphealthtracker-textdomain' ),
				'adminjstransstring11'  => __( 'Enter your 4 Cholesterol values here, including your LDL, HDL, Triglycerides, and Total Cholesterol numbers. This will be used in a  graph to show Cholesterol changes over time.', 'wphealthtracker-textdomain' ),
				'adminjstransstring12'  => __( 'Tip', 'wphealthtracker-textdomain' ),
				'adminjstransstring13'  => __( 'Record your Blood Pressure at the same times every day - for example, at the same time upon waking, a time in the afternoon, and right before bed.', 'wphealthtracker-textdomain' ),
				'adminjstransstring14'  => __( 'Enter your Blood Sugar readings here. Click the \'Add Row\' button to add additional Blood Sugar readings, and enter a time of day to see at what times your Blood Sugar is higher or lower.', 'wphealthtracker-textdomain' ),
				'adminjstransstring15'  => __( 'Record your Blood Sugar at the same times every day - for example, at the same time upon waking, a time in the afternoon, and right before bed.', 'wphealthtracker-textdomain' ),
				'adminjstransstring16'  => __( 'Enter your Blood Oxygen readings here. Click the \'Add Row\' button to add additional Blood Oxygen readings, and enter a time of day to see at what times your Blood Oxygen is higher or lower.', 'wphealthtracker-textdomain' ),
				'adminjstransstring17'  => __( 'Record your Blood Oxygen at the same times every day - for example, at the same time upon waking, a time in the afternoon, and right before bed.', 'wphealthtracker-textdomain' ),
				'adminjstransstring18'  => __( 'Enter your Body Temperature readings here. Click the \'Add Row\' button to add additional Body Temperature readings, and enter a time of day to see at what times your Body Temperature is higher or lower.', 'wphealthtracker-textdomain' ),
				'adminjstransstring19'  => __( 'Record your Body Temperature at the same times every day - for example, at the same time upon waking, a time in the afternoon, and right before bed.', 'wphealthtracker-textdomain' ),
				'adminjstransstring20'  => __( 'Enter your Heart Rate readings here. Click the \'Add Row\' button to add additional Heart Rate readings, and enter a time of day to see at what times your Heart Rate is higher or lower.', 'wphealthtracker-textdomain' ),
				'adminjstransstring21'  => __( 'Record your Heart Rate at the same times every day - for example, at the same time upon waking, a time in the afternoon, and right before bed.', 'wphealthtracker-textdomain' ),
				'adminjstransstring22'  => __( 'Here you can upload Images that are related to your Vitals data - for example, an image of Vitals data from another app or program, a picture of your weight scale number, or a printout of your Vitals info from your doctor. Either use the \'Choose/Upload Image\' button to the right of this message to upload your image, or manually place the URL of where the image is located in the text box below. Add additional images by clicking the \'Add Row\' button.', 'wphealthtracker-textdomain' ),
				'adminjstransstring23'  => __( 'Here you can upload Files that are related to your Vitals data - for example, generated file(s) from another app or program, or a medical report from your doctor. Either use the \'Choose/Upload File\' button to the right of this message to upload your image, or manually place the URL of where the image is located in the text box below. Add additional files by clicking the \'Add Row\' button.', 'wphealthtracker-textdomain' ),
				'adminjstransstring24'  => __( 'If you\'re the WPHealthTracker SuperAdmin, you can set a Default User that will be automatically selected from this Drop-Down on the General Settings page.', 'wphealthtracker-textdomain' ),

				'adminjstransstring25'  => __( 'Enter the name of your Food Item here. The names of your Food Items will be used in the graph on the Diet Tab of the Statistics page.', 'wphealthtracker-textdomain' ),
				'adminjstransstring26'  => __( 'Keep your Food Item names as short, concise, and unique as possible for best results on the Diet Tab of the Statistics page.', 'wphealthtracker-textdomain' ),
				'adminjstransstring27'  => __( 'Food Item Name', 'wphealthtracker-textdomain' ),
				'adminjstransstring28'  => __( 'Enter a Category name of your Food Item here. Category names will be used to organize and separate your individual food items. This is useful if you have similar foods and/or foods with the same name but different servings sizes or other data. Also useful for simply separating food items by meal, such as Breakfast, Lunch, Dinner, or Snack.', 'wphealthtracker-textdomain' ),
				'adminjstransstring29'  => __( 'Keep your Food Item names as short, concise, and unique as possible for best results on the Diet Tab of the Statistics page.', 'wphealthtracker-textdomain' ),
				'adminjstransstring30'  => __( 'Food Category Name', 'wphealthtracker-textdomain' ),
				'adminjstransstring31'  => __( 'The time of day you consumed this Food Item.', 'wphealthtracker-textdomain' ),
				'adminjstransstring32'  => __( 'The amount of Energy contained in this Food Item. Can be recorded in standard U.S. Calories, or in Kilocalories/Kilojoules (for those that prefer the measurement most of the rest of the world uses for rating a Food Item\'s energy content. This number will be used in throughout the Diet tab of the Statistics page.', 'wphealthtracker-textdomain' ),
				'adminjstransstring33'  => __( 'Choose a Food Item Energy Measurement - Standard U.S. Calories, or the more widely-used Kilocalories/Kilojoules.', 'wphealthtracker-textdomain' ),
				'adminjstransstring34'  => __( 'Food Energy Measurement', 'wphealthtracker-textdomain' ),
				'adminjstransstring35'  => __( 'Enter the amount of Protein found in this Food Item. This is a type of nutrient often called a \'Macronutrient\' - a nutrient that the Human body requires in relatively large amounts. This number will be used in the Macronutrients chart on the Diet tab of the Statistics page.', 'wphealthtracker-textdomain' ),
				'adminjstransstring36'  => __( 'Protein Type', 'wphealthtracker-textdomain' ),
				'adminjstransstring37'  => __( 'Select the type of Protein this Food Item contains from the options in the Drop-Down.', 'wphealthtracker-textdomain' ),
				'adminjstransstring38'  => __( 'Enter the Total Fat contained within this Food Item. Fats are types of nutrients often called \'Macronutrients\' - nutrients that the Human body requires in relatively large amounts. This number will be used in the Macronutrients chart on the Diet tab of the Statistics page.', 'wphealthtracker-textdomain' ),
				'adminjstransstring39'  => __( 'Enter the Total Saturated Fat contained within this Food Item. Saturated fat is fat that is solid at room temperature (like cold bacon grease), and that is fully \'Saturated\' with hydrogen, thus the name. Once considered absolutely unhealthy, recent studies have shed some doubt on that belief (especially when replaced by processed carbohydrates), however, it\'s generally recommended to limit your intake of Saturated fat.', 'wphealthtracker-textdomain' ),
				'adminjstransstring40'  => __( 'Enter the Total Monounsaturated Fat contained within this Food Item. Considered to be a \'Healthier Fat,\' Monounsaturated fat is fat that is liquid at room temperature (Olive Oil is mostly Monounsaturated fat). This fat is usually associated with \'Mediterrainian\' diets and can be found in things like Avocados and most types of nuts. ', 'wphealthtracker-textdomain' ),
				'adminjstransstring41'  => __( 'Enter the Total Polyunsaturated Fat contained within this Food Item. Polyunsaturated Fats are \'Essential Fats\' and mainly consist of either Omega-3 or Omega-6 Fatty Acids. Essential Fats are required by the Human body and must be obtained via food. They\'re used for building cell membranes and nerve converings, among other things. Polyunsaturated Fats can be found in foods such as fatty fish, walnuts, and sunflower & corn oils.', 'wphealthtracker-textdomain' ),
				'adminjstransstring42'  => __( 'Enter the Total Carbohydrates contained within this Food Item. Carbohydrates are types of nutrients often called \'Macronutrients\' - nutrients that the Human body requires in relatively large amounts. The Human body converts Carbohydrates mostly into Glucose (a type of sugar, which itself is a type of Carbohydrate), which is why it\'s important to consume high-quality, non-processed Carbohydrates, as these types of Carbs are broken down at a slower rate, wihch helps prevent short-term blood sugar spikes - something that is generally recommended to be avoided for good health. This number will be used in the Macronutrients chart on the Diet tab of the Statistics page.', 'wphealthtracker-textdomain' ),
				'adminjstransstring43'  => __( 'Enter the Total Dietary Fiber contained within this Food Item. Dietary Fiber is not digested by the Human body, and comes in two varieties - Soluble (dissolves in water), and Insoluble (does not dissolve in water). Soluble Fiber can help lower Cholesterol Levels and control Blood Sugar, and Insoluble Fiber can aid in digestive movement and healthy bowel function. Dietary Fiber also helps control weight by leading to a sense of \'fullness\', leading to a temporarily reduced appetite.', 'wphealthtracker-textdomain' ),
				'adminjstransstring44'  => __( 'Enter the Total Sugars contained within this Food Item. Sugars are types of Carbohydrates that act as a source of energy for the Human body, however, excessive consumption of Sugar is generally related to negative health effects, including obesity and diabeties. Natural sugars, like the types found in dairy and fruits (but not in most processed items such as \'Fruit Snacks,\' \'Fruit Juices,\' and \'Fruit Cups\' ), are considered healthier Sugars, while Sugars found in most processed foods and sugary soft drinks are considered the unhealthiest kinds.', 'wphealthtracker-textdomain' ),
				'adminjstransstring45'  => __( 'Here you can upload Images that are related to your Food Item - for example, an image of the Food Item itself, or a picture of the Nutrition Label. Either use the \'Choose/Upload Image\' button to the right of this message to upload your image, or manually place the URL of where the image is located in the text box below.', 'wphealthtracker-textdomain' ),
				'adminjstransstring46'  => __( 'Here you can upload Files that are related to your Food Item - for example, a digital nutrition/diet document, or a PDF of the Nutrition Label. Either use the \'Choose/Upload File\' button to the right of this message to upload your file, or manually place the URL of where the file is located in the text box below.', 'wphealthtracker-textdomain' ),
				'adminjstransstring47'  => __( 'Here you can upload Images that are related to your Food Item - for example, an image of the Food Item itself, or a picture of the Nutrition Label. Either use the \'Choose/Upload Image\' button below to upload your image, or manually place the URL of where the image is located in the text box to the left of this message.', 'wphealthtracker-textdomain' ),
				'adminjstransstring48'  => __( 'Here you can upload Files that are related to your Food Item - for example, a digital nutrition/diet document, or a PDF of the Nutrition Label. Either use the \'Choose/Upload File\' button below to upload your file, or manually place the URL of where the file is located in the text box to the left of this message.', 'wphealthtracker-textdomain' ),
				'adminjstransstring49'  => __( 'Enter the name of your Exercise here. The names of your Exercises will be used throughout the Exercise Tab of the Statistics page.', 'wphealthtracker-textdomain' ),
				'adminjstransstring50'  => __( 'Keep your Exercise names as short, concise, and unique as possible for best results on the Exercise Tab of the Statistics page.', 'wphealthtracker-textdomain' ),
				'adminjstransstring51'  => __( 'Choose an Exercise Type from the Drop-Down below that this exercise can be best described as. This information will be used throughout the Exercise Tab of the Statistics page.', 'wphealthtracker-textdomain' ),
				'adminjstransstring52'  => __( 'Enter the Time you began this Exercise. This information will be used to plot Exercise Times on the Exercise Tab of the Statistics page, as well as to calculate values such as the average time of day your Exercises occur.', 'wphealthtracker-textdomain' ),
				'adminjstransstring53'  => __( 'Enter the total amount of time it took you to complete this Exercise. Enter just the number here, and select your measurement (Seconds, Minutes, or Hours) in the Drop-Down box to the right. This information will be used throughout the Exercise Tab of the Statistics page.', 'wphealthtracker-textdomain' ),
				'adminjstransstring54'  => __( 'Select the measurement of time it took you to complete this Exercise from the Drop-Down below. Choose from Seconds, Minutes, or Hours. This information will be used throughout the Exercise Tab of the Statistics page.', 'wphealthtracker-textdomain' ),
				'adminjstransstring55'  => __( 'Exercise Duration Measurement', 'wphealthtracker-textdomain' ),
				'adminjstransstring56'  => __( 'Enter the Total Distance travelled during this Exercise (leave blank if Exercise does not involve distance). Enter just the number here, and select your measurement (Feet, Yards, Miles, Meters, or Kilometers), in the Drop-Down box to the right. This will be used on the Exercise Tab of the Statistics page to chart how far you\'ve travelled to various locations around the world (and beyond!)', 'wphealthtracker-textdomain' ),
				'adminjstransstring57'  => __( 'Select the distance measurement you travelled during this Exercise. ', 'wphealthtracker-textdomain' ),
				'adminjstransstring58'  => __( 'Exercise Distance Measurement', 'wphealthtracker-textdomain' ),
				'adminjstransstring59'  => __( 'Enter the Muscle Groups that were involved in this Exercise below. These Muscle Groups will be used throughout the Exercise Tab of the Statistics page.', 'wphealthtracker-textdomain' ),
				'adminjstransstring60'  => __( 'Enter the Weight used in this Set. If no extra weight was used aside from one\'s own bodyweight, then check the \'Bodyweight\' checkbox. Enter just the number here, and select your measurement (Pounds or Kilograms) in the Drop-Down box to the right.', 'wphealthtracker-textdomain' ),
				'adminjstransstring61'  => __( 'Weight of Set', 'wphealthtracker-textdomain' ),
				'adminjstransstring62'  => __( 'Enter the Number of Reps in this Set.', 'wphealthtracker-textdomain' ),
				'adminjstransstring63'  => __( 'Reps of Set', 'wphealthtracker-textdomain' ),
				'adminjstransstring64'  => __( 'Select the Weight Measurement for this Set, in either Pounds or Kilograms.', 'wphealthtracker-textdomain' ),
				'adminjstransstring65'  => __( 'Set Weight Measurement', 'wphealthtracker-textdomain' ),
				'adminjstransstring66'  => __( 'Here you can upload Images that are related to your Exercise - for example, an image of the Exercise itself, or a picture of the Exercise Machine used. Either use the \'Choose/Upload Image\' button to the right of this message to upload your image, or manually place the URL of where the image is located in the text box below.', 'wphealthtracker-textdomain' ),
				'adminjstransstring67'  => __( 'Here you can upload Files that are related to your Exercise - for example, a digital workout document, or a video of the Exercise being performed. Either use the \'Choose/Upload File\' button to the right of this message to upload your file, or manually place the URL of where the file is located in the text box below.', 'wphealthtracker-textdomain' ),
				'adminjstransstring68'  => __( 'Here you can upload Images that are related to your Exercise - for example, an image of the Exercise itself, or a picture of the Exercise Machine used. Either use the \'Choose/Upload Image\' button below to upload your image, or manually place the URL of where the image is located in the text box to the left of this message.', 'wphealthtracker-textdomain' ),
				'adminjstransstring69'  => __( 'Here you can upload Files that are related to your Exercise - for example, a digital workout document, or a video of the Exercise being performed. Either use the \'Choose/Upload File\' button below to upload your file, or manually place the URL of where the file is located in the text box to the left of this message.', 'wphealthtracker-textdomain' ),
				'adminjstransstring70'  => __( 'The total number of days that have tracked data and information.', 'wphealthtracker-textdomain' ),
				'adminjstransstring71'  => __( 'The longest run of days that have been tracked back-to-back, without missing a day of information.', 'wphealthtracker-textdomain' ),
				'adminjstransstring72'  => __( 'The date of the first day that data was tracked.', 'wphealthtracker-textdomain' ),
				'adminjstransstring73'  => __( 'The date of the last day that data was tracked.', 'wphealthtracker-textdomain' ),
				'adminjstransstring74'  => __( 'The largest gap between days tracked - the goal would be to not miss a day of recording your information.', 'wphealthtracker-textdomain' ),
				'adminjstransstring75'  => __( 'The total number of gaps between days tracked - this is how many times you\'ve missed at least one day of tracking data. The goal would be to have no gaps whatsoever.', 'wphealthtracker-textdomain' ),
				'adminjstransstring76'  => __( 'This is the first weight measurement that has been tracked.', 'wphealthtracker-textdomain' ),
				'adminjstransstring77'  => __( 'This is the most recent weight measurement that has been tracked.', 'wphealthtracker-textdomain' ),
				'adminjstransstring78'  => __( 'This is the first blood pressure measurement that has been tracked.', 'wphealthtracker-textdomain' ),
				'adminjstransstring79'  => __( 'This is the most recent blood pressure measurement that has been tracked.', 'wphealthtracker-textdomain' ),
				'adminjstransstring80'  => __( 'This is the first cholesterol measurement that has been tracked.', 'wphealthtracker-textdomain' ),
				'adminjstransstring81'  => __( 'This is the most recent cholesterol measurement that has been tracked.', 'wphealthtracker-textdomain' ),
				'adminjstransstring82'  => __( 'This is the highest single Weight measurement that has ever been tracked.', 'wphealthtracker-textdomain' ),
				'adminjstransstring83'  => __( 'This is the lowest single Weight measurement that has ever been tracked.', 'wphealthtracker-textdomain' ),
				'adminjstransstring84'  => __( 'This is your Average Weight, calculated from every Weight measurement that has ever been tracked.', 'wphealthtracker-textdomain' ),
				'adminjstransstring85'  => __( 'This is the total amount of Weight you\'ve ever lost (even if you gained weight and then lost more), calculated from every Weight measurement that has ever been tracked.', 'wphealthtracker-textdomain' ),
				'adminjstransstring86'  => __( 'This is the total amount of Weight you\'ve ever gained (even if you lost weight and then gained more), calculated from every Weight measurement that has ever been tracked.', 'wphealthtracker-textdomain' ),
				'adminjstransstring87'  => __( 'Largest Single Weight Loss', 'wphealthtracker-textdomain' ),
				'adminjstransstring88'  => __( 'This is the Largest Single Loss of Weight from one day to another ever recorded. Ideally, if you have no gaps in your tracked days, and you haven\'t fasted or lost a signifigant amount of water weight, this number should be quite low. However, if it\'s zero, that means you haven\'t lost any weight whatsoever - get to work!', 'wphealthtracker-textdomain' ),
				'adminjstransstring89'  => __( 'Largest Single Weight Gain', 'wphealthtracker-textdomain' ),
				'adminjstransstring90'  => __( 'This is the Largest Single Weight Gain from one day to another ever recorded. Ideally, this number should be as low as possible (assuming you don\'t have any gaps in your days tracked), however, there are lots of factors that can change your weight from one day to another aside from the amount of fat on your body, including how hydrated you are.', 'wphealthtracker-textdomain' ),
				'adminjstransstring91'  => __( 'Average Blood Pressure Reading', 'wphealthtracker-textdomain' ),
				'adminjstransstring92'  => __( 'This is your average Blood Pressure Reading, calculated from all Blood Pressure readings ever recorded.', 'wphealthtracker-textdomain' ),
				'adminjstransstring93'  => __( 'Highest Blood Pressure Reading', 'wphealthtracker-textdomain' ),
				'adminjstransstring94'  => __( 'This is your highest single Blood Pressure Reading, calculated from all Blood Pressure readings ever recorded.', 'wphealthtracker-textdomain' ),
				'adminjstransstring95'  => __( 'Lowest Blood Pressure Reading', 'wphealthtracker-textdomain' ),
				'adminjstransstring96'  => __( 'This is your lowest single Blood Pressure Reading, calculated from all Blood Pressure readings ever recorded.', 'wphealthtracker-textdomain' ),
				'adminjstransstring97'  => __( 'Highest Systolic Reading', 'wphealthtracker-textdomain' ),
				'adminjstransstring98'  => __( 'This is the highest single Systolic Reading taken from all Blood Pressure readings ever recorded.', 'wphealthtracker-textdomain' ),
				'adminjstransstring99'  => __( 'Lowest Systolic Reading', 'wphealthtracker-textdomain' ),
				'adminjstransstring100' => __( 'This is the lowest single Systolic Reading taken from all Blood Pressure readings ever recorded.', 'wphealthtracker-textdomain' ),
				'adminjstransstring101' => __( 'Highest Diastolic Reading', 'wphealthtracker-textdomain' ),
				'adminjstransstring102' => __( 'This is the highest single Diastolic Reading taken from all Blood Pressure readings ever recorded.', 'wphealthtracker-textdomain' ),
				'adminjstransstring103' => __( 'Highest Diastolic Reading', 'wphealthtracker-textdomain' ),
				'adminjstransstring104' => __( 'This is the highest single Diastolic Reading taken from all Blood Pressure readings ever recorded.', 'wphealthtracker-textdomain' ),
				'adminjstransstring105' => __( 'This is the average LDL number, calculated from all Cholesterol readings ever recorded.', 'wphealthtracker-textdomain' ),
				'adminjstransstring106' => __( 'This is the average HDL number, calculated from all Cholesterol readings ever recorded.', 'wphealthtracker-textdomain' ),
				'adminjstransstring107' => __( 'This is the average Triglycerides number, calculated from all Cholesterol readings ever recorded.', 'wphealthtracker-textdomain' ),
				'adminjstransstring108' => __( 'This is the average Total Cholesterol number, calculated from all Cholesterol readings ever recorded.', 'wphealthtracker-textdomain' ),
				'adminjstransstring109' => __( 'This is the Highest Total Cholesterol number ever recorded.', 'wphealthtracker-textdomain' ),
				'adminjstransstring110' => __( 'This is the Lowest Total Cholesterol number ever recorded.', 'wphealthtracker-textdomain' ),
				'adminjstransstring111' => __( 'This section shows a chart of your Weight change over time, in both Pounds and Kilograms, and it also displays various statistics about your Weight, such as Average Weight, Lowest Weight, etc.', 'wphealthtracker-textdomain' ),
				'adminjstransstring112' => __( 'This section shows a chart of your Blood Pressure readings over time, for both your Systolic and Diastolic numbers. Change the Drop-Down box below to switch between your Average Daily Blood Pressure Readings and your First and Last Blood Pressure readings for each day, if multiple readings exist per day. This section also displays various statistics about your Blood Pressure, such as Average Single Reading, Lowest Single Reading, etc.', 'wphealthtracker-textdomain' ),
				'adminjstransstring113' => __( 'This section shows a chart of your Cholesterol readings over time, for all 4 individuals numbers (LDL, HDL, Triglycerides, and Total Cholesterol). This section also displays various statistics about your Cholesterol, such as Average LDL, Lowest Total Cholesterol, etc.', 'wphealthtracker-textdomain' ),
				'adminjstransstring114' => __( 'This is the number of totally unique food items you\'ve ever tracked. A food item is conidered unique if it has a unique name and a unique category.', 'wphealthtracker-textdomain' ),
				'adminjstransstring115' => __( 'These are the 3 food items that you consume the most often.', 'wphealthtracker-textdomain' ),
				'adminjstransstring116' => __( 'This is the average number of Calories/Kilocalories you consume on a daily basis, calculated from every food item you\'ve ever recorded.', 'wphealthtracker-textdomain' ),
				'adminjstransstring117' => __( 'This is the average number of Kilojoules you consume on a daily basis, calculated from every food item you\'ve ever recorded.', 'wphealthtracker-textdomain' ),
				'adminjstransstring118' => __( 'This is the average amount of Protein you consume on a daily basis, calculated from every food item you\'ve ever recorded.', 'wphealthtracker-textdomain' ),
				'adminjstransstring119' => __( 'This is the average amount of Total Carbohydrates you consume on a daily basis, calculated from every food item you\'ve ever recorded.', 'wphealthtracker-textdomain' ),
				'adminjstransstring120' => __( 'This is the average amount of Sugars you consume on a daily basis, calculated from every food item you\'ve ever recorded.', 'wphealthtracker-textdomain' ),
				'adminjstransstring121' => __( 'This is the average amount of Total Fats you consume on a daily basis, calculated from every food item you\'ve ever recorded.', 'wphealthtracker-textdomain' ),
				'adminjstransstring122' => __( 'This is the average amount of Fiber you consume on a daily basis, calculated from every food item you\'ve ever recorded.', 'wphealthtracker-textdomain' ),
				'adminjstransstring123' => __( 'This is the single food item you\'ve consumed the most.', 'wphealthtracker-textdomain' ),
				'adminjstransstring124' => __( 'This is the Average amount of Saturated Fats you consume on a daily basis, calculated from every food item you\'ve ever recorded.', 'wphealthtracker-textdomain' ),
				'adminjstransstring125' => __( 'This is the Average amount of Monounsaturated Fats you consume on a daily basis, calculated from every food item you\'ve ever recorded.', 'wphealthtracker-textdomain' ),
				'adminjstransstring126' => __( 'This is the Average amount of Polyunsaturated Fats you consume on a daily basis, calculated from every food item you\'ve ever recorded.', 'wphealthtracker-textdomain' ),
				'adminjstransstring127' => __( 'This is the total amount of Calories/Kilocalories you\'ve ever consumed, calculated from every food item you\'ve ever recorded.', 'wphealthtracker-textdomain' ),
				'adminjstransstring128' => __( 'This is the total amount of Kilojoules you\'ve ever consumed, calculated from every food item you\'ve ever recorded.', 'wphealthtracker-textdomain' ),
				'adminjstransstring129' => __( 'This is the single food item with the highest energy content you\'ve ever consumed, calculated from every food item you\'ve ever recorded.', 'wphealthtracker-textdomain' ),
				'adminjstransstring130' => __( 'Single Highest-Energy Food Item', 'wphealthtracker-textdomain' ),
				'adminjstransstring131' => __( 'This is the highest run of consequtive days that you\'ve decreased the amount of Calories/Kilocalories/Kilojoules you\'ve consumed on each of those days. The higher this number the better, if you goal is weight loss. Of course, this number can only go so high before you\'re simply not eating any food whatosever!', 'wphealthtracker-textdomain' ),
				'adminjstransstring132' => __( 'This is the highest run of consequtive days that you\'ve increased the amount of Calories/Kilocalories/Kilojoules you\'ve consumed on each of those days. The lower this number is the better, if your goal is weight loss.', 'wphealthtracker-textdomain' ),
				'adminjstransstring133' => __( 'This is the total amount of Protein you\'ve ever consumed, calculated from every food item you\'ve ever recorded.', 'wphealthtracker-textdomain' ),
				'adminjstransstring134' => __( 'This is the total amount of Carbohydrates you\'ve ever consumed, calculated from every food item you\'ve ever recorded.', 'wphealthtracker-textdomain' ),
				'adminjstransstring135' => __( 'This is the total amount of Fats you\'ve ever consumed, calculated from every food item you\'ve ever recorded.', 'wphealthtracker-textdomain' ),
				'adminjstransstring136' => __( 'This section shows a chart of the unique Food Items you\'ve consumed, sorted either by the order in which you recorded them, or by the number of times you\'ve consumed that food item, from highest to lowest. Hover over each red bar to see details about that food item. This section also displays various statistics about your Food Items, such as Average Daily Protein, Total Unique Food Items, etc.', 'wphealthtracker-textdomain' ),
				'adminjstransstring137' => __( 'This section shows a chart of the Energy of the food items you\'ve consumed over time, in Calories/Kilocalories and Kilojoules. This section also displays various statistics about your Food Item Energy amounts, such as Average Daily Energy consumed, Single Highest-Energy Food Item, etc.', 'wphealthtracker-textdomain' ),
				'adminjstransstring138' => __( 'This section shows a breakdown of the Macronutrients you\'ve consumed. Macronutrients are nutrients that the Human Body requires in relatively large amounts, and consist of Carbohydrates, Proteins, and Fats. The two pie charts below show the percentage breakdown of your daily and total Carbohydrates, Proteins, and Fats. There are different ideal percentages and ratios of these 3 Macronutrients depending on what your health goals are, such as weight loss or muscle gain. This section also displays various statistics about your Macronutrients, such as Average Daily Total Fats, Total Carbohydrates Consumed, etc.', 'wphealthtracker-textdomain' ),
				'adminjstransstring139' => __( 'This is the total number of unique Exercises you\'ve ever performed. An exercise is considered unique if it has a unique name.', 'wphealthtracker-textdomain' ),
				'adminjstransstring140' => __( 'This is the name of the one single Exercise you\'ve performed the most often.', 'wphealthtracker-textdomain' ),
				'adminjstransstring141' => __( 'This is the total number of Exercise Categories you\'ve performed Exercises within. The available Exercise Categories are Endurance/Cardio, Strength/Weightlifting, Balance, Flexibility, Mixed, and Other.', 'wphealthtracker-textdomain' ),
				'adminjstransstring142' => __( 'This is the name of your single most-used Exercise Category.', 'wphealthtracker-textdomain' ),
				'adminjstransstring143' => __( 'This is the total number of individual Muscle Groups you\'ve ever Exercised.', 'wphealthtracker-textdomain' ),
				'adminjstransstring144' => __( 'These are the names of your top 3 most-exercised Muscle Groups.', 'wphealthtracker-textdomain' ),
				'adminjstransstring145' => __( 'This is the total amount of time you\'ve spent exercising, in seconds.', 'wphealthtracker-textdomain' ),
				'adminjstransstring146' => __( 'This is the total amount of time you\'ve spent exercising, in minutes.', 'wphealthtracker-textdomain' ),
				'adminjstransstring147' => __( 'This is the total amount of time you\'ve spent exercising, in hours.', 'wphealthtracker-textdomain' ),
				'adminjstransstring148' => __( 'This section shows a Diagram of how far you\'ve travelled to and from various parts of the United States, based on the total distance you\'ve travelled during all of your Exercising. Hovering over each red dot will cause lines to emanate from the dot, corresponding with how many Miles/Kilometers you\'ve travelled, and a readout of the miles and percentages you\'ve travelled to each U.S. city will appear. Hover over the \'Play Demo\' text to see how this diagram will function once you\'ve travelled a decent amount in your Exercising. This section also displays various statistics about your Distance Travelled, such as Total Miles Travelled, Percentage of travel around the world, etc.', 'wphealthtracker-textdomain' ),
				'adminjstransstring149' => __( 'This section shows a Diagram illustrating which Muscle Groups you\'ve exercised the most. The darker colored each Muscle Group is, the more times you\'ve exercised that particular Muscle Group. This section also displays various statistics about the Muscle Groups you\'ve exercised, such as the single most-often exercised Muscle Group, how many total unique exercises you\'ve performed, etc.', 'wphealthtracker-textdomain' ),
				'adminjstransstring150' => __( 'This section shows a Heatmap illustrating what days and times of the week you\'ve exercised. The darker colored each square is, the more times you\'ve exercised on that particular day, at that particular time. This section also displays various statistics about when you\'ve exercised, such as your single-longest exercise, total minutes you\'ve spent exercising, etc.', 'wphealthtracker-textdomain' ),
				'adminjstransstring151' => __( 'This is the total amount of Miles you\'ve travelled in all of your exercising, if a distance value was provided.', 'wphealthtracker-textdomain' ),
				'adminjstransstring152' => __( 'This is the total amount of Kilometers you\'ve travelled in all of your exercising, if a distance value was provided.', 'wphealthtracker-textdomain' ),
				'adminjstransstring153' => __( 'This is the total amount of Meters you\'ve travelled in all of your exercising, if a distance value was provided.', 'wphealthtracker-textdomain' ),
				'adminjstransstring154' => __( 'This is the total amount of Yards you\'ve travelled in all of your exercising, if a distance value was provided.', 'wphealthtracker-textdomain' ),
				'adminjstransstring155' => __( 'This is the total amount of Feet you\'ve travelled in all of your exercising, if a distance value was provided.', 'wphealthtracker-textdomain' ),
				'adminjstransstring156' => __( 'This is the percentage of travel around the world you\'ve completed so far. To raise this percentage to 100%, you\'d have to travel 24,901 miles!', 'wphealthtracker-textdomain' ),
				'adminjstransstring157' => __( 'This is the percentage of travel from the Earth to the Moon you\'ve completed so far. To raise this percentage to 100%, you\'d have to travel 238,900 miles!', 'wphealthtracker-textdomain' ),
				'adminjstransstring158' => __( 'This is the single Exercise Category you\'ve performed Exercises from the most. ', 'wphealthtracker-textdomain' ),
				'adminjstransstring159' => __( 'This is the total number of individual Exercises you\'ve ever performed.', 'wphealthtracker-textdomain' ),
				'adminjstransstring160' => __( 'This is the longest single Exercise you\'ve ever performed, in Hours.', 'wphealthtracker-textdomain' ),
				'adminjstransstring161' => __( 'This is the longest single Exercise you\'ve ever performed, in Minutes.', 'wphealthtracker-textdomain' ),
				'adminjstransstring162' => __( 'This is the longest single Exercise you\'ve ever performed, in Seconds.', 'wphealthtracker-textdomain' ),
				'adminjstransstring163' => __( 'This is the average time of day you perform your Exercises.', 'wphealthtracker-textdomain' ),
				'adminjstransstring164' => __( 'Enter this user\'s First Name here. This is a required field.', 'wphealthtracker-textdomain' ),
				'adminjstransstring165' => __( 'Enter this user\'s Last Name here.', 'wphealthtracker-textdomain' ),
				'adminjstransstring166' => __( 'Enter this user\'s E-Mail Address here. This is a required field.', 'wphealthtracker-textdomain' ),
				'adminjstransstring167' => __( 'Enter this user\'s E-Mail Address again, just to make sure it\'s correct. This is a required field.', 'wphealthtracker-textdomain' ),
				'adminjstransstring168' => __( 'Create a Password for this user here. Click the \'Show Password\' text below to see the password you\'ve typed. This is a required field.', 'wphealthtracker-textdomain' ),
				'adminjstransstring169' => __( 'Enter this user\'s Password again, just to make sure it\'s correct. Click the \'Show Password\' text to the left to see the password you\'ve typed. This is a required field.', 'wphealthtracker-textdomain' ),
				'adminjstransstring170' => __( 'Choose a Username for this user. By default, the username for this user will be set to the part of the user\'s Email address before the \'@\' sign, but you can change it to whatever you\'d like. This is a required field.', 'wphealthtracker-textdomain' ),
				'adminjstransstring171' => __( 'Here you can set the User\'s Role. This will control what a user is able to see and what actions a user can take.', 'wphealthtracker-textdomain' ),
				'adminjstransstring172' => __( 'Can record and view their own data and stats, but has no access to other User\'s data or WPHealthTracker settings.', 'wphealthtracker-textdomain' ),
				'adminjstransstring173' => __( 'Can record and view their own data and stats, and has access to view (but not edit) other User\'s data. Can not change WPHealthTracker settings.', 'wphealthtracker-textdomain' ),
				'adminjstransstring174' => __( 'Can record and view their own data and stats, and has access to view and edit other User\'s data. Can not change WPHealthTracker settings.', 'wphealthtracker-textdomain' ),
				'adminjstransstring175' => __( 'Can record and view their own data and stats, and has access to view and edit other User\'s data. Can create new users, can set custom permissions for users, and has full access to WPHealthTracker settings. There can only be one SuperAdmin.', 'wphealthtracker-textdomain' ),
				'adminjstransstring176' => __( 'Let\'s start with the Basics - Name, Username, E-mail, Password. This section is the only section that contains required fields - everything else on this page is optional. The required fields are:', 'wphealthtracker-textdomain' ),
				'adminjstransstring177' => __( 'Here you\'ll enter everything you could ever need to contact this user. All of these fields are optional. None of this information will be used throughout WPHealthTracker unless explicitly stated, such as in the WPHealthTracker Payment & Billing Extensions.', 'wphealthtracker-textdomain' ),
				'adminjstransstring178' => __( 'Enter the name of the Country this user lives in (example: United States)', 'wphealthtracker-textdomain' ),
				'adminjstransstring179' => __( 'Enter the Street Address this user lives on (example: 123 Mystreet Lane)', 'wphealthtracker-textdomain' ),
				'adminjstransstring180' => __( 'Enter any additional address info here, such as an Apartment number or P.O. Box.', 'wphealthtracker-textdomain' ),
				'adminjstransstring181' => __( 'Enter the name of the City this user lives in (example: New York City)', 'wphealthtracker-textdomain' ),
				'adminjstransstring182' => __( 'Enter the name of the State/Region/Province this user lives in (example: Kansas or Ontario)', 'wphealthtracker-textdomain' ),
				'adminjstransstring183' => __( 'Enter the Zip/Postal code this user lives in.', 'wphealthtracker-textdomain' ),
				'adminjstransstring184' => __( 'Enter a Phone number this user can be reached at.', 'wphealthtracker-textdomain' ),
				'adminjstransstring185' => __( 'Here you\'ll enter some personalized profile info for this user. All of these fields are optional. Some of this information will be used throughout WPHealthTracker, such as in the Leaderboards. The user will have the ability to determine what information can and cannot be displayed on their own Profile page.', 'wphealthtracker-textdomain' ),
				'adminjstransstring186' => __( 'Here you can set this user\'s Profile Image. This image will be used on the user\'s Profile Page. Either use the \'Select Profile Image\' button to the right, or enter the URL of where the profile image can be found in the text box below.', 'wphealthtracker-textdomain' ),
				'adminjstransstring187' => __( 'Set the User\'s birthday here. This information will be hidden from others, as will their age, unless the user chooses to share this info on their Profile Page.', 'wphealthtracker-textdomain' ),
				'adminjstransstring188' => __( 'Set the User\'s gender here. This information will be hidden from others unless the user chooses to share this info on their Profile Page.', 'wphealthtracker-textdomain' ),
				'adminjstransstring189' => __( 'Set the User\'s Height here.', 'wphealthtracker-textdomain' ),
				'adminjstransstring190' => __( 'Set the User\'s main Health Goal/Focus here. This information will be used throughout WPHealthTracker in various places, such as on the user\'s Profile Page.', 'wphealthtracker-textdomain' ),
				'adminjstransstring191' => __( 'Here you can set the user\'s favorite motivational quote.', 'wphealthtracker-textdomain' ),
				'adminjstransstring192' => __( 'Here you can write a short paragraph about this user. This information will be displayed on the user\'s profile page, and the user will have full access to edit and/or hide this information if they choose.', 'wphealthtracker-textdomain' ),

			);
		}

		/**
		 *  Translation strings that are common to different tabs and used all throughout the plugin.
		 */
		public function common_trans_strings() {

			$this->common_trans_1 = __( 'Expand', 'wphealthtracker-textdomain' );

			$this->common_trans_2  = __( 'Data for', 'wphealthtracker-textdomain' );
			$this->common_trans_3  = __( 'Update Data for', 'wphealthtracker-textdomain' );
			$this->common_trans_4  = __( 'Whoops! Looks like you might have missed entering some data!', 'wphealthtracker-textdomain' );
			$this->common_trans_5  = __( 'Enter Data for', 'wphealthtracker-textdomain' );
			$this->common_trans_6  = __( 'Expand', 'wphealthtracker-textdomain' );
			$this->common_trans_7  = __( 'View & Edit Saved Data', 'wphealthtracker-textdomain' );
			$this->common_trans_8  = __( 'Past 7 Days', 'wphealthtracker-textdomain' );
			$this->common_trans_9  = __( 'Past 30 Days', 'wphealthtracker-textdomain' );
			$this->common_trans_10 = __( 'Past 60 Days', 'wphealthtracker-textdomain' );
			$this->common_trans_11 = __( 'Past 90 Days', 'wphealthtracker-textdomain' );
			$this->common_trans_12 = __( 'Filter Data', 'wphealthtracker-textdomain' );
			$this->common_trans_13 = __( 'Filter', 'wphealthtracker-textdomain' );
			$this->common_trans_14 = __( 'Uh-Oh! Looks like you haven\'t created any users yet!', 'wphealthtracker-textdomain' );
			$this->common_trans_15 = __( 'Click Here to Create a User', 'wphealthtracker-textdomain' );
			$this->common_trans_16 = __( 'Select a User', 'wphealthtracker-textdomain' );
			$this->common_trans_17 = __( 'Choose an Option Below', 'wphealthtracker-textdomain' );
			$this->common_trans_18 = __( 'Uh-Oh!', 'wphealthtracker-textdomain' );
			$this->common_trans_19 = __( 'Looks like there\'s no previously saved data for', 'wphealthtracker-textdomain' );
			$this->common_trans_20 = __( 'Try saving some data in the "Enter Data for', 'wphealthtracker-textdomain' );
			$this->common_trans_21 = __( 'section above', 'wphealthtracker-textdomain' );
			$this->common_trans_22 = __( 'Please note that data entered today will not appear in this section until tomorrow', 'wphealthtracker-textdomain' );
			$this->common_trans_23 = __( 'Measurement', 'wphealthtracker-textdomain' );
			$this->common_trans_24 = __( 'Total', 'wphealthtracker-textdomain' );
			$this->common_trans_25 = __( 'Time of Day', 'wphealthtracker-textdomain' );
			$this->common_trans_26 = __( 'Percent', 'wphealthtracker-textdomain' );
			$this->common_trans_27 = __( 'Images', 'wphealthtracker-textdomain' );
			$this->common_trans_28 = __( 'Image URL', 'wphealthtracker-textdomain' );
			$this->common_trans_29 = __( 'Upload Image', 'wphealthtracker-textdomain' );
			$this->common_trans_30 = __( 'Choose/Upload Image', 'wphealthtracker-textdomain' );
			$this->common_trans_31 = __( 'Files', 'wphealthtracker-textdomain' );
			$this->common_trans_32 = __( 'File URL', 'wphealthtracker-textdomain' );
			$this->common_trans_33 = __( 'Upload File', 'wphealthtracker-textdomain' );
			$this->common_trans_34 = __( 'Choose/Upload File', 'wphealthtracker-textdomain' );
			$this->common_trans_35 = __( 'Category', 'wphealthtracker-textdomain' );
			$this->common_trans_36 = __( 'Type', 'wphealthtracker-textdomain' );
			$this->common_trans_37 = __( 'Mixed', 'wphealthtracker-textdomain' );
			$this->common_trans_38 = __( 'Unknown', 'wphealthtracker-textdomain' );
			$this->common_trans_39 = __( 'Minimize', 'wphealthtracker-textdomain' );
			$this->common_trans_40 = __( 'Clone', 'wphealthtracker-textdomain' );
			$this->common_trans_41 = __( 'Delete', 'wphealthtracker-textdomain' );
			$this->common_trans_42 = __( 'Add Row', 'wphealthtracker-textdomain' );
			$this->common_trans_43 = __( 'Times', 'wphealthtracker-textdomain' );
			$this->common_trans_44 = __( 'Time', 'wphealthtracker-textdomain' );
			$this->common_trans_45 = __( 'N/A', 'wphealthtracker-textdomain' );
			$this->common_trans_46 = __( 'Day(s)', 'wphealthtracker-textdomain' );
			$this->common_trans_47 = __( 'Other', 'wphealthtracker-textdomain' );
			$this->common_trans_48 = __( 'Seconds', 'wphealthtracker-textdomain' );
			$this->common_trans_49 = __( 'Minutes', 'wphealthtracker-textdomain' );
			$this->common_trans_50 = __( 'Hours', 'wphealthtracker-textdomain' );
			$this->common_trans_51 = __( 'Feet', 'wphealthtracker-textdomain' );
			$this->common_trans_52 = __( 'Yards', 'wphealthtracker-textdomain' );
			$this->common_trans_53 = __( 'Miles', 'wphealthtracker-textdomain' );
			$this->common_trans_54 = __( 'Meters', 'wphealthtracker-textdomain' );
			$this->common_trans_55 = __( 'Kilometers', 'wphealthtracker-textdomain' );
			$this->common_trans_56 = __( 'KMs', 'wphealthtracker-textdomain' );
			$this->common_trans_57 = __( 'Categories', 'wphealthtracker-textdomain' );
			$this->common_trans_58 = __( 'Mondays', 'wphealthtracker-textdomain' );
			$this->common_trans_59 = __( 'Tuesdays', 'wphealthtracker-textdomain' );
			$this->common_trans_60 = __( 'Wednesdays', 'wphealthtracker-textdomain' );
			$this->common_trans_61 = __( 'Thursdays', 'wphealthtracker-textdomain' );
			$this->common_trans_62 = __( 'Fridays', 'wphealthtracker-textdomain' );
			$this->common_trans_63 = __( 'Saturdays', 'wphealthtracker-textdomain' );
			$this->common_trans_64 = __( 'Sundays', 'wphealthtracker-textdomain' );
			$this->common_trans_65 = __( 'AM', 'wphealthtracker-textdomain' );
			$this->common_trans_66 = __( 'PM', 'wphealthtracker-textdomain' );
			$this->common_trans_67 = __( 'Mon.', 'wphealthtracker-textdomain' );
			$this->common_trans_68 = __( 'Tues.', 'wphealthtracker-textdomain' );
			$this->common_trans_69 = __( 'Wed.', 'wphealthtracker-textdomain' );
			$this->common_trans_70 = __( 'Thurs.', 'wphealthtracker-textdomain' );
			$this->common_trans_71 = __( 'Fri.', 'wphealthtracker-textdomain' );
			$this->common_trans_72 = __( 'Sat.', 'wphealthtracker-textdomain' );
			$this->common_trans_73 = __( 'Sun.', 'wphealthtracker-textdomain' );
			$this->common_trans_74 = __( 'Create a New User Below', 'wphealthtracker-textdomain' );
			$this->common_trans_75 = __( 'Looks like you don\'t have access to this part of WPHealthTracker!', 'wphealthtracker-textdomain' );
			$this->common_trans_76 = __( 'Contact', 'wphealthtracker-textdomain' );
			$this->common_trans_77 = __( 'to request access.', 'wphealthtracker-textdomain' );
			$this->common_trans_78 = __( 'at', 'wphealthtracker-textdomain' );

			return $translation_array1 = array(
				'commontrans1'  => $this->common_trans_1,
				'commontrans2'  => $this->common_trans_2,
				'commontrans3'  => $this->common_trans_3,
				'commontrans4'  => $this->common_trans_4,
				'commontrans5'  => $this->common_trans_5,
				'commontrans6'  => $this->common_trans_6,
				'commontrans7'  => $this->common_trans_7,
				'commontrans8'  => $this->common_trans_8,
				'commontrans9'  => $this->common_trans_9,
				'commontrans10' => $this->common_trans_10,
				'commontrans11' => $this->common_trans_11,
				'commontrans12' => $this->common_trans_12,
				'commontrans13' => $this->common_trans_13,
				'commontrans14' => $this->common_trans_14,
				'commontrans15' => $this->common_trans_15,
				'commontrans16' => $this->common_trans_16,
				'commontrans17' => $this->common_trans_17,
				'commontrans18' => $this->common_trans_18,
				'commontrans19' => $this->common_trans_19,
				'commontrans20' => $this->common_trans_20,
				'commontrans21' => $this->common_trans_21,
				'commontrans22' => $this->common_trans_22,
				'commontrans23' => $this->common_trans_23,
				'commontrans24' => $this->common_trans_24,
				'commontrans25' => $this->common_trans_25,
				'commontrans26' => $this->common_trans_26,
				'commontrans27' => $this->common_trans_27,
				'commontrans28' => $this->common_trans_28,
				'commontrans29' => $this->common_trans_29,
				'commontrans30' => $this->common_trans_30,
				'commontrans31' => $this->common_trans_31,
				'commontrans32' => $this->common_trans_32,
				'commontrans33' => $this->common_trans_33,
				'commontrans34' => $this->common_trans_34,
				'commontrans35' => $this->common_trans_35,
				'commontrans36' => $this->common_trans_36,
				'commontrans37' => $this->common_trans_37,
				'commontrans38' => $this->common_trans_38,
				'commontrans39' => $this->common_trans_39,
				'commontrans40' => $this->common_trans_40,
				'commontrans41' => $this->common_trans_41,
				'commontrans42' => $this->common_trans_42,
				'commontrans43' => $this->common_trans_43,
				'commontrans44' => $this->common_trans_44,
				'commontrans45' => $this->common_trans_45,
				'commontrans46' => $this->common_trans_46,
				'commontrans47' => $this->common_trans_47,
				'commontrans48' => $this->common_trans_48,
				'commontrans49' => $this->common_trans_49,
				'commontrans50' => $this->common_trans_50,
				'commontrans51' => $this->common_trans_51,
				'commontrans52' => $this->common_trans_52,
				'commontrans53' => $this->common_trans_53,
				'commontrans54' => $this->common_trans_54,
				'commontrans55' => $this->common_trans_55,
				'commontrans56' => $this->common_trans_56,
				'commontrans57' => $this->common_trans_57,
				'commontrans58' => $this->common_trans_58,
				'commontrans59' => $this->common_trans_59,
				'commontrans60' => $this->common_trans_60,
				'commontrans61' => $this->common_trans_61,
				'commontrans62' => $this->common_trans_62,
				'commontrans63' => $this->common_trans_63,
				'commontrans64' => $this->common_trans_64,
				'commontrans65' => $this->common_trans_65,
				'commontrans66' => $this->common_trans_66,
				'commontrans67' => $this->common_trans_67,
				'commontrans68' => $this->common_trans_68,
				'commontrans69' => $this->common_trans_69,
				'commontrans70' => $this->common_trans_70,
				'commontrans71' => $this->common_trans_71,
				'commontrans72' => $this->common_trans_72,
				'commontrans73' => $this->common_trans_73,
			);
		}

		/**
		 *  Translation strings that are used in tab titles
		 */
		public function tab_titles_trans_strings() {

			$this->tab_title_1  = __( 'Welcome!', 'wphealthtracker-textdomain' );
			$this->tab_title_2  = __( 'Vitals', 'wphealthtracker-textdomain' );
			$this->tab_title_3  = __( 'Vital Stats', 'wphealthtracker-textdomain' );
			$this->tab_title_4  = __( 'Diet', 'wphealthtracker-textdomain' );
			$this->tab_title_5  = __( 'Diet Stats', 'wphealthtracker-textdomain' );
			$this->tab_title_6  = __( 'Exercise', 'wphealthtracker-textdomain' );
			$this->tab_title_7  = __( 'Create Users', 'wphealthtracker-textdomain' );
			$this->tab_title_8  = __( 'Medications', 'wphealthtracker-textdomain' );
			$this->tab_title_9  = __( 'Lifestyle', 'wphealthtracker-textdomain' );
			$this->tab_title_10 = __( 'Goal Tracker', 'wphealthtracker-textdomain' );
			$this->tab_title_11 = __( 'Misc. Notes', 'wphealthtracker-textdomain' );
			$this->tab_title_12 = __( 'Exercise Stats', 'wphealthtracker-textdomain' );
			$this->tab_title_13 = __( 'Med Stats', 'wphealthtracker-textdomain' );
			$this->tab_title_14 = __( 'L & A Stats', 'wphealthtracker-textdomain' );
			$this->tab_title_15 = __( 'Goal Stats', 'wphealthtracker-textdomain' );
			$this->tab_title_16 = __( 'Edit & Delete Users', 'wphealthtracker-textdomain' );

			return $translation_array1 = array(
				'tabtitle1' => $this->tab_title_1,
				'tabtitle2' => $this->tab_title_2,
				'tabtitle3' => $this->tab_title_3,
				'tabtitle4' => $this->tab_title_4,
				'tabtitle5' => $this->tab_title_5,
				'tabtitle6' => $this->tab_title_6,
				'tabtitle7' => $this->tab_title_7,
			);

		}

		/**
		 *  Translation strings that are used on the Users menu page
		 */
		public function users_tab_trans_strings() {

			$this->user_trans_1  = __( 'The Basics', 'wphealthtracker-textdomain' );
			$this->user_trans_2  = __( 'First Name', 'wphealthtracker-textdomain' );
			$this->user_trans_3  = __( 'Last Name', 'wphealthtracker-textdomain' );
			$this->user_trans_4  = __( 'E-Mail', 'wphealthtracker-textdomain' );
			$this->user_trans_5  = __( 'Confirm E-Mail', 'wphealthtracker-textdomain' );
			$this->user_trans_6  = __( 'Password', 'wphealthtracker-textdomain' );
			$this->user_trans_7  = __( 'Confirm Password', 'wphealthtracker-textdomain' );
			$this->user_trans_8  = __( 'Username', 'wphealthtracker-textdomain' );
			$this->user_trans_9  = __( 'User Role', 'wphealthtracker-textdomain' );
			$this->user_trans_10 = __( 'Contact Info', 'wphealthtracker-textdomain' );
			$this->user_trans_11 = __( 'Country', 'wphealthtracker-textdomain' );
			$this->user_trans_12 = __( 'Street Address 1', 'wphealthtracker-textdomain' );
			$this->user_trans_13 = __( 'Street Address 2', 'wphealthtracker-textdomain' );
			$this->user_trans_14 = __( 'City', 'wphealthtracker-textdomain' );
			$this->user_trans_15 = __( 'State/Region/Province', 'wphealthtracker-textdomain' );
			$this->user_trans_16 = __( 'Zip/Postal Code', 'wphealthtracker-textdomain' );
			$this->user_trans_17 = __( 'Phone', 'wphealthtracker-textdomain' );
			$this->user_trans_19 = __( 'Bio', 'wphealthtracker-textdomain' );
			$this->user_trans_21 = __( 'Birthdate', 'wphealthtracker-textdomain' );
			$this->user_trans_23 = __( 'Gender', 'wphealthtracker-textdomain' );
			$this->user_trans_24 = __( 'Main Exercise Focus', 'wphealthtracker-textdomain' );
			$this->user_trans_25 = __( 'Secondary Exercise Focus', 'wphealthtracker-textdomain' );
			$this->user_trans_27 = __( 'Favorite Motivational Song', 'wphealthtracker-textdomain' );
			$this->user_trans_28 = __( 'Favorite Single Exercise', 'wphealthtracker-textdomain' );
			$this->user_trans_29 = __( 'Playlist', 'wphealthtracker-textdomain' );
			$this->user_trans_30 = __( 'Enter First Name', 'wphealthtracker-textdomain' );
			$this->user_trans_31 = __( 'Enter Last Name', 'wphealthtracker-textdomain' );
			$this->user_trans_32 = __( 'Enter an E-Mail Address', 'wphealthtracker-textdomain' );
			$this->user_trans_33 = __( 'Enter E-Mail Address Again', 'wphealthtracker-textdomain' );
			$this->user_trans_34 = __( 'Create a Password', 'wphealthtracker-textdomain' );
			$this->user_trans_35 = __( 'Enter Password Again', 'wphealthtracker-textdomain' );
			$this->user_trans_36 = __( 'Create a Username', 'wphealthtracker-textdomain' );
			$this->user_trans_37 = __( 'E-Mails', 'wphealthtracker-textdomain' );
			$this->user_trans_38 = __( 'Match!', 'wphealthtracker-textdomain' );
			$this->user_trans_39 = __( 'Passwords', 'wphealthtracker-textdomain' );
			$this->user_trans_40 = __( 'Don\'t Match!', 'wphealthtracker-textdomain' );
			$this->user_trans_41 = __( 'User', 'wphealthtracker-textdomain' );
			$this->user_trans_42 = __( 'Reviewer', 'wphealthtracker-textdomain' );
			$this->user_trans_43 = __( 'Admin', 'wphealthtracker-textdomain' );
			$this->user_trans_44 = __( 'Select a Role...', 'wphealthtracker-textdomain' );
			$this->user_trans_45 = __( 'SuperAdmin', 'wphealthtracker-textdomain' );
			$this->user_trans_46 = __( 'Whoa!', 'wphealthtracker-textdomain' );
			$this->user_trans_47 = __( 'There can only be one SuperAdmin, and right now, that\'s you! If you create this user as a SuperAdmin, your role will be changed to Admin, and this new user will become the one-and-only SuperAdmin for WPHealthTracker. This means you\'ll lose some of the abilities you currently have to modify plugin-wide settings and set specific permissions for individual users.', 'wphealthtracker-textdomain' );
			$this->user_trans_48 = __( 'Contact Information', 'wphealthtracker-textdomain' );
			$this->user_trans_49 = __( 'Enter a Country', 'wphealthtracker-textdomain' );
			$this->user_trans_50 = __( 'Enter Street Address', 'wphealthtracker-textdomain' );
			$this->user_trans_51 = __( 'Apt. #, P.O. Box, etc.', 'wphealthtracker-textdomain' );
			$this->user_trans_52 = __( 'Enter a City', 'wphealthtracker-textdomain' );
			$this->user_trans_53 = __( 'Enter State/Region/Province', 'wphealthtracker-textdomain' );
			$this->user_trans_54 = __( 'Enter Zip/Postal Code', 'wphealthtracker-textdomain' );
			$this->user_trans_55 = __( 'Enter Phone Number', 'wphealthtracker-textdomain' );
			$this->user_trans_56 = __( 'Profile Info', 'wphealthtracker-textdomain' );
			$this->user_trans_57 = __( 'Profile Image', 'wphealthtracker-textdomain' );
			$this->user_trans_58 = __( 'Enter Image URL', 'wphealthtracker-textdomain' );
			$this->user_trans_59 = __( 'Birthday', 'wphealthtracker-textdomain' );
			$this->user_trans_60 = __( 'Gender', 'wphealthtracker-textdomain' );
			$this->user_trans_61 = __( 'Male', 'wphealthtracker-textdomain' );
			$this->user_trans_62 = __( 'Female', 'wphealthtracker-textdomain' );
			$this->user_trans_63 = __( 'Select a Gender...', 'wphealthtracker-textdomain' );
			$this->user_trans_64 = __( 'Height', 'wphealthtracker-textdomain' );
			$this->user_trans_65 = __( 'Main Focus', 'wphealthtracker-textdomain' );
			$this->user_trans_66 = __( 'Feet', 'wphealthtracker-textdomain' );
			$this->user_trans_67 = __( 'Inches', 'wphealthtracker-textdomain' );
			$this->user_trans_68 = __( 'Select a Main Focus...', 'wphealthtracker-textdomain' );
			$this->user_trans_69 = __( 'Weight Loss', 'wphealthtracker-textdomain' );
			$this->user_trans_70 = __( 'Vitals Tracking', 'wphealthtracker-textdomain' );
			$this->user_trans_71 = __( 'Diet Tracking', 'wphealthtracker-textdomain' );
			$this->user_trans_72 = __( 'Exercise Tracking', 'wphealthtracker-textdomain' );
			$this->user_trans_73 = __( 'Select a Secondary Focus...', 'wphealthtracker-textdomain' );
			$this->user_trans_74 = __( 'Secondary Focus', 'wphealthtracker-textdomain' );
			$this->user_trans_75 = __( 'Favorite Motivational Quote', 'wphealthtracker-textdomain' );
			$this->user_trans_76 = __( 'Enter a Motivational Quote', 'wphealthtracker-textdomain' );
			$this->user_trans_77 = __( 'About This User', 'wphealthtracker-textdomain' );
			$this->user_trans_78 = __( 'Enter a Short Bio For This User', 'wphealthtracker-textdomain' );
			$this->user_trans_79 = __( '(Show Password)', 'wphealthtracker-textdomain' );
			$this->user_trans_80 = __( '(Hide Password)', 'wphealthtracker-textdomain' );
			$this->user_trans_81 = __( 'Create New User', 'wphealthtracker-textdomain' );
			$this->user_trans_82 = __( 'The Only Required Fields are', 'wphealthtracker-textdomain' );
			$this->user_trans_83 = __( 'Feel free to leave everything else blank!', 'wphealthtracker-textdomain' );
			$this->user_trans_84 = __( 'Whoops! Looks like your E-Mail Addresses don\'t match!', 'wphealthtracker-textdomain' );
			$this->user_trans_85 = __( 'Whoops! Looks like your Passwords don\'t match!', 'wphealthtracker-textdomain' );
			$this->user_trans_86 = __( 'Looks like there\'s already a registered User with the Username of', 'wphealthtracker-textdomain' );
			$this->user_trans_87 = __( 'Try creating this User again with a different Username', 'wphealthtracker-textdomain' );
			$this->user_trans_88 = __( 'Looks like there\'s already a registered User with the E-Mail Address of', 'wphealthtracker-textdomain' );
			$this->user_trans_89 = __( 'Try creating this User again with a different E-Mail Address', 'wphealthtracker-textdomain' );
			$this->user_trans_90 = __( 'You\'ve just created a new WPHealthTracker User', 'wphealthtracker-textdomain' );
			$this->user_trans_91 = __( 'WPHealthTracker Basic User', 'wphealthtracker-textdomain' );

			return $translation_array1 = array(
				'usertrans1'  => $this->user_trans_1,
				'usertrans2'  => $this->user_trans_2,
				'usertrans3'  => $this->user_trans_3,
				'usertrans4'  => $this->user_trans_4,
				'usertrans5'  => $this->user_trans_5,
				'usertrans6'  => $this->user_trans_6,
				'usertrans7'  => $this->user_trans_7,
				'usertrans8'  => $this->user_trans_8,
				'usertrans9'  => $this->user_trans_9,
				'usertrans10' => $this->user_trans_10,
				'usertrans11' => $this->user_trans_11,
				'usertrans12' => $this->user_trans_12,
				'usertrans13' => $this->user_trans_13,
				'usertrans14' => $this->user_trans_14,
				'usertrans15' => $this->user_trans_15,
				'usertrans16' => $this->user_trans_16,
				'usertrans17' => $this->user_trans_17,
				'usertrans19' => $this->user_trans_19,
				'usertrans21' => $this->user_trans_21,
				'usertrans23' => $this->user_trans_23,
				'usertrans24' => $this->user_trans_24,
				'usertrans25' => $this->user_trans_25,
				'usertrans27' => $this->user_trans_27,
				'usertrans28' => $this->user_trans_28,
				'usertrans29' => $this->user_trans_29,
				'usertrans30' => $this->user_trans_30,
				'usertrans31' => $this->user_trans_31,
				'usertrans32' => $this->user_trans_32,
				'usertrans33' => $this->user_trans_33,
				'usertrans34' => $this->user_trans_34,
				'usertrans35' => $this->user_trans_35,
				'usertrans36' => $this->user_trans_36,
				'usertrans37' => $this->user_trans_37,
				'usertrans38' => $this->user_trans_38,
				'usertrans39' => $this->user_trans_39,
				'usertrans40' => $this->user_trans_40,
				'usertrans41' => $this->user_trans_41,
				'usertrans42' => $this->user_trans_42,
				'usertrans43' => $this->user_trans_43,
				'usertrans44' => $this->user_trans_44,
				'usertrans45' => $this->user_trans_45,
				'usertrans46' => $this->user_trans_46,
				'usertrans47' => $this->user_trans_47,
				'usertrans48' => $this->user_trans_48,
				'usertrans49' => $this->user_trans_49,
				'usertrans50' => $this->user_trans_50,
				'usertrans51' => $this->user_trans_51,
				'usertrans52' => $this->user_trans_52,
				'usertrans53' => $this->user_trans_53,
				'usertrans54' => $this->user_trans_54,
				'usertrans55' => $this->user_trans_55,
				'usertrans56' => $this->user_trans_56,
				'usertrans57' => $this->user_trans_57,
				'usertrans58' => $this->user_trans_58,
				'usertrans59' => $this->user_trans_59,
				'usertrans60' => $this->user_trans_60,
				'usertrans61' => $this->user_trans_61,
				'usertrans62' => $this->user_trans_62,
				'usertrans63' => $this->user_trans_63,
				'usertrans64' => $this->user_trans_64,
				'usertrans65' => $this->user_trans_65,
				'usertrans66' => $this->user_trans_66,
				'usertrans67' => $this->user_trans_67,
				'usertrans68' => $this->user_trans_68,
				'usertrans69' => $this->user_trans_69,
				'usertrans70' => $this->user_trans_70,
				'usertrans71' => $this->user_trans_71,
				'usertrans72' => $this->user_trans_72,
				'usertrans73' => $this->user_trans_73,
				'usertrans74' => $this->user_trans_74,
				'usertrans75' => $this->user_trans_75,
				'usertrans76' => $this->user_trans_76,
				'usertrans77' => $this->user_trans_77,
				'usertrans78' => $this->user_trans_78,
				'usertrans79' => $this->user_trans_79,
				'usertrans80' => $this->user_trans_80,
				'usertrans81' => $this->user_trans_81,
				'usertrans82' => $this->user_trans_82,
				'usertrans83' => $this->user_trans_83,
				'usertrans84' => $this->user_trans_84,
				'usertrans85' => $this->user_trans_85,
				'usertrans86' => $this->user_trans_86,
				'usertrans87' => $this->user_trans_87,
				'usertrans88' => $this->user_trans_88,
				'usertrans89' => $this->user_trans_89,
				'usertrans90' => $this->user_trans_90,

			);

		}

		/**
		 *  Translation strings that are used on the Vitals tab
		 */
		public function vitals_tab_trans_strings() {

			$this->vitals_trans_1  = __( 'Weight', 'wphealthtracker-textdomain' );
			$this->vitals_trans_2  = __( 'Pounds', 'wphealthtracker-textdomain' );
			$this->vitals_trans_3  = __( 'Kilograms', 'wphealthtracker-textdomain' );
			$this->vitals_trans_4  = __( 'Cholesterol', 'wphealthtracker-textdomain' );
			$this->vitals_trans_5  = __( 'LDL', 'wphealthtracker-textdomain' );
			$this->vitals_trans_6  = __( 'HDL', 'wphealthtracker-textdomain' );
			$this->vitals_trans_7  = __( 'Triglycerides', 'wphealthtracker-textdomain' );
			$this->vitals_trans_8  = __( 'Blood Pressure', 'wphealthtracker-textdomain' );
			$this->vitals_trans_9  = __( 'Systolic', 'wphealthtracker-textdomain' );
			$this->vitals_trans_10 = __( 'Diastolic', 'wphealthtracker-textdomain' );
			$this->vitals_trans_11 = __( 'Blood Sugar', 'wphealthtracker-textdomain' );
			$this->vitals_trans_12 = __( 'Level', 'wphealthtracker-textdomain' );
			$this->vitals_trans_13 = __( 'mg/dL', 'wphealthtracker-textdomain' );
			$this->vitals_trans_14 = __( 'mmol/L', 'wphealthtracker-textdomain' );
			$this->vitals_trans_15 = __( 'Blood Oxygen Level', 'wphealthtracker-textdomain' );
			$this->vitals_trans_16 = __( 'Oxygen Level', 'wphealthtracker-textdomain' );
			$this->vitals_trans_17 = __( 'mm HG', 'wphealthtracker-textdomain' );
			$this->vitals_trans_18 = __( 'Body Temperature', 'wphealthtracker-textdomain' );
			$this->vitals_trans_19 = __( 'Temperature', 'wphealthtracker-textdomain' );
			$this->vitals_trans_20 = __( 'Fahrenheit', 'wphealthtracker-textdomain' );
			$this->vitals_trans_21 = __( 'Celcius', 'wphealthtracker-textdomain' );
			$this->vitals_trans_22 = __( 'Heart Rate', 'wphealthtracker-textdomain' );
			$this->vitals_trans_23 = __( 'Beats Per Minute', 'wphealthtracker-textdomain' );
			$this->vitals_trans_24 = __( 'Save Vitals', 'wphealthtracker-textdomain' );

			return $translation_array = array(
				'vitalstrans1'  => $this->vitals_trans_1,
				'vitalstrans2'  => $this->vitals_trans_2,
				'vitalstrans3'  => $this->vitals_trans_3,
				'vitalstrans4'  => $this->vitals_trans_4,
				'vitalstrans5'  => $this->vitals_trans_5,
				'vitalstrans6'  => $this->vitals_trans_6,
				'vitalstrans7'  => $this->vitals_trans_7,
				'vitalstrans8'  => $this->vitals_trans_8,
				'vitalstrans9'  => $this->vitals_trans_9,
				'vitalstrans10' => $this->vitals_trans_10,
				'vitalstrans11' => $this->vitals_trans_11,
				'vitalstrans12' => $this->vitals_trans_12,
				'vitalstrans13' => $this->vitals_trans_13,
				'vitalstrans14' => $this->vitals_trans_14,
				'vitalstrans15' => $this->vitals_trans_15,
				'vitalstrans16' => $this->vitals_trans_16,
				'vitalstrans17' => $this->vitals_trans_17,
				'vitalstrans18' => $this->vitals_trans_18,
				'vitalstrans19' => $this->vitals_trans_19,
				'vitalstrans20' => $this->vitals_trans_20,
				'vitalstrans21' => $this->vitals_trans_21,
				'vitalstrans22' => $this->vitals_trans_22,
				'vitalstrans23' => $this->vitals_trans_23,
				'vitalstrans24' => $this->vitals_trans_24,
			);
		}

		/**
		 *  Translation strings that are used on the Diet tab
		 */
		public function diet_tab_trans_strings() {

			$this->diet_trans_1  = __( 'Diet', 'wphealthtracker-textdomain' );
			$this->diet_trans_2  = __( 'Food Item', 'wphealthtracker-textdomain' );
			$this->diet_trans_3  = __( 'Time Consumed', 'wphealthtracker-textdomain' );
			$this->diet_trans_4  = __( 'Total Fat', 'wphealthtracker-textdomain' );
			$this->diet_trans_5  = __( 'Saturated Fat', 'wphealthtracker-textdomain' );
			$this->diet_trans_6  = __( 'Monounsaturated Fat', 'wphealthtracker-textdomain' );
			$this->diet_trans_7  = __( 'Polyunsaturated Fat', 'wphealthtracker-textdomain' );
			$this->diet_trans_8  = __( 'Calories/Kilocalories', 'wphealthtracker-textdomain' );
			$this->diet_trans_9  = __( 'Calories', 'wphealthtracker-textdomain' );
			$this->diet_trans_10 = __( 'kcal', 'wphealthtracker-textdomain' );
			$this->diet_trans_11 = __( 'kJ', 'wphealthtracker-textdomain' );
			$this->diet_trans_12 = __( 'Protein', 'wphealthtracker-textdomain' );
			$this->diet_trans_13 = __( 'Whey', 'wphealthtracker-textdomain' );
			$this->diet_trans_14 = __( 'Casein', 'wphealthtracker-textdomain' );
			$this->diet_trans_15 = __( 'Soy', 'wphealthtracker-textdomain' );
			$this->diet_trans_16 = __( 'Animal/Meat', 'wphealthtracker-textdomain' );
			$this->diet_trans_17 = __( 'Milk/Dairy', 'wphealthtracker-textdomain' );
			$this->diet_trans_18 = __( 'Egg', 'wphealthtracker-textdomain' );
			$this->diet_trans_19 = __( 'Vegitarian/Plant-Based', 'wphealthtracker-textdomain' );
			$this->diet_trans_20 = __( 'Total Carbohydrates', 'wphealthtracker-textdomain' );
			$this->diet_trans_21 = __( 'Dietary Fiber', 'wphealthtracker-textdomain' );
			$this->diet_trans_22 = __( 'Total Sugars', 'wphealthtracker-textdomain' );
			$this->diet_trans_23 = __( 'Save this food item for future use?', 'wphealthtracker-textdomain' );
			$this->diet_trans_24 = __( 'Save Food Items for Today', 'wphealthtracker-textdomain' );
			$this->diet_trans_25 = __( 'Enter Food Items for', 'wphealthtracker-textdomain' );
			$this->diet_trans_26 = __( 'View & Edit Saved Food Items', 'wphealthtracker-textdomain' );
			$this->diet_trans_27 = __( 'Try saving some data in the "Enter Food Items for', 'wphealthtracker-textdomain' );
			$this->diet_trans_28 = __( 'Update Food Items for', 'wphealthtracker-textdomain' );
			$this->diet_trans_29 = __( 'Food Items for', 'wphealthtracker-textdomain' );
			$this->diet_trans_30 = __( 'Select a Category...', 'wphealthtracker-textdomain' );
			$this->diet_trans_31 = __( 'Add Food Item', 'wphealthtracker-textdomain' );
			$this->diet_trans_32 = __( 'Consumed', 'wphealthtracker-textdomain' );
			$this->diet_trans_33 = __( 'Kilocalories', 'wphealthtracker-textdomain' );
			$this->diet_trans_34 = __( 'Kilojoules', 'wphealthtracker-textdomain' );
			$this->diet_trans_35 = __( 'Carbohydrates', 'wphealthtracker-textdomain' );
			$this->diet_trans_36 = __( 'Fats', 'wphealthtracker-textdomain' );
			$this->diet_trans_37 = __( 'Monounsat. Fat', 'wphealthtracker-textdomain' );
			$this->diet_trans_38 = __( 'Polyunsat. Fat', 'wphealthtracker-textdomain' );
			$this->diet_trans_39 = __( 'Sugars', 'wphealthtracker-textdomain' );
			$this->diet_trans_40 = __( 'Fiber', 'wphealthtracker-textdomain' );
			$this->diet_trans_41 = __( 'Kcals', 'wphealthtracker-textdomain' );
			$this->diet_trans_42 = __( 'kJs', 'wphealthtracker-textdomain' );
			$this->diet_trans_43 = __( 'Highest Food', 'wphealthtracker-textdomain' );
			$this->diet_trans_44 = __( 'Most Consequtive Energy Decrease', 'wphealthtracker-textdomain' );
			$this->diet_trans_45 = __( 'Most Consequtive Energy Increase', 'wphealthtracker-textdomain' );

			return $translation_array3 = array(
				'diettrans1'  => $this->diet_trans_1,
				'diettrans2'  => $this->diet_trans_2,
				'diettrans3'  => $this->diet_trans_3,
				'diettrans4'  => $this->diet_trans_4,
				'diettrans5'  => $this->diet_trans_5,
				'diettrans6'  => $this->diet_trans_6,
				'diettrans7'  => $this->diet_trans_7,
				'diettrans8'  => $this->diet_trans_8,
				'diettrans9'  => $this->diet_trans_9,
				'diettrans10' => $this->diet_trans_10,
				'diettrans11' => $this->diet_trans_11,
				'diettrans12' => $this->diet_trans_12,
				'diettrans13' => $this->diet_trans_13,
				'diettrans14' => $this->diet_trans_14,
				'diettrans15' => $this->diet_trans_15,
				'diettrans16' => $this->diet_trans_16,
				'diettrans17' => $this->diet_trans_17,
				'diettrans18' => $this->diet_trans_18,
				'diettrans19' => $this->diet_trans_19,
				'diettrans20' => $this->diet_trans_20,
				'diettrans21' => $this->diet_trans_21,
				'diettrans22' => $this->diet_trans_22,
				'diettrans23' => $this->diet_trans_23,
				'diettrans24' => $this->diet_trans_24,
				'diettrans25' => $this->diet_trans_25,
				'diettrans26' => $this->diet_trans_26,
				'diettrans27' => $this->diet_trans_27,
				'diettrans28' => $this->diet_trans_28,
				'diettrans29' => $this->diet_trans_29,
				'diettrans30' => $this->diet_trans_30,
				'diettrans31' => $this->diet_trans_31,
				'diettrans32' => $this->diet_trans_32,
				'diettrans33' => $this->diet_trans_33,
				'diettrans34' => $this->diet_trans_34,
				'diettrans35' => $this->diet_trans_35,
				'diettrans36' => $this->diet_trans_36,
				'diettrans37' => $this->diet_trans_37,
				'diettrans38' => $this->diet_trans_38,
				'diettrans39' => $this->diet_trans_39,
				'diettrans40' => $this->diet_trans_40,
				'diettrans41' => $this->diet_trans_41,
				'diettrans42' => $this->diet_trans_42,
				'diettrans43' => $this->diet_trans_43,
				'diettrans44' => $this->diet_trans_44,
				'diettrans45' => $this->diet_trans_45,
			);
		}

		/**
		 *  Translation strings that are used on the Exercise tab
		 */
		public function exercise_tab_trans_strings() {

			$this->exercise_trans_1  = __( 'Enter Exercises for', 'wphealthtracker-textdomain' );
			$this->exercise_trans_2  = __( 'View & Edit Saved Exercises', 'wphealthtracker-textdomain' );
			$this->exercise_trans_3  = __( 'Try saving some data in the "Enter Exercises for', 'wphealthtracker-textdomain' );
			$this->exercise_trans_4  = __( 'Add Exercise', 'wphealthtracker-textdomain' );
			$this->exercise_trans_5  = __( 'Update Exercises for', 'wphealthtracker-textdomain' );
			$this->exercise_trans_6  = __( 'Save Exercises for Today', 'wphealthtracker-textdomain' );
			$this->exercise_trans_7  = __( 'Exercise Name', 'wphealthtracker-textdomain' );
			$this->exercise_trans_8  = __( 'Exercise Type', 'wphealthtracker-textdomain' );
			$this->exercise_trans_9  = __( 'Endurance/Cardio', 'wphealthtracker-textdomain' );
			$this->exercise_trans_10 = __( 'Strength/Weightlifting', 'wphealthtracker-textdomain' );
			$this->exercise_trans_11 = __( 'Balance', 'wphealthtracker-textdomain' );
			$this->exercise_trans_12 = __( 'Flexibility', 'wphealthtracker-textdomain' );
			$this->exercise_trans_13 = __( 'Time of Exercise', 'wphealthtracker-textdomain' );
			$this->exercise_trans_14 = __( 'Duration of Exercise', 'wphealthtracker-textdomain' );
			$this->exercise_trans_15 = __( 'Distance Travelled', 'wphealthtracker-textdomain' );
			$this->exercise_trans_16 = __( 'Reps', 'wphealthtracker-textdomain' );
			$this->exercise_trans_17 = __( 'Set', 'wphealthtracker-textdomain' );
			$this->exercise_trans_18 = __( 'Add a Set', 'wphealthtracker-textdomain' );
			$this->exercise_trans_19 = __( 'Muscle Group(s) Trained', 'wphealthtracker-textdomain' );
			$this->exercise_trans_20 = __( 'Abs', 'wphealthtracker-textdomain' );
			$this->exercise_trans_21 = __( 'Biceps', 'wphealthtracker-textdomain' );
			$this->exercise_trans_22 = __( 'Calves', 'wphealthtracker-textdomain' );
			$this->exercise_trans_23 = __( 'Chest', 'wphealthtracker-textdomain' );
			$this->exercise_trans_24 = __( 'Forearms', 'wphealthtracker-textdomain' );
			$this->exercise_trans_25 = __( 'Glutes', 'wphealthtracker-textdomain' );
			$this->exercise_trans_26 = __( 'Hamstrings', 'wphealthtracker-textdomain' );
			$this->exercise_trans_27 = __( 'Lats', 'wphealthtracker-textdomain' );
			$this->exercise_trans_28 = __( 'Lower Back', 'wphealthtracker-textdomain' );
			$this->exercise_trans_29 = __( 'Middle Back', 'wphealthtracker-textdomain' );
			$this->exercise_trans_30 = __( 'Neck', 'wphealthtracker-textdomain' );
			$this->exercise_trans_31 = __( 'Quads', 'wphealthtracker-textdomain' );
			$this->exercise_trans_32 = __( 'Shoulders', 'wphealthtracker-textdomain' );
			$this->exercise_trans_33 = __( 'Traps', 'wphealthtracker-textdomain' );
			$this->exercise_trans_34 = __( 'Triceps', 'wphealthtracker-textdomain' );
			$this->exercise_trans_35 = __( 'Deltoids', 'wphealthtracker-textdomain' );
			$this->exercise_trans_36 = __( 'Obliques', 'wphealthtracker-textdomain' );
			$this->exercise_trans_37 = __( 'Adductors', 'wphealthtracker-textdomain' );
			$this->exercise_trans_38 = __( 'Bodyweight', 'wphealthtracker-textdomain' );
			$this->exercise_trans_39 = __( 'Exercises for', 'wphealthtracker-textdomain' );
			$this->exercise_trans_40 = __( 'Arms', 'wphealthtracker-textdomain' );
			$this->exercise_trans_41 = __( 'Biceps', 'wphealthtracker-textdomain' );
			$this->exercise_trans_43 = __( 'Forearms', 'wphealthtracker-textdomain' );
			$this->exercise_trans_44 = __( 'Back', 'wphealthtracker-textdomain' );
			$this->exercise_trans_45 = __( 'Trapezius', 'wphealthtracker-textdomain' );
			$this->exercise_trans_46 = __( 'Core', 'wphealthtracker-textdomain' );
			$this->exercise_trans_47 = __( 'Pectorals', 'wphealthtracker-textdomain' );
			$this->exercise_trans_48 = __( 'Times Exercised', 'wphealthtracker-textdomain' );
			$this->exercise_trans_49 = __( 'First Exercised On', 'wphealthtracker-textdomain' );
			$this->exercise_trans_50 = __( 'Last Exercised On', 'wphealthtracker-textdomain' );
			$this->exercise_trans_51 = __( 'Used In These Exercises', 'wphealthtracker-textdomain' );

			return $translation_array = array(
				'exercisetrans1'  => $this->exercise_trans_1,
				'exercisetrans2'  => $this->exercise_trans_2,
				'exercisetrans3'  => $this->exercise_trans_3,
				'exercisetrans4'  => $this->exercise_trans_4,
				'exercisetrans5'  => $this->exercise_trans_5,
				'exercisetrans6'  => $this->exercise_trans_6,
				'exercisetrans7'  => $this->exercise_trans_7,
				'exercisetrans8'  => $this->exercise_trans_8,
				'exercisetrans9'  => $this->exercise_trans_9,
				'exercisetrans10' => $this->exercise_trans_10,
				'exercisetrans11' => $this->exercise_trans_11,
				'exercisetrans12' => $this->exercise_trans_12,
				'exercisetrans13' => $this->exercise_trans_13,
				'exercisetrans14' => $this->exercise_trans_14,
				'exercisetrans15' => $this->exercise_trans_15,
				'exercisetrans16' => $this->exercise_trans_16,
				'exercisetrans17' => $this->exercise_trans_17,
				'exercisetrans18' => $this->exercise_trans_18,
				'exercisetrans19' => $this->exercise_trans_19,
				'exercisetrans20' => $this->exercise_trans_20,
				'exercisetrans21' => $this->exercise_trans_21,
				'exercisetrans22' => $this->exercise_trans_22,
				'exercisetrans23' => $this->exercise_trans_23,
				'exercisetrans24' => $this->exercise_trans_24,
				'exercisetrans25' => $this->exercise_trans_25,
				'exercisetrans26' => $this->exercise_trans_26,
				'exercisetrans27' => $this->exercise_trans_27,
				'exercisetrans28' => $this->exercise_trans_28,
				'exercisetrans29' => $this->exercise_trans_29,
				'exercisetrans30' => $this->exercise_trans_30,
				'exercisetrans31' => $this->exercise_trans_31,
				'exercisetrans32' => $this->exercise_trans_32,
				'exercisetrans33' => $this->exercise_trans_33,
				'exercisetrans34' => $this->exercise_trans_34,
				'exercisetrans35' => $this->exercise_trans_35,
				'exercisetrans36' => $this->exercise_trans_36,
				'exercisetrans37' => $this->exercise_trans_37,
				'exercisetrans38' => $this->exercise_trans_38,
				'exercisetrans39' => $this->exercise_trans_39,
				'exercisetrans40' => $this->exercise_trans_40,
				'exercisetrans41' => $this->exercise_trans_41,
				'exercisetrans43' => $this->exercise_trans_43,
				'exercisetrans44' => $this->exercise_trans_44,
				'exercisetrans45' => $this->exercise_trans_45,
				'exercisetrans46' => $this->exercise_trans_46,
				'exercisetrans47' => $this->exercise_trans_47,
				'exercisetrans48' => $this->exercise_trans_48,
				'exercisetrans49' => $this->exercise_trans_49,
				'exercisetrans50' => $this->exercise_trans_50,
				'exercisetrans51' => $this->exercise_trans_51,
			);
		}

		/**
		 *  Translation strings that are used in the Quickstats dashboards
		 */
		public function dashboard_trans_strings() {

			$this->dashboard_trans_1  = __( 'QuickStats', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_2  = __( 'Total Days Tracked', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_3  = __( 'Day(s)', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_4  = __( 'Most Consecutive Days Tracked', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_5  = __( 'First Date Tracked', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_6  = __( 'Last Date Tracked', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_7  = __( 'Largest Gap Between Tracked Days', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_8  = __( 'Starting Weight', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_9  = __( 'Most Recent Weight', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_10 = __( 'Starting Cholesterol', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_11 = __( 'Most Recent Cholesterol', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_12 = __( 'Starting Blood Pressure', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_13 = __( 'Most Recent Blood Pressure', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_14 = __( 'Number of Gaps', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_15 = __( 'LDL', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_16 = __( 'HDL', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_17 = __( 'Tri.', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_18 = __( 'Total', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_19 = __( 'Systolic', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_20 = __( 'Diastolic', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_21 = __( 'Uh-Oh!', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_22 = __( "Looks like there's no saved data for", 'wphealthtracker-textdomain' );
			$this->dashboard_trans_23 = __( 'Click here to enter some data!', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_24 = __( 'Zero Gaps!', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_25 = __( 'No Starting Weight!', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_26 = __( 'No Recent Weight!', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_27 = __( 'No Starting Cholesterol!', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_28 = __( 'No Recent Cholesterol!', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_29 = __( 'No Starting Blood Pressue!', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_30 = __( 'No Recent Blood Pressure!', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_31 = __( 'No Consecutive Days Tracked!', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_32 = __( 'Gap(s)', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_33 = __( 'Total Unique Food Items', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_34 = __( 'Top 3 Consumed Food Items', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_35 = __( 'Avg. Daily Protein', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_36 = __( 'Avg. Daily Total Carbohydrates', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_37 = __( 'Avg. Daily Sugars', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_38 = __( 'Avg. Daily Total Fats', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_39 = __( 'Avg. Daily Fiber', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_40 = __( 'Grams', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_41 = __( 'Food Item(s)', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_42 = __( 'Avg. Daily Calories/Kcals', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_43 = __( 'Avg. Daily Kilojoules', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_44 = __( 'Avg. Daily Sat. Fats', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_45 = __( 'Avg. Daily Monounsat. Fats', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_46 = __( 'Avg. Daily Polyunsat. Fats', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_47 = __( 'Total Carbohydrates Consumed', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_48 = __( 'Total Protein Consumed', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_49 = __( 'Total Fats Consumed', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_50 = __( 'Total Unique Exercises', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_51 = __( 'Exercises', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_52 = __( 'Top Exercise', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_53 = __( 'Total Seconds Exercised', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_54 = __( 'Total Minutes Exercised', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_55 = __( 'Total Hours Exercised', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_56 = __( 'Top Exercise Category', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_57 = __( 'Total Exercise Categories', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_58 = __( 'Total Muscle Groups Exercised', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_59 = __( 'Top 3 Muscle Groups', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_60 = __( 'Muscle Group(s)', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_61 = __( 'Total Individual Exercises', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_62 = __( 'Longest Exercise (hours)', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_63 = __( 'Longest Exercise (minutes)', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_64 = __( 'Longest Exercise (seconds)', 'wphealthtracker-textdomain' );
			$this->dashboard_trans_65 = __( 'Average Time of Workout', 'wphealthtracker-textdomain' );

			return $dashboard_array1 = array(
				'dashboardtrans1'  => $this->dashboard_trans_1,
				'dashboardtrans2'  => $this->dashboard_trans_2,
				'dashboardtrans3'  => $this->dashboard_trans_3,
				'dashboardtrans4'  => $this->dashboard_trans_4,
				'dashboardtrans5'  => $this->dashboard_trans_5,
				'dashboardtrans6'  => $this->dashboard_trans_6,
				'dashboardtrans7'  => $this->dashboard_trans_7,
				'dashboardtrans8'  => $this->dashboard_trans_8,
				'dashboardtrans9'  => $this->dashboard_trans_9,
				'dashboardtrans10' => $this->dashboard_trans_10,
				'dashboardtrans11' => $this->dashboard_trans_11,
				'dashboardtrans12' => $this->dashboard_trans_12,
				'dashboardtrans13' => $this->dashboard_trans_13,
				'dashboardtrans14' => $this->dashboard_trans_14,
				'dashboardtrans15' => $this->dashboard_trans_15,
				'dashboardtrans16' => $this->dashboard_trans_16,
				'dashboardtrans17' => $this->dashboard_trans_17,
				'dashboardtrans18' => $this->dashboard_trans_18,
				'dashboardtrans19' => $this->dashboard_trans_19,
				'dashboardtrans20' => $this->dashboard_trans_20,
				'dashboardtrans21' => $this->dashboard_trans_21,
				'dashboardtrans22' => $this->dashboard_trans_22,
				'dashboardtrans23' => $this->dashboard_trans_23,
				'dashboardtrans24' => $this->dashboard_trans_24,
				'dashboardtrans25' => $this->dashboard_trans_25,
				'dashboardtrans26' => $this->dashboard_trans_26,
				'dashboardtrans27' => $this->dashboard_trans_27,
				'dashboardtrans28' => $this->dashboard_trans_28,
				'dashboardtrans29' => $this->dashboard_trans_29,
				'dashboardtrans30' => $this->dashboard_trans_30,
				'dashboardtrans31' => $this->dashboard_trans_31,
				'dashboardtrans32' => $this->dashboard_trans_32,
				'dashboardtrans33' => $this->dashboard_trans_33,
				'dashboardtrans34' => $this->dashboard_trans_34,
				'dashboardtrans35' => $this->dashboard_trans_35,
				'dashboardtrans36' => $this->dashboard_trans_36,
				'dashboardtrans37' => $this->dashboard_trans_37,
				'dashboardtrans38' => $this->dashboard_trans_38,
				'dashboardtrans39' => $this->dashboard_trans_39,
				'dashboardtrans40' => $this->dashboard_trans_40,
				'dashboardtrans41' => $this->dashboard_trans_41,
				'dashboardtrans42' => $this->dashboard_trans_42,
				'dashboardtrans43' => $this->dashboard_trans_43,
				'dashboardtrans44' => $this->dashboard_trans_44,
				'dashboardtrans45' => $this->dashboard_trans_45,
				'dashboardtrans46' => $this->dashboard_trans_46,
				'dashboardtrans47' => $this->dashboard_trans_47,
				'dashboardtrans48' => $this->dashboard_trans_48,
				'dashboardtrans49' => $this->dashboard_trans_49,
				'dashboardtrans50' => $this->dashboard_trans_50,
				'dashboardtrans51' => $this->dashboard_trans_51,
				'dashboardtrans52' => $this->dashboard_trans_52,
				'dashboardtrans53' => $this->dashboard_trans_53,
				'dashboardtrans54' => $this->dashboard_trans_54,
				'dashboardtrans55' => $this->dashboard_trans_55,
				'dashboardtrans56' => $this->dashboard_trans_56,
				'dashboardtrans57' => $this->dashboard_trans_57,
				'dashboardtrans58' => $this->dashboard_trans_58,
				'dashboardtrans59' => $this->dashboard_trans_59,
				'dashboardtrans60' => $this->dashboard_trans_60,
				'dashboardtrans61' => $this->dashboard_trans_61,
				'dashboardtrans62' => $this->dashboard_trans_62,
				'dashboardtrans63' => $this->dashboard_trans_63,
				'dashboardtrans64' => $this->dashboard_trans_64,
				'dashboardtrans65' => $this->dashboard_trans_65,
			);

		}

		/**
		 *  Translation strings that are used in d3 charts/stats areas
		 */
		public function d3_chart_trans_strings() {

			$this->d3_trans_1   = __( 'Weight Chart & Stats', 'wphealthtracker-textdomain' );
			$this->d3_trans_2   = __( 'Weight Stats', 'wphealthtracker-textdomain' );
			$this->d3_trans_3   = __( 'Began Tracking On', 'wphealthtracker-textdomain' );
			$this->d3_trans_4   = __( 'Lbs', 'wphealthtracker-textdomain' );
			$this->d3_trans_5   = __( 'Kg', 'wphealthtracker-textdomain' );
			$this->d3_trans_6   = __( 'Highest Weight', 'wphealthtracker-textdomain' );
			$this->d3_trans_7   = __( 'Lowest Weight', 'wphealthtracker-textdomain' );
			$this->d3_trans_8   = __( 'Average Weight', 'wphealthtracker-textdomain' );
			$this->d3_trans_9   = __( 'Total Weight Lost', 'wphealthtracker-textdomain' );
			$this->d3_trans_10  = __( 'Largest Single Loss', 'wphealthtracker-textdomain' );
			$this->d3_trans_11  = __( 'Largest Single Gain', 'wphealthtracker-textdomain' );
			$this->d3_trans_12  = __( "Looks like there's no saved Weight Data!", 'wphealthtracker-textdomain' );
			$this->d3_trans_13  = __( 'Once there is, this area will display a chart showing Weight change over time.', 'wphealthtracker-textdomain' );
			$this->d3_trans_14  = __( 'Once there is, this area will display some Weight Data Statistics.', 'wphealthtracker-textdomain' );
			$this->d3_trans_15  = __( 'Uh-Oh!', 'wphealthtracker-textdomain' );
			$this->d3_trans_16  = __( "Looks like there's not at least 2 days of saved Weight Data!", 'wphealthtracker-textdomain' );
			$this->d3_trans_17  = __( 'Total Weight Gained', 'wphealthtracker-textdomain' );
			$this->d3_trans_18  = __( 'Kilograms', 'wphealthtracker-textdomain' );
			$this->d3_trans_19  = __( 'Pounds', 'wphealthtracker-textdomain' );
			$this->d3_trans_20  = __( 'Hover Here...', 'wphealthtracker-textdomain' );
			$this->d3_trans_21  = __( 'Blood Pressure Chart & Stats', 'wphealthtracker-textdomain' );
			$this->d3_trans_22  = __( "Looks like there's no saved Blood Pressure Data!", 'wphealthtracker-textdomain' );
			$this->d3_trans_23  = __( 'Once there is, this area will display a chart showing Blood Pressure readings over time.', 'wphealthtracker-textdomain' );
			$this->d3_trans_24  = __( "Looks like there's not enough Blood Pressure Data yet!", 'wphealthtracker-textdomain' );
			$this->d3_trans_25  = __( 'Blood Pressure Stats', 'wphealthtracker-textdomain' );
			$this->d3_trans_26  = __( 'Highest Systolic', 'wphealthtracker-textdomain' );
			$this->d3_trans_27  = __( 'Lowest Systolic', 'wphealthtracker-textdomain' );
			$this->d3_trans_28  = __( 'Highest Diastolic', 'wphealthtracker-textdomain' );
			$this->d3_trans_29  = __( 'Lowest Diastolic', 'wphealthtracker-textdomain' );
			$this->d3_trans_30  = __( 'Average Single Reading', 'wphealthtracker-textdomain' );
			$this->d3_trans_31  = __( 'Highest Single Reading', 'wphealthtracker-textdomain' );
			$this->d3_trans_32  = __( 'Lowest Single Reading', 'wphealthtracker-textdomain' );
			$this->d3_trans_33  = __( 'Once there is, this area will display some Blood Pressure Data Statistics.', 'wphealthtracker-textdomain' );
			$this->d3_trans_34  = __( 'LDL', 'wphealthtracker-textdomain' );
			$this->d3_trans_35  = __( 'HDL', 'wphealthtracker-textdomain' );
			$this->d3_trans_36  = __( 'Triglycerides', 'wphealthtracker-textdomain' );
			$this->d3_trans_37  = __( 'Total', 'wphealthtracker-textdomain' );
			$this->d3_trans_38  = __( 'Cholesterol Chart & Stats', 'wphealthtracker-textdomain' );
			$this->d3_trans_39  = __( 'Cholesterol', 'wphealthtracker-textdomain' );
			$this->d3_trans_40  = __( 'Weight', 'wphealthtracker-textdomain' );
			$this->d3_trans_41  = __( 'Cholesterol Stats', 'wphealthtracker-textdomain' );
			$this->d3_trans_42  = __( 'Average LDL', 'wphealthtracker-textdomain' );
			$this->d3_trans_43  = __( 'Average HDL', 'wphealthtracker-textdomain' );
			$this->d3_trans_44  = __( 'Average Triglycerides', 'wphealthtracker-textdomain' );
			$this->d3_trans_45  = __( 'Average Total Cholesterol', 'wphealthtracker-textdomain' );
			$this->d3_trans_46  = __( 'Highest Total Cholesterol', 'wphealthtracker-textdomain' );
			$this->d3_trans_47  = __( 'Lowest Total Cholesterol', 'wphealthtracker-textdomain' );
			$this->d3_trans_48  = __( 'Building Awesome Chart...', 'wphealthtracker-textdomain' );
			$this->d3_trans_49  = __( "Looks like there's not at least 2 days of saved Cholesterol Data!", 'wphealthtracker-textdomain' );
			$this->d3_trans_50  = __( 'Once there is, this area will display a chart showing Cholesterol readings over time.', 'wphealthtracker-textdomain' );
			$this->d3_trans_51  = __( "Looks like there's no saved Cholesterol Data!", 'wphealthtracker-textdomain' );
			$this->d3_trans_52  = __( 'Once there is, this area will display some Cholesterol Data Statistics.', 'wphealthtracker-textdomain' );
			$this->d3_trans_53  = __( 'Food Chart & Stats', 'wphealthtracker-textdomain' );
			$this->d3_trans_54  = __( 'Hover On Bars Above...', 'wphealthtracker-textdomain' );
			$this->d3_trans_55  = __( 'Total Unique Food Items', 'wphealthtracker-textdomain' );
			$this->d3_trans_56  = __( 'Most Consumed Food', 'wphealthtracker-textdomain' );
			$this->d3_trans_57  = __( 'Total Kilocalories/Cal. Consumed', 'wphealthtracker-textdomain' );
			$this->d3_trans_58  = __( "Looks like there's no saved Food Data!", 'wphealthtracker-textdomain' );
			$this->d3_trans_59  = __( 'Once there is, this area will display some Food Data Statistics.', 'wphealthtracker-textdomain' );
			$this->d3_trans_60  = __( 'Once there is, this area will display a chart showing various data about your saved food items.', 'wphealthtracker-textdomain' );
			$this->d3_trans_61  = __( 'Total Kilojoules Consumed', 'wphealthtracker-textdomain' );
			$this->d3_trans_62  = __( 'Energy Chart & Stats', 'wphealthtracker-textdomain' );
			$this->d3_trans_63  = __( 'Macronutrients Chart & Stats', 'wphealthtracker-textdomain' );
			$this->d3_trans_64  = __( "Looks like there's no saved Energy (Calorie/Kilocalorie) Data!", 'wphealthtracker-textdomain' );
			$this->d3_trans_65  = __( 'Once there is, this area will display some Energy Data Statistics.', 'wphealthtracker-textdomain' );
			$this->d3_trans_66  = __( 'Energy (Calorie/Kilocalorie) Stats', 'wphealthtracker-textdomain' );
			$this->d3_trans_67  = __( 'Once there is, this area will display a chart showing Energy readings over time.', 'wphealthtracker-textdomain' );
			$this->d3_trans_68  = __( "Looks like there's not at least 2 days of saved Energy Data!", 'wphealthtracker-textdomain' );
			$this->d3_trans_69  = __( 'Energy', 'wphealthtracker-textdomain' );
			$this->d3_trans_70  = __( 'Macronutrients (All-Time Totals)', 'wphealthtracker-textdomain' );
			$this->d3_trans_71  = __( 'Macronutrients (Avg. Daily Values)', 'wphealthtracker-textdomain' );
			$this->d3_trans_72  = __( 'Hover Over Colors...', 'wphealthtracker-textdomain' );
			$this->d3_trans_73  = __( 'Macronutrient Stats', 'wphealthtracker-textdomain' );
			$this->d3_trans_74  = __( 'Distance Chart & Stats', 'wphealthtracker-textdomain' );
			$this->d3_trans_75  = __( 'Complete', 'wphealthtracker-textdomain' );
			$this->d3_trans_76  = __( 'Hover Over Dots', 'wphealthtracker-textdomain' );
			$this->d3_trans_77  = __( 'to', 'wphealthtracker-textdomain' );
			$this->d3_trans_78  = __( 'Play Demo...', 'wphealthtracker-textdomain' );
			$this->d3_trans_79  = __( 'Total Miles Travelled', 'wphealthtracker-textdomain' );
			$this->d3_trans_80  = __( 'Total Kilometers Travelled', 'wphealthtracker-textdomain' );
			$this->d3_trans_81  = __( 'Total Meters Travelled', 'wphealthtracker-textdomain' );
			$this->d3_trans_82  = __( 'Total Yards Travelled', 'wphealthtracker-textdomain' );
			$this->d3_trans_83  = __( 'Total Feet Travelled', 'wphealthtracker-textdomain' );
			$this->d3_trans_84  = __( 'Distance Stats', 'wphealthtracker-textdomain' );
			$this->d3_trans_85  = __( "Looks like you haven't travelled any distance at all!", 'wphealthtracker-textdomain' );
			$this->d3_trans_86  = __( 'Once you have, this area will display a map showing how far you\'ve travelled to various locations.', 'wphealthtracker-textdomain' );
			$this->d3_trans_87  = __( 'Once you have, this area will display some statistics about your distance travelled.', 'wphealthtracker-textdomain' );
			$this->d3_trans_88  = __( 'Around The World' );
			$this->d3_trans_89  = __( 'From Earth To The Moon' );
			$this->d3_trans_90  = __( 'Muscle Groups Chart & Stats' );
			$this->d3_trans_91  = __( 'Muscle Group Stats' );
			$this->d3_trans_92  = __( 'Hover Over Muscles', 'wphealthtracker-textdomain' );
			$this->d3_trans_93  = __( "Looks like there's no Muscle Group Data!", 'wphealthtracker-textdomain' );
			$this->d3_trans_94  = __( 'Once there is, this area will display a diagram showing info on the Muscles Groups Exercised.', 'wphealthtracker-textdomain' );
			$this->d3_trans_95  = __( "Looks like there's no saved Exercise Data!", 'wphealthtracker-textdomain' );
			$this->d3_trans_96  = __( 'Once there is, this area will display a chart showing info about your saved Exercise data.', 'wphealthtracker-textdomain' );
			$this->d3_trans_97  = __( 'Once there is, this area will display some Muscle Group Statistics.', 'wphealthtracker-textdomain' );
			$this->d3_trans_98  = __( 'Once there is, this area will display some Exercise Statistics.', 'wphealthtracker-textdomain' );
			$this->d3_trans_99  = __( 'Exercise Duration Chart & Stats', 'wphealthtracker-textdomain' );
			$this->d3_trans_100 = __( 'Hover Over Squares', 'wphealthtracker-textdomain' );
			$this->d3_trans_101 = __( 'Exercise Duration Stats' );

			$this->d3_trans_102 = __( "Looks like there's no Macronutrients Data!", 'wphealthtracker-textdomain' );
			$this->d3_trans_103 = __( 'Once there is, this area will display a diagram showing Macronutrient Percentages.', 'wphealthtracker-textdomain' );
			$this->d3_trans_104 = __( 'Once there is, this area will display some Macronutrients Statistics.', 'wphealthtracker-textdomain' );

			return $d3_array1 = array(
				'd3trans1'   => $this->d3_trans_1,
				'd3trans2'   => $this->d3_trans_2,
				'd3trans3'   => $this->d3_trans_3,
				'd3trans4'   => $this->d3_trans_4,
				'd3trans5'   => $this->d3_trans_5,
				'd3trans6'   => $this->d3_trans_6,
				'd3trans7'   => $this->d3_trans_7,
				'd3trans8'   => $this->d3_trans_8,
				'd3trans9'   => $this->d3_trans_9,
				'd3trans10'  => $this->d3_trans_10,
				'd3trans11'  => $this->d3_trans_11,
				'd3trans12'  => $this->d3_trans_12,
				'd3trans13'  => $this->d3_trans_13,
				'd3trans14'  => $this->d3_trans_14,
				'd3trans15'  => $this->d3_trans_15,
				'd3trans16'  => $this->d3_trans_16,
				'd3trans17'  => $this->d3_trans_17,
				'd3trans18'  => $this->d3_trans_18,
				'd3trans19'  => $this->d3_trans_19,
				'd3trans20'  => $this->d3_trans_20,
				'd3trans21'  => $this->d3_trans_21,
				'd3trans22'  => $this->d3_trans_22,
				'd3trans23'  => $this->d3_trans_23,
				'd3trans24'  => $this->d3_trans_24,
				'd3trans25'  => $this->d3_trans_25,
				'd3trans26'  => $this->d3_trans_26,
				'd3trans27'  => $this->d3_trans_27,
				'd3trans28'  => $this->d3_trans_28,
				'd3trans29'  => $this->d3_trans_29,
				'd3trans30'  => $this->d3_trans_30,
				'd3trans31'  => $this->d3_trans_31,
				'd3trans32'  => $this->d3_trans_32,
				'd3trans33'  => $this->d3_trans_33,
				'd3trans34'  => $this->d3_trans_34,
				'd3trans35'  => $this->d3_trans_35,
				'd3trans36'  => $this->d3_trans_36,
				'd3trans37'  => $this->d3_trans_37,
				'd3trans38'  => $this->d3_trans_38,
				'd3trans39'  => $this->d3_trans_39,
				'd3trans40'  => $this->d3_trans_40,
				'd3trans41'  => $this->d3_trans_41,
				'd3trans42'  => $this->d3_trans_42,
				'd3trans43'  => $this->d3_trans_43,
				'd3trans44'  => $this->d3_trans_44,
				'd3trans45'  => $this->d3_trans_45,
				'd3trans46'  => $this->d3_trans_46,
				'd3trans47'  => $this->d3_trans_47,
				'd3trans48'  => $this->d3_trans_48,
				'd3trans49'  => $this->d3_trans_49,
				'd3trans50'  => $this->d3_trans_50,
				'd3trans51'  => $this->d3_trans_51,
				'd3trans52'  => $this->d3_trans_52,
				'd3trans53'  => $this->d3_trans_53,
				'd3trans54'  => $this->d3_trans_54,
				'd3trans55'  => $this->d3_trans_55,
				'd3trans56'  => $this->d3_trans_56,
				'd3trans57'  => $this->d3_trans_57,
				'd3trans58'  => $this->d3_trans_58,
				'd3trans59'  => $this->d3_trans_59,
				'd3trans60'  => $this->d3_trans_60,
				'd3trans61'  => $this->d3_trans_61,
				'd3trans62'  => $this->d3_trans_62,
				'd3trans63'  => $this->d3_trans_63,
				'd3trans64'  => $this->d3_trans_64,
				'd3trans65'  => $this->d3_trans_65,
				'd3trans66'  => $this->d3_trans_66,
				'd3trans67'  => $this->d3_trans_67,
				'd3trans68'  => $this->d3_trans_68,
				'd3trans69'  => $this->d3_trans_69,
				'd3trans70'  => $this->d3_trans_70,
				'd3trans71'  => $this->d3_trans_71,
				'd3trans72'  => $this->d3_trans_72,
				'd3trans73'  => $this->d3_trans_73,
				'd3trans74'  => $this->d3_trans_74,
				'd3trans75'  => $this->d3_trans_75,
				'd3trans76'  => $this->d3_trans_76,
				'd3trans77'  => $this->d3_trans_77,
				'd3trans78'  => $this->d3_trans_78,
				'd3trans79'  => $this->d3_trans_79,
				'd3trans80'  => $this->d3_trans_80,
				'd3trans81'  => $this->d3_trans_81,
				'd3trans82'  => $this->d3_trans_82,
				'd3trans83'  => $this->d3_trans_83,
				'd3trans84'  => $this->d3_trans_84,
				'd3trans85'  => $this->d3_trans_85,
				'd3trans86'  => $this->d3_trans_86,
				'd3trans87'  => $this->d3_trans_87,
				'd3trans88'  => $this->d3_trans_88,
				'd3trans89'  => $this->d3_trans_89,
				'd3trans90'  => $this->d3_trans_90,
				'd3trans91'  => $this->d3_trans_91,
				'd3trans92'  => $this->d3_trans_92,
				'd3trans93'  => $this->d3_trans_93,
				'd3trans94'  => $this->d3_trans_94,
				'd3trans95'  => $this->d3_trans_95,
				'd3trans96'  => $this->d3_trans_96,
				'd3trans97'  => $this->d3_trans_97,
				'd3trans98'  => $this->d3_trans_98,
				'd3trans99'  => $this->d3_trans_99,
				'd3trans100' => $this->d3_trans_100,
				'd3trans101' => $this->d3_trans_101,
			);

		}

		/**
		 *  Translation strings that are used in responses to specific Ajax cals, like saving/editing user data
		 */
		public function ajax_return_strings() {

			$this->ajax_return_1  = __( 'Success!', 'wphealthtracker-textdomain' );
			$this->ajax_return_2  = __( "You've just updated your data for", 'wphealthtracker-textdomain' );
			$this->ajax_return_3  = __( "You've just saved your data for", 'wphealthtracker-textdomain' );
			$this->ajax_return_4  = __( 'Be sure to visit', 'wphealthtracker-textdomain' );
			$this->ajax_return_5  = __( 'The WPHealthTracker Website', 'wphealthtracker-textdomain' );
			$this->ajax_return_6  = __( 'for Extensions, StylePaks, and more!', 'wphealthtracker-textdomain' );
			$this->ajax_return_7  = __( "And don't forget to", 'wphealthtracker-textdomain' );
			$this->ajax_return_8  = __( 'leave a 5-star review', 'wphealthtracker-textdomain' );
			$this->ajax_return_9  = __( 'over at the', 'wphealthtracker-textdomain' );
			$this->ajax_return_10 = __( 'WordPress Plugin Repository', 'wphealthtracker-textdomain' );
			$this->ajax_return_11 = __( 'Uh-Oh!', 'wphealthtracker-textdomain' );
			$this->ajax_return_12 = __( 'Looks like there was an issue saving or updating your data', 'wphealthtracker-textdomain' );
			$this->ajax_return_13 = __( 'Try sending this error message to', 'wphealthtracker-textdomain' );
			$this->ajax_return_14 = __( "Sorry about the trouble - WPHealthTracker Tech Support will do it's best to fix your issue", 'wphealthtracker-textdomain' );

			return $translation_array = array(
				'ajaxreturn1'  => $this->ajax_return_1,
				'ajaxreturn2'  => $this->ajax_return_2,
				'ajaxreturn3'  => $this->ajax_return_3,
				'ajaxreturn4'  => $this->ajax_return_4,
				'ajaxreturn5'  => $this->ajax_return_5,
				'ajaxreturn6'  => $this->ajax_return_6,
				'ajaxreturn7'  => $this->ajax_return_7,
				'ajaxreturn8'  => $this->ajax_return_8,
				'ajaxreturn9'  => $this->ajax_return_9,
				'ajaxreturn10' => $this->ajax_return_10,
				'ajaxreturn11' => $this->ajax_return_11,
				'ajaxreturn12' => $this->ajax_return_12,
				'ajaxreturn13' => $this->ajax_return_13,
				'ajaxreturn14' => $this->ajax_return_14,
			);

		}


	}
endif;
