<?php
/**
 * Plugin Name: Ele Slider and Post
 * Description: Adds two Elementor widgets: Slider and Post.
 * Text Domain: ele-slider-and-post
 * Version: 1.0
 * Author: Soyeb Salar
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Include Widgets
function esp_register_widgets( $widgets_manager ) {
    require_once( __DIR__ . '/widgets/ele-slider.php' );
    require_once( __DIR__ . '/widgets/ele-post.php' );

    $widgets_manager->register( new \Ele_Slider_Widget() );
    $widgets_manager->register( new \Ele_Post_Widget() );
}
add_action( 'elementor/widgets/register', 'esp_register_widgets' );

// Enqueue Scripts and Styles
function esp_enqueue_assets() {
   // wp_register_style( 'esp-icon', plugins_url( '/assets/all.min.css', __FILE__ ) );
    wp_register_script( 'esp-script', plugins_url( '/assets/ele-script.js', __FILE__ ), array( 'jquery' ), false, true );
    wp_register_style( 'esp-style-slider', plugins_url( '/assets/ele-style-slider.css', __FILE__ ) );
    wp_register_style( 'esp-style-post', plugins_url( '/assets/ele-style-post.css', __FILE__ ) );
    
}
add_action( 'wp_enqueue_scripts', 'esp_enqueue_assets' );
