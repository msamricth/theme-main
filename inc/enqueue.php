<?php
/**
 * Template file: inc/enqueue.php
 * Settings that came with the original Boiler point
 *
 * @package Bootstrap Base
 * @since v1
 */

/**
 * Loading All CSS Stylesheets and Javascript Files.
 *
 * @since v1.0
 */

function theme_main_styles_loader()
{
    $theme_version = wp_get_theme()->get('Version');
    wp_enqueue_style('theme-main-inline-styles', get_stylesheet_uri());

    // 1. Styles.
    wp_enqueue_style('style', get_template_directory_uri() . '/style.css', array(), $theme_version, 'all');
    wp_enqueue_script('fontawesome', 'https://kit.fontawesome.com/8b0174b394.js', '', true);
    wp_enqueue_style('main', get_template_directory_uri() . '/build/main.css', array(), $theme_version, 'all'); // main.scss: Compiled Framework source + custom styles.

    wp_enqueue_script('vimeo', 'https://player.vimeo.com/api/player.js', ['jquery'], true);

    if (is_rtl()) {
        wp_enqueue_style('rtl', get_template_directory_uri() . '/assets/css/rtl.css', array(), $theme_version, 'all');
    }
}

add_action('wp_enqueue_scripts', 'theme_main_styles_loader');


add_filter('script_loader_tag', 'my_scripts_modifier', 10, 3);

function my_scripts_modifier($tag, $handle, $src)
{
    if ('splide' === $handle) {
        return '<script defer src="' . $src . '" type="text/javascript" integrity="sha256-FZsW7H2V5X9TGinSjjwYJ419Xka27I8XPDmWryGlWtw=" crossorigin="anonymous"></script>' . "\n";
    }
    return $tag;
}

function theme_main_black_editor_scripts()
{
    $screen = get_current_screen();

    // Check if we are on the widgets.php page in wp-admin
    if ($screen && $screen->id === 'widgets') {
        return;
    }

    // Enqueue the 'wp-editor' script separately to avoid conflicts
    wp_enqueue_script('wp-editor');

    // Enqueue your 'theme-editor' script with proper dependencies
    wp_enqueue_script(
        'theme-editor',
        get_template_directory_uri() . '/build/editor.js',
        array('wp-blocks', 'wp-dom', 'wp-edit-post', 'acf', 'wp-editor'), // Add 'wp-editor' as a dependency
        filemtime(get_template_directory() . '/build/editor.js'),
        true
    );

}

add_action('enqueue_block_editor_assets', 'theme_main_black_editor_scripts');
function theme_main_black_editor_assets()
{
    $screen = get_current_screen();

    // Enqueue your 'theme-editor' styles
    wp_enqueue_style(
        'theme-editor',
        get_theme_file_uri('build/main.css'),
        array(),
        filemtime(get_theme_file_path('build/main.css')), // Use filemtime to add version based on file modification time
        'all'
    );
}

add_action('enqueue_block_editor_assets', 'theme_main_black_editor_assets');





function enqueue_splide_script()
{
    wp_enqueue_script('splide-script', 'https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js', array('jquery'), null, true);
}

// Hook the script enqueue function to 'wp_enqueue_scripts' and 'enqueue_block_editor_assets' actions
//add_action('wp_enqueue_scripts', 'enqueue_splide_script');
//add_action('enqueue_block_editor_assets', 'enqueue_splide_script');

// Check if the function theme_main_get_legacy_carousel is called, and enqueue the script
function enqueue_block_script_on_page()
{
    global $post;

    // Check if the function is called and if it's in the block editor
    if (function_exists('theme_main_get_legacy_carousel') && (is_admin() || (isset ($post->post_content) && has_shortcode($post->post_content, 'theme_main_get_legacy_carousel')))) {
        enqueue_splide_script();
    } else {

        if (function_exists('theme_main_get_carousel') && (is_admin() || (isset ($post->post_content) && has_shortcode($post->post_content, 'theme_main_get_carousel')))) {

            wp_enqueue_script('jQuery', 'https://code.jquery.com/jquery-3.7.1.min.js', array('jquery'), null, true);

            enqueue_splide_script();
        } else {
            if (check_if_block_exist('acf/content-slider')) {
                enqueue_splide_script();
            }
        }

    }

}
// Hook the conditional script enqueue function to 'wp_enqueue_scripts' and 'enqueue_block_editor_assets' actions
//add_action('wp_enqueue_scripts', 'enqueue_splide_script_on_page');
add_action('enqueue_block_editor_assets', 'enqueue_block_script_on_page');


function theme_main_scripts_loader()
{
    $theme_version = wp_get_theme()->get('Version');

    wp_enqueue_script('main', get_template_directory_uri() . '/build/main.bundle.js', array(), $theme_version, true);

    wp_localize_script(
        'main',
        'ajax_object',
        array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'ajax_nonce' => wp_create_nonce('load_more_nonce'),
        )
    );
    //if (!is_admin()) {
    global $post;
    //if ($post) {
    $blocks = parse_blocks($post->post_content);
    $loadSplide = false;
    foreach ($blocks as $block) {
        if(has_block('acf/lottie-motion')) {
            wp_enqueue_script( 'lottie-player', "https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js", array(), $theme_version, true );
        }
        if (has_block('acf/content-slider')) {
            $loadSplide = true;
        }
        if (has_block('acf/header-block') && isset($block['attrs']['data']) && isset($block['attrs']['data']['header_type'])) {
            $header_type = $block['attrs']['data']['header_type'];
            if ($header_type == 'carousel') {
                $loadSplide = true;
            }
        }
    }
    if ($loadSplide) {
        enqueue_splide_script();
    }
}

add_action('wp_enqueue_scripts', 'theme_main_scripts_loader', 100);