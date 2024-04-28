<?php
/**
 * Template file: inc/core/utilities.php
 * Utilities for Theme Main
 *
 * @package Bootstrap Base
 * @since v1
 */


/** PHP color stuff - trying to take it easy on browser side JS */
if (!function_exists('HTMLToRGB')):
	function HTMLToRGB($htmlCode)
	{
		if (isset ($htmlCode)) {
			if (is_string($htmlCode) && !empty ($htmlCode)) {
				if ($htmlCode[0] == '#') {
					$htmlCode = substr($htmlCode, 1);
				}

				if (strlen($htmlCode) == 3) {
					$htmlCode = $htmlCode[0] . $htmlCode[0] . $htmlCode[1] . $htmlCode[1] . $htmlCode[2] . $htmlCode[2];
				}

				if (strlen($htmlCode) == 6) { // Ensure the string has correct length after modifications
					$r = hexdec($htmlCode[0] . $htmlCode[1]);
					$g = hexdec($htmlCode[2] . $htmlCode[3]);
					$b = hexdec($htmlCode[4] . $htmlCode[5]);

					$srftidu = $b + ($g << 0x8) + ($r << 0x10);
					return $r . ', ' . $g . ', ' . $b;
				}
			} else {
				return 'error utitlities line-34 ' . $htmlCode; // so we can figure out what it is.
			}
		} else {

			// Return default values if input is invalid or empty
			$r = 'cant';
			$g = 'find';
			$b = 'hexcode';
			return $r . ', ' . $g . ', ' . $b;
		}
	}
endif;

function adjustBrightness($hexCode, $adjustPercent)
{
	$hexCode = ltrim($hexCode, '#');

	if (strlen($hexCode) == 3) {
		$hexCode = $hexCode[0] . $hexCode[0] . $hexCode[1] . $hexCode[1] . $hexCode[2] . $hexCode[2];
	}

	$hexCode = array_map('hexdec', str_split($hexCode, 2));

	foreach ($hexCode as &$color) {
		$adjustableLimit = $adjustPercent < 0 ? $color : 255 - $color;
		$adjustAmount = ceil($adjustableLimit * $adjustPercent);

		$color = str_pad(dechex($color + $adjustAmount), 2, '0', STR_PAD_LEFT);
	}

	return '#' . implode($hexCode);
}
if (!function_exists('HTMLToRGBforComparison')):
	function HTMLToRGBforComparison($htmlCode)
	{
		if (isset ($htmlCode)) {
			if ($htmlCode[0] == '#')
				$htmlCode = substr($htmlCode, 1);

			if (strlen($htmlCode) == 3) {
				$htmlCode = $htmlCode[0] . $htmlCode[0] . $htmlCode[1] . $htmlCode[1] . $htmlCode[2] . $htmlCode[2];
			}

			$r = hexdec($htmlCode[0] . $htmlCode[1]);
			$g = hexdec($htmlCode[2] . $htmlCode[3]);
			$b = hexdec($htmlCode[4] . $htmlCode[5]);

			$srftidu = $b + ($g << 0x8) + ($r << 0x10);
			return $b + ($g << 0x8) + ($r << 0x10);
		} else {
			$r = 'cant';
			$g = 'find';
			$b = 'hexcode';
			return $r . ' ' . $g . ' ' . $b;
		}
	}
endif;


if (!function_exists('RGBToHSL')):
	function RGBToHSL($RGB)
	{
		$r = 0xFF & ($RGB >> 0x10);
		$g = 0xFF & ($RGB >> 0x8);
		$b = 0xFF & $RGB;

		$r = ((float) $r) / 255.0;
		$g = ((float) $g) / 255.0;
		$b = ((float) $b) / 255.0;

		$maxC = max($r, $g, $b);
		$minC = min($r, $g, $b);

		$l = ($maxC + $minC) / 2.0;

		if ($maxC == $minC) {
			$s = 0;
			$h = 0;
		} else {
			if ($l < .5) {
				$s = ($maxC - $minC) / ($maxC + $minC);
			} else {
				$s = ($maxC - $minC) / (2.0 - $maxC - $minC);
			}
			if ($r == $maxC)
				$h = ($g - $b) / ($maxC - $minC);
			if ($g == $maxC)
				$h = 2.0 + ($b - $r) / ($maxC - $minC);
			if ($b == $maxC)
				$h = 4.0 + ($r - $g) / ($maxC - $minC);

			$h = $h / 6.0;
		}

		$h = (int) round(255.0 * $h);
		$s = (int) round(255.0 * $s);
		$l = (int) round(255.0 * $l);

		return (object) array('hue' => $h, 'saturation' => $s, 'lightness' => $l);
	}

endif;

if (!function_exists('get_match_nav')):
	/**
	 * "Theme posted on" pattern.
	 *
	 * @since v7.6
	 */
	function get_match_nav($custom = null)
	{
		if (isset ($custom)) {
			$scheme = $custom;
		} else {
			$scheme = get_field('background_color', get_theme_main_postID());
		}
		if ($scheme) {
			$scheme = 'match-nav match_' . $scheme . ' ';
		} else {
			$scheme = 'match-nav match_light';
		}
		return $scheme;
	}

endif;

if (!function_exists('get_scheme')):
	/**
	 * "Theme posted on" pattern.
	 *
	 * @since v7.6
	 */
	function get_scheme($custom = null)
	{
		if (isset ($custom)) {
			$scheme = $custom;
		} else {
			$scheme = get_field('background_color', get_theme_main_postID());
		}
		if ($scheme) {
			$scheme = 'bg-' . $scheme . ' ';
		} else {
			$scheme = 'bg-light';
		}
		return $scheme;
	}

endif;
if (!function_exists('get_scheme_new')):
	/**
	 * "Theme posted on" pattern.
	 *
	 * @since v7.6
	 */
	function get_scheme_new($custom = null, $postID = null)
	{

		if (empty ($postID)) {
			$postID = get_theme_main_postID();
		}
		if (isset ($custom)) {
			$scheme = $custom;
		} else {
			$scheme = get_field('background_color', $postID);
		}
		if (empty ($scheme)) {
			$scheme = 'light';
		}
		return $scheme;
	}

endif;


function acf_append_color_choices($field)
{
	// Get values from repeater field in Field Group A
	$repeater_values = get_field('extra_colors', 'option');

	// Check if values exist
	if ($repeater_values) {
		// Loop through repeater values and add them as choices
		foreach ($repeater_values as $color) {
			// Replace white spaces with underscores in the color label
			$label = slugify($color['color_label']);

			// Add color to choices array
			$field['choices'][$label] = $color['color_label'];
		}
	}

	// Return the modified field
	return $field;
}

// Hook into acf/load_field and apply the function to your select fields
add_filter('acf/load_field/name=background_color', 'acf_append_color_choices');
add_filter('acf/load_field/name=navbar_color_settings', 'acf_append_color_choices');
add_filter('acf/load_field/name=footer_background_color', 'acf_append_color_choices');
add_filter('acf/load_field/name=footer_background_graident_top', 'acf_append_color_choices');
add_filter('acf/load_field/name=footer_background_graident_bottom', 'acf_append_color_choices');
add_filter('acf/load_field/name=button_background', 'acf_append_color_choices');



if (!function_exists('theme_main_get_ratio')):
	/**
	 * "Theme posted on" pattern.
	 *
	 * @since v1.7
	 */

	function theme_main_get_ratio($content, $ratio, $extras = null)
	{
		enqueue_header_markup(customRatio($ratio));
		$classes = ' ratio-' . $ratio;
		return '<div class="ratio ' . $classes . '>' . $content . '</div>';

	}
endif;

if (!function_exists('theme_main_get_block_ratio')):
	/**
	 *
	 * @since v1.7
	 */

	function theme_main_get_block_ratio($content, $ratio, $block, $blockID, $classes)
	{
		enqueue_header_markup(customRatio($ratio));
		$classes .= 'ratio ratio-' . $ratio;
		return '<div ' . get_block_settings($block, $blockID, $classes) . '>' . $content . '</div>';

	}
endif;


if (!function_exists('customRatio')):
	/**
	 * "Theme posted on" pattern.
	 *
	 * @since v3.6 updated v9
	 */

	function customRatio($ratio)
	{
		if ($ratio) {
			$blockStyles = '';
			// Use preg_match_all() function to check match
			preg_match_all('!\d+\.*\d*!', $ratio, $ratiomatches);
			$i = 0;
			$ratioWidth = '';
			$ratioHeight = '';
			foreach ($ratiomatches as $ratiomatch) {
				foreach ($ratiomatch as $ratiom) {
					if ($i == 0) {
						$ratioWidth = $ratiom;
					} else {
						$ratioHeight = $ratiom;
					}
					$i++;
				}
			}
			if ($ratiomatches) {
				if (empty ($ratioWidth)) {
					if (empty ($ratioHeight)) {
						if (strpos($ratio, '.') !== false) {
							list($ratioWidth, $ratioHeight) = preg_split("/x/", $ratio);
							$ratioWidth = preg_replace("/[^0-9\.]/", '', $ratioWidth);
						}
					}
				}
			}
			$presetRatios = array('21x9', '16x9', '4x3', '3x2', 'fullw');
			if (strpos(implode(" ", $presetRatios), $ratio) !== false) {
			} else {
				$ratio = str_replace('.', '\.', $ratio);
				$blockStyles .= '<style type="text/css">';
				$blockStyles .= '.' . $ratio . ':before, .ratio-' . $ratio . ':before {';
				$blockStyles .= '  --bs-aspect-ratio: calc(' . $ratioHeight . ' / ' . $ratioWidth . ' * 100%);';
				$blockStyles .= '} </style>';
				return $blockStyles;
			}
		}
	}
endif;

if (!function_exists('theme_main_oembed_filter')):
	/**
	 * Responsive oEmbed filter: https://getbootstrap.com/docs/5.0/helpers/ratio
	 *
	 * @since v1.0
	 */
	function theme_main_oembed_filter($html)
	{
		return '<div class="ratio ratio-16x9">' . $html . '</div>';
	}
endif;
add_filter('embed_oembed_html', 'theme_main_oembed_filter', 10, 4);

function get_theme_main_postID()
{
	$output = '';
	$post_id = '';
	$current_post = get_queried_object();
	$post_id = $current_post ? $current_post->ID : null;

	if ($post_id) {
		$output = $post_id;
		return $output;
	}
}


if (!function_exists('wp_body_open')) {
	/**
	 * Fire the wp_body_open action.
	 *
	 * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
	 *
	 * @since v2.2
	 *
	 * @return void
	 */
	function wp_body_open()
	{
		do_action('wp_body_open');
	}
}


/**
 * Test if a page is a blog page.
 * if ( is_blog() ) { ... }
 *
 * @since v1.0
 *
 * @return bool
 */
function is_blog()
{
	global $post;
	$posttype = get_post_type($post);

	return ((is_archive() || is_author() || is_category() || is_home() || is_single() || (is_tag() && ('post' === $posttype))) ? true : false);
}

/**
 * Disable comments for Media (Image-Post, Jetpack-Carousel, etc.)
 *
 * @since v1.0
 *
 * @param bool $open    Comments open/closed.
 * @param int  $post_id Post ID.
 *
 * @return bool
 */
function theme_main_filter_media_comment_status($open, $post_id = null)
{
	$media_post = get_post($post_id);

	if ('attachment' === $media_post->post_type) {
		return false;
	}

	return $open;
}
add_filter('comments_open', 'theme_main_filter_media_comment_status', 10, 2);



/**
 * Responsive oEmbed filter: https://getbootstrap.com/docs/5.0/helpers/ratio
 *
 * @since v1.0
 *
 * @param string $html Inner HTML.
 *
 * @return string
 */
function theme_main_oembed_filter($html)
{
	return '<div class="ratio ratio-16x9">' . $html . '</div>';
}
add_filter('embed_oembed_html', 'theme_main_oembed_filter', 10);



if (!function_exists('theme_main_add_user_fields')) {
	/**
	 * Add new User fields to Userprofile:
	 * get_user_meta( $user->ID, 'facebook_profile', true );
	 *
	 * @since v1.0
	 *
	 * @param array $fields User fields.
	 *
	 * @return array
	 */
	function theme_main_add_user_fields($fields)
	{
		// Add new fields.
		$fields['facebook_profile'] = 'Facebook URL';
		$fields['twitter_profile'] = 'Twitter URL';
		$fields['linkedin_profile'] = 'LinkedIn URL';
		$fields['xing_profile'] = 'Xing URL';
		$fields['github_profile'] = 'GitHub URL';

		return $fields;
	}
	add_filter('user_contactmethods', 'theme_main_add_user_fields');
}


if (!function_exists('theme_main_article_posted_on')) {
	/**
	 * "Theme posted on" pattern.
	 *
	 * @since v1.0
	 */
	function theme_main_article_posted_on()
	{
		printf(
			wp_kses_post(__('<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author-meta vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', theme_namespace())),
			esc_url(get_the_permalink()),
			esc_attr(get_the_date() . ' - ' . get_the_time()),
			esc_attr(get_the_date('c')),
			esc_html(get_the_date() . ' - ' . get_the_time()),
			esc_url(get_author_posts_url((int) get_the_author_meta('ID'))),
			sprintf(esc_attr__('View all posts by %s', theme_namespace()), get_the_author()),
			get_the_author()
		);
	}
}

/**
 * Template for Password protected post form.
 *
 * @since v1.0
 *
 * @return string
 */
function theme_main_password_form()
{
	global $post;
	$label = 'pwbox-' . (empty ($post->ID) ? rand() : $post->ID);

	$output = '<div class="row">';
	$output .= '<form action="' . esc_url(site_url('wp-login.php?action=postpass', 'login_post')) . '" method="post">';
	$output .= '<h4 class="col-md-12 alert alert-warning">' . esc_html__('This content is password protected. To view it please enter your password below.', theme_namespace()) . '</h4>';
	$output .= '<div class="col-md-6">';
	$output .= '<div class="input-group">';
	$output .= '<input type="password" name="post_password" id="' . esc_attr($label) . '" placeholder="' . esc_attr__('Password', theme_namespace()) . '" class="form-control" />';
	$output .= '<div class="input-group-append"><input type="submit" name="submit" class="btn btn-primary" value="' . esc_attr__('Submit', theme_namespace()) . '" /></div>';
	$output .= '</div><!-- /.input-group -->';
	$output .= '</div><!-- /.col -->';
	$output .= '</form>';
	$output .= '</div><!-- /.row -->';

	return $output;
}
add_filter('the_password_form', 'theme_main_password_form');


if (!function_exists('theme_main_duplicate_post_link')) {
	function theme_main_duplicate_post_link($actions, $post)
	{
		if (current_user_can('edit_posts')) {
			$duplicate_url = admin_url('admin.php?action=theme_main_duplicate_post&amp;post=' . $post->ID . '&amp;nonce=' . wp_create_nonce('theme_main_duplicate_post_nonce'));

			$actions['duplicate'] = '<a href="' . esc_url($duplicate_url) . '" title="' . esc_attr__('Duplicate this item', 'theme_main') . '">' . __('Duplicate', 'theme_main') . '</a>';
		}

		return $actions;
	}

	add_filter('post_row_actions', 'theme_main_duplicate_post_link', 10, 2);
	add_filter('page_row_actions', 'theme_main_duplicate_post_link', 10, 2);
	add_filter('page_row_actions', 'theme_main_duplicate_post_link', 10, 2);
}

if (!function_exists('theme_main_duplicate_post')) {
	function theme_main_duplicate_post()
	{
		// Check for nonce security
		if (!isset ($_GET['nonce']) || !wp_verify_nonce($_GET['nonce'], 'theme_main_duplicate_post_nonce')) {
			return;
		}

		// Check if user has proper permissions
		if (!current_user_can('edit_posts')) {
			return;
		}

		// Get the original post ID
		$post_id = (isset ($_GET['post'])) ? absint($_GET['post']) : '';

		if (empty ($post_id)) {
			return;
		}

		// Get the original post
		$post = get_post($post_id);

		// Duplicate the post
		$new_post_id = wp_insert_post(
			array(
				'post_title' => $post->post_title . ' (Duplicate)',
				'post_content' => $post->post_content,
				'post_status' => $post->post_status,
				'post_type' => $post->post_type,
				'post_author' => get_current_user_id(),
			)
		);

		// Duplicate post meta
		$post_meta = get_post_meta($post_id);
		foreach ($post_meta as $key => $value) {
			update_post_meta($new_post_id, $key, maybe_unserialize($value[0]));
		}

		// Redirect to the edit screen of the new duplicate post
		wp_redirect(admin_url('post.php?action=edit&post=' . $new_post_id));
		exit;
	}

	add_action('admin_action_theme_main_duplicate_post', 'theme_main_duplicate_post');
}


if (!function_exists('theme_main_seperate_characters')) {
	function theme_main_seperate_characters($inputString)
	{
		// Check if the input string is null or empty
		//if ($inputString === null || $inputString === '') {
		//return;
		//}

		// Split the input string into an array of characters
		$characters = preg_split('/(?<!^)(?!$)/u', $inputString);

		// Print each character wrapped in a <span>
		foreach ($characters as $character) {
			echo "<span>$character</span>";
		}
	}
}
function filter_block_categories_when_post_provided($block_categories, $editor_context)
{
	if (!empty ($editor_context->post)) {
		array_push(
			$block_categories,
			array(
				'slug' => 'theme-main',
				'title' => __('Theme Main', 'Theme provided blocks'),
				'icon' => null,
			)
		);
	}
	return $block_categories;
}

add_filter('block_categories_all', 'filter_block_categories_when_post_provided', 10, 2);
function custom_block_category($categories)
{
	$custom_block = array(
		'slug' => 'theme-main',
		'title' => __('Theme Main', 'Theme provided blocks'),
	);

	$categories_sorted = array();
	$categories_sorted[0] = $custom_block;

	foreach ($categories as $category) {
		$categories_sorted[] = $category;
	}

	return $categories_sorted;
}
add_filter('block_categories_all', 'custom_block_category', 10, 2);

if (!function_exists('theme_main_check_for_unit')) {
	function theme_main_check_for_unit($demension)
	{

		$unitOfMeasurement = array("px", "pc", "pt", "%", "em", "rem", "vh", "vw", "lh", "rlh", "vb", "vi", "svw", "svh", "lvw", "lvh", "dvw", "dvh", "auto");

		// Regular expression pattern to match any unit of measurement
		$pattern = '/\b(?:' . implode('|', $unitOfMeasurement) . ')\b/i';

		// Check if width contains a unit of measurement
		if (preg_match($pattern, $demension)) {
			return $demension;
		} else {
			if (str_contains($demension, '%')) { //because the first filter keeps missing percentages
				return $demension;
			} else {
				return $demension . 'px';
			}
		}


	}
}


if (!function_exists('theme_main_option_fields')) {
	function theme_main_option_fields($style, $terms, $filter_label, $classes, $aria = null)
	{
		$post_id = get_theme_main_postID();
		$field = '';
		switch ($style) {
			case 'select':
				$classes .= ' form-select';
				$field .= '<select name="' . $style . '" class="' . $classes . '" data-post-id="'.$post_id.'" aria-label="Filter by ' . $filter_label . '" id="' . slugify($filter_label) . '-filter">';
				$field .= '<option value="">All ' . $filter_label . '</option>';
				foreach ($terms as $term) {
					$field .= '<option value="' . esc_attr($term->term_id) . '">' . esc_html($term->name) . '</option>';
				}
				$field .= '</select>';
				break;
			case 'multiple-select':
				$classes .= ' form-select';
				$field .= '<select name="' . $style . '" class="' . $classes . '" multiple data-post-id="'.$post_id.'" aria-label="Filter by ' . $filter_label . '" id="' . slugify($filter_label) . '-filter">';
				foreach ($terms as $term) {
					$field .= '<option value="' . esc_attr($term->term_id) . '">' . esc_html($term->name) . '</option>';
				}
				$field .= '</select>';
				break;
			case 'checkbox':
				$classes .= ' form-check-input';
				$field .= '<div class="form-check-container" id="' . slugify($filter_label) . '-filter">';
				foreach ($terms as $term) {
					$field .= '<div class="form-check mb-3" id="term-' . esc_attr($term->term_id) . '">';
					$field .= '<input class="' . $classes . '" type="checkbox" data-post-id="'.$post_id.'" name="' . $term->slug . '" value="' . esc_attr($term->term_id) . '" id="term-' . esc_attr($term->term_id) . '">';
					$field .= '<label class="form-check-label" for="term-' . esc_attr($term->term_id) . '">' . esc_html($term->name) . '</label>';
					$field .= '</input>';
					$field .= '</div>';
				}
				$field .= '</div>';
				break;
			case 'radio':
				$classes .= ' form-check-input';
				$field .= '<div class="form-check-container" id="' . slugify($filter_label) . '-filter">';
				foreach ($terms as $term) {
					$field .= '<div class="form-check mb-3" id="term-' . esc_attr($term->term_id) . '">';
					$field .= '<input class="' . $classes . '" type="radio" data-post-id="'.$post_id.'" name="' . $term->slug . '" value="' . esc_attr($term->term_id) . '" id="term-' . esc_attr($term->term_id) . '">';
					$field .= '<label class="form-check-label" for="term-' . esc_attr($term->term_id) . '">' . esc_html($term->name) . '</label>';
					$field .= '</input>';
					$field .= '</div>';
				}
				$field .= '</div>';
				break;
			default:
				// Handle unsupported styles or fallback to a default style
				break;
		}
		return $field;
	}
}
add_action('acfe/fields/button/name=set_featured_image', 'theme_main_header_update_FI', 10, 2);
function theme_main_header_update_FI($field, $post_id){

    // retrieve field input value 'my_field'
    $my_field = get_field('set_featured_image');
    
    // send json success message
    wp_send_json_success("Success! Field value is: {$my_field}");
    
}