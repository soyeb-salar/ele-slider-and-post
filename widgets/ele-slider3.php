<?php
/**
 * Ele Slider3 Widget Class
 *
 * @package EleSlider_And_Post_Addon
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Ele Slider3 Widget
 */
class EleSlider_Slider3_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ele-slider3';
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Ele Slider 3', 'ele-slider-and-post-addon' );
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
		return array( 'slider', 'carousel', 'image', 'gallery', 'showcase' );
	}

	/**
	 * Get script dependencies.
	 *
	 * @return array Script dependencies.
	 */
	public function get_script_depends() {
		return array( 'ele-script-slider3' );
	}

	/**
	 * Get style dependencies.
	 *
	 * @return array Style dependencies.
	 */
	public function get_style_depends() {
		return array( 'ele-style-slider3' );
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
				'default'     => esc_html__( 'La Pâtisserie Belle', 'ele-slider-and-post-addon' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'description',
			array(
				'label'       => esc_html__( 'Description', 'ele-slider-and-post-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Discover our exquisite collection of artisanal pastries', 'ele-slider-and-post-addon' ),
				'label_block' => true,
			)
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'image',
			array(
				'label'   => esc_html__( 'Image', 'ele-slider-and-post-addon' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => array(
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				),
			)
		);

		$repeater->add_control(
			'image_title',
			array(
				'label'       => esc_html__( 'Image Title', 'ele-slider-and-post-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Sample Item', 'ele-slider-and-post-addon' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'gallery_items',
			array(
				'label'       => esc_html__( 'Gallery Items', 'ele-slider-and-post-addon' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'image_title' => esc_html__( 'Croissant', 'ele-slider-and-post-addon' ),
					),
					array(
						'image_title' => esc_html__( 'Macarons', 'ele-slider-and-post-addon' ),
					),
					array(
						'image_title' => esc_html__( 'Éclair', 'ele-slider-and-post-addon' ),
					),
				),
				'title_field' => '{{{ image_title }}}',
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
					'{{WRAPPER}} .slider3-container' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'container_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'ele-slider-and-post-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#1a1a1a',
				'selectors' => array(
					'{{WRAPPER}} .slider3-container' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'container_border',
				'selector' => '{{WRAPPER}} .slider3-container',
			)
		);

		$this->add_responsive_control(
			'container_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'ele-slider-and-post-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .slider3-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'container_box_shadow',
				'selector' => '{{WRAPPER}} .slider3-container',
			)
		);

		$this->end_controls_section();

		// Style Section for Title.
		$this->start_controls_section(
			'section_style_title',
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
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .slider3-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .slider3-title',
			)
		);

		$this->add_responsive_control(
			'title_margin',
			array(
				'label'      => esc_html__( 'Margin', 'ele-slider-and-post-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .slider3-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// Style Section for Description.
		$this->start_controls_section(
			'section_style_description',
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
				'default'   => '#cccccc',
				'selectors' => array(
					'{{WRAPPER}} .slider3-description' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .slider3-description',
			)
		);

		$this->add_responsive_control(
			'description_margin',
			array(
				'label'      => esc_html__( 'Margin', 'ele-slider-and-post-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .slider3-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// Style Section for Gallery Items.
		$this->start_controls_section(
			'section_style_gallery',
			array(
				'label' => esc_html__( 'Gallery Items', 'ele-slider-and-post-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'gallery_item_size',
			array(
				'label'      => esc_html__( 'Item Size', 'ele-slider-and-post-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 50,
						'max'  => 200,
						'step' => 5,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 100,
				),
				'selectors'  => array(
					'{{WRAPPER}} .slider3-gallery-item' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'gallery_item_border',
				'selector' => '{{WRAPPER}} .slider3-gallery-item',
			)
		);

		$this->add_responsive_control(
			'gallery_item_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'ele-slider-and-post-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .slider3-gallery-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'gallery_item_box_shadow',
				'selector' => '{{WRAPPER}} .slider3-gallery-item',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['gallery_items'] ) ) {
			return;
		}
		?>
		<div class="slider3-container">
			<div class="slider3-content">
				<?php if ( ! empty( $settings['title'] ) ) : ?>
					<h2 class="slider3-title"><?php echo esc_html( $settings['title'] ); ?></h2>
				<?php endif; ?>

				<?php if ( ! empty( $settings['description'] ) ) : ?>
					<p class="slider3-description"><?php echo esc_html( $settings['description'] ); ?></p>
				<?php endif; ?>

				<div class="slider3-gallery">
					<?php foreach ( $settings['gallery_items'] as $index => $item ) : ?>
						<div class="slider3-gallery-item" data-index="<?php echo esc_attr( $index ); ?>">
							<?php if ( ! empty( $item['image']['url'] ) ) : ?>
								<img src="<?php echo esc_url( $item['image']['url'] ); ?>" alt="<?php echo esc_attr( $item['image_title'] ); ?>" loading="lazy">
							<?php endif; ?>
							<?php if ( ! empty( $item['image_title'] ) ) : ?>
								<div class="slider3-item-title"><?php echo esc_html( $item['image_title'] ); ?></div>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="slider3-main-display">
				<?php if ( ! empty( $settings['gallery_items'][0]['image']['url'] ) ) : ?>
					<img id="slider3-main-image" src="<?php echo esc_url( $settings['gallery_items'][0]['image']['url'] ); ?>" alt="<?php echo esc_attr( $settings['gallery_items'][0]['image_title'] ?? '' ); ?>" loading="lazy">
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
		if ( settings.gallery_items.length ) {
		#>
		<div class="slider3-container">
			<div class="slider3-content">
				<# if ( settings.title ) { #>
					<h2 class="slider3-title">{{ settings.title }}</h2>
				<# } #>

				<# if ( settings.description ) { #>
					<p class="slider3-description">{{ settings.description }}</p>
				<# } #>

				<div class="slider3-gallery">
					<# _.each( settings.gallery_items, function( item, index ) { #>
						<div class="slider3-gallery-item" data-index="{{ index }}">
							<# if ( item.image.url ) { #>
								<img src="{{ item.image.url }}" alt="{{ item.image_title }}">
							<# } #>
							<# if ( item.image_title ) { #>
								<div class="slider3-item-title">{{ item.image_title }}</div>
							<# } #>
						</div>
					<# }); #>
				</div>
			</div>

			<div class="slider3-main-display">
				<# if ( settings.gallery_items[0] && settings.gallery_items[0].image.url ) { #>
					<img id="slider3-main-image" src="{{ settings.gallery_items[0].image.url }}" alt="{{ settings.gallery_items[0].image_title }}">
				<# } #>
			</div>
		</div>
		<#
		}
		#>
		<?php
	}
}
