<?php
/**
 * Square Theme Customizer.
 *
 * @package Square
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function square_customize_register($wp_customize) {
    
}

add_action('customize_register', 'square_customize_register');

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function square_customize_preview_js() {
    wp_enqueue_script('square_customizer', get_template_directory_uri() . '/js/customizer.js', array('customize-preview'), SQUARE_VERSION, true);
}

add_action('customize_preview_init', 'square_customize_preview_js');

function square_customizer_script() {
    wp_enqueue_script('square-customizer-script', get_template_directory_uri() . '/inc/js/customizer-scripts.js', array('jquery'), SQUARE_VERSION, true);
    wp_enqueue_script('square-customizer-chosen-script', get_template_directory_uri() . '/inc/js/chosen.jquery.js', array('jquery'), SQUARE_VERSION, true);
    wp_enqueue_style('square-customizer-chosen-style', get_template_directory_uri() . '/inc/css/chosen.css', array(), SQUARE_VERSION);
    wp_enqueue_style('font-awesome-4.7.0', get_template_directory_uri() . '/css/font-awesome-4.7.0.css', array(), SQUARE_VERSION);
    wp_enqueue_style('font-awesome-5.2.0', get_template_directory_uri() . '/css/font-awesome-5.2.0.css', array(), SQUARE_VERSION);
    wp_enqueue_style('square-customizer-style', get_template_directory_uri() . '/inc/css/customizer-style.css', array(), SQUARE_VERSION);
}

add_action('customize_controls_enqueue_scripts', 'square_customizer_script');


if (class_exists('WP_Customize_Control')) {

    class Square_Customize_Heading extends WP_Customize_Control {

        public function render_content() {
            ?>

            <?php if (!empty($this->label)) : ?>
                <h3 class="square-accordion-section-title"><?php echo esc_html($this->label); ?></h3>
            <?php endif; ?>
            <?php
        }

    }

    class Square_Dropdown_Chooser extends WP_Customize_Control {

        public function render_content() {
            if (empty($this->choices))
                return;
            ?>
            <label>
                <span class="customize-control-title">
                    <?php echo esc_html($this->label); ?>
                </span>

                <?php if ($this->description) { ?>
                    <span class="description customize-control-description">
                        <?php echo wp_kses_post($this->description); ?>
                    </span>
                <?php } ?>

                <select class="hs-chosen-select" <?php $this->link(); ?>>
                    <?php
                    foreach ($this->choices as $value => $label)
                        echo '<option value="' . esc_attr($value) . '"' . selected($this->value(), $value, false) . '>' . esc_html($label) . '</option>';
                    ?>
                </select>
            </label>
            <?php
        }

    }

    class Square_Fontawesome_Icon_Chooser extends WP_Customize_Control {

        public $type = 'icon';

        public function render_content() {
            ?>
            <label>
                <span class="customize-control-title">
                    <?php echo esc_html($this->label); ?>
                </span>

                <?php if ($this->description) { ?>
                    <span class="description customize-control-description">
                        <?php echo wp_kses_post($this->description); ?>
                    </span>
                <?php } ?>
                <div class="square-selected-icon">
                    <i class="<?php echo esc_attr($this->value()); ?>"></i>
                    <span><i class="fas fa-chevron-down"></i></span>
                </div>

                <div class="square-icon-box">
                    <div class="square-icon-search">
                        <input type="text" class="square-icon-search-input" placeholder="<?php echo esc_attr__('Type to filter', 'square') ?>" />
                    </div>

                    <ul class="square-icon-list clearfix">
                        <?php
                        $square_font_awesome_icon_array = square_font_awesome_icon_array();
                        foreach ($square_font_awesome_icon_array as $square_font_awesome_icon) {
                            $icon_class = $this->value() == $square_font_awesome_icon ? 'icon-active' : '';
                            echo '<li class=' . esc_attr($icon_class) . '><i class="' . esc_attr($square_font_awesome_icon) . '"></i></li>';
                        }
                        ?>
                    </ul>
                </div>
                <input type="hidden" value="<?php $this->value(); ?>" <?php $this->link(); ?> />
            </label>
            <?php
        }

    }

    class Square_Display_Gallery_Control extends WP_Customize_Control {

        public $type = 'gallery';

        public function render_content() {
            ?>
            <label>
                <span class="customize-control-title">
                    <?php echo esc_html($this->label); ?>
                </span>

                <?php if ($this->description) { ?>
                    <span class="description customize-control-description">
                        <?php echo wp_kses_post($this->description); ?>
                    </span>
                <?php } ?>

                <ul class="square-gallery-container">
                    <?php
                    if ($this->value()) {
                        $images = explode(',', $this->value());
                        foreach ($images as $image) {
                            $image_src = wp_get_attachment_image_src($image, 'thumbnail');
                            echo '<li data-id="' . $image . '"><span style="background-image:url(' . $image_src[0] . ')"></span><a href="#" class="square-gallery-remove">×</a></li>';
                        }
                    }
                    ?>
                </ul>

                <input type="hidden" <?php echo esc_attr($this->link()) ?> value="<?php echo esc_attr($this->value()); ?>" />

                <a href="#" class="button square-gallery-button"><?php esc_html_e('Add Images', 'square') ?></a>
            </label>
            <?php
        }

    }

    class Square_Info_Text extends WP_Customize_Control {

        public function render_content() {
            ?>
            <span class="customize-control-title">
                <?php echo esc_html($this->label); ?>
            </span>

            <?php if ($this->description) { ?>
                <span class="description customize-control-description">
                    <?php echo wp_kses_post($this->description); ?>
                </span>
                <?php
            }
        }

    }

    class Square_Toggle_Control extends WP_Customize_Control {

        /**
         * Control type
         *
         * @var string
         */
        public $type = 'square-toggle';

        /**
         * Control method
         *
         */
        public function render_content() {
            ?>
            <div class="square-checkbox-toggle">
                <div class="square-toggle-switch">
                    <input type="checkbox" id="<?php echo esc_attr($this->id); ?>" name="<?php echo esc_attr($this->id); ?>" class="square-toggle-checkbox" value="<?php echo esc_attr($this->value()); ?>" <?php $this->link(); ?> <?php checked($this->value()); ?>>
                    <label class="square-toggle-label" for="<?php echo esc_attr($this->id); ?>"><span></span></label>
                </div>
                <span class="customize-control-title square-toggle-title"><?php echo esc_html($this->label); ?></span>
                <?php if (!empty($this->description)) { ?>
                    <span class="description customize-control-description">
                        <?php echo $this->description; ?>
                    </span>
                <?php } ?>
            </div>
            <?php
        }

    }

    // Upgrade Text
    class Square_Upgrade_Text extends WP_Customize_Control {

        public $type = 'square-upgrade-text';

        public function render_content() {
            ?>
            <label>
                <span class="dashicons dashicons-info"></span>

                <?php if ($this->label) { ?>
                    <span>
                        <?php echo wp_kses_post($this->label); ?>
                    </span>
                <?php } ?>

                <a href="<?php echo esc_url('https://hashthemes.com/wordpress-theme/square-plus/?utm_source=wordpress&utm_medium=square-link&utm_campaign=square-upgrade'); ?>" target="_blank"> <strong><?php echo esc_html__('Upgrade to PRO', 'square'); ?></strong></a>
            </label>

            <?php if ($this->description) { ?>
                <span class="description customize-control-description">
                    <?php echo wp_kses_post($this->description); ?>
                </span>
                <?php
            }

            $choices = $this->choices;
            if ($choices) {
                echo '<ul>';
                foreach ($choices as $choice) {
                    echo '<li>' . esc_html($choice) . '</li>';
                }
                echo '</ul>';
            }
        }

    }

}


if (class_exists('WP_Customize_Section')) {

    /**
     * Pro customizer section.
     *
     * @since  1.0.0
     * @access public
     */
    class Square_Customize_Section_Pro extends WP_Customize_Section {

        /**
         * The type of customize section being rendered.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $type = 'square-pro-section';

        /**
         * Custom button text to output.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $pro_text = '';

        /**
         * Custom pro button URL.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $pro_url = '';

        /**
         * Add custom parameters to pass to the JS via JSON.
         *
         * @since  1.0.0
         * @access public
         * @return void
         */
        public function json() {
            $json = parent::json();

            $json['pro_text'] = $this->pro_text;
            $json['pro_url'] = $this->pro_url;

            return $json;
        }

        /**
         * Outputs the Underscore.js template.
         *
         * @since  1.0.0
         * @access public
         * @return void
         */
        protected function render_template() {
            ?>

            <li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">

                <h3 class="accordion-section-title">
                    <# if ( data.title ) { #>
                    {{ data.title }}
                    <# } #>

                    <# if ( data.pro_text && data.pro_url ) { #>
                    <a href="{{ data.pro_url }}" class="button button-primary" target="_blank">{{ data.pro_text }}</a>
                    <# } #>
                </h3>
            </li>
            <?php
        }

    }

    class Square_Customize_Upgrade_Section extends WP_Customize_Section {

        /**
         * The type of customize section being rendered.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $type = 'square-upgrade-section';

        /**
         * Custom button text to output.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $text = '';
        public $options = array();

        /**
         * Add custom parameters to pass to the JS via JSON.
         *
         * @since  1.0.0
         * @access public
         * @return void
         */
        public function json() {
            $json = parent::json();

            $json['text'] = $this->text;
            $json['options'] = $this->options;

            return $json;
        }

        /**
         * Outputs the Underscore.js template.
         *
         * @since  1.0.0
         * @access public
         * @return void
         */
        protected function render_template() {
            ?>
            <li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">
                <label>
                    <# if ( data.title ) { #>
                    {{ data.title }}
                    <# } #>
                </label>

                <# if ( data.text ) { #>
                {{ data.text }}
                <# } #>

                <# _.each( data.options, function(key, value) { #>
                {{ key }}<br/>
                <# }) #>

                <a href="<?php echo esc_url('https://hashthemes.com/wordpress-theme/square-plus/?utm_source=wordpress&utm_medium=square-link&utm_campaign=square-upgrade'); ?>" class="button button-primary" target="_blank"><?php echo esc_html__('Upgrade to Pro', 'square'); ?></a>
            </li>
            <?php
        }

    }

}

//SANITIZATION FUNCTIONS
function square_sanitize_text($input) {
    return wp_kses_post(force_balance_tags($input));
}

function square_sanitize_checkbox($input) {
    if ($input == 1) {
        return 1;
    } else {
        return '';
    }
}

function square_sanitize_integer($input) {
    if (is_numeric($input)) {
        return intval($input);
    }
}

function square_sanitize_choices($input, $setting) {
    global $wp_customize;

    $control = $wp_customize->get_control($setting->id);

    if (array_key_exists($input, $control->choices)) {
        return $input;
    } else {
        return $setting->default;
    }
}

function square_is_upgrade_notice_active() {
    $show_upgrade_notice = get_theme_mod('square_hide_upgrade_notice', false);
    return !$show_upgrade_notice;
}
