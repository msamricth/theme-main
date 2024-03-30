<div id="archive-posts-container" class="row">
    <?php

    $categories = get_categories();
    $read_more_button_text = get_field('read_more_button_text');
    $read_more_function = get_field('read_more_function');
    $classes = '';
    $btnClasses = '';
    if (!empty ($block['backgroundColor']) && strpos($NamesOff, 'backgroundColor') === false) {
        $classes .= ' bg-' . $block['backgroundColor'];
        $btnClasses = ' btn-' . $block['backgroundColor'];
        $classes .= ' has-' . $block['backgroundColor'] . '-background-color ';
    }
    if (!empty ($block['textColor']) && strpos($NamesOff, 'textColor') === false) {
        $classes .= ' has-' . $block['textColor'] . '-color ';
        $btnClasses .= ' has-' . $block['textColor'] . '-color ';
    }

    if(empty($btnClasses)){
        $btnClasses = 'btn-primary';
    }


    $category_id = isset ($_POST['category_id']) ? intval($_POST['category_id']) : 0;

    // Define the query arguments
    $args = array(
        'posts_per_page' => 3,
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

            if (empty ($read_more_button_text)) {
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
                    $post_classes .= 'mb-0 ' . $classes;

                    $tablet_classes = $post_classes . ' d-none d-lg-flex d-xxl-none mb-lg-4';
                    $tablet_last = theme_main_get_horizontal_card_version_2($title, $excerpt, $permalink, $post_id, $card_date, $thumbnail_url, $tablet_classes);

                    $post_classes .= ' d-lg-none d-xxl-flex';
                } else {
                    $post_classes .= 'mb-5 mb-lg-0 mb-xxl-5 ' . $classes;
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
    <?php 
     if ($tablet_last) { ?>
        <div class="col-12 mt-lg-4 mt-dlg-5 col-xxl-9 mx-auto">
            <?php echo $tablet_last; ?>
            <!-- button here-->
            <hr class="mt-lg-5 mt-0 mt-xxl-0" style="--bs-border-width: 1px;">

            <?php
            
            switch ($read_more_function) {
                case 'post-page':
                    echo '<a href="' . get_post_type_archive_link('post') . '" class="btn btn-wide mx-auto mt-5 ' . $btnClasses . '"
                    title="See all latest posts">' . $read_more_button_text . '</a>';
                    break;
                case 'load-more':
                    theme_main_content_nav('ajax');
                    echo '<button id="load-more" class="btn btn-wide mx-auto mt-5 ' . $btnClasses . '">' . $read_more_button_text . '</button>';
                    break;
            } ?>
        </div>

    <?php } ?>
</div>