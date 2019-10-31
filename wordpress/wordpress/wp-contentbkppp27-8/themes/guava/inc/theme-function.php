<?php
/**
* Select Images according to Category saved.
*
* @since Guava 1.0.0
*
* @param null
* @return null
*
*/
if ( !function_exists('guava_slider_images_selection') ) :
  function guava_slider_images_selection() 
  { 
    global $guava_theme_options;

    $category_name=$guava_theme_options['guava-feature-cat'];

    $category_name          = $guava_theme_options['guava-feature-cat'];

    $selected_opt           = $guava_theme_options['slider-options'];

    $no_of_post             = $guava_theme_options['guava_no_of_slider'];

    if( $selected_opt == 'category' )
    {
     $args = array( 'cat' => $category_name , 'posts_per_page' =>  $no_of_post   );
   }
   elseif ( $selected_opt == 'recent-posts' ) {
    $args = array( 'post_type' => 'post' , 'posts_per_page' =>   $no_of_post   );
  }


  $query = new WP_Query($args);

  if($query->have_posts()):

    while($query->have_posts()):

     $query->the_post();
     if(has_post_thumbnail())
     {

       $image_id = get_post_thumbnail_id();
       $image_url = wp_get_attachment_image_src($image_id,'',true);
       ?>
       <div class="feature-area">
        <a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url($image_url[0]);?>" alt=""></a>
        <div class="feature-description text-center">
          <figcaption>
            <?php get_the_author(); ?>
            <a href="" class="categories">
              <span>
                <?php 
                $categories = get_the_category();
                if ( ! empty( $categories ) ) 
                {
                  echo esc_html( $categories[0]->name );   
                }
                ?>
              </span>
            </a>
            <a href="<?php the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
            <div class="entry-meta">
              <?php guava_blog_posted_on(); ?>
            </div><!-- .entry-meta -->
          </figcaption>

        </div>
      </div>
      

      <?php 
    }
  endwhile; endif;wp_reset_postdata();
}
endif;

/*
* Remove [...] from default fallback excerpt content
*
*/
function guava_excerpt_more( $more ) {
	if(is_admin())
	{
		return $more;
	}
	return '';
}
add_filter( 'excerpt_more', 'guava_excerpt_more'); 

if ( !function_exists('guava_single_pagination') ) :
  function guava_single_pagination() 
  {  ?>
    <div class="pagination">
      <?php
      global $wp_query;
            $big = 999999999; // need an unlikely integer
            echo paginate_links(array(
              'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
              'format' => '?paged=%#%',
              'current' => max(1, get_query_var('paged')),
              'total' => $wp_query->max_num_pages,
              'prev_text' => __('&laquo;','guava'),
              'next_text' => __('&raquo;','guava'),
            ));
            
            ?>
          </div>
        <?php } endif; ?>

        <?php
/**
 * Social Sharing Hook *
 * @since 1.0.0
 *
 * @param int $post_id
 * @return void
 *
 */
if ( !function_exists('guava_constuct_social_sharing') ) :
  function guava_constuct_social_sharing($post_id) {
    $guava_url = get_the_permalink($post_id);
    $guava_title = get_the_title($post_id);
    $guava_image = get_the_post_thumbnail_url($post_id);

        //sharing url
    $guava_twitter_sharing_url = esc_url('http://twitter.com/share?text='.$guava_title.'&url='.$guava_url);
    $guava_facebook_sharing_url = esc_url('https://www.facebook.com/sharer/sharer.php?u='.$guava_url);
    $guava_pinterest_sharing_url = esc_url('http://pinterest.com/pin/create/button/?url='.$guava_url.'&media='.$guava_image.'&description='.$guava_title);
    $guava_linkedin_sharing_url = esc_url('http://www.linkedin.com/shareArticle?mini=true&title=' . $guava_title . '&url=' . $guava_url);

    ?>
    <div class="meta_bottom">
      <div class="text_share header-text"><?php _e('Share This Post &nbsp:&nbsp', 'guava');?> <a href=""><i class="fa fa-share-alt"></i></a></div>
      <div class="post-share">
        <a target="_blank" href="<?php echo $guava_facebook_sharing_url; ?>"><i class="fa fa-facebook"></i></a>
        <a target="_blank" href="<?php echo $guava_twitter_sharing_url; ?>"><i class="fa fa-twitter"></i></a>
        <a target="_blank" href="<?php echo $guava_pinterest_sharing_url; ?>"><i class="fa fa-pinterest"></i></a>
        <a target="_blank" href="<?php echo $guava_linkedin_sharing_url; ?>"><i class="fa fa-linkedin"></i></a>
      </div>
    </div>
    <?php
  }
endif;
add_action( 'guava_social_sharing', 'guava_constuct_social_sharing', 10 );