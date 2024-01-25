<?php
/**
 * Template file: inc/blocks/content-slider/block.php
 *
 * Content Slider Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$blockName = "Content Slider";
$blockID = "content-slider";
$classes = $blockID . " carousel-block ";



// add acf or other functions here

$classes .= ""; // Add extra classes here.
?>
<div <?php echo get_block_settings($block, $blockID, $classes); ?>>
    <?php
    echo theme_main_get_carousel('carousel-' . $blockID, 1);


    ?>
</div>