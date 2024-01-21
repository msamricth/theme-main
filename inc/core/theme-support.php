<?php
/**
 * Template file: inc/core/theme-support.php
 * add theme support 
 *
 * @package Bootstrap Base
 * @since v1.5
 */

add_theme_support('editor-font-sizes', array(
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
function load_headpper_block()
{
    $template = array(
        'acf/header-block',
        array(),
        array(
            'core/paragraph',
            array(
                'placeholder' => 'Add a inner paragraph'
            )
        ),
        array(
            'wp-bootstrap-blocks/row',
            array(),
            array(
                array(
                    'wp-bootstrap-blocks/column',
                    array(),
                    array(
                        array('core/image', array()),
                    )
                ),
                array(
                    'wp-bootstrap-blocks/column',
                    array(),
                    array(
                        array(
                            'core/paragraph',
                            array(
                                'placeholder' => 'Add a inner paragraph'
                            )
                        ),
                    )
                ),
            )
        )
    );
    $post_type_object = get_post_type_object('post');
    $post_type_object->template = $template;
}


function load_header_block()
{

    $post_type_object = get_post_type_object('post');
    $post_type_object->template = array(
        array(
            'acf/header-block')
    );
}
add_action('init', 'load_header_block', 20);
