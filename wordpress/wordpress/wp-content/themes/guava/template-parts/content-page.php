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

<article class="post-wrap" id="post-<?php the_ID(); ?>" >
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'guava' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
			<footer class="entry-footer">
				<?php
					edit_post_link(
						sprintf(
							/* translators: %s: Name of current post */
							esc_html__( 'Edit %s', 'guava' ),
							the_title( '<span class="screen-reader-text">"', '"</span>', false )
						),
						'<span class="edit-link">',
						'</span>'
					);
				?>
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
			</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-## -->

