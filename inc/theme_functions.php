<?php
/**
 * Template file: inc/theme_functions.php
 * Core functions and template tags for Theme Main
 *
 * @package Bootstrap Base
 * @since v3
 */

 /**
 * Include Support for Advance Custom Fields Pro.
 * 
 * @since v1.0
 */
 // Define path and URL to the ACF plugin.
define( 'MY_ACF_PATH', get_template_directory() . '/inc/acf/plugin/' );
define( 'MY_ACF_URL', get_template_directory_uri() . '/inc/acf/plugin/' );

// Include the ACF plugin.
include_once( MY_ACF_PATH . 'acf.php' );

// Customize the url setting to fix incorrect asset URLs.
add_filter('acf/settings/url', 'my_acf_settings_url');
function my_acf_settings_url( $url ) {    return MY_ACF_URL; }

// (Optional) Hide the ACF admin menu item.
// add_filter('acf/settings/show_admin', 'my_acf_settings_show_admin');
function my_acf_settings_show_admin( $show_admin ) { return false; }


//load custom acf upgrades
$theme_ACFPUpgrades = __DIR__ . '/acf/acf-theme_main_upgrades.php';

// Load Supply ACF Content
$theme_ACFProFields = __DIR__ . '/acf/acf_fields.php';
$theme_ACFProBlocks = __DIR__ . '/acf/acf_blocks.php';
$theme_ACFProCPTS = __DIR__ . '/acf/acf_cpts.php';
//$theme_ACFProDIR  = __DIR__ . '/acf/';

//if ( is_readable( $theme_ACFPUpgrades ) ) {	require_once $theme_ACFPUpgrades;}
if ( is_readable( $theme_ACFProFields ) ) {	require_once $theme_ACFProFields;}
if ( is_readable( $theme_ACFProBlocks ) ) {	require_once $theme_ACFProBlocks;}
if ( is_readable( $theme_ACFProCPTS ) ) {	require_once $theme_ACFProCPTS;}


$theme_plugins = __DIR__ . '/tgma.php';
if ( is_readable( $theme_plugins ) ) {	require_once $theme_plugins;}

/**
 * Include Theme Functions and Template Tags.
 *
 * @since v3
 */

$theme_main_media_setting = __DIR__ . '/media/components.php';
if ( is_readable( $theme_main_media_setting ) ) {	require_once $theme_main_media_setting;}

$theme_main_media_utilities = __DIR__ . '/media/utilities.php';
if ( is_readable( $theme_main_media_utilities ) ) {	require_once $theme_main_media_utilities;}

$theme_main_media_video = __DIR__ . '/media/video.php';
if ( is_readable( $theme_main_media_video ) ) {	require_once $theme_main_media_video;}

//$theme_main_setup = __DIR__ . '/core/one-time-functions.php';
//if ( is_readable( $theme_main_setup ) ) {	require_once $theme_main_setup;}

$theme_main_core = __DIR__ . '/core.php';
if ( is_readable( $theme_main_core ) ) {	require_once $theme_main_core;}