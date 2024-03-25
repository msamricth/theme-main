<?php
/**
 * Template file: inc/blocks/lottie-motion/block.php
 *
 * Lottie / Motion Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$blockName = "Lottie / Motion";
$blockID = "lottie-motion";
$classes = $blockID . " ";
$blockContent = '';
$main_options_checked_values = get_field('main_options');
$main_options = 'preserveAspectRatio="xMaxYMid meet" ';
if ($main_options_checked_values):
    foreach ($main_options_checked_values as $main_options_value):
        $main_options .= esc_html($main_options_value) . ' ';
    endforeach;
endif;
if (get_field('motion_background')) {
    $main_options .= 'background="' . get_field('motion_background') . '" ';
} else {
    $main_options .= 'background="transparent" ';
}
if (get_field('speed')) {
    $main_options .= 'speed="' . get_field('speed') . '"';
}

if ($main_options !== '' && str_contains($main_options, 'autoplay')) {
} else {
    $classes .= ' fold non-autoplay';
    $utils = 'data-class="bg-play-animation"';
}


if ($main_options !== '' && str_contains($main_options, 'controls')) {
    $style_output = '<style>#lottie-' . esc_attr($id) . '{';
    if (get_field('toolbar_height')) {
        $style_output .= '--lottie-player-toolbar-height: ' . get_field('toolbar_height');
    }
    if (get_field('toolbar_background_color')) {
        $style_output .= '--lottie-player-toolbar-background-color: ' . get_field('toolbar_background_color');
    }
    if (get_field('toolbar_icon_color')) {
        $style_output .= '--lottie-player-toolbar-icon-color: ' . get_field('toolbar_icon_color');
    }
    if (get_field('toolbar_icon_hover_color')) {
        $style_output .= '--lottie-player-toolbar-icon-hover-color: ' . get_field('toolbar_icon_hover_color');
    }
    if (get_field('toolbar_icon_active_color')) {
        $style_output .= '--lottie-player-toolbar-icon-active-color: ' . get_field('toolbar_icon_active_color');
    }
    if (get_field('seeker_track_color')) {
        $style_output .= '--lottie-player-seeker-track-color: ' . get_field('seeker_track_color');
    }
    if (get_field('seeker_thumb_color')) {
        $style_output .= '--lottie-player-seeker-thumb-color: ' . get_field('seeker_thumb_color');
    }
    $style_output .= '}</style>';
    enqueue_footer_markup($style_output);
}


// add acf or other functions here

?>
<div <?php echo get_block_settings($block, $blockID, $classes); ?>>
    <?php

    if (get_field('primary_json')):
        $blockContent .= '<lottie-player  class="lottiedottie" id="lottie-' . esc_attr($blockID) . '" src="' . get_field('primary_json') . '" ' . $main_options . '>';
        $blockContent .= '</lottie-player>';
    endif;
    echo $blockContent;
    ?>
</div>