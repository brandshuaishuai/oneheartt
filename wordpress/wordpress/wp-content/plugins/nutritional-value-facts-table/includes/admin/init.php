<?php
function nutritional_value_admin_init(){
	
	
	include( 'create-metaboxes.php' );
	include ('nutritional-value-options.php');
	include ('enqueue.php');
    include ('columns.php');
	add_action ('add_meta_boxes_nutritional_value', 'nvft_create_metaboxes');
    add_action ('admin_enqueue_scripts', 'nvft_admin_enqueue');
    add_filter('manage_edit-nutritional_value_columns', 'add_new_nutritional_value_columns');
    add_action('manage_nutritional_value_posts_custom_column', 'manage_nutritional_value_columns', 10, 2 );
    remove_meta_box( 'categorydiv', 'nutritional_value', 'normal' ); 
    remove_meta_box( 'tagsdiv-post_tag','nutritional_value','normal' ); // Tags Metabox
}


/*

DIT ZORGT VOOR HET AANMAKEN VAN EEN METABOX OM RECEPTEN AAN TE MAKEN EN OM VOEDINGSINFORMATIE IN TE GEVEN

*/
?>