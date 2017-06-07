<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-header clearfix">

	<h1 class="entry-title clearfix">
		<?php the_title(); ?>
	</h1>

			<?php if ( has_post_thumbnail() ) : ?>
				<?php
					$caption = it_summit_the_post_thumbnail_caption();
				?>
				<div class="it-featured-image">
						<?php the_post_thumbnail( 'index_thumbnail', array( 'class' => 'index-thumbnail' ) ); ?>
				</div>
			<?php endif; ?>

		<div class="entry-meta date">
			<span><?php echo get_the_date(); ?>&nbsp;</span>
		</div>
		
		<?php
			if($caption) {
		        echo '<p class="wp-caption-text">' . $caption . '</p>';
		    }
		?>
	</div>

	<div class="entry-content clearfix">
		<?php the_content( __( 'Read More &rarr;', 'it-l10n-Builder-Summit' ) ); ?>
	</div>

	<div class="entry-footer clearfix">
		<?php edit_post_link( __( 'Edit this entry.', 'it-l10n-Builder-Summit' ), '<div class="entry-utility edit-entry-link">', '</div>' ); ?>
	</div>
</div>