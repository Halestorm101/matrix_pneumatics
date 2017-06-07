<?php

/* This file can be used to add additional functionality and customization to this Extension */


function builder_extension_magazine_print_scripts() {
	it_classes_load( 'it-file-utility.php' );
	$base_url = ITFileUtility::get_url_from_file( dirname( __FILE__ ) );
	
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'builder_magazine_script', "$base_url/js/script.js" );
}
add_action( 'wp_print_scripts', 'builder_extension_magazine_print_scripts' );

function builder_extension_magazine_render_content() {
	
?>
	<?php if ( have_posts() ) : ?>
		<div class="loop">
			<div class="loop-content">
				<?php while ( have_posts() ) : // the loop ?>
					<?php the_post(); ?>
					
					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<!--Title/Date/Meta-->
						<div class="entry-header clearfix">
							<?php if ( has_post_thumbnail() ) : ?>
								<div class="entry-meta thumbnail-wrap">
									<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'thumbnail' ); ?></a>
								</div>
							<?php endif; ?>
							
							<h3 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
							
							<div class="entry-meta author"><?php _e( 'By', 'it-l10n-Builder-Summit' ); ?> <span class="author-name"><?php the_author_posts_link(); ?></span></div>
							<?php do_action( 'builder_comments_popup_link', '<div class="entry-meta comments">&middot; ', '</div>', __( 'Comments %s', 'it-l10n-Builder-Summit' ), __( '(0)', 'it-l10n-Builder-Summit' ), __( '(1)', 'it-l10n-Builder-Summit' ), __( '(%)', 'it-l10n-Builder-Summit' ) ); ?>
							
							<div class="entry-meta date">
								<span class="weekday"><?php the_time( 'l' ); ?><span class="weekday-comma">,</span></span>
								<span class="month"><?php the_time( 'F' ); ?></span>
								<span class="day"><?php the_time( 'j' ); ?><span class="day-suffix"><?php the_time( 'S' ); ?></span><span class="day-comma">,</span></span>
								<span class="year"><?php the_time( 'Y' ); ?></span>
							</div>
						</div>
						
						<!--post text with the read more link-->
						<div class="entry-content">
							<?php the_excerpt(); ?>
							<a href="<?php the_permalink(); ?>" class="readmorelink"><span>READ MORE</span></a>
							
							<?php if ( is_singular() ) : ?>
								<?php edit_post_link( __( 'Edit this entry.', 'it-l10n-Builder-Summit' ), '<p class="edit-entry-link">', '</p>' ); ?>
							<?php endif; ?>
						</div>
						
						<!--post meta info-->
						<div class="entry-footer clearfix">
							<div class="entry-meta alignleft"><span class="categories">Categories : <?php the_category( ', ' ) ?></span></div>
							<?php do_action( 'builder_comments_popup_link', '<div class="entry-meta alignright"><span class="comments">', '</span></div>', __( 'Comments %s', 'it-l10n-Builder-Summit' ), __( '(0)', 'it-l10n-Builder-Summit' ), __( '(1)', 'it-l10n-Builder-Summit' ), __( '(%)', 'it-l10n-Builder-Summit' ) ); ?>
						</div>
					</div>
					<!--end .post-->
				<?php endwhile; // end of one post ?>
			</div>
			
			<div class="loop-footer">
				<!-- Previous/Next page navigation -->
				<div class="loop-utility paging clearfix">
					<div class="alignleft"><?php previous_posts_link( '&larr; Previous Page' ); ?></div>
					<div class="alignright"><?php next_posts_link( 'Next Page &rarr;' ); ?></div>
				</div>
			</div>
		</div>
	<?php else : // do not delete ?>
		<?php do_action( 'builder_template_show_not_found' ); ?>
	<?php endif; // do not delete ?>
<?php
	
}

add_action( 'builder_layout_engine_render', 'builder_extension_magazine_change_render_content', 0 );

function builder_extension_magazine_change_render_content() {
	remove_action( 'builder_layout_engine_render_content', 'render_content' );
	add_action( 'builder_layout_engine_render_content', 'builder_extension_magazine_render_content' );
}
