<?php

if (!class_exists('Square_Register_Customizer_Controls')) {

    class Square_Register_Customizer_Controls {

        function __construct() {
            add_action('customize_register', array($this, 'register_customizer_settings'));
            add_action('customize_controls_enqueue_scripts', array($this, 'enqueue_customizer_script'));
            add_action('customize_preview_init', array($this, 'enqueue_customize_preview_js'));
        }

        public function register_customizer_settings($wp_customize) {
            /** Theme Options */
            require SQUARE_CUSTOMIZER_PATH . 'customizer-panel/settings.php';

            /** For Additional Hooks */
            do_action('square_new_options', $wp_customize);
        }

        public function enqueue_customizer_script() {
            wp_enqueue_script('hash-themes-customizer', SQUARE_CUSTOMIZER_URL . 'customizer-panel/assets/customizer.js', array('jquery'), SQUARE_VERSION, true);
            wp_enqueue_style('hash-themes-customizer', SQUARE_CUSTOMIZER_URL . 'customizer-panel/assets/customizer.css', array(), SQUARE_VERSION);
            wp_enqueue_style('font-awesome-4.7.0', get_template_directory_uri() . '/css/font-awesome-4.7.0.css', array(), SQUARE_VERSION);
            wp_enqueue_style('font-awesome-5.2.0', get_template_directory_uri() . '/css/font-awesome-5.2.0.css', array(), SQUARE_VERSION);
        }

        public function enqueue_customize_preview_js() {
            wp_enqueue_script('webfont', SQUARE_CUSTOMIZER_URL . 'custom-controls/typography/js/webfont.js', array('jquery'), SQUARE_VERSION, false);
            wp_enqueue_script('hash-themes-customizer-preview', SQUARE_CUSTOMIZER_URL . 'customizer-panel/assets/customizer-preview.js', array('customize-preview'), SQUARE_VERSION, true);
        }

    }

    new Square_Register_Customizer_Controls();
}
