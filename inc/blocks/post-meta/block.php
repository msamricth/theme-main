<?php
/**
 * Template file: inc/blocks/post-meta/block.php
 *
 * Post Meta Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$blockName = "Post Meta";
$blockID = "post-meta";
$classes = $blockID . " ";
$current_post = get_queried_object();
if (is_admin()) {
    if (empty($current_post)) {
        global $post;
        $current_post = $post;
    }

}
$classes .= 'd-flex theme-main-color text-uppercase flex-wrap mb-3 mb-md-1';
?>
<div <?php echo get_block_settings($block, $blockID, $classes); ?> style="    --theme-main-font-color: currentColor;">

    <?php
    if ($current_post instanceof WP_Post) {
        // Get the post date
        //$post_date = $current_post->post_date;
        $post_date = date('D M j, Y', strtotime($current_post->post_date));
        // Get the post categories
        $post_categories = get_the_category($current_post->ID);

        if (!empty($post_date) && !empty($post_categories)) {
            echo theme_main_post_meta($post_date, $post_categories);
        } else {
            echo 'No post date or categories found.';
        }
    } else {
        echo 'Unable to retrieve post information.';
    }
    ?>
</div>