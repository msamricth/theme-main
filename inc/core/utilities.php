<?php
/**
 * Template file: inc/core/utilities.php
 * Utilities for the Supply Theme
 *
 * @package Bootstrap Base
 * @since v1
 */


/** PHP color stuff - trying to take it easy on browser side JS */
if (!function_exists('HTMLToRGB')):
	function HTMLToRGB($htmlCode)
	{
		if ($htmlCode[0] == '#')
			$htmlCode = substr($htmlCode, 1);

		if (strlen($htmlCode) == 3) {
			$htmlCode = $htmlCode[0] . $htmlCode[0] . $htmlCode[1] . $htmlCode[1] . $htmlCode[2] . $htmlCode[2];
		}

		$r = hexdec($htmlCode[0] . $htmlCode[1]);
		$g = hexdec($htmlCode[2] . $htmlCode[3]);
		$b = hexdec($htmlCode[4] . $htmlCode[5]);

		$srftidu = $b + ($g << 0x8) + ($r << 0x10);
		return $r . ', ' . $g . ', ' . $b;
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


if (!function_exists('get_scheme')):
	/**
	 * "Theme posted on" pattern.
	 *
	 * @since v7.6
	 */
	function get_scheme($custom = null)
	{
		$output = '';
		if (isset($custom)) {
			$scheme = $custom;
		} else {
			$scheme = get_field('background_color');
		}
		if ($scheme) {
			if (strpos($scheme, 'dots') !== false) {
				$bodyClasses .= ' dots_on ';
				$scheme = 'bg-light bg-pattern';
				// }elseif(strpos($scheme, 'offerings') !== false){
				//   $scheme = 'bg-dark bg-offerings';
			} else {
				$scheme = 'bg-' . $scheme . ' ';
			}
		} else {
			$scheme = 'bg-light';
		}
		return $scheme;
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
				if (empty($ratioWidth)) {
					if (empty($ratioHeight)) {
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

if (!function_exists('theme_main_content_nav')) {
	/**
	 * Display a navigation to next/previous pages when applicable.
	 *
	 * @since v1.0
	 *
	 * @param string $nav_id Navigation ID.
	 */
	function theme_main_content_nav($nav_id)
	{
		global $wp_query;

		if ($wp_query->max_num_pages > 1) {
			?>
			<div id="<?php echo esc_attr($nav_id); ?>" class="d-flex mb-4 justify-content-between">
				<div>
					<?php next_posts_link('<span aria-hidden="true">&larr;</span> ' . esc_html__('Older posts', theme_namespace())); ?>
				</div>
				<div>
					<?php previous_posts_link(esc_html__('Newer posts', theme_namespace()) . ' <span aria-hidden="true">&rarr;</span>'); ?>
				</div>
			</div><!-- /.d-flex -->
			<?php
		} else {
			echo '<div class="clearfix"></div>';
		}
	}

	/**
	 * Add Class.
	 *
	 * @since v1.0
	 *
	 * @return string
	 */
	function posts_link_attributes()
	{
		return 'class="btn btn-secondary btn-lg"';
	}
	add_filter('next_posts_link_attributes', 'posts_link_attributes');
	add_filter('previous_posts_link_attributes', 'posts_link_attributes');
}

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


if ( ! function_exists( 'theme_main_article_posted_on' ) ) {
	/**
	 * "Theme posted on" pattern.
	 *
	 * @since v1.0
	 */
	function theme_main_article_posted_on() {
		printf(
			wp_kses_post( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author-meta vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', theme_namespace() ) ),
			esc_url( get_the_permalink() ),
			esc_attr( get_the_date() . ' - ' . get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() . ' - ' . get_the_time() ),
			esc_url( get_author_posts_url( (int) get_the_author_meta( 'ID' ) ) ),
			sprintf( esc_attr__( 'View all posts by %s', theme_namespace() ), get_the_author() ),
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
function theme_main_password_form() {
	global $post;
	$label = 'pwbox-' . ( empty( $post->ID ) ? rand() : $post->ID );

	$output                  = '<div class="row">';
		$output             .= '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">';
		$output             .= '<h4 class="col-md-12 alert alert-warning">' . esc_html__( 'This content is password protected. To view it please enter your password below.', theme_namespace() ) . '</h4>';
			$output         .= '<div class="col-md-6">';
				$output     .= '<div class="input-group">';
					$output .= '<input type="password" name="post_password" id="' . esc_attr( $label ) . '" placeholder="' . esc_attr__( 'Password', theme_namespace() ) . '" class="form-control" />';
					$output .= '<div class="input-group-append"><input type="submit" name="submit" class="btn btn-primary" value="' . esc_attr__( 'Submit', theme_namespace() ) . '" /></div>';
				$output     .= '</div><!-- /.input-group -->';
			$output         .= '</div><!-- /.col -->';
		$output             .= '</form>';
	$output                 .= '</div><!-- /.row -->';

	return $output;
}
add_filter( 'the_password_form', 'theme_main_password_form' );


if ( ! function_exists( 'theme_main_comment' ) ) {
	/**
	 * Style Reply link.
	 *
	 * @since v1.0
	 *
	 * @param string $class Link class.
	 *
	 * @return string
	 */
	function theme_main_replace_reply_link_class( $class ) {
		return str_replace( "class='comment-reply-link", "class='comment-reply-link btn btn-outline-secondary", $class );
	}
	add_filter( 'comment_reply_link', 'theme_main_replace_reply_link_class' );

	/**
	 * Template for comments and pingbacks:
	 * add function to comments.php ... wp_list_comments( array( 'callback' => 'theme_main_comment' ) );
	 *
	 * @since v1.0
	 *
	 * @param object $comment Comment object.
	 * @param array  $args    Comment args.
	 * @param int    $depth   Comment depth.
	 */
	function theme_main_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback':
			case 'trackback':
				?>
		<li class="post pingback">
			<p>
				<?php
					esc_html_e( 'Pingback:', theme_namespace() );
					comment_author_link();
					edit_comment_link( esc_html__( 'Edit', theme_namespace() ), '<span class="edit-link">', '</span>' );
				?>
			</p>
				<?php
				break;
			default:
				?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<article id="comment-<?php comment_ID(); ?>" class="comment">
				<footer class="comment-meta">
					<div class="comment-author vcard">
						<?php
							$avatar_size = ( '0' !== $comment->comment_parent ? 68 : 136 );
							echo get_avatar( $comment, $avatar_size );

							/* Translators: 1: Comment author, 2: Date and time */
							printf(
								wp_kses_post( __( '%1$s, %2$s', theme_namespace() ) ),
								sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
								sprintf(
									'<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
									esc_url( get_comment_link( $comment->comment_ID ) ),
									get_comment_time( 'c' ),
									/* Translators: 1: Date, 2: Time */
									sprintf( esc_html__( '%1$s ago', theme_namespace() ), human_time_diff( (int) get_comment_time( 'U' ), current_time( 'timestamp' ) ) )
								)
							);

							edit_comment_link( esc_html__( 'Edit', theme_namespace() ), '<span class="edit-link">', '</span>' );
						?>
					</div><!-- .comment-author .vcard -->

					<?php if ( '0' === $comment->comment_approved ) { ?>
						<em class="comment-awaiting-moderation">
							<?php esc_html_e( 'Your comment is awaiting moderation.', theme_namespace() ); ?>
						</em>
						<br />
					<?php } ?>
				</footer>

				<div class="comment-content"><?php comment_text(); ?></div>

				<div class="reply">
					<?php
						comment_reply_link(
							array_merge(
								$args,
								array(
									'reply_text' => esc_html__( 'Reply', theme_namespace() ) . ' <span>&darr;</span>',
									'depth'      => $depth,
									'max_depth'  => $args['max_depth'],
								)
							)
						);
					?>
				</div><!-- /.reply -->
			</article><!-- /#comment-## -->
				<?php
				break;
		endswitch;
	}

	/**
	 * Custom Comment form.
	 *
	 * @since v1.0
	 * @since v1.1: Added 'submit_button' and 'submit_field'
	 * @since v2.0.2: Added '$consent' and 'cookies'
	 *
	 * @param array $args    Form args.
	 * @param int   $post_id Post ID.
	 *
	 * @return array
	 */
	function theme_main_custom_commentform( $args = array(), $post_id = null ) {
		if ( null === $post_id ) {
			$post_id = get_the_ID();
		}

		$commenter     = wp_get_current_commenter();
		$user          = wp_get_current_user();
		$user_identity = $user->exists() ? $user->display_name : '';

		$args = wp_parse_args( $args );

		$req      = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true' required" : '' );
		$consent  = ( empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"' );
		$fields   = array(
			'author'  => '<div class="form-floating mb-3">
							<input type="text" id="author" name="author" class="form-control" value="' . esc_attr( $commenter['comment_author'] ) . '" placeholder="' . esc_html__( 'Name', theme_namespace() ) . ( $req ? '*' : '' ) . '"' . $aria_req . ' />
							<label for="author">' . esc_html__( 'Name', theme_namespace() ) . ( $req ? '*' : '' ) . '</label>
						</div>',
			'email'   => '<div class="form-floating mb-3">
							<input type="email" id="email" name="email" class="form-control" value="' . esc_attr( $commenter['comment_author_email'] ) . '" placeholder="' . esc_html__( 'Email', theme_namespace() ) . ( $req ? '*' : '' ) . '"' . $aria_req . ' />
							<label for="email">' . esc_html__( 'Email', theme_namespace() ) . ( $req ? '*' : '' ) . '</label>
						</div>',
			'url'     => '',
			'cookies' => '<p class="form-check mb-3 comment-form-cookies-consent">
							<input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" class="form-check-input" type="checkbox" value="yes"' . $consent . ' />
							<label class="form-check-label" for="wp-comment-cookies-consent">' . esc_html__( 'Save my name, email, and website in this browser for the next time I comment.', theme_namespace() ) . '</label>
						</p>',
		);

		$defaults = array(
			'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
			'comment_field'        => '<div class="form-floating mb-3">
											<textarea id="comment" name="comment" class="form-control" aria-required="true" required placeholder="' . esc_attr__( 'Comment', theme_namespace() ) . ( $req ? '*' : '' ) . '"></textarea>
											<label for="comment">' . esc_html__( 'Comment', theme_namespace() ) . '</label>
										</div>',
			/** This filter is documented in wp-includes/link-template.php */
			'must_log_in'          => '<p class="must-log-in">' . sprintf( wp_kses_post( __( 'You must be <a href="%s">logged in</a> to post a comment.', theme_namespace() ) ), wp_login_url( esc_url( get_the_permalink( get_the_ID() ) ) ) ) . '</p>',
			/** This filter is documented in wp-includes/link-template.php */
			'logged_in_as'         => '<p class="logged-in-as">' . sprintf( wp_kses_post( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', theme_namespace() ) ), get_edit_user_link(), $user->display_name, wp_logout_url( apply_filters( 'the_permalink', esc_url( get_the_permalink( get_the_ID() ) ) ) ) ) . '</p>',
			'comment_notes_before' => '<p class="small comment-notes">' . esc_html__( 'Your Email address will not be published.', theme_namespace() ) . '</p>',
			'comment_notes_after'  => '',
			'id_form'              => 'commentform',
			'id_submit'            => 'submit',
			'class_submit'         => 'btn btn-primary',
			'name_submit'          => 'submit',
			'title_reply'          => '',
			'title_reply_to'       => esc_html__( 'Leave a Reply to %s', theme_namespace() ),
			'cancel_reply_link'    => esc_html__( 'Cancel reply', theme_namespace() ),
			'label_submit'         => esc_html__( 'Post Comment', theme_namespace() ),
			'submit_button'        => '<input type="submit" id="%2$s" name="%1$s" class="%3$s" value="%4$s" />',
			'submit_field'         => '<div class="form-submit">%1$s %2$s</div>',
			'format'               => 'html5',
		);

		return $defaults;
	}
	add_filter( 'comment_form_defaults', 'theme_main_custom_commentform' );
}
