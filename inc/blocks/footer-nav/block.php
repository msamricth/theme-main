<?php
/**
 * Template file: inc/blocks/footer-nav/block.php
 *
 * Footer Nav Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$blockName = "Footer Nav";
$blockID = "footer-nav";
$classes = $blockID . " ";
$justify = "";
$navigation_stance = get_field('navigation_stance');
if (!empty($navigation_stance)) {
	$classes .= ' display-horizontal';
}
$justify = get_field('justify');
if (!empty($justify)) {
	$justify = " justify-content-" . $justify;
} else {
	$justify = "";
}

?>
<div <?php echo get_block_settings($block, $blockID, $classes); ?>>
	<?php

	if (has_nav_menu('footer-menu')):
		if ($navigation_stance) {
			wp_nav_menu(
				array(
					'theme_location' => 'footer-menu',
					'container' => 'nav',
					'container_class' => 'footer-nav ',
					'fallback_cb' => '',
					'items_wrap' => '<ul class="menu navbar-nav nav d-flex flex-row '.$justify.'">%3$s</ul>',
					//'fallback_cb'    => 'WP_Bootstrap4_Navwalker_Footer::fallback',
					'walker' => new WP_Bootstrap_Navwalker_Footer_horizontal(),
				)
			);
		} else {
			wp_nav_menu(
				array(
					'theme_location' => 'footer-menu',
					'container' => 'nav',
					'container_class' => 'footer-nav ',
					'fallback_cb' => '',
					'items_wrap' => '<ul class="menu navbar-nav nav d-block justify-content-end">%3$s</ul>',
					//'fallback_cb'    => 'WP_Bootstrap4_Navwalker_Footer::fallback',
					'walker' => new WP_Bootstrap4_Navwalker_Footer(),
				)
			);
		}

	endif;

	if (is_admin()) {
		// Runs only if this PHP code is in a file that displays outside the admin panels, like the theme template.
		echo "<button style='position: absolute;right: 10%;padding: 0.768rem;top: 20%;'>Click here to edit this " . $blockName . "</button>";
	}
	?>
</div>