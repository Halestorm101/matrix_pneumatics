<?php

function render_content() {

?>
	<?php if ( have_posts() ) : ?>
		<div class="loop">
			<div class="loop-content">
				<?php while ( have_posts() ) : // The Loop ?>
					<?php the_post(); ?>

					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<?php function add_product_title() { ?>
							<!-- title, meta, and date info -->
							<div class="entry-header clearfix">
									<h1 class="entry-title"><?php the_title(); ?></h1>
							</div>
						<?php } ?>
						<?php add_action('it_exchange_content_product_before_product_info_loop', 'add_product_title'); ?>
						
						<!-- post content -->
						<div class="entry-content clearfix">
							<?php it_exchange_get_template_part( 'content', 'product' ); ?>
						</div>

					</div>
					<!-- end .post -->

					<?php comments_template(); // include comments template ?>
				<?php endwhile; // end of one post ?>
			</div>
		</div>
	<?php else : // do not delete ?>
		<?php do_action( 'builder_template_show_not_found' ); ?>
	<?php endif; // do not delete ?>
<?php

}

add_action( 'builder_layout_engine_render_content', 'render_content' );

do_action( 'builder_layout_engine_render', basename( __FILE__ ) );
