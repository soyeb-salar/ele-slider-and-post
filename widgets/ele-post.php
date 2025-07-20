<?php
/**
 * Ele Post Widget Class
 *
 * @package EleSlider_And_Post_Addon
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Ele Post Widget
 */
class EleSlider_Post_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ele-post';
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Ele Post', 'ele-slider-and-post-addon' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-posts-grid';
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
		return array( 'post', 'blog', 'content', 'grid', 'list' );
	}

	/**
	 * Get script dependencies.
	 *
	 * @return array Script dependencies.
	 */
	public function get_script_depends() {
		return array( 'ele-script' );
	}

	/**
	 * Get style dependencies.
	 *
	 * @return array Style dependencies.
	 */
	public function get_style_depends() {
		return array( 'ele-post-style' );
	}

	/**
	 * Register widget controls.
	 */
	protected function register_controls() {
		// Content Section.
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Content', 'ele-slider-and-post-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$post_types = get_post_types( array( 'public' => true ), 'objects' );
		$post_type_options = array();
		foreach ( $post_types as $post_type ) {
			$post_type_options[ $post_type->name ] = $post_type->label;
		}

		$this->add_control(
			'post_type',
			array(
				'label'   => esc_html__( 'Select Post Type', 'ele-slider-and-post-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => $post_type_options,
				'default' => 'post',
			)
		);

		$this->add_control(
			'posts_per_page',
			array(
				'label'   => esc_html__( 'Number of Posts', 'ele-slider-and-post-addon' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 6,
				'min'     => 1,
				'max'     => 50,
			)
		);

		$this->add_control(
			'columns',
			array(
				'label'   => esc_html__( 'Columns', 'ele-slider-and-post-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'1' => esc_html__( '1 Column', 'ele-slider-and-post-addon' ),
					'2' => esc_html__( '2 Columns', 'ele-slider-and-post-addon' ),
					'3' => esc_html__( '3 Columns', 'ele-slider-and-post-addon' ),
					'4' => esc_html__( '4 Columns', 'ele-slider-and-post-addon' ),
				),
				'default' => '3',
			)
		);

		$this->add_control(
			'orderby',
			array(
				'label'   => esc_html__( 'Order By', 'ele-slider-and-post-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'date'       => esc_html__( 'Date', 'ele-slider-and-post-addon' ),
					'title'      => esc_html__( 'Title', 'ele-slider-and-post-addon' ),
					'menu_order' => esc_html__( 'Menu Order', 'ele-slider-and-post-addon' ),
					'rand'       => esc_html__( 'Random', 'ele-slider-and-post-addon' ),
				),
				'default' => 'date',
			)
		);

		$this->add_control(
			'order',
			array(
				'label'   => esc_html__( 'Order', 'ele-slider-and-post-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'ASC'  => esc_html__( 'Ascending', 'ele-slider-and-post-addon' ),
					'DESC' => esc_html__( 'Descending', 'ele-slider-and-post-addon' ),
				),
				'default' => 'DESC',
			)
		);

		$this->add_control(
			'show_featured_image',
			array(
				'label'        => esc_html__( 'Show Featured Image', 'ele-slider-and-post-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'ele-slider-and-post-addon' ),
				'label_off'    => esc_html__( 'No', 'ele-slider-and-post-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'image_size',
			array(
				'label'     => esc_html__( 'Image Size', 'ele-slider-and-post-addon' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => $this->get_available_image_sizes(),
				'default'   => 'medium',
				'condition' => array(
					'show_featured_image' => 'yes',
				),
			)
		);

		$this->add_control(
			'show_title',
			array(
				'label'        => esc_html__( 'Show Title', 'ele-slider-and-post-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'ele-slider-and-post-addon' ),
				'label_off'    => esc_html__( 'No', 'ele-slider-and-post-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'show_excerpt',
			array(
				'label'        => esc_html__( 'Show Excerpt', 'ele-slider-and-post-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'ele-slider-and-post-addon' ),
				'label_off'    => esc_html__( 'No', 'ele-slider-and-post-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'excerpt_length',
			array(
				'label'     => esc_html__( 'Excerpt Length', 'ele-slider-and-post-addon' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'default'   => 20,
				'min'       => 5,
				'max'       => 100,
				'condition' => array(
					'show_excerpt' => 'yes',
				),
			)
		);

		$this->add_control(
			'show_read_more',
			array(
				'label'        => esc_html__( 'Show Read More', 'ele-slider-and-post-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'ele-slider-and-post-addon' ),
				'label_off'    => esc_html__( 'No', 'ele-slider-and-post-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'read_more_text',
			array(
				'label'     => esc_html__( 'Read More Text', 'ele-slider-and-post-addon' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( 'Read More', 'ele-slider-and-post-addon' ),
				'condition' => array(
					'show_read_more' => 'yes',
				),
			)
		);

		$this->add_control(
			'show_meta',
			array(
				'label'        => esc_html__( 'Show Post Meta', 'ele-slider-and-post-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'ele-slider-and-post-addon' ),
				'label_off'    => esc_html__( 'No', 'ele-slider-and-post-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'meta_separator',
			array(
				'label'     => esc_html__( 'Meta Separator', 'ele-slider-and-post-addon' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => ' | ',
				'condition' => array(
					'show_meta' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		// Query Section.
		$this->start_controls_section(
			'query_section',
			array(
				'label' => esc_html__( 'Query', 'ele-slider-and-post-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'include_by',
			array(
				'label'   => esc_html__( 'Include By', 'ele-slider-and-post-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					''           => esc_html__( 'None', 'ele-slider-and-post-addon' ),
					'categories' => esc_html__( 'Categories', 'ele-slider-and-post-addon' ),
					'tags'       => esc_html__( 'Tags', 'ele-slider-and-post-addon' ),
				),
				'default' => '',
			)
		);

		$this->add_control(
			'include_categories',
			array(
				'label'     => esc_html__( 'Categories', 'ele-slider-and-post-addon' ),
				'type'      => \Elementor\Controls_Manager::SELECT2,
				'options'   => $this->get_post_categories(),
				'multiple'  => true,
				'condition' => array(
					'include_by' => 'categories',
				),
			)
		);

		$this->add_control(
			'include_tags',
			array(
				'label'     => esc_html__( 'Tags', 'ele-slider-and-post-addon' ),
				'type'      => \Elementor\Controls_Manager::SELECT2,
				'options'   => $this->get_post_tags(),
				'multiple'  => true,
				'condition' => array(
					'include_by' => 'tags',
				),
			)
		);

		$this->add_control(
			'exclude_posts',
			array(
				'label'       => esc_html__( 'Exclude Posts', 'ele-slider-and-post-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Post IDs separated by commas', 'ele-slider-and-post-addon' ),
				'description' => esc_html__( 'Enter post IDs separated by commas to exclude them from the query.', 'ele-slider-and-post-addon' ),
			)
		);

		$this->end_controls_section();

		// Style Section for Container.
		$this->start_controls_section(
			'container_style',
			array(
				'label' => esc_html__( 'Container', 'ele-slider-and-post-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'container_gap',
			array(
				'label'      => esc_html__( 'Gap', 'ele-slider-and-post-addon' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 20,
				),
				'selectors'  => array(
					'{{WRAPPER}} .ele-posts-grid' => 'gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// Style Section for Post Item.
		$this->start_controls_section(
			'post_item_style',
			array(
				'label' => esc_html__( 'Post Item', 'ele-slider-and-post-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'post_item_border',
				'selector' => '{{WRAPPER}} .ele-post-item',
			)
		);

		$this->add_responsive_control(
			'post_item_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'ele-slider-and-post-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ele-post-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'post_item_box_shadow',
				'selector' => '{{WRAPPER}} .ele-post-item',
			)
		);

		$this->add_responsive_control(
			'post_item_padding',
			array(
				'label'      => esc_html__( 'Padding', 'ele-slider-and-post-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .ele-post-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'post_item_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'ele-slider-and-post-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ele-post-item' => 'background-color: {{VALUE}};',
				),
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
					'{{WRAPPER}} .ele-post-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'title_hover_color',
			array(
				'label'     => esc_html__( 'Hover Color', 'ele-slider-and-post-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ele-post-title:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .ele-post-title',
			)
		);

		$this->add_responsive_control(
			'title_margin',
			array(
				'label'      => esc_html__( 'Margin', 'ele-slider-and-post-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .ele-post-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// Style Section for Excerpt.
		$this->start_controls_section(
			'excerpt_style',
			array(
				'label' => esc_html__( 'Excerpt', 'ele-slider-and-post-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'excerpt_color',
			array(
				'label'     => esc_html__( 'Color', 'ele-slider-and-post-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ele-post-excerpt' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'excerpt_typography',
				'selector' => '{{WRAPPER}} .ele-post-excerpt',
			)
		);

		$this->add_responsive_control(
			'excerpt_margin',
			array(
				'label'      => esc_html__( 'Margin', 'ele-slider-and-post-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .ele-post-excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// Style Section for Meta.
		$this->start_controls_section(
			'meta_style',
			array(
				'label' => esc_html__( 'Meta', 'ele-slider-and-post-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'meta_color',
			array(
				'label'     => esc_html__( 'Color', 'ele-slider-and-post-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ele-post-meta' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'meta_typography',
				'selector' => '{{WRAPPER}} .ele-post-meta',
			)
		);

		$this->add_responsive_control(
			'meta_margin',
			array(
				'label'      => esc_html__( 'Margin', 'ele-slider-and-post-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .ele-post-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// Style Section for Read More Button.
		$this->start_controls_section(
			'read_more_style',
			array(
				'label' => esc_html__( 'Read More Button', 'ele-slider-and-post-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->start_controls_tabs( 'read_more_style_tabs' );

		$this->start_controls_tab(
			'read_more_normal',
			array(
				'label' => esc_html__( 'Normal', 'ele-slider-and-post-addon' ),
			)
		);

		$this->add_control(
			'read_more_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'ele-slider-and-post-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#007cba',
				'selectors' => array(
					'{{WRAPPER}} .ele-post-read-more' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'read_more_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'ele-slider-and-post-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ele-post-read-more' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'read_more_hover',
			array(
				'label' => esc_html__( 'Hover', 'ele-slider-and-post-addon' ),
			)
		);

		$this->add_control(
			'read_more_hover_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'ele-slider-and-post-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ele-post-read-more:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'read_more_hover_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'ele-slider-and-post-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ele-post-read-more:hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'read_more_typography',
				'selector' => '{{WRAPPER}} .ele-post-read-more',
			)
		);

		$this->add_responsive_control(
			'read_more_padding',
			array(
				'label'      => esc_html__( 'Padding', 'ele-slider-and-post-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .ele-post-read-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'read_more_margin',
			array(
				'label'      => esc_html__( 'Margin', 'ele-slider-and-post-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .ele-post-read-more' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'read_more_border',
				'selector' => '{{WRAPPER}} .ele-post-read-more',
			)
		);

		$this->add_responsive_control(
			'read_more_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'ele-slider-and-post-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ele-post-read-more' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Get available image sizes.
	 *
	 * @return array Available image sizes.
	 */
	private function get_available_image_sizes() {
		$image_sizes = get_intermediate_image_sizes();
		$sizes = array();

		foreach ( $image_sizes as $size ) {
			$sizes[ $size ] = ucwords( str_replace( '_', ' ', $size ) );
		}

		$sizes['full'] = esc_html__( 'Full Size', 'ele-slider-and-post-addon' );

		return $sizes;
	}

	/**
	 * Get post categories.
	 *
	 * @return array Post categories.
	 */
	private function get_post_categories() {
		$categories = get_categories();
		$options = array();

		foreach ( $categories as $category ) {
			$options[ $category->term_id ] = $category->name;
		}

		return $options;
	}

	/**
	 * Get post tags.
	 *
	 * @return array Post tags.
	 */
	private function get_post_tags() {
		$tags = get_tags();
		$options = array();

		foreach ( $tags as $tag ) {
			$options[ $tag->term_id ] = $tag->name;
		}

		return $options;
	}

	/**
	 * Render widget output on the frontend.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		// Build query arguments.
		$args = array(
			'post_type'      => sanitize_text_field( $settings['post_type'] ),
			'posts_per_page' => intval( $settings['posts_per_page'] ),
			'orderby'        => sanitize_text_field( $settings['orderby'] ),
			'order'          => sanitize_text_field( $settings['order'] ),
			'post_status'    => 'publish',
		);

		// Handle category filtering.
		if ( 'categories' === $settings['include_by'] && ! empty( $settings['include_categories'] ) ) {
			$args['cat'] = implode( ',', array_map( 'intval', $settings['include_categories'] ) );
		}

		// Handle tag filtering.
		if ( 'tags' === $settings['include_by'] && ! empty( $settings['include_tags'] ) ) {
			$args['tag__in'] = array_map( 'intval', $settings['include_tags'] );
		}

		// Handle excluded posts.
		if ( ! empty( $settings['exclude_posts'] ) ) {
			$excluded_ids = explode( ',', $settings['exclude_posts'] );
			$excluded_ids = array_map( 'trim', $excluded_ids );
			$excluded_ids = array_map( 'intval', $excluded_ids );
			$excluded_ids = array_filter( $excluded_ids );
			if ( ! empty( $excluded_ids ) ) {
				$args['post__not_in'] = $excluded_ids;
			}
		}

		// Execute query.
		$query = new \WP_Query( $args );

		if ( ! $query->have_posts() ) {
			echo '<p>' . esc_html__( 'No posts found.', 'ele-slider-and-post-addon' ) . '</p>';
			return;
		}

		$columns = intval( $settings['columns'] );
		?>
		<div class="ele-posts-grid ele-posts-columns-<?php echo esc_attr( $columns ); ?>">
			<?php
			while ( $query->have_posts() ) :
				$query->the_post();
				?>
				<article class="ele-post-item">
					<?php if ( 'yes' === $settings['show_featured_image'] && has_post_thumbnail() ) : ?>
						<div class="ele-post-thumbnail">
							<a href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail( $settings['image_size'], array( 'class' => 'ele-post-image' ) ); ?>
							</a>
						</div>
					<?php endif; ?>

					<div class="ele-post-content">
						<?php if ( 'yes' === $settings['show_title'] ) : ?>
							<h3 class="ele-post-title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h3>
						<?php endif; ?>

						<?php if ( 'yes' === $settings['show_meta'] ) : ?>
							<div class="ele-post-meta">
								<span class="ele-post-date"><?php echo get_the_date(); ?></span>
								<?php if ( ! empty( $settings['meta_separator'] ) ) : ?>
									<span class="ele-meta-separator"><?php echo esc_html( $settings['meta_separator'] ); ?></span>
								<?php endif; ?>
								<span class="ele-post-author"><?php the_author(); ?></span>
							</div>
						<?php endif; ?>

						<?php if ( 'yes' === $settings['show_excerpt'] ) : ?>
							<div class="ele-post-excerpt">
								<?php
								$excerpt_length = intval( $settings['excerpt_length'] );
								$excerpt = wp_trim_words( get_the_excerpt(), $excerpt_length, '...' );
								echo esc_html( $excerpt );
								?>
							</div>
						<?php endif; ?>

						<?php if ( 'yes' === $settings['show_read_more'] && ! empty( $settings['read_more_text'] ) ) : ?>
							<div class="ele-post-read-more-wrapper">
								<a href="<?php the_permalink(); ?>" class="ele-post-read-more">
									<?php echo esc_html( $settings['read_more_text'] ); ?>
								</a>
							</div>
						<?php endif; ?>
					</div>
				</article>
				<?php
			endwhile;
			wp_reset_postdata();
			?>
		</div>
		<?php
	}

	/**
	 * Render widget output in the editor.
	 */
	protected function content_template() {
		?>
		<#
		// Note: This is a simplified template for the editor preview
		// In a real implementation, you would need to handle the PHP queries differently
		#>
		<div class="ele-posts-grid ele-posts-columns-{{ settings.columns }}">
			<# for ( var i = 1; i <= 3; i++ ) { #>
				<article class="ele-post-item">
					<# if ( settings.show_featured_image === 'yes' ) { #>
						<div class="ele-post-thumbnail">
							<img src="<?php echo esc_url( \Elementor\Utils::get_placeholder_image_src() ); ?>" alt="Placeholder" class="ele-post-image">
						</div>
					<# } #>
					<div class="ele-post-content">
						<# if ( settings.show_title === 'yes' ) { #>
							<h3 class="ele-post-title">Sample Post Title {{ i }}</h3>
						<# } #>
						<# if ( settings.show_meta === 'yes' ) { #>
							<div class="ele-post-meta">
								<span class="ele-post-date"><?php echo esc_html( date( 'F j, Y' ) ); ?></span>
								<# if ( settings.meta_separator ) { #>
									<span class="ele-meta-separator">{{ settings.meta_separator }}</span>
								<# } #>
								<span class="ele-post-author">Author Name</span>
							</div>
						<# } #>
						<# if ( settings.show_excerpt === 'yes' ) { #>
							<div class="ele-post-excerpt">
								This is a sample excerpt for the post. It shows how the excerpt will look in the frontend.
							</div>
						<# } #>
						<# if ( settings.show_read_more === 'yes' && settings.read_more_text ) { #>
							<div class="ele-post-read-more-wrapper">
								<a href="#" class="ele-post-read-more">{{ settings.read_more_text }}</a>
							</div>
						<# } #>
					</div>
				</article>
			<# } #>
		</div>
		<?php
	}
}
