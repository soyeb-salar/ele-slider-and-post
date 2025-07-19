<?php
/**
 * Plugin Name: Ele Slider and Post addon
 * Description: Adds two Elementor widgets: Ele Slider and Ele Post for creating beautiful and dynamic sliders and post displays within Elementor layouts.
 * Text Domain: ele-slider-and-post-addon
 * Version: 1.0
 * Author: Soyeb Salar
 * Author URI: https://www.soyebsalar.in
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Requires at least: 5.6
 * Tested up to: 6.7
 * Requires PHP: 7.0
 * Donate link: https://soyebsalar.in/donate/
 * Tags: elementor, slider, post, widget, image, title, subtitle, button, customization
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
define('ELESLIDER_AND_POST_VERSION', '2.0' );
define('ELESLIDER_AND_POST_URL', plugin_dir_url( __FILE__ ) );
define('ELESLIDER_AND_POST_PATH', plugin_dir_path( __FILE__ ) );
define('ELESLIDER_AND_POST_BASENAME', plugin_basename( __FILE__ ) );

// Add Custom Category
function eleslider_add_custom_category( $elements_manager ) {
    $elements_manager->add_category(
        'ele-kit', // Category slug
        [
            'title' => __( 'Ele Kit', 'ele-slider-and-post-addon' ), // Display name
            'icon' => 'fa fa-plug', // icon
        ]
    );
}
add_action( 'elementor/elements/categories_registered', 'eleslider_add_custom_category' );

// Include Widgets
function eleslider_register_widgets( $widgets_manager ) {
    require_once( __DIR__ . '/widgets/ele-slider.php' );
    require_once( __DIR__ . '/widgets/ele-post.php' );
    require_once( __DIR__ . '/widgets/ele-slider3.php' );
    require_once( __DIR__ . '/widgets/ele-slider4.php' );

    $widgets_manager->register( new \EleSlider_Slider_Widget() );
    $widgets_manager->register( new \EleSlider_Post_Widget() );
    $widgets_manager->register( new \EleSlider_Slider3_Widget() );
    $widgets_manager->register( new \EleSlider_Slider4_Widget() );
}
add_action( 'elementor/widgets/register', 'eleslider_register_widgets' );

// Enqueue Scripts and Styles
function eleslider_enqueue_assets() {
    wp_enqueue_style( 'elementor-icons' );
    wp_register_script( 'ele-script', ELESLIDER_AND_POST_URL.'assets/ele-script.js', array( 'jquery' ), ELESLIDER_AND_POST_VERSION, true );
    wp_register_style( 'ele-style-slider', ELESLIDER_AND_POST_URL. 'assets/ele-style-slider.css', array(), ELESLIDER_AND_POST_VERSION, 'all' );
    wp_register_style( 'ele-style-post', ELESLIDER_AND_POST_URL.'assets/ele-style-post.css', array(), ELESLIDER_AND_POST_VERSION, 'all' );
    //slider-3
    wp_register_style( 'ele-style-slider3', ELESLIDER_AND_POST_URL.'assets/ele-slider3.css', array(), ELESLIDER_AND_POST_VERSION, 'all' );
    wp_register_script( 'ele-script-slider3', ELESLIDER_AND_POST_URL.'assets/ele-slider3.js', array( 'jquery' ), ELESLIDER_AND_POST_VERSION, true );
    //silder 4
    wp_register_style( 'ele-style-slider4', ELESLIDER_AND_POST_URL.'assets/slider4/swiper-bundle.min.css', array(), ELESLIDER_AND_POST_VERSION, 'all' );
    wp_register_style( 'ele-style-slider4-custom', ELESLIDER_AND_POST_URL.'assets/slider4/slider4.css', array(), ELESLIDER_AND_POST_VERSION, 'all' );
    wp_register_script( 'ele-script-slider4-swiper', ELESLIDER_AND_POST_URL.'assets/slider4/swiper-bundle.min.js',[], ELESLIDER_AND_POST_VERSION, true );
    wp_register_script( 'ele-script-slider4', ELESLIDER_AND_POST_URL.'assets/slider4/slider4.js', array( 'jquery' ), ELESLIDER_AND_POST_VERSION, true );
    wp_register_script( 'ele-script-slider4-ion-esm', ELESLIDER_AND_POST_URL.'assets/slider4/ionicons.esm.js', [], ELESLIDER_AND_POST_VERSION, true );
    wp_register_script( 'ele-script-slider4-swiper-ion', ELESLIDER_AND_POST_URL.'assets/slider4/ionicons.js', [], ELESLIDER_AND_POST_VERSION, true );
     

}
add_action( 'wp_enqueue_scripts', 'eleslider_enqueue_assets' );
add_action( 'admin_enqueue_scripts', 'eleslider_enqueue_assets' );

