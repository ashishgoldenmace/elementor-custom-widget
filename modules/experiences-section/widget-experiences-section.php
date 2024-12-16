<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Elementor_Experiences_Section_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'experiences_section';
    }

    public function get_title() {
        return __( 'Experiences Section', 'elementor-custom-widget' );
    }

    // Widget Icon
    public function get_icon() {
        return 'eicon-call-to-action';
    }

    public function get_categories() {
        return [ 'general' ];
    }

    protected function _register_controls() {

        // Text Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'elementor-custom-widget' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Title
        $this->add_control(
            'experiences_title',
            [
                'label' => __( 'Title', 'elementor-custom-widget' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Experiences', 'elementor-custom-widget' ),
            ]
        );

        // Description
        $this->add_control(
            'experiences_desc',
            [
                'label' => __( 'Description', 'elementor-custom-widget' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __( 'Explore the beauty of the island by day right from our beachfront hotel by snorkel or paddleboard. By night, experience a variety of tantalizing cuisines, handcrafted cocktails, nightly entertainment, and a 24hr casino at our beachfront hotel.', 'elementor-custom-widget' ),
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        ?>
        <div class="container-fluid">
            <div class="experiences-section">    
                <div class="experiences-section-child">
                    <h2 class="experiences-title"><?php echo esc_html( $settings['experiences_title'] ) ?></h2>
                    <p class="experiences-dec"><?php echo esc_html( $settings['experiences_desc'] ) ?></p>
                    <div class="image-options-slider image-options">
                        <?php
                        // Define query parameters
                        $args = array(
                            'post_type'      => 'experience', // Custom post type
                            'posts_per_page' => -1            // Number of posts to display
                        );

                        // Custom Query
                        $query = new \WP_Query($args);

                        // Loop through the posts
                        if ($query->have_posts()) :
                            while ($query->have_posts()) : $query->the_post();
                            // Get post data
                            $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full'); // Get featured image URL
                            $title = get_the_title(); // Get post title
                            $short_desc = get_the_excerpt(); // Get post excerpt as short description
                            $post_url = get_permalink(); // Get post URL

                            // Create an associative array for the object
                            $post_data = array(
                                'img_url' => $image_url,
                                'title' => $title,
                                'short_desc' => $short_desc,
                                'post_url' => $post_url,
                                'discover_more_link'=> get_field('discover_more_link'),
                            );

                            // Encode data to JSON format
                            $post_data_json = json_encode($post_data);
                        ?>
                            <div class="img-option-card" data-post-data='<?php echo esc_attr($post_data_json); ?>'>
                                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($title); ?>" class="option" data-image="<?php echo sanitize_title($title); ?>">
                                <h4 class="experiences-post-title"><?php echo esc_html($title); ?></h4>
                            </div>
                        <?php
                            endwhile;
                            wp_reset_postdata(); // Reset post data after the loop
                        else :
                            echo '<p>No experiences found.</p>';
                        endif;
                        ?>
                    </div>

                </div>
            </div>
            <div class="large-image-section">
                <div class="active-image-card">
                    <div class="active-image-content">
                        <h2 class="active-image-heading">Beach</h2>
                        <p class="active-image-desc">desc</p>
                        <button class="active-image-btn">
                            <a>
                                discover now 
                                <span class="active-image-btn-icon">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.8225 13.5525L15.375 9.00001L10.8225 4.44751" stroke="currentcolor" stroke-width="1.2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M2.62457 9H15.2471" stroke="currentcolor" stroke-width="1.2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                            </a>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <?php
    }
}

// Register the widget
\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Elementor_Experiences_Section_Widget() );
