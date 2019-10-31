<?php
/*
Plugin Name: Database operations 
Plugin URI: https://antechncom.wordpress.com/
Description: This plugin connects Wordpress and the MY_SQL database, thus allowing a user fetch data from the MY_SQL database, a user can display a table or perform a simple 'UNION' on two tables. Copy shortcodes to use on any page. 
Version: 2.9.9
Author: Antechn
Author URI: https://antechncom.wordpress.com/about-us/
License: GPLv2
Text Domain:       Database-operations
Domain Path:       /languages
*/
/*  Copyright 2019  Bowale Joseph  (email : devjoe2016@gmail.com)
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-database-operations-activator.php
 */
function activate_database_operations() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-database-operations-activator.php';
	Database_Operations_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-database-operations-deactivator.php
 */
function deactivate_database_operations() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-database-operations-deactivator.php';
	Database_Operations_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_database_operations' );
register_deactivation_hook( __FILE__, 'deactivate_database_operations' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-database-operations.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.5.0
 */
function run_database_operations() {

	$plugin = new Database_Operations();
	$plugin->run();

}
run_database_operations();
