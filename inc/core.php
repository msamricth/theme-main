<?php
/**
 * Template file: inc/core.php
 * Core functions for Theme Main
 *
 * @package Bootstrap Base
 * @since v1
 */

/**
 * Core Colors
 *
 * @since v1.0
 */
$core_colors = __DIR__ . '/core/colors.php';
if ( is_readable( $core_colors ) ) {
	require_once $core_colors;
}
/**
 * Core template tags
 *
 * @since v1.0
 */
$core_tags = __DIR__ . '/core/tags.php';
if ( is_readable( $core_tags ) ) {
	require_once $core_tags;
}


/**
 * Utilities
 * @since v1.0
 */
$core_utils = __DIR__ . '/core/utilities.php';
if ( is_readable( $core_utils ) ) {
	require_once $core_utils;
}


/**
 * Theme Supports
 * @since v1.0
 */
$core_theme_support = __DIR__ . '/core/theme-support.php';
if ( is_readable( $core_theme_support ) ) {
	require_once $core_theme_support;
}

/**
 * Page header
 * @since v1.0
 */
$core_header = __DIR__ . '/core/head.php';
if ( is_readable( $core_header ) ) {
	require_once $core_header;
}


/**
 * The Footer options
 * @since v1.0
 */
$core_footer = __DIR__ . '/core/footer.php';
if ( is_readable( $core_footer ) ) {
	require_once $core_footer;
}


/**
 * Load Nav functions on the front end
 * @since v1.6
 * 
 * WHile it seems unlikely, this file is causing a issue for the medit edit stuff in wordpress.
 */
if ( ! is_admin() ) {
    $core_nav = __DIR__ . '/navs/nav.php';
    if ( is_readable( $core_nav ) ) {
        require_once $core_nav;
    }
}


/**
 * Widgets
 * @since v1.0
 */
$core_widgets = __DIR__ . '/core/widgets.php';
if ( is_readable( $core_widgets ) ) {
	require_once $core_widgets;
}


/**
 * Sidebar
 * @since v1.0
 */

/**
 * Blocks and Block settings
 * @since v1.0
 */
$theme_main_block_settings = __DIR__ . '/core/blocks.php';
if ( is_readable( $theme_main_block_settings ) ) {	require_once $theme_main_block_settings;}