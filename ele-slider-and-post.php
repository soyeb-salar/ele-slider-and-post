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
define('ELE_SLIDER_AND_POST_VERSION', '1.0' );
define('ELE_SLIDER_AND_POST_URL', plugin_dir_url( __FILE__ ) );
define('ELE_SLIDER_AND_POST_PATH', plugin_dir_path( __FILE__ ) );
define('ELE_SLIDER_AND_POST_BASENAME', plugin_basename( __FILE__ ) );
// Load text domain for translations
function ele_slider_and_post_load_textdomain() {
    load_plugin_textdomain( 'ele-slider-and-post', false, dirname( ELE_SLIDER_AND_POST_BASENAME ) . '/languages' );
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
// Enqueue Scripts and Styles
function ele_enqueue_assets() {
    wp_register_script( 'ele-script', ELE_SLIDER_AND_POST_URL.'/assets/ele-script.js', array( 'jquery' ), ELE_SLIDER_AND_POST_VERSION, true );
    wp_register_style( 'ele-style-slider', ELE_SLIDER_AND_POST_URL. '/assets/ele-style-slider.css', array(), ELE_SLIDER_AND_POST_VERSION, 'all' );
    wp_register_style( 'ele-style-post', ELE_SLIDER_AND_POST_URL.'/assets/ele-style-post.css', array(), ELE_SLIDER_AND_POST_VERSION, 'all' );
}
add_action( 'wp_enqueue_scripts', 'ele_enqueue_assets' );
add_action( 'admin_enqueue_scripts', 'ele_enqueue_assets' );

