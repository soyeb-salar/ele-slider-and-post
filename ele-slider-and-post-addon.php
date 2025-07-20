<?php
/**
 * Plugin Name: Ele Slider and Post Addon
 * Description: Adds Elementor widgets: Ele Slider and Ele Post for creating beautiful and dynamic sliders and post displays within Elementor layouts.
 * Text Domain: ele-slider-and-post-addon
 * Version: 2.0.2
 * Author: Soyeb Salar
 * Author URI: https://www.soyebsalar.in
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Requires at least: 5.6
 * Tested up to: 6.7
 * Requires PHP: 7.4
 * Elementor tested up to: 3.25.0
 * Elementor Pro tested up to: 3.25.0
 * Donate link: https://soyebsalar.in/donate/
 * Tags: elementor, slider, post, widget, image, title, subtitle, button, customization
 * Domain Path: /languages
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Plugin constants.
define( 'ELESLIDER_AND_POST_VERSION', '2.0.2' );
define( 'ELESLIDER_AND_POST_URL', plugin_dir_url( __FILE__ ) );
define( 'ELESLIDER_AND_POST_PATH', plugin_dir_path( __FILE__ ) );
define( 'ELESLIDER_AND_POST_BASENAME', plugin_basename( __FILE__ ) );
define( 'ELESLIDER_AND_POST_MINIMUM_ELEMENTOR_VERSION', '3.0.0' );
define( 'ELESLIDER_AND_POST_MINIMUM_PHP_VERSION', '7.4' );

/**
 * Main Plugin Class
 */
final class EleSlider_And_Post_Addon {

	/**
	 * Plugin instance.
	 *
	 * @var EleSlider_And_Post_Addon
	 */
	private static $instance = null;

	/**
	 * Get plugin instance.
	 *
	 * @return EleSlider_And_Post_Addon
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'init' ) );
		
		// Safe cache clearing on activation without affecting Elementor
		register_activation_hook( __FILE__, array( $this, 'on_activation' ) );
	}

	/**
	 * Plugin activation callback.
	 */
	public function on_activation() {
		// Only clear basic WordPress cache, don't touch Elementor
		if ( function_exists( 'wp_cache_flush' ) ) {
			wp_cache_flush();
		}
		
		// Set activation notice
		set_transient( 'eleslider_activation_notice', true, 30 );
	}

	/**
	 * Initialize the plugin.
	 */
	public function init() {
		// Check for required PHP version.
		if ( version_compare( PHP_VERSION, ELESLIDER_AND_POST_MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
			return;
		}

		// Check if Elementor is installed and activated.
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
			return;
		}

		// Check for required Elementor version.
		if ( ! version_compare( ELEMENTOR_VERSION, ELESLIDER_AND_POST_MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
			return;
		}

		// Load plugin textdomain.
		add_action( 'init', array( $this, 'load_textdomain' ) );

		// Register widgets.
		add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ), 10 );

		// Register widget category.
		add_action( 'elementor/elements/categories_registered', array( $this, 'add_custom_category' ) );

		// Enqueue assets.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_assets' ) );
		add_action( 'elementor/editor/after_enqueue_scripts', array( $this, 'enqueue_editor_assets' ) );
		
		// Activation notice.
		add_action( 'admin_notices', array( $this, 'activation_notice' ) );
	}

	/**
	 * Load plugin textdomain.
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'ele-slider-and-post-addon', false, dirname( ELESLIDER_AND_POST_BASENAME ) . '/languages' );
	}

	/**
	 * Show activation notice.
	 */
	public function activation_notice() {
		if ( get_transient( 'eleslider_activation_notice' ) ) {
			delete_transient( 'eleslider_activation_notice' );
			?>
			<div class="notice notice-success is-dismissible">
				<h3><?php esc_html_e( '🎉 Ele Slider and Post Addon Activated!', 'ele-slider-and-post-addon' ); ?></h3>
				<p><?php esc_html_e( 'The plugin has been successfully activated. You can now find the "Ele Kit" widgets in your Elementor editor.', 'ele-slider-and-post-addon' ); ?></p>
				<p><strong><?php esc_html_e( 'Available Widgets:', 'ele-slider-and-post-addon' ); ?></strong></p>
				<ul style="list-style: disc; margin-left: 20px;">
					<li><?php esc_html_e( 'Ele Slider - Advanced image slider with customizable controls', 'ele-slider-and-post-addon' ); ?></li>
					<li><?php esc_html_e( 'Ele Post - Dynamic post grid with query options', 'ele-slider-and-post-addon' ); ?></li>
					<li><?php esc_html_e( 'Ele Slider3 - Gallery slider with lightbox effect', 'ele-slider-and-post-addon' ); ?></li>
					<li><?php esc_html_e( 'Ele Slider4 - Swiper-based slider with modern transitions', 'ele-slider-and-post-addon' ); ?></li>
				</ul>
				<p><em><?php esc_html_e( 'If you encounter any issues, please go to Elementor > Tools > Regenerate CSS to refresh the styles.', 'ele-slider-and-post-addon' ); ?></em></p>
			</div>
			<?php
		}
	}

	/**
	 * Admin notice for minimum PHP version.
	 */
	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'ele-slider-and-post-addon' ),
			'<strong>' . esc_html__( 'Ele Slider and Post Addon', 'ele-slider-and-post-addon' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'ele-slider-and-post-addon' ) . '</strong>',
			ELESLIDER_AND_POST_MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice for missing Elementor.
	 */
	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'ele-slider-and-post-addon' ),
			'<strong>' . esc_html__( 'Ele Slider and Post Addon', 'ele-slider-and-post-addon' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'ele-slider-and-post-addon' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice for minimum Elementor version.
	 */
	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'ele-slider-and-post-addon' ),
			'<strong>' . esc_html__( 'Ele Slider and Post Addon', 'ele-slider-and-post-addon' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'ele-slider-and-post-addon' ) . '</strong>',
			ELESLIDER_AND_POST_MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Add custom widget category.
	 *
	 * @param \Elementor\Elements_Manager $elements_manager Elementor elements manager.
	 */
	public function add_custom_category( $elements_manager ) {
		$elements_manager->add_category(
			'ele-kit',
			array(
				'title' => esc_html__( 'Ele Kit', 'ele-slider-and-post-addon' ),
				'icon'  => 'fa fa-plug',
			)
		);
	}

	/**
	 * Register widgets.
	 *
	 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
	 */
	public function register_widgets( $widgets_manager ) {
		// Include widget files safely.
		$this->include_widget_files();

		// Register widgets only if classes exist and not already registered.
		$widgets = array(
			'EleSlider_Slider_Widget',
			'EleSlider_Post_Widget', 
			'EleSlider_Slider3_Widget',
			'EleSlider_Slider4_Widget'
		);

		foreach ( $widgets as $widget_class ) {
			if ( class_exists( $widget_class ) ) {
				try {
					$widgets_manager->register( new $widget_class() );
				} catch ( Exception $e ) {
					// Silently skip if widget can't be registered
					error_log( 'Ele Slider Widget Registration Error: ' . $e->getMessage() );
				}
			}
		}
	}

	/**
	 * Include widget files.
	 */
	private function include_widget_files() {
		$widget_files = array(
			'ele-slider.php',
			'ele-post.php',
			'ele-slider3.php',
			'ele-slider4.php',
		);

		foreach ( $widget_files as $file ) {
			$file_path = ELESLIDER_AND_POST_PATH . 'widgets/' . $file;
			if ( file_exists( $file_path ) && is_readable( $file_path ) ) {
				try {
					require_once $file_path;
				} catch ( Exception $e ) {
					// Log error but don't break execution
					error_log( 'Ele Slider Widget File Include Error (' . $file . '): ' . $e->getMessage() );
				}
			}
		}
	}

	/**
	 * Enqueue frontend assets.
	 */
	public function enqueue_frontend_assets() {
		// Register scripts and styles.
		wp_register_script(
			'ele-script',
			ELESLIDER_AND_POST_URL . 'assets/ele-script.js',
			array( 'jquery' ),
			ELESLIDER_AND_POST_VERSION,
			true
		);

		wp_register_style(
			'ele-style-slider',
			ELESLIDER_AND_POST_URL . 'assets/ele-style-slider.css',
			array(),
			ELESLIDER_AND_POST_VERSION
		);

		wp_register_style(
			'ele-style-post',
			ELESLIDER_AND_POST_URL . 'assets/ele-style-post.css',
			array(),
			ELESLIDER_AND_POST_VERSION
		);

		// Slider 3 assets.
		wp_register_style(
			'ele-style-slider3',
			ELESLIDER_AND_POST_URL . 'assets/ele-slider3.css',
			array(),
			ELESLIDER_AND_POST_VERSION
		);

		wp_register_script(
			'ele-script-slider3',
			ELESLIDER_AND_POST_URL . 'assets/ele-slider3.js',
			array( 'jquery' ),
			ELESLIDER_AND_POST_VERSION,
			true
		);

		// Slider 4 assets.
		wp_register_style(
			'ele-style-slider4',
			ELESLIDER_AND_POST_URL . 'assets/slider4/swiper-bundle.min.css',
			array(),
			ELESLIDER_AND_POST_VERSION
		);

		wp_register_style(
			'ele-style-slider4-custom',
			ELESLIDER_AND_POST_URL . 'assets/slider4/slider4.css',
			array(),
			ELESLIDER_AND_POST_VERSION
		);

		wp_register_script(
			'ele-script-slider4-swiper',
			ELESLIDER_AND_POST_URL . 'assets/slider4/swiper-bundle.min.js',
			array(),
			ELESLIDER_AND_POST_VERSION,
			true
		);

		wp_register_script(
			'ele-script-slider4',
			ELESLIDER_AND_POST_URL . 'assets/slider4/slider4.js',
			array( 'jquery', 'ele-script-slider4-swiper' ),
			ELESLIDER_AND_POST_VERSION,
			true
		);

		wp_register_script(
			'ele-script-slider4-ion-esm',
			ELESLIDER_AND_POST_URL . 'assets/slider4/ionicons.esm.js',
			array(),
			ELESLIDER_AND_POST_VERSION,
			true
		);

		wp_register_script(
			'ele-script-slider4-swiper-ion',
			ELESLIDER_AND_POST_URL . 'assets/slider4/ionicons.js',
			array(),
			ELESLIDER_AND_POST_VERSION,
			true
		);
	}

	/**
	 * Enqueue editor assets.
	 */
	public function enqueue_editor_assets() {
		wp_enqueue_style( 'elementor-icons' );
	}
}

// Initialize the plugin.
EleSlider_And_Post_Addon::instance();

