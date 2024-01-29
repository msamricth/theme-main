<?php
/**
 * Template file: inc/blocks/floating-call-to-action/block.php
 *
 * Floating Call To Action  Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$blockName = "Floating Call To Action ";
$blockID = "block-floating-cta";
$classes = $blockID . " ";
$template = array(
    array(
        'core/button',
        array(
            'placeholder' => 'Add a call to action', // Set the placeholder here
            'backgroundColor' => 'dark',  // Set the background color to dark
            'color' => 'light',  // Set the text color to white
            'alignContent' => 'right',  // Align content to right
            'justifyContent' => 'flex-end'
        ),
    ),
    // You can add more buttons as needed
);
// add acf or other functions here


$classes .= "py-2 position-sticky sticky-top full-width"; // Add extra classes here.
?>
<div <?php echo get_block_settings($block, $blockID, $classes); ?>>

        <?php
        echo '<InnerBlocks class="container" template="' . esc_attr(wp_json_encode($template)) . '" />';

        ?>

</div>