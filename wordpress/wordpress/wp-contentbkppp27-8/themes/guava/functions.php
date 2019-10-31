<?php
/**
 * guava functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package guava
 */

if ( ! function_exists( 'guava_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function guava_setup() 
{
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on guava, use a find and replace
	 * to change 'guava' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'guava');

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	* Enable support for Post Formats.
	*
	* See: https://codex.wordpress.org/Post_Formats
	*/
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'status',
		'audio',
		'chat',
	) );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

    add_image_size( 'guava-promo-post', 360, 261, array( 'left', 'bottom' ) ); //(cropped)
	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'guava' ),
		'social' => esc_html__( 'Social', 'guava' ),
	) );

	/*
	 * Theme custom logo
	 */
	add_theme_support( 'custom-logo', array(
        'flex-width'  => true,
    ) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'guava_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}

endif;
add_action( 'after_setup_theme', 'guava_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function guava_content_width() 
{
	$GLOBALS['content_width'] = apply_filters( 'guava_content_width', 640 );
}
add_action( 'after_setup_theme', 'guava_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function guava_widgets_init() 
{
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'guava' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'guava' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer One', 'guava' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Add widgets here', 'guava' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Two', 'guava' ),
		'id'            => 'footer-2',
		'description'   => esc_html__( 'Add widgets here', 'guava' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Three', 'guava' ),
		'id'            => 'footer-3',
		'description'   => esc_html__( 'Add widgets here', 'guava' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Four', 'guava' ),
		'id'            => 'footer-4',
		'description'   => esc_html__( 'Add widgets here', 'guava' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );
}
add_action( 'widgets_init', 'guava_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function guava_scripts()
{
 global $guava_theme_options;
   
    $guava_theme_options    = guava_get_theme_options();

    $sticky_menu            = wp_kses_post( $guava_theme_options['show_sticky_menu'] );

    $body_font_name         = wp_kses_post( $guava_theme_options['guava_paragraph_font_url'] );

    if(!empty( $body_font_name ))
    {
      	/*google font  */
        wp_enqueue_style( 'guava-body-font', $body_font_name, array(), null );
    }
  wp_enqueue_style( 'guava-googleapis', 'https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Lora:300,400,600,700|Roboto+Condensed:400,700&display=swap', array(), null );
	
	/*Font-Awesome-master*/
    wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/framework/Font-Awesome/css/font-awesome.min.css', array(), '4.5.0' );
	
	/*Bootstrap CSS*/
    wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/framework/bootstrap/css/bootstrap.min.css', array(), '4.5.0' );
	
	/*Owl CSS*/
    wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/assets/framework/owl-carousel/owl.carousel.css', array(), '4.5.0' );
	
	/*Style CSS*/
	wp_enqueue_style( 'guava-style', get_stylesheet_uri() );

       global $guava_theme_options;
       $masonry = $guava_theme_options['guava_columns_option'];
	
     if($masonry =="col-sm-6" || $masonry =="col-sm-4"  )
    {

     wp_enqueue_script( 'masonry' );
     
     wp_enqueue_script('guava-custom-masonary', get_template_directory_uri() . '/assets/js/custom-masonary.js', array('jquery'), '201765', true);
    }
    /*Bootstrap JS*/
    wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/framework/bootstrap/js/bootstrap.min.js', array('jquery'), '4.5.0' );
	
	/*navigation JS*/
	wp_enqueue_script( 'guava-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array('jquery'), '20151215', true );

	/*owl*/
    wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/assets/framework/owl-carousel/owl.carousel.min.js', array('jquery'), '4.5.0' );
	
  
   if( $sticky_menu == 1)   
  {
       wp_enqueue_script( 'guava-sticky_menu ', get_template_directory_uri() . '/assets/js/sticky-menu.js', array('jquery'), '4.5.0' );
    }
    
   /*Sticky Sidebar js*/
    wp_enqueue_script( 'sticky-sidebar', get_template_directory_uri() . '/assets/js/theia-sticky-sidebar.js', array('jquery'), '4.5.0' );

	/*Custom JS*/
	wp_enqueue_script( 'scripts', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), '4.5.0' );
	

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) 
	{
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'guava_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Loading related post file
 */

require get_template_directory() . '/inc/hooks/related-post.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Loading breadcrumbs File.
 */

if (!function_exists('breadcrumb_trail')) {
 
   require get_template_directory() . '/inc/library/breadcrumbs/breadcrumbs.php';

}
/**
 * Loading page-breadcrumbs in pages/posts
 */

require get_template_directory() . '/inc/hooks/page-breadcrumbs.php';


/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


/**
 * Load theme-function  file.
 */
require get_template_directory() . '/inc/theme-function.php';

/**
* Load Update to Pro section
*/
require get_template_directory() . '/inc/customizer-pro/class-customize.php';

/**
 * Load Custom widget File.
 */
require get_template_directory() . '/inc/custom-widget/author-widget.php';

/**
 * Load Custom widget File.
 */
require get_template_directory() . '/inc/custom-widget/recent-posts.php';

require get_template_directory() . '/inc/custom-widget/social-widget.php';

/**
 * Dynamic CSS File.
 */
require get_template_directory() . '/inc/hooks/dynamic-css.php';
/**
 * Admin Enqueue scripts and styles.
 */
if ( ! function_exists( 'guava_admin_scripts' ) ) {
    function guava_admin_scripts($hook) {
        if( 'widgets.php' != $hook )
            return;
        if (function_exists('wp_enqueue_media')){
            wp_enqueue_media();
        }       
        wp_enqueue_style( 'font-awesome', get_template_directory_uri().'/assets/framework/Font-Awesome/css/font-awesome.min.css' );
    }
}
add_action('admin_enqueue_scripts', 'guava_admin_scripts');
