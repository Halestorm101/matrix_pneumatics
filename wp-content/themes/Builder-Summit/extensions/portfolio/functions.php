<?php

if ( is_admin() )
	return;

if ( ! class_exists( 'BuilderExtensionPortfolioLayout' ) ) {
	class BuilderExtensionPortfolioLayout {

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
				'posts_per_page' => 6
			);

			$args = wp_parse_args( $args, $wp_query->query );

			query_posts( $args );

		?>

			<?php if ( have_posts() ) : ?>
				<div class="loop">
					<div class="loop-content">
						<?php while ( have_posts() ) : // the loop ?>
							<?php the_post(); ?>

							<div id="post-<?php the_ID(); ?>" <?php post_class('portfolio-extension'); ?>>
								<!-- title, meta, and date info -->
								<div class="entry-header clearfix">

									<?php if ( has_post_thumbnail() ) : ?>
										<div class="it-featured-image">
											<a href="<?php the_permalink(); ?>">
												<?php the_post_thumbnail( 'index_thumbnail', array( 'class' => 'index-thumbnail' ) ); ?>
											</a>
										</div>
									<?php endif; ?>

									<h3 class="entry-title clearfix">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h3>

									<div class="entry-meta-wrapper clearfix">
										<div class="categories"><?php printf( __( '%s', 'it-l10n-Builder-Summit' ), get_the_category_list( ', ' ) ); ?></div>
									</div>

								</div>

								<?php edit_post_link( __( 'Edit this entry.', 'it-l10n-Builder-Summit' ), '<div class="entry-utility edit-entry-link">', '</div>' ); ?>

							</div>

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

		}

		function change_render_content() {
			remove_action( 'builder_layout_engine_render_content', 'render_content' );
			add_action( 'builder_layout_engine_render_content', array( &$this, 'extension_render_content' ) );
		}

	} // end class

	$BuilderExtensionPortfolioLayout = new BuilderExtensionPortfolioLayout();
}