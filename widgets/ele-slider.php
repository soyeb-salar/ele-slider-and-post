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
        return [ 'ele-kit' ];
    }

    public function get_script_depends() {
        return [ 'ele-script' ];
    }

    public function get_style_depends() {
        return [ 'ele-style-slider', 'esp-icon' ];
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
        // Box Shadow Section for Slider






$this->start_controls_section(
    'slider_shadow_section',
    [
        'label' => __( 'Box Shadow', 'ele-slider-and-post' ),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_control(
    'slider_shadow_color',
    [
        'label' => __( 'Shadow Color', 'ele-slider-and-post' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#505050',
    ]
);

$this->add_control(
    'slider_shadow_opacity',
    [
        'label' => __( 'Shadow Opacity', 'ele-slider-and-post' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'default' => [
            'size' => 0.5,
        ],
        'range' => [
            'px' => [
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
            ],
        ],
    ]
);

$this->add_control(
    'slider_shadow_horizontal',
    [
        'label' => __( 'Horizontal Offset', 'ele-slider-and-post' ),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'default' => 0,
    ]
);

$this->add_control(
    'slider_shadow_vertical',
    [
        'label' => __( 'Vertical Offset', 'ele-slider-and-post' ),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'default' => 30,
    ]
);

$this->add_control(
    'slider_shadow_blur',
    [
        'label' => __( 'Blur Radius', 'ele-slider-and-post' ),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'default' => 50,
    ]
);

$this->add_control(
    'slider_shadow_spread',
    [
        'label' => __( 'Spread Radius', 'ele-slider-and-post' ),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'default' => 0,
    ]
);

$this->end_controls_section();




//arrow controll section
$this->start_controls_section(
    'slider_arrow_section',
    [
        'label' => __( 'Arrow Settings', 'ele-slider-and-post' ),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_control(
    'slider_arrow_color',
    [
        'label' => __( 'Arrow Color', 'ele-slider-and-post' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#000000',
        'selectors' => [
            '{{WRAPPER}} .arrows' => 'color: {{VALUE}};'
        ],
    ]
);
$this->add_control(
    'slider_arrow_color_bg',
    [
        'label' => __( 'Arrow Color Background', 'ele-slider-and-post' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#FFFFFF',
        'selectors' => [
            '{{WRAPPER}} .button .arrowbg' => 'background-color: {{VALUE}};'
        ],
    ]
);

$this->add_control(
    'slider_arrow_color_bg_hover',
    [
        'label' => __( 'Arrow Color Background Hover', 'ele-slider-and-post' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#505050',
        'selectors' => [
            '{{WRAPPER}} .arrowbg:hover' => 'background-color: {{VALUE}};'
        ],
    ]
);
$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name' => 'Arrowborder',
        'selector' => '{{WRAPPER}} .arrowbg',
    ]
);

$this->add_control(
    'slider_arrow_redius',
    [
        'label' => __( 'Arrow Redius', 'ele-slider-and-post' ),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'default' => 8,
    ]
);

$this->add_control(
    'slider_arrow_width',
    [
        'label' => __( 'Arrow Width', 'ele-slider-and-post' ),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'default' => 35,
    ]
);
$this->add_control(
    'slider_arrow_height',
    [
        'label' => __( 'Arrow Height', 'ele-slider-and-post' ),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'default' => 35,
    ]
);
$this->end_controls_section();


//arrow controll section
$this->start_controls_section(
    'slider_arrow_section',
    [
        'label' => __( 'Arrow Settings', 'ele-slider-and-post' ),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_control(
    'slider_arrow_color',
    [
        'label' => __( 'Arrow Color', 'ele-slider-and-post' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#000000',
        'selectors' => [
            '{{WRAPPER}} .arrows' => 'color: {{VALUE}};'
        ],
    ]
);
$this->add_control(
    'slider_arrow_color_bg',
    [
        'label' => __( 'Arrow Color Background', 'ele-slider-and-post' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#FFFFFF',
        'selectors' => [
            '{{WRAPPER}} .button .arrowbg' => 'background-color: {{VALUE}};'
        ],
    ]
);

$this->add_control(
    'slider_arrow_color_bg_hover',
    [
        'label' => __( 'Arrow Color Background Hover', 'ele-slider-and-post' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#505050',
        'selectors' => [
            '{{WRAPPER}} .arrowbg:hover' => 'background-color: {{VALUE}};'
        ],
    ]
);
$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name' => 'Arrowborder',
        'selector' => '{{WRAPPER}} .arrowbg',
    ]
);

$this->add_control(
    'slider_arrow_redius',
    [
        'label' => __( 'Arrow Redius', 'ele-slider-and-post' ),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'default' => 8,
    ]
);

$this->add_control(
    'slider_arrow_width',
    [
        'label' => __( 'Arrow Width', 'ele-slider-and-post' ),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'default' => 35,
    ]
);
$this->add_control(
    'slider_arrow_height',
    [
        'label' => __( 'Arrow Height', 'ele-slider-and-post' ),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'default' => 35,
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
             // Box shadow properties
             $shadow_color = $settings['slider_shadow_color'];
             $shadow_opacity = isset($settings['slider_shadow_opacity']['size']) ? $settings['slider_shadow_opacity']['size'] : 0.5;
             $slider_shadow_rgba = $this->hex_to_rgba($shadow_color, $shadow_opacity);
             $box_slider_shadow = sprintf(
                 '%spx %spx %spx %spx %s',
                 $settings['slider_shadow_horizontal'],
                 $settings['slider_shadow_vertical'],
                 $settings['slider_shadow_blur'],
                 $settings['slider_shadow_spread'],
                 $slider_shadow_rgba
             );  

             $arrow_width = $settings['slider_arrow_width'];
             $arrow_height = $settings['slider_arrow_height'];
             $arrow_redius = $settings['slider_arrow_redius'];
             $arrow_style= "width: {$arrow_width}px;height: {$arrow_height}px;border-radius: {$arrow_redius}px;";

    
        if ( ! empty( $slides ) ) : ?>
            <div class="ele-container">
                <div class="ele-slide">
                    <?php foreach ( $slides as $slide ) : 
                        $background_image = $slide['background_image']['url'];
                        $title = $slide['slider_title'];
                        $description = $slide['slider_description'];
                        $button_text = $slide['button_text'];
                        $button_link = $slide['button_link']['url'];
                    ?>
                    <div class="ele-item" style="background-image: url(<?php echo esc_url( $background_image ); ?>); box-shadow: <?php echo esc_attr($box_slider_shadow); ?>;">
                        <div class="ele-content">
                            <div class="ele-name" style="<?php echo esc_attr( $this->get_render_attribute_string( 'title_style' ) ); ?>">
                                <?php echo esc_html( $title ); ?>
                            </div>
                            <div class="ele-des" style="<?php echo esc_attr( $this->get_render_attribute_string( 'description_style' ) ); ?>">
                                <?php echo esc_html( $description ); ?>
                            </div>
                            <?php if ( $button_link ) : ?>
                                <a href="<?php echo esc_url( $button_link ); ?>">
                                    <button class="btnTitle" style="<?php echo esc_attr( $this->get_render_attribute_string( 'button_style' ) ); ?>">
                                        <?php echo esc_html( $button_text ); ?>
                                    </button>
                                </a>
                            <?php else : ?>
                                <button class="btnTitle" style="<?php echo esc_attr( $this->get_render_attribute_string( 'button_style' ) ); ?>">
                                    <?php echo esc_html( $button_text ); ?>
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="button">
                    <button class="prev arrowbg" style="<?php echo esc_attr($arrow_style); ?>"><i class="icon icon-left-arrows arrows"></i></button>
                    <button class="next arrowbg" style="<?php echo esc_attr($arrow_style); ?>"><i class="icon icon-right-arrow1 arrows"></i></button>
                </div>
            </div>
        <?php endif;
    }
    private function hex_to_rgba($hex, $alpha = 1) {
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) == 6) {
            list($r, $g, $b) = array_map('hexdec', str_split($hex, 2));
        } else {
            list($r, $g, $b) = array_map('hexdec', str_split($hex, 1));
            $r = $r * 17;
            $g = $g * 17;
            $b = $b * 17;
        }
        return "rgba($r, $g, $b, $alpha)";
    }
    
}
