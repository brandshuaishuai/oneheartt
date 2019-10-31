<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package guava
 */

get_header();

/**
* Hook - breadcrumb_type.
*
* @hooked breadcrumb_type
*/
do_action( 'breadcrumb_type' );

global $guava_theme_options;
$masonry = $guava_theme_options['guava_columns_option'];

$designlayout = $guava_theme_options['guava-layout'];
$side_col     = 'right-s-bar ';
if( 'left-sidebar' == $designlayout ){
  $side_col = 'left-s-bar';
}
?>

<div id="primary" class="content-area col-sm-8 <?php echo $side_col; ?>">
  <main id="main" class="site-main" role="main">
   <div class="row">

    <header class="page-header">
      <?php
      the_archive_title( '<h1 class="page-title">', '</h1>' );

      ?>
    </header><!-- .page-header -->


    <?php if($masonry =="col-sm-6" || $masonry =="col-sm-4"  ){ ?> 
     <div id="masonry-loop">
      <?php
    }


    if ( have_posts() ) : ?>



     <?php
     /* Start the Loop */
     while ( have_posts() ) : the_post();

        /*
         * Include the Post-Format-specific template for the content.
         * If you want to override this in a child theme, then include a file
         * called content-___.php (where ___ is the Post Format name) and that will be used instead.
         */
        get_template_part( 'template-parts/content', get_post_format() );

      endwhile;
     if( $masonry =="col-sm-6" || $masonry =="col-sm-4"  ) {
       ?>
     </div>
     <?php
   } ?>
   <div class="col-sm-12 text-center">
    <?php guava_single_pagination(); ?>
  </div>  
  <?php
else :

 get_template_part( 'template-parts/content', 'none' );

endif; ?>
</div>  
</main><!-- #main -->
</div><!-- #primary -->
<?php 
get_sidebar(); 
get_footer();
