<?php
/**
 * Template file: inc/blocks/big-list/block.php
 *
 * Big List Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$blockName = "Big List";
$blockID = "big-list";
$classes = $blockID . " ";


$allowed_blocks = array(
    'acf/big-list-item'
);
$template = array(
    array(
        'acf/big-list-item',
        array()
    )
);

// add acf or other functions here

$classes .= "d-flex flex-column"; // Add extra classes here.
echo '<InnerBlocks ' . get_block_settings($block, $blockID, $classes) . ' allowedBlocks="' .
    esc_attr(wp_json_encode($allowed_blocks)) . '" template="' . esc_attr(wp_json_encode($template)) . '" />';

?>