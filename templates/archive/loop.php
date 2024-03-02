<?php
/**
 * The template for displaying the archive loop.
 */

//theme_main_content_nav('nav-above');


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
		?>
	</div>
	<?php
}

wp_reset_postdata();


theme_main_content_nav('ajax');
