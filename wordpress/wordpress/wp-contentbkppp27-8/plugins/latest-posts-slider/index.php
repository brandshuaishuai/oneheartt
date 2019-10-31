<?php
/*
Plugin Name: Latest Posts Slider
Description: Latest Posts Slider in recent order with carousel design. Use shortcode [latest-posts-slider]
Version: 1.1
Author: Evince Development
*/

define( 'EVDPL_LPS', plugin_dir_url( __FILE__ ) );

function evdpl_latest_posts_get($atts){

	ob_start();
	wp_enqueue_style('evdpl_lps_carousel_style',EVDPL_LPS.'assets/css/owl.carousel.min.css');
	wp_enqueue_style('evdpl_lps_carousel_theme_style',EVDPL_LPS.'assets/css/owl.theme.default.min.css');
	wp_enqueue_script('evdpl_lps_carousel_main_script',EVDPL_LPS.'assets/js/owl.carousel.min.js',array('jquery'));
	wp_enqueue_style('evdpl_lps_main_style',EVDPL_LPS.'assets/css/evdpl_lps_main.css');
	?>
	<section id="cat-slider">
		<div class="evdpl-posts-slider owl-carousel owl-theme"> 
			<?php 
			global $wp_query;

			$atts = shortcode_atts(
					array(
						'category' => '',
						'show_category_name' => '',
						'show_date' =>'',
						'show_content' =>'',
						'dots' =>'',
						'arrows' =>'',
						'show_read_more' =>'',
						'post_type' =>'',
						'limit' =>'',
					), $atts, 'category-posts' );

			$args             = array(
				'post_status'     => 'publish',
				'orderby'         => 'date',
				'order'           => 'DESC'
			);

			$args['posts_per_page'] = ($atts['limit'] ? $atts['limit'] : 10 );
			$args['category'] = ($atts['category'] ? $atts['category'] : '' );
			$args['post_type'] = ($atts['post_type'] ? $atts['post_type'] : 'post' );

			$dots = ($atts['dots'] ? $atts['dots'] : 'false');
			$arrows = ($atts['arrows'] ? $atts['arrows'] : 'true');
			$show_category_name = ($atts['show_category_name'] ? $atts['show_category_name'] : 'false');
			$show_date = ($atts['show_date`'] ? $atts['show_date`'] : 'false');
			$show_content = ($atts['show_content`'] ? $atts['show_content`'] : 'false');
			$show_read_more = ($atts['show_read_more`'] ? $atts['show_read_more`'] : 'false');
			
			$evdpl_lps_posts_data  = get_posts( $args );

			foreach($evdpl_lps_posts_data as $evdpl_lps_value){
				$post_categories = get_the_category($evdpl_lps_value->ID);
				$feature_image_thumbID = get_post_thumbnail_id($evdpl_lps_value->ID);
				$feature_image = wp_get_attachment_image_url( $feature_image_thumbID, 'medium', false ); 
			
		    ?>
				<div class="item">
					<div class="sp-pc-post-image">
						<a href="<?php echo get_permalink($evdpl_lps_value->ID); ?>">
							<?php if($feature_image){?>
								<img src="<?php echo $feature_image; ?>">
							<?php }else{?>
								<img src="<?php echo EVDPL_LPS."images/no_thumb.png" ?>">
							<?php }?>
						</a>
					</div>
					<div class="slider-post-content">
						<?php if($show_date){?>
							<span class="post-date">
								<?php 
								$date_format = get_option( 'date_format' );
								echo get_the_date($date_format,$evdpl_lps_value->ID); ?>
							</span>
						<?php }?>	
						<h2 class="sp-pc-post-title">
							<a href="<?php echo get_permalink($evdpl_lps_value->ID); ?>">
								<?php echo $evdpl_lps_value->post_title; ?>
							</a>
						</h2>
						<?php 
						if($show_category_name){ 
							$i = 0;
							foreach ($post_categories as $key => $value) { ?>
								<span class="category-name" id="<?php echo "id".$i;?>">
									<?php echo $value->name;?>
								</span>
						<?php 
							$i++;
							}	
						}
						if($show_content){ ?>
							<p><?php echo $evdpl_lps_value->post_excerpt ?></p>
						<?php }
						if($show_read_more){?>
							<a href="<?php echo get_permalink($evdpl_lps_value->ID); ?>" class="read-more">Read More</a>
						<?php }?>
					</div>
				</div>
			<?php
			}
			wp_reset_postdata();
			?>
		</div>
	</section>
	
	<?php
	
	wp_enqueue_script('inline_evdpl_lps', EVDPL_LPS . 'assets/js/evdpl_lps_main.js',array('jquery'));
	wp_localize_script('inline_evdpl_lps', 'evdpl_lps_script_vars', array(
			'owl_arrows' => $arrows,
			'owl_dots' => $dots
		)
	);
	//wp_reset_postdata();
	return ob_get_clean();
}

add_shortcode('latest-posts-slider', 'evdpl_latest_posts_get');
?>