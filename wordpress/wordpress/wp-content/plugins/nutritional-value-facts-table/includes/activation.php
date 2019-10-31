<?php

function nvft_activate_plugin(){
if( version_compare( get_bloginfo('version'), '4.2', '<') ){
	wp_die( __('You must update Wordpress to use this plugin', 'nutritional-value-facts-table')); // nutritional-value-facts-table = Text Domain
}
function my_rewrite_flush() {
    // First, we "add" the custom post type via the above written function.
    // Note: "add" is written with quotes, as CPTs don't get added to the DB,
    // They are only referenced in the post_type column with a post entry, 
    // when you add a post of this CPT.
    nutritional_value_init();

    // ATTENTION: This is *only* done during plugin activation hook in this example!
    // You should *NEVER EVER* do this on every page load!!
    flush_rewrite_rules();
}	
global $wpdb;
$createSQL = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "wp_nutritional_value_rating` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nutritional_value_id` bigint(20) UNSIGNED NOT NULL,
  `rating` float UNSIGNED NOT NULL,
  `user_ip` varchar(32) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB " . $wpdb->get_charset_collate() . " AUTO_INCREMENT=1;";

require ( ABSPATH . '/wp-admin/includes/upgrade.php');
dbDelta($createSQL);
	
}