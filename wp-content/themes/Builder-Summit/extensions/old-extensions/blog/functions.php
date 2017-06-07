<?php

/* This file can be used to add additional functionality and customization to this Extension */


function builder_extension_blog_style_content() {
	
?>
	<?php if ( have_posts() ) : ?>
		<div class="loop">
			<div class="loop-content">
				<?php while ( have_posts() ) : // the loop ?>
					<?php the_post(); ?>
					
					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<!--Title/Date/Meta-->
						<div class="entry-header clearfix">
							<div class="entry-meta date">
								<div class="month"><?php the_time( 'M' ); ?></div>
								<div class="day"><?php the_time( 'd' ); ?></div>
							</div>
							
							<h3 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
							
							<div class="entry-meta author"><?php _e( 'By', 'it-l10n-Builder-Summit' ); ?> <span class="author-name"><?php the_author_posts_link(); ?></span></div>
							<?php do_action( 'builder_comments_popup_link', '<div class="entry-meta comments">&middot; ', '</div>', __( 'Comments %s', 'it-l10n-Builder-Summit' ), __( '(0)', 'it-l10n-Builder-Summit' ), __( '(1)', 'it-l10n-Builder-Summit' ), __( '(%)', 'it-l10n-Builder-Summit' ) ); ?>
						</div>
						
						<!--post text with the read more link-->
						<div class="entry-content">
							<?php the_content( __( 'Read More&rarr;', 'it-l10n-Builder-Summit' ) ); ?>
							
							<?php if ( is_singular() ) : ?>
								<?php edit_post_link( __( 'Edit this entry.', 'it-l10n-Builder-Summit' ), '<p class="edit-entry-link">', '</p>' ); ?>
							<?php endif; ?>
						</div>
						
						<!--post meta info-->
						<div class="entry-footer clearfix">
							<div class="entry-meta alignleft"><span class="categories">Categories : <?php the_category(', ') ?></span></div>
							<?php do_action( 'builder_comments_popup_link', '<div class="entry-meta alignright"><span class="comments">', '</span></div>', __( 'Comments %s', 'it-l10n-Builder-Summit' ), __( '(0)', 'it-l10n-Builder-Summit' ), __( '(1)', 'it-l10n-Builder-Summit' ), __( '(%)', 'it-l10n-Builder-Summit' ) ); ?>
						</div>
					</div>
					<!--end .post-->
					
					<?php comments_template(); // include comments template ?>
				<?php endwhile; // end of one post ?>
			</div>
			
			<?php $previous_posts_link = get_previous_posts_link( __( '&larr; Previous Page', 'it-l10n-Builder-Summit' ) ); ?>
			<?php $next_posts_link = get_next_posts_link( __( 'Next Page &rarr;', 'it-l10n-Builder-Summit' ) ); ?>
			
			<?php if ( ! empty( $previous_posts_link ) || ! empty( $next_posts_link ) ) : ?>
				<div class="loop-footer">
					<!-- Previous/Next page navigation -->
					<div class="loop-utility paging clearfix">
						<div class="alignleft"><?php echo $previous_posts_link; ?></div>
						<div class="alignright"><?php echo $next_posts_link; ?></div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	<?php else : // do not delete ?>
		<?php do_action( 'builder_template_show_not_found' ); ?>
	<?php endif; // do not delete ?>
<?php
	
}

add_action( 'builder_layout_engine_render', 'builder_extension_blog_change_render_content', 0 );

function builder_extension_blog_change_render_content() {
	remove_action( 'builder_layout_engine_render_content', 'render_content' );
	add_action( 'builder_layout_engine_render_content', 'builder_extension_blog_style_content' );
}
