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
            $hasBackground = '';
            if ($block['backgroundColor']) {
                
            $hasBackground = 'true';
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
            $read_more_toggle = '';
            $final = '<div class="d-none estimate" id="estimate-' . $post_id . '">' . wp_strip_all_tags(get_the_content()) . '</div>';
            if (empty($read_more_toggle)) {
                if (get_field('read_more_link_type') == 1):
                    $read_more_toggle = 'true';
                endif;
            }
            $read_posts_more_label = get_field('read_posts_more_label');
            if (empty($read_posts_more_label)) {
                $read_posts_more_label = 'Read More';
            }
    
            $read_more_button_style = get_field('read_more_button_style');
            if (empty($read_more_button_style)) {
                $read_more_button_style = 'btn-primary';
            }
            if ($classes) {
                $classes = $classes . ' mb-4 mb-xl-5 fold animation-on fade-in px-0 ';
            }
            $classes .= 'card horizontal-card';
            $output = '<div ';
            if ($post_id) {
                $output .= 'id="post-' . esc_attr($post_id) . '" ';
            }
            $column_content = 'col-dlg-8';
            $column_media = 'col-dlg-4';
            $output .= 'class="' . $classes . '">';
            $output .= '<div class="row g-0">';
            $output .= '<div class="media-side ' . $column_media . '">';
    
            if ($thumbnail_url) {
                $output .= '<img src="' . esc_url($thumbnail_url) . '" class="card-img-top d-dlg-none" alt="' . esc_attr($title) . '">';
            }
            if ($thumbnail_url) {
                $output .= '<div class="has-background-image d-none d-dlg-block" style="background-image: url(' . esc_url($thumbnail_url) . ');"></div>';
            }
            $output .= '</div>';
            $output .= '<div class="' . $column_content . ' content-side">';
            $output .= '<div class="card-body ';
            if($hasBackground){
                $output .= 'pt-0';
            }
            $output .= '">';
            if ($card_date) {
                $output .= '<strong class="theme-main-color text-uppercase">' . $card_date . '</strong>';
            }
            $output .= '<h3 class="card-title"><a href="' . esc_url($permalink) . '" class="stretched-link" title="Continue reading - ' . esc_attr($title) . '">' . esc_html($title) . '</a></h3>';
            $output .= '<p class="card-text">' . esc_html($excerpt) . '</p>';
    
            $output .= '</div>';
    
            $output .= '<div class="card-footer ';
            if($hasBackground){
                $output .= 'pb-0';
            }
            $output .= '">';
            if ($read_more_toggle) {
                $output .= '<a href="' . esc_url($permalink) . '" class="btn '.$read_more_button_style.'">'.$read_posts_more_label.'</a>';
            } else {
                $output .= '<a href="' . esc_url($permalink) . '" class="read-more-link stretched-link">'.$read_posts_more_label.'</a>';
            }
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
            echo $output.$final;

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