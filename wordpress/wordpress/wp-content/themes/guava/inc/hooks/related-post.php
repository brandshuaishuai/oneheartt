<?php
/**
 * Related Post
 *
 * @since Guava 1.0.0
 *
 * @param null
 * @return void
 *
 */


if (!function_exists('guava_related_post_below')) :

    function guava_related_post_below($post_id)
    {
        global $guava_theme_options;
        $guava_theme_options       =  guava_get_theme_options();
        $related_post_hide_option  =  $guava_theme_options['guava-realted-post'];       
        if ( 0 == $related_post_hide_option)

        {
            return;
        }


        $categories = get_the_category($post_id);

        if ($categories)
        {
            $category_ids = array();

            foreach ($categories as $category)
            {
                $category_ids[] = $category->term_id;
                $category_name[] = $category->slug;
            }

            $guava_plus_cat_post_args = array(
                'category__in' => $category_ids,
                'post__not_in' => array($post_id),
                'post_type' => 'post',
                'posts_per_page' => 3,
                'post_status' => 'publish',
                'ignore_sticky_posts' => true
            );
            $guava_plus_featured_query = new WP_Query($guava_plus_cat_post_args);
            ?>
            <div class="related-post news-block">
                <h1 class="entry-title">
                    <?php esc_html_e('Related Posts', 'guava'); ?>
                </h1>
                <div class="row">
                    <?php
                    while ($guava_plus_featured_query->have_posts()) :
                        $guava_plus_featured_query->the_post(); ?>
                        <article class="col-sm-4" id="post-<?php the_ID(); ?>" <?php post_class(); ?>">
                            <div class="guava-post-wrapper <?php if ( !has_post_thumbnail () ) { echo "no-feature-image"; } ?>">
                             <!--post thumbnal options-->
                             <?php if ( has_post_thumbnail () ) 
                             { ?>
                                <div class="guava-post-thumb post-thumb">
                                    <a href="<?php the_permalink(); ?>">
                                       <?php the_post_thumbnail( 'full' ); ?>
                                   </a>
                               </div><!-- .post-thumb-->
                           <?php } ?>
                           <div class="content-wrap">
                            <div class="catagories">
                                <?php guava_entry_footer(); ?>
                            </div>

                            <div class="entry-header">
                                <?php
                                if ( is_single() ) :

                                    the_title( '<h1 class="entry-title">', '</h1>' );
                                else :
                                    the_title( '<h2 class="entry-title"><a href="' . esc_url( the_permalink() ) . '" rel="bookmark">', '</a></h2>' );
                                endif; ?>
                            </div><!-- .entry-header -->

                            <!-- .entry-content -->
                        </div>


                    </div>
                </article><!-- #post-## -->
            <?php endwhile;
            wp_reset_postdata();
            ?>
        </div>
    </div>
    <?php
}
}
endif;

add_action('guava_related_posts', 'guava_related_post_below', 10, 1);