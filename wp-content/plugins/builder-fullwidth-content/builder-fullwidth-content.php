<?php
/*
  Plugin Name: Builder Full Width Content modules
  Plugin URI: http://weerdpress.com/
  Description: Builder Full Width content in modules enables a style to make modules outer wrapper full width.
  Version: 0.0.1
  Changelog: see history.txt
  Author: Ronald van Weerd
  Author URI: http://weerdpress.com
 */

function builder_fullwidth_modules_invalid_theme_notice() {
        // Add a notice if a Builder theme is not running.
        if (!isset($GLOBALS['it_builder_core_version']) && ( 'builder' != strtolower(get_template()) ))
                echo '<div class="error"><p>' . __('The Builder Full Width Content plugin requires that a Builder theme is active in order for it to function.', 'it-l10n-builder-mobile-menus') . '</p></div>';
}

add_action('admin_notices', 'builder_fullwidth_modules_invalid_theme_notice');

if (!class_exists('rvwBuilderFullWidthContent')) {

        class rvwBuilderFullWidthContent {

                var $version = '0.0.1';
                var $slug = 'rvw_builder_fullwidth_content';
                var $description = 'Builder Full Width Content';
                var $short_description = 'Builder Full Width Content';
                var $modules = array(
                    'header' => 'Header module',
                    'navigation' => 'Navigation module',
                    'content' => 'Content module',
                    'image' => 'Image module',
                    'widget-bar' => 'Widget module',
                    'html' => 'HTML module',
                    'footer' => 'Footer module'
                );

                function __construct() {

                        // Load textdomain
                        add_action('plugins_loaded', array($this, 'languages'), 0);

                        if (is_admin()) {
                                $this->load_admin();
                                $this->get_options();
                                $this->add_module_styles();
                        } else {
                                $this->get_options();
                                $this->add_code();
                        }
                }

                /**
                 * Load translations.
                 */
                public function languages() {

                        load_plugin_textdomain($this->slug, false, dirname(plugin_basename(__FILE__)) . '/lang/');
                }

                /**
                 * Init and add menu page
                 */
                function load_admin() {

                        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_styles'));
                        add_action('admin_init', array($this, 'init'));
                        add_action('admin_menu', array($this, 'add_page'), 99);
                        
                }
                
                /**
                 * add styles and scripts for admin backend
                 */
                function enqueue_admin_styles() {

                        wp_register_style('builder_fullwidth_modules', plugins_url('css/admin-style.css', __FILE__), null, $this->version);
                        wp_enqueue_style('builder_fullwidth_modules');
                }                

                /**
                 * Add alternate module styles
                 */
                function add_module_styles() {
                        
                        add_action('it_libraries_loaded', array($this, 'register_modules'));

                }
                
                /**
                 * Register module styles
                 */
                function register_modules() {
                        
                        foreach ($this->modules as $key => $value) :

                                if( isset($this->options[$key]['enable']) ) :

                                        builder_register_module_style( $key, '|-- Full Width Content --|', 'full-width-content' );

                                endif; 
                                
                        endforeach;

                }

                /**
                 * Get theme options
                 */
                function get_options() {

                        $this->options = get_option($this->slug);

                }

                /**
                 * process options and add code
                 */
                function add_code() {

                        add_action('wp_head', array($this, 'add_code_to_header'));

                }

                /**
                 * Init plugin options
                 */
                function init() {

                        register_setting($this->slug . '_options', $this->slug, array($this, 'validate'));
                }

                /**
                 * Add options page either to Builder My Theme menu, or WordPress Appearances menu
                 */
                function add_page() {
                        
                        $theme_menu_var = apply_filters( 'it_filter_theme_menu_var', '' );

                        add_submenu_page($theme_menu_var, $this->description, $this->short_description, apply_filters( 'rvw_builder_fullwidth_content', 'manage_options' ), $this->slug, array($this, 'do_page'));

                }

                /**
                 * Display and process options page
                 */
                function do_page() { ?>

                        <div class="wrap">

                                <?php if ( isset($_GET['settings-updated']) ) { ?>
                                            <div id="message" class="updated">
                                                <p><?php _e('Settings saved.') ?></p>
                                            </div>
                                <?php } ?>

                                <h2><?php echo $this->description; ?> options</h2>

                                <form method="post" action="options.php">

                                        <?php
                                        settings_fields($this->slug . '_options');
                                        $this->options = get_option($this->slug);
                                        ?>


                                        <table id="builder-fullwidth-content" class="form-table">
                                                <p><?php _e( '<p>The following settings control the ability to make the content of Builder modules flow full screen width. If enabled, in the <a href="' . admin_url( "admin.php?page=layout-editor" ) . '">Builder Layout Editor</a> for the module you will find a "Style" setting <code>|--Full Width Content --|</code>.</p><p> That style will lift the content width restrictions that are currently in effect for Builder modules (even when <a href="http://ithemes.com/codex/page/Builder_Tips_and_Tricks#How_to_have_full_width_.28100.25_wide_background.29_modules">builder-full-width-modules is enabled</a>).</p><p>In addition, you can set paddings and margins, but <strong>note</strong> that the settings here will apply to <strong>all</strong> <em>full width content modules</em> of the type for which they are set. And, if you want to set these to 0, you need to add this explicitely in these settings. If you do not set padding or margins here, the theme\'s padding and margin will be applied.</p><p>If you want to set different padding or margin settings for modules of the same kind (e.g. two different Image modules, one with, and one without padding) you can always add css code at the end of your custom child theme\'s stylesheet style.css.</p>', $this->slug ); ?>
                                                </p>

                                                <tr>
                                                    <td><h3><?php _e( 'Module', $this->slug ); ?></h3></td>
                                                    <td><h3><?php _e( 'Enable?', $this->slug ); ?></h3></td>
                                                    <td><h3><?php _e( 'Padding (Top / Right / Bottom / Left)', $this->slug ); ?></h3><span>e.g. <code>10px</code> or <code>1.5em</code>or <code>0</code></span></td>
                                                    <td><h3><?php _e( 'Margin (Top / Right / Bottom / Left)', $this->slug ); ?></h3></td>                                        
                                                </tr>

                                                <?php foreach ($this->modules as $key => $value) : ?>
                                                        <tr>
                                                            <th scope="row"><label><?php echo $value; ?></label></th>

                                                            <td>
                                                                <input type="checkbox" name="<?php echo $this->slug; ?>[<?php echo $key; ?>][enable]" value="1" <?php checked(isset($this->options[$key]['enable'])); ?> />
                                                            </td>

                                                            <td>
                                                                <input type="text" size="5" name="<?php echo $this->slug; ?>[<?php echo $key; ?>][padding-top]" value="<?php echo $this->options[$key]['padding-top']; ?>" />
                                                                <input type="text" size="5" name="<?php echo $this->slug; ?>[<?php echo $key; ?>][padding-right]" value="<?php echo $this->options[$key]['padding-right']; ?>" />
                                                                <input type="text" size="5" name="<?php echo $this->slug; ?>[<?php echo $key; ?>][padding-bottom]" value="<?php echo $this->options[$key]['padding-bottom']; ?>" />
                                                                <input type="text" size="5" name="<?php echo $this->slug; ?>[<?php echo $key; ?>][padding-left]" value="<?php echo $this->options[$key]['padding-left']; ?>" />
                                                            </td>

                                                            <td>
                                                                <input type="text" size="5" name="<?php echo $this->slug; ?>[<?php echo $key; ?>][margin-top]" value="<?php echo $this->options[$key]['margin-top']; ?>" />
                                                                <input type="text" size="5" name="<?php echo $this->slug; ?>[<?php echo $key; ?>][margin-right]" value="<?php echo $this->options[$key]['margin-right']; ?>" />
                                                                <input type="text" size="5" name="<?php echo $this->slug; ?>[<?php echo $key; ?>][margin-bottom]" value="<?php echo $this->options[$key]['margin-bottom']; ?>" />
                                                                <input type="text" size="5" name="<?php echo $this->slug; ?>[<?php echo $key; ?>][margin-left]" value="<?php echo $this->options[$key]['margin-left']; ?>" />
                                                            </td>                                        

                                                        </tr>

                                                <?php endforeach ?>

                                        </table>

                                        <?php submit_button(); ?>
                                    
                                </form>
                        </div>
                <?php }

                /**
                 * Sanitize and validate input.
                 */
                function validate($input) {

                        return $input;
                }

                /**
                 * Process options and print dynamic css
                 */
                function add_code_to_header() {

                        echo "\n<!-- start Builder Full Width Content plugin css -->\n";
                        echo "<style type='text/css'>\n";
                        
                        foreach ($this->modules as $key => $value) :

                                if( isset( $this->options[$key]['enable'] ) ) :

                                        echo "\n.builder-module-" . $key . "-outer-wrapper.full-width-content-outer-wrapper {\n";
                                        echo "\tmax-width: none !important;\n";
                                        echo "\tbox-sizing: border-box !important;\n";
                                        
                                        if ( ( $this->options[$key]['padding-top'] ) OR ( $this->options[$key]['padding-top'] === "0" ) ) :
                                                echo "\tpadding-top: " . $this->options[$key]['padding-top'] . " !important;\n";
                                        endif; 
                                        
                                        if ( ( $this->options[$key]['padding-right'] ) OR ( $this->options[$key]['padding-right'] === "0" ) ) :
                                                echo "\tpadding-right: " . $this->options[$key]['padding-right'] . " !important;\n";
                                        endif;
                                        
                                        if ( ( $this->options[$key]['padding-bottom'] ) OR ( $this->options[$key]['padding-bottom'] === "0" ) ) :
                                                echo "\tpadding-bottom: " . $this->options[$key]['padding-bottom'] . " !important;\n";
                                        endif;
                                        
                                        if ( ( $this->options[$key]['padding-left'] ) OR ( $this->options[$key]['padding-left'] === "0" ) ) :
                                                echo "\tpadding-left: " . $this->options[$key]['padding-left'] . " !important;\n";
                                        endif;
                                        
                                        if ( ( $this->options[$key]['margin-top'] ) OR ( $this->options[$key]['margin-top'] === "0" ) ) :
                                                echo "\tmargin-top: " . $this->options[$key]['margin-top'] . " !important;\n";
                                        endif; 
                                        
                                        if ( ( $this->options[$key]['margin-right'] ) OR ( $this->options[$key]['margin-right'] === "0" ) ) :
                                                echo "\tmargin-right: " . $this->options[$key]['margin-right'] . " !important;\n";
                                        endif;
                                        
                                        if ( ( $this->options[$key]['margin-bottom'] ) OR ( $this->options[$key]['margin-bottom'] === "0" ) ) :
                                                echo "\tmargin-bottom: " . $this->options[$key]['margin-bottom'] . " !important;\n";
                                        endif;
                                        
                                        if ( ( $this->options[$key]['margin-left'] ) OR ( $this->options[$key]['margin-left'] === "0" ) ) :
                                                echo "\tmargin-left: " . $this->options[$key]['margin-left'] . " !important;\n";
                                        endif;
                                        
                                        echo "}\n";

                                endif; 
                                
                        endforeach;

                        echo "</style>\n";
                        echo "<!-- end Builder Full Width Content plugin css -->\n";
                }
        }
}

// Instantiate the class
if (class_exists('rvwBuilderFullWidthContent')) {
        $rvwBuilderFullWidthContent_var = new rvwBuilderFullWidthContent();
}