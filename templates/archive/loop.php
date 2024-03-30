<?php
/**
 * The template for displaying the archive loop.
 */

// Retrieve all categories
$categories = get_categories();

// Display the category filter dropdown
if (!empty ($categories)) {
	?>
	<div class="category-filter mb-5">
		<label for="category-filter">Filter by Category:</label>
		<select name="category-filter" class="form-select" id="category-filter">
			<option value="">All Categories</option>
			<?php foreach ($categories as $category): ?>
				<option value="<?php echo esc_attr($category->term_id); ?>">
					<?php echo esc_html($category->name); ?>
				</option>
			<?php endforeach; ?>
		</select>
	</div>
	<div id="archive-posts-container" class="row">
		<?php
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
		// Output posts
		if ($query->have_posts()) {
			while ($query->have_posts()) {
				$query->the_post();
				// Include the Post-Format-specific template for the content
				$title = get_the_title();
				$excerpt = theme_main_excerpt('40') . '...';
				$permalink = get_the_permalink();
				$post_id = get_the_ID();
				$card_date = get_the_date('D, M j') . '<span class="read-time"></span>';
				$thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
				$classes = 'p-4 bg-primary';
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

		theme_main_content_nav('ajax');
		?>
	</div>
	<?php
}
?>