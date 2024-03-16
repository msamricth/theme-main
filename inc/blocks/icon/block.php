<?php
/**
 * Template file: inc/blocks/icon/block.php
 *
 * Icon Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$blockName = "Icon";
$blockID = "icon";
$classes = $blockID . " ";

$classes .= get_field('icon');
if(get_field('icon_size')){
    $classes .= ' '.get_field('icon_size');
}

?>
<i <?php echo get_block_settings($block, $blockID, $classes); ?>>
</i>