<?php
/**
 * Template file: inc/blocks/filter-posts/block.php
 *
 * Filter Posts Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$blockName = "Filter Posts";
$blockID = "filter-posts";
$classes = $blockID . " row ";
$categories = get_categories();
$classes .= "category-filter";
$filterClasses = 'filter-field';
if (!empty($block['backgroundColor'])) {
    $filterClasses .= ' has-' . $block['backgroundColor'] . '-background-color ';
}
if (!empty($block['textColor'])) {
    $filterClasses .= ' has-' . $block['textColor'] . '-color ';
}
?>
<div <?php echo get_block_settings($block, $blockID, $classes, 'backgroundColor background color textColor'); ?>>
    <?php
    if (have_rows('filters')):
        while (have_rows('filters')):
            the_row(); ?>
            <div class="col">
                <?php
                if (get_row_layout() == 'taxonomy_type'):
                    $taxonomies = get_sub_field('taxonomies');
                    $filter_label = get_sub_field('filter_label');
                    $style = get_sub_field('style');
                    $all_terms = array();
                    foreach ($taxonomies as $taxonomy) {
                        // Get the terms for the current taxonomy
                        $terms = get_terms(
                            array(
                                'taxonomy' => $taxonomy->name,
                                'hide_empty' => false,
                            )
                        );
                        // Merge terms into the all_terms array
                        $all_terms = array_merge($all_terms, $terms);
                    }

                    echo '<label for="' . slugify($filter_label) . '-filter">Filter by ' . $filter_label . ':</label>';
                    echo theme_main_option_fields($style, $all_terms, $filter_label, $filterClasses);
                elseif (get_row_layout() == 'filter_by_custom_terms'):

                    $taxonomies = get_sub_field('taxonomy_terms');
                    $filter_label = get_sub_field('filter_label');
                    // $taxonomies = explode(" ", $taxonomies);
                    $style = get_sub_field('style');
                    echo '<label for="' . slugify($filter_label) . '-filter">Filter by ' . $filter_label . ':</label>';
                    echo theme_main_option_fields($style, $taxonomies, $filter_label, $filterClasses);

                elseif (get_row_layout() == 'search_form'):
                    $filter_label = get_sub_field('filter_label');
                    $style = get_sub_field('style');

                    // Output the filter label
                    echo '<label for="' . $style . '">' . $filter_label . ':</label>';

                    // Output the search input field
                    echo '<form class="search-form" role="search" method="get" action="' . esc_url(home_url('/')) . '">
                        <div class="input-group">
                            <input type="text" name="s" class="form-control" placeholder="' . esc_attr_e('Search', 'theme_main') . '" />
                            <button type="submit" class="btn btn-secondary" name="submit">' . esc_html_e('Search', 'theme_main') . '</button>
                        </div><!-- /.input-group -->
                    </form>';


                endif; ?>
            </div>
            <?php
        endwhile;
    else:
        // No layouts found
    endif;

    ?>

</div>