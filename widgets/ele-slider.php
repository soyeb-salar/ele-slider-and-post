<?php
class Ele_Slider_Widget extends \Elementor\Widget_Base {
    public function get_name() {
        return 'ele-slider';
    }

    public function get_title() {
        return __( 'Ele Slider', 'ele-slider-and-post' );
    }

    public function get_icon() {
        return 'eicon-slider-album';
    }

    public function get_categories() {
        return [ 'basic' ];
    }

    public function get_script_depends() {
        return [ 'esp-script' ];
    }

    public function get_style_depends() {
        return [ 'esp-style-slider', 'esp-icon' ];
    }

    protected function _register_controls() {
        // Section for Slide Content
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Slides', 'ele-slider-and-post' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        // Background Image
        $repeater->add_control(
            'background_image',
            [
                'label' => __( 'Background Image', 'ele-slider-and-post' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        // Title Text
        $repeater->add_control(
            'slider_title',
            [
                'label' => __( 'Title', 'ele-slider-and-post' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Sample Title', 'ele-slider-and-post' ),
                'label_block' => true,
            ]
        );

        // Description Text
        $repeater->add_control(
            'slider_description',
            [
                'label' => __( 'Description', 'ele-slider-and-post' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __( 'Sample Description', 'ele-slider-and-post' ),
                'label_block' => true,
            ]
        );

        // Button Text
        $repeater->add_control(
            'button_text',
            [
                'label' => __( 'Button Text', 'ele-slider-and-post' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Read More', 'ele-slider-and-post' ),
                'label_block' => true,
            ]
        );

        // Button Link
        $repeater->add_control(
            'button_link',
            [
                'label' => __( 'Button Link', 'ele-slider-and-post' ),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __( 'https://your-link.com', 'ele-slider-and-post' ),
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => false,
                    'nofollow' => false,
                ],
            ]
        );

        // Add the repeater control
        $this->add_control(
            'slides',
            [
                'label' => __( 'Slides', 'ele-slider-and-post' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'slider_title' => __( 'Sample Title', 'ele-slider-and-post' ),
                        'slider_description' => __( 'Sample Description', 'ele-slider-and-post' ),
                        'button_text' => __( 'Read More', 'ele-slider-and-post' ),
                    ],
                ],
                'title_field' => '{{{ slider_title }}}',
            ]
        );

        $this->end_controls_section();
        // Global Settings for All Slides
        $this->start_controls_section(
            'global_style_section',
            [
                'label' => __( 'Global Styles', 'ele-slider-and-post' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Global Width Setting
        $this->add_control(
            'slider_width',
            [
                'label' => __( 'Slider Width', 'ele-slider-and-post' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'vw' ],
                'range' => [
                    'px' => [
                        'min' => 300,
                        'max' => 2000,
                    ],
                    '%' => [
                        'min' => 50,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 1000,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ele-container' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        

        // Global Height Setting
        $this->add_control(
            'slider_height',
            [
                'label' => __( 'Slider Height', 'ele-slider-and-post' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'vh' ],
                'range' => [
                    'px' => [
                        'min' => 200,
                        'max' => 1000,
                    ],
                    'vh' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 600,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ele-container' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Image Size Control (applies to all slides)
        $this->add_control(
            'global_image_size',
            [
                'label' => __( 'Image Size', 'ele-slider-and-post' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $this->get_available_image_sizes(),
                'default' => 'full',
            ]
        );

        $this->end_controls_section();

        // Global Settings for All Slides
        $this->start_controls_section(
            'global_style_section',
            [
                'label' => __( 'Global Styles', 'ele-slider-and-post' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Title Typography Settings
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __( 'Title Typography', 'ele-slider-and-post' ),
                'selector' => '{{WRAPPER}} .name',
            ]
        );

        // Title Color
        $this->add_control(
            'title_color',
            [
                'label' => __( 'Title Color', 'ele-slider-and-post' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .name' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Description Typography Settings
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'label' => __( 'Description Typography', 'ele-slider-and-post' ),
                'selector' => '{{WRAPPER}} .des',
            ]
        );

        // Description Color
        $this->add_control(
            'description_color',
            [
                'label' => __( 'Description Color', 'ele-slider-and-post' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .des' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Button Typography Settings
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => __( 'Button Typography', 'ele-slider-and-post' ),
                'selector' => '{{WRAPPER}} .btnTitle',
            ]
        );

        // Button Text Color
        $this->add_control(
            'button_text_color',
            [
                'label' => __( 'Button Text Color', 'ele-slider-and-post' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btnTitle' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Button Background Color
        $this->add_control(
            'button_background_color',
            [
                'label' => __( 'Button Background Color', 'ele-slider-and-post' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btnTitle' => 'background-color: {{VALUE}};',
                ],
            ]
        ); 

        // Image Size Control (applies to all slides)
        $this->add_control(
            'global_image_size',
            [
                'label' => __( 'Image Size', 'ele-slider-and-post' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $this->get_available_image_sizes(),
                'default' => 'full',
            ]
        );

        $this->end_controls_section();
    }

    protected function get_available_image_sizes() {
        global $_wp_additional_image_sizes;

        $sizes = [];
        foreach ( get_intermediate_image_sizes() as $size ) {
            if ( isset( $_wp_additional_image_sizes[ $size ] ) ) {
                $width  = $_wp_additional_image_sizes[ $size ]['width'];
                $height = $_wp_additional_image_sizes[ $size ]['height'];
                $sizes[ $size ] = $size . ' (' . $width . 'x' . $height . ')';
            } else {
                $sizes[ $size ] = $size;
            }
        }

        return $sizes;
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $slides = $settings['slides'];      

        if ( ! empty( $slides ) ) : ?>
            <div class="ele-container">
                <div class="ele-slide">
                    <?php foreach ( $slides as $slide ) : 
                        $background_image = $slide['background_image']['url'];
                        $title = $slide['slider_title'];
                        $description = $slide['slider_description'];
                        $button_text = $slide['button_text'];
                        $button_link = $slide['button_link']['url']; // Fetch button URL
                    ?>
                    <div class="ele-item" style="background-image: url(<?php echo esc_url( $background_image ); ?>);">
                        <div class="ele-content">
                            <div class="ele-name"><?php echo esc_html( $title ); ?></div>
                            <div class="ele-des"><?php echo esc_html( $description ); ?></div>

                            <?php if ( $button_link ) : ?>
                                <a href="<?php echo esc_url( $button_link ); ?>">
                                    <button class="btnTitle"><?php echo esc_html( $button_text ); ?></button>
                                </a>
                            <?php else : ?>
                                <button class="btnTitle"><?php echo esc_html( $button_text ); ?></button>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="button">
                    <button class="prev"><i class="icon icon-left-arrows"></i></button>
                    <button class="next"><i class="icon icon-right-arrow1"></i></button>
                </div>
            </div>
        <?php endif;
    }
}
