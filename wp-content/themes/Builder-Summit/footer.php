<?php


function render_footer() {
	$builder_link = '<a rel="nofollow" href="http://ithemes.com/purchase/builder-theme/" title="iThemes Builder">iThemes Builder</a>';
	$ithemes_link = '<a rel="nofollow" href="http://ithemes.com/" title="iThemes WordPress Themes">iThemes</a>';
	$wordpress_link = '<a rel="nofollow" href="http://wordpress.org">WordPress</a>';

	$footer_credit = sprintf( __( '%1$s by %2$s | Powered by %3$s', 'it-l10n-Builder-Summit' ), $builder_link, $ithemes_link, $wordpress_link );
	$footer_credit = apply_filters( 'builder_footer_credit', $footer_credit );

?>
	<strong><?php bloginfo( 'name' ); ?></strong> | <?php printf( __( 'Copyright &copy; %s All Rights Reserved', 'it-l10n-Builder-Summit' ), date( 'Y' ) ); ?><br />
	<?php echo $footer_credit; ?>
	<?php wp_footer(); ?>
<?php

}

add_action( 'builder_layout_engine_render_footer', 'render_footer' );
