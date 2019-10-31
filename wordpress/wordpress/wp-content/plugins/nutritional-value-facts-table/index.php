<?php
/*
* Plugin Name: Nutritional Value Facts Table
* Author Name: Djenci Duquene
* Author URI: https://dbdprojects.com
* Version: 1.0.1
* Description: With This Plugin We Can Add The Nutritional Information Of Foods. We Can Add Calories, Carbs, Fats, Protein, Vitamins, Minerals and Omega 3 Omega 6 Ratio. We can write about the benefits of that particular food. This is the most complete nutritional facts label on the plugin market for Wordpress.
* Text Domain: nutritional-value-facts-table

*/

// Not allowing direct access to the plugin files
if( !function_exists ( 'add_action')) {
	echo 'Not Allowed!';
	exit();
}
// End

// Setups

// Constant

define ('NUTRITIONAL_VALUE_PLUGIN_URL', __FILE__ );

// Includes
include ('includes/activation.php');
include ('includes/init.php');
include ('includes/admin/init.php');
include ('process/save-post.php');
include ('process/filter-content.php');
include ('includes/front/enqueue.php');

// Hooks
register_activation_hook(__FILE__, 'nvft_activate_plugin');
add_action('init', 'nutritional_value_init');
add_action ('admin_init', 'nutritional_value_admin_init');
add_action ('save_post_nutritional_value', 'nvft_save_post_admin', 10, 3); // !!!!!!!!!!!!!!!!!!!!!!
add_filter ('the_content', 'nvft_filter_nutrition_value_content');
add_action ('wp_enqueue_scripts', 'nvft_enqueue_scripts', 9999);
// Shortcodes


?>