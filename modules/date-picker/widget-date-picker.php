<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Date_Picker_Widget extends Widget_Base {

    // Widget Name
    public function get_name() {
        return 'date_picker_widget';
    }

    // Widget Title
    public function get_title() {
        return esc_html__( 'Date Picker', 'textdomain' );
    }

    // Widget Icon
    public function get_icon() {
        return 'eicon-calendar';
    }

    // Widget Categories
    public function get_categories() {
        return [ 'basic' ];
    }

    // Register Widget Controls
    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Content', 'textdomain' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
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
                    '{{WRAPPER}} .datepicker' => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .date-picker' => 'text-align: {{VALUE}};',
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
                'default' => '#545457',
                'selectors' => [
                    '{{WRAPPER}} .datepicker' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Typography Control
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'typography',
                'label'    => esc_html__( 'Typography', 'textdomain' ),
                'selector' => '{{WRAPPER}} .datepicker',
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
        <div class="date-picker">
            <input type="text" class="datepicker" placeholder="<?php echo date('d-m-Y'); ?>">
        </div>
        <?php
    }

    // Render Widget Output in the Editor
    protected function _content_template() {
        ?>
        <div class="date-picker">
            <input type="text" class="datepicker" placeholder="<?php echo date('d-m-Y'); ?>">
        </div>
        <?php
    }
}

// Register the widget
\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Date_Picker_Widget() );
