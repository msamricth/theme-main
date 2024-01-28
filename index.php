<?php
/**
 * Template Name: Blog Index
 * Description: The template for displaying the Blog index /blog.
 *
 */

get_header();

$page_id = get_option( 'page_for_posts' );
?>
<?php echo get_the_fold(); ?>
<div class="row">
	<div class="col-md-12">
		<?php
			echo apply_filters( 'the_content', get_post_field( 'post_content', $page_id ) );

			edit_post_link( __( 'Edit', 'theme_main' ), '<span class="edit-link">', '</span>', $page_id );
		?>
	</div><!-- /.col -->
	<div class="col-md-12">
		<?php
			get_template_part( 'templates/archive/loop' );
		?>
	</div><!-- /.col -->
</div><!-- /.row -->
<?php
get_footer();
