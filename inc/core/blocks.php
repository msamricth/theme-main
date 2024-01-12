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
    function get_block_settings($block, $blockID, $classes)
    {
        $output = '';

        $anchor = $blockID . '-block-' . $block['id'];
        if (!empty($block['anchor'])) {
            $anchor = $block['anchor'];
        }

        // Create class attribute allowing for custom "className" and "align" values.
        if (!empty($block['className']))
            $classes .= array_merge($classes, explode(' ', $block['className']));

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

        $anchor = 'id="'.$anchor.'"';
        $classes = ' class="' . $classes . '"';
        $output = $anchor . $classes;

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
    register_block_type(get_stylesheet_directory() . '/inc/blocks/base');
    register_block_type(get_stylesheet_directory() . '/inc/blocks/media');

}
add_action('init', 'theme_main_register_acf_blocks');