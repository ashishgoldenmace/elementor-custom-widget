<?php
class Accommodation_Gallery_Dynamic_Tag extends \Elementor\Core\DynamicTags\Data_Tag {

    public function get_name() {
        return 'accommodation-gallery-tag'; // Unique ID for the tag
    }

    public function get_title() {
        return __( 'Accommodation Gallery', 'text-domain' ); // Display name for the tag
    }

    public function get_group() {
        return 'site'; // Group it under 'site'
    }

    public function get_categories() {
        return [ \Elementor\Modules\DynamicTags\Module::GALLERY_CATEGORY ]; // Gallery type
    }

    public function get_value( array $options = [] ) {
        global $post;

        // Get the post ID in the current loop iteration
        $post_id = $post->ID;

        // Fetch the gallery data from the custom field for this specific post
        $gallery = get_post_meta($post_id, '_accommodation_gallery', true);

        if ( ! $gallery || ! is_array( $gallery ) ) {
            return []; // Return empty if no gallery exists or data isn't valid
        }

        $value = [];

        // Loop through the gallery image IDs and prepare the result
        foreach ( $gallery as $attachment_id ) {
            $value[] = [
                'id' => $attachment_id,
            ];
        }

        return $value; // Return the array of image IDs (like WooCommerce product gallery)
    }
}

\Elementor\Plugin::instance()->dynamic_tags->register( new Accommodation_Gallery_Dynamic_Tag() );
