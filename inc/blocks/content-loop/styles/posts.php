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
    $args = array(
        'posts_per_page' => 6,
    );

    if (is_category()) {
        $category_id = get_queried_object_id();
    }
    if ($category_id > 0) {
        $args['cat'] = $category_id;
    }
    echo theme_main_grid_loop($args);
    switch ($read_more_function) {
        case 'post-page':
            echo '<a href="' . get_permalink( get_option( 'page_for_posts' ) ) . '" class="btn btn-wide mx-auto mt-5 ' . $btnClasses . '"
            title="See all latest posts">' . $read_more_button_text . '</a>';
            break;
        case 'load-more':
            theme_main_content_nav('ajax');
            // echo '<button id="load-more" class="btn btn-wide mx-auto mt-5 ' . $btnClasses . '">' . $read_more_button_text . '</button>';
            break;
    }
    ?>
</div>