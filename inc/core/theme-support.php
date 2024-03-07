<?php
/**
 * Template file: inc/core/theme-support.php
 * add theme support 
 *
 * @package Bootstrap Base
 * @since v1.5
 */

add_theme_support(
    'editor-font-sizes',
    array(
        array(
            'name' => esc_attr__('Small', 'themeLangDomain'),
            'size' => 12,
            'slug' => 'small'
        ),
        array(
            'name' => esc_attr__('Regular', 'themeLangDomain'),
            'size' => 16,
            'slug' => 'regular'
        ),
        array(
            'name' => esc_attr__('Large', 'themeLangDomain'),
            'size' => 36,
            'slug' => 'large'
        ),
        array(
            'name' => esc_attr__('Huge', 'themeLangDomain'),
            'size' => 50,
            'slug' => 'huge'
        )
    )
);
function theme_main_editor_colors()
{
    $colorScheme = theme_main_color_array();

    if (have_rows('extra_colors', 'option')):
        while (have_rows('extra_colors', 'option')):
            the_row();
            $extra_colors_color_label = get_sub_field('color_label');
            $extra_colors_color = get_sub_field('color');
            $extra_colors_color = array(
                'name' => esc_attr__($extra_colors_color_label, theme_namespace()),
                'slug' => slugify($extra_colors_color_label),
                'color' => $extra_colors_color,
            );
            array_push($colorScheme, $extra_colors_color);
        endwhile;
    endif;
    return $colorScheme;
}
add_theme_support('editor-color-palette', theme_main_editor_colors());


if (!function_exists('theme_main_setup_theme')) {
    /**
     * General Theme Settings.
     *
     * @since v1.0
     *
     * @return void
     */
    function theme_main_setup_theme()
    {
        // Make theme available for translation: Translations can be filed in the /languages/ directory.
        load_theme_textdomain(theme_namespace(), __DIR__ . '/languages');

        /**
         * Set the content width based on the theme's design and stylesheet.
         *
         * @since v1.0
         */
        global $content_width;
        if (!isset($content_width)) {
            $content_width = 800;
        }

        // Theme Support.
        add_theme_support('title-tag');
        add_theme_support('automatic-feed-links');
        add_theme_support('post-thumbnails');
        add_theme_support(
            'html5',
            array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'script',
                'style',
                'navigation-widgets',
            )
        );

        // Add support for Block Styles.
        add_theme_support('wp-block-styles');
        // Add support for full and wide alignment.
        add_theme_support('align-wide');
        // Add support for Editor Styles.
        add_theme_support('editor-styles');
        // Enqueue Editor Styles.
        add_editor_style('style-editor.css');

        // Default attachment display settings.
        update_option('image_default_align', 'none');
        update_option('image_default_link_type', 'none');
        update_option('image_default_size', 'large');

        // Custom CSS styles of WorPress gallery.
        add_filter('use_default_gallery_style', '__return_false');
    }
    add_action('after_setup_theme', 'theme_main_setup_theme');

    // Disable Block Directory: https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/filters/editor-filters.md#block-directory
    remove_action('enqueue_block_editor_assets', 'wp_enqueue_editor_block_directory_assets');
    remove_action('enqueue_block_editor_assets', 'gutenberg_enqueue_block_editor_assets_block_directory');
}




function theme_main_load_header_posts_block()
{

    $post_type_object = get_post_type_object('post');
    $post_type_object->template = array(
        array(
            'acf/header-block'
        )
    );

}
add_action('init', 'theme_main_load_header_posts_block', 20);



function theme_main_load_header_page_block()
{

    $post_type_object = get_post_type_object('page');
    $post_type_object->template = array(
        array(
            'acf/header-block'
        )
    );

}

add_action('init', 'theme_main_load_header_page_block', 20);

add_filter('pre_set_site_transient_update_themes', 'theme_main_check_for_updates', 100, 1);

function theme_main_check_for_updates($data) {
    // Theme information
    $theme   = get_stylesheet(); // Folder name of the current theme
    $current = wp_get_theme()->get('Version'); // Get the version of the current theme
    // GitHub information
    $user = 'msamricth'; // The GitHub username hosting the repository
    $repo = 'theme-main'; // Repository name as it appears in the URL
    // Get the latest release tag from the repository. The User-Agent header must be sent, as per
    // GitHub's API documentation: https://developer.github.com/v3/#user-agent-required
    $file = @json_decode(@file_get_contents('https://api.github.com/repos/'.$user.'/'.$repo.'/releases/latest', false,
        stream_context_create(['http' => ['header' => "User-Agent: ".$user."\r\n"]])
    ));

    if ($file && isset($file->tag_name, $file->assets[0]->browser_download_url)) {
        $update = filter_var($file->tag_name, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        // Only return a response if the new version number is higher than the current version
        if ($update > $current) {
            $data->response[$theme] = array(
                'theme'       => $theme,
                // Strip the version number of any non-alpha characters (excluding the period)
                // This way you can still use tags like v1.1 or ver1.1 if desired
                'new_version' => $update,
                'url'         => 'https://github.com/'.$user.'/'.$repo,
                'package'     => $file->assets[0]->browser_download_url,
            );
        }
    }

    return $data;
}
