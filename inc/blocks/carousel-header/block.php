<?php
/**
 * Template file: inc/blocks/carousel-header/block.php
 *
 * Carousel Header Block Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$blockName = "Header Block";
$blockID = "header-block";
$classes = $blockID . " ";

$anchor = 'header-' . get_theme_main_postID();
if (!empty($block['anchor'])) {
    $anchor = $block['anchor'];
}


$classes .= "header-container carousel-header full-width mb-gutter ";
if (have_rows('options')):
    while (have_rows('options')):
        the_row();
        if (get_sub_field('make_full_screen') == 1):
            $classes .= "full-height ";
        endif;
    endwhile;
endif;

$blockStyles = '';
$header_content = '';
$blockContent = '';
$page_title = '';
if (isset($args['page_title'])) {
    $page_title = $args['page_title'];
}

//Assets
$headerMedia = '';
$blockClasses = '';
$header_media = get_header_media();
//settings
$header_type = get_field('header_type');
$classes .= $header_type;

$header_content = theme_main_get_carousel();

?>
<header id="<?php echo esc_attr($anchor); ?>" class="<?php echo esc_attr(get_block_classes($block, $classes)); ?>">
    <?php

    ?>

    <?php
        echo $header_content;
    
    if (!empty($header_media)) {

        echo $header_media;
    } ?>
</header>

<div class="fold <?php echo get_match_nav(); ?>"></div>