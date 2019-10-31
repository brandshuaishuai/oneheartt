<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package guava
 */
global $guava_theme_options;
$social_share        = $guava_theme_options['guava_social_share_blog_archive_option'];
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="guava-post-wrapper <?php if ( !has_post_thumbnail () ) { echo "no-feature-image"; } ?>">
		<!--post thumbnal options-->
		<div class="guava-post-thumb">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'full' ); ?>
			</a>
		</div><!-- .post-thumb-->
		<div class="single-content-wrap content-wrap">
			<span class="post-format"></span>
			<div class="catagories">
				<?php guava_entry_footer(); ?>
			</div>

			<div class="entry-header">
				<?php
				if ( is_single() ) :
					the_title( '<h1 class="entry-title">', '</h1>' );
				else :
					the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				endif; ?>
			</div><!-- .entry-header -->
			<div class="entry-footer">
				<?php
				if ( 'post' === get_post_type() ) : ?>
					<div class="entry-meta">
						<?php guava_posted_on(); ?>
					</div><!-- .entry-meta -->
					<?php
				endif; ?>
			</div>

			<div class="entry-content">
				<?php
				the_content( sprintf(
					/* translators: %s: Name of current post. */
					wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'guava' ), array( 'span' => array( 'class' => array() ) ) ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				) );

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'guava' ),
					'after'  => '</div>',
				) );
				?>
			</div><!-- .entry-content -->
			<div class="entry-footer">
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