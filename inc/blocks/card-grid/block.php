<?php
/**
 * Template file: inc/blocks/card-grid/block.php
 *
 * Card Grid Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$blockName = "Card Grid";
$blockID = "card-grid";
$classes = $blockID . " ";
$allowed_blocks = array(
    'acf/card',
    'acf/staff-card'
);
$template = array(
    array(
        'acf/card',
        array(
            'className' => 'col',
        )
    )
);

// add acf or other functions here

$classes .= "row row-cols-1 row-cols-md-2 row-cols-dlg-3 row-cols-2xl-4 justify-content-center g-4"; // Add extra classes here.
?>

<?php

echo '<InnerBlocks ' . get_block_settings($block, $blockID, $classes) .' allowedBlocks="' .
esc_attr(wp_json_encode($allowed_blocks)) . '" template="' . esc_attr(wp_json_encode($template)) . '" />';

?>