<?php

if ( is_admin() )
	return;

if ( ! class_exists( 'BuilderExtensionTeasersRight' ) ) {
	class BuilderExtensionTeasersRight {

		function __construct() {

			// Helpers
			it_classes_load( 'it-file-utility.php' );
			$this->_base_url = ITFileUtility::get_url_from_file( dirname( __FILE__ ) );

			// Calling only if not on a singular
			if ( ! is_singular() ) {
				add_action( 'builder_layout_engine_render', array( &$this, 'change_render_content' ), 0 );
			}
		}

		function extension_render_content() {
			add_filter( 'excerpt_length', array( &$this, 'excerpt_length' ) );
			add_filter( 'excerpt_more', array( &$this, 'excerpt_more' ) );

			global $post, $wp_query;

			// WP_Query arguments
			$args = array(
			    'post_type' => 'post',
				'tax_query' => array(
					array(
						'taxonomy' => 'post_format',
						'field' => 'slug',
						'terms' => array(
										'post-format-link', 'post-format-image', 'post-format-quote', 'post-format-gallery', 'post-format-status', 'post-format-video'
									),
						'operator' => 'NOT IN'
					)
				),
				'posts_per_page' => 5
			);

			$args = wp_parse_args( $args, $wp_query->query );

			query_posts( $args );

		?>
			<?php if ( have_posts() ) : ?>
				<div class="loop">
					<div class="loop-content">
						<?php while ( have_posts() ) : // the loop ?>
							<?php the_post(); ?>

							<div id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

									<?php if ( has_post_thumbnail() ) : ?>
										<div class="it-featured-image">
											<a href="<?php the_permalink(); ?>">
												<?php the_post_thumbnail( 'index_thumbnail', array( 'class' => 'index-thumbnail' ) ); ?>
											</a>
										</div>
									<?php endif; ?>

									<div class="main-content-wrapper">

									<div class="entry-header clearfix">

										<h3 class="entry-title clearfix">
											<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
										</h3>

										<div class="entry-meta-wrapper clearfix">
											<!-- meta, and date info -->
											<div class="entry-meta">
												<?php printf( __( 'Posted by %s on', 'it-l10n-Builder-Summit' ), '<span class="author">' . builder_get_author_link() . '</span>' ); ?>
											</div>

											<div class="entry-meta date">
												<a href="<?php the_permalink(); ?>">
													<span>&nbsp;<?php echo get_the_date(); ?></span>
												</a>
											</div>

											<div class="entry-meta">
												<?php do_action( 'builder_comments_popup_link', '<span class="comments">&nbsp; &middot; ', '</span>', __( '%s', 'it-l10n-Builder-Summit' ), __( 'No Comments', 'it-l10n-Builder-Summit' ), __( '1 Comment', 'it-l10n-Builder-Summit' ), __( '% Comments', 'it-l10n-Builder-Summit' ) ); ?>
											</div>
										</div>

									</div>

									<?php the_excerpt(); ?>

									</div>

							</div>
							<!-- end .post -->
						<?php endwhile; // end of one post ?>
					</div>
					<!-- Previous/Next page navigation -->
					<div class="loop-footer">
						<div class="loop-utility clearfix">
							<div class="alignleft"><?php previous_posts_link( __( '&larr; Previous Page' , 'it-l10n-Builder-Summit' ) ); ?></div>
							<div class="alignright"><?php next_posts_link( __( 'Next Page &rarr;', 'it-l10n-Builder-Summit' ) ); ?></div>
						</div>
					</div>
				</div>
			<?php else : // do not delete ?>
				<?php do_action( 'builder_template_show_not_found' ); ?>
			<?php endif; // do not delete ?>
		<?php
			remove_filter( 'excerpt_length', array( &$this, 'excerpt_length' ) );
			remove_filter( 'excerpt_more', array( &$this, 'excerpt_more' ) );
		}

		function excerpt_length( $length ) {
			return 60;
		}

		function excerpt_more( $more ) {
			global $post;
			return '...<p><a href="'. get_permalink( $post->ID ) . '" class="more-link">Read More&rarr;</a></p>';
		}

		function change_render_content() {
			remove_action( 'builder_layout_engine_render_content', 'render_content' );
			add_action( 'builder_layout_engine_render_content', array( &$this, 'extension_render_content' ) );
		}

	} // end class

	$BuilderExtensionTeasersRight = new BuilderExtensionTeasersRight();
}
