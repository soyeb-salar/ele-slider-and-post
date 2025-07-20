<?php
/**
 * Plugin Name: Ele Slider and Post Addon
 * Description: Adds Elementor widgets: Ele Slider and Ele Post for creating beautiful and dynamic sliders and post displays within Elementor layouts.
 * Text Domain: ele-slider-and-post-addon
 * Version: 2.1.1
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
	exit;
}

// Plugin constants.
define( 'ELESLIDER_VERSION', '2.1.1' );
define( 'ELESLIDER_URL', plugin_dir_url( __FILE__ ) );
define( 'ELESLIDER_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Main Plugin Class
 */
final class EleSlider_Addon {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'init' ) );
	}

	/**
	 * Initialize the plugin.
	 */
	public function init() {
		// Check if Elementor is active
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_elementor' ) );
			return;
		}

		// Add plugin actions
		add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );
		add_action( 'elementor/elements/categories_registered', array( $this, 'add_widget_categories' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'elementor/editor/after_enqueue_scripts', array( $this, 'editor_scripts' ) );
	}

	/**
	 * Admin notice for missing Elementor.
	 */
	public function admin_notice_missing_elementor() {
		?>
		<div class="notice notice-warning is-dismissible">
			<p><?php esc_html_e( 'Ele Slider and Post Addon requires Elementor to be installed and activated.', 'ele-slider-and-post-addon' ); ?></p>
		</div>
		<?php
	}

	/**
	 * Add custom widget category.
	 */
	public function add_widget_categories( $elements_manager ) {
		$elements_manager->add_category(
			'ele-addons',
			array(
				'title' => esc_html__( 'Ele Addons', 'ele-slider-and-post-addon' ),
				'icon'  => 'eicon-gallery-grid',
			)
		);
	}

	/**
	 * Register widgets.
	 */
	public function register_widgets( $widgets_manager ) {
		// Include widget files
		require_once ELESLIDER_PATH . 'widgets/ele-slider.php';
		require_once ELESLIDER_PATH . 'widgets/ele-post.php';
		require_once ELESLIDER_PATH . 'widgets/ele-slider3.php';
		require_once ELESLIDER_PATH . 'widgets/ele-slider4.php';

		// Register widgets
		$widgets_manager->register( new \EleSlider_Slider_Widget() );
		$widgets_manager->register( new \EleSlider_Post_Widget() );
		$widgets_manager->register( new \EleSlider_Slider3_Widget() );
		$widgets_manager->register( new \EleSlider_Slider4_Widget() );
	}

	/**
	 * Enqueue scripts and styles.
	 */
	public function enqueue_scripts() {
		// Register main slider assets
		wp_register_style( 
			'ele-slider-style', 
			ELESLIDER_URL . 'assets/ele-style-slider.css', 
			array(), 
			ELESLIDER_VERSION 
		);
		wp_register_script( 
			'ele-slider-script', 
			ELESLIDER_URL . 'assets/ele-script.js', 
			array( 'jquery' ), 
			ELESLIDER_VERSION, 
			true 
		);

		// Register post widget assets
		wp_register_style( 
			'ele-post-style', 
			ELESLIDER_URL . 'assets/ele-style-post.css', 
			array(), 
			ELESLIDER_VERSION 
		);

		// Register slider3 assets
		wp_register_style( 
			'ele-slider3-style', 
			ELESLIDER_URL . 'assets/ele-slider3.css', 
			array(), 
			ELESLIDER_VERSION 
		);
		wp_register_script( 
			'ele-slider3-script', 
			ELESLIDER_URL . 'assets/ele-slider3.js', 
			array( 'jquery' ), 
			ELESLIDER_VERSION, 
			true 
		);

		// Register slider4 assets (Swiper)
		wp_register_style( 
			'swiper-css', 
			ELESLIDER_URL . 'assets/slider4/swiper-bundle.min.css', 
			array(), 
			ELESLIDER_VERSION 
		);
		wp_register_style( 
			'ele-slider4-style', 
			ELESLIDER_URL . 'assets/slider4/slider4.css', 
			array( 'swiper-css' ), 
			ELESLIDER_VERSION 
		);
		wp_register_script( 
			'swiper-js', 
			ELESLIDER_URL . 'assets/slider4/swiper-bundle.min.js', 
			array(), 
			ELESLIDER_VERSION, 
			true 
		);
		wp_register_script( 
			'ele-slider4-script', 
			ELESLIDER_URL . 'assets/slider4/slider4.js', 
			array( 'jquery', 'swiper-js' ), 
			ELESLIDER_VERSION, 
			true 
		);

		// Register ionicons for slider4
		wp_register_script( 
			'ionicons-esm', 
			ELESLIDER_URL . 'assets/slider4/ionicons.esm.js', 
			array(), 
			ELESLIDER_VERSION, 
			true 
		);
		wp_register_script( 
			'ionicons', 
			ELESLIDER_URL . 'assets/slider4/ionicons.js', 
			array(), 
			ELESLIDER_VERSION, 
			true 
		);
	}

	/**
	 * Enqueue editor scripts.
	 */
	public function editor_scripts() {
		// Enqueue all widget styles for editor preview
		wp_enqueue_style( 'ele-slider-style' );
		wp_enqueue_style( 'ele-post-style' );
		wp_enqueue_style( 'ele-slider3-style' );
		wp_enqueue_style( 'swiper-css' );
		wp_enqueue_style( 'ele-slider4-style' );
		
		// Enqueue scripts for editor functionality
		wp_enqueue_script( 'ele-slider-script' );
		wp_enqueue_script( 'ele-slider3-script' );
		wp_enqueue_script( 'swiper-js' );
		wp_enqueue_script( 'ele-slider4-script' );
	}
}

// Initialize the plugin
new EleSlider_Addon();

