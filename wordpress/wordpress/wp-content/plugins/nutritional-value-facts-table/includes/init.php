<?php
function nutritional_value_init() {
	/**
 * Register a book post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 
 Hier gaan we het post type registreren. 
 */
$labels = array(
		'name'               => __( 'Nutritional Values', 'post type general name', 'nutritional-value-facts-table' ), // 'name'               => _x( 'Books', 'post type general name', 'your-plugin-textdomain' ),
		'singular_name'      => __( 'Nutritional Value', 'post type singular name', 'nutritional-value-facts-table' ),
		'menu_name'          => __( 'Nutritional Values', 'admin menu', 'nutritional-value-facts-table' ),
		'name_admin_bar'     => __( 'Nutritional Value', 'add new on admin bar', 'nutritional-value-facts-table' ),
		'add_new'            => __( 'Add New', 'nutritional_value', 'nutritional-value-facts-table' ),
		'add_new_item'       => __( 'Add New Nutritional Value', 'nutritional-value-facts-table' ),
		'new_item'           => __( 'New Nutritional Value', 'nutritional-value-facts-table' ),
		'edit_item'          => __( 'Edit Nutritional Value', 'nutritional-value-facts-table' ),
		'view_item'          => __( 'View Nutritional Value', 'nutritional-value-facts-table' ),
		'all_items'          => __( 'All Nutritional Values', 'nutritional-value-facts-table' ),
		'search_items'       => __( 'Search Nutritional Values', 'nutritional-value-facts-table' ),
		'parent_item_colon'  => __( 'Parent Nutritional Values:', 'nutritional-value-facts-table' ),
		'not_found'          => __( 'No Nutritional Values found.', 'nutritional-value-facts-table' ),
		'not_found_in_trash' => __( 'No Nutritional Values found in Trash.', 'nutritional-value-facts-table' )
	);

	$args = array(
		'labels'             => $labels,
                'description'        => __( 'A Custom Post Type For Nutritional Values.', 'nutritional-value-facts-table' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'nutritional-value' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 20,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail' ),
		'taxonomies'          => array ( 'category','post_tag')
	);
	 
	 
	 flush_rewrite_rules( false );

	register_post_type( 'nutritional_value', $args );
	}
	
	// Eerste parameter 'recipe' is voor ons posttype, tweede $args zijn de settings!
/*
function nvft_food_category_init() {
	// create a new taxonomy
	register_taxonomy(
		'food_category',
		'nutritional_value',
		array(
			'label' => __( 'food_category' ),
			'rewrite' => array( 'slug' => 'food-category' ),
			'capabilities' => array(
				'assign_terms' => 'edit_guides',
				'edit_terms' => 'publish_guides'
			)
		)
	);
}
add_action( 'init', 'nvft_food_category_init' );

*/


