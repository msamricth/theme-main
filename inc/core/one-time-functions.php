<?php 

if (function_exists('theme_main_add_header_block_and_image')) {
    function theme_main_add_header_block_and_image()
    {
        // Check if the theme activation flag is set
        if (get_option('theme_main_activation_flag') !== 'activated') {

            // Query all published posts
            $posts_query = new WP_Query(array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => -1,
            ));

            // Loop through each post and update the ACF fields
            if ($posts_query->have_posts()) {
                while ($posts_query->have_posts()) {
                    $posts_query->the_post();

                    // Skip the post if header block is already present
                    $blocks = parse_blocks(get_the_content());
                    if ($blocks && $blocks[0]['blockName'] === 'acf/header-block') {
                        continue;
                    }

                    // Add ACF header-block to the very top of the post
                    array_unshift($blocks, array('blockName' => 'acf/header-block'));
                    $post_content = serialize_blocks($blocks);
                    wp_update_post(array('ID' => get_the_ID(), 'post_content' => $post_content));

                    // Save the featured image to the ACF header_image field
                    $featured_image_id = get_post_thumbnail_id(get_the_ID());
                    update_field('header_image', $featured_image_id, get_the_ID());
                }

                // Reset post data
                wp_reset_postdata();
            }

            // Set the theme activation flag to 'activated'
            update_option('theme_main_activation_flag', 'activated');
        }
    }

    // Run the function on theme activation
    add_action('after_switch_theme', 'theme_main_add_header_block_and_image');
}
/**
 * Activate Theme Main Theme.
 */
function activate_theme_main() {
    // Include ACF fields file
    include_once get_template_directory() . '/inc/acf/acf_fields.php';

    // Add/Update ACF field group
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group($acf_field_group);
    }
}

// Hook into the activation process
register_activation_hook(__FILE__, 'activate_theme_main');