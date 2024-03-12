<?php
/**
 * Template file: inc/blocks/header-block/block.php
 *
 * Header Block Block Template.
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
$fullHeight = '';

$classes .= "header-container full-width mb-gutter ";
if (have_rows('options')):
    while (have_rows('options')):
        the_row();
        if (get_sub_field('make_full_screen') == 1):
            $fullHeight .= "full-height ";
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
//settings
$header_type = get_field('header_type');
$classes .= $header_type;


if (($header_type === "image" || empty($header_type)) && !has_post_thumbnail(get_theme_main_postID())) {

    $header_type = 'Basic';
}

if ($header_type === "Image" || $header_type === "Video" ) {
    $header_media = get_header_media();
}


$classes .= $header_type;
$inner_blocks_template = array(
    array(
        'core/columns',
        array(
            'verticalAlignment' => 'bottom',
            'style'             => array(
                'spacing' => array(
                    'padding' => array(
                        'top'    => 'var:preset|spacing|30',
                        'right'  => 'var:preset|spacing|30',
                        'bottom' => 'var:preset|spacing|30',
                        'left'   => 'var:preset|spacing|30',
                    ),
                ),
            ),
        ),
        array(
            array(
                'core/column',
                array(
                    'verticalAlignment' => 'bottom',
                    'width'             => '',
                ),
                array(
                    array(
                        'core/post-title',
                        array(
                        )
                    ),
                    array(
                        'core/paragraph',
                        array(
                            'placeholder' => 'Add a inner paragraph'
                        )
                    ),
                ),
            ),
            array(
                'core/column',
                array(
                    'verticalAlignment' => 'bottom',
                    'width'             => '250px',
                ),
                array(
                    array(
                        'core/button',
                        array(
                            'placeholder' => 'Add a call to action',
                            'backgroundColor' => 'primary',
                            "alignContent" => "right"
                        )
                    ),
                ),
            ),
        ),
    ),
);



if (!empty($block['alignContent'])) {
    $blockClasses .= ' align-items-' . $block['alignContent'];
}
$header_content .= '<div class="page-header py-2 my-3xl-5 fold '.$blockClasses.'" data-class="header">';


$header_content .= '<div class="container">';
$header_content .= '<InnerBlocks class="header-block-editor-content" '. get_header_color().' template="'. esc_attr( wp_json_encode( $inner_blocks_template ) ) .'"/>';
$header_content .= '</div></div>';


$header_type = get_field('header_type');

if ( $header_type == 'carousel') {
    $header_media = theme_main_get_legacy_carousel('carousel-'.$blockID, 1);
}
if ($header_type === 'Basic') {
    $header_media = get_header_basic();
    // Your code here
    $fullHeight = '';
    // This block will be executed when $header_type is "image" or empty
    // and the featured image thumbnail is also empty
}
$classes .= ' ' . $fullHeight;
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