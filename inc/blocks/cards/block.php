<?php
/**
 * Template file: inc/blocks/theme-cards/block.php
 *
 * Theme Cards Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$blockName = "Theme Cards";
$blockID = "theme-cards";
$classes = $blockID . " ";

$card_media = get_basic_media('card-img-top');

$make_card_horizontal = '';
$card_options_reverse_layout = '';
$card_options_connect_card = '';
$card_options_call_to_action = '';
$card_options_content_postID = '';
$card_options_card_content_link = '';
$card_options_cta_format = '';
$card_options_button_background = '';
$card_options_cta_link = '';
$card_footer = '';
$cta_classes = '';
$rowClasses = '';
$placeholder_title = "Card Title";
$placeholder_text = "Lorem ipsum dolor sit amet. Ad distinctio exercitationem quo voluptatibus quisquam ea natus sunt aut suscipit voluptatibus a aliquid quia.";

$card_options_content_postID = get_field('card_content_postID');
if (have_rows('card_options')) {
    while (have_rows('card_options')) {
        the_row();
        $make_card_horizontal = (get_sub_field('card_layout') == 1) ? 'true' : 'false';
        $card_options_reverse_layout = (get_sub_field('reverse_layout') == 1) ? 'true' : 'false';
        $card_options_connect_card = (get_sub_field('connect_card') == 1) ? 'true' : 'false';
        $card_options_call_to_action = (get_sub_field('call_to_action') == 1) ? 'true' : 'false';

        if ($card_options_content_postID) {
            $card_options_card_content_link = ($card_options_content_postID) ? '<a href="' . esc_url(get_permalink($card_options_content_postID)) . '">' . get_the_title($card_options_content_postID) . '</a>' : '';

            $thumbnail_url = get_the_post_thumbnail_url($card_options_content_postID, 'full');

            // Check if a thumbnail is available
            if ($thumbnail_url) {
                $card_media = '<img class="card-img-top" src="' . esc_url($thumbnail_url) . '" alt="' . esc_attr(get_post_meta($card_options_content_postID, '_wp_attachment_image_alt', true)) . '" />';
            }
            $placeholder_title = get_the_title($card_options_content_postID);
            $placeholder_text = theme_main_excerpt('25', $card_options_content_postID);
            $template = array(
                array(
                    'core/heading',
                    array(
                        'level' => 3,
                        'content' => $placeholder_title,
                        'className' => 'card-title', // Add the class 'card-title' here
                    )
                ),
                array(
                    'core/paragraph',
                    array(
                        'content' => $placeholder_text,
                        'className' => 'card-text'
                    )
                )
            );

            if ($card_options_call_to_action === 'true') {
                $card_footer .= '<div class="card-footer">';

                $cta_text = get_sub_field('cta_text');
                if (empty($cta_text)) {
                    $cta_text = get_the_title($card_options_content_postID);
                }
                $card_options_cta_format = get_sub_field('cta_format');
                if ($card_options_cta_format === 'Button') {
                    $cta_classes = "btn";
                }
                $card_options_button_background = get_sub_field('button_background');
                $cta_classes .= " btn-" . $card_options_button_background;
                $card_footer .= ($card_options_content_postID) ? '<a href="' . esc_url(get_permalink($card_options_content_postID)) . '" class="' . $cta_classes . '">' . esc_html($cta_text) . '</a>' : '';
                $card_footer .= '</div>';
            }

        } else {
            $template = array(
                array(
                    'core/heading',
                    array(
                        'level' => 3,
                        'placeholder' => $placeholder_title,
                        'className' => 'card-title', // Add the class 'card-title' here
                    )
                ),
                array(
                    'core/paragraph',
                    array(
                        'placeholder' => $placeholder_text,
                        'className' => 'card-text'
                    )
                )
            );
            if ($card_options_call_to_action === 'true') {
                $card_footer .= '<div class="card-footer">';

                $card_options_cta_format = get_sub_field('cta_format');
                if ($card_options_cta_format === 'Button') {
                    $cta_classes = "btn";
                }
                $card_options_button_background = get_sub_field('button_background');
                $cta_classes .= " btn-" . $card_options_button_background;
                $cta_link = get_sub_field('cta_link');
                $card_footer .= ($cta_link) ? '<a href="' . esc_url($cta_link['url']) . '" class="' . $cta_classes . '" target="' . esc_attr($cta_link['target']) . '">' . esc_html($cta_link['title']) . '</a>' : '';
                $card_footer .= '</div>';
            }
        }

        if ($card_options_reverse_layout === 'true') {
            $classes .= ' column-reverse ';
            $rowClasses .= ' row-reverse ';
        }
    }
}

$card_media_container = '';
$card_markup = '';
$card_body = '<InnerBlocks class="card-body" template="' . esc_attr(wp_json_encode($template)) . '" />';

?>
<div <?php echo get_block_settings($block, $blockID, $classes); ?>>
    <div class="card mb3">
        <?php if ($make_card_horizontal === 'true') {
            $card_markup = '<div class="row g-0 ' . $rowClasses . '">';

            $card_markup .= '<div class="col-md-4">';
            $card_markup .= $card_media;
            $card_markup .= '</div>';

            $card_markup .= '<div class="col-md-8">';
            $card_markup .= $card_body;
            $card_markup .= $card_footer;
            $card_markup .= '</div>';

            $card_markup .= '</div>';
        } else {
            $card_markup = $card_media;
            $card_markup .= $card_body;
            $card_markup .= $card_footer;
        }

        echo $card_markup;
        ?>
    </div>
</div>