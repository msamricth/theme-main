<?php
/**
 * Template Name: Page (Default)
 * Description: Page template with Sidebar on the left side.
 *
 */

get_header();

the_post();
?>
<div id="post-<?php the_ID(); ?>" <?php post_class('content'); ?>>
	<div class="entry-content">
		<?php
		the_content();

		echo get_the_fold();
		wp_link_pages(
			array(
				'before' => '<nav class="page-links" aria-label="' . esc_attr__('Page', 'theme_main') . '">',
				'after' => '</nav>',
				'pagelink' => esc_html__('Page %', 'theme_main'),
			)
		);
		edit_post_link(
			esc_attr__('Edit', 'theme_main'),
			'<span class="edit-link">',
			'</span>'
		);
		?>
	</div><!-- /#post-<?php the_ID(); ?> -->
	<?php
	// If comments are open or we have at least one comment, load up the comment template.
	if (comments_open() || get_comments_number()) {
		comments_template();
	}
	?>
</div>
<?php
get_footer();
