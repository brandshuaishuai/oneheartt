<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package guava
 */
global $guava_theme_options;
$guava_theme_options    = guava_get_theme_options();
$category_id            = $guava_theme_options['guava-promo-cat'];
$selected_opt           = $guava_theme_options['slider-options'];
$logo_position          = $guava_theme_options['site_identity']; 
$feat_cat_id            = absint($guava_theme_options['guava-feature-cat']);
$feat_tagline           = esc_html($guava_theme_options['guava_promo_tagline_option']);
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>

</head>

<body <?php body_class('at-sticky-sidebar');?>>
<?php
if ( function_exists( 'wp_body_open' ) ) {
	wp_body_open();
}
?>
<div id="page">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'guava' ); ?></a>
	<header id="masthead" class="site-header" role="banner">
		<div class="section-menu">		
			<div class="container">
				<nav id="site-navigation" class="main-navigation navbar" role="navigation">
						<!-- Brand and toggle get grouped for better mobile display -->
					    <div class="navbar-header">
					      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					        <span class="sr-only"><?php esc_html_e('Toggle navigation','guava') ?></span>
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
					      </button>
					    </div>

						
						<div class="header-nav">
							<div class="collapse navbar-collapse navbar-left" id="bs-example-navbar-collapse-1">
								<?php
								    if (has_nav_menu('primary')) 

								    { 
								       wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) );
								    }   
								   ?>
							</div><!-- /.navbar-collapse -->

							<div class="top-right">
								<div class="social-links top-header-social">
		                           <?php 
		                               if (has_nav_menu('social')) 

								       {
		                                   wp_nav_menu( array( 'theme_location' => 'social', 'menu_id' => 'social-menu' ) ); 
	   									}

		                                ?>
							    </div>
							    <div class="search-wrapper">
									<i class="fa fa-search"></i>
									<div class="search-form-wrapper">
										<?php get_search_form(); ?>
									</div>
								</div>
							</div>
						</div>
				</nav>
			</div>
		</div>
		<div class="logo-section">
			<div class="container">
				<div class="guava-logo">
			    	<div class="logo-center">		
					 	<?php	if($logo_position == 'logo-only' )
		 					{

		 						the_custom_logo();

		 					}

		 					elseif( $logo_position == 'logo-desc' )
		 					{
		 						the_custom_logo();

		 						$description = get_bloginfo( 'description', 'display' );

		 						if ( $description || is_customize_preview() ) : ?>

		                            <p class="site-description"><?php echo $description; ?></p>

		                            <?php
		                       
		                        endif; 

		 					}

		 					elseif( $logo_position == 'logo-title' )
		 					{
	                          
	                         ?>
	                        <div class="guava-logo-text">
	                        	<?php  the_custom_logo(); ?>
						  
						        <h1 class="site-title">
						       	  <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
						       	</h1>  

						    </div>   
	                    <?php
		 				    }		
		 			 ?>		
					</div>		 
				</div>	 
	            <?php
	                if( $logo_position == 'title-text' )
					    { 
						    ?>
		                    <div class="guava-logo-text">
							  
							    <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>

		 						<?php
		                           $description = get_bloginfo( 'description', 'display' );

		                         if ( $description || is_customize_preview() ) : ?>

		                            <p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>

		                            <?php
		                         endif; ?>
		                    </div>
							<?php
	                    }

	                	elseif( $logo_position == 'logo-title-desc' ){ 
	                    	?>
	                    	<div class="guava-logo-text">
	                    		<?php  the_custom_logo(); ?>
						  
							    <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>

		 						<?php
		                           $description = get_bloginfo( 'description', 'display' );

		                         if ( $description || is_customize_preview() ) : ?>

		                              <p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>

		                            <?php
	                            endif; ?>
	                        </div>
	                  	<?php  }
	            ?>		
			</div>
		</div>
	</header><!-- #masthead -->
	<?php 
	if (is_front_page() || is_home()  ) {

	  if( $selected_opt == 'category' || $selected_opt == 'recent-posts')
	
	{ 

	?>

	<section  class="owl-wrapper clearfix">
		<div class="container">
			<div id="featured-slider">
				<?php 
			     

                  if( $selected_opt == 'category' || $selected_opt == 'recent-posts')
                  {
                  	guava_slider_images_selection();               
                  }
				 ?>	
			</div>
		</div>
	</section>

	<?php } }
	if( $category_id > 0 && is_home() )
		{ ?>
			<section class="promo-area">
			  <?php if ( is_front_page() && is_home() )
			   {  ?>
					<div class="container">
						<?php if(!empty($feat_tagline)) { ?>
							<h2 class="text-center"><?php echo esc_html( $feat_tagline ); ?>
							</h2>
						<?php } ?>
						<div class="promo-slider owl-theme">
								<?php
								$args = array( 'cat' => $category_id , 'posts_per_page' => 10,'order'=> 'DESC' );

								  $query = new WP_Query($args);

								  if($query->have_posts()):

									while($query->have_posts()):

									 $query->the_post();
							?>

									<div class="item">
										<a href="<?php the_permalink(); ?>">
										<?php

										 if(has_post_thumbnail())
									   {

											 $image_id  = get_post_thumbnail_id();
											 $image_url = wp_get_attachment_image_src($image_id,'guava-promo-post',true);
                                        ?>

											<figure>
												<img src="<?php echo esc_url($image_url[0]);?>">
											</figure>
								<?php   } ?>

											<div class="category">
												<?php $posttags = get_the_tags();

												if( !empty( $posttags ))
												{
												?>
													
													<?php
														$count = 0;
														if ( $posttags ) 
														{
														  foreach( $posttags as $tag )
														   {
																$count++;
																if ( 1 == $count )
																  {
																   echo $tag->name;
															      }
														    }
									                    } ?>
												<?php   } ?>
											</div>
											<span class="entry-title"><?php the_title(); ?></span>
										</a>
									</div>

							<?php    endwhile; endif; wp_reset_postdata(); ?>

						</div>
					</div>
		      <?php } ?>
			</section>
<?php   } ?>
	<div id="content" class="site-content">
		<div class="container">
			<div class="row">