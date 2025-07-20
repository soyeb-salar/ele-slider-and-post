<?php
class EleSlider_slider4_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'ele-slider4';
    }

    public function get_title() {
        return __( 'Ele Slider-4', 'ele-slider-and-post-addon' );
    }

    public function get_icon() {
        return 'eicon-';
    }

    public function get_categories() {
        return [ 'ele-kit' ];
    }

    public function get_script_depends() {
        return [ 'ele-script-slider4','ele-script-slider4-swiper','ele-script-slider4-ion-esm','ele-script-slider4-swiper-ion'];
    }

    public function get_style_depends() {
        return [ 'ele-style-slider4', 'ele-style-slider4-custom' ];
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

        // Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __( 'Title Typography', 'ele-slider-and-post-addon' ),
                'selector' => '{{WRAPPER}} .ele-slider4-wrapper p',
            ]
        );

        // Title color
        $this->add_control(
            'title_color',
            [
                'label' => __( 'Title Color', 'ele-slider-and-post-addon' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .ele-slider4-wrapper p' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Button background
        $this->add_control(
            'button_background',
            [
                'label' => __( 'Button Background Color', 'ele-slider-and-post-addon' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ff6600',
                'selectors' => [
                    '{{WRAPPER}} .ele-slider4-wrapper .btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Gallery
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
        <div class="ele-slider4-wrapper">
          


            <div id="particles-js" class="particles"></div>

            <div class="container">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        <?php if ( ! empty( $settings['images'] ) ) : ?>
                            <?php foreach ( $settings['images'] as $image ) : ?>
                                <div class="swiper-slide">
                                    <img src="<?php echo esc_url( $image['url'] ); ?>" alt="">
                                    <p><?php echo esc_html( $settings['title'] ); ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="swiper-slide">
                                <img src="https://github.com/ecemgo/mini-samples-great-tricks/assets/13468728/c91f906b-5881-47b1-89e4-e4a69c1961a7" alt="">
                                <p><?php echo esc_html( $settings['title'] ); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>

        </div>
        <?php
    }
}
?>


































































































