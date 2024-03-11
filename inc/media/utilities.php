<?php
/**
 * Template file: inc/media/video.php
 * Core Utilities for the Media framework within Theme Main
 *
 * @package Bootstrap Base
 * @since v1
 */

if (!function_exists('muteBTN')):
    /**
     * Mute Button
     *
     * @since v7.0
     * @modified v9
     */
    function muteBTN($darkMode = null)
    {

        if (empty($darkMode)) {
            $mute = get_field('mute_button', 'option');
            $unmute = get_field('unmute_button', 'option');
        } else {
            $mute = get_field('mute_button_dark', 'option');
            $unmute = get_field('unmute_button_dark', 'option');
        }
        $output = '';
        $output .= '<button class="mute-button" role="button" data-bs-toggle="button"><img class="mute" src="' . $mute . '" /><img class="d-none unmute" src="' . $unmute . '" /></button>';
        return $output;
    }

endif;
if (!function_exists('theme_main_limit_inner_blocks')):
    function theme_main_limit_inner_blocks($allowed_block_type, $block_content)
    {
        // Parse the block content
        $blocks = parse_blocks($block_content);

        // Filter only the allowed block type
        $filtered_blocks = array_filter($blocks, function ($block) use ($allowed_block_type) {
            return $block['blockName'] === $allowed_block_type;
        });

        // Convert the filtered blocks back to HTML
        $filtered_content = '';
        foreach ($filtered_blocks as $filtered_block) {
            $filtered_content .= render_block($filtered_block);
        }

        return $filtered_content;
    }
endif;

function theme_main_get_slides_inner_block_template($related_content_title, $related_content_excerpt, $related_content_url, $related_content_placement, $related_content_position, $related_content_date = null)
{
    $slideContent = '';
    $layoutSize = '';
    $inner_blocks_template = '';
    switch ($related_content_placement) {
        case "left":
            $layoutSize = "skinny";
            break;
        case "right":
            $layoutSize = "skinny";
            break;
        case "top":
            $layoutSize = "wide";
            break;
        case "bottom":
            $layoutSize = "wide";
            break;

    }

    if ($layoutSize == "wide") {
        $slideContent .= '<div class="wp-block-columns is-layout-flex wp-container-core-columns-layout-1 wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--30)">'; //1
        $slideContent .= '<div class="wp-block-column is-vertically-aligned-bottom is-layout-flow wp-block-column-is-layout-flow">'; //2
        $slideContent .= '<h2 class="wp-block-post-title">' . $related_content_title . '</h2>';
        $slideContent .= '<p>' . $related_content_excerpt . '</p>';
        $slideContent .= '</div>'; //2
        $slideContent .= '<div class="wp-block-column is-vertically-aligned-bottom is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:250px">'; //3
        $slideContent .= '<div class="wp-block-buttons is-layout-flex wp-container-core-buttons-layout-1 wp-block-buttons-is-layout-flex">'; //4
        $slideContent .= '<div class="wp-block-button"><a href="' . $related_content_url . '" class="wp-block-button__link wp-element-button">Learn More</a></div>'; //5 //5
        $slideContent .= '</div>'; //4
        $slideContent .= '</div>'; //3
        $slideContent .= '</div>'; //1


        $inner_blocks_template = $slideContent;
    }

    if ($layoutSize == "skinny") {

        if ($related_content_position == 'Outside') {


            $slideContent .= '<div class="card-body px-0 pb-4">';
            if ($related_content_date) {
                $slideContent .= '<span class="card-sub-title">' . $related_content_date . '</span>';
            }
            $slideContent .= '<h3 class="card-title">' . $related_content_title . '</h3>';
            $slideContent .= '<p class="card-text mt-3">' . $related_content_excerpt . '</p>';
            $slideContent .= '</div>';
            $slideContent .= '<div class="card-footer bg-transparent text-left me-auto ms-0 ps-0">';
            $slideContent .= '<a href="' . $related_content_url . '" class="btn btn-primary">Learn More</a>';
            $slideContent .= '</div>';


        } else {

            $slideContent .= '<div class="wp-block-columns is-layout-flex wp-container-core-columns-layout-1 wp-block-columns-is-layout-flex" style="padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--30)">';
            $slideContent .= '<div class="wp-block-column is-vertically-aligned-bottom is-layout-flow wp-block-column-is-layout-flow">';

            $slideContent .= '<h2 class="wp-block-post-title">' . $related_content_title . '</h2>';
            $slideContent .= '<p>' . $related_content_excerpt . '</p>';

            $slideContent .= '<div class="wp-block-button"><a href="' . $related_content_url . '" class="wp-block-button__link wp-element-button">Learn More</a></div>';
            $slideContent .= '</div>';
            $slideContent .= '</div>';
        }

        $inner_blocks_template = $slideContent;
    }

    return $inner_blocks_template;
}


if (function_exists('theme_main_get_slides_inner_block_basic_template')) {
    function theme_main_get_slides_inner_block_basic_template()
    {


        $inner_blocks_template = array(
            array(
                'core/columns',
                array(
                    'verticalAlignment' => 'bottom',
                    'style' => array(
                        'spacing' => array(
                            'padding' => array(
                                'top' => 'var:preset|spacing|30',
                                'right' => 'var:preset|spacing|30',
                                'bottom' => 'var:preset|spacing|30',
                                'left' => 'var:preset|spacing|30',
                            ),
                        ),
                    ),
                ),
                array(
                    array(
                        'core/column',
                        array(
                            'verticalAlignment' => 'bottom',
                            'width' => '',
                        ),
                        array(
                            array(
                                'core/paragraph',
                                array(
                                    'placeholder' => 'Add a inner paragraph'
                                )
                            ),
                        ),
                    )
                ),
            ),
        );




        return $inner_blocks_template;
    }
}


//if (function_exists('theme_main_get_slides_options')) {
    function theme_main_get_slides_options($options_same_height, $options_custom_height, $options_gap, $options_per_move, $multiple_slides)
    {
        $blockContent = '';
        if (have_rows('slide_count_per_breakpoint')):
            while (have_rows('slide_count_per_breakpoint')):
                the_row();
                $blockContent .= ' data-s320="' . get_sub_field('320') . '"';
                $blockContent .= ' data-s768="' . get_sub_field('768') . '"';
                $blockContent .= ' data-s1024="' . get_sub_field('1024') . '"';
                $blockContent .= ' data-s1290="' . get_sub_field('1290') . '"';
                $blockContent .= ' data-s1440="' . get_sub_field('1440') . '"';
                $blockContent .= ' data-s1920="' . get_sub_field('1920') . '"';
                $blockContent .= ' data-s2400="' . get_sub_field('2400') . '"';
            endwhile;
        endif;
        if ($options_same_height) { $blockContent .= ' ' . $options_same_height; }
        if ($options_custom_height) {
            $blockContent .= ' data-custom_height="' . $options_custom_height . '" ';
        }
        $blockContent .= 'data-multiple-slides="' . $multiple_slides . '" data-gap="' . $options_gap . '" ' . ' data-per_move="' . $options_per_move . '" ';
        return $blockContent;
    }
//}


if (!function_exists('get_header_gradient_type_color')):
    function get_header_gradient_type_color()
    {
        if (get_sub_field('turn_on_overlay')) {
            if (get_sub_field('overlay_color')) {
                $gradient_type_color = "--theme-main-contrasting-text-" . get_sub_field('overlay_color');

                return 'style="--theme-main-carousel-color: var(' . $gradient_type_color . ');"';

            }
        }
    }
endif;



if (!function_exists('get_header_gradient')):
    function get_header_gradient()
    {
        if (get_sub_field('turn_on_overlay')) {
            $headerOverlayBG = "--bs-" . get_sub_field('overlay_color') . "-rgb";
            $headerOverlayOpacity = get_sub_field('opacity_level');
            $gradient_level = get_sub_field('gradient_level');

            if (empty($headerOverlayOpacity)) {
                $headerOverlayOpacity = '0';
            }
            return '<div class="theme-overlay" style="--theme-main-overlay-color: rgba(var(' . $headerOverlayBG . '), 0.' . $headerOverlayOpacity . '); --theme-main-overlay-level: ' . $gradient_level . '%;"></div>';

        }
    }
endif;

if (!function_exists('get_header_assets')):
    /**
     * Master Container for header videos 
     *
     * @since v5.0
     * @modified v9.8
     */
    function get_header_assets($videoURL = null, $videoMURL = null, $ratio = null, $mobile_ratio = null, $placerholder = null, $mobileplaceholder = null)
    {
        $classes = '';
        $mobileVideo = '';
        $desktopVideo = '';
        $header_media = '';

        if ($videoMURL) {
            if ($mobile_ratio) {
            } else {
                $mobile_ratio = 'mobile';
            }
            $mobileVideo .= '<div class="d-block d-md-none theme-main-video ratio ratio-' . $mobile_ratio . '">' . background_video($videoMURL, $mobileplaceholder, 'yes', 'preload="auto" autoplay ') . '</div>';
            $classes .= "d-none d-md-block";
        } else {
            if ($mobileplaceholder) {

                if ($mobile_ratio) {
                } else {
                    $mobile_ratio = 'mobile';
                }
                $mobileVideo .= '<div class="d-block d-md-none theme-main-video ratio ratio-' . $mobile_ratio . '">' . theme_main_get_image($mobileplaceholder) . '</div>';
                $classes .= "d-none d-md-block";
            }
        }
        if ($ratio) {
            $classes .= ' ratio-' . $ratio;
        } else {
            $classes .= ' ratio-16x9';
        }
        if ($videoURL) {
            $desktopVideo .= '<div class="ratio theme-main-video ' . $classes . '">' . background_video($videoURL, $placerholder, 'yes', 'preload="auto" autoplay ') . '</div>';
        }
        //$desktopVideo .= $mobileVideo;
        //return $desktopVideo;
        if ($ratio) {
            $header_media .= customRatio($ratio);
        }
        if ($mobile_ratio) {
            $header_media .= customRatio($mobile_ratio);
        }
        if (empty($videoURL)) {
            if ($placerholder) {
                $header_media .= image_containers($placerholder, $mobileplaceholder, $ratio, $mobile_ratio);
            } else {
                $header_media .= image_containers_URL('https://placehold.co/1440x750?text=Placeholder%20Image', 'placeholder image', 'https://placehold.co/390x844?text=Placeholder%20for%20header%20media', 'fullw', 'fullw');
            }
        } else {

            $header_media .= $desktopVideo;
            $header_media .= $mobileVideo;
        }

        return $header_media;
    }

endif;






if (!function_exists('video_containers')):
    /**
     * Master Container for videos / with ratios
     *
     * @since v5.0
     * @modified v9
     */
    function video_containers($videoURL, $videoMURL = null, $ratio = null, $mobile_ratio = null, $placerholder = null, $mobileplaceholder = null)
    {
        $classes = '';
        $mobileVideo = '';
        $desktopVideo = '';
        if ($videoMURL) {
            if ($mobile_ratio) {
            } else {
                $mobile_ratio = 'mobile';
            }
            $mobileVideo .= '<div class="d-md-none theme-main-video ratio ratio-' . $mobile_ratio . '">' . background_video($videoMURL, $mobileplaceholder) . '</div>';
            $classes .= "d-none d-md-block";
        }
        if ($ratio) {
            $classes .= ' ratio-' . $ratio;
        } else {
            $classes .= ' ratio-16x9';
        }
        $desktopVideo .= '<div class="ratio theme-main-video ' . $classes . '">' . background_video($videoURL, $placerholder) . '</div>';
        $desktopVideo .= $mobileVideo;
        return $desktopVideo;
    }
endif;

if (!function_exists('image_containers')):
    /**
     * Master Container for Images  / with ratios
     *
     * @since v5.5
     * @modified v9
     */
    function image_containers($imageObject, $imageObjectMobile = null, $ratio = null, $mobile_ratio = null)
    {
        $classes = '';
        $mobileImage = '';
        $desktopImage = '';
        if ($imageObjectMobile) {
            $classes .= 'd-none d-sm-block';
            if ($mobile_ratio) {
            } else {
                $mobile_ratio = 'mobile';
            }
            $mobileImage .= '<div class="d-sm-none theme-main-image ratio ratio-' . $mobile_ratio . '">';
            $mobileImage .= '<img src="' . esc_url($imageObjectMobile['url']) . '" alt="' . esc_attr($imageObjectMobile['alt']) . '" />';
            $mobileImage .= '</div>';
        } else {
            $classes .= "main-image";
        }

        if ($ratio) {
            $classes .= ' ratio-' . $ratio;
        } else {
            $classes .= ' ratio-16x9';
        }
        $desktopImage .= '<div class="ratio theme-main-image ' . $classes . '">';

        $desktopImage .= '<img class="' . $classes . '"';
        if (is_array($imageObject) && isset($imageObject['url'])) {
            $desktopImage .= ' src="' . esc_url($imageObject['url']) . '" alt="' . esc_attr($imageObject['alt']) . '"';
        } else {

            // Check if imageObject is a valid attachment ID
            if (is_numeric($imageObject)) {
                $image_url = wp_get_attachment_image_src($imageObject, 'full');

                if ($image_url) {
                    $desktopImage .= ' src="' . esc_url($image_url[0]) . '" alt="' . esc_attr(get_post_meta($imageObject, '_wp_attachment_image_alt', true)) . '"';
                }
            }


        }
        $desktopImage .= ' />';
        // add fall backs
        $desktopImage .= '</div>';
        $desktopImage .= $mobileImage;
        if (is_array($imageObject)) {
            return $desktopImage;
        }
    }
endif;

if (!function_exists('theme_main_get_image')):
    /**
     * Master Container for Images  / with ratios
     *
     * @since v1.5
     */
    function theme_main_get_image($imageObject)
    {
        $image = '';
        $image .= '<img ';
        if (is_array($imageObject) && isset($imageObject['url'])) {
            $image .= ' src="' . esc_url($imageObject['url']) . '" alt="' . esc_attr($imageObject['alt']) . '"';
        } else {

            // Check if imageObject is a valid attachment ID
            if (is_numeric($imageObject)) {
                $image_url = wp_get_attachment_image_src($imageObject, 'full');

                if ($image_url) {
                    $image .= ' src="' . esc_url($image_url[0]) . '" alt="' . esc_attr(get_post_meta($imageObject, '_wp_attachment_image_alt', true)) . '"';
                }
            }


        }
        $image .= ' />';
        return $image;
    }
endif;
if (!function_exists('image_containers_URL')):
    /**
     * Master Container for Images  / with ratios
     *
     * @since v1.5
     */
    function image_containers_URL($imageObject, $alt = null, $imageObjectMobile = null, $ratio = null, $mobile_ratio = null)
    {
        $classes = '';
        $mobileImage = '';
        $desktopImage = '';
        if ($imageObjectMobile) {
            $classes .= 'd-none d-sm-block';
            if ($mobile_ratio) {
            } else {
                $mobile_ratio = 'mobile';
            }
            $mobileImage .= '<div class="d-sm-none theme-main-image ratio ratio-' . $mobile_ratio . '">';
            $mobileImage .= '<img src="' . $imageObjectMobile . '" alt="' . $alt . '" />';
            $mobileImage .= '</div>';
        } else {
            $classes .= "main-image";
        }

        if ($ratio) {
            $classes .= ' ratio-' . $ratio;
        } else {
            $classes .= ' ratio-16x9';
        }
        $desktopImage .= '<div class="ratio theme-main-image ' . $classes . '">';
        $desktopImage .= '<img class="' . $classes . '" src="' . $imageObject . '" alt="' . $alt . '" />';
        $desktopImage .= '</div>';
        $desktopImage .= $mobileImage;
        return $desktopImage;

    }
endif;

if (!function_exists('image_containersNR')):
    /**
     * Master Container for Images  / WITHOUT ratios
     *
     * @since v5.5
     * @modified v9
     */
    function image_containersNR($imageObject, $imageObjectMobile = null)
    {
        $classes = '';
        $mobileImage = '';
        $desktopImage = '';
        if ($imageObjectMobile) {
            $classes .= 'd-none d-md-block';
            $mobileImage .= '<div class="d-md-none theme-main-image">';
            $mobileImage .= '<img src="' . esc_url($imageObjectMobile['url']) . '" alt="' . esc_attr($imageObjectMobile['alt']) . '" />';
            $mobileImage .= '</div>';
        } else {
            $classes .= "main-image";
        }

        $desktopImage .= '<div class=" theme-main-image ' . $classes . '">';
        $desktopImage .= '<img class="' . $classes . '" src="' . esc_url($imageObject['url']) . '" alt="' . esc_attr($imageObject['alt']) . '" />';
        $desktopImage .= '</div>';
        $desktopImage .= $mobileImage;
        if (is_array($imageObject)) {
            return $desktopImage;
        }
    }
endif;

if (!function_exists('video_containersNR')):
    /**
     * Master Container for videos / WITHOUT ratios
     *
     * @since v5.0
     * @modified v9
     */
    function video_containersNR($mainVideo, $mobileVideo)
    {
        $classes = '';
        $mobileVideoOutput = '';
        $output = '';
        if ($mobileVideo) {
            $mobileVideoOutput .= '<div class="d-md-none theme-main-video">' . $mobileVideo . '</div>';
            $classes .= "d-none d-md-block";
        }
        $output .= '<div class="theme-main-video ' . $classes . '">' . $mainVideo . '</div>';
        $output .= $mobileVideoOutput;
        return $output;
    }

endif;