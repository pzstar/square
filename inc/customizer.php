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
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';
    $wp_customize->get_control('background_color')->section = 'background_image';
    $wp_customize->get_section('colors')->priority = 25;

    $square_page = '';
    $square_page_array = get_pages();
    if (is_array($square_page_array)) {
        $square_page = $square_page_array[0]->ID;
    }

    $header_bg_choices = array(
        'sq-white' => esc_html__('White', 'square'),
        'sq-black' => esc_html__('Black', 'square')
    );

    $square_pro_features = '<ul class="upsell-features">
	<li>' . esc_html__("One click demo import", "square") . '</li>
	<li>' . esc_html__("18 Front page sections with lots of variations", "square") . '</li>
	<li>' . esc_html__("Section reorder", "square") . '</li>
	<li>' . esc_html__("Video background, Image Motion background, Parallax background, Gradient background option for each section", "square") . '</li>
	<li>' . esc_html__("4 icon pack for icon picker (5000+ Icons)", "square") . '</li>
	<li>' . esc_html__("Unlimited slider with linkable button", "square") . '</li>
	<li>' . esc_html__("Add unlimited blocks(like slider, team, testimonial) for each Section", "square") . '</li>
	<li>' . esc_html__("Fully customizable options for Front Page blocks", "square") . '</li>
	<li>' . esc_html__("15+ Shape divider to choose from for each section", "square") . '</li>
	<li>' . esc_html__("Remove footer credit Text", "square") . '</li>
	<li>' . esc_html__("6 header layouts and advanced header settings", "square") . '</li>
	<li>' . esc_html__("4 blog layouts", "square") . '</li>
	<li>' . esc_html__("In-built MegaMenu", "square") . '</li>
	<li>' . esc_html__("Advanced Typography options", "square") . '</li>
	<li>' . esc_html__("Advanced color options", "square") . '</li>
	<li>' . esc_html__("Top header bar", "square") . '</li>
	<li>' . esc_html__("PreLoader option", "square") . '</li>
	<li>' . esc_html__("Sidebar layout options", "square") . '</li>
	<li>' . esc_html__("Website layout (Fullwidth or Boxed)", "square") . '</li>
	<li>' . esc_html__("Advanced blog settings", "square") . '</li>
	<li>' . esc_html__("Advanced footer setting", "square") . '</li>
	<li>' . esc_html__("Front page sections with full window height", "square") . '</li>
	<li>' . esc_html__("26 custom widgets", "square") . '</li>
	<li>' . esc_html__("Blog single page - Author Box, Social Share and Related Post", "square") . '</li>
	<li>' . esc_html__("Google map option", "square") . '</li>
	<li>' . esc_html__("WooCommerce Compatible", "square") . '</li>
	<li>' . esc_html__("Fully Multilingual and Translation ready", "square") . '</li>
	<li>' . esc_html__("Fully RTL(Right to left) languages compatible", "square") . '</li>
	</ul>
	<a class="ht-implink" href="https://hashthemes.com/wordpress-theme/square-plus/#theme-comparision-tab" target="_blank">' . esc_html__("Comparision - Free Vs Pro", "square") . '</a>';

    $wp_customize->register_section_type('Square_Customize_Section_Pro');
    // Register sections.
    $wp_customize->add_section(new Square_Customize_Section_Pro($wp_customize, 'square-pro-section', array(
        'priority' => 0,
        'pro_text' => esc_html__('Upgrade to Pro', 'square'),
        'pro_url' => 'https://hashthemes.com/wordpress-theme/square-plus/'
    )));

    $wp_customize->add_section(new Square_Customize_Section_Pro($wp_customize, 'square-doc-section', array(
        'title' => esc_html__('Documentation', 'square'),
        'priority' => 1000,
        'pro_text' => esc_html__('View', 'square'),
        'pro_url' => 'https://hashthemes.com/documentation/square-documentation/'
    )));

    $wp_customize->add_section(new Square_Customize_Section_Pro($wp_customize, 'square-demo-import-section', array(
        'title' => esc_html__('Import Demo Content', 'square'),
        'priority' => 1001,
        'pro_text' => esc_html__('Import', 'square'),
        'pro_url' => admin_url('/themes.php?page=square-welcome')
    )));

    $wp_customize->add_setting('square_template_color', array(
        'default' => '#5bc2ce',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'square_template_color', array(
        'section' => 'colors',
        'label' => esc_html__('Template Color', 'square')
    )));

    /* ============GENERAL SETTINGS PANEL============ */
    $wp_customize->add_panel('square_general_settings_panel', array(
        'title' => esc_html__('General Settings', 'square'),
        'priority' => 20
    ));

    //STATIC FRONT PAGE
    $wp_customize->add_section('static_front_page', array(
        'title' => esc_html__('Static Front Page', 'square'),
        'panel' => 'square_general_settings_panel',
        'description' => esc_html__('Your theme supports a static front page.', 'square'),
    ));

    //TITLE AND TAGLINE SETTINGS
    $wp_customize->add_section('title_tagline', array(
        'title' => esc_html__('Site Title & Tagline', 'square'),
        'panel' => 'square_general_settings_panel',
    ));

    //HEADER LOGO 
    $wp_customize->add_section('header_image', array(
        'title' => esc_html__('Header Logo', 'square'),
        'panel' => 'square_general_settings_panel',
    ));

    //HEADER SETTINGS 
    $wp_customize->add_section('square_header_setting_sec', array(
        'title' => esc_html__('Header Settings', 'square'),
        'panel' => 'square_general_settings_panel'
    ));

    $wp_customize->add_setting('square_disable_sticky_header', array(
        'default' => 0,
        'sanitize_callback' => 'absint'
    ));

    $wp_customize->add_control('square_disable_sticky_header', array(
        'settings' => 'square_disable_sticky_header',
        'section' => 'square_header_setting_sec',
        'label' => esc_html__('Disable Sticky Header', 'square'),
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('square_header_bg', array(
        'default' => 'sq-black',
        'transport' => 'postMessage',
        'sanitize_callback' => 'square_sanitize_choices'
    ));

    $wp_customize->add_control(new Square_Dropdown_Chooser($wp_customize, 'square_header_bg', array(
        'settings' => 'square_header_bg',
        'section' => 'square_header_setting_sec',
        'type' => 'select',
        'label' => esc_html__('Header Background Color', 'square'),
        'choices' => $header_bg_choices
    )));


    $wp_customize->add_setting('square_page_header_bg', array(
        'default' => get_template_directory_uri() . '/images/bg.jpg',
        'sanitize_callback' => 'esc_url_raw'
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'square_page_header_bg', array(
        'label' => esc_html__('Page Header Banner', 'square'),
        'settings' => 'square_page_header_bg',
        'section' => 'square_header_setting_sec',
        'description' => esc_html__('This banner will show in the header of all the inner pages', 'square') . '<br/>' . esc_html__('Recommended Image Size: 1800X400px', 'square')
    )));

    //BLOG SETTINGS
    $wp_customize->add_section('square_blog_sec', array(
        'title' => esc_html__('Blog Settings', 'square'),
        'panel' => 'square_general_settings_panel'
    ));

    $wp_customize->add_setting('square_blog_format', array(
        'default' => 'excerpt',
        'sanitize_callback' => 'square_sanitize_text'
    ));

    $wp_customize->add_control('square_blog_format', array(
        'label' => esc_html__('Blog Content Format', 'square'),
        'section' => 'square_blog_sec',
        'settings' => 'square_blog_format',
        'type' => 'radio',
        'choices' => array(
            'excerpt' => 'Excerpt',
            'full_content' => 'Full Content',
        )
    ));

    $wp_customize->add_setting('square_blog_share_buttons', array(
        'default' => 0,
        'sanitize_callback' => 'absint'
    ));

    $wp_customize->add_control('square_blog_share_buttons', array(
        'settings' => 'square_blog_share_buttons',
        'section' => 'square_blog_sec',
        'label' => esc_html__('Disable Share Buttons', 'square'),
        'type' => 'checkbox',
    ));

    //BACKGROUND IMAGE
    $wp_customize->add_section('background_image', array(
        'title' => esc_html__('Background Image', 'square'),
        'panel' => 'square_general_settings_panel',
    ));

    /* ============HOME SETTINGS PANEL============ */
    $wp_customize->add_panel('square_home_settings_panel', array(
        'title' => esc_html__('Home Page Sections', 'square'),
        'priority' => 30
    ));

    /* ============SLIDER IMAGES SECTION============ */
    $wp_customize->add_section('square_slider_sec', array(
        'title' => esc_html__('Slider Section', 'square'),
        'panel' => 'square_home_settings_panel'
    ));

    //SLIDERS
    for ($i = 1; $i < 4; $i++) {

        $wp_customize->add_setting('square_slider_heading' . $i, array(
            'default' => '',
            'sanitize_callback' => 'square_sanitize_text'
        ));

        $wp_customize->add_control(new Square_Customize_Heading($wp_customize, 'square_slider_heading' . $i, array(
            'settings' => 'square_slider_heading' . $i,
            'section' => 'square_slider_sec',
            'label' => esc_html__('Slider ', 'square') . $i,
        )));

        $wp_customize->add_setting('square_slider_title' . $i, array(
            'default' => esc_html__('Free WordPress Themes', 'square'),
            'sanitize_callback' => 'square_sanitize_text',
        ));

        $wp_customize->add_control('square_slider_title' . $i, array(
            'settings' => 'square_slider_title' . $i,
            'section' => 'square_slider_sec',
            'type' => 'text',
            'label' => esc_html__('Caption Title', 'square')
        ));

        $wp_customize->add_setting('square_slider_subtitle' . $i, array(
            'default' => esc_html__('Create website in no time', 'square'),
            'sanitize_callback' => 'square_sanitize_text'
        ));

        $wp_customize->add_control('square_slider_subtitle' . $i, array(
            'settings' => 'square_slider_subtitle' . $i,
            'section' => 'square_slider_sec',
            'type' => 'textarea',
            'label' => esc_html__('Caption SubTitle', 'square')
        ));

        $wp_customize->add_setting('square_slider_image' . $i, array(
            'default' => get_template_directory_uri() . '/images/bg.jpg',
            'sanitize_callback' => 'esc_url_raw'
        ));

        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'square_slider_image' . $i, array(
            'label' => esc_html__('Slider Image', 'square'),
            'settings' => 'square_slider_image' . $i,
            'section' => 'square_slider_sec',
            'description' => esc_html__('Recommended Image Size: 1800X800px', 'square')
        )));
    }

    /* ============FEATURED SECTION============ */

    //FEATURED PAGES
    $wp_customize->add_section('square_featured_page_sec', array(
        'title' => esc_html__('Featured Section', 'square'),
        'panel' => 'square_home_settings_panel'
    ));

    $wp_customize->add_setting('square_enable_featured_link', array(
        'default' => 1,
        'sanitize_callback' => 'absint'
    ));

    $wp_customize->add_control('square_enable_featured_link', array(
        'settings' => 'square_enable_featured_link',
        'section' => 'square_featured_page_sec',
        'label' => esc_html__('Enable Read More link ', 'square'),
        'type' => 'checkbox',
    ));

    for ($i = 1; $i < 4; $i++) {

        $wp_customize->add_setting('square_featured_header' . $i, array(
            'default' => '',
            'sanitize_callback' => 'square_sanitize_text'
        ));

        $wp_customize->add_control(new Square_Customize_Heading($wp_customize, 'square_featured_header' . $i, array(
            'settings' => 'square_featured_header' . $i,
            'section' => 'square_featured_page_sec',
            'label' => esc_html__('Featured Page ', 'square') . $i
        )));

        $wp_customize->add_setting('square_featured_page' . $i, array(
            'default' => $square_page,
            'sanitize_callback' => 'absint'
        ));

        $wp_customize->add_control('square_featured_page' . $i, array(
            'settings' => 'square_featured_page' . $i,
            'section' => 'square_featured_page_sec',
            'type' => 'dropdown-pages',
            'label' => esc_html__('Select a Page', 'square')
        ));

        $wp_customize->add_setting('square_featured_page_icon' . $i, array(
            'default' => 'fa fa-bell',
            'sanitize_callback' => 'square_sanitize_text'
        ));

        $wp_customize->add_control(new Square_Fontawesome_Icon_Chooser($wp_customize, 'square_featured_page_icon' . $i, array(
            'settings' => 'square_featured_page_icon' . $i,
            'section' => 'square_featured_page_sec',
            'label' => esc_html__('FontAwesome Icon', 'square'),
            'type' => 'icon'
        )));
    }

    /* ============ABOUT SECTION============ */

    $wp_customize->add_section('square_about_sec', array(
        'title' => esc_html__('About Us Section', 'square'),
        'panel' => 'square_home_settings_panel'
    ));

    $wp_customize->add_setting('square_disable_about_sec', array(
        'default' => 0,
        'sanitize_callback' => 'absint'
    ));

    $wp_customize->add_control('square_disable_about_sec', array(
        'settings' => 'square_disable_about_sec',
        'section' => 'square_about_sec',
        'label' => esc_html__('Disable About Section ', 'square'),
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('square_about_header', array(
        'default' => '',
        'sanitize_callback' => 'square_sanitize_text'
    ));

    $wp_customize->add_control(new Square_Customize_Heading($wp_customize, 'square_about_header', array(
        'settings' => 'square_about_header',
        'section' => 'square_about_sec',
        'label' => esc_html__('About Page ', 'square')
    )));

    $wp_customize->add_setting('square_about_page', array(
        'default' => '',
        'sanitize_callback' => 'absint'
    ));

    $wp_customize->add_control('square_about_page', array(
        'settings' => 'square_about_page',
        'section' => 'square_about_sec',
        'type' => 'dropdown-pages',
        'label' => esc_html__('Select a Page', 'square')
    ));

    $wp_customize->add_setting('square_about_image_header', array(
        'default' => '',
        'sanitize_callback' => 'square_sanitize_text'
    ));

    $wp_customize->add_control(new Square_Customize_Heading($wp_customize, 'square_about_image_header', array(
        'settings' => 'square_about_image_header',
        'section' => 'square_about_sec',
        'label' => esc_html__('About Page Stack Images', 'square')
    )));

    $wp_customize->add_setting('square_about_image_stack', array(
        'default' => '',
        'sanitize_callback' => 'square_sanitize_text'
    ));

    $wp_customize->add_control(new Square_Display_Gallery_Control($wp_customize, 'square_about_image_stack', array(
        'settings' => 'square_about_image_stack',
        'section' => 'square_about_sec',
        'label' => esc_html__('About Us Stack Image', 'square'),
        'description' => esc_html__('Recommended Image Size: 400X420px', 'square') . '<br/>' . esc_html__('Leave the gallery empty for Full Width Text', 'square')
    )));

    /* ============ABOUT SECTION============ */

    $wp_customize->add_section('square_tab_sec', array(
        'title' => esc_html__('Tab Section', 'square'),
        'panel' => 'square_home_settings_panel'
    ));

    $wp_customize->add_setting('square_disable_tab_sec', array(
        'default' => 0,
        'sanitize_callback' => 'absint'
    ));

    $wp_customize->add_control('square_disable_tab_sec', array(
        'settings' => 'square_disable_tab_sec',
        'section' => 'square_tab_sec',
        'label' => esc_html__('Disable Tab Section ', 'square'),
        'type' => 'checkbox',
        'priority' => 5
    ));

    for ($i = 1; $i < 6; $i++) {

        $wp_customize->add_setting('square_tab_header' . $i, array(
            'default' => '',
            'sanitize_callback' => 'square_sanitize_text'
        ));

        $wp_customize->add_control(new Square_Customize_Heading($wp_customize, 'square_tab_header' . $i, array(
            'settings' => 'square_tab_header' . $i,
            'section' => 'square_tab_sec',
            'label' => esc_html__('Tab ', 'square') . $i,
            'priority' => 10
        )));

        $wp_customize->add_setting('square_tab_title' . $i, array(
            'default' => '',
            'sanitize_callback' => 'square_sanitize_text'
        ));

        $wp_customize->add_control('square_tab_title' . $i, array(
            'settings' => 'square_tab_title' . $i,
            'section' => 'square_tab_sec',
            'type' => 'text',
            'label' => esc_html__('Tab Title', 'square'),
            'priority' => 10
        ));

        $wp_customize->add_setting('square_tab_icon' . $i, array(
            'default' => 'fa fa-bell',
            'sanitize_callback' => 'square_sanitize_text'
        ));

        $wp_customize->add_control(new Square_Fontawesome_Icon_Chooser($wp_customize, 'square_tab_icon' . $i, array(
            'settings' => 'square_tab_icon' . $i,
            'section' => 'square_tab_sec',
            'type' => 'icon',
            'label' => esc_html__('FontAwesome Icon', 'square'),
            'priority' => 10
        )));

        $wp_customize->add_setting('square_tab_page' . $i, array(
            'default' => '',
            'sanitize_callback' => 'absint'
        ));

        $wp_customize->add_control('square_tab_page' . $i, array(
            'settings' => 'square_tab_page' . $i,
            'section' => 'square_tab_sec',
            'type' => 'dropdown-pages',
            'label' => esc_html__('Select a Page', 'square'),
            'priority' => 10
        ));
    }

    /* ============CLIENTS LOGO SECTION============ */
    $wp_customize->add_section('square_logo_sec', array(
        'title' => esc_html__('Clients Logo Section', 'square'),
        'panel' => 'square_home_settings_panel'
    ));

    $wp_customize->add_setting('square_disable_logo_sec', array(
        'default' => 0,
        'sanitize_callback' => 'absint'
    ));

    $wp_customize->add_control('square_disable_logo_sec', array(
        'settings' => 'square_disable_logo_sec',
        'section' => 'square_logo_sec',
        'label' => esc_html__('Disable Client Logo Section ', 'square'),
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('square_logo_header', array(
        'default' => '',
        'sanitize_callback' => 'square_sanitize_text'
    ));

    $wp_customize->add_control(new Square_Customize_Heading($wp_customize, 'square_logo_header', array(
        'settings' => 'square_logo_header',
        'section' => 'square_logo_sec',
        'label' => esc_html__('Section Title & Logo', 'square')
    )));

    $wp_customize->add_setting('square_logo_title', array(
        'default' => '',
        'sanitize_callback' => 'square_sanitize_text'
    ));

    $wp_customize->add_control('square_logo_title', array(
        'settings' => 'square_logo_title',
        'section' => 'square_logo_sec',
        'type' => 'text',
        'label' => esc_html__('Title', 'square')
    ));

    //CLIENTS LOGOS
    $wp_customize->add_setting('square_client_logo_image', array(
        'default' => '',
        'sanitize_callback' => 'square_sanitize_text'
    ));

    $wp_customize->add_control(new Square_Display_Gallery_Control($wp_customize, 'square_client_logo_image', array(
        'settings' => 'square_client_logo_image',
        'section' => 'square_logo_sec',
        'label' => esc_html__('Upload Clients Logos', 'square'),
        'description' => esc_html__('Recommended Image Size: 220X90px', 'square')
    )));

    /* ============SOCIAL ICONS SECTION============ */
    $wp_customize->add_section('square_social_sec', array(
        'title' => esc_html__('Footer Social Icons', 'square'),
    ));

    $wp_customize->add_setting('square_social_facebook', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));

    $wp_customize->add_control('square_social_facebook', array(
        'settings' => 'square_social_facebook',
        'section' => 'square_social_sec',
        'type' => 'text',
        'label' => esc_html__('Facebook', 'square')
    ));

    $wp_customize->add_setting('square_social_twitter', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));

    $wp_customize->add_control('square_social_twitter', array(
        'settings' => 'square_social_twitter',
        'section' => 'square_social_sec',
        'type' => 'text',
        'label' => esc_html__('Twitter', 'square')
    ));

    $wp_customize->add_setting('square_social_pinterest', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));

    $wp_customize->add_control('square_social_pinterest', array(
        'settings' => 'square_social_pinterest',
        'section' => 'square_social_sec',
        'type' => 'text',
        'label' => esc_html__('Pinterest', 'square')
    ));

    $wp_customize->add_setting('square_social_youtube', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));

    $wp_customize->add_control('square_social_youtube', array(
        'settings' => 'square_social_youtube',
        'section' => 'square_social_sec',
        'type' => 'text',
        'label' => esc_html__('Youtube', 'square')
    ));

    $wp_customize->add_setting('square_social_linkedin', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));

    $wp_customize->add_control('square_social_linkedin', array(
        'settings' => 'square_social_linkedin',
        'section' => 'square_social_sec',
        'type' => 'text',
        'label' => esc_html__('Linkedin', 'square')
    ));

    $wp_customize->add_setting('square_social_instagram', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));

    $wp_customize->add_control('square_social_instagram', array(
        'settings' => 'square_social_instagram',
        'section' => 'square_social_sec',
        'type' => 'text',
        'label' => esc_html__('Instagram', 'square')
    ));

    /* ============PRO FEATURES============ */
    $wp_customize->add_section('square_pro_feature_section', array(
        'title' => esc_html__('Pro Theme Features', 'square'),
        'priority' => 1
    ));

    $wp_customize->add_setting('square_pro_features', array(
        'sanitize_callback' => 'total_sanitize_text'
    ));

    $wp_customize->add_control(new Square_Info_Text($wp_customize, 'square_pro_features', array(
        'settings' => 'square_pro_features',
        'section' => 'square_pro_feature_section',
        'description' => $square_pro_features
    )));
}

add_action('customize_register', 'square_customize_register');

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function square_customize_preview_js() {
    wp_enqueue_script('square_customizer', get_template_directory_uri() . '/js/customizer.js', array('customize-preview'), '20130508', true);
}

add_action('customize_preview_init', 'square_customize_preview_js');

function square_customizer_script() {
    wp_enqueue_script('square-customizer-script', get_template_directory_uri() . '/inc/js/customizer-scripts.js', array('jquery'), '09092016', true);
    wp_enqueue_script('square-customizer-chosen-script', get_template_directory_uri() . '/inc/js/chosen.jquery.js', array('jquery'), '1.4.1', true);
    wp_enqueue_style('square-customizer-chosen-style', get_template_directory_uri() . '/inc/css/chosen.css');
    wp_enqueue_style('square-customizer-font-awesome', get_template_directory_uri() . '/css/font-awesome.css');
    wp_enqueue_style('square-customizer-style', get_template_directory_uri() . '/inc/css/customizer-style.css');
}

add_action('customize_controls_enqueue_scripts', 'square_customizer_script');


if (class_exists('WP_Customize_Control')):

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
                    <i class="fa <?php echo esc_attr($this->value()); ?>"></i>
                    <span><i class="fa fa-angle-down"></i></span>
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

                <div class="gallery-screenshot clearfix">
                    <?php {
                        $ids = explode(',', $this->value());
                        foreach ($ids as $attachment_id) {
                            $img = wp_get_attachment_image_src($attachment_id, 'thumbnail');
                            echo '<div class="screen-thumb"><img src="' . esc_url($img[0]) . '" /></div>';
                        }
                    }
                    ?>
                </div>

                <input id="edit-gallery" class="button upload_gallery_button" type="button" value="<?php esc_html_e('Add/Edit Gallery', 'square') ?>" />
                <input id="clear-gallery" class="button upload_gallery_button" type="button" value="<?php esc_html_e('Clear', 'square') ?>" />
                <input type="hidden" class="gallery_values" <?php echo esc_attr($this->link()) ?> value="<?php echo esc_attr($this->value()); ?>">
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

    endif;


if (class_exists('WP_Customize_Section')):

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
        public $type = 'pro-section';

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
            $json['pro_url'] = esc_url($this->pro_url);

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

    endif;

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
