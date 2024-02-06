<?php
/**
 * Template file: inc/blocks/stats/block.php
 *
 * Stats Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$blockName = "Stats";
$blockID = "stats-block";
$classes = $blockID . " ";


$blockContent = '';
// add acf or other functions here

$classes .= ""; // Add extra classes here.
?>
<div <?php echo get_block_settings($block, $blockID, $classes); ?>>
    <?php
    if (have_rows('stats')):
        $blockContent .= '<div class="row g-0 justify-content-between">';
        while (have_rows('stats')):
            the_row();
            $blockContent .= '<div class="col-md-4 px-gutter px-gutter mb-5 mb-md-0 text-center">';
            $blockContent .= '<h4 class="stats display-3 pb-3 mb-3">';
            $blockContent .= get_sub_field('number');
            $blockContent .= '</h4>';
            $blockContent .= '<p class="pt-1 text-uppercase"><strong>' . get_sub_field('statement') . '</strong></p>';
            $blockContent .= '</div>';
        endwhile;
        $blockContent .= '</div>';
    else:
    endif;
    echo $blockContent;
    ?>
</div>