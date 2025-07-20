<?php
/**
 * Ele Slider Widget Class
 *
 * @package EleSlider_And_Post_Addon
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Ele Slider Widget
 */
class EleSlider_Slider_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ele-slider';
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Ele Slider', 'ele-slider-and-post-addon' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-slider-album';
	}

	/**
	 * Get widget categories.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'ele-addons' );
	}

	/**
	 * Get widget keywords.
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return array( 'slider', 'carousel', 'image', 'gallery' );
	}

	/**
	 * Get script dependencies.
	 *
	 * @return array Script dependencies.
	 */
	public function get_script_depends() {
		return array( 'ele-slider-script' );
	}

	/**
	 * Get style dependencies.
	 *
	 * @return array Style dependencies.
	 */
	public function get_style_depends() {
		return array( 'ele-slider-style' );
	}

	/**
	 * Register widget controls.
	 */
	protected function register_controls() {
		// Section for Slide Content.
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Slides', 'ele-slider-and-post-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new \Elementor\Repeater();

		// Background Image.
		$repeater->add_control(
			'background_image',
			array(
				'label'   => esc_html__( 'Background Image', 'ele-slider-and-post-addon' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => array(
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				),
			)
		);

		// Title Text.
		$repeater->add_control(
			'slider_title',
			array(
				'label'       => esc_html__( 'Title', 'ele-slider-and-post-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Sample Title', 'ele-slider-and-post-addon' ),
				'label_block' => true,
			)
		);

		// Description Text.
		$repeater->add_control(
			'slider_description',
			array(
				'label'       => esc_html__( 'Description', 'ele-slider-and-post-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Sample Description', 'ele-slider-and-post-addon' ),
				'label_block' => true,
			)
		);

		// Button Text.
		$repeater->add_control(
			'button_text',
			array(
				'label'       => esc_html__( 'Button Text', 'ele-slider-and-post-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Read More', 'ele-slider-and-post-addon' ),
				'label_block' => true,
			)
		);

		// Button Link.
		$repeater->add_control(
			'button_link',
			array(
				'label'         => esc_html__( 'Button Link', 'ele-slider-and-post-addon' ),
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

		// Add the repeater control.
		$this->add_control(
			'slides',
			array(
				'label'       => esc_html__( 'Slides', 'ele-slider-and-post-addon' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'slider_title'       => esc_html__( 'First Slide Title', 'ele-slider-and-post-addon' ),
						'slider_description' => esc_html__( 'First slide description text', 'ele-slider-and-post-addon' ),
						'button_text'        => esc_html__( 'Read More', 'ele-slider-and-post-addon' ),
					),
					array(
						'slider_title'       => esc_html__( 'Second Slide Title', 'ele-slider-and-post-addon' ),
						'slider_description' => esc_html__( 'Second slide description text', 'ele-slider-and-post-addon' ),
						'button_text'        => esc_html__( 'Learn More', 'ele-slider-and-post-addon' ),
					),
				),
				'title_field' => '{{{ slider_title }}}',
			)
		);

		$this->end_controls_section();

		// Slider Settings Section.
		$this->start_controls_section(
			'slider_settings',
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
			'autoplay_speed',
			array(
				'label'     => esc_html__( 'Autoplay Speed (ms)', 'ele-slider-and-post-addon' ),
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

		$this->end_controls_section();

		// Style Section for Title.
		$this->start_controls_section(
			'title_style',
			array(
				'label' => esc_html__( 'Title', 'ele-slider-and-post-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Color', 'ele-slider-and-post-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ele-slider-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .ele-slider-title',
			)
		);

		$this->add_responsive_control(
			'title_margin',
			array(
				'label'      => esc_html__( 'Margin', 'ele-slider-and-post-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .ele-slider-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// Style Section for Description.
		$this->start_controls_section(
			'description_style',
			array(
				'label' => esc_html__( 'Description', 'ele-slider-and-post-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'description_color',
			array(
				'label'     => esc_html__( 'Color', 'ele-slider-and-post-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ele-slider-description' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .ele-slider-description',
			)
		);

		$this->add_responsive_control(
			'description_margin',
			array(
				'label'      => esc_html__( 'Margin', 'ele-slider-and-post-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .ele-slider-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// Style Section for Button.
		$this->start_controls_section(
			'button_style',
			array(
				'label' => esc_html__( 'Button', 'ele-slider-and-post-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->start_controls_tabs( 'button_style_tabs' );

		$this->start_controls_tab(
			'button_normal',
			array(
				'label' => esc_html__( 'Normal', 'ele-slider-and-post-addon' ),
			)
		);

		$this->add_control(
			'button_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'ele-slider-and-post-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .ele-slider-button' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'ele-slider-and-post-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#007cba',
				'selectors' => array(
					'{{WRAPPER}} .ele-slider-button' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'button_hover',
			array(
				'label' => esc_html__( 'Hover', 'ele-slider-and-post-addon' ),
			)
		);

		$this->add_control(
			'button_hover_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'ele-slider-and-post-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ele-slider-button:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_hover_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'ele-slider-and-post-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ele-slider-button:hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .ele-slider-button',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'button_border',
				'selector' => '{{WRAPPER}} .ele-slider-button',
			)
		);

		$this->add_responsive_control(
			'button_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'ele-slider-and-post-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ele-slider-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'button_padding',
			array(
				'label'      => esc_html__( 'Padding', 'ele-slider-and-post-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .ele-slider-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'button_margin',
			array(
				'label'      => esc_html__( 'Margin', 'ele-slider-and-post-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .ele-slider-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// Style Section for Slider Container.
		$this->start_controls_section(
			'slider_container_style',
			array(
				'label' => esc_html__( 'Slider Container', 'ele-slider-and-post-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'slider_height',
			array(
				'label'      => esc_html__( 'Height', 'ele-slider-and-post-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'vh' ),
				'range'      => array(
					'px' => array(
						'min'  => 200,
						'max'  => 1000,
						'step' => 10,
					),
					'vh' => array(
						'min' => 10,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 500,
				),
				'selectors'  => array(
					'{{WRAPPER}} .ele-slider-container' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'slider_border',
				'selector' => '{{WRAPPER}} .ele-slider-container',
			)
		);

		$this->add_responsive_control(
			'slider_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'ele-slider-and-post-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ele-slider-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'slider_box_shadow',
				'selector' => '{{WRAPPER}} .ele-slider-container',
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

		$this->add_render_attribute(
			'slider-wrapper',
			array(
				'class'         => 'ele-slider-wrapper',
				'data-autoplay' => $settings['autoplay'] === 'yes' ? 'true' : 'false',
				'data-speed'    => isset( $settings['autoplay_speed'] ) ? $settings['autoplay_speed'] : 3000,
			)
		);
		?>
		<div <?php echo $this->get_render_attribute_string( 'slider-wrapper' ); ?>>
			<div class="ele-slider-container">
				<div class="ele-slider-slides">
					<?php foreach ( $settings['slides'] as $index => $slide ) : ?>
						<div class="ele-slider-slide <?php echo 0 === $index ? 'active' : ''; ?>">
							<?php if ( ! empty( $slide['background_image']['url'] ) ) : ?>
								<div class="ele-slider-bg" style="background-image: url(<?php echo esc_url( $slide['background_image']['url'] ); ?>);"></div>
							<?php endif; ?>
							<div class="ele-slider-content">
								<?php if ( ! empty( $slide['slider_title'] ) ) : ?>
									<h2 class="ele-slider-title"><?php echo esc_html( $slide['slider_title'] ); ?></h2>
								<?php endif; ?>
								<?php if ( ! empty( $slide['slider_description'] ) ) : ?>
									<p class="ele-slider-description"><?php echo esc_html( $slide['slider_description'] ); ?></p>
								<?php endif; ?>
								<?php if ( ! empty( $slide['button_text'] ) && ! empty( $slide['button_link']['url'] ) ) : ?>
									<?php
									$this->add_link_attributes( 'button-' . $index, $slide['button_link'] );
									$this->add_render_attribute( 'button-' . $index, 'class', 'ele-slider-button' );
									?>
									<a <?php echo $this->get_render_attribute_string( 'button-' . $index ); ?>>
										<?php echo esc_html( $slide['button_text'] ); ?>
									</a>
								<?php endif; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>

				<?php if ( $settings['show_navigation'] === 'yes' ) : ?>
					<div class="ele-slider-navigation">
						<button class="ele-slider-prev" aria-label="<?php echo esc_attr__( 'Previous slide', 'ele-slider-and-post-addon' ); ?>">
							<i class="fas fa-chevron-left"></i>
						</button>
						<button class="ele-slider-next" aria-label="<?php echo esc_attr__( 'Next slide', 'ele-slider-and-post-addon' ); ?>">
							<i class="fas fa-chevron-right"></i>
						</button>
					</div>
				<?php endif; ?>

				<?php if ( $settings['show_pagination'] === 'yes' ) : ?>
					<div class="ele-slider-pagination">
						<?php foreach ( $settings['slides'] as $index => $slide ) : ?>
							<button class="ele-slider-dot <?php echo 0 === $index ? 'active' : ''; ?>" data-slide="<?php echo esc_attr( $index ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Go to slide %d', 'ele-slider-and-post-addon' ), $index + 1 ) ); ?>"></button>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Render widget output in the editor.
	 */
	protected function content_template() {
		?>
		<#
		if ( settings.slides.length ) {
		#>
		<div class="ele-slider-wrapper" data-autoplay="{{ settings.autoplay }}" data-speed="{{ settings.autoplay_speed }}">
			<div class="ele-slider-container">
				<div class="ele-slider-slides">
					<# _.each( settings.slides, function( slide, index ) { #>
						<div class="ele-slider-slide {{ index === 0 ? 'active' : '' }}">
							<# if ( slide.background_image.url ) { #>
								<div class="ele-slider-bg" style="background-image: url({{ slide.background_image.url }});"></div>
							<# } #>
							<div class="ele-slider-content">
								<# if ( slide.slider_title ) { #>
									<h2 class="ele-slider-title">{{ slide.slider_title }}</h2>
								<# } #>
								<# if ( slide.slider_description ) { #>
									<p class="ele-slider-description">{{ slide.slider_description }}</p>
								<# } #>
								<# if ( slide.button_text && slide.button_link.url ) { #>
									<a href="{{ slide.button_link.url }}" class="ele-slider-button">{{ slide.button_text }}</a>
								<# } #>
							</div>
						</div>
					<# }); #>
				</div>

				<# if ( settings.show_navigation === 'yes' ) { #>
					<div class="ele-slider-navigation">
						<button class="ele-slider-prev"><i class="fas fa-chevron-left"></i></button>
						<button class="ele-slider-next"><i class="fas fa-chevron-right"></i></button>
					</div>
				<# } #>

				<# if ( settings.show_pagination === 'yes' ) { #>
					<div class="ele-slider-pagination">
						<# _.each( settings.slides, function( slide, index ) { #>
							<button class="ele-slider-dot {{ index === 0 ? 'active' : '' }}" data-slide="{{ index }}"></button>
						<# }); #>
					</div>
				<# } #>
			</div>
		</div>
		<#
		}
		#>
		<?php
	}
}
