<?php
/**
 * The template for displaying the archive loop.
 */
// Retrieve all categories
$categories = get_categories();
$read_more_button_text = get_field('read_more_button_text');
$read_more_function = get_field('read_more_function');
?>
<div id="archive-posts-container" class="row">
    <?php
    $category_id = isset ($_POST['category_id']) ? intval($_POST['category_id']) : 0;
    // Define the query arguments
    $args = array(
        'posts_per_page' => 6,
    );

    // Check if a category filter is applied
    if ($category_id > 0) {
        $args['cat'] = $category_id;
    }

    // Query posts
    $query = new WP_Query($args);
    $post_count = $query->post_count; // Get the total number of posts in the query
    $i = 0;
    $row_class = '';
    // Output posts
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $classes = '';
            $btnClasses = '';
            if ($block['backgroundColor']) {
                $classes .= ' bg-' . $block['backgroundColor'];
                $btnClasses = ' btn-' . $block['backgroundColor'];
                $classes .= ' has-' . $block['backgroundColor'] . '-background-color ';
            }
            if (isset ($args['bgcolor'])) {

                $classes .= ' bg-' . $args['bgcolor'];
                $btnClasses = ' btn-' . $args['bgcolor'];

            }
            if ($block['textColor']) {
                $classes .= ' has-' . $block['textColor'] . '-color ';
                $btnClasses .= ' has-' . $block['textColor'] . '-color ';
            }

            if (isset ($args['textcolor'])) {
                $classes .= ' has-' . $args['textcolor'] . '-color ';
                $btnClasses .= ' has-' . $args['textcolor'] . '-color ';
            }
            $read_more_function = get_field('read_more_function');
            if (empty ($btnClasses)) {
                $btnClasses = 'btn-primary';
            }
            // Include the Post-Format-specific template for the content
            $title = get_the_title();
            $excerpt = theme_main_excerpt('40') . '...';
            $permalink = get_the_permalink();
            $post_id = get_the_ID();
            $card_date = get_the_date('D, M j') . '<span class="read-time"></span>';
            $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
            $classes .= ' p-4';
            $column_classes = '';
            $read_more_toggle = '';
            $final = '<div class="d-none estimate" id="estimate-' . $post_id . '">' . wp_strip_all_tags(get_the_content()) . '</div>';

            // Check if there are less than four posts
            if ($post_count < 4) {
                $post_col = 12 / $post_count;
                ?>
                <div class="col-md-6 col-xl-<?php echo $post_col; ?> mb-4 mb-xl-5 fold animation-on fade-in">
                    <?php echo theme_main_get_vertical_card($title, $excerpt, $permalink, $post_id, $card_date, $thumbnail_url, $classes, $read_more_toggle, 'px-0');
                    echo $final; ?>
                </div>
                <?php
            } else {
                if ($i == 0) { ?>
                    <div class="col-dlg-12 col-md-6 mb-4 mb-xl-5 fold animation-on fade-in">
                        <?php echo theme_main_get_horizontal_card($title, $excerpt, $permalink, $post_id, $card_date, $thumbnail_url, $classes, $column_classes, $read_more_toggle);
                        echo $final ?>
                    </div>
                <?php } elseif ($i <= 3) { ?>
                    <div class="col-md-6 col-xl-4 mb-4 mb-xl-5 fold animation-on fade-in">
                        <?php // Display 3 posts in the second row
                                        //get_template_part('templates/content/vertical-card', null, ['row_class' => $row_class]);
                                        echo theme_main_get_vertical_card($title, $excerpt, $permalink, $post_id, $card_date, $thumbnail_url, $classes, $read_more_toggle, 'px-0');
                                        echo $final; ?>
                    </div>
                    <?php
                } else { ?>
                    <div class="col-md-6 mb-4 mb-xl-5 fold animation-on fade-in">
                        <?php echo theme_main_get_vertical_card($title, $excerpt, $permalink, $post_id, $card_date, $thumbnail_url, $classes, $read_more_toggle, 'px-0');
                        echo $final; ?>
                    </div>
                    <?php
                }
                $i++; // Increment $i after each post
            }
        }
        wp_reset_postdata();
    } else {
        echo 'No posts found';
    }
    switch ($read_more_function) {
        case 'post-page':
            echo '<a href="' . get_post_type_archive_link('post') . '" class="btn btn-wide mx-auto mt-5 ' . $btnClasses . '"
            title="See all latest posts">' . $read_more_button_text . '</a>';
            break;
        case 'load-more':
            theme_main_content_nav('ajax');
            // echo '<button id="load-more" class="btn btn-wide mx-auto mt-5 ' . $btnClasses . '">' . $read_more_button_text . '</button>';
            break;
    }
    ?>
</div>