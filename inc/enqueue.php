<?php
/**
 * Template file: inc/enqueue.php
 * Settings that came with the orginal Boiler point
 *
 * @package Bootstrap Base
 * @since v1
 */

/**
 * Loading All CSS Stylesheets and Javascript Files.
 *
 * @since v1.0
 */

function theme_main_styles_loader() {
	$theme_version = wp_get_theme()->get( 'Version' );

	// 1. Styles.
	wp_enqueue_style( 'style', get_theme_file_uri( 'style.css' ), array(), $theme_version, 'all' );
	wp_enqueue_script(
		'fontawesome', 'https://kit.fontawesome.com/8b0174b394.js','',
		true
	);
	wp_enqueue_style( 'main', get_theme_file_uri( 'build/main.css' ), array(), $theme_version, 'all' ); // main.scss: Compiled Framework source + custom styles.

	wp_enqueue_script(
		'vimeo', 'https://player.vimeo.com/api/player.js',
		['jquery'],
		true
	);
	if ( is_rtl() ) {
		wp_enqueue_style( 'rtl', get_theme_file_uri( 'assets/css/rtl.css' ), array(), $theme_version, 'all' );
	}

	
}
add_action( 'wp_enqueue_scripts', 'theme_main_styles_loader' );
function theme_main_scripts_loader() {
	$theme_version = wp_get_theme()->get( 'Version' );
	//if ( get_post_type() === 'service-offerings' ) { }
	if(check_if_block_exist('acf/supply-lottie-block')) {
		wp_enqueue_script( 'lottie-player', "https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js", array(), $theme_version, true );
	}
	wp_enqueue_script( 'mainjs', get_theme_file_uri( 'build/main.js' ), array(), $theme_version, true );
	if(check_if_block_exist('acf/supply-carousel-block')) {
//		wp_enqueue_script( 'splide', "https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js", array(), $theme_version, true );
	}

	
}
add_action( 'wp_enqueue_scripts', 'theme_main_scripts_loader', 100);

add_filter( 'script_loader_tag', 'my_scripts_modifier', 10, 3 );
function my_scripts_modifier( $tag, $handle, $src ) {
    if ( 'splide' === $handle ) {
        return '<script defer src="' . $src . '" type="text/javascript" integrity="sha256-FZsW7H2V5X9TGinSjjwYJ419Xka27I8XPDmWryGlWtw=" crossorigin="anonymous"></script>' . "\n";
    }
    return $tag;
}


function be_gutenberg_scripts() {
	wp_enqueue_script( 'theme-editor', get_template_directory_uri() . '/assets/js/editor.js', array( 'wp-blocks', 'wp-dom', 'wp-edit-post','acf' ), filemtime( get_template_directory() . '/assets/js/editor.js' ), true );
}
add_action( 'enqueue_block_editor_assets', 'be_gutenberg_scripts' );
add_action('enqueue_block_editor_assets', function() {
	wp_enqueue_script('awp-gutenberg-filters', get_template_directory_uri() . '/assets/js/gutenberg-filters.js', array( 'wp-blocks', 'wp-dom', 'wp-edit-post','acf' ));
});
