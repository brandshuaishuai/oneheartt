<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package guava
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function guava_body_classes( $classes )
   {

   		global $guava_theme_options;
   	
		// Adds a class of group-blog to blogs with more than 1 published author.
		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() )
	{
		$classes[] = 'hfeed';
	}



// Logo Image Position

    $logo_position  = $guava_theme_options['site_logo_position'];
	$classes[]      = $logo_position;


// Site Layout
    $site_layout  = $guava_theme_options['site_layout'];
	$classes[]      = $site_layout;




// Add sticky menu
    $sticky_menu  = $guava_theme_options['show_sticky_menu'];
    if( $sticky_menu == 1 )
    {
    	$sticky_menu = "sticky-menu";
    }
	$classes[]    = $sticky_menu;


// Add design layout of sidebar
    $designlayout=$guava_theme_options['guava-layout'];
	$classes[] = $designlayout;
	return $classes;
}
add_filter( 'body_class', 'guava_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function guava_pingback_header()
{
	if ( is_singular() && pings_open() ) 
	{
		echo '<link rel="pingback" href="', bloginfo( 'pingback_url' ), '">';
	}
}
add_action( 'wp_head', 'guava_pingback_header');
