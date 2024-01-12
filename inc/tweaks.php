<?php
// Add to existing function.php file
// Disable support for comments and trackbacks in post types
function df_disable_comments_post_types_support() {
    $post_types = get_post_types();
    foreach ($post_types as $post_type) {
        if(post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
}
add_action('admin_init', 'df_disable_comments_post_types_support');
// Close comments on the front-end
function df_disable_comments_status() {
    return false;
}
add_filter('comments_open', 'df_disable_comments_status', 20, 2);
add_filter('pings_open', 'df_disable_comments_status', 20, 2);
// Hide existing comments
function df_disable_comments_hide_existing_comments($comments) {
    $comments = array();
    return $comments;
}
add_filter('comments_array', 'df_disable_comments_hide_existing_comments', 10, 2);
// Remove comments page in menu
function df_disable_comments_admin_menu() {
    remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'df_disable_comments_admin_menu');
// Redirect any user trying to access comments page
function df_disable_comments_admin_menu_redirect() {
    global $pagenow;
    if ($pagenow === 'edit-comments.php') {
        wp_redirect(admin_url()); exit;
    }
}
add_action('admin_init', 'df_disable_comments_admin_menu_redirect');
// Remove comments metabox from dashboard
function df_disable_comments_dashboard() {
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
}
add_action('admin_init', 'df_disable_comments_dashboard');
// Remove comments links from admin bar
function df_disable_comments_admin_bar() {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
}
add_action('init', 'df_disable_comments_admin_bar');
/**
 * Gutenberg scripts and styles
 *
 */

/**
 * Enqueue footer markup in WP at lowest priority.
 * Convenience function!
 *
 * @param $markup
 */

 function enqueue_footer_styles($markup){
    $markup = '<style>'.$markup.'</style>';
	add_action('wp_footer', function () use ($markup){
		echo $markup;
	}, 99, 1);
}
function enqueue_footer_markup($markup){
	add_action('wp_footer', function () use ($markup){
		echo $markup;
	}, 99, 1);
}
function randClassName($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}
/**
 * Enqueue footer markup in WP at lowest priority.
 * Convenience function!
 *
 * @param $markup
*
*function enqueue_header_markup($markup){
*	add_action('wp_head', function () use ($markup){
*		echo $markup;
*	}, 10, 1);
*}
 */
function enqueue_header_markup($markup){
  
  add_action( 'wp_head', function() {echo $markup;} );
}
//add_action('wp_head', 'enqueue_header_markup', 9);
function my_acf_admin_head() {
    ?>

    <?php
}

add_action('acf/input/admin_head', 'my_acf_admin_head');
add_filter('wpcf7_form_elements', function($content) {

    $content = preg_replace('/<(span).*?class="\s*(?:.*\s)?wpcf7-form-control-wrap(?:\s[^"]+)?\s*"[^\>]*>(.*)<\/\1>/i', '\2', $content);
    $content = str_replace('<br />', '', $content);
    
    return $content;
});
// Remove <p> and <br/> from Contact Form 7
add_filter('wpcf7_autop_or_not', '__return_false');


function is_page_php(){
    if ( is_page_template( 'page.php' ) ) { return 'true';}
}
function add_slug_body_class( $classes ) {
    global $post;
    if ( isset( $post ) ) {
        $classes[] = $post->post_type . '-' . $post->post_name;
    }
    if ( is_single() && 'post' == get_post_type() ) {
        $classes[] = 'supply-articles';
    }
    return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );

function add_categories_to_pages() {
    register_taxonomy_for_object_type( 'category', 'page' );
}
add_action( 'init', 'add_categories_to_pages' );
function add_tags_to_pages() {
    register_taxonomy_for_object_type( 'post_tag', 'page' );
}
add_action( 'init', 'add_tags_to_pages');

function hide_search_widget() {
    unregister_widget('WP_Widget_Search');
}
add_action( 'widgets_init', 'hide_search_widget' );

add_filter('acf/upload_prefilter/name=images_optional', 'images_optional_upload_prefilter');
function images_optional_upload_prefilter($errors) {
  // in this filter we add a WP filter that alters the upload path
  add_filter('upload_dir', 'images_optional_upload_dir');
  return $errors;
}
// second filter
function images_optional_upload_dir($uploads) {
  // here is where we later the path
  $uploads['path'] = $uploads['path'].'/images';
  $uploads['url'] = $uploads['url'].'/images';
  $uploads['subdir'] = '';
  return $uploads;
}
function enable_svg_upload( $upload_mimes ) {
    $upload_mimes['svg'] = 'image/svg+xml';
    $upload_mimes['svgz'] = 'image/svg+xml';
    $upload_mimes['json'] = 'application/json';
    return $upload_mimes;
}
add_filter( 'upload_mimes', 'enable_svg_upload', 10, 1 );

if ( ! function_exists( 'slugify' ) ) :
	/**
	 * "Theme posted on" pattern.
	 *
	 * @since v7.7
	 */
	function slugify($text, string $divider = '-')
    {
      // replace non letter or digits by divider
      $text = preg_replace('~[^\pL\d]+~u', $divider, $text);
    
      // transliterate
      $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    
      // remove unwanted characters
      $text = preg_replace('~[^-\w]+~', '', $text);
    
      // trim
      $text = trim($text, $divider);
    
      // remove duplicate divider
      $text = preg_replace('~-+~', $divider, $text);
    
      // lowercase
      $text = strtolower($text);
    
      if (empty($text)) {
        return 'n-a';
      }
    
      return $text;
    }

endif;