<?php
class Ele_Post_Widget extends \Elementor\Widget_Base {
    public function get_name() {
        return 'ele-post';
    }

    public function get_title() {
        return __( 'Ele Post', 'ele-slider-and-post' );
    }

    public function get_icon() {
        return 'eicon-post';
    }

    public function get_categories() {
        return [ 'ele-kit'];
    }

    public function get_script_depends() {
        return [ 'ele-script' ];
    }

    public function get_style_depends() {
        return [ 'ele-style-post', 'esp-icon' ];
    }

    protected function _register_controls() {
        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'ele-slider-and-post' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'post_type',
            [
                'label' => __( 'Select Post Type', 'ele-slider-and-post' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => get_post_types([ 'public' => true ]),
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => __( 'Number of Posts', 'ele-slider-and-post' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 5,
                'min' => 1,
                'max' => 20,
            ]
        );

        $this->end_controls_section();

        // Typography Section
        $this->start_controls_section(
            'typography_section',
            [
                'label' => __( 'Typography Settings', 'ele-slider-and-post' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Title Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __( 'Title Typography', 'ele-slider-and-post' ),
                'selector' => '{{WRAPPER}} .ele-name-post',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __( 'Title Color', 'ele-slider-and-post' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ele-name-post' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Description Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'label' => __( 'Description Typography', 'ele-slider-and-post' ),
                'selector' => '{{WRAPPER}} .ele-des-post',
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => __( 'Description Color', 'ele-slider-and-post' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ele-des-post' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Button Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => __( 'Button Typography', 'ele-slider-and-post' ),
                'selector' => '{{WRAPPER}} .post-permalink .btnTitle',
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => __( 'Button Color', 'ele-slider-and-post' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-permalink .btnTitle' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_color',
            [
                'label' => __( 'Button Background Color', 'ele-slider-and-post' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-permalink .btnTitle' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Box Shadow Section
        $this->start_controls_section(
            'shadow_section',
            [
                'label' => __( 'Box Shadow', 'ele-slider-and-post' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'shadow_color',
            [
                'label' => __( 'Shadow Color', 'ele-slider-and-post' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#505050',
            ]
        );

        $this->add_control(
            'shadow_opacity',
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
            'shadow_horizontal',
            [
                'label' => __( 'Horizontal Offset', 'ele-slider-and-post' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 0,
            ]
        );

        $this->add_control(
            'shadow_vertical',
            [
                'label' => __( 'Vertical Offset', 'ele-slider-and-post' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 30,
            ]
        );

        $this->add_control(
            'shadow_blur',
            [
                'label' => __( 'Blur Radius', 'ele-slider-and-post' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 50,
            ]
        );

        $this->add_control(
            'shadow_spread',
            [
                'label' => __( 'Spread Radius', 'ele-slider-and-post' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 0,
            ]
        );

        $this->end_controls_section();
        //load default controls for slider arrow settings

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

    protected function render() {
        $settings = $this->get_settings_for_display();

        // Box shadow properties
        $shadow_color = $settings['shadow_color'];
        $shadow_opacity = isset($settings['shadow_opacity']['size']) ? $settings['shadow_opacity']['size'] : 0.5;
        $shadow_rgba = $this->hex_to_rgba($shadow_color, $shadow_opacity);
        $box_shadow = sprintf(
            '%spx %spx %spx %spx %s',
            $settings['shadow_horizontal'],
            $settings['shadow_vertical'],
            $settings['shadow_blur'],
            $settings['shadow_spread'],
            $shadow_rgba
        );

        $args = array(
            'post_type' => $settings['post_type'],
            'posts_per_page' => $settings['posts_per_page'],
        );
        $arrow_width = $settings['slider_arrow_width'];
        $arrow_height = $settings['slider_arrow_height'];
        $arrow_redius = $settings['slider_arrow_redius'];
        $arrow_style= "width: {$arrow_width}px;height: {$arrow_height}px;border-radius: {$arrow_redius}px;";

        $query = new WP_Query($args);
        ?>
        <div class="ele-container-post">
            <div class="ele-slide-post">
                <?php if ($query->have_posts()) : ?>
                    <?php while ($query->have_posts()) : $query->the_post(); ?>
                        <div class="ele-item-post" style="background-image: url(<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full') ?: 'https://i.ibb.co/qCkd9jS/img1.jpg'); ?>); box-shadow: <?php echo esc_attr($box_shadow); ?>;">
                            <div class="ele-content-post">
                                <div class="ele-name-post"><?php the_title(); ?></div>
                                <div class="ele-des-post"><?php echo esc_attr(wp_trim_words(get_the_excerpt(), 15)); ?></div>
                                <a class="post-permalink" href="<?php the_permalink(); ?>"><button class="btnTitle">See More</button></a>
                            </div>
                        </div>
                    <?php endwhile;
                    wp_reset_postdata(); ?>
                <?php endif; ?>
            </div>
            <div class="button">
                <button class="prevpost arrowbg" style="<?php echo esc_attr($arrow_style); ?>"><i class="icon icon-left-arrows arrows"></i></button>
                <button class="nextpost arrowbg" style="<?php echo esc_attr($arrow_style); ?>"><i class="icon icon-right-arrow1 arrows"></i></button>
            </div>
        </div>
        <?php
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
