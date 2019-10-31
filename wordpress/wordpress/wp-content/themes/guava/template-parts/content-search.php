<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package guava
 */
global $guava_theme_options;
$social_share        = $guava_theme_options['guava_social_share_blog_archive_option'];
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="guava-post-wrapper">
	   <!--post thumbnal options-->
		<div class="guava-post-thumb">
			<a href="<?php the_permalink(); ?>">
			 <?php the_post_thumbnail( 'full' ); ?>
			</a>
		</div><!-- .post-thumb-->

		<div class="content-wrap">
			<span class="post-format"></span>
			<div class="catagories">
				<?php guava_entry_footer(); ?>
			</div>

			<div class="entry-header">
				<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

				<?php if ( 'post' === get_post_type() ) : ?>
				<?php endif; ?>
			</div><!-- .entry-header -->

			<div class="entry-content">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
			<div class="entry-footer">
				<?php
				if ( 'post' === get_post_type() ) : ?>
					<div class="entry-meta">
						<?php guava_posted_on(); ?>
					</div><!-- .entry-meta -->
				<?php
				endif; ?>
				<?php
			        /**
			         * guava_social_sharing hook
			         * @since 1.0.0
			         *
			         * @hooked guava_constuct_social_sharing -  10
			         */
			        if($social_share == 1 ) :
			        	do_action( 'guava_social_sharing' ,get_the_ID() );
			    	endif;
			    ?>
			</div>

		</div>
	</div>
</article><!-- #post-## -->
