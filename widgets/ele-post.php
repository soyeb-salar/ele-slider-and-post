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
        return [ 'basic' ];
    }

    public function get_script_depends() {
        return [ 'esp-script' ];
    }
    public function get_style_depends() {
        return [ 'esp-style-post', 'esp-icon' ]; // Register style.css for this widget
    }
    protected function _register_controls() {
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
                'options' => get_post_types(['public'   => true ]),
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $args = array(
            'post_type' => $settings['post_type'],
            'posts_per_page' => 5, // Adjust the number as needed
        );
        $query = new WP_Query( $args );
        ?>
        <div class="ele-container-post">
            <div class="ele-slide-post">
                <?php if ( $query->have_posts() ) : ?>
                    <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                        <div class="ele-item-post" style="background-image: url(<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'full' ) ?: 'https://i.ibb.co/qCkd9jS/img1.jpg' ); ?>);">
                            <div class="ele-content-post">
                                <div class="ele-name-post"><?php the_title(); ?></div>
                                <div class="ele-des-post"><?php echo wp_trim_words( get_the_excerpt(), 15 ); ?></div>
                                <a class="post-permalink" href="<?php the_permalink(); ?>"><button class="btnTitle">See More</button></a>
                            </div>
                        </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                <?php endif; ?>
            </div>
            <div class="button">
                <button class="prevpost"><i class="icon icon-left-arrows"></i></button>
                <button class="nextpost"><i class="icon icon-right-arrow1"></i></button>
            </div>
        </div>
        <?php
    }
}
