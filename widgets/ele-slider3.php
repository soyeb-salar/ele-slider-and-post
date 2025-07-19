<?php
class EleSlider_slider3_Widget extends \Elementor\Widget_Base {
    public function get_name() {
        return 'ele-slider3';
    }

    public function get_title() {
        return __( 'Ele Slider-3', 'ele-slider-and-post-addon' );
    }

    public function get_icon() {
        return 'eicon-slider-album';
    }

    public function get_categories() {
        return [ 'ele-kit' ];
    }

    public function get_script_depends() {
        return [ 'ele-script-slider3' ];
    }

    public function get_style_depends() {
        return [ 'ele-style-slider3', 'esp-icon' ];
    }

    protected function register_controls() {
        // Content Section
        $this->start_controls_section(
            'section_content',
            [
                'label' => __( 'Content', 'ele-slider-and-post-addon' ),
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __( 'Title', 'ele-slider-and-post-addon' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'La Pâtisserie Belle', 'ele-slider-and-post-addon' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => __( 'Description', 'ele-slider-and-post-addon' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __( 'Welcome to La Pâtisserie Belle, where every bite is a journey into the exquisite world of finely crafted pastries.', 'ele-slider-and-post-addon' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => __( 'Button Text', 'ele-slider-and-post-addon' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Explore More', 'ele-slider-and-post-addon' ),
                'label_block' => true,
            ]
        );

        // Typography Section
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __( 'Title Typography', 'ele-slider-and-post-addon' ),
                'selector' => '{{WRAPPER}} .ele-slider3 h1',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'label' => __( 'Description Typography', 'ele-slider-and-post-addon' ),
                'selector' => '{{WRAPPER}} .ele-slider3 p',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => __( 'Button Typography', 'ele-slider-and-post-addon' ),
                'selector' => '{{WRAPPER}} .ele-slider3 .btn',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __( 'Title Color', 'ele-slider-and-post-addon' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .ele-slider3 h1' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => __( 'Description Color', 'ele-slider-and-post-addon' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#dddddd',
                'selectors' => [
                    '{{WRAPPER}} .ele-slider3 p' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => __( 'Button Text Color', 'ele-slider-and-post-addon' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .ele-slider3 .btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background',
            [
                'label' => __( 'Button Background Color', 'ele-slider-and-post-addon' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ff6600',
                'selectors' => [
                    '{{WRAPPER}} .ele-slider3 .btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Image Gallery Section
        $this->add_control(
            'images',
            [
                'label' => __( 'Images', 'ele-slider-and-post-addon' ),
                'type' => \Elementor\Controls_Manager::GALLERY,
                'default' => [],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="ele-slider3">
            <main3>
                <div class="content">
                    <h1> <?php echo esc_html( $settings['title'] ); ?> </h1>
                    <p> <?php echo esc_html( $settings['description'] ); ?> </p>
                    <button class="btn">
                        <?php echo esc_html( $settings['button_text'] ); ?>
                    </button>
                </div>
                <div class="stack">
                    <?php if ( ! empty( $settings['images'] ) ) : ?>
                        <?php foreach ( $settings['images'] as $image ) : ?>
                            <div class="card">
                                <img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo isset( $image['alt'] ) ? esc_attr( $image['alt'] ) : ''; ?>" />
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </main3>
        </div>
        <?php
    }
   
}
