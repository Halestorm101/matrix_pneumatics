<?php if ( has_post_thumbnail() ) : ?>
	<div class="it-featured-image">
		<a href="<?php the_permalink(); ?>">
			<?php the_post_thumbnail( 'index_thumbnail', array( 'class' => 'index-thumbnail' ) ); ?>
		</a>
	</div>
<?php endif; ?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<!-- title, meta, and date info -->
	<div class="entry-header clearfix">
		
		<h1 class="entry-title clearfix">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h1>

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
				<?php do_action( 'builder_comments_popup_link', '<span class="comments">&nbsp; &middot; &nbsp;', '</span>', __( '%s', 'it-l10n-Builder-Summit' ), __( 'No Comments', 'it-l10n-Builder-Summit' ), __( '1 Comment', 'it-l10n-Builder-Summit' ), __( '% Comments', 'it-l10n-Builder-Summit' ) ); ?>
			</div>
		</div>

	</div>

	<!-- post content -->
	<div class="entry-content clearfix">
		<?php the_content( __( 'Read More', 'it-l10n-Builder-Summit' ) ); ?>
	</div>

	<!-- categories, tags and comments -->
	<div class="entry-footer clearfix">
		<div class="entry-meta">
			<?php wp_link_pages( array( 'before' => '<div class="entry-utility entry-pages">' . __( 'Pages:', 'it-l10n-Builder-Summit' ) . '', 'after' => '</div>', 'next_or_number' => 'number' ) ); ?>
			<div class="categories"><?php printf( get_the_category_list( ' ' ) ); ?></div>
			<?php the_tags( '<div class="tags">' . __( 'Tags : ', 'it-l10n-Builder-Summit' ), ', ', '</div>' ); ?>
		</div>
		<?php edit_post_link( __( 'Edit', 'it-l10n-Builder-Summit' ), '<div class="entry-utility edit-entry-link">', '</div>' ); ?>
	</div>
</div>