<?php
/**
 * Template file: inc/blocks/word-fumbler/block.php
 *
 * Word Fumbler Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$blockName = "Word Fumbler";
$blockID = "word-fumbler";
$blockVersion = 1;
$type = '';
$type_size = '';

$classes = $blockID . " ";
if (have_rows('options')):
    while (have_rows('options')):
        the_row();
        if (get_sub_field('version') == 1):
            $blockVersion = 2;
            $classes .= " word-fumbler-second-version";
        else:
            $classes .= " word-fumbler-first-version";
        endif;
    endwhile;
endif;
?>
<div <?php echo get_block_settings($block, $blockID, $classes); ?>>
    <?php if (have_rows('terms')): ?>
        <ul class="list-unstyled box">
            <?php while (have_rows('terms')):
                the_row();
                if ($blockVersion === 2) {

                    $type = get_sub_field('typography');
                    $type_size = get_sub_field('type_size');
                    echo '<li class="word-fumbler-item"><' . $type . ' class="' . $type_size . '">';
                    $term = get_sub_field('term');
                    theme_main_seperate_characters($term);


                    echo '</' . $type . '></li>';


                    ?>
                <?php } else { ?>
                    <li class="word-fumbler-item">
                        <?php the_sub_field('term'); ?>
                    </li>
                <?php }
            endwhile; ?>
        </ul>
    <?php else: ?>
        <?php // No rows found     ?>
    <?php endif; ?>
</div>