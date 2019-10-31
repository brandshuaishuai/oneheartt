<?php
if(!defined('WP_UNINSTALL_PLUGIN'))
    exit;

    /** following code deletes all tables
     * and the plugin options after uninstall.
     */
global $wpdb;

$table_name = $wpdb->prefix . "ghazale_sds_";
$sql = "SHOW TABLES LIKE '" . $table_name . "%'";
$tables = $wpdb->get_results($sql,ARRAY_A);
foreach ($tables as $table) {
    foreach ($table as $single_table) {
        $wpdb->query("DROP TABLE IF EXISTS ". $single_table);
    }
}