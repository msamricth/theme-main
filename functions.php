<?php

/**
 * Main Theme Functions
 */

 if ( ! function_exists( 'theme_namespace' ) ) {
	/**
	 * General Theme Settings.
	 *
	 * @since v1.0
	 *
	 * This is the slug for the theme directory, i.e. the name of the folder as it sits inside the wp-content/themes directory
	 */
	function theme_namespace() {
		return 'Emm-theme-main';
	}
}

if ( ! function_exists( 'theme_identity' ) ) {
	/**
	 * General Theme Settings.
	 *
	 * @since v1.0
	 *
	 * This is the internal recognizer for the website i.e. the name of your company, an internal reference for your business, etc. This is used in areas such as block categories, prefix name for blocks, the theme options title, etc
	 */
	function theme_identity() {
		return 'Emm';
	}
}

// Included settings, filters, configs, options, add-ons and templates

$theme_customizer = __DIR__ . '/inc/customizer.php';
if ( is_readable( $theme_customizer ) ) {
	require_once $theme_customizer;
}
$enqueue = __DIR__ . '/inc/enqueue.php';
if ( is_readable( $enqueue ) ) {	require_once $enqueue;}

$theme_tweaks = __DIR__ . '/inc/tweaks.php';
if ( is_readable( $theme_tweaks ) ) {	require_once $theme_tweaks;}

$theme_functions = __DIR__ . '/inc/theme_functions.php';
if ( is_readable( $theme_functions ) ) {	require_once $theme_functions;}
