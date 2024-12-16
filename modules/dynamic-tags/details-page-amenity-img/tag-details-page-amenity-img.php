<?php
use Elementor\Core\DynamicTags\Tag;
use Elementor\Controls_Manager;

class Details_Page_Amenity_Img_Dynamic_Tag extends \Elementor\Core\DynamicTags\Data_Tag {

    public function get_name() {
        return 'details-page-amenity-img';
    }

    public function get_title() {
        return __( 'Details Page Amenity Image', 'text-domain' );
    }

    public function get_group() {
        return 'site';
    }

    public function get_categories() {
        return [ \Elementor\Modules\DynamicTags\Module::IMAGE_CATEGORY ];
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

    public function get_value( array $options = [] ) {
        $post_id = get_the_ID();
        $term_names = $this->get_details_page_menities_term_names($post_id);
    
        $start_index = $this->get_settings_for_display('start_index');
        
        if (!empty($term_names) && $start_index < count($term_names)) {
            $term_name = $term_names[$start_index];
            $term = get_term_by('name', $term_name, 'details-page-amenity');
            
            if ($term) {
                $image = get_field('term_image', $term); // ACF field 'term_image'
                if ($image && isset($image['url'])) {
                    $image_url = $image['url'];
                    $image_id = $image['id'];
                    
                    // Create an array with image ID and URL
                    $image_data = array(
                        'id' => $image_id,
                        'url' => $image_url,
                    );
                    
                    return($image_data);
                }
            }
        }
        
        // Return empty JSON string if no image found
        return array(
            'id' => '',
            'url' => '',
        );
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
\Elementor\Plugin::instance()->dynamic_tags->register(new Details_Page_Amenity_Img_Dynamic_Tag());
