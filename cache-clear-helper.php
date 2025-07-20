<?php
/**
 * Cache Clear Helper for Ele Slider and Post Addon
 * 
 * If you're experiencing issues with duplicate control names or old widget versions,
 * run this script to clear all relevant caches.
 * 
 * Instructions:
 * 1. Upload this file to your WordPress root directory
 * 2. Access it via: yoursite.com/cache-clear-helper.php
 * 3. Delete this file after running it
 */

// Simple security check
if ( ! isset( $_GET['clear_cache'] ) || $_GET['clear_cache'] !== 'eleslider_fix' ) {
    die( 'Access denied. Use: ?clear_cache=eleslider_fix' );
}

// Load WordPress
require_once( 'wp-config.php' );
require_once( 'wp-load.php' );

if ( ! current_user_can( 'manage_options' ) ) {
    die( 'Access denied. You must be an administrator.' );
}

echo '<h1>Ele Slider and Post Addon - Cache Cleaner</h1>';
echo '<p>Clearing all relevant caches...</p>';

// Clear WordPress cache
if ( function_exists( 'wp_cache_flush' ) ) {
    wp_cache_flush();
    echo '<p>✅ WordPress cache cleared</p>';
}

// Clear Elementor cache
if ( class_exists( '\Elementor\Plugin' ) ) {
    \Elementor\Plugin::$instance->files_manager->clear_cache();
    echo '<p>✅ Elementor cache cleared</p>';
}

// Clear specific transients
delete_transient( 'elementor_widgets_cache' );
delete_option( 'elementor_controls_usage' );
echo '<p>✅ Widget cache cleared</p>';

// Clear object cache if available
if ( function_exists( 'wp_cache_flush' ) ) {
    wp_cache_flush();
}

// Clear opcache if available
if ( function_exists( 'opcache_reset' ) ) {
    opcache_reset();
    echo '<p>✅ OPCache cleared</p>';
}

// Force refresh browser cache
header( 'Cache-Control: no-cache, no-store, must-revalidate' );
header( 'Pragma: no-cache' );
header( 'Expires: 0' );

echo '<h2>✅ Cache clearing completed!</h2>';
echo '<p><strong>Next steps:</strong></p>';
echo '<ol>';
echo '<li>Go to WordPress Admin > Elementor > Tools > Regenerate CSS</li>';
echo '<li>Clear any other caching plugins you have (WP Rocket, W3 Total Cache, etc.)</li>';
echo '<li>Try using the widgets in Elementor editor</li>';
echo '<li><strong>Delete this file for security</strong></li>';
echo '</ol>';

echo '<p><a href="' . admin_url() . '">Go to WordPress Admin</a></p>';
?>