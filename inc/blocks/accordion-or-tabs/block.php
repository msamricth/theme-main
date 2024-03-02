<?php
/**
 * Template file: inc/blocks/accordion-or-tabs/block.php
 *
 * Accordion or Tabs Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$blockName = "Accordion or Tabs";
$blockID = "accordion-or-tabs";
$classes = $blockID . " ";
$type = '';
$tab_placement = '';
$accordion_open_icon = '';
$accordion_close_icon = '';
$accordion_always_open = '';
$nav_fill_on = '';

if (have_rows('options')) {
    while (have_rows('options')) {
        the_row();
        $type = get_sub_field('type');
        $tab_placement = get_sub_field('tab_placement');
        $accordion_open_icon = get_sub_field('accordion_open_icon_');
        $accordion_close_icon = get_sub_field('accordion_close_icon');
        $nav_style = get_sub_field('nav_style');
        if ( get_sub_field( 'always_open' ) == 1 ) : $accordion_always_open = 'true';  endif;
        if ( get_sub_field( 'nav_fill' ) == 1 ) : $nav_fill_on = 'true';  endif;
        if(empty($nav_style)){
            $nav_style = 'tabs';
        }
    }
}

// add acf or other functions here

$classes .= ""; // Add extra classes here.
?>
<div <?php echo get_block_settings($block, $blockID, $classes); ?>>
    <?php
    switch ($type) {
        case 'Accordion':
            echo get_theme_main_accordion($blockID, $accordion_open_icon, $accordion_close_icon, $accordion_always_open);
            break;
        case 'Tabs':
            echo get_theme_main_tabs($blockID, $tab_placement, $nav_style, $nav_fill_on);
            break;
    }
    
    ?>
</div>