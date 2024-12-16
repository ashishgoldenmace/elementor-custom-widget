<?php
namespace Elementor;
// return;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Amenity_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'amenity_widget'; // Unique name for the widget
    }

    public function get_title() {
        return __( 'Amenity', 'text-domain' );
    }

    public function get_icon() {
        return 'eicon-post-list'; // Icon for the widget
    }

    public function get_categories() {
        return [ 'general' ]; // Widget category
    }

    protected function _register_controls() {

        // Wrap/no-wrap setting
        $this->start_controls_section(
            'section_layout',
            [
                'label' => __( 'Layout', 'plugin-name' ),
            ]
        );

        // Add control for the number of amenities to display
        $this->add_control(
            'number_of_amenities',
            [
                'label' => __( 'Number of Amenities to Display', 'text-domain' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 0, // 0 means no limit (show all)
                'min' => 0,
                'max' => 100,
                'description' => __( 'Enter the number of amenities to display. Leave blank for all.', 'text-domain' ),
            ]
        );

        $this->add_control(
            'flex_direction',
            [
                'label' => __( 'Flex Direction', 'text-domain' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'row' => __( 'Row', 'text-domain' ),
                    'column' => __( 'Column', 'text-domain' ),
                ],
                'default' => 'row',  // Default to row
                'selectors' => [
                    '{{WRAPPER}} .amenities_container' => 'display: flex; flex-direction: {{VALUE}};',
                ],
            ]
        );

        // Add control for column gap (distance between amenity containers)
        $this->add_control(
            'column_gap',
            [
                'label' => __( 'Column Gap', 'text-domain' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .amenities_container' => 'gap: {{SIZE}}{{UNIT}};', // Apply the gap to the parent container
                ],
            ]
        );

        $this->add_control(
            'item_column_gap',
            [
                'label' => __( 'Aminity Gap', 'text-domain' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .amenity_container' => 'gap: {{SIZE}}{{UNIT}};', // Apply the gap to the parent container
                ],
            ]
        );

        $this->end_controls_section();
        
        // Image width control
        $this->start_controls_section(
            'style_section',
            [
                'label' => __( 'Style', 'text-domain' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'image_width',
            [
                'label' => __( 'Image Width', 'text-domain' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Title color
        $this->add_control(
            'title_color',
            [
                'label' => __( 'Title Color', 'text-domain' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} h3' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Title Margin Control
        $this->add_control(
            'title_margin',
            [
                'label' => __( 'Title Margin', 'text-domain' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => '10',
                    'right' => '0',
                    'bottom' => '10',
                    'left' => '0',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} h3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        // Typography Control
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'typography',
                'label'    => esc_html__( 'Typography', 'textdomain' ),
                'selector' => '{{WRAPPER}} h3',
            ]
        );

        $this->add_control(
            'vertical_alignment',
            [
                'label' => __( 'Vertical Alignment', 'text-domain' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'top' => [
                        'title' => __( 'Top', 'text-domain' ),
                        'icon' => 'eicon-align-top',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'text-domain' ),
                        'icon' => 'eicon-align-middle',
                    ],
                    'bottom' => [
                        'title' => __( 'Bottom', 'text-domain' ),
                        'icon' => 'eicon-align-bottom',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .amenity_container' => 'align-items: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

    }

    protected function render() {

        global $post;
        $settings = $this->get_settings_for_display();
        $post_id = $post->ID;
        $number_of_amenities = $settings['number_of_amenities'];

        ?>
        <div class="amenities_container">
        <?php
        // Call the function that retrieves the ACF taxonomy field
        echo $this->get_acf_taxonomy_field( $post_id, $number_of_amenities );
        ?>
        </div>
        <?php
    }

    public function get_acf_taxonomy_field($post_id, $number_of_amenities) {
        $terms = get_field('amenities', $post_id); // Replace with your field name
    
        $output = '';
        if ($terms) {

            // If the number of amenities is set, limit the number
            if ($number_of_amenities > 0) {
                $terms = array_slice($terms, 0, $number_of_amenities);
            }
            
            foreach ($terms as $term) {
                $term_title = $term->name;
                $term_image = get_field('image', 'term_' . $term->term_id);
    
                $term_image_html = '';
                if ($term_image) {
                    $term_image_html = '<img src="' . esc_url($term_image['url']) . '" alt="' . esc_attr($term_image['alt']) . '" />';
                }
                $output .= '<div class="amenity_container">';
                $output .= $term_image_html;
                $output .= '<h3>' . $term_title . '</h3>';
                $output .= '</div>';
            }
    
            return $output;
        }
  
        return $output;
    }
    
}

// Register the widget
\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Amenity_Widget() );

