<?php

if ( is_admin() ) {
	return;
}

function BuilderExtensionSlider() {

	// Helpers
	it_classes_load( 'it-file-utility.php' );
	$this->_base_url = ITFileUtility::get_url_from_file( dirname( __FILE__ ) );

	// Printing necessary scripts
	add_action( 'wp_enqueue_scripts',  array( &$this, 'print_scripts' ) );

	// Calling only if not on a singular
	if ( ! is_singular() ) {
		add_action( 'builder_layout_engine_render', array( &$this, 'builder_extension_slider_change_render_content' ), 0 );
	}

}

function slider_ext_print_scripts() {
	wp_enqueue_script( 'slides', get_stylesheet_directory_uri() .'/extensions/slider/js/jquery.bxslider.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'builder-extension-slider', get_stylesheet_directory_uri() .'/extensions/slider/js/slides-starter.js', array( 'slides' ) );
	wp_enqueue_style( 'slider-css', get_stylesheet_directory_uri() . '/extensions/slider/css/jquery.bxslider.css' );

}

function builder_extension_slider_render_content() {

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
		'posts_per_page' => 6,
		'meta_query' => array(
			array(
				'key'     => '_thumbnail_id',
				'compare' => 'NOT EXISTS',
			)
		)
	);

	$args = wp_parse_args( $args, $wp_query->query );

	query_posts( $args );


	 if ( have_posts() ) : ?>
		<div class="loop">
			<div class="loop-content">
				<?php while ( have_posts() ) : ?>

					<?php the_post(); ?>

					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<!-- title, meta, and date info -->
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

							<?php if ( has_post_thumbnail() ) : ?>
								<div class="it-featured-image">
									<a href="<?php the_permalink(); ?>">
										<?php the_post_thumbnail( 'index_thumbnail', array( 'class' => 'index-thumbnail' ) ); ?>
									</a>
								</div>
							<?php endif; ?>

						</div>

						<!-- post content -->
						<div class="entry-content clearfix">
							<?php the_content( __( 'Read More &rarr;', 'it-l10n-Builder-Summit' ) ); ?>
						</div>

						<!-- categories, tags and comments -->
						<div class="entry-footer clearfix">
							<div class="entry-meta alignright">
							<?php do_action( 'builder_comments_popup_link', '<div class="comments">', '</div>', __( '%s', 'it-l10n-Builder-Summit' ), __( 'No Comments', 'it-l10n-Builder-Summit' ), __( '1 Comment', 'it-l10n-Builder-Summit' ), __( '% Comments', 'it-l10n-Builder-Summit' ) ); ?>
							</div>
							<div class="entry-meta alignleft">
								<?php wp_link_pages( array( 'before' => '<div class="entry-utility entry-pages">' . __( 'Pages:', 'it-l10n-Builder-Summit' ) . '', 'after' => '</div>', 'next_or_number' => 'number' ) ); ?>
								<div class="categories"><?php printf( __( 'Categories : %s', 'it-l10n-Builder-Summit' ), get_the_category_list( ', ' ) ); ?></div>
								<?php the_tags( '<div class="tags">' . __( 'Tags : ', 'it-l10n-Builder-Summit' ), ', ', '</div>' ); ?>
							</div>
							<?php edit_post_link( __( 'Edit this entry.', 'it-l10n-Builder-Summit' ), '<div class="entry-utility edit-entry-link">', '</div>' ); ?>
						</div>
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

function excerpt_length( $length ) {
	return 55;
}

function excerpt_more( $more ) {
	global $post;
	return '...<p><a href="'. get_permalink( $post->ID ) . '" class="more-link">Read More&rarr;</a></p>';
}

add_action( 'builder_layout_engine_render', 'builder_extension_slider_change_render_content', 0 );

function builder_extension_slider_change_render_content() {
	remove_action( 'builder_layout_engine_render_content', 'render_content' );
	add_action( 'builder_layout_engine_render_content', 'builder_extension_slider_render_content' );
}

function cody_test() {

	global $post;

	$args = array(
		'ignore_sticky_posts' => true,
		'posts_per_page' => '6',
	    'post_type' => 'post',
	    'meta_key' => '_thumbnail_id',
		'tax_query' => array(
			array(
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => array(
								'post-format-link', 'post-format-image', 'post-format-quote', 'post-format-gallery', 'post-format-status', 'post-format-video'
							),
				'operator' => 'NOT IN'
			)
		)
	);

	$it_slider_query = new WP_Query( $args );
	$featured_post_ids = array(); ?>

			<div class="slides-wrapper">

				<div class="bxslider">

		<?php if ( $it_slider_query->have_posts() ) : while ( $it_slider_query->have_posts() ) : $it_slider_query->the_post(); ?>
		<?php array_push($featured_post_ids, $post->ID ); ?>

			<div>
				<?php the_post_thumbnail( 'ext_slider_thumb', array( 'class' => 'ext-slider-thumbnail' ) ); ?>
				<h3><?php the_title(); ?></h3>
			</div>

		<?php endwhile; ?>

				</div>

			</div>

		<?php endif; ?>

	<?php wp_reset_postdata();

}
add_action( 'builder_module_render_contents_content', 'cody_test', -5 );


// Printing necessary scripts
add_action( 'wp_enqueue_scripts', 'slider_ext_print_scripts' );