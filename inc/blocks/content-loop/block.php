<?php
/**
 * Template file: inc/blocks/content-loop/block.php
 *
 * Content Loop Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$blockName = "Content Loop";
$blockID = "content-loop";
$classes = $blockID . " ";

$thumbnail_url = has_post_thumbnail($post_id) ? get_the_post_thumbnail_url($post_id, 'full') : '';

$styleClasses = explode(' ', $block['className']);
$blockStyles = '';
foreach ($styleClasses as $class) {
    if (strpos($class, 'is-style-') !== false) {
        $blockStyles = str_replace('is-style-', '', $class);
        break; // Stop loop after finding the first style class
    }
}
$classes .= " " . $blockStyles;


?>
<div <?php echo get_block_settings($block, $blockID, $classes, 'background textColor'); ?>>
    <?php include('styles/' . $blockStyles.'.php'); ?>
    
</div>