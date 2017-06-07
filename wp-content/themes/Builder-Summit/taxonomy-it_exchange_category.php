<?php

function render_content() {

?>
	<?php if ( have_posts() ) : ?>

		<div class="loop">
			<div class="loop-header">
				<h4 class="loop-title">
					<?php
						the_post();
						
						$title = 'Product Category Archive - ' . single_cat_title( '', false );

						if ( is_paged() )
							printf( __( '%s &ndash; Page %d', 'it-l10n-Builder-Summit' ), $title, get_query_var( 'paged' ) );
						else
							echo $title;

						rewind_posts();
					?>
				</h4>

				<?php	if ( is_tax() ) { // Category Archive ?>
							<div class="category-description it-exchange-taxonomy-description">
								<?php echo category_description(); ?>
							</div>
				<?php	} ?>

			</div>

			<div id="it-exchange-store" class="loop-content">
			<ul class="it-exchange-products">
				<?php while ( have_posts() ) : // The Loop ?>
					<?php the_post(); ?>
<!--                     <?php it_exchange_set_product( $post->ID ); ?> -->
                    <?php it_exchange_get_template_part( 'content-store/elements/product' ); ?>
				<?php endwhile; // end of one post ?>
			</ul>
			</div>

			<div class="loop-footer">
				<!-- Previous/Next page navigation -->
				<div class="loop-utility clearfix">
					<div class="alignleft"><?php previous_posts_link( __( '&larr; Previous Page', 'it-l10n-Builder-Summit' ) ); ?></div>
					<div class="alignright"><?php next_posts_link( __( 'Next Page &rarr;', 'it-l10n-Builder-Summit' ) ); ?></div>
				</div>
			</div>
		</div>
	<?php else : // do not delete ?>
		<?php do_action( 'builder_template_show_not_found' ); ?>
	<?php endif; // do not delete ?>
<?php

}

add_action( 'builder_layout_engine_render_content', 'render_content' );

do_action( 'builder_layout_engine_render', basename( __FILE__ ) );
