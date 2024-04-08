<?php

/**
 * Template file: inc/core/loop.php
 * The Loop
 * These functions are related to post querys and custom cards
 *
 * @package Upgrading posts block and adding filter block
 * @since v2.7.9
 */

// Loop Block Settings
if (!function_exists('theme_main_get_content_loop_block_settings')):
    function theme_main_get_content_loop_block_settings($post_id = null)
    {
        $block_settings = array();
        if (empty($post_id)) {
            $post_id = get_theme_main_postID();
        }
        $content = get_post_field('post_content', $post_id);

        $blocks = parse_blocks($content);
        foreach ($blocks as $block) {
            if ($block['blockName'] === 'acf/content-loop') {
                $block_settings = $block['attrs'];
                $block_settings['backgroundColor'] = isset($block_settings['backgroundColor']) ? $block_settings['backgroundColor'] : '';
                $block_settings['textColor'] = isset($block_settings['textColor']) ? $block_settings['textColor'] : '';
                $block_settings['blockAnimation'] = isset($block_settings['blockAnimation']) ? $block_settings['blockAnimation'] : '';

                $styleClasses = isset($block_settings['className']) ? explode(' ', $block_settings['className']) : array();
                $blockStyles = '';
                foreach ($styleClasses as $class) {
                    if (strpos($class, 'is-style-') !== false) {
                        $blockStyles = str_replace('is-style-', '', $class);
                    }
                }
                $block_settings['blockStyle'] = $blockStyles;
            }
        }
        return $block_settings;

    }
endif;
// END Loop Block Settings



//cards
if (!function_exists('theme_main_get_horizontal_card')):
    function theme_main_get_horizontal_card($title, $excerpt, $permalink, $post_id = null, $card_date = null, $thumbnail_url = null, $classes = null, $column_classes = null, $categories = null)
    {

        if ($classes) {
            $classes = $classes . ' ';
        }
        $classes .= 'card horizontal-card';
        $output = '<div ';
        if ($post_id) {
            $output .= 'id="post-' . esc_attr($post_id) . '" ';
        }
        if (empty($column_classes)) {
            $column_classes = 'dlg';
        }
        $column_content = 'col-' . $column_classes . '-8';
        $column_media = 'col-' . $column_classes . '-4';
        $output .= 'class="' . $classes . '">';
        $output .= '<div class="row g-0">';
        $output .= '<div class="media-side ' . $column_media . '">';

        if ($thumbnail_url) {
            $output .= '<img src="' . esc_url($thumbnail_url) . '" class="card-img-top d-' . $column_classes . '-none" alt="' . esc_attr($title) . '">';
        }
        if ($thumbnail_url) {
            $output .= '<div class="has-background-image d-none d-' . $column_classes . '-block" style="background-image: url(' . esc_url($thumbnail_url) . ');"></div>';
        }
        $output .= '</div>';
        $output .= '<div class="' . $column_content . ' content-side">';
        $output .= '<div class="card-body">';

        $output .= theme_main_get_post_loop_meta($card_date, $categories);
        $output .= '<h3 class="card-title"><a href="' . esc_url($permalink) . '" class="stretched-link" title="Continue reading - ' . esc_attr($title) . '">' . esc_html($title) . '</a></h3>';
        $output .= '<p class="card-text">' . esc_html($excerpt) . '</p>';

        $output .= '</div>';

        $output .= '<div class="card-footer">';
        $output .= theme_main_get_read_more_button($permalink);
        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';
        $output .= '<div class="d-none estimate" id="estimate-' . $post_id . '">' . wp_strip_all_tags(get_the_content()) . '</div>';
        $output .= '</div>';

        return $output;
    }
endif;
if (!function_exists('theme_main_get_horizontal_card_version_2')):
    function theme_main_get_horizontal_card_version_2($title, $excerpt, $permalink, $post_id = null, $card_date = null, $thumbnail_url = null, $classes = null, $column_classes = null, $categories = null)
    {

        if ($classes) {
            $classes = $classes . ' ';
        }
        $classes .= 'card horizontal-card';
        $output = '<div ';
        if ($post_id) {
            $output .= 'id="post-' . esc_attr($post_id) . '" ';
        }
        if (empty($column_classes)) {
            $column_content = 'col-dlg-6 col-xl-7';
            $column_media = 'col-dlg-6 col-xl-5';
        } else {
            $column_content = 'col-' . $column_classes . '-8';
            $column_media = 'col-' . $column_classes . '-4';
        }
        if (empty($column_classes)) {
            $column_classes = 'dlg';
        }
        $output .= 'class="' . $classes . '">';
        $output .= '<div class="row">';
        $output .= '<div class="media-side pe-dlg-4 ' . $column_media . '">';

        if ($thumbnail_url) {
            $output .= '<img src="' . esc_url($thumbnail_url) . '" class="card-img-top d-' . $column_classes . '-none" alt="' . esc_attr($title) . '">';
        }
        if ($thumbnail_url) {
            $output .= '<div class="has-background-image d-none d-' . $column_classes . '-block" style="background-image: url(' . esc_url($thumbnail_url) . ');"></div>';
        }
        $output .= '</div>';
        $output .= '<div class="' . $column_content . ' content-side ps-dlg-4">';
        $output .= '<div class="card-body">';

        $output .= theme_main_get_post_loop_meta($card_date, $categories);
        $output .= '<h3 class="card-title"><a href="' . esc_url($permalink) . '" class="stretched-link" title="Continue reading - ' . esc_attr($title) . '">' . esc_html($title) . '</a></h3>';
        $output .= '<p class="card-text">' . esc_html($excerpt) . '</p>';

        $output .= '</div>';

        $output .= '<div class="card-footer">';
        $output .= theme_main_get_read_more_button($permalink);
        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';
        $output .= '<div class="d-none estimate" id="estimate-' . $post_id . '">' . wp_strip_all_tags(get_the_content()) . '</div>';
        $output .= '</div>';

        return $output;
    }
endif;

if (!function_exists('theme_main_get_vertical_card')):
    function theme_main_get_vertical_card($title, $excerpt, $permalink, $post_id = null, $card_date = null, $thumbnail_url = null, $classes = null, $categories = null, $column_classes = null)
    {

        if ($classes) {
            $classes = $classes . ' ';
        }
        $classes .= 'card vertical-card';
        $output = '<div ';
        if ($post_id) {
            $output .= 'id="post-' . esc_attr($post_id) . '" ';
        }
        $output .= 'class="' . $classes . '"  style="--theme-main-font-color: var(--theme-main-contrasting-text-dark);">';

        if ($thumbnail_url) {
            $output .= '<img src="' . esc_url($thumbnail_url) . '" class="card-img-top" alt="' . esc_attr($title) . '">';
        }

        $output .= '<div class="card-body ' . $column_classes . '">';
        $output .= theme_main_get_post_loop_meta($card_date, $categories);
        $output .= '<h3 class="card-title"><a href="' . esc_url($permalink) . '" class="stretched-link" title="Continue reading - ' . esc_attr($title) . '">' . esc_html($title) . '</a></h3>';
        $output .= '<p class="card-text">' . esc_html($excerpt) . '</p>';

        $output .= '</div>';


        $output .= '<div class="card-footer ' . $column_classes . '">';

        $output .= theme_main_get_read_more_button($permalink);
        $output .= '</div>';

        $output .= '<div class="d-none estimate" id="estimate-' . $post_id . '">' . wp_strip_all_tags(get_the_content()) . '</div>';
        $output .= '</div>';

        return $output;
    }
endif;




if (!function_exists('theme_main_get_overlay_card')):
    function theme_main_get_overlay_card($title, $excerpt, $permalink, $post_id = null, $card_date = null, $thumbnail_url = null, $classes = null, $categories = null)
    {
        if ($classes) {
            $classes = $classes . ' ';
        }
        $excerpt = theme_main_excerpt('30', '', $excerpt);
        $classes .= 'card card-overlay text-bg-dark postion-relative';
        $output = '<div ';
        if ($post_id) {
            $output .= 'id="post-' . esc_attr($post_id) . '" ';
        }
        $output .= 'class="' . $classes . '">';
        $output .= '<div class="card-img-overlay text-light';
        if ($thumbnail_url) {
            $output .= ' has-background-image" style="background-image: url(' . esc_url($thumbnail_url) . ');';
        }
        $output .= '">';
        $output .= theme_main_get_post_loop_meta($card_date, $categories);
        $output .= '<h3 class="card-title"><a href="' . esc_url($permalink) . '" class="stretched-link" title="Continue reading - ' . esc_attr($title) . '">' . esc_html($title) . '</a></h3>';
        $output .= '<p class="card-text mb-0">' . esc_html($excerpt) . '</p>';

        $output .= '<div class="theme-overlay" style="--theme-main-overlay-color: rgba(var(--bs-dark-rgb), 0.99); --theme-main-overlay-level: 65%;"></div>';
        $output .= '</div>';
        $output .= '<div class="d-none estimate" id="estimate-' . $post_id . '">' . wp_strip_all_tags(get_the_content()) . '</div>';
        $output .= '</div>';

        return $output;
    }
endif;




//end cards












//AJAX and Post Navigation
if (!function_exists('theme_main_content_nav')) {
    /**
     * Display a navigation to next/previous pages when applicable.
     *
     * @since v1.0
     *
     * @param string $nav_id Navigation ID.
     */
    function theme_main_content_nav($nav_id)
    {
        global $wp_query;
        if ($nav_id === 'ajax') {
            $count_posts = wp_count_posts();
            if ($count_posts->publish > 7) { //if theres only 6 posts on a site dont give a option to load more 
                echo '<div id="posts-container" class="row"></div><button id="load-more" class="btn btn-wide mx-auto mt-5 mb-gutter btn-primary">Load More</button>';
            }
        } else {
            if ($wp_query->max_num_pages > 1) {
                ?>
                <div id="<?php echo esc_attr($nav_id); ?>" class="d-flex mb-4 justify-content-between">
                    <div>
                        <?php next_posts_link('<span aria-hidden="true">&larr;</span> ' . esc_html__('Older posts', theme_namespace())); ?>
                    </div>
                    <div>
                        <?php previous_posts_link(esc_html__('Newer posts', theme_namespace()) . ' <span aria-hidden="true">&rarr;</span>'); ?>
                    </div>
                </div><!-- /.d-flex -->
                <?php
            } else {
                echo '<div class="clearfix"></div>';
            }

        }


    }

    /**
     * Add Class.
     *
     * @since v1.0
     *
     * @return string
     */
    function posts_link_attributes()
    {
        return 'class="btn btn-secondary btn-lg"';
    }
    add_filter('next_posts_link_attributes', 'posts_link_attributes');
    add_filter('previous_posts_link_attributes', 'posts_link_attributes');
}

//if (!function_exists('theme_main_filter_posts')) {
add_action('wp_ajax_theme_main_filter_posts', 'theme_main_filter_posts'); // Update AJAX Action
add_action('wp_ajax_nopriv_theme_main_filter_posts', 'theme_main_filter_posts');

function theme_main_filter_posts()
{
    $category_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 'missing post id';

    // Define the query arguments
    $args = array(
        'posts_per_page' => 6,
    );

    // Check if a category filter is applied
    if ($category_id > 0) {
        $args['cat'] = $category_id;
    }

    theme_main_the_loop($args, $post_id);
    die();
    theme_main_content_nav('ajax');
}
//}


if (!function_exists('theme_main_load_more_posts')) {
    function theme_main_load_more_posts()
    {

        $category_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;

        // Define the query arguments
        $page = $_POST['page'];

        $load_moreArgs = array(
            'posts_per_page' => 6,
            'paged' => $page,
            'offset' => ($page - 1) * 3, // Calculate offset based on page number
        );


        // Check if a category filter is applied
        if ($category_id > 0) {
            $load_moreArgs['cat'] = $category_id;
        }
        theme_main_the_loop($load_moreArgs);

    }

    add_action('wp_ajax_load_more_posts', 'theme_main_load_more_posts');
    add_action('wp_ajax_nopriv_load_more_posts', 'theme_main_load_more_posts');
}
//END AJAX and Post Navigation






//Loop stuff
if (!function_exists('theme_main_the_loop')) {
    function theme_main_the_loop($args, $post_id = null)
    {
        if (empty($post_id)) {
            $post_id = get_theme_main_postID();
        }
        $block = theme_main_get_content_loop_block_settings($post_id);
        $blockStyle = isset($block['blockStyle']) ? $block['blockStyle'] : '';
        if (empty($blockStyle)) {
            'featured';
        }
        $output = '';
        switch ($blockStyle) {
            case 'featured':
                echo 'test';
                $output = theme_main_featured_loop($args, $post_id);
                break;
            case 'posts':
                $output = theme_main_grid_loop($args, $post_id);
                break;
            case 'list':
                $output = theme_main_list_loop($args, $post_id);
                break;
        }
        return $output;
    }
}

//list
if (!function_exists('theme_main_list_loop')) {
    function theme_main_list_loop($args, $parent_post_id)
    {
        $block = theme_main_get_content_loop_block_settings($parent_post_id);
        // Query posts
        $query = new WP_Query($args);
        $output = '';
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $classes = 'mb-4 mb-xl-5 fold animation-on fade-in px-0 ';
                $hasBackground = '';
                if (isset($block['backgroundColor'])) {
                    $hasBackground = 'true';
                    $classes .= ' bg-' . $block['backgroundColor'];
                    $classes .= ' has-' . $block['backgroundColor'] . '-background-color ';
                }
                if (isset($block['textColor'])) {
                    $classes .= ' has-' . $block['textColor'] . '-color ';
                }
                // Include the Post-Format-specific template for the content
                $title = get_the_title();
                $excerpt = theme_main_excerpt('40') . '...';
                $permalink = get_the_permalink();
                $post_id = get_the_ID();
                $card_date = get_the_date('D, M j');
                $categories = get_the_category();
                $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                $classes .= 'card horizontal-card';
                $output .= '<div ';
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
                if (empty($hasBackground)) {
                    $output .= 'pt-0';
                }
                $output .= '">';
                $output .= theme_main_get_post_loop_meta($card_date, $categories);
                $output .= '<h3 class="card-title"><a href="' . esc_url($permalink) . '" class="stretched-link" title="Continue reading - ' . esc_attr($title) . '">' . esc_html($title) . '</a></h3>';
                $output .= '<p class="card-text">' . esc_html($excerpt) . '</p>';

                $output .= '</div>';
                $output .= '<div class="card-footer ';
                if (empty($hasBackground)) {
                    $output .= 'pb-0';
                }
                $output .= '">';
                $output .= theme_main_get_read_more_button($permalink);
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '<div class="d-none estimate" id="estimate-' . $post_id . '">' . wp_strip_all_tags(get_the_content()) . '</div>';
                $output .= '</div>';

            }
            wp_reset_postdata();
        }
        echo $output;
    }
}
//END List
//grid
if (!function_exists('theme_main_grid_loop')) {
    function theme_main_grid_loop($args)
    {
        $block = theme_main_get_content_loop_block_settings();
        $query = new WP_Query($args);
        $post_count = $query->post_count; // Get the total number of posts in the query
        $i = 0;
        $output = '';
        // Output posts
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $classes = '';
                if ($block['backgroundColor']) {
                    $classes .= ' bg-' . $block['backgroundColor'];
                    $classes .= ' has-' . $block['backgroundColor'] . '-background-color ';
                }
                if (isset($args['bgcolor'])) {
                    $classes .= ' bg-' . $args['bgcolor'];

                }
                if ($block['textColor']) {
                    $classes .= ' has-' . $block['textColor'] . '-color ';
                }

                if (isset($args['textcolor'])) {
                    $classes .= ' has-' . $args['textcolor'] . '-color ';
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
                $categories = get_the_category();
                if ($post_count < 4) {
                    $post_col = 12 / $post_count;
                    $output .= '<div class="col-md-6 col-xl-' . $post_col . ' mb-4 mb-xl-5 fold animation-on fade-in">';
                    $output .= theme_main_get_vertical_card($title, $excerpt, $permalink, $post_id, $card_date, $thumbnail_url, $classes, $categories, 'px-0');
                    $output .= '</div>';

                } else {
                    if ($i == 0) {
                        $output .= '<div class="col-dlg-12 col-md-6 mb-4 mb-xl-5 fold animation-on fade-in">';
                        $output .= theme_main_get_horizontal_card($title, $excerpt, $permalink, $post_id, $card_date, $thumbnail_url, $classes, $column_classes, $categories);
                        $output .= '</div>';
                    } elseif ($i <= 3) {
                        $output .= '<div class="col-md-6 col-xl-4 mb-4 mb-xl-5 fold animation-on fade-in">';
                        $output .= theme_main_get_vertical_card($title, $excerpt, $permalink, $post_id, $card_date, $thumbnail_url, $classes, $categories, 'px-0');
                        $output .= '</div>';
                    } else {
                        $output .= '<div class="col-md-6 mb-4 mb-xl-5 fold animation-on fade-in">';
                        $output .= theme_main_get_vertical_card($title, $excerpt, $permalink, $post_id, $card_date, $thumbnail_url, $classes, $categories, 'px-0');
                        $output .= '</div>';
                    }
                    $i++; // Increment $i after each post
                }
            }
            wp_reset_postdata();
            // die();
        }
        echo $output;
    }
}
//featured
if (!function_exists('theme_main_featured_loop')) {
    function theme_main_featured_loop($args)
    {
        //$block = theme_main_get_content_loop_block_settings();
        $output = '';
        $query = new WP_Query($args);
        $row_class = '';

        if ($query->have_posts()) {
            $count = 0;

            while ($query->have_posts()) {
                $query->the_post();
                $classes = '';
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
                $categories = get_the_category();
                // Check if it's the first post
                $is_first_post = ($count === 0);
                if ($is_first_post) {

                    $output .= '<div class="col-lg-6 col-12 col-xxl-5 col-3xl-4 pe-dlg-2 mb-5 mb-lg-0">';
                    $output .= theme_main_get_overlay_card($title, $excerpt, $permalink, $post_id, $card_date, $thumbnail_url, $post_classes, $categories);
                    $output .= '</div>';
                    $output .= '<div class="col-lg-6 col-12 col-xxl-7 col-3xl-8 ps-dlg-2">';
                } else {
                    if ($count === 2) {
                        $post_classes .= 'mb-0 ' . $classes;

                        $tablet_classes = $post_classes . ' d-none d-lg-flex d-xxl-none mb-lg-2';
                        $tablet_last = theme_main_get_horizontal_card_version_2($title, $excerpt, $permalink, $post_id, $card_date, $thumbnail_url, $tablet_classes, '', $categories);

                        $post_classes .= ' d-lg-none d-xxl-flex';
                    } else {
                        $post_classes .= 'mb-5 mb-lg-0 mb-xxl-3 ' . $classes;
                        $row_class = 'xxl';
                    }
                    $output .= theme_main_get_horizontal_card($title, $excerpt, $permalink, $post_id, $card_date, $thumbnail_url, $post_classes, $row_class, $categories);
                }

                $count++;
            }
            wp_reset_postdata();
        }
        $output .= '</div>';
        if ($tablet_last) {
            $output .= '<div class="col-12 mt-lg-4 mt-dlg-5 col-xxl-9 mx-auto">';
            $output .= $tablet_last;
            $output .= '<hr class="mt-lg-5 mt-0 mt-xxl-0" style="--bs-border-width: 1px;">';
            $output .= '</div>';

        }
        // die();
        echo $output;
    }
}

//Utilities
if (!function_exists('theme_main_get_read_more_button')):
    function theme_main_get_read_more_button($permalink, $read_more_toggle = null)
    {
        $output = '';
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

        if ($read_more_toggle) {
            $output .= '<a href="' . esc_url($permalink) . '" class="btn ' . $read_more_button_style . '">' . $read_posts_more_label . '</a>';
        } else {
            $output .= '<a href="' . esc_url($permalink) . '" class="read-more-link stretched-link">' . $read_posts_more_label . '</a>';
        }

        return $output;
    }
endif;

if (!function_exists('theme_main_get_post_loop_meta')):
    function theme_main_get_post_loop_meta($card_date, $categories = null)
    {
        $output = '';
        if ($card_date) {
            $output .= '<div class="d-flex theme-main-color text-uppercase align-items-center flex-wrap mb-3 mb-md-1">';
            $output .= theme_main_post_meta($card_date, $categories);
            $output .= '</div>';
        }
        return $output;
    }
endif;
if (!function_exists('theme_main_post_meta')):
    function theme_main_post_meta($card_date, $categories = null)
    {
        $output = '';
        $categoryObj = '';
        if (!empty($categories)) {
            $categoryObj = '<div class="badge-container order-3 order-md-2">';
            foreach ($categories as $category) {
                if ($category->name == 'Uncategorized') {
                } else {
                    $categoryObj .= '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="badge text-bg-primary me-3">' . esc_html($category->name) . '</a>';
                }
            }
            $categoryObj .= '</div>';
        }

        if ($card_date) {
            $output .= '<strong class="me-3">' . $card_date . '</strong>
            ' . $categoryObj . '
            <span class="read-time me-3"></span>';
        }
        return $output;
    }
endif;
function theme_main_post_meta_block($block) {
    $post_id = get_the_ID();
    $block['data']['postId'] = $post_id;
    return $block;
}
add_filter('acf/prepare_block', 'theme_main_post_meta_block');
