<?php

//Logo Options Setting Starts
$wp_customize->add_setting('guava_theme_options[site_identity]',
 array(
    'default'           => $defaults['site_identity'],
    'sanitize_callback' => 'guava_sanitize_select'
));

$wp_customize->add_control('guava_theme_options[site_identity]',
 array(
    'type'              => 'radio',
    'label'             => esc_html__('Logo Options', 'guava'),
    'section'           => 'title_tagline',
    'choices'           => array(
        'logo-only'     => esc_html__('Logo Only', 'guava'),
        'title-text'    => esc_html__('Title + Tagline', 'guava'),
        'logo-desc'     => esc_html__('Logo + Tagline', 'guava'),
        'logo-title'    => esc_html__('Logo + Title', 'guava'),
        'logo-title-desc'    => esc_html__('Logo + Title + Tagline', 'guava')
    )
));

//Logo Position Options Setting 
$wp_customize->add_setting('guava_theme_options[site_logo_position]',
 array(
    'default'           => $defaults['site_logo_position'],
    'sanitize_callback' => 'guava_sanitize_select'
));

$wp_customize->add_control('guava_theme_options[site_logo_position]',
 array(
    'type'              => 'radio',
    'label'             => esc_html__('Logo Position Options', 'guava'),
    'section'           => 'title_tagline',
    'choices'           => array(
        'left-logo-image'     => esc_html__('Left Logo Image', 'guava'),
        'center-logo-image'    => esc_html__('Center Logo Image', 'guava'),
    )
));


/**
 * Theme Option
 *
 * @since 1.0.0
 */
$wp_customize->add_panel(
    'guava_theme_options', 
    array(
        'priority'       => 15,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '',
        'title'          => esc_html__( 'Theme Option', 'guava' ),
    ) 
);


// Layout Section.
$wp_customize->add_section( 'general_setting',
    array(
        'title'      => esc_html__( 'General Settings', 'guava' ),
        'priority'   => 100,
        'panel'      => 'guava_theme_options',
    )
);

// Setting global_layout.
$wp_customize->add_setting( 'guava_theme_options[site_layout]',
    array(
        'default'           => $defaults['site_layout'],
        'sanitize_callback' => 'guava_sanitize_select',
    )
);
$wp_customize->add_control( 'guava_theme_options[site_layout]',
    array(
        'label'    => esc_html__( 'Site Layout', 'guava' ),
        'section'  => 'general_setting',
        'type'     => 'select',
        'priority' => 10,
        'choices'  => array(

            'full-width'  => esc_html__( 'Full Width', 'guava' ),
            'boxed'       => esc_html__( 'Boxed', 'guava' ),

        ),
    )
);
// Navigation Section.
  $wp_customize->add_section( 'main_navigation_option',
    array(
        'title'      => esc_html__( 'Main Navigation Options', 'guava' ),
        'priority'   => 100,
        'panel'      => 'guava_theme_options',
    )
);

// Setting Show Sticky Menu.
$wp_customize->add_setting( 'guava_theme_options[show_sticky_menu]',
    array(
        'default'           => $defaults['show_sticky_menu'],
        'sanitize_callback' => 'guava_sanitize_checkbox',
    )
);

$wp_customize->add_control( 'guava_theme_options[show_sticky_menu]',
    array(
        'label'             => esc_html__( 'Show Sticky Menu', 'guava' ),
        'section'           => 'main_navigation_option',
        'type'              => 'checkbox',
        'priority'          => 10,
    )
);




/*adding sections for Breadcrumbs for pages/posts*/
$wp_customize->add_section( 'breadcrumb_type',
 array(
    'priority'       => 160,
    'capability'     => 'edit_theme_options',
    'title'          => __( 'Breadcrumbs Section', 'guava' ),
    'panel'          => 'guava_theme_options',


) );

/* breadcrumb_option*/
$wp_customize->add_setting( 'guava_theme_options[breadcrumb_option]',
 array(
    'capability'        => 'edit_theme_options',
    'default'           => $defaults['breadcrumb_option'],
    'sanitize_callback' => 'guava_sanitize_select'
) );

$wp_customize->add_control('guava_theme_options[breadcrumb_option]',
    array(
        'label' => esc_html__('Breadcrumb Options', 'guava'),
        'section'   => 'breadcrumb_type',
        'settings'  => 'guava_theme_options[breadcrumb_option]',
        'choices'   => array(
            'simple'     => esc_html__('Simple', 'guava'),
            'disable'    => esc_html__('Disable', 'guava'),
        ),
        'type' => 'select',
        'priority' => 10
    )
);

// Call back Function for feature slider
if (!function_exists('guava_is_category_slider_active')) {
        // Check for the video slider
    function guava_is_category_slider_active()
    {
        global $guava_theme_options;
        $guava_theme_options    = guava_get_theme_options(); 
        $selected_opt = $guava_theme_options['slider-options'];

        if ( $selected_opt == 'category' ) {

            return true;
        }
        return false;
    }
}

/*adding sections for category section in front page*/
$wp_customize->add_section( 'guava-feature-category',
 array(
    'priority'       => 160,
    'capability'     => 'edit_theme_options',
    'title'          => __( 'Slider Section', 'guava' ),
    'panel'          => 'guava_theme_options',
    'description'    => __( 'Recommended image for slider is 1920*700', 'guava' )

) );


/* slider-options*/
$wp_customize->add_setting( 'guava_theme_options[slider-options]',
 array(
    'capability'        => 'edit_theme_options',
    'default'           => $defaults['slider-options'],
    'sanitize_callback' => 'guava_sanitize_select'
) );

$wp_customize->add_control('guava_theme_options[slider-options]',
    array(
        'label' => esc_html__('Slider Options', 'guava'),
        'section'   => 'guava-feature-category',
        'settings'  => 'guava_theme_options[slider-options]',
        'choices'   => array(
            ''          => esc_html__('Select Option', 'guava'),
            'category'     => esc_html__('Category', 'guava'),
            'recent-posts'    => esc_html__('Recent Posts', 'guava'),
        ),
        'type' => 'select',
        'priority' => 10
    )
);

/* feature cat selection */
$wp_customize->add_setting( 'guava_theme_options[guava-feature-cat]',
 array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['guava-feature-cat'],
    'sanitize_callback' => 'absint'
) );

$wp_customize->add_control(
    new Guava_Customize_Category_Dropdown_Control(
        $wp_customize,
        'guava_theme_options[guava-feature-cat]',
        array(
            'label'		=> __( 'Select Category', 'guava' ),
            'section'   => 'guava-feature-category',
            'settings'  => 'guava_theme_options[guava-feature-cat]',
            'type'	  	=> 'category_dropdown',
            'active_callback' => 'guava_is_category_slider_active',
            'priority'  => 10
        )
    )
);
/**
 * Field for no of posts to display..
 *
 */

$wp_customize->add_setting(
    'guava_theme_options[guava_no_of_slider]',
    array(
        'default' => $defaults['guava_no_of_slider'],
        'sanitize_callback' => 'absint',
    )
);


$wp_customize->add_control(
    'guava_theme_options[guava_no_of_slider]',
    array(
        'type'             => 'number',
        'label'            => esc_html__('No of Slider', 'guava'),
        'section'          => 'guava-feature-category',
        'priority' => 10
    )
);
/*adding sections for category selection for promo section in homepage*/
$wp_customize->add_section( 'guava-promo-category', 
    array(
        'priority'       => 160,
        'capability'     => 'edit_theme_options',
        'title'          => __( 'Promo Section', 'guava' ),
        'panel'          => 'guava_theme_options',
        'description'    => __( 'Recommended image for col section is 600*600', 'guava' )
    ) );

/* feature cat selection */
$wp_customize->add_setting( 'guava_theme_options[guava-promo-cat]',
 array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['guava-promo-cat'],
    'sanitize_callback' => 'absint'
) );

$wp_customize->add_control(
    new Guava_Customize_Category_Dropdown_Control(
        $wp_customize,
        'guava_theme_options[guava-promo-cat]',
        array(
            'label'		=> __( 'Select Category', 'guava' ),
            'section'   => 'guava-promo-category',
            'settings'  => 'guava_theme_options[guava-promo-cat]',
            'type'	  	=> 'category_dropdown',
            'priority'  => 10
        )
    )
);

/**
 * Promo Tagline Section
 */
   $wp_customize->add_setting(
    'guava_theme_options[guava_promo_tagline_option]',
    array(
        'default' => $defaults['guava_promo_tagline_option'],
        'sanitize_callback' => 'sanitize_text_field',
    )
);
   $wp_customize->add_control('guava_theme_options[guava_promo_tagline_option]',
    array(
        'label' => esc_html__('Promo Tagline', 'guava'),
        'section' => 'guava-promo-category',
        'type' => 'text',
        'priority' => 14
    )
);




/*adding sections for category selection for promo section in homepage*/
$wp_customize        -> add_section( 'guava-site-layout',
 array(
    'priority'       => 160,
    'capability'     => 'edit_theme_options',
    'panel'          => 'guava_theme_options',
    'title'          => __( 'Sidebar Options', 'guava' )
) );

/* Sidebar selection */
$wp_customize          -> add_setting( 'guava_theme_options[guava-layout]',
 array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['guava-layout'],
    'sanitize_callback' => 'guava_sanitize_select'
) );

$choices                = guava_sidebar_layout();
$wp_customize           -> add_control('guava_theme_options[guava-layout]',
    array(
        'choices'   => $choices,
        'label'		=> __( 'Sidebar Position', 'guava'),
        'section'   => 'guava-site-layout',
        'settings'  => 'guava_theme_options[guava-layout]',
        'type'	  	=> 'select',
        'priority'  => 10
    )
);
/*adding sections for Blog Options*/

$wp_customize        -> add_section( 'guava-blog-layout',
 array(
    'priority'       => 160,
    'capability'     => 'edit_theme_options',
    'panel'          => 'guava_theme_options',
    'title'          => __( 'Blog/Archive Design Layout', 'guava' )
) );
/**
 * Blog/Archive Columns Option
 */
  $wp_customize->add_setting(
    'guava_theme_options[guava_columns_option]',
    array(
        'default'           => $defaults['guava_columns_option'],
        'sanitize_callback' => 'guava_sanitize_select',
    )
);

  $columns = guava_select_number_of_column();
  $wp_customize->add_control('guava_theme_options[guava_columns_option]',
    array(
        'choices'   => $columns,
        'label'     => esc_html__('Columns Options','guava'),
        'section'   => 'guava-blog-layout',
        'type'      => 'select',
        'priority'  => 10
    )
);

/**
 * Read More Text
 */
   $wp_customize->add_setting(
    'guava_theme_options[guava_read_more_text_blog_archive_option]',
    array(
        'default' => $defaults['guava_read_more_text_blog_archive_option'],
        'sanitize_callback' => 'sanitize_text_field',
    )
);
   $wp_customize->add_control('guava_theme_options[guava_read_more_text_blog_archive_option]',
    array(
        'label' => esc_html__('Read More Text', 'guava'),
        'section' => 'guava-blog-layout',
        'type' => 'text',
        'priority' => 14
    )
);
/**
 * Social Share Enable Disable
 */
   $wp_customize->add_setting(
    'guava_theme_options[guava_social_share_blog_archive_option]',
    array(
        'default' => $defaults['guava_social_share_blog_archive_option'],
        'sanitize_callback' => 'guava_sanitize_checkbox',
    )
);
   $wp_customize->add_control('guava_theme_options[guava_social_share_blog_archive_option]',
    array(
        'label' => esc_html__('Social Share Option', 'guava'),
        'section' => 'guava-blog-layout',
        'type' => 'checkbox',
        'priority' => 15
    )
);

   /*adding sections for Single Post*/

   $wp_customize        -> add_section( 'guava-single-post-layout',
     array(
        'priority'       => 160,
        'capability'     => 'edit_theme_options',
        'panel'          => 'guava_theme_options',
        'title'          => __( 'Single Post Option', 'guava' )
    ) );

   /* Related post Section */
   $wp_customize          -> add_setting( 'guava_theme_options[guava-realted-post]',
     array(
        'capability'        => 'edit_theme_options',
        'default'           => $defaults['guava-realted-post'],
        'sanitize_callback' => 'guava_sanitize_checkbox'
    ) );

   $wp_customize           -> add_control('guava_theme_options[guava-realted-post]',
    array(
        'label'     => __( 'Hide/Show Related Post', 'guava'),
        'section'   => 'guava-single-post-layout',
        'settings'  => 'guava_theme_options[guava-realted-post]',
        'type'      => 'checkbox',
        'priority'  => 9
    )
);
/*-------------------------------------------------------------------------------------------*/

   /*adding sections for footer options*/

   $wp_customize-> add_section('guava-footer-option', 
    array(
        'priority'       => 170,
        'capability'     => 'edit_theme_options',
        'panel'          => 'guava_theme_options',
        'title'          => __( 'Footer Option', 'guava' )
    ) );

   /*copyright*/
   $wp_customize-> add_setting( 'guava_theme_options[guava-footer-copyright]',
      array(
        'capability'        => 'edit_theme_options',
        'default'           => $defaults['guava-footer-copyright'],
        'sanitize_callback' => 'wp_kses_post'
    ) );

   $wp_customize-> add_control( 'guava_theme_options[guava-footer-copyright]',
     array(
        'label'     => __( 'Copyright Text', 'guava' ),
        'section'   => 'guava-footer-option',
        'settings'  => 'guava_theme_options[guava-footer-copyright]',
        'type'      => 'text',
        'priority'  => 10
    ) );

