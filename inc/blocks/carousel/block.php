<?php
/**
 * Template file: inc/blocks/carousel-block/block.php
 *
 * Carousel Block Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$blockName = "Carousel Block";
$blockID = "carousel-block";
$classes = $blockID . " ";



// add acf or other functions here

$classes .= ""; // Add extra classes here.
?>
<div <?php echo get_block_settings($block, $blockID, $classes); ?>>
    <?php

    // add template stuff here
    

    if (is_admin()) {
        // Runs only if this PHP code is in a file that displays outside the admin panels, like the theme template.
        echo "<button style='position: absolute;right: 10%;padding: 0.768rem;top: 20%;'>Click here to edit this " . $blockName . "</button>";
    }
    ?>
</div>