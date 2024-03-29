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
        $turnOnFold = '';
        $styles = '';
        $anchor = $blockID . '-block-' . $block['id'];
        if (!empty($block['anchor'])) {
            $anchor = $block['anchor'];
        }
        $classes = $classNames . ' ';
        // Create class attribute allowing for custom "className" and "align" values.


        if (!empty($block['className'])) {
            $classes .= $block['className'];
        }
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
        if (!empty($block['animationDelay'])) {
            $animation_delay = str_replace('animation-delay-', '', $block['animationDelay']);
            if(!str_contains($animation_delay, 's')){
                $animation_delay .= 's';
            } 
            $styles .= ' --theme-main-animation-delay: ' .$animation_delay . ';';
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
        if (!empty($block['fullWidth'])) {
            $classes .= ' full-width';
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

        if (!empty($block['matchNavBackground'])) {
            $turnOnFold = 1;

            if (!empty($block['textColor'])) {
                $classes .= ' colorMatch_' . $block['textColor'];
            }
            if (!empty($block['backgroundColor'])) {
                $classes .= '  match-nav match_' . $block['backgroundColor'];
            }
        }
        if (!empty($block['blockAnimation'])) {
            $turnOnFold = 1;
            $classes .= '  animation-on ' . $block['blockAnimation'];
        }
        if ($turnOnFold) {
            $classes .= ' fold';
        }
        if (!empty($block['hideMobile'])) {
            $classes .= ' d-none d-md-inherit';
        }
        if (!empty($block['hideTablet'])) {
            $classes .= ' d-inherit d-md-none d-xl-inherit';
        }
        if (!empty($block['hideDesktop'])) {
            $classes .= ' d-xl-none';
        }


        if (!empty($block['backgroundImage'])) {
            $classes .= ' has-background-image';
            $styles .= ' background-image:url(' . $block['backgroundImage'] . ');';
        }

        $anchor = 'id="' . $anchor . '"';
        $classes = ' class="' . $classes . '"';
        if(!empty($styles)){
            $styles = ' style="'.$styles.'"';
        }
        $output = $anchor . $classes . $styles;

        return $output;
    }
endif;
// Add custom inline styles to all blocks except ACF blocks
function get_block_settings_for_core_blocks( $block_content, $block ) {
    
    $styles = '';
    if (!is_null($block['blockName']) && strpos($block['blockName'], 'acf/') === 0) {
        // If it's an ACF block, return the block content as is without any modifications since we handled that above
        return $block_content;
    }
    if (!empty($block['animationDelay'])) {
        $animation_delay = str_replace('animation-delay-', '', $block['animationDelay']);
        if(!str_contains($animation_delay, 's')){
            $animation_delay .= 's';
        } 
        $styles .= ' --theme-main-animation-delay: ' .$animation_delay . ';';
    }
    if(!empty($styles)){
        $styles = ' style="'.$styles.'"';
    }

    // Add the custom inline styles to the block's attributes
    $block_content = str_replace( '<' . $block['blockName'], '<' . $block['blockName'] . ' ' . esc_attr( $styles ) . ' ', $block_content );

    return $block_content;
}
add_filter( 'render_block', 'get_block_settings_for_core_blocks', 10, 2 );

if (!function_exists('get_block_classes')):
    /**
     *
     * @since v1
     * Make creating blocks as easy as possible.
     */
    function get_block_classes($block, $classNames, $classNamesOff = null)
    {
        $output = '';

        $turnOnFold = '';

        $classes = $classNames . ' ';
        // Create class attribute allowing for custom "className" and "align" values.
    
        if (!empty($block['className']) && empty($classNamesOff)) {
            $classes .= $block['className'];
        }
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
        if (!empty($block['fullWidth'])) {
            $classes .= ' full-width';
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

        if (!empty($block['matchNavBackground'])) {
            $turnOnFold = 1;

            if (!empty($block['textColor'])) {
                $classes .= ' colorMatch_' . $block['textColor'];
            }
            if (!empty($block['backgroundColor'])) {
                $classes .= '  match-nav match_' . $block['backgroundColor'];
            }
        }
        if (!empty($block['blockAnimation'])) {
            $turnOnFold = 1;
            $classes .= '  animation-on ' . $block['blockAnimation'];
        }
        if ($turnOnFold) {
            $classes .= ' fold';
        }
        if (!empty($block['hideMobile'])) {
            $classes .= ' d-none d-md-inherit';
        }
        if (!empty($block['hideTablet'])) {
            $classes .= ' d-inherit d-md-none d-xl-inherit';
        }
        if (!empty($block['hideDesktop'])) {
            $classes .= ' d-xl-none';
        }
        $output = $classes;

        return $output;
    }
endif;
if (!function_exists('get_block_settings_no_colors')):
    /**
     *
     * @since v1
     * Make creating blocks as easy as possible.
     */
    function get_block_settings_no_colors($block, $blockID, $classNames)
    {
        $output = '';
        $turnOnFold = '';
        $anchor = $blockID . '-block-' . $block['id'];
        if (!empty($block['anchor'])) {
            $anchor = $block['anchor'];
        }
        $classes = $classNames . ' ';
        // Create class attribute allowing for custom "className" and "align" values.


        if (!empty($block['className'])) {
            $classes .= $block['className'];
        }
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
        if (!empty($block['fullWidth'])) {
            $classes .= ' full-width';
        }
        if (!empty($block['blockAnimation'])) {
            $classes .= ' ' . $block['blockAnimation'];
        }


        if (!empty($block['blockAnimation'])) {
            $turnOnFold = 1;
            $classes .= '  animation-on ' . $block['blockAnimation'];
        }
        if ($turnOnFold) {
            $classes .= ' fold';
        }
        if (!empty($block['hideMobile'])) {
            $classes .= ' d-none d-md-inherit';
        }
        if (!empty($block['hideTablet'])) {
            $classes .= ' d-inherit d-md-none d-xl-inherit';
        }
        if (!empty($block['hideDesktop'])) {
            $classes .= ' d-xl-none';
        }


        if (!empty($block['backgroundImage'])) {
            $classes .= ' has-background-image';
            $classes .= '" style="background-image:url(' . $block['backgroundImage'] . ');';
        }

        $anchor = 'id="' . $anchor . '"';
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
    //register_block_type(get_template_directory() . '/inc/blocks/base');
    register_block_type(get_template_directory() . '/inc/blocks/footer-nav');
    register_block_type(get_template_directory() . '/inc/blocks/social-media-nav');
    register_block_type(get_template_directory() . '/inc/blocks/header-block');
    register_block_type(get_template_directory() . '/inc/blocks/media');
    register_block_type(get_template_directory() . '/inc/blocks/content-slider');
    register_block_type(get_template_directory() . '/inc/blocks/floating-cta');
    register_block_type(get_template_directory() . '/inc/blocks/cards');
    register_block_type(get_template_directory() . '/inc/blocks/card-grid');
    register_block_type(get_template_directory() . '/inc/blocks/stats');
    register_block_type(get_template_directory() . '/inc/blocks/half-screen');
    register_block_type(get_template_directory() . '/inc/blocks/content-loop');
    register_block_type(get_template_directory() . '/inc/blocks/content-slider-gutenberg-slide');
    register_block_type(get_template_directory() . '/inc/blocks/logo-carousel');
    register_block_type(get_template_directory() . '/inc/blocks/staff-card');
    register_block_type(get_template_directory() . '/inc/blocks/accordion-or-tabs');
    register_block_type(get_template_directory() . '/inc/blocks/word-fumbler');
    register_block_type(get_template_directory() . '/inc/blocks/big-list');
    register_block_type(get_template_directory() . '/inc/blocks/big-list-item');
    register_block_type(get_template_directory() . '/inc/blocks/image');
    register_block_type(get_template_directory() . '/inc/blocks/icon');
    register_block_type(get_template_directory() . '/inc/blocks/lottie-motion');
    register_block_type(get_template_directory() . '/inc/blocks/image-cloud');
    register_block_type(get_template_directory() . '/inc/blocks/pop-over');
    

    if (class_exists('WPCF7')) {
        register_block_type(get_template_directory() . '/inc/blocks/contact-form-7');
    }

    //register_block_type(get_template_directory() . '/inc/blocks/carousel-slide-block'); these will be available in a future update.
    //register_block_type(get_template_directory() . '/inc/blocks/carousel-header');
    //register_block_type(get_template_directory() . '/inc/blocks/carousel');

}
add_action('init', 'theme_main_register_acf_blocks');


function theme_main_carousel_blocks_slides($allowed_blocks, $post)
{
    // Get the current block type
    $block_type = get_post_type($post);

    if ($block_type === 'acf/carousel-block') {
        // Define the allowed inner block type(s)
        $allowed_inner_blocks = array('acf/carousel-slide-block');

        // Check if the inner block is allowed
        if (!in_array($block_type, $allowed_inner_blocks)) {
            // If not allowed, remove it
            return array();
        }
    } elseif ($block_type === 'acf/carousel-header') {
        // Define the allowed inner block type(s)
        $allowed_inner_blocks = array('acf/carousel-slide-block');

        // Check if the inner block is allowed
        if (!in_array($block_type, $allowed_inner_blocks)) {
            // If not allowed, remove it
            return array();
        }
    }

    // If not the specified parent block, allow all inner blocks
    return $allowed_blocks;
}

// Hook the function into the 'allowed_block_types_all' filter
add_filter('allowed_block_types_all', 'theme_main_carousel_blocks_slides', 10, 2);


function acf_set_featured_image($post_id = null)
{

    // acf/save_post - filter for all ACF fields
//dd_action('acf/save_post', 'acf_set_featured_image', 20);
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
                    if ($image_data) {
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