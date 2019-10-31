<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Canyon Themes
 * @subpackage Guava
 */

if (!function_exists('breadcrumb_type')) :

    function breadcrumb_type($post_id)
    {
       $guava_theme_options   = guava_get_theme_options();
       $breadcrumb_type       = $guava_theme_options['breadcrumb_option'];

        if(  $breadcrumb_type == 'simple' )
        {
?>    
            <!--breadcrumb-->
            <div class="col-sm-12 col-md-12 ">
              <div class="breadcrumb">
                <?php  breadcrumb_trail(); ?>
              </div>
            </div>
            <!--end breadcrumb-->    
            <?php  
        }  
    }
endif;

add_action('breadcrumb_type', 'breadcrumb_type', 10, 1);    