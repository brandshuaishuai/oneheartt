<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package guava
 */
global $guava_theme_options;
$no_of_column         = $guava_theme_options['guava_columns_option'];
$readmore_text        = $guava_theme_options['guava_read_more_text_blog_archive_option'];
$social_share        = $guava_theme_options['guava_social_share_blog_archive_option'];
?>

<article class="<?php echo esc_attr( $no_of_column ) .' '.join( ' ', get_post_class('masonry-entry') ) ?>" id="post-<?php the_ID(); ?>" >
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
			<span class="post-format"></span>
			<div class="catagories">
				<?php guava_entry_blog(); ?>
			</div>

			<div class="entry-header">
				<?php
				if ( is_single() ) :
					the_title( '<h1 class="entry-title">', '</h1>' );
				else :
					the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				endif; ?>
			</div><!-- .entry-header -->

			<div class="authorinfo text-left">
				<?php
				if ( 'post' === get_post_type() ) : ?>
					<div class="entry-meta">
						<?php guava_blog_posted_on(); ?>
					</div><!-- .entry-meta -->
					<?php
				endif; ?>
			</div>

			<div class="entry-content">
				<?php the_excerpt(); ?>
			</div><!-- .entry-content -->
			<div class="entry-footer">
				<?php
				if(!empty($readmore_text ))
				{
					?>
					<div class=" more-area text-left">
						<a href="<?php the_permalink(); ?>">
							<?php echo esc_html ( $readmore_text ); ?> <i class="fa fa-angle-double-right"></i></a>
						</div>
					<?php  } ?>	
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

