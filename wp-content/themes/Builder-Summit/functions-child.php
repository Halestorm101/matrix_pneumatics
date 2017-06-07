<?php

// Tell the main theme that a child theme is running. Do not remove this.
$GLOBALS['builder_child_theme_loaded'] = true;


// Theme Support Features
add_theme_support( 'builder-3.0' ); // Adds Support for Builder 3.0
// add_theme_support( 'builder-percentage-widths' ); // Add if you remove the responsive feature of Builder.
add_theme_support( 'builder-responsive' ); // Adds Responsive Capabilities, limits column widths to be a minimum of 300px wide before breaking down
add_theme_support( 'builder-full-width-modules' ); // Adds Full Browser Width Background Modules
add_theme_support( 'post-formats', array( 'image', 'quote', 'status' ) );


// Enqueuing and Using Custom Javascript/jQuery
function custom_load_custom_scripts() {
wp_enqueue_style( 'dashicons' );
if ( file_exists( get_stylesheet_directory() . '/js/custom_jquery_additions.js' ) )
    $url = get_stylesheet_directory_uri() . '/js/custom_jquery_additions.js';
else if ( file_exists( get_template_directory() . '/js/custom_jquery_additions.js' ) )
    $url = get_template_directory_uri() . '/js/custom_jquery_additions.js';
if ( ! empty( $url ) )
    wp_enqueue_script( 'custom_jquery_additions', $url, array('jquery'), false, true );
    	wp_enqueue_style( 'dashicons' );
}
add_action( 'wp_enqueue_scripts', 'custom_load_custom_scripts' );



// Tag Cloud Widget functionality
function it_custom_tag_cloud_widget($args) {
	$args['number'] = 0; // adding a 0 will display all tags
	$args['largest'] = 30; // largest tag
	$args['smallest'] = 12; // smallest tag
	$args['unit'] = 'px'; // tag font unit
	$args['format'] = 'flat';
	return $args;
}
add_filter( 'widget_tag_cloud_args', 'it_custom_tag_cloud_widget' );


// Adds Support for Alternate Module Styles
if ( ! function_exists( 'it_builder_loaded' ) ) {
	function it_builder_loaded() {
		builder_register_module_style( 'image', 'No Spacing', 'image-no-spacing' );
		builder_register_module_style( 'image', 'Full Window', 'image-full-window' );
		builder_register_module_style( 'html', 'Background Image', 'background-image-html' );
		builder_register_module_style( 'html', 'Large Text Blue Background', 'large-text-blue-background-html' );
		builder_register_module_style( 'navigation', 'Navigation with Logo', 'nav-with-logo' );
		builder_register_module_style( 'navigation', 'Secondary Navigation', 'secondary-navigation' );
		builder_register_module_style( 'widget-bar', 'Remove Titles', 'remove-titles' );
		builder_register_module_style( 'widget-bar', 'Dark Widgets', 'dark-widgets' );
	}
}
add_action( 'it_libraries_loaded', 'it_builder_loaded' );


// Registers Featured Image Sizes
if ( function_exists( 'add_image_size' ) ) {
		add_image_size( 'index_thumbnail', 0, 0, true );
}


// Add extra classes to identify if a post has a featured image or not
function cs_it_builder_add_post_class( $classes ){
	if ( has_post_thumbnail( get_the_ID() ) ) {
		$classes[] = 'has-post-thumbnail';
	}
	else {
		$classes[] = 'no-post-thumbnail';
	}
	return $classes;
}
add_filter( 'post_class', 'cs_it_builder_add_post_class' );

// Sets up the WP Customizer to Let Users Add a Logo to the Alternate Navigation Module "Nav With Logo"
function it_summit_theme_customizer( $wp_customize ) {

	$wp_customize->add_section( 'it_summit_logo_section' , array(
	    'title'       => __( 'Site Logo', 'it_summit' ),
	    'priority'    => 30,
	    'description' => 'Upload a logo to replace the default site name and description in the Alternate Navigation Bar, "Nav with Logo". We recommend a size of 330px wide by 90px tall.',
	) );

	$wp_customize->add_setting( 'it_summit_logo' );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'it_summit_logo', array(
	    'label'    => __( 'Site Logo', 'it_summit' ),
	    'section'  => 'it_summit_logo_section',
	    'settings' => 'it_summit_logo',
	) ) );

}
add_action('customize_register', 'it_summit_theme_customizer');


// Adds Logo Customizer to the Alternate Navigation Module "Nav With Logo"
function it_summit_add_logo_to_nav( $fields ) {

	if ( !isset( $fields['data']['style'] ) || ( 'nav-with-logo' != $fields['data']['style'] ) ) {
		return;
	}

	if ( get_theme_mod( 'it_summit_logo' ) ) : ?>
	    <div class='site-logo'>
	        <a href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'><img src='<?php echo esc_url( get_theme_mod( 'it_summit_logo' ) ); ?>' alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>'></a>
	    </div>
	<?php else : ?>
		<div class="site-text">
	        <h1 class='site-title'><a href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'><?php bloginfo( 'name' ); ?></a></h1>
	        <div class='site-tagline'><?php bloginfo( 'description' ); ?></div>
		</div>
	<?php endif;

}
add_action( 'builder_module_render_element_block_contents_navigation', 'it_summit_add_logo_to_nav' );

// Ensure that a Full Window-styled Image Module keeps a high-resolution image
function it_full_image_filter_image_module_widths( $fields ) {
	if ( ( 'image' != $fields['module'] ) || ( 'image-full-window' != $fields['data']['style'] ) || empty( $fields['data']['attachment'] ) )
		return $fields;

	$image = wp_get_attachment_metadata( $fields['data']['attachment'] );

	$fields['widths']['container_width'] = $image['width'];
	$fields['widths']['content_width'] = $image['width'];
	$fields['widths']['element_width'] = $image['width'];

	return $fields;
}
add_filter( 'builder_module_filter_calculated_widths', 'it_full_image_filter_image_module_widths' );

// Add extra classes to the body for Exchange (Global), Store and Cart Pages
function it_builder_add_exchange_body_class( $classes ){
	if ( ! function_exists( 'it_exchange_is_page' ) ) {
		return $classes;
	}
	if ( it_exchange_is_page() ) {
		$classes[] = 'exchange-page';
	}
	if ( it_exchange_is_page( 'store' ) ) {
		$classes[] = 'exchange-store';
	}
	elseif ( it_exchange_is_page( 'cart' ) ) {
		$classes[] = 'exchange-cart';
	}
	return $classes;
}
add_filter( 'body_class', 'it_builder_add_exchange_body_class' );

// Get caption for featured image
function it_summit_the_post_thumbnail_caption() {
  global $post;

  $thumbnail_id    = get_post_thumbnail_id($post->ID);
  $thumbnail_image = get_posts(array('p' => $thumbnail_id, 'post_type' => 'attachment'));

  if ($thumbnail_image && isset($thumbnail_image[0])) {
    $caption = $thumbnail_image[0]->post_excerpt;
  }

  return $caption;
}