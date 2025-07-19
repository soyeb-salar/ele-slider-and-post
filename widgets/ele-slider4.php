<?php
/**
 * Ele Slider4 Widget Class
 *
 * @package EleSlider_And_Post_Addon
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Ele Slider4 Widget
 */
class EleSlider_Slider4_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ele-slider4';
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Ele Slider 4', 'ele-slider-and-post-addon' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-slider-push';
	}

	/**
	 * Get widget categories.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'ele-kit' );
	}

	/**
	 * Get widget keywords.
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return array( 'slider', 'swiper', 'carousel', 'image', 'gallery' );
	}

	/**
	 * Get script dependencies.
	 *
	 * @return array Script dependencies.
	 */
	public function get_script_depends() {
		return array( 'ele-script-slider4-swiper', 'ele-script-slider4' );
	}

	/**
	 * Get style dependencies.
	 *
	 * @return array Style dependencies.
	 */
	public function get_style_depends() {
		return array( 'ele-style-slider4', 'ele-style-slider4-custom' );
	}

	/**
	 * Register widget controls.
	 */
	protected function register_controls() {
		// Content Section.
		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Content', 'ele-slider-and-post-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Title', 'ele-slider-and-post-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Premium Slider', 'ele-slider-and-post-addon' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'subtitle',
			array(
				'label'       => esc_html__( 'Subtitle', 'ele-slider-and-post-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Modern & Responsive', 'ele-slider-and-post-addon' ),
				'label_block' => true,
			)
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'slide_image',
			array(
				'label'   => esc_html__( 'Slide Image', 'ele-slider-and-post-addon' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => array(
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				),
			)
		);

		$repeater->add_control(
			'slide_title',
			array(
				'label'       => esc_html__( 'Slide Title', 'ele-slider-and-post-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Slide Title', 'ele-slider-and-post-addon' ),
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'slide_description',
			array(
				'label'       => esc_html__( 'Slide Description', 'ele-slider-and-post-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Slide description text', 'ele-slider-and-post-addon' ),
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'slide_link',
			array(
				'label'         => esc_html__( 'Slide Link', 'ele-slider-and-post-addon' ),
				'type'          => \Elementor\Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'ele-slider-and-post-addon' ),
				'show_external' => true,
				'default'       => array(
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				),
			)
		);

		$this->add_control(
			'slides',
			array(
				'label'       => esc_html__( 'Slides', 'ele-slider-and-post-addon' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'slide_title'       => esc_html__( 'First Slide', 'ele-slider-and-post-addon' ),
						'slide_description' => esc_html__( 'This is the first slide description', 'ele-slider-and-post-addon' ),
					),
					array(
						'slide_title'       => esc_html__( 'Second Slide', 'ele-slider-and-post-addon' ),
						'slide_description' => esc_html__( 'This is the second slide description', 'ele-slider-and-post-addon' ),
					),
					array(
						'slide_title'       => esc_html__( 'Third Slide', 'ele-slider-and-post-addon' ),
						'slide_description' => esc_html__( 'This is the third slide description', 'ele-slider-and-post-addon' ),
					),
				),
				'title_field' => '{{{ slide_title }}}',
			)
		);

		$this->end_controls_section();

		// Slider Settings Section.
		$this->start_controls_section(
			'section_slider_settings',
			array(
				'label' => esc_html__( 'Slider Settings', 'ele-slider-and-post-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'autoplay',
			array(
				'label'        => esc_html__( 'Autoplay', 'ele-slider-and-post-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'ele-slider-and-post-addon' ),
				'label_off'    => esc_html__( 'No', 'ele-slider-and-post-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'autoplay_delay',
			array(
				'label'     => esc_html__( 'Autoplay Delay (ms)', 'ele-slider-and-post-addon' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'default'   => 3000,
				'min'       => 1000,
				'max'       => 10000,
				'step'      => 100,
				'condition' => array(
					'autoplay' => 'yes',
				),
			)
		);

		$this->add_control(
			'show_navigation',
			array(
				'label'        => esc_html__( 'Show Navigation', 'ele-slider-and-post-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'ele-slider-and-post-addon' ),
				'label_off'    => esc_html__( 'No', 'ele-slider-and-post-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'show_pagination',
			array(
				'label'        => esc_html__( 'Show Pagination', 'ele-slider-and-post-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'ele-slider-and-post-addon' ),
				'label_off'    => esc_html__( 'No', 'ele-slider-and-post-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'loop',
			array(
				'label'        => esc_html__( 'Loop', 'ele-slider-and-post-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'ele-slider-and-post-addon' ),
				'label_off'    => esc_html__( 'No', 'ele-slider-and-post-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'effect',
			array(
				'label'   => esc_html__( 'Effect', 'ele-slider-and-post-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'slide'     => esc_html__( 'Slide', 'ele-slider-and-post-addon' ),
					'fade'      => esc_html__( 'Fade', 'ele-slider-and-post-addon' ),
					'cube'      => esc_html__( 'Cube', 'ele-slider-and-post-addon' ),
					'coverflow' => esc_html__( 'Coverflow', 'ele-slider-and-post-addon' ),
					'flip'      => esc_html__( 'Flip', 'ele-slider-and-post-addon' ),
				),
				'default' => 'slide',
			)
		);

		$this->end_controls_section();

		// Style Section for Title.
		$this->start_controls_section(
			'section_style_title',
			array(
				'label' => esc_html__( 'Main Title', 'ele-slider-and-post-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Color', 'ele-slider-and-post-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .slider4-main-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .slider4-main-title',
			)
		);

		$this->add_responsive_control(
			'title_margin',
			array(
				'label'      => esc_html__( 'Margin', 'ele-slider-and-post-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .slider4-main-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// Style Section for Slide Content.
		$this->start_controls_section(
			'section_style_slide_content',
			array(
				'label' => esc_html__( 'Slide Content', 'ele-slider-and-post-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'slide_title_color',
			array(
				'label'     => esc_html__( 'Slide Title Color', 'ele-slider-and-post-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .slider4-slide-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'slide_title_typography',
				'label'    => esc_html__( 'Slide Title Typography', 'ele-slider-and-post-addon' ),
				'selector' => '{{WRAPPER}} .slider4-slide-title',
			)
		);

		$this->add_control(
			'slide_description_color',
			array(
				'label'     => esc_html__( 'Slide Description Color', 'ele-slider-and-post-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#cccccc',
				'selectors' => array(
					'{{WRAPPER}} .slider4-slide-description' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'slide_description_typography',
				'label'    => esc_html__( 'Slide Description Typography', 'ele-slider-and-post-addon' ),
				'selector' => '{{WRAPPER}} .slider4-slide-description',
			)
		);

		$this->end_controls_section();

		// Style Section for Container.
		$this->start_controls_section(
			'section_style_container',
			array(
				'label' => esc_html__( 'Container', 'ele-slider-and-post-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'container_height',
			array(
				'label'      => esc_html__( 'Height', 'ele-slider-and-post-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'vh' ),
				'range'      => array(
					'px' => array(
						'min'  => 300,
						'max'  => 1000,
						'step' => 10,
					),
					'vh' => array(
						'min' => 30,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 600,
				),
				'selectors'  => array(
					'{{WRAPPER}} .slider4-container' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'container_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'ele-slider-and-post-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => array(
					'{{WRAPPER}} .slider4-container' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'container_border',
				'selector' => '{{WRAPPER}} .slider4-container',
			)
		);

		$this->add_responsive_control(
			'container_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'ele-slider-and-post-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .slider4-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'container_box_shadow',
				'selector' => '{{WRAPPER}} .slider4-container',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['slides'] ) ) {
			return;
		}

		$slider_id = 'slider4-' . $this->get_id();
		?>
		<div class="slider4-container" id="<?php echo esc_attr( $slider_id ); ?>">
			<?php if ( ! empty( $settings['title'] ) || ! empty( $settings['subtitle'] ) ) : ?>
				<div class="slider4-header">
					<?php if ( ! empty( $settings['title'] ) ) : ?>
						<h2 class="slider4-main-title"><?php echo esc_html( $settings['title'] ); ?></h2>
					<?php endif; ?>
					<?php if ( ! empty( $settings['subtitle'] ) ) : ?>
						<p class="slider4-subtitle"><?php echo esc_html( $settings['subtitle'] ); ?></p>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<div class="swiper">
				<div class="swiper-wrapper">
					<?php foreach ( $settings['slides'] as $index => $slide ) : ?>
						<div class="swiper-slide">
							<?php if ( ! empty( $slide['slide_image']['url'] ) ) : ?>
								<div class="slider4-slide-bg" style="background-image: url(<?php echo esc_url( $slide['slide_image']['url'] ); ?>);"></div>
							<?php endif; ?>
							<div class="slider4-slide-content">
								<?php if ( ! empty( $slide['slide_title'] ) ) : ?>
									<h3 class="slider4-slide-title"><?php echo esc_html( $slide['slide_title'] ); ?></h3>
								<?php endif; ?>
								<?php if ( ! empty( $slide['slide_description'] ) ) : ?>
									<p class="slider4-slide-description"><?php echo esc_html( $slide['slide_description'] ); ?></p>
								<?php endif; ?>
								<?php if ( ! empty( $slide['slide_link']['url'] ) ) : ?>
									<?php
									$this->add_link_attributes( 'slide-link-' . $index, $slide['slide_link'] );
									?>
									<a <?php echo $this->get_render_attribute_string( 'slide-link-' . $index ); ?> class="slider4-slide-link">
										<?php esc_html_e( 'Learn More', 'ele-slider-and-post-addon' ); ?>
									</a>
								<?php endif; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>

				<?php if ( 'yes' === $settings['show_pagination'] ) : ?>
					<div class="swiper-pagination"></div>
				<?php endif; ?>

				<?php if ( 'yes' === $settings['show_navigation'] ) : ?>
					<div class="swiper-button-prev"></div>
					<div class="swiper-button-next"></div>
				<?php endif; ?>
			</div>
		</div>

		<script>
		document.addEventListener('DOMContentLoaded', function() {
			if (typeof Swiper !== 'undefined') {
				new Swiper('#<?php echo esc_js( $slider_id ); ?> .swiper', {
					<?php if ( 'yes' === $settings['loop'] ) : ?>
					loop: true,
					<?php endif; ?>
					<?php if ( 'yes' === $settings['autoplay'] ) : ?>
					autoplay: {
						delay: <?php echo intval( $settings['autoplay_delay'] ); ?>,
					},
					<?php endif; ?>
					effect: '<?php echo esc_js( $settings['effect'] ); ?>',
					<?php if ( 'yes' === $settings['show_pagination'] ) : ?>
					pagination: {
						el: '#<?php echo esc_js( $slider_id ); ?> .swiper-pagination',
						clickable: true,
					},
					<?php endif; ?>
					<?php if ( 'yes' === $settings['show_navigation'] ) : ?>
					navigation: {
						nextEl: '#<?php echo esc_js( $slider_id ); ?> .swiper-button-next',
						prevEl: '#<?php echo esc_js( $slider_id ); ?> .swiper-button-prev',
					},
					<?php endif; ?>
				});
			}
		});
		</script>
		<?php
	}

	/**
	 * Render widget output in the editor.
	 */
	protected function content_template() {
		?>
		<#
		if ( settings.slides.length ) {
		var sliderId = 'slider4-' + view.model.id;
		#>
		<div class="slider4-container" id="{{ sliderId }}">
			<# if ( settings.title || settings.subtitle ) { #>
				<div class="slider4-header">
					<# if ( settings.title ) { #>
						<h2 class="slider4-main-title">{{ settings.title }}</h2>
					<# } #>
					<# if ( settings.subtitle ) { #>
						<p class="slider4-subtitle">{{ settings.subtitle }}</p>
					<# } #>
				</div>
			<# } #>

			<div class="swiper">
				<div class="swiper-wrapper">
					<# _.each( settings.slides, function( slide, index ) { #>
						<div class="swiper-slide">
							<# if ( slide.slide_image.url ) { #>
								<div class="slider4-slide-bg" style="background-image: url({{ slide.slide_image.url }});"></div>
							<# } #>
							<div class="slider4-slide-content">
								<# if ( slide.slide_title ) { #>
									<h3 class="slider4-slide-title">{{ slide.slide_title }}</h3>
								<# } #>
								<# if ( slide.slide_description ) { #>
									<p class="slider4-slide-description">{{ slide.slide_description }}</p>
								<# } #>
								<# if ( slide.slide_link.url ) { #>
									<a href="{{ slide.slide_link.url }}" class="slider4-slide-link">Learn More</a>
								<# } #>
							</div>
						</div>
					<# }); #>
				</div>

				<# if ( settings.show_pagination === 'yes' ) { #>
					<div class="swiper-pagination"></div>
				<# } #>

				<# if ( settings.show_navigation === 'yes' ) { #>
					<div class="swiper-button-prev"></div>
					<div class="swiper-button-next"></div>
				<# } #>
			</div>
		</div>
		<#
		}
		#>
		<?php
	}
}
?>


































































































