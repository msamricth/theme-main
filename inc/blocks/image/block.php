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



// add acf or other functions here

$classes .= ""; // Add extra classes here.
?>
<image <?php echo get_block_settings($block, $blockID, $classes); ?> src="" alt="" />
