<?php
/**
 * Emergency Disable for Ele Slider and Post Addon
 * 
 * If the plugin is breaking Elementor's editor, use this to quickly disable it.
 * 
 * Instructions:
 * 1. Upload this file to your WordPress root directory
 * 2. Access via: yoursite.com/emergency-disable.php?action=disable_eleslider
 * 3. This will deactivate the plugin and restore Elementor
 * 4. Delete this file after use
 */

// Security check
if ( ! isset( $_GET['action'] ) || $_GET['action'] !== 'disable_eleslider' ) {
    die( 'Access denied. Use: ?action=disable_eleslider' );
}

// Load WordPress
require_once( 'wp-config.php' );
require_once( 'wp-load.php' );

if ( ! current_user_can( 'manage_options' ) ) {
    die( 'Access denied. You must be an administrator.' );
}

echo '<h1>Emergency Disable - Ele Slider and Post Addon</h1>';

// Get active plugins
$active_plugins = get_option( 'active_plugins', array() );
$plugin_file = 'ele-slider-and-post-addon/ele-slider-and-post-addon.php';

if ( in_array( $plugin_file, $active_plugins ) || array_key_exists( $plugin_file, $active_plugins ) ) {
    // Deactivate the plugin
    $active_plugins = array_diff( $active_plugins, array( $plugin_file ) );
    update_option( 'active_plugins', $active_plugins );
    
    echo '<p>✅ <strong>Ele Slider and Post Addon has been deactivated.</strong></p>';
    echo '<p>Elementor should now work normally.</p>';
} else {
    echo '<p>ℹ️ Ele Slider and Post Addon is not currently active.</p>';
}

// Clear any problematic transients
delete_transient( 'eleslider_activation_notice' );

// Clear WordPress cache
if ( function_exists( 'wp_cache_flush' ) ) {
    wp_cache_flush();
    echo '<p>✅ WordPress cache cleared.</p>';
}

echo '<h2>Next Steps:</h2>';
echo '<ol>';
echo '<li><strong>Check Elementor</strong> - Go to your WordPress admin and try editing with Elementor</li>';
echo '<li><strong>If Elementor works</strong> - The issue was with our plugin</li>';
echo '<li><strong>Safe reactivation</strong> - You can try reactivating the plugin later</li>';
echo '<li><strong>Delete this file</strong> for security</li>';
echo '</ol>';

echo '<p><a href="' . admin_url( 'plugins.php' ) . '">Go to WordPress Plugins Page</a></p>';

echo '<hr>';
echo '<h3>Alternative: Rename Plugin Folder</h3>';
echo '<p>If the plugin keeps reactivating, you can also rename the plugin folder:</p>';
echo '<p><code>/wp-content/plugins/ele-slider-and-post-addon/</code> → <code>/wp-content/plugins/ele-slider-and-post-addon-disabled/</code></p>';

?>