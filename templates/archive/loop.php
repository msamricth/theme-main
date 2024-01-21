<?php
/**
 * The template for displaying the archive loop.
 */

theme_main_content_nav('nav-above');


$args = array(
	'posts_per_page' => 6,
);

$query = new WP_Query($args);
$i = 0;
$row_class = '';
if ($query->have_posts()) {
	?>
	<div class="row">
		<?php

		while ($query->have_posts()) {
			$query->the_post();

			/**
			 * Include the Post-Format-specific template for the content.
			 * If you want to overload this in a child theme then include a file
			 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
			 */

			if ($i == 0) {
				$row_class = 'horizontal-card';
				// Display 1 post in the first row
				get_template_part('templates/content/horizontal-card', null, ['row_class' => $row_class]);
			} elseif ($i <= 3) {

				$row_class = 'vertical-card col-lg-4';
				// Display 3 posts in the second row
				get_template_part('templates/content/vertical-card', null, ['row_class' => $row_class]);
			} else {
				$row_class = 'vertical-card col-lg-6';
				// Display 2 posts in the third row
				get_template_part('templates/content/vertical-card', null, ['row_class' => $row_class]);
			}
			$i++; // Increment $i after each post
		}
		?>
	</div>
	<button id="load-more" class="btn btn-primary">Load More</button>
	<div id="posts-container" class="row">
		<!-- Existing posts go here -->
	</div>
	<?php
}

wp_reset_postdata();


theme_main_content_nav('nav-below');