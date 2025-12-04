<?php

/**
 * Plugin Name: ACF Image Point
 * Description: ACF field type for selecting points on an image.
 * Version: 1.0.0
 * Author: abareja
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

define( 'ACF_IMAGE_POINT_PATH', plugin_dir_path( __FILE__ ) );
define( 'ACF_IMAGE_POINT_URL', plugin_dir_url( __FILE__ ) );
define( 'ACF_IMAGE_POINT_VERSION', '1.0.0' );

if( ! class_exists('ACF_Image_Point')  ) {
    class ACF_Image_Point 
    {
        public function __construct()
        {
            add_action('acf/include_field_types', array($this, 'registerField'));
        }

        public function registerField()
        {
            include_once( ACF_IMAGE_POINT_PATH . '/includes/class-acf-image-point-field.php' );
            acf_register_field_type('ACF_Image_Point_Field');
        }
    }

    function acfImagePoint() {
        global $acfImagePoint;

        if ( ! isset( $acfImagePoint ) ) {
            $acfImagePoint = new ACF_Image_Point();
        }
        return $acfImagePoint;
    }
    acfImagePoint();
}

