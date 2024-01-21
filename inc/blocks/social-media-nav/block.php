<?php
/**
 * Template file: inc/blocks/social-media-nav/block.php
 *
 * Social Media Nav Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$blockName = "Social Media Nav";
$blockID = "social-media-nav";
$classes = $blockID . " ";

$navigation_stance = get_field('navigation_stance');
if ( ! empty( $navigation_stance ) ) {
    $classes .= ' display-horizontal';
}

$classes .= ""; // Add extra classes here.
?>
<div <?php echo get_block_settings($block, $blockID, $classes); ?>>
    <?php
    if (have_rows('add_a_social_media_account', 'option')): ?>
        <ul class="social-nav ">
            <?php while (have_rows('add_a_social_media_account', 'option')):
                the_row();
                $site_title = get_bloginfo('name');
                $sm_title = get_sub_field('social_media_name'); ?>
                <li>
                    <a href="<?php the_sub_field('url'); ?>" target="_blank"
                        title="<?php echo $site_title . "'s" . $sm_title; ?>">
                        <?php the_sub_field('icon'); ?>
                    </a>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <?php // No rows found ?>
    <?php endif;?>
</div>