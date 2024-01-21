<?php
/**
 * Template file: inc/media/settings.php
 * Settings for the Media framework within the Theme Main
 *
 * @package Bootstrap Base
 * @since v1
 */


if (!function_exists('media_block_main')):
    /**
     * Media Block Frame work
     *
     * @since v7.0
     * @modified v9
     */
    function media_block_main()
    {
        $output = '';
        $media_block_video = '';
        $media_block_video_mobile = '';
        $mobile_ratio = '';
        $media_block_image = '';
        $subClasses = '';
        $video_ratio = '';
        $blockStyles = '';
        $video_ratio = '';
        $placerholder = '';
        $mobileplaceholder = '';
        $blockContent = '';
        $self_host_video = '';
        $IsReels = '';
        $IsMute = '';
        $mainVideo = '';
        $mobileVideo = '';
        $PlaceholdervideoURL = '';
        $darkMode = '';

        if (have_rows('media')):
            while (have_rows('media')):
                the_row();
                $video_ratio = get_sub_field('video_ratio');
                if (get_sub_field('make_full_screen') == 1):
                    $video_ratio = 'fullw';
                    $mobile_ratio = 'fullw';
                endif;
                if (get_sub_field('play_button') == 1):
                    $IsReels = 1;
                endif;

                if (get_sub_field('mute_settings') == 1):
                    $IsMute = 1;
                endif;

                if (get_sub_field('dark_layout') == 1):
                    $darkMode = 1;
                endif;
                if (have_rows('video_desktop')):
                    while (have_rows('video_desktop')):
                        the_row();
                        if (have_rows('options')):
                            while (have_rows('options')):
                                the_row();
                                if (get_sub_field('self_host_video') == 1):
                                    $self_host_video = 'true';
                                endif;
                                if ($video_ratio) {
                                } else {
                                    $video_ratio = get_sub_field('video_ratio');
                                }
                            endwhile;
                        endif;
                        if ($self_host_video):
                            $media_block_video = get_sub_field('video_uploaded');
                            $self_host_video = '';
                        else:
                            $media_block_video = get_sub_field('video');
                        endif;

                        $PlaceholdervideoURL = get_sub_field('placeholder_video');

                        if (empty($PlaceholdervideoURL)) {
                            $PlaceholdervideoURL = get_sub_field('placeholder_video_url');
                        }
                        $placerholder = get_sub_field('video_placeholder');

                        if ($IsReels) {
                            $mainVideo = reels($media_block_video, $placerholder, $video_ratio, $PlaceholdervideoURL, $darkMode);
                        } else {
                            $mainVideo = backgroundVideo($media_block_video, $placerholder, $video_ratio, $IsMute, $darkMode);
                        }

                    endwhile;
                endif;

                if (have_rows('video_mobile')):
                    while (have_rows('video_mobile')):
                        the_row();
                        if (have_rows('options')):
                            while (have_rows('options')):
                                the_row();
                                if (get_sub_field('self_host_video') == 1):
                                    $self_host_video = 'true';
                                endif;
                                if ($mobile_ratio) {
                                } else {
                                    $mobile_ratio = get_sub_field('video_ratio');
                                }


                            endwhile;
                        endif;
                        $PlaceholdervideoURL = get_sub_field('placeholder_video');
                        if ($self_host_video):
                            $media_block_video_mobile = get_sub_field('video_mobile_uploaded');
                        else:
                            $media_block_video_mobile = get_sub_field('video_mobile');
                        endif;
                        $mobileplaceholder = get_sub_field('video_placeholder');
                        if ($IsReels) {
                            $mobileVideo = reels($media_block_video_mobile, $mobileplaceholder, $mobile_ratio, $PlaceholdervideoURL, $darkMode);
                        } else {
                            $mobileVideo = backgroundVideo($media_block_video_mobile, $mobileplaceholder, $mobile_ratio, $IsMute, $darkMode);
                        }
                    endwhile;
                endif;
                if ($media_block_video):
                    $output .= customRatio($mobile_ratio);
                    $output .= customRatio($video_ratio);
                    $output .= video_containersNR($mainVideo, $mobileVideo);
                else:
                    if ($placerholder):
                        if ($video_ratio == 'fullw') {
                            $output .= image_containers($placerholder, $mobileplaceholder, $video_ratio, $mobile_ratio);
                        } else {
                            $output .= image_containersNR($placerholder, $mobileplaceholder);
                        }
                    endif;
                endif;
            endwhile;
        endif;

        return $output;

    }
endif;



if (!function_exists('get_header_media')):
    /**
     * Header Media Frame work
     *
     * @since v7.0
     * @modified v9
     */
    function get_header_media()
    {
        $post_id = '';
        $current_post = get_queried_object();
        $post_id = $current_post ? $current_post->ID : null;
        $header_media = '';
        $mobile_ratio = '';
        $video_ratio = '';
        $classes = '';
        $self_host_video = '';
        $video_ratio = '';
        $header_video = '';
        $placerholder = '';
        $mobile_ratio = '';
        $header_video_mobile = '';
        $mobileplaceholder = '';
        $header_gradient = '';
        $header_type = get_field('header_type');

        $header_video_uploaded = get_field('header_video_uploaded');

        $header_video = get_field('header_video');

        $placerholder = get_field('header_image');

        if (have_rows('options')):
            while (have_rows('options')):
                the_row();
                if (get_sub_field('make_full_screen') == 1):
                    $classes .= "fullscreen_media";
                    $video_ratio = 'fullw';
                endif;
                if (empty($video_ratio)) {
                    $video_ratio = get_sub_field('video_ratio');
                }
                $header_gradient = get_header_gradient();

                if (get_sub_field('self_host_video') == 1):
                    $header_video = $header_video_uploaded;
                endif;
            endwhile;
        endif;
        if (have_rows('header_mobile')):
            $self_host_video = '';
            while (have_rows('header_mobile')):
                the_row();
                if (have_rows('options')):
                    while (have_rows('options')):
                        the_row();
                        if (get_sub_field('self_host_video') == 1):
                            $self_host_video = 'true';
                        endif;
                        if (get_sub_field('make_full_screen') == 1):
                            $mobile_ratio = 'fullw';
                        endif;
                        if (empty($mobile_ratio)) {
                            $mobile_ratio = get_sub_field('video_ratio');
                        }

                    endwhile;
                endif;

                if ($self_host_video):
                    $header_video_mobile = get_sub_field('video_mobile_uploaded');
                else:
                    $header_video_mobile = get_sub_field('video_mobile');
                endif;
                $mobileplaceholder = get_sub_field('placeholder_image');

            endwhile;
        endif;

        $header_media .= '<div class="header-container__media ' . $classes . ' fold" data-class="header">
        ';

        $header_media .= $header_gradient;

        $header_media .= get_header_assets($header_video, $header_video_mobile, $video_ratio, $mobile_ratio, $placerholder, $mobileplaceholder);

        $header_media .= '
        </div>';

        return $header_media;

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
            return '<div class="header-overlay" style="--mt-header-overlay-color: rgba(var(' . $headerOverlayBG . '), 0.' . $headerOverlayOpacity . '); --mt-header-overlay-level: ' . $gradient_level . '%;"></div>';

        }
    }
endif;