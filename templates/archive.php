<?php
/**
 * The Template for displaying Archive pages.
 */

$usingBlocks = theme_main_check_for_blocks();

if ($usingBlocks) {
	echo 'test';
	get_template_part('templates/archive/block');
} else {
	if (have_posts()):

		get_template_part('archive/loop');
	else:
		// 404.
		get_template_part('content/none');
	endif;

	wp_reset_postdata(); // End of the loop.
}
