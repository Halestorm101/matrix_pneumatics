<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-header clearfix">

		<h3 class="entry-title clearfix">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h3>

		<div class="entry-meta-wrapper clearfix">
			<div class="entry-meta date">
				<a href="<?php the_permalink(); ?>">
					<span>&nbsp;<?php echo get_the_date(); ?></span>
				</a>
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

	<div class="entry-content clearfix">
		<?php the_content( __( 'Read More', 'it-l10n-Builder-Summit' ) ); ?>
	</div>

	<div class="entry-footer clearfix">
		<?php edit_post_link( __( 'Edit this entry.', 'it-l10n-Builder-Summit' ), '<div class="entry-utility edit-entry-link">', '</div>' ); ?>
	</div>
</div>