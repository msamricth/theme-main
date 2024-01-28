<?php
$footer_background_image = get_field("footer_background_image","option");
$footer_options = '';

if( $footer_background_image ) {
	$footer_options =' has-background-image" style="background-image="url('.$footer_background_image.');';

}

?>
</div>
<?php echo get_the_fold(); ?>
</main><!-- /#main -->

<footer id="footer" <?php echo theme_main_footer_get_options('footer mt-gutter py-gutter'); ?>>

	<?php


	if (is_active_sidebar('third_widget_area')):
		?>
		<div class="col-md-12">
			<?php
			dynamic_sidebar('third_widget_area');

			if (current_user_can('manage_options')):
				?>
				<span class="edit-link"><a href="<?php echo esc_url(admin_url('widgets.php')); ?>" class="badge bg-secondary">
						<?php esc_html_e('Edit', 'theme_main'); ?>
					</a></span><!-- Show Edit Widget link -->
				<?php
			endif;
			?>
		</div>
		<?php
	endif;
	?>
</footer><!-- /#footer -->
</div><!-- /#wrapper -->
<?php
wp_footer();
?>
</body>

</html>