<?php

class ACF_Image_Point_Field extends acf_field
{
    public function __construct()
    {
        $this->name = 'image_point';
        $this->category = 'content';
        $this->defaults = [];

        parent::__construct();
    }

    public function render_field($field)
    {
        include( ACF_IMAGE_POINT_PATH . 'views/field.php' );
    }
    
    public function input_admin_enqueue_scripts()
    {
        $url     = trailingslashit(ACF_IMAGE_POINT_URL);
        $version = ACF_IMAGE_POINT_VERSION;

        wp_enqueue_media();

        wp_enqueue_style( 'acf-image-point', $url . 'assets/css/input.css', false, $version );
        wp_enqueue_script( 'acf-image-point', $url . 'assets/js/input.js', ['acf-input'], $version, true );
    }

    public function format_value($value, $post_id, $field)
    {
        if ( empty($value['image']) ) {
            return null;
        }

        return [
            'image' => (int) $value['image'],
            'x' => !empty($value['x']) ? (float) $value['x'] : null,
            'y' => !empty($value['y']) ? (float) $value['y'] : null,
        ];
    }
    
    public function update_value( $value, $post_id, $field )
    {
        return [
            'image' => intval($value['image'] ?? 0),
            'x'     => sanitize_text_field($value['x'] ?? ''),
            'y'     => sanitize_text_field($value['y'] ?? ''),
        ];
    }
}