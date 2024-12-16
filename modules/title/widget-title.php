<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Elementor_Title_Widget extends \Elementor\Widget_Base {

    // Widget Name
    public function get_name() {
        return 'custom_title';
    }

    // Widget Title
    public function get_title() {
        return esc_html__( 'Custom Title', 'textdomain' );
    }

    // Widget Icon
    public function get_icon() {
        return 'eicon-t-letter'; // You can change to any Elementor icon
    }

    // Widget Categories (For grouping widgets in Elementor)
    public function get_categories() {
        return [ 'basic' ];
    }

    // Register Widget Controls
    protected function _register_controls() {

        // Content Tab
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Content', 'textdomain' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Title Text Control
        $this->add_control(
            'title',
            [
                'label'       => esc_html__( 'Title', 'textdomain' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Default Title', 'textdomain' ),
                'placeholder' => esc_html__( 'Enter your title', 'textdomain' ),
            ]
        );

        // Title Alignment Control
        $this->add_responsive_control(
            'alignment',
            [
                'label'        => esc_html__( 'Alignment', 'textdomain' ),
                'type'         => \Elementor\Controls_Manager::CHOOSE,
                'options'      => [
                    'left'    => [
                        'title' => esc_html__( 'Left', 'textdomain' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center'  => [
                        'title' => esc_html__( 'Center', 'textdomain' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'   => [
                        'title' => esc_html__( 'Right', 'textdomain' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'      => 'center',
                'selectors'    => [
                    '{{WRAPPER}} h2' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Tab
        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__( 'Style', 'textdomain' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Text Color Control
        $this->add_control(
            'text_color',
            [
                'label'     => esc_html__( 'Text Color', 'textdomain' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default' => '#AE3427',
                'selectors' => [
                    '{{WRAPPER}} h2' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Typography Control
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'typography',
                'label'    => esc_html__( 'Typography', 'textdomain' ),
                'selector' => '{{WRAPPER}} h2',
                'default'  => [
                    'size' => '18px',
                ],
            ]
        );

        $this->end_controls_section();
    }

    // Render Widget Output on the Frontend
    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
    <style>
        .star_title_child_conatiner {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .star_title_bottom_icon {
            display: flex;
            justify-content: center;
            margin-top: -10px;
        }
        .star_title_conatiner {
            display: flex;
            justify-content: center;
            flex-wrap: nowrap;
            flex-direction: column;
            width: fit-content;
        }
        .star_title h2 {
            margin: 0;
        }
    </style>        
         
    <div class="star_title_conatiner">
        <div class="star_title_child_conatiner">      
            <div class="star_title">
                <h2><?php echo esc_html( $settings['title'] ); ?></h2>   
            </div>               
        </div>
        <div class="star_title_bottom_icon">
            <svg width="70" height="28" viewBox="0 0 70 28" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <rect width="70" height="28" fill="url(#pattern0_1025_968)"/>
                <defs>
                    <pattern id="pattern0_1025_968" patternContentUnits="objectBoundingBox" width="1" height="1">
                        <use xlink:href="#image0_1025_968" transform="scale(0.00235294 0.00588235)"/>
                    </pattern>
                    <image id="image0_1025_968" width="425" height="170" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAakAAACqCAYAAAAXz7BBAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTQ1IDc5LjE2MzQ5OSwgMjAxOC8wOC8xMy0xNjo0MDoyMiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTkgKFdpbmRvd3MpIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOkNENUUyNUMyODA3RTExRUZCNEVERjBEMkQ0MjdCRUYwIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOkNENUUyNUMzODA3RTExRUZCNEVERjBEMkQ0MjdCRUYwIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6Q0Q1RTI1QzA4MDdFMTFFRkI0RURGMEQyRDQyN0JFRjAiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6Q0Q1RTI1QzE4MDdFMTFFRkI0RURGMEQyRDQyN0JFRjAiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz7p8mBHAAAI0ElEQVR42uzd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"/>
                </defs>
            </svg>        
        </div>
    </div>
        
        <?php
    }

    // Render Widget Output in the Editor (Optional but recommended for live updates in the editor)
    protected function _content_template() {
        ?>
    <style>
        .star_title_child_conatiner {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .star_title_bottom_icon {
            display: flex;
            justify-content: center;
            margin-top: -10px;
        }
        .star_title_conatiner {
            display: flex;
            justify-content: center;
            flex-wrap: nowrap;
            flex-direction: column;
            width: fit-content;
        }
        .star_title h2 {
            margin: 0;
        }
    </style>      
        <div class="star_title_conatiner">
            <div class="star_title_child_conatiner">      
                <div class="star_title">
                    <h2>{{{ settings.title}}}</h2>   
                </div>               
            </div>
            <div class="star_title_bottom_icon">
                <svg width="70" height="28" viewBox="0 0 70 28" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <rect width="70" height="28" fill="url(#pattern0_1025_968)"/>
                    <defs>
                        <pattern id="pattern0_1025_968" patternContentUnits="objectBoundingBox" width="1" height="1">
                            <use xlink:href="#image0_1025_968" transform="scale(0.00235294 0.00588235)"/>
                        </pattern>
                        <image id="image0_1025_968" width="425" height="170" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAakAAACqCAYAAAAXz7BBAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTQ1IDc5LjE2MzQ5OSwgMjAxOC8wOC8xMy0xNjo0MDoyMiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTkgKFdpbmRvd3MpIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOkNENUUyNUMyODA3RTExRUZCNEVERjBEMkQ0MjdCRUYwIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOkNENUUyNUMzODA3RTExRUZCNEVERjBEMkQ0MjdCRUYwIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6Q0Q1RTI1QzA4MDdFMTFFRkI0RURGMEQyRDQyN0JFRjAiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6Q0Q1RTI1QzE4MDdFMTFFRkI0RURGMEQyRDQyN0JFRjAiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz7p8mBHAAAI0ElEQVR42uzd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"/>
                    </defs>
                </svg>        
            </div>
        </div>            
        <?php
    }
}

// Register the widget
\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Elementor_Title_Widget() );