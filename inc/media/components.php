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



if (!function_exists('theme_main_get_carousel')) {

    function theme_main_get_carousel($blockID, $builtInSlides = null)
    {

        $blockContent = '';
        $options_position = '';
        $options_interval = '';
        $extra_options = '';
        $options_gap = '';
        $slides = '';
        $videoRatio = '';
        $slideClasses = '';
        $finalContent = '';
        $type_color = '';
        $classes = 'carousel ';
        if (have_rows('options')) {
            while (have_rows('options')) {
                the_row();
                $blockContent = '<div id="' . $blockID . '" class="splide"';

                $options_type = get_sub_field('type');
                $options_interval = get_sub_field('interval');
                if (empty($options_type)) {
                    $options_type = 'slide';
                }

                $extra_options = '"type":"' . $options_type . '", "pagination":false';

                if ($options_type === 'loop') {
                    $extra_options .= ', "rewind":true';
                }

                if (get_sub_field('autoplay') == 1):
                    $extra_options .= ', "autoplay":true, "interval":"' . $options_interval . '"';
                endif;

                if (get_sub_field('make_full_screen') == 1):
                    $slideClasses .= "full-width";
                    $video_ratio = 'fullw';
                    $extra_options .= ', "width":"100vw", "height":"100vh"';
                    $classes .= 'fullscreen-element';
                endif;

                $positoning = get_sub_field('caption_positioning');
                if($positoning == 'Outside') {
                    $extra_options .= ', "height":"--theme-main-medium-carousel-min-height"';
                }

                $blockContent .= 'data-splide=\'{' . $extra_options . '}\' ';

                if (empty($video_ratio)) {
                    $video_ratio = get_sub_field('video_ratio');
                }
                $options_scroll__drag = get_sub_field('scroll__drag');
                $options_arrows = get_sub_field('arrows');

                $options_same_height = get_sub_field('same_height');
                $options_custom_height = get_sub_field('custom_height');
                $options_per_move = get_sub_field('per_move');
                $options_gap = get_sub_field('gap');
                if ($options_position) {
                    $classes .= 'd-flex justify-content-bottom ';
                }
                if (empty($options_gap)) {
                    $options_gap = '40';
                }
                $multiple_slides = 'false';
                if (get_sub_field('multiple_slides') == 1):
                    $classes .= ' multiple-slides ';
                    $multiple_slides = 'true';
                endif;
                if (empty($options_same_height)) {
                    $options_same_height = '';
                    if (empty($options_position)) {
                        $classes .= ' middle';
                    }
                } else {
                    $options_same_height = 'data-same-height="' . $options_same_height . '"';
                }

                if (empty($options_per_move)) {
                    $options_per_move = 1;
                }
                $placement = get_sub_field('caption_placement');
                if (get_sub_field('multiple_slides') == 1):
                    $blockContent .= theme_main_get_slides_options($options_same_height, $options_custom_height, $options_gap, $options_per_move, $multiple_slides) . ' ';
                else:
                    //  $classes .= "full-width";
                endif;
                $blockContent .= ' data-type="' . $options_type . '"';
                $blockContent .= ' data-drag="' . $options_scroll__drag . '"';

                $blockContent .= ' data-arrows="' . $options_arrows . '">';
            }
        }

        $slides .= theme_main_get_carousel_slides($positoning, $placement, $slideClasses);


        $blockContent .= '<div class="splide__track">';
        $blockContent .= '<ul class="splide__list">';
        $blockContent .= $slides;
        $blockContent .= '</ul>';
        $blockContent .= '</div>';
        $blockContent .= '</div>';


        $finalContent .= '<div class="container__media ' . $classes . '">';

        $finalContent .= $blockContent;
        $finalContent .= '</div>';

        return $finalContent;
    }
}

if (!function_exists('theme_main_get_legacy_carousel')) {

    function theme_main_get_legacy_carousel($blockID, $builtInSlides = null)
    {

        $blockContent = '';
        $options_position = '';
        $options_interval = '';
        $extra_options = '';
        $options_gap = '';
        $slides = '';
        $videoRatio = '';
        $slideClasses = '';
        $finalContent = '';

        $classes = 'carousel ';
        if (have_rows('options')) {
            while (have_rows('options')) {
                the_row();
                $blockContent = '<div id="' . $blockID . '" class="splide"';


                $options_type = get_sub_field('type');
                $options_interval = get_sub_field('interval');

                if (empty($options_type)) {
                    $options_type = 'slide';
                }

                $extra_options .= '"type": "' . $options_type . '"';

                if ($options_type === 'loop') {
                    $extra_options .= ', "rewind": "true"';

                }
                if (get_sub_field('autoplay') == 1):
                    $extra_options .= ', "autoplay": "true", "interval": "' . $options_interval . '"';
                endif;

                if (get_sub_field('make_full_screen') == 1):
                    $slideClasses .= "full-width";
                    $video_ratio = 'fullw';
                    $extra_options .= ', "width": "100vw", "height": "100vh"';
                endif;

                $blockContent .= 'data-splide=\'{' . $extra_options . '}\' ';
                if (empty($video_ratio)) {
                    $video_ratio = get_sub_field('video_ratio');
                }
                $options_scroll__drag = get_sub_field('scroll__drag');
                $options_arrows = get_sub_field('arrows');

                $options_same_height = get_sub_field('same_height');
                $options_custom_height = get_sub_field('custom_height');
                $options_per_move = get_sub_field('per_move');
                $options_gap = get_sub_field('gap');
                if ($options_position) {
                    $classes .= 'd-flex justify-content-bottom ';
                }
                if (empty($options_gap)) {
                    $options_gap = '40';
                }
                $multiple_slides = 'false';
                if (get_sub_field('multiple_slides') == 1):
                    $classes .= ' multiple-slides ';
                    $multiple_slides = 'true';
                endif;
                if (empty($options_same_height)) {
                    $options_same_height = '';
                    if (empty($options_position)) {
                        $classes .= ' middle';
                    }
                } else {
                    $options_same_height = 'data-same-height="' . $options_same_height . '"';
                }

                if (empty($options_per_move)) {
                    $options_per_move = 1;
                }


                if (get_sub_field('multiple_slides') == 1):
                    $blockContent .= theme_main_get_slides_options($options_same_height, $options_custom_height, $options_gap, $options_per_move, $multiple_slides) . ' ';
                else:
                    //  $classes .= "full-width";
                endif;
                $blockContent .= ' data-type="' . $options_type . '"';
                $blockContent .= ' data-drag="' . $options_scroll__drag . '"';

                $blockContent .= ' data-arrows="' . $options_arrows . '"';

                $blockContent .= $extra_options . '>';
            }
        }

        if (have_rows('slides')):
            while (have_rows('slides')):
                the_row();
                $slides .= '<li class="splide__slide ' . $slideClasses . '">';
                if (get_row_layout() == 'image') {
                    $image = get_sub_field('image');
                    if ($image):
                        $slides .= '<img src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt']) . '"';
                        //	$slides .=' width="'.esc_attr( $image['width'] ).'" height="'.esc_attr( $image['height'] ).'"';
                        $slides .= ' />';

                        $slides .= get_header_gradient();
                    endif;

                } elseif (get_row_layout() == 'vimeo') {

                    $videoRatio = get_sub_field('video_ratio');
                    $video = get_sub_field('video');

                    if ($videoRatio) {
                        enqueue_header_markup(customRatio($videoRatio));
                    }
                    $slides .= video_containers($video, '', $videoRatio, $videoRatio);
                } elseif (get_row_layout() == 'video') {
                    $videoRatio = get_sub_field('video_ratio');
                    if ($videoRatio) {
                        enqueue_header_markup(customRatio($videoRatio));
                    }
                    $video = get_sub_field('video');
                    $video_placeholder = get_sub_field('video_placeholder');
                    $slides .= video_containers($video, '', $videoRatio, $videoRatio, $video_placeholder);
                }

                $slides .= '</li>';
            endwhile;
        else:
            // No layouts found 
        endif;


        $blockContent .= '<div class="splide__track">';
        $blockContent .= '<ul class="splide__list">';
        $blockContent .= $slides;
        $blockContent .= '</ul>';
        $blockContent .= '</div>';
        $blockContent .= '</div>';


        $finalContent .= '<div class="header-container__media ' . $classes . ' fold" data-class="header">';

        $finalContent .= $blockContent;
        $finalContent .= '</div>';

        return $finalContent;
    }
}
if (!function_exists('theme_main_get_carousel_slides')) {

    function theme_main_get_carousel_slides($positoning, $placement, $slideClasses)
    {


        $classes = " splide__slide ";

        $carousel_slide_content = ''; 
        $inner_block_content = '';
        $inner_block_content_order = '';
        $carousel_outside_slide_content = '';

        $blockClasses = 'placement-' . $placement;
        $slideClasses .= ' placement-' . $placement;
        $slideClasses .= ' position-' . $positoning;
        // add acf or other functions here

        $classes .= ""; // Add extra classes here.
        $slides = '';
        if (have_rows('slides')):
            while (have_rows('slides')):
                the_row();
                
                $type_color = get_header_gradient_type_color();
                $inner_block_instance = '';
                $inner_block_content = '';
                $slideMedia = '';
                $instance_card = '';
                $carousel_slide_content = '';
                $carousel_inside_slide_content = '';
                $carousel_outside_slide_content = '';
                $related_content = get_sub_field('related_content');
                if ($related_content):
                    $related_content_url = get_permalink($related_content);
                    $related_content_title = get_the_title($related_content);
                    $related_content_excerpt = get_the_excerpt($related_content);
                    $featured_img_url = get_the_post_thumbnail_url($related_content, 'full');
                    $inner_blocks_template = theme_main_get_slides_inner_block_template($related_content_title, $related_content_excerpt, $related_content_url, $placement, $positoning);
                    if ($featured_img_url) {
                        // $alt_text = get_post_meta($featured_img_url->ID, '_wp_attachment_image_alt', true);

                        if (!empty($featured_img_url)) {
                            if (!empty($alt_text)) {
                                $alt_text = $alt_text;
                            } else {
                                $alt_text = __('no alt text set', 'themeMain');
                            }
                            $slides .= '<li class="splide__slide ' . $slideClasses . '">';


                            $slideMedia .= '<img src="' . esc_url($featured_img_url) . '" alt="' . esc_attr($alt_text) . '"';
                            //	$slides .=' width="'.esc_attr( $image['width'] ).'" height="'.esc_attr( $image['height'] ).'"';
                            $slideMedia .= ' />';

                            $inner_block_content .= '<div class="carousel-block-editor-content content-slides ' . $blockClasses . ' py-5 my-3xl-5"';
                            
                            if($type_color){
                                $inner_block_content .= ' ' . $type_color; 
                            }
                            $inner_block_content .= '>';


                            $inner_block_content .= '<div class="container">';
                            $instance_card = '<div class="card bg-transparent"><div class="row">';
                            $instance_card_footer = '</div></div>';

                            $inner_block_instance = '<div class="carousel-block-editor-content carousel-captions">' . $inner_blocks_template . '</div>';

                            switch ($placement) {
                                case "left":
                                    $carousel_inside_slide_content .= $inner_block_content;
                                    $carousel_inside_slide_content .= '<div class="row"><div class="col-dlg-4 order-2 order-dlg-1  carousel-captions--placement-left">';
                                    $carousel_inside_slide_content .= $inner_block_instance;
                                    $carousel_inside_slide_content .= '</div>';
                                    $carousel_inside_slide_content .= '</div>';



                                    $carousel_outside_slide_content .= $inner_block_content;
                                    $carousel_outside_slide_content .= $instance_card;
                                    $carousel_outside_slide_content .= '<div class="col-dlg-4 order-2 order-dlg-1 carousel-captions--placement-left card bg-transparent inner-card">' . $inner_blocks_template . '</div>';
                                    $carousel_outside_slide_content .= '<div class="col-dlg-8 order-1 order-dlg-2">' . $slideMedia . '</div>';
                                    $carousel_outside_slide_content .= $instance_card_footer;

                                    break;
                                case "right":
                                    $carousel_inside_slide_content .= $inner_block_content;
                                    $carousel_inside_slide_content .= '<div class="row"><div class="col-dlg-4 order-2 order-dlg-1 carousel-captions--placement-right">';
                                    $carousel_inside_slide_content .= $inner_block_instance;
                                    $carousel_inside_slide_content .= '</div>';
                                    $carousel_inside_slide_content .= '</div>';

                                    $carousel_outside_slide_content .= $inner_block_content;
                                    $carousel_outside_slide_content .= $instance_card;
                                    $carousel_outside_slide_content .= '<div class="col-dlg-4 order-1 order-dlg-2   carousel-captions--placement-right card bg-transparent inner-card">' . $inner_blocks_template . '</div>';
                                    $carousel_outside_slide_content .= '<div class="col-dlg-8 order-2 order-dlg-1">' . $slideMedia . '</div>';
                                    $carousel_outside_slide_content .= $instance_card_footer;

                                    break;
                                case "top":
                                    $carousel_inside_slide_content .= $inner_block_instance;

                                    $carousel_outside_slide_content .= $inner_block_content;
                                    $carousel_outside_slide_content .= $slideMedia;
                                    break;
                                case "bottom":
                                    $carousel_inside_slide_content .= $inner_block_instance;

                                    $carousel_outside_slide_content .= $slideMedia;
                                    $carousel_outside_slide_content .= $inner_block_content;
                                    break;
                                default:
                                    $carousel_inside_slide_content .= $inner_block_instance;

                                    $carousel_outside_slide_content .= $slideMedia;
                                    $carousel_outside_slide_content .= $inner_block_content;
                            }
                            $carousel_outside_slide_content .= '</div></div>';
                            $carousel_inside_slide_content .= '</div></div>';
                            switch ($positoning) {
                                case "hidden":
                                    $carousel_slide_content = $slideMedia;
                                    break;
                                case "Inside":
                                    $carousel_slide_content = $carousel_inside_slide_content;
                                    $carousel_slide_content .= $slideMedia;
                                    break;
                                case "Outside":
                                    $carousel_slide_content = $carousel_outside_slide_content;
                                    break;

                            }

                            $slides .= $carousel_slide_content;
                            $slides .= get_header_gradient();
                            $slides .= '</li>';
                        }
                        // <a href="echo get_permalink( $related_content ); ">echo get_the_title( $related_content ); </a>


                    }
                endif;


            endwhile;
        else:
            // No layouts found 
        endif;
        return $slides;
    }
}