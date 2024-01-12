<?php
/**
 * Template file: inc/media/settings.php
 * Settings for the Media framework within the Supply Theme
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
        $video_lg = '';
        $video_lg_ratio = '';
        $video_lg_class = '';
        if (have_rows('header_media')):
            while (have_rows('header_media')):
                the_row();
                if (get_sub_field('make_full_screen') == 1):
                    $classes .= "fullscreen_media";
                    $video_lg_class = 'fullscreen_media';
                    $video_ratio = 'fullw';
                    $mobile_ratio = 'fullw';
                    $video_lg_ratio = 'fullw';
                endif;
                if (have_rows('video_desktop')):
                    $self_host_video = '';
                    while (have_rows('video_desktop')):
                        the_row();
                        if (have_rows('options')):
                            while (have_rows('options')):
                                the_row();
                                if (get_sub_field('self_host_video') == 1):
                                    $self_host_video = 'true';
                                endif;

                                if (empty($video_ratio)) {
                                    $video_ratio = get_sub_field('video_ratio');
                                }
                            endwhile;
                        endif;
                        if ($self_host_video):
                            $header_video = get_sub_field('video_uploaded');
                            $self_host_video = '';
                        else:
                            $header_video = get_sub_field('video');
                        endif;
                        $placerholder = get_sub_field('video_placeholder');
                    endwhile;
                endif;
                if (have_rows('video_mobile')):
                    $self_host_video = '';
                    while (have_rows('video_mobile')):
                        the_row();
                        if (have_rows('options')):
                            while (have_rows('options')):
                                the_row();
                                if (get_sub_field('self_host_video') == 1):
                                    $self_host_video = 'true';
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
                        $mobileplaceholder = get_sub_field('video_placeholder');

                    endwhile;
                endif;
                if (have_rows('video_lg')):
                    $self_host_video = '';
                    while (have_rows('video_lg')):
                        $video_lg_placeholder = '';
                        the_row();
                        if (have_rows('options')):
                            while (have_rows('options')):
                                the_row();
                                if (get_sub_field('self_host_video') == 1):
                                    $self_host_video = 'true';
                                endif;

                                if (empty($video_lg_ratio)) {
                                    $video_lg_ratio = get_sub_field('video_ratio');
                                }

                            endwhile;
                        endif;


                        if ($self_host_video):
                            $video_lg = get_sub_field('video_mobile_uploaded');
                        else:
                            $video_lg = get_sub_field('video_mobile');
                        endif;
                        if ($video_lg) {

                            $classes .= " d-3xl-none";
                            $header_media .= customRatio($video_lg_ratio);
                            $header_media .= '<div class="header-container__media ' . $video_lg_class . ' d-none d-3xl-block fold" data-class="header">';

                            $video_lg_placeholder = get_sub_field('video_placeholder');
                            $header_media .= get_header_assets($video_lg, '', $video_lg_ratio, '', $video_lg_placeholder);
                            $header_media .= '</div>';
                        }

                    endwhile;
                endif;
            endwhile;
        endif;

        $header_media .= '<div class="header-container__media ' . $classes . ' fold" data-class="header">';
        if (get_field('turn_on_overlay')) {
            $headerOverlayBG = "background-color: " . get_field('overlay_color');
            $headerOverlayOpacity = get_field('opacity_level');
            if (empty($headerOverlayOpacity)) {
                $headerOverlayOpacity = '0';
            } else {
                $headerOverlayOpacity = '.' . $headerOverlayOpacity;
            }
            $header_media .= '<div class="header-overlay" style="opacity: ' . $headerOverlayOpacity . '; ' . $headerOverlayBG . '"></div>';
        }

        $header_media .= get_header_assets($header_video, $header_video_mobile, $video_ratio, $mobile_ratio, $placerholder, $mobileplaceholder);
        $header_type = get_field('header_type');


        if ($header_type == 'casestudy') {
            $client_logo = get_field('client_logo');
            $title_of_work_performed = get_field('title_of_work_performed');
            if (empty($title_of_work_performed)):
                $title_of_work_performed = get_the_title();
            endif;
            $header_media .= '<header class="page-header fold" data-class="header">';

            $header_media .= '<div class="container">';
            if ($client_logo):
                $header_media .= '<img class="img-responsive client-logo" src="' . esc_url($client_logo['url']) . '" alt="' . esc_attr($client_logo['alt']) . '" />';
                $header_media .= '<h3 class="card-title cp1">' . $title_of_work_performed . '</h3>';
            endif;
            $header_media .= '</div></header>';
        }
        $header_media .= '</div>';

        return $header_media;

    }
endif;