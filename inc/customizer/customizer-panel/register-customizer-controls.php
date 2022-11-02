<?php

if (!class_exists('Hash_Themes_Register_Customizer_Controls')) {

    class Hash_Themes_Register_Customizer_Controls {

        function __construct() {
            add_action('customize_register', array($this, 'register_customizer_settings'));
            add_action('customize_controls_enqueue_scripts', array($this, 'enqueue_customizer_script'));
            add_action('customize_preview_init', array($this, 'enqueue_customize_preview_js'));
        }

        public function register_customizer_settings($wp_customize) {
            /** Theme Options */
            require HASH_THEMES_CUSTOMIZER_PATH . 'customizer-panel/settings.php';

            /** For Additional Hooks */
            do_action('hash_themes_new_options', $wp_customize);
        }

        public function enqueue_customizer_script() {
            wp_enqueue_script('hash-themes-customizer', HASH_THEMES_CUSTOMIZER_URL . 'customizer-panel/assets/customizer.js', array('jquery'), HASH_THEMES_VERSION, true);
            wp_enqueue_style('hash-themes-customizer', HASH_THEMES_CUSTOMIZER_URL . 'customizer-panel/assets/customizer.css', array(), HASH_THEMES_VERSION);
            wp_enqueue_style('font-awesome-4.7.0', get_template_directory_uri() . '/css/font-awesome-4.7.0.css', array(), SQUARE_VERSION);
            wp_enqueue_style('font-awesome-5.2.0', get_template_directory_uri() . '/css/font-awesome-5.2.0.css', array(), SQUARE_VERSION);
        }

        public function enqueue_customize_preview_js() {
            wp_enqueue_script('webfont', HASH_THEMES_CUSTOMIZER_URL . 'custom-controls/typography/js/webfont.js', array('jquery'), HASH_THEMES_VERSION, false);
            wp_enqueue_script('hash-themes-customizer-preview', HASH_THEMES_CUSTOMIZER_URL . 'customizer-panel/assets/customizer-preview.js', array('customize-preview'), HASH_THEMES_VERSION, true);
        }

    }

    new Hash_Themes_Register_Customizer_Controls();
}
