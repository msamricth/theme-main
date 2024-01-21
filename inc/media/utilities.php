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
            $mobileVideo .= '<div class="d-md-none theme-main-video ratio ratio-' . $mobile_ratio . '">' . background_video($videoMURL, $mobileplaceholder, 'yes', 'preload="auto" autoplay ') . '</div>';
            $classes .= "d-none d-md-block";
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