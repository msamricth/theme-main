<?php
/**
 * Template file: inc/blocks/image/block.php
 *
 * Image Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$blockName = "Image";
$blockID = "image";
$classes = $blockID . " ";
$blockImage = get_field('image');
$blockImageRatio = get_field('ratio');
$blockImageWidth = get_field('width');
$blockImageHeight = get_field('height');
$blockImageAltText = get_field('alternative_text');
$blockImageSettings = ' ';
$blockImageClasses = ' ';
$blockImageURL = '';
if ($blockImage):
    $blockImageURL = esc_url($blockImage['url']);
    if (empty ($blockImageAltText)) {
        $blockImageAltText = esc_attr($blockImage['alt']);
    }
endif;
if (get_field('make_round') == 1):
    $classes .= " rounded-circle";
endif;

if (isset ($blockImageWidth)) {
    $blockImageWidth = theme_main_check_for_unit($blockImageWidth); //check if there is some sort of measurement (px, %, rem, etc) attached to this var and append 'px' to the end if there isnt.
    $blockImageSettings .= 'width="' . $blockImageWidth . '" ';
}
if (isset ($blockImageHeight)) {
    $blockImageHeight = theme_main_check_for_unit($blockImageHeight); //check if there is some sort of measurement (px, %, rem, etc) attached to this var and append 'px' to the end if there isnt.
    $blockImageSettings .= 'width="' . $blockImageHeight . '" ';
}
if (empty ($blockImageRatio)) {
    $blockImageSettings .= get_block_settings($block, $blockID, $blockImageClasses);
} else {
    $blockImageSettings .= 'class="'.$blockImageClasses.'"';
}

$blockImage = '<image src="' . $blockImageURL . '" alt="' . $blockImageAltText . '"'. $blockImageSettings .' />';

if ($blockImageRatio) {
    echo theme_main_get_block_ratio($blockImage, $blockImageRatio, $block, $blockID, $classes); // wraps image in div with ratio ratio-$blockImageRatio as the class, adds block settings to that div instead of the image
} else {
    echo $blockImage;
}
?>