<?php
use Elementor\Core\DynamicTags\Tag;
use Elementor\Controls_Manager;

class Details_Page_Amenity_Text_Dynamic_Tag extends Tag {

    public function get_name() {
        return 'details-page-amenity-text';
    }

    public function get_title() {
        return __( 'Details Page Amenity Text', 'text-domain' );
    }

    public function get_group() {
        return 'site';
    }

    public function get_categories() {
        return [ \Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY ];
    }

    protected function _register_controls() {
        $this->add_control(
            'start_index',
            [
                'label' => __('Start Index', 'text-domain'),
                'type' => Controls_Manager::NUMBER,
                'default' => 0,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'description' => __('Specify the index to start from. For example, 0 to start from the first term.', 'text-domain'),
            ]
        );
    }

    public function render() {
        $post_id = get_the_ID();
        $term_names = $this->get_details_page_menities_term_names($post_id);

        $start_index = $this->get_settings_for_display('start_index');

        if (!empty($term_names) && $start_index < count($term_names)) {
            $term_name = $term_names[$start_index];

            echo esc_html($term_name);
        }
    }

    public function get_details_page_menities_term_names($post_id) {
        $terms = get_field('details_page_amenities', $post_id);
    
        if ($terms) {
            $term_names = array();
            
            foreach ($terms as $term) {
                $term_names[] = $term->name;
            }
    
            return $term_names;
        }
    
        return [];
    }
}

// Register the dynamic tag
\Elementor\Plugin::instance()->dynamic_tags->register(new Details_Page_Amenity_Text_Dynamic_Tag());
