<?php
/**
 * guava Theme Customizer.
 *
 * @package guava
 */
/**
 *  Default Theme options
 *
 * @since guava 1.0.0
 *
 * @param null
 * @return array $guava_theme_layout
 *
 */
if ( !function_exists('guava_default_theme_options') ) :
    function guava_default_theme_options() 
   {
        $default_theme_options = array(
            /*feature section options*/
            'site_identity'           => 'title-text',
            'site_logo_position'      => 'center-logo-image',
            'site_layout'             => 'full-width',
            'show_sticky_menu'        => 1,
            'guava-feature-cat'       => 0,
            'guava_no_of_slider'      => 3,
            'slider-options'          => 'category',
            'guava-feature-tag'       => 0,
            'guava-promo-cat'         => 0,
            
            'guava_promo_tagline_option'=> esc_html__( 'Hot Topics', 'guava'),
            
            'guava-footer-copyright'  => esc_html__( 'Guava WordPress Theme, Copyright 2017', 'guava'),
            'guava-layout'            => 'right-sidebar',   
            
            'breadcrumb_option'       => 'simple',
            
            'guava-realted-post'      => 0,
            'guava-realted-post-title'=> esc_html__( 'Related Posts', 'guava' ),
            
            'hide-breadcrumb-at-home' => 1 ,
            
            'primary_color'           => '#222222',
            
            'guava_columns_option'    => 'col-sm-12',
            
            'guava_read_more_text_blog_archive_option' => esc_html( 'Read More', 'guava' ),
            'guava_social_share_blog_archive_option'=> 1,
            'guava_post_pagination_option'             => 'default',
             
             // Theme Color Options
            'guava_primary_color'                      => '#4c5ccf',
            
             //Paragraph
            'guava_paragraph_font_url'                 => wp_kses_post( 'https://fonts.googleapis.com/css?family=Hind:300,400,500|Libre+Franklin:400,500|Merriweather:400,700,700i,900','guava'),
            'guava_paragraph_font_family'                        => "Hind, sans-serif",
        ); 

        return apply_filters( 'guava_default_theme_options', $default_theme_options );
    }
endif;

/**
 *  Get theme options
 *
 * @since guava 1.0.0
 *
 * @param null
 * @return array guava_theme_options
 *
 */
if ( !function_exists('guava_get_theme_options') ) :
    function guava_get_theme_options()
    {

        $guava_default_theme_options = guava_default_theme_options();
        

        $guava_get_theme_options = get_theme_mod( 'guava_theme_options');
        
        if( is_array( $guava_get_theme_options )){
          
            return array_merge( $guava_default_theme_options, $guava_get_theme_options );
        }

        else{

            return $guava_default_theme_options;
        }

    }
endif;

/**
 * Sidebar layout options
 *
 * @since guava 1.0.0
 *
 * @param null
 * @return array $guava_sidebar_layout
 *
 */
if ( !function_exists('guava_sidebar_layout') ) :
    function guava_sidebar_layout()
    {
        $guava_sidebar_layout =  array(
            'right-sidebar' => __( 'Right Sidebar', 'guava'),
            'left-sidebar'  => __( 'Left Sidebar' , 'guava'),
            'no-sidebar'    => __( 'No Sidebar', 'guava')
        );
        return apply_filters( 'guava_sidebar_layout', $guava_sidebar_layout );
    }
endif;

/**
 * guava select_number of columns option for blog post
 *
 * @since Guava 1.0.0
 *
 * @param null
 * @return array $guava_select_number_of_column
 *
 */
if (!function_exists('guava_select_number_of_column')) :
    function guava_select_number_of_column()
    {
        $guava_select_number_of_column = array(
            'col-sm-12'  => esc_html__( '1 Columns','guava'),
            'col-sm-6'  => esc_html__( 'Masonry 2 Columns','guava'),
            'col-sm-4'  => esc_html__( 'Masonry 3 Columns','guava'),
           
        );
        return apply_filters('guava_select_number_of_column', $guava_select_number_of_column);
    }
endif;
/**
 * Pagination option
 *
 * @since Guava 1.0.0
 *
 * @param null
 * @return array $guava_pagination_option
 *
 */
if (!function_exists('guava_pagination_option')) :
    function guava_pagination_option()
    {
        $guava_pagination_option = array(
            'default'   => esc_html__( 'Default','guava'),
            'numeric'   => esc_html__( 'Numeric','guava'),
        );
        return apply_filters('guava_pagination_option', $guava_pagination_option);
    }
endif;
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function guava_customize_register( $wp_customize )
{
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	/*defaults options*/
    $defaults = guava_get_theme_options();
       
    /**
     * Load customizer custom-controls
     */
    require get_template_directory() . '/inc/customizer-inc/custom-controls.php';

    /**
     * Load customizer Theme Options
     */
    require get_template_directory() . '/inc/customizer-inc/theme-options.php';

     /**
     * Load customizer Color section
     */
    require get_template_directory() . '/inc/customizer-inc/color-options.php';

      /**
     * Load customizer Typography section
     */
    require get_template_directory() . '/inc/customizer-inc/typography-options.php';


}
add_action( 'customize_register', 'guava_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function guava_customize_preview_js() 
{
	wp_enqueue_script( 'guava_customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'jquery' ), '20151216', true );
}
add_action( 'customize_preview_init', 'guava_customize_preview_js' );


function guava_customizer_script() {

    wp_enqueue_script( 'guava-alpha-color-picker', get_template_directory_uri() .'/assets/js/alpha-color-picker.js',array( 'jquery', 'wp-color-picker' ),
            time());   
}
add_action( 'customize_controls_enqueue_scripts', 'guava_customizer_script' );

/**
 * Sanitizing the select callback example
 *
 * @since guava 1.0.0
 *
 * @see sanitize_key()https://developer.wordpress.org/reference/functions/sanitize_key/
 * @see $wp_customize->get_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/get_control/
 *
 * @param $input
 * @param $setting
 * @return sanitized output
 *
 */
if ( !function_exists('guava_sanitize_select') ) :
    function guava_sanitize_select( $input, $setting ) 
   {

        // Ensure input is a slug.
        $input = sanitize_key( $input );

        // Get list of choices from the control associated with the setting.
        $choices = $setting->manager->get_control( $setting->id )->choices;

        // If the input is a valid key, return it; otherwise, return the default.
        return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
    }
endif;

/**
 * Sanitize checkbox field
 *
 * @since Guava 1.0.0
 *
 * @param $checked
 * @return Boolean
 */
if ( !function_exists('guava_sanitize_checkbox') ) :
    function guava_sanitize_checkbox( $checked ) {
        // Boolean check.
        return ( ( isset( $checked ) && true == $checked ) ? true : false );
    }
endif;