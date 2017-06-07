<?php

function summit_featured_post_extension_render_content() {

?>


	<?php // Creating a New Loop

	$args = array(
		'posts_per_page' => 1,
		'post__in' => get_option( 'sticky_posts' ),
		'ignore_sticky_posts' => 1,
		'meta_query' => array( array( 'key' => '_thumbnail_id' ) )
	);

	$test_loop = new WP_Query( $args ); ?>

	<?php if ( $test_loop->have_posts() ) : ?>
	
	<?php
		
	?>
	
		<div class="loop">
			<div class="loop-content">
				<?php while( $test_loop->have_posts() ) : ?>
					<?php $test_loop->the_post(); ?>
						<div id="post-<?php the_ID(); ?>" <?php post_class('summit-featured-post clearfix'); ?>>
							<?php if ( has_post_thumbnail() ) : ?>
								<div class="it-featured-image">
									<a href="<?php the_permalink(); ?>">
									
										<?php
											it_classes_load( 'it-file-utility.php' );
							
											$post_thumbnail_array = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
											$url = $post_thumbnail_array[0];
											$image_width = 650;
											$image_height = 550;
											$file_path = ITUtility::get_file_from_url( $url );
											$resized_image = ITFileUtility::resize_image( $file_path, $image_width, $image_height, true );
											
											echo '<img src="' . $resized_image['url'] . '" />';
										?>
<!-- 										<?php the_post_thumbnail( 'index_thumbnail', array( 'class' => 'index-thumbnail' ) ); ?> -->
									</a>
								</div>
								<div class="it-featured-image-landscape">
									<a href="<?php the_permalink(); ?>">
									
										<?php
											it_classes_load( 'it-file-utility.php' );
							
											$post_thumbnail_array = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
											$url = $post_thumbnail_array[0];
											$image_width = 800;
											$image_height = 250;
											$file_path = ITUtility::get_file_from_url( $url );
											$resized_image = ITFileUtility::resize_image( $file_path, $image_width, $image_height, true );
											
											echo '<img src="' . $resized_image['url'] . '" />';
										?>
<!-- 										<?php the_post_thumbnail( 'index_thumbnail', array( 'class' => 'index-thumbnail' ) ); ?> -->
									</a>
								</div>
							<?php endif; ?>
							<div class="it-featured-text">
								<div class="it-featured-text-inner-wrapper">
									<h3 class="entry-title clearfix">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h3>
									
									<div class="regular-excerpt">
										<?php the_excerpt(); ?>
									</div>
									
									<div class="short-excerpt">
										<?php
											function the_excerpt_max_charlength($charlength) {
												$excerpt = get_the_excerpt();
												$charlength++;
											
												if ( mb_strlen( $excerpt ) > $charlength ) {
													$subex = mb_substr( $excerpt, 0, $charlength - 5 );
													$exwords = explode( ' ', $subex );
													$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
													if ( $excut < 0 ) {
														echo mb_substr( $subex, 0, $excut );
													} else {
														echo $subex;
													}
													echo '[...]';
												} else {
													echo $excerpt;
												}
											}
										?>
										<p><?php the_excerpt_max_charlength(180); ?></p>
									</div>
									<a class="btn" href="<?php the_permalink(); ?>"><?php _e( 'Read More', 'it-l10n-Builder-Summit' ); ?></a>
								</div>
							</div>
						</div>
				<?php endwhile; // end of loop ?>
				<?php wp_reset_postdata(); // reset the loop ?>
			</div>
		</div>
	<?php else : // do not delete ?>
<!-- 		<?php do_action( 'builder_template_show_not_found' ); ?> -->
		<div class="extension-error-message clearfix">
		<h2><?php _e('Summit Featured Posts Extension Error', 'it-l10n-Builder-Summit' ); ?></h2>
		<p><strong><?php _e("You're latest post or sticky post must have a featured image for this extension to work."); ?></strong></p>
		</div>
	<?php endif; // do not delete ?>
<?php

}

/**
 * Hook into the layout engine render to remove
 * the current content and replace it with our
 * new content.
*/
function summit_featured_post_extension_render_change_content() {
	if ( ! is_single() ) {
		// Add specific CSS class by filter
	add_filter( 'body_class', 'summit_class_names' );
	function summit_class_names( $classes ) {
		// add 'class-name' to the $classes array
		$classes[] = 'summit-featured-post-enabled';
		// return the $classes array
		return $classes;
	}
		remove_action( 'builder_layout_engine_render_content', 'render_content' );
		add_action( 'builder_layout_engine_render_content', 'summit_featured_post_extension_render_content' );
	}
}
add_action( 'builder_layout_engine_render', 'summit_featured_post_extension_render_change_content', 0 );