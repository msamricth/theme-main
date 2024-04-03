<div id="archive-posts-container" class="row">
    <?php

    $categories = get_categories();
    $read_more_button_text = get_field('read_more_button_text');
    $read_more_function = get_field('read_more_function');
    $classes = '';
    $btnClasses = '';
    $post_id = get_theme_main_postID();
    if (!empty($block['backgroundColor'])) {
        $classes .= ' bg-' . $block['backgroundColor'];
        $btnClasses = ' btn-' . $block['backgroundColor'];
        $classes .= ' has-' . $block['backgroundColor'] . '-background-color ';
    }
    if (!empty($block['textColor'])) {
        $classes .= ' has-' . $block['textColor'] . '-color ';
        $btnClasses .= ' has-' . $block['textColor'] . '-color ';
    }

    if (empty($btnClasses)) {
        $btnClasses = 'btn-primary';
    }


    $category_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;

    // Define the query arguments
    $args = array(
        'posts_per_page' => 3,
    );

    // Check if a category filter is applied
    if ($category_id > 0) {
        $args['cat'] = $category_id;
    }
    $posts_page_id = get_option('page_for_posts');

    // Get the permalink of the posts page
    $posts_page_url = get_permalink($posts_page_id);
    echo theme_main_featured_loop($args, $post_id); ?>
</div>
<?php
switch ($read_more_function) {
    case 'post-page':
        echo '<a href="' . $posts_page_url  . '" class="btn btn-wide mx-auto mt-5 ' . $btnClasses . '"
                    title="See all latest posts">' . $read_more_button_text . '</a>';
        break;
    case 'load-more':
        theme_main_content_nav('ajax');
        echo '<button id="load-more" class="btn btn-wide mx-auto mt-5 ' . $btnClasses . '">' . $read_more_button_text . '</button>';
        break;
} ?>