<?php
/**
 * Template file: inc/blocks/content-slider-gutenberg-slide/block.php
 *
 * Content Slider - Gutenberg slide Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$blockName = "Content Slider - Gutenberg slide";
$blockID = "content-slider-gutenberg-slide";
$classes = $blockID . " ";

$positoning = get_field('caption_positioning');
$placement = get_field('caption_placement');

$classes .= " splide__slide ";

$blockClasses = 'placement-' . $placement;
$classes .= ' placement-' . $placement;
$classes .= ' position-' . $positoning;


$carousel_slide_content = '';
$inner_block_content = '';
$inner_block_content_order = '';
$carousel_outside_slide_content = '';
$carousel_inside_slide_content = '';
$type_color = '';
$slides = '';
$inner_block_instance = '';
$slideMedia = '';
$instance_card = '';
$related_content = get_field('related_content');
if (have_rows('gradient')):
    while (have_rows('gradient')):
        the_row();
        $type_color = get_header_gradient_type_color();
    endwhile;
endif;

?>
<div <?php echo get_block_settings($block, $blockID, $classes); ?>>
    <?php

    // add template stuff here
    // $inner_blocks_template = '<InnerBlocks />';
    
    if ($related_content):

        //for a future update
    
        $related_content_url = get_permalink($related_content);
        $related_content_title = get_the_title($related_content);
        $related_content_excerpt = get_the_excerpt($related_content);
        if(! empty($related_content_excerpt)){
            $related_content_excerpt .='...';
        }
        $related_content_date_posted = get_the_date('D, M j', $related_content) . '<span class="read-time"></span>';

        $template = array(
            array(
                'core/heading',
                array(
                    'level' => 4,
                    'content' => $related_content_title
                )
            ),
            array(
                'core/paragraph',
                array(
                    'content' => $related_content_excerpt
                )
            ),
            array(
                'core/button',
                array(
                    'backgroundColor' => 'primary',
                    'className' => 'btn-icon mt-auto mt-xl-0',
                    'fontSize' => 'regular',
                    'blockAnimation' => 'fade-in',
                    'content' => $related_content_title . ' <i class="fa-solid ms-3 fa-chevron-right"></i>',
                    'text' => $related_content_title . ' <i class="fa-solid ms-3 fa-chevron-right"></i>',
                    'title' => $related_content_title . ' <i class="fa-solid ms-3 fa-chevron-right"></i>',
                    'url' => $related_content_url,
                    'layout' => array(
                        'type' => 'flex',
                        'justifyContent' => 'left'
                    )

                )
            )
        );

        $inner_blocks_template = '<InnerBlocks template="' . esc_attr(wp_json_encode($template)) . '" />';


        $related_content_post_type = get_post_type($related_content);

        //end for a future update
    

        $featured_img_url = get_the_post_thumbnail_url($related_content, 'full');
        if ($featured_img_url) {
            // $alt_text = get_post_meta($featured_img_url->ID, '_wp_attachment_image_alt', true);
    
            if (!empty($featured_img_url)) {
                if (!empty($alt_text)) {
                    $alt_text = $alt_text;
                } else {
                    $alt_text = __('no alt text set', 'themeMain');
                }

                $blockClasses .= ' type-' . $related_content_post_type;

                $slideMedia .= '<img class="" src="' . esc_url($featured_img_url) . '" alt="' . esc_attr($alt_text) . '"';
                //	$slides .=' width="'.esc_attr( $image['width'] ).'" height="'.esc_attr( $image['height'] ).'"';
                $slideMedia .= ' />';
                if ($positoning != 'Outside') {
                    $blockClasses .= ' py-5 my-3xl-5';
                } else {
                    //$blockClasses .= ' py-5 py-dlg-0';
                }
                $inner_block_content .= '<div class="carousel-block-editor-content content-slides ' . $blockClasses . '"';

                if ($type_color) {
                    $inner_block_content .= ' ' . $type_color;
                }
                $inner_block_content .= '>';


                //$inner_block_content .= '<div class="container">';
                $instance_card = '<div class="card bg-transparent"><div class="row">';
                //$instance_card_footer = '</div></div>';
                $instance_card_footer = '</div></div>';

                $inner_block_instance = '<div class="carousel-block-editor-content carousel-captions">' . $inner_blocks_template . '</div>';

                switch ($placement) {
                    case "left":
                        $carousel_inside_slide_content .= $inner_block_content;
                        $carousel_inside_slide_content .= '<div class="row"><div class="col-dlg-4 order-2 order-dlg-1  carousel-captions--placement-left">';
                        $carousel_inside_slide_content .= $inner_block_instance;
                        $carousel_inside_slide_content .= '</div>';
                        // $carousel_inside_slide_content .= '</div>';
    


                        $carousel_outside_slide_content .= $inner_block_content;
                        $carousel_outside_slide_content .= $instance_card;
                        $carousel_outside_slide_content .= '<div class="col-dlg-4 order-2 order-dlg-1 carousel-captions--placement-left card bg-transparent inner-card py-dlg-5 my-3xl-5">' . $inner_blocks_template . '</div>';
                        $carousel_outside_slide_content .= '<div class="col-dlg-8 order-1 order-dlg-2 py-dlg-5 my-3xl-5">' . $slideMedia . '</div>';
                        $carousel_outside_slide_content .= $instance_card_footer;

                        break;
                    case "right":
                        $carousel_inside_slide_content .= $inner_block_content;
                        $carousel_inside_slide_content .= '<div class="row"><div class="col-dlg-4 order-2 order-dlg-1 carousel-captions--placement-right">';
                        $carousel_inside_slide_content .= $inner_block_instance;
                        $carousel_inside_slide_content .= '</div>';
                        //$carousel_inside_slide_content .= '</div>';
    
                        $carousel_outside_slide_content .= $inner_block_content;
                        $carousel_outside_slide_content .= $instance_card;
                        $carousel_outside_slide_content .= '<div class="col-dlg-4 order-1 order-dlg-2 py-dlg-5 my-3xl-5 carousel-captions--placement-right card bg-transparent inner-card">' . $inner_blocks_template . '</div>';
                        $carousel_outside_slide_content .= '<div class="col-dlg-8 order-2 order-dlg-1 py-dlg-5 my-3xl-5">' . $slideMedia . '</div>';
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
                        $carousel_outside_slide_content .= $inner_block_instance;
                        break;
                    default:
                        $carousel_inside_slide_content .= $inner_block_instance;

                        $carousel_outside_slide_content .= $slideMedia;
                        $carousel_outside_slide_content .= $inner_block_content;
                }
                $carousel_outside_slide_content .= '</div>';
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
            }


        }
    endif;

    echo $slides;
    ?>
</div>