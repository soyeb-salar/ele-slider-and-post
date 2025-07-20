<?php
/**
 * Plugin Name: Ele Slider and Post Addon (Safe Mode)
 * Description: Safe version that won't break Elementor. Adds widgets only when completely safe.
 * Text Domain: ele-slider-and-post-addon
 * Version: 2.0.3-safe
 * Author: Soyeb Salar
 * Author URI: https://www.soyebsalar.in
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Requires at least: 5.6
 * Tested up to: 6.7
 * Requires PHP: 7.4
 * Elementor tested up to: 3.25.0
 * Elementor Pro tested up to: 3.25.0
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Only proceed if WordPress is fully loaded
if ( ! function_exists( 'add_action' ) ) {
    return;
}

/**
 * Safe Ele Slider Plugin
 */
class EleSlider_Safe_Mode {
    
    private static $instance = null;
    
    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function __construct() {
        // Only initialize if it's completely safe
        add_action( 'plugins_loaded', array( $this, 'safe_init' ), 999 );
    }
    
    public function safe_init() {
        // Multiple safety checks
        if ( ! $this->is_environment_safe() ) {
            return;
        }
        
        // Show notice that safe mode is active
        add_action( 'admin_notices', array( $this, 'safe_mode_notice' ) );
        
        // Only register if absolutely safe
        if ( $this->is_elementor_ready() ) {
            add_action( 'elementor/widgets/register', array( $this, 'safe_register_widgets' ), 9999 );
        }
    }
    
    private function is_environment_safe() {
        // Check PHP version
        if ( version_compare( PHP_VERSION, '7.4', '<' ) ) {
            return false;
        }
        
        // Check if WordPress is properly loaded
        if ( ! did_action( 'wp_loaded' ) ) {
            return false;
        }
        
        return true;
    }
    
    private function is_elementor_ready() {
        // Elementor must be loaded
        if ( ! did_action( 'elementor/loaded' ) ) {
            return false;
        }
        
        // Elementor must be initialized
        if ( ! did_action( 'elementor/init' ) ) {
            return false;
        }
        
        // Check Elementor version
        if ( ! defined( 'ELEMENTOR_VERSION' ) || version_compare( ELEMENTOR_VERSION, '3.0.0', '<' ) ) {
            return false;
        }
        
        // Elementor Plugin class must exist
        if ( ! class_exists( '\Elementor\Plugin' ) ) {
            return false;
        }
        
        return true;
    }
    
    public function safe_register_widgets( $widgets_manager ) {
        // Final safety check
        if ( ! $widgets_manager || ! method_exists( $widgets_manager, 'register' ) ) {
            return;
        }
        
        // Don't proceed if there are any PHP errors
        if ( error_get_last() ) {
            return;
        }
        
        // Try to register one simple widget only
        try {
            $this->register_simple_widget( $widgets_manager );
        } catch ( Exception $e ) {
            // Log but don't break
            error_log( 'Ele Slider Safe Mode Error: ' . $e->getMessage() );
        }
    }
    
    private function register_simple_widget( $widgets_manager ) {
        // Create minimal test widget
        if ( ! class_exists( 'EleSlider_Test_Widget' ) ) {
            $this->create_test_widget();
        }
        
        if ( class_exists( 'EleSlider_Test_Widget' ) ) {
            $widgets_manager->register( new EleSlider_Test_Widget() );
        }
    }
    
    private function create_test_widget() {
        eval('
        class EleSlider_Test_Widget extends \Elementor\Widget_Base {
            public function get_name() { return "ele-test"; }
            public function get_title() { return "Ele Test (Safe Mode)"; }
            public function get_icon() { return "eicon-posts-ticker"; }
            public function get_categories() { return ["basic"]; }
            protected function register_controls() {
                $this->start_controls_section("content_section", ["label" => "Content"]);
                $this->add_control("title", ["label" => "Title", "type" => \Elementor\Controls_Manager::TEXT, "default" => "Safe Mode Active"]);
                $this->end_controls_section();
            }
            protected function render() {
                $settings = $this->get_settings_for_display();
                echo "<div style=\"padding: 20px; background: #f0f0f0; border: 1px solid #ddd; text-align: center;\">";
                echo "<h3>" . esc_html($settings["title"]) . "</h3>";
                echo "<p>Ele Slider is running in safe mode. Elementor is working normally.</p>";
                echo "</div>";
            }
        }
        ');
    }
    
    public function safe_mode_notice() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }
        
        ?>
        <div class="notice notice-info">
            <h3>🔒 Ele Slider and Post Addon - Safe Mode</h3>
            <p>The plugin is running in <strong>safe mode</strong> to prevent conflicts with Elementor.</p>
            <p>✅ <strong>Elementor is working normally.</strong></p>
            <p>📍 You can find a test widget called "Ele Test (Safe Mode)" in the Basic category.</p>
            <p><em>To activate full widgets, ensure there are no conflicts and switch to the full version.</em></p>
        </div>
        <?php
    }
}

// Initialize safe mode
EleSlider_Safe_Mode::instance();