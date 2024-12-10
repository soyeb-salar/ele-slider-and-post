<?php
/**
 * Plugin Name: Ele Slider and Post
 * Description: Adds two Elementor widgets: Ele Slider and Ele Post for creating beautiful and dynamic sliders and post displays within Elementor layouts.
 * Text Domain: ele-slider-and-post
 * Version: 1.0
 * Author: Soyeb Salar
 * Author URI: https://www.soyebsalar.com
 * Plugin URI: https://www.soyebsalar.com/ele-slider-and-post
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Requires at least: 5.6
 * Tested up to: 6.7
 * Requires PHP: 7.0
 * Donate link: https://www.paypal.me/soyebsalar
 * Tags: elementor, slider, post, widget, image, title, subtitle, button, customization
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
// Load text domain for translations
function ele_slider_and_post_load_textdomain() {
    load_plugin_textdomain( 'ele-slider-and-post', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'ele_slider_and_post_load_textdomain' );
// Add Custom Category
function ele_add_custom_category( $elements_manager ) {
    $elements_manager->add_category(
        'ele-kit', // Category slug
        [
            'title' => __( 'Ele Kit', 'ele-slider-and-post' ), // Display name
            'icon' => 'fa fa-plug', // icon
        ]
    );
}
add_action( 'elementor/elements/categories_registered', 'ele_add_custom_category' );

// Include Widgets
function ele_register_widgets( $widgets_manager ) {
    require_once( __DIR__ . '/widgets/ele-slider.php' );
    require_once( __DIR__ . '/widgets/ele-post.php' );

    $widgets_manager->register( new \Ele_Slider_Widget() );
    $widgets_manager->register( new \Ele_Post_Widget() );
}
add_action( 'elementor/widgets/register', 'ele_register_widgets' );

// Enqueue Scripts and Styles
function ele_enqueue_assets() {
// Use file modification time as version
$script_version = filemtime( plugin_dir_path( __FILE__ ) . 'assets/ele-script.js' );
wp_register_script( 'ele-script', plugins_url( '/assets/ele-script.js', __FILE__ ), array( 'jquery' ), $script_version, true );
wp_register_style( 
    'ele-style-slider', 
    plugins_url( '/assets/ele-style-slider.css', __FILE__ ), 
    [], 
    filemtime( plugin_dir_path( __FILE__ ) . 'assets/ele-style-slider.css' )
);

wp_register_style( 
    'ele-style-post', 
    plugins_url( '/assets/ele-style-post.css', __FILE__ ), 
    [], 
    filemtime( plugin_dir_path( __FILE__ ) . 'assets/ele-style-post.css' )
);
}
add_action( 'wp_enqueue_scripts', 'ele_enqueue_assets' );
