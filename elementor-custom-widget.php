<?php
/**
 * Plugin Name: Elementor Custom Widgets
 * Description: Basic Boilerplate for Custom widgets added to Elementor
 */
if ( ! defined( 'ABSPATH' ) ) exit;
define('ECW_PLUGIN_PLUGIN_PATH', plugin_dir_path( __FILE__ ));
define( 'ECW_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );

// plug it in
add_action('plugins_loaded', 'ecw_require_files');
function ecw_require_files() {
    require_once ECW_PLUGIN_PLUGIN_PATH.'modules.php';
}

add_action( 'wp_enqueue_scripts', 'ecw_enqueue_styles_and_scripts', 25 );
function ecw_enqueue_styles_and_scripts() {

    wp_enqueue_script( 'elementor-custom-widget-editor-jquery-ui-min-js', 'https://code.jquery.com/ui/1.12.1/jquery-ui.min.js', array(), null, true );

    /*For Date Picker Widget*/
    
    // Load your styles
    wp_enqueue_style( 'jquery-ui-css', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css' );
    wp_enqueue_style( 'widget-date-picker-css', ECW_PLUGIN_DIR_URL . 'assets/css/widget-date-picker.css' );
    
    // Enqueue your script with dependencies on Elementor's jQuery
    wp_enqueue_script( 'widget-date-picker-js', ECW_PLUGIN_DIR_URL . 'assets/js/widget-date-picker.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-widget' ), null, true );

    
    
    /*For Experiance Widget*/
    // Enqueue CSS file
    wp_enqueue_style('widget-experiences-section-css', ECW_PLUGIN_DIR_URL . 'assets/css/widget-experiences-section.css');
    // Enqueue JS file
    wp_enqueue_script('widget-experiences-section-js', ECW_PLUGIN_DIR_URL . 'assets/js/widget-experiences-section.js', array('jquery'), null, true);

    // Slick Carousel CSS
    wp_enqueue_style('slick-carousel-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
    // Slick Theme CSS (optional)
    wp_enqueue_style('slick-carousel-theme', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css');
    // Slick Carousel JS
    wp_enqueue_script('slick-carousel-js', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), '', true);



    /*For Amenity Widget*/
    // Enqueue CSS file
    wp_enqueue_style('widget-amenity-css', ECW_PLUGIN_DIR_URL . 'assets/css/widget-amenity.css');
}
