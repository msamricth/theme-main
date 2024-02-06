<?php
/**
 * Template file: inc/blocks/content-loop/block.php
 *
 * Content Loop Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$blockName = "Content Loop";
$blockID = "content-loop";
$classes = $blockID . " ";

$thumbnail_url = has_post_thumbnail($post_id) ? get_the_post_thumbnail_url($post_id, 'full') : '';

// add acf or other functions here
$read_more_button_text = get_field('read_more_button_text');
$classes .= ""; // Add extra classes here.
?>
<div <?php echo get_block_settings($block, $blockID, $classes); ?>>

    <div class="row">
        <?php
        $args = array(
            'post_type' => 'post', // Adjust post type if necessary
            'posts_per_page' => 3,
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            $count = 0;

            while ($query->have_posts()) {
                $query->the_post();

                // Basic post data
                $title = get_the_title();
                $excerpt = get_the_excerpt();
                $permalink = get_permalink();
                $post_id = get_the_ID();
                $card_date = get_the_date('F j, Y');
                $thumbnail_url = get_the_post_thumbnail_url($post_id, 'full');
                $post_classes = 'count-' . ($count + 1) . ' ';
                $row_class = '';
                $tablet_last = '';

                if (empty($read_more_button_text)) {
                    $read_more_button_text = "Read More";
                }

                // Check if it's the first post
                $is_first_post = ($count === 0);
                if ($is_first_post) {

                    ?>

                    <div class="col-lg-6 col-12 col-xxl-5 col-3xl-4 pe-dlg-4 mb-5 mb-lg-0">
                        <?php echo theme_main_get_overlay_card($title, $excerpt, $permalink, $post_id, $card_date, $thumbnail_url, $post_classes); ?>
                    </div>
                    <div class="col-lg-6 col-12 col-xxl-7 col-3xl-8 ps-dlg-4">
                    <?php } else {
                    if ($count === 2) {
                        $post_classes .= 'mb-0';

                        $tablet_classes = $post_classes . ' d-none d-lg-flex d-xxl-none mb-lg-4';
                        $tablet_last = theme_main_get_horizontal_card_version_2($title, $excerpt, $permalink, $post_id, $card_date, $thumbnail_url, $tablet_classes);

                        $post_classes .= ' d-lg-none d-xxl-flex';
                    } else {
                        $post_classes .= 'mb-5 mb-lg-0 mb-xxl-5';
                        $row_class = 'xxl';
                    }
                    echo theme_main_get_horizontal_card($title, $excerpt, $permalink, $post_id, $card_date, $thumbnail_url, $post_classes, $row_class);
                }

                // Increment count
                $count++;

                // Your code here to use the variables as needed
            }

            // Restore original post data
            wp_reset_postdata();
        }

        ?>
        </div>
        <?php if ($tablet_last) { ?>
            <div class="col-12 mt-lg-4 mt-dlg-5 col-xxl-9 mx-auto">
                <?php echo $tablet_last; ?>
                <!-- button here-->
                <hr class="mt-lg-5 mt-0 mt-xxl-0" style="--bs-border-width: 1px;">
                <a href="<?php echo get_post_type_archive_link('post'); ?>" class="btn btn-secondary btn-wide mx-auto mt-5"
                    title="See all latest posts">
                    <?php echo $read_more_button_text; ?>
                </a>
            </div>

        <?php } ?>
    </div>
</div>