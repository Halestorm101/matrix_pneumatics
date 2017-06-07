<?php
/**
 * This file initializes the image grid extension,
 * but only loads when an extension is active.
 *
 * @author Justin Kopepasah
 * @package builder-core
*/

/**
 * Use the init hook to add image sizes for the
 * extension.
*/
function builder_core_extension_image_grid_add_image_size() {
	add_image_size( 'it-gallery-thumb', 400, 250, true );
	add_image_size( 'it-gallery-singular', 300, 250, true );
}
add_action( 'init', 'builder_core_extension_image_grid_add_image_size' );


/**
 * Set up the new content for the extension.
*/
function builder_core_extension_image_grid_render_content() {
	global $post, $wp_query;

	$directory_uri = get_template_directory_uri() . '/lib/builder-core/extensions/image-grid/';

	$args = array(
		'ignore_sticky_posts' => true,
		'posts_per_page'      => 6,
		'meta_key'            => '_thumbnail_id',
		'paged'               => get_query_var( 'paged' ),
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
	);

	$args = wp_parse_args( $args, $wp_query->query );

	query_posts( $args );
?>
	<?php if ( have_posts() ) : ?>
		<div class="loop">
			<div class="loop-content">
				<?php while ( have_posts() ) : ?>

					<?php the_post(); ?>
					<div id="post-<?php the_ID(); ?>" <?php post_class('image-grid-extension'); ?>>

						<?php if ( has_post_thumbnail() ) : ?>
							<div class="it-featured-image">
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail( 'index_thumbnail', array( 'class' => 'index-thumbnail' ) ); ?>
								</a>
							</div>
						<?php endif; ?>

					</div>

				<?php endwhile; ?>
			</div>

			<div class="loop-footer">
				<div class="loop-utility clearfix">
					<div class="alignleft"><?php previous_posts_link( __( '&larr; Previous Page' , 'it-l10n-Builder-Summit' ) ); ?></div>
					<div class="alignright"><?php next_posts_link( __( 'Next Page &rarr;', 'it-l10n-Builder-Summit' ) ); ?></div>
				</div>
			</div>
		</div>
	<?php else : ?>
		<?php do_action( 'builder_template_show_not_found' ); ?>
	<?php endif; ?>
<?php

}

/**
 * Hook into the layout engine render to remove
 * the current content and replace it with our
 * new content, but only if we are not viewing a
 * singluar item.
*/
function builder_core_extension_image_grid_change_render_content() {
	if ( ! is_singular() ) {
		remove_action( 'builder_layout_engine_render_content', 'render_content' );
		add_action( 'builder_layout_engine_render_content', 'builder_core_extension_image_grid_render_content' );
	}
}
add_action( 'builder_layout_engine_render', 'builder_core_extension_image_grid_change_render_content', 0 );