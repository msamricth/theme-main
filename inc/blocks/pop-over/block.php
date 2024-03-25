<?php
/**
 * Template file: inc/blocks/pop-over/block.php
 *
 * Pop Over Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$blockName = "Pop Over";
$blockID = "pop-over";
$classes = $blockID . " ";

$blockID .= '-' . rand();

$button_label = get_field('button_label');
$popover_content = get_field('popover_content');
$direction = get_field('direction');
// add acf or other functions here

$classes .= "btn btn-secondary theme-main-popover-btn";

$blockBTN = '<button type="button" data-bs-toggle="collapse" data-bs-target="#' . $blockID . '" data-bs-popper-placement="' . $direction . '" ' . get_block_settings($block, $blockID, $classes) . '>';
$blockBTN .= get_field('button_label');
$blockBTN .= '</button>';
echo $blockBTN;

$blockClasses = 'collapse theme-main-popover-content';
if($direction){
    $blockClasses .= ' popover-direction-'.$direction;
}
$blockContent = '<div id="' . $blockID . '" class="' . get_block_classes($block, $blockClasses, '1') . '">';
$blockContent .= $popover_content;
$blockContent .= '</div>';
echo $blockContent;