<?php
/**
 * Template file: inc/blocks/carousel-slide-block/block.php
 *
 * Carousel Slide Block Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$blockName = "Carousel Slide Block";
$blockID = "carousel-slide-block";
$classes = $blockID . " splide__slide ";

$caption_positioning = get_field("caption_positioning");
$caption_placement = get_field("caption_placement");
$carousel_slide_content = '';
$inner_block_content = '';
$inner_block_content_order = '';
$carousel_outside_slide_content = '';

$blockClasses = 'placement-'.$caption_placement;
// add acf or other functions here

$classes .= ""; // Add extra classes here.
?>
<li <?php echo get_block_settings($block, $blockID, $classes); ?>>
    <?php
    if (have_rows('slides')) {
        while (have_rows('slides')) {
            the_row();
            if (get_row_layout() == 'content_on_this_site') {
                $related_content = get_sub_field('related_content');
                if ($related_content):
                    $related_content_url = get_permalink($related_content);
                    $related_content_title = get_the_title($related_content);
                    $related_content_excerpt = get_the_excerpt($related_content);
                    $featured_img_url = get_the_post_thumbnail_url($related_content, 'full');
                    $inner_blocks_template = theme_main_get_slides_inner_block_template($related_content_title, $related_content_excerpt, $related_content_url, $related_content_position);
                    if ($featured_img_url) {
                        $alt_text = get_post_meta($featured_img_url->ID, '_wp_attachment_image_alt', true);

                        if (!empty($featured_img_url)) {
                            if (!empty($alt_text)) {
                                $alt_text = $alt_text;
                            } else {
                                $alt_text = __('no alt text set', 'themeMain');
                            }
                        }

                        $slides .= '<img src="' . esc_url($featured_img_url) . '" alt="' . esc_attr($alt_text) . '"';
                        //	$slides .=' width="'.esc_attr( $image['width'] ).'" height="'.esc_attr( $image['height'] ).'"';
                        $slides .= ' />';
                    }
                    // <a href="echo get_permalink( $related_content ); ">echo get_the_title( $related_content ); </a>
                endif;
            } elseif (get_row_layout() == 'image') {
                $image = get_sub_field('image');
                if ($image):
                    $slides .= '<img src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt']) . '"';
                    //	$slides .=' width="'.esc_attr( $image['width'] ).'" height="'.esc_attr( $image['height'] ).'"';
                    $slides .= ' />';

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
        }
    }
    $inner_block_content .= '<div class="carousel-block-editor-content '. $blockClasses.' py-5 my-3xl-5 fold" data-class="header" ' . get_header_color() . '>';


    $inner_block_content .= '<div class="container">';
    $inner_block_instance = '<InnerBlocks class="header-block-editor-content" template="' . esc_attr(wp_json_encode($inner_blocks_template)) . '"/>';
    $inner_block_content .= '</div></div>';

    switch ($caption_placement) {
        case "left":
            $inner_block_content .= '<div class="row"><div class="col-dlg-4 order-2 order-dlg-1">';
            $inner_block_content .= $inner_block_instance;
            $inner_block_content .= '</div>';
            $carousel_outside_slide_content .= $inner_block_content;
            $carousel_outside_slide_content .= '<div class="col-dlg-8 order-1 order-dlg-2">' . $slides . '</div></div>';
            $inner_block_content .= '</div>';
            break;
        case "right":
            $inner_block_content .= '<div class="row"><div class="col-dlg-4 order-2 order-dlg-1">';
            $inner_block_content .= $inner_block_instance;
            $inner_block_content .= '</div>';
            $carousel_outside_slide_content .= $inner_block_content;
            $carousel_outside_slide_content .= '<div class="col-dlg-8">' . $slides . '</div></div>';
            $inner_block_content .= '</div>';
            break;
        case "top":
            $inner_block_content .= $inner_block_instance;
            $carousel_outside_slide_content .= $inner_block_content;
            $carousel_outside_slide_content .= $slides;
            break;
        case "bottom":
            $inner_block_content .= $inner_block_instance;
            $carousel_outside_slide_content .= $slides;
            $carousel_outside_slide_content .= $inner_block_content;
            break;
        default:
            $inner_block_content .= $inner_block_instance;
            $carousel_outside_slide_content .= $slides;
            $carousel_outside_slide_content .= $inner_block_content;
    }
    $carousel_outside_slide_content .= '</div></div>';
    $inner_block_content .= '</div></div>';
    $carousel_inside_slide_content = $inner_block_content;
    switch ($caption_positioning) {
        case "hidden":
            $carousel_slide_content = $slides;
            break;
        case "Inside":
            $carousel_slide_content = $carousel_inside_slide_content;
            $carousel_slide_content .= $slides;
            break;
        case "Outside":
            $carousel_slide_content = $carousel_outside_slide_content;
            break;
        default:
            $carousel_slide_content = $slides;
    }

    echo $carousel_slide_content;
    ?>
</li>