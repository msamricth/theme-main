<?php
/**
 * Template file: inc/core/blocks.php
 *
 * @package Bootstrap Base
 * @since v1
 */


if (!function_exists('check_if_block_exist')):
    /**
     *
     * @since v??
     */
    function check_if_block_exist($block_handle)
    {
        $post = get_post();
        if (isset($post->post_content)) {
            if (has_blocks($post->post_content)) {
                $blocks = parse_blocks($post->post_content);

                foreach ($blocks as $block) {
                    if ($block['blockName'] === $block_handle) {
                        return true;
                    }
                }
                return false;
            }
        }
    }
endif;

if (!function_exists('get_block_settings')):
    /**
     *
     * @since v1
     * Make creating blocks as easy as possible.
     */
    function get_block_settings($block, $blockID, $classNames)
    {
        $output = '';

        $anchor = $blockID . '-block-' . $block['id'];
        if (!empty($block['anchor'])) {
            $anchor = $block['anchor'];
        }
        $classes = $classNames . ' ';
        // Create class attribute allowing for custom "className" and "align" values.
        if (!empty($block['className']))
            $classes .= array_merge($classes, explode(' ', $block['className']));
        if (!empty($block['alignText'])) {
            $classes .= ' text-' . $block['alignText'];
        }
        if (!empty($block['alignContent'])) {
            $classes .= ' align-items-' . $block['alignContent'];
        }
        if (!empty($block['fullHeight'])) {
            $classes .= ' full-height';
        }
        if (!empty($block['align'])) {
            $classes .= ' align' . $block['align'];
        }
        if (!empty($block['topPadding'])) {
            $classes .= ' ' . $block['topPadding'];
        }
        if (!empty($block['bottomPadding'])) {
            $classes .= ' ' . $block['bottomPadding'];
        }
        if (!empty($block['topMargin'])) {
            $classes .= ' ' . $block['topMargin'];
        }
        if (!empty($block['bottomMargin'])) {
            $classes .= ' ' . $block['bottomMargin'];
        }
        if (!empty($block['fullHeight'])) {
            $classes .= ' ' . $block['fullHeight'];
        }
        if (!empty($block['blockAnimation'])) {
            $classes .= ' ' . $block['blockAnimation'];
        }
        if (!empty($block['backgroundColor'])) {
            $classes .= ' has-' . $block['backgroundColor'] . '-background-color';
        }

        if (!empty($block['textColor'])) {
            $classes .= ' has-' . $block['textColor'] . '-color';
        }

        $anchor = 'id="' . $anchor . '"';
        $classes = ' class="' . $classes . '"';
        $output = $anchor . $classes;

        return $output;
    }
endif;
if (!function_exists('get_block_classes')):
    /**
     *
     * @since v1
     * Make creating blocks as easy as possible.
     */
    function get_block_classes($block, $classNames)
    {
        $output = '';


        $classes = $classNames . ' ';
        // Create class attribute allowing for custom "className" and "align" values.
        if (!empty($block['className']))
            $classes .= array_merge($classes, explode(' ', $block['className']));
        if (!empty($block['alignText'])) {
            $classes .= ' text-' . $block['alignText'];
        }
        if (!empty($block['alignContent'])) {
            $classes .= ' align-items-' . $block['alignContent'];
        }
        if (!empty($block['fullHeight'])) {
            $classes .= ' full-height';
        }
        if (!empty($block['align'])) {
            $classes .= ' align' . $block['align'];
        }
        if (!empty($block['topPadding'])) {
            $classes .= ' ' . $block['topPadding'];
        }
        if (!empty($block['bottomPadding'])) {
            $classes .= ' ' . $block['bottomPadding'];
        }
        if (!empty($block['topMargin'])) {
            $classes .= ' ' . $block['topMargin'];
        }
        if (!empty($block['bottomMargin'])) {
            $classes .= ' ' . $block['bottomMargin'];
        }
        if (!empty($block['fullHeight'])) {
            $classes .= ' ' . $block['fullHeight'];
        }
        if (!empty($block['blockAnimation'])) {
            $classes .= ' ' . $block['blockAnimation'];
        }
        if (!empty($block['backgroundColor'])) {
            $classes .= ' has-' . $block['backgroundColor'] . '-background-color';
        }

        if (!empty($block['textColor'])) {
            $classes .= ' has-' . $block['textColor'] . '-color';
        }

        $output = $classes;

        return $output;
    }
endif;


function theme_main_register_acf_blocks()
{
    /**
     * We register our block's with WordPress's handy
     * register_block_type();
     *
     * @link https://developer.wordpress.org/reference/functions/register_block_type/
     */
    //register_block_type(get_stylesheet_directory() . '/inc/blocks/base');
    register_block_type(get_stylesheet_directory() . '/inc/blocks/footer-nav');
    register_block_type(get_stylesheet_directory() . '/inc/blocks/social-media-nav');
    register_block_type(get_stylesheet_directory() . '/inc/blocks/header-block');
    register_block_type(get_stylesheet_directory() . '/inc/blocks/media');

}
add_action('init', 'theme_main_register_acf_blocks');


    function acf_set_featured_image($post_id = null)
    {

        $current_post = get_queried_object();
        if (empty($post_id)) {
            $post_id = $current_post ? $current_post->ID : null;
        }

        $post_thumbnail_exists = has_post_thumbnail($post_id);

        if (!$post_thumbnail_exists) {
            $post = get_post($post_id);
            $blocks = parse_blocks($post->post_content);

            foreach ($blocks as $block) {
                if ('acf/header-block' === $block['blockName']) {

                    $image_data = get_field('header_image', $block['id']);
                   if (!empty($block['attrs']['data']['header_image'])) {
                        $image_data = $block['attrs']['data']['header_image'];
                    }

                    // Check if it's an array and has an ID
                    if (is_array($image_data) && isset($image_data['ID'])) {
                        $image_id = $image_data['ID'];
                    } else {
                        if($image_data){
                            $image_id = $image_data;
                        }                       
                    }
                    if ($image_id) {
                        update_post_meta($post_id, '_thumbnail_id', $image_id);
                    }
                }
            }
        }
    }

    // acf/save_post - filter for all ACF fields
    add_action('acf/save_post', 'acf_set_featured_image', 20);
    