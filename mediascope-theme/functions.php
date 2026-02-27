<?php
/**
 * Mediascope Theme functions and definitions
 *
 * @package Mediascope
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Theme version
define('MEDIASCOPE_VERSION', '1.0.0');

/**
 * Theme setup
 */
function mediascope_setup() {
    // Add theme support
    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 350,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    add_theme_support('responsive-embeds');
    add_theme_support('align-wide');

    // Register navigation menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'mediascope'),
        'footer-1' => esc_html__('Footer Menu 1', 'mediascope'),
        'footer-2' => esc_html__('Footer Menu 2', 'mediascope'),
        'footer-3' => esc_html__('Footer Menu 3', 'mediascope'),
    ));

    // Set content width
    global $content_width;
    if (!isset($content_width)) {
        $content_width = 1200;
    }
}
add_action('after_setup_theme', 'mediascope_setup');

/**
 * Enqueue scripts and styles
 */
function mediascope_scripts() {
    // Theme stylesheet
    wp_enqueue_style('mediascope-style', get_stylesheet_uri(), array(), MEDIASCOPE_VERSION);
    
    // Theme JavaScript
    wp_enqueue_script('mediascope-script', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), MEDIASCOPE_VERSION, true);
    
    // Localize script
    wp_localize_script('mediascope-script', 'mediascope_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('mediascope_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'mediascope_scripts');

/**
 * Register widget areas
 */
function mediascope_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Sidebar', 'mediascope'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here.', 'mediascope'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
    
    register_sidebar(array(
        'name'          => esc_html__('Footer Widget Area', 'mediascope'),
        'id'            => 'footer-1',
        'description'   => esc_html__('Add footer widgets here.', 'mediascope'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h4 class="footer-title">',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'mediascope_widgets_init');

/**
 * Register custom post types
 */
function mediascope_register_post_types() {
    // Case Studies
    register_post_type('case_study', array(
        'labels' => array(
            'name'                  => esc_html__('Case Studies', 'mediascope'),
            'singular_name'         => esc_html__('Case Study', 'mediascope'),
            'add_new'               => esc_html__('Add New', 'mediascope'),
            'add_new_item'          => esc_html__('Add New Case Study', 'mediascope'),
            'edit_item'             => esc_html__('Edit Case Study', 'mediascope'),
            'new_item'              => esc_html__('New Case Study', 'mediascope'),
            'view_item'             => esc_html__('View Case Study', 'mediascope'),
            'search_items'          => esc_html__('Search Case Studies', 'mediascope'),
            'not_found'             => esc_html__('No case studies found', 'mediascope'),
            'not_found_in_trash'    => esc_html__('No case studies found in trash', 'mediascope'),
        ),
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => array('slug' => 'case-study'),
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'menu_icon'          => 'dashicons-portfolio',
        'show_in_rest'       => true,
    ));
    
    // Team Members
    register_post_type('team_member', array(
        'labels' => array(
            'name'                  => esc_html__('Team Members', 'mediascope'),
            'singular_name'         => esc_html__('Team Member', 'mediascope'),
            'add_new'               => esc_html__('Add New', 'mediascope'),
            'add_new_item'          => esc_html__('Add New Team Member', 'mediascope'),
            'edit_item'             => esc_html__('Edit Team Member', 'mediascope'),
            'new_item'              => esc_html__('New Team Member', 'mediascope'),
            'view_item'             => esc_html__('View Team Member', 'mediascope'),
            'search_items'          => esc_html__('Search Team Members', 'mediascope'),
            'not_found'             => esc_html__('No team members found', 'mediascope'),
            'not_found_in_trash'    => esc_html__('No team members found in trash', 'mediascope'),
        ),
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => array('slug' => 'team'),
        'supports'           => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'menu_icon'          => 'dashicons-groups',
        'show_in_rest'       => true,
    ));
}
add_action('init', 'mediascope_register_post_types');

/**
 * Handle contact form submission
 */
function mediascope_handle_contact_form() {
    // Verify nonce
    if (!isset($_POST['contact_nonce']) || !wp_verify_nonce($_POST['contact_nonce'], 'mediascope_contact_nonce')) {
        wp_die('Security check failed');
    }
    
    // Get form data
    $user_type = sanitize_text_field($_POST['user_type']);
    $first_name = sanitize_text_field($_POST['first_name']);
    $last_name = sanitize_text_field($_POST['last_name']);
    $email = sanitize_email($_POST['email']);
    $country = sanitize_text_field($_POST['country']);
    $company = sanitize_text_field($_POST['company']);
    $phone = sanitize_text_field($_POST['phone']);
    $message = sanitize_textarea_field($_POST['message']);
    $consent = isset($_POST['consent']) ? 1 : 0;
    
    // Validate required fields
    if (empty($user_type) || empty($first_name) || empty($last_name) || empty($email) || empty($country)) {
        wp_die('Please fill in all required fields');
    }
    
    // Prepare email
    $to = get_option('admin_email');
    $subject = 'New Contact Form Submission from ' . $first_name . ' ' . $last_name;
    
    $body = "User Type: $user_type\n";
    $body .= "Name: $first_name $last_name\n";
    $body .= "Email: $email\n";
    $body .= "Country: $country\n";
    $body .= "Company: $company\n";
    $body .= "Phone: $phone\n";
    $body .= "Message:\n$message\n";
    
    $headers = array('Content-Type: text/plain; charset=UTF-8', 'From: ' . $email);
    
    // Send email
    wp_mail($to, $subject, $body, $headers);
    
    // Save to database
    $post_data = array(
        'post_title'   => $first_name . ' ' . $last_name,
        'post_content' => $body,
        'post_status'  => 'private',
        'post_type'    => 'contact_submission',
    );
    
    wp_insert_post($post_data);
    
    // Redirect back with success message
    wp_redirect(home_url('/?contact=success'));
    exit;
}
add_action('admin_post_mediascope_contact_form', 'mediascope_handle_contact_form');
add_action('admin_post_nopriv_mediascope_contact_form', 'mediascope_handle_contact_form');

/**
 * Customizer settings
 */
function mediascope_customize_register($wp_customize) {
    // Hero Section
    $wp_customize->add_section('mediascope_hero', array(
        'title'    => esc_html__('Hero Section', 'mediascope'),
        'priority' => 130,
    ));
    
    $wp_customize->add_setting('hero_title', array(
        'default'           => 'Connecting Brands To The World',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hero_title', array(
        'label'   => esc_html__('Hero Title', 'mediascope'),
        'section' => 'mediascope_hero',
        'type'    => 'text',
    ));
    
    $wp_customize->add_setting('hero_subtitle', array(
        'default'           => 'Media. Culture. Impact.',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hero_subtitle', array(
        'label'   => esc_html__('Hero Subtitle', 'mediascope'),
        'section' => 'mediascope_hero',
        'type'    => 'text',
    ));
    
    $wp_customize->add_setting('hero_button_text', array(
        'default'           => 'Success Stories',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hero_button_text', array(
        'label'   => esc_html__('Button Text', 'mediascope'),
        'section' => 'mediascope_hero',
        'type'    => 'text',
    ));
    
    $wp_customize->add_setting('hero_button_url', array(
        'default'           => '/case-study/',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hero_button_url', array(
        'label'   => esc_html__('Button URL', 'mediascope'),
        'section' => 'mediascope_hero',
        'type'    => 'text',
    ));
    
    $wp_customize->add_setting('hero_background_image');
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_background_image', array(
        'label'    => esc_html__('Background Image', 'mediascope'),
        'section'  => 'mediascope_hero',
        'settings' => 'hero_background_image',
    )));
    
    // About Section
    $wp_customize->add_section('mediascope_about', array(
        'title'    => esc_html__('About Section', 'mediascope'),
        'priority' => 131,
    ));
    
    $wp_customize->add_setting('about_title', array(
        'default'           => 'Reaching Audiences that Matter',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('about_title', array(
        'label'   => esc_html__('About Title', 'mediascope'),
        'section' => 'mediascope_about',
        'type'    => 'text',
    ));
    
    $wp_customize->add_setting('about_subtitle', array(
        'default'           => 'From C-suite Leaders To Trendsetters, Wherever They Are',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('about_subtitle', array(
        'label'   => esc_html__('About Subtitle', 'mediascope'),
        'section' => 'mediascope_about',
        'type'    => 'text',
    ));
    
    $wp_customize->add_setting('about_content', array(
        'default'           => 'We connect brands with the world\'s most influential audiences...',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('about_content', array(
        'label'   => esc_html__('About Content', 'mediascope'),
        'section' => 'mediascope_about',
        'type'    => 'textarea',
    ));
    
    // Social Links
    $wp_customize->add_section('mediascope_social', array(
        'title'    => esc_html__('Social Links', 'mediascope'),
        'priority' => 140,
    ));
    
    $wp_customize->add_setting('social_facebook', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('social_facebook', array(
        'label'   => esc_html__('Facebook', 'mediascope'),
        'section' => 'mediascope_social',
        'type'    => 'url',
    ));
    
    $wp_customize->add_setting('social_twitter', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('social_twitter', array(
        'label'   => esc_html__('Twitter', 'mediascope'),
        'section' => 'mediascope_social',
        'type'    => 'url',
    ));
    
    $wp_customize->add_setting('social_linkedin', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('social_linkedin', array(
        'label'   => esc_html__('LinkedIn', 'mediascope'),
        'section' => 'mediascope_social',
        'type'    => 'url',
    ));
    
    $wp_customize->add_setting('social_instagram', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('social_instagram', array(
        'label'   => esc_html__('Instagram', 'mediascope'),
        'section' => 'mediascope_social',
        'type'    => 'url',
    ));
}
add_action('customize_register', 'mediascope_customize_register');

/**
 * Add custom meta boxes
 */
function mediascope_add_meta_boxes() {
    // Team Member Position
    add_meta_box(
        'team_position',
        'Position',
        'mediascope_team_position_callback',
        'team_member',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'mediascope_add_meta_boxes');

function mediascope_team_position_callback($post) {
    wp_nonce_field('team_position_nonce', 'team_position_nonce');
    $position = get_post_meta($post->ID, 'team_position', true);
    ?>
    <label for="team_position">Position/Title:</label>
    <input type="text" id="team_position" name="team_position" value="<?php echo esc_attr($position); ?>" style="width: 100%;">
    <?php
}

function mediascope_save_meta_boxes($post_id) {
    if (!isset($_POST['team_position_nonce']) || !wp_verify_nonce($_POST['team_position_nonce'], 'team_position_nonce')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    if (isset($_POST['team_position'])) {
        update_post_meta($post_id, 'team_position', sanitize_text_field($_POST['team_position']));
    }
}
add_action('save_post', 'mediascope_save_meta_boxes');

/**
 * Disable WordPress admin bar for non-admin users
 */
function mediascope_disable_admin_bar() {
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}
add_action('after_setup_theme', 'mediascope_disable_admin_bar');

/**
 * Custom excerpt length
 */
function mediascope_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'mediascope_excerpt_length');

/**
 * Custom excerpt more
 */
function mediascope_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'mediascope_excerpt_more');

/**
 * Add async/defer to scripts
 */
function mediascope_script_loader_tag($tag, $handle) {
    if ('mediascope-script' === $handle) {
        $tag = str_replace(' src', ' defer src', $tag);
    }
    return $tag;
}
add_filter('script_loader_tag', 'mediascope_script_loader_tag', 10, 2);
