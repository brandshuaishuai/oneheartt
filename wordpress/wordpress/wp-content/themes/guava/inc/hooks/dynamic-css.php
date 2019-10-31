<?php
/**
 * Dynamic css
 *
 * @package Canyon Themes
 * @subpackage Guava
 *
 * @param null
 * @return void
 *
 */
if ( !function_exists('guava_dynamic_css') ):
  function guava_dynamic_css(){
    $guava_theme_options  = guava_get_theme_options();
    
    /*====================
    Basic Color
    =====================*/

    $guava_primary_color = $guava_theme_options['guava_primary_color'];

    /*====================
    Paragraph Typography
    =====================*/
    $guava_paragraph_font_family= $guava_theme_options['guava_paragraph_font_family'];
    
    $custom_css = '';
    //Primary Color 

    $custom_css .= " 
    .pagination .page-numbers,
    .widget_meta ul li a:hover,
    .promo-area a .category,
    .promo-area a .entry-title:hover,
    .entry-header .entry-title a:hover,
    .pagination .page-numbers,
    .widget li a:hover,
    .main-navigation ul li.current-menu-item a, 
    .main-navigation ul li a:hover,
    .site-title a, 
    p.site-description{
      color: " . $guava_primary_color . ";
    }";

    $custom_css .= "
    .submit,
    .search-submit,
    #featured-slider .categories,
    .scrollToTop, 
    .more-area a,
    .widget .search-submit,
    article.format-standard .content-wrap .post-format::after, 
    article.format-image .content-wrap .post-format::after, 
    article.hentry.sticky .content-wrap .post-format::after, 
    article.format-video .content-wrap .post-format::after, 
    article.format-gallery .content-wrap .post-format::after, 
    article.format-audio .content-wrap .post-format::after, 
    article.format-quote .content-wrap .post-format::after{
      background: ". $guava_primary_color . "!important;
    }"; 


  /*==================== Paragraph Typography=====================*/

  $custom_css .= "body {

         font-family: ". $guava_paragraph_font_family . ";
       }

    ";  

    /*custom css*/
    wp_add_inline_style('guava-style', $custom_css);
  }
endif;
add_action('wp_enqueue_scripts', 'guava_dynamic_css', 99);