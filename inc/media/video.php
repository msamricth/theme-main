<?php
/**
 * Template file: inc/media/video.php
 * Video Functions for the Media framework within Theme Main
 *
 * @package Bootstrap Base
 * @since v1
 */

// Supplys video functions 

if (!function_exists('VideoFM')):
    /**
     * Basic required prestructure setup video url formatting 
     * Preformats URLs to be received properly by vimeo API
     *
     * @since v5.0
     * @modified v9
     */

    function VideoFM($url = null)
    {
        $video = '';
        $current_post = get_queried_object();
        $post_id = $current_post ? $current_post->ID : null;
        $reels = get_field('reels', $post_id);
        if (empty($url)) {
            if ($reels) {
                // Load value.
                // Use preg_match to find iframe src.
                preg_match('/src="(.+?)"/', $reels, $matches);
                $video = $matches[1];
            }
        } else {
            if (strpos($url, 'vimeo') !== false) {
                preg_match('/src="(.+?)"/', $url, $matches);
                if ($matches) {
                    $video = $matches[1];
                }
            }
        }
        return $video;
    }
endif;

if (!function_exists('VimeoVideo')):
    /**
     * vimeo video player
     *
     * @since v5.0
     * @modified v9
     */
    function VimeoVideo($video = null, $classes = null, $backgroundvideoOff = null)
    {
        $output = '';
        $vimeoTitle = '';
        $vimeoID = str_replace('https://player.vimeo.com/video/', '', $video);
        $vimeoID = substr($vimeoID, 0, strpos($vimeoID, "?"));
        $request = wp_remote_get('https://vimeo.com/api/oembed.json?url=https://vimeo.com/' . $vimeoID);
        $response = wp_remote_retrieve_body($request);
        $video_array = json_decode($response, true);
        $options = '';
        if ($video_array) {
            if (isset($video_array['title']) ? $video_array['title'] : null) {
                $vimeoTitle = $video_array['title'];
            } else {
                $vimeoTitle = 'RAVT-' . rand(5, 15);
            }

        }
        if (empty($classes)) {
            $classes = 'videofx';
        }
        if (empty($backgroundvideoOff)) {
            $options = '?&amp;background=1&amp;muted=1&amp;loop=1&maxheight=200vh&maxwidth=200vw&title=0&byline=0&portrait=0&autopause=0';
        } else {
            $options = '?title=0&byline=0&portrait=0&playsinline=0&muted=0&autoplay=0&autopause=0&controls=1&loop=0';
        }
        $classes .= ' vimeo lazy';

        if (!empty($video)) {
            $output .= '<iframe loading="lazy" data-videotitle="' . $vimeoTitle . '" title="' . $vimeoTitle . '" id="video' . $vimeoID . '" class="' . $classes . '" src="' . $video . $options . '" frameBorder="0" allow="autoplay; picture-in-picture; fullscreen"></iframe>';
        } else {
            $output .= '<div class="entry-content text-center"><h3>Video not found</h3></div>'; // change this to show placeholder image if one exists
        }
        return $output;
    }
endif;

if (!function_exists('selfHostVideo')):
    /**
     * selfhosting formating
     * Self hosted video player
     *
     * @since v5.0
     * @modified v9
     */
    function selfHostVideo($videoURL = null, $placerholder = null, $classes = null, $id = null)
    {
        $output = '';
        if (empty($classes)) {
            $classes = 'videofx';
        }
        $classes .= ' selfhosted lazy';

        $output .= '<video ';
        $output .= 'id="video' . rand(5, 15) . '" class="' . $classes . '" ';
        if ($placerholder) {
            $output .= 'poster="' . esc_url($placerholder['url']) . '"';
            $output .= 'data-videotitle="' . $placerholder['alt'] . '" title="' . $placerholder['alt'] . '" ';
        }
        $output .= '  autoplay muted playsinline loop background  allow="picture-in-picture">';
        if (is_admin()) {
            $output .= '<source src="' . $videoURL . '" type="video/mp4"></video>';
        } else {
            $output .= '<source data-src="' . $videoURL . '" type="video/mp4"></video>';
        }

        return $output;
    }
endif;


if (!function_exists('videoJS')):
    /**
     * selfhosting formating
     * Self hosted video player
     * using videoJS
     *
     * @since v5.0
     * @modified v9.8
     */
    function videoJS($videoURL, $placerholder = null, $classes = null, $id = null, $options = null)
    {
        $output = '';
        $sourceTag = '';
        if (empty($id)) {
            $id = 'video' . rand(5, 15);
        }
        $pos = strpos($options, 'preload');
        if (empty($options)) {
            $options = '';
        }
        $options .= 'fluid muted loop background';
        if ($placerholder) {
            $options .= ' poster="' . esc_url($placerholder['url']) . '"';
        }
        if ($pos !== false) {
            $options .= " data-setup='{}'";
        }
        if (empty($classes)) {
            $classes = 'videofx';
        }

        $classes .= ' selfhosted';
        if (str_contains($options, 'preload')) {
            //Load and play the video right away - This is likely a header video
            $sourceTag = 'src';
        } else {
            //Lazy load the video by adding class, disable preloading, move video asset from src to data-src - we will load it later via JS
            $classes .= ' lazy';
            $options .= ' preload="none"';

            $sourceTag = 'data-src';
        }
        $output .= '<video ';
        if ($placerholder) {
            if ($placerholder['alt']) {
                $output .= 'data-videotitle="' . $placerholder['alt'] . '" title="' . $placerholder['alt'] . '" ';
            }
        }
        $output .= 'id="' . $id . '" class="' . $classes . '" ';
        $output .= $options;

        $output .= '>';
        $output .= '<source ' . $sourceTag . '="' . $videoURL . '" type="video/mp4">';
        $output .= '<p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="https://videojs.com/html5-video-support" target="_blank">supports HTML5 video</a></p>';
        $output .= '</video>';

        return $output;
    }
endif;

if (!function_exists('Video_embed')):
    /**
     * Video embed with a playbutton
     *
     * @since v5.0
     * @modified v9
     */

    function Video_embed()
    {
        $playBTN = get_field('play_button', 'option');
        $embed = '';
        $displayVideo = '';
        $previewVideo = '';
        $ratio = 'ratio-16x9';

        $video = VideoFM();
        $displayVideo = VimeoVideo($video, 'iframe-video d-none', 'vimeoFrame', 'true');
        $previewVideo = VimeoVideo($video);
        $embed .= '<div class="ratio ' . $ratio . ' video-embed fadeNoScroll">';
        $embed .= '<div class="preview-video reels--preview">' . $previewVideo . '</div><button id="play-button"><img src="' . $playBTN . '" /><span>Watch Video</span></button>';
        // $embed .= '<div class="video-block" data-video="'. $video.'?autoplay=1&loop=1"></div>';
        $embed .= $displayVideo;
        $embed .= '</div>';
        return $embed;

    }
endif;

if (!function_exists('reels')):
    /**
     * Reels Video Module (uses either vimeo or self hosting)
     *
     * @since v5.0
     * @modified v9
     */

    function reels($videoURL = null, $placerholder = null, $ratio = null, $PlaceholdervideoURL = null, $darkMode = null)
    {

        if (empty($darkMode)) {
            $playBTN = get_field('play_button', 'option');
        } else {
            $playBTN = get_field('play_button_dark', 'option');
        }
        $video = VideoFM($videoURL);
        $Placeholdervideo = '';
        $embed = '';
        $displayVideo = '';
        $previewVideo = '';
        if (empty($ratio)) {
            $ratio = 'ratio-16x9';
        } else {
            $ratio .= ' ratio-' . $ratio;
        }
        $video = VideoFM($videoURL);
        if (strpos($videoURL, 'vimeo') !== false) {
            $displayVideo = VimeoVideo($video, 'iframe-video d-none', 'vimeoFrame', 'true');
        } else {
            $displayVideo = videoJS($videoURL, $placerholder, 'reels--reel iframe-video d-none');
        }
        if (empty($PlaceholdervideoURL)) {
            if ($placerholder) {
                $previewVideo = '<img src="' . esc_url($placerholder['url']) . '" />';
            }
        } else {
            if (strpos($PlaceholdervideoURL, 'vimeo') !== false) {
                $Placeholdervideo = VideoFM($PlaceholdervideoURL);
                $previewVideo = VimeoVideo($Placeholdervideo);
            } else {
                $previewVideo = videoJS($PlaceholdervideoURL);
            }
        }
        $embed .= '<div class="ratio ' . $ratio . ' video-embed reels fadeNoScroll">';
        $embed .= '<div class="preview-video reels--preview ratio ' . $ratio . ' ">' . $previewVideo . '</div><button class="reels--button" id="play-button"><img src="' . $playBTN . '" /><span>Watch Video</span></button>';
        $embed .= $displayVideo;
        $embed .= '</div>';
        return $embed;
    }
endif;

if (!function_exists('vimeoPreloadImage')):
    function vimeoPreloadImage($imageObject)
    {
        $desktopImage = '<img class="vimeo-placeholder"';
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
        return $desktopImage;
    }
endif;
if (!function_exists('background_video')):
    /**
     * SIMPLIFIED Video Module that works as a background (uses either vimeo or self hosting)
     *
     * @since v5.0
     * @modified v9
     */

    function background_video($videoURL = null, $placerholder = null, $eagerLoad = null, $options = null)
    {
        $embed = '';
        if (strpos($videoURL, 'vimeo') !== false) {
            $video = VideoFM($videoURL);
            if ($placerholder) {
                $embed .= vimeoPreloadImage($placerholder);
            }
            $embed .= VimeoVideo($video);
        } else {
            $embed .= selfHostVideo($videoURL, $placerholder, '', '', $options);
        }
        //endif; 
        return $embed;
    }

endif;

if (!function_exists('backgroundVideo')):
    /**
     * ADVANCE Video Module that works as a background (uses either vimeo or self hosting)
     *
     * @since v5.0
     * @modified v9
     */
    function backgroundVideo($videoURL = null, $placerholder = null, $ratio = null, $mute = null, $darkMode = null)
    {
        $embed = '';
        $classes = '';
        $video = VideoFM($videoURL);
        if (empty($ratio)) {
            $ratio = 'ratio-16x9';
        } else {
            $ratio .= ' ratio-' . $ratio;
        }
        if ($mute == 1) {
            $ratio .= ' mute-controls';
        }
        $embed .= '<div class="ratio supply-video ' . $ratio . '">';

        if ($mute == 1) {
            $embed .= muteBTN($darkMode);
        }
        if (strpos($videoURL, 'vimeo') !== false) {
            if ($placerholder) {
                $embed .= vimeoPreloadImage($placerholder);
            }
            $embed .= VimeoVideo($video);
        } else {
            $embed .= selfHostVideo($videoURL, $placerholder);
        }
        $embed .= '</div>';

        //endif; 
        return $embed;
    }

endif;