<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<link rel="preconnect" href="https://player.vimeo.com">
	<link rel="preconnect" href="https://i.vimeocdn.com">
	<link rel="preconnect" href="https://f.vimeocdn.com">
	<?php wp_head();
	$bodyClasses = get_bodyclasses();

	$nav_classes = '';
	$nav_placement = get_field('nav_placement', 'option');

	// Check if $nav_placement is empty
	if (empty($nav_placement)) {
		$nav_placement = 'ms-auto';
	}
	$nav_classes .= $nav_placement;

	?>

</head>

<body <?php body_class($bodyClasses); ?>>

	<?php wp_body_open(); ?>
	<a href="#main" class="visually-hidden-focusable">
		<?php esc_html_e('Skip to main content', theme_namespace()); ?>
	</a>
	<div class="scroller" data-scroller <?php echo get_scroller_attributes(); ?>>
		<div id="wrapper" <?php echo get_wrapper(); ?>>
			<header id="nav-header">
				<nav id="header" class="<?php echo get_nav_header('navbar navbar-expand-lg') ?>" <?php echo get_nav_attributes(); ?>>
					<div class="container">
						<?php echo get_navbrand(); ?>
						<button class="navbar-toggler ms-auto hamburger hamburger--<?php echo get_hamburger(); ?>"
							type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar"
							aria-expanded="false"
							aria-label="<?php esc_attr_e('Toggle navigation', theme_namespace()); ?>">
							<span class="hamburger-box">
								<span class="hamburger-inner"></span>
							</span>
						</button>

						<div id="navbar" class="collapse navbar-collapse">
							<?php
							// Loading WordPress Custom Menu (theme_location).
							wp_nav_menu(
								array(
									'theme_location' => 'main-menu',
									'container' => '',
									'menu_class' => 'navbar-nav ' . $nav_classes . ' mb-11 mb-md-0',
									'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
									'walker' => new WP_Bootstrap_Navwalker(),
								)
							);

							?>
							<?php if (is_active_sidebar('secondary_widget_area')): ?>
								<div class="widget-area d-flex">

								<?php dynamic_sidebar('secondary_widget_area');

								if (current_user_can('manage_options')):
									?>
									<span class="edit-link"><a href="<?php echo esc_url(admin_url('widgets.php')); ?>"
											class="badge bg-secondary">
											<?php esc_html_e('Edit', 'theme_main'); ?>
										</a></span><!-- Show Edit Widget link -->
									<?php
								endif;?>
								</div><!-- /.navbar-collapse -->
								<?php
							endif; ?>
						</div><!-- /.navbar-collapse -->

					</div><!-- /.container -->
				</nav><!-- /#header -->
			</header>
			<main id="main" class="main">
				<div class="<?php echo get_main_classes(); ?>">