<?php
/**
 * Template file: inc/core/tags.php
 *
 * 
 * Core functions for the Supply Theme
 *
 * @package Bootstrap Base
 * @since v1
 */


if ( ! function_exists( 'header_link' ) ) :
	/**
	 * Header Link for Careers header / Media with a link header type
	 *
	 * @since v5 - updated v9
	 */
    function header_link(){ 
        $post_id = '';
        $current_post = get_queried_object();
        $post_id = $current_post ? $current_post->ID : null;
        $output = '';
        $cta_link = '';
        $cta_label = '';
        $cta_target = '';
        $useUrl = '';
        $header_cta = '';
        $ctapadding = '';
        if ( have_rows( 'header_link' ) ) : 
            while ( have_rows( 'header_link' ) ) : the_row();
                $page_lookup = get_sub_field( 'page_lookup' ); 
                $cta_label = get_sub_field( 'link_text' ); 
                $ctaClasses = 'internal-link ';
                if ( have_rows( 'options' ) ) : 
                    while ( have_rows( 'options' ) ) : the_row(); 
                        if ( get_sub_field( 'use_url' ) == 1 ) : 
                            $useUrl = 1;         
                        endif; 
                        if ( get_sub_field( 'external_url' ) == 1 ) : 
                            $ctaClasses = 'link-up ';
                            $cta_target = 'target="_blank"';
                        endif; 
                        $ctapadding .= get_sub_field( 'padding_bottom' );
                    endwhile; 
                endif;
                if ( $useUrl == 1 ) : 
                    $cta_link = get_sub_field( 'url' ); 
                else :              
                    if ( $page_lookup ) :
                        if(empty($cta_label)){
                            $cta_label = get_the_title( $page_lookup );
                        }
                        $cta_link = get_permalink( $page_lookup );
                    endif; 
                endif;  
                $ctaClasses .= 'h8';
                $output .= '<div class="header-link '.$ctapadding.'"><a href="'.esc_attr($cta_link).'" class="'. esc_attr( $ctaClasses ).'" '.$cta_target.'>'.$cta_label.'</a></div>';
            endwhile; 
        endif; 
        return $output;
    }
endif;

if ( ! function_exists( 'theme_main_excrpt' ) ) :
	/**
	 * "Theme posted on" pattern.
	 *
	 * @since v1.0
	 */
	function theme_main_excerpt($limit) {

        $excerpt = explode(' ', get_the_excerpt(), $limit);

        if (count($excerpt) >= $limit) {
            array_pop($excerpt);
            $excerpt = implode(" ", $excerpt) . '...';
        } else {
            $excerpt = implode(" ", $excerpt);
        }
  
        $excerpt = preg_replace('`\[[^\]]*\]`', '', $excerpt);
  
		printf($excerpt);
	}
endif;
if ( ! function_exists( 'theme_main_alert' ) ) :
	/**
	 * "Theme posted on" pattern.
	 *
	 * @since v1.0
	 */
	function theme_main_alert($msg = null) {
        if(empty($msg)) {
            $msg = get_field('copy_article_link_success_message', 'option');
        }
		$output = '<div class="liveToast alert alert-dark border-0 bg-dark text-white alert-dismissible fade" role="alert">'.$msg.'<button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button></div>';
		return $output;
    }

endif;

if ( ! function_exists( 'theme_main_share_buttons' ) ) :
	/**
	 * "Theme posted on" pattern.
	 *
	 * @since v1.0
	 */
	function theme_main_share_buttons() {
        $permalink = get_the_permalink();
        $title = get_the_title();
		$output = '<ul class="social-nav share-buttons cp2"><li><a class="mt-0 ms-0 copy-to-clipboard" href="#" title="Copy to clipboard"><i class="fa-solid fa-link" aria-hidden="true"></i></a></li><li><a class="" href="https://www.linkedin.com/sharing/share-offsite/?url='.$permalink.'" target="_blank" title="Share on LinkedIn"><i class="fa-brands fa-linkedin-in" aria-hidden="true"></i></a></li><li><a class="" href="https://www.facebook.com/sharer/sharer.php?u='.$permalink.'" target="_blank" title="Share on Facebook"><i class="fa-brands fa-facebook-f" aria-hidden="true"></i></a></li><li><a class="twitter-share-button mb-0 me-0" href="https://twitter.com/intent/tweet?text='.$title.' '. $permalink.'" target="_blank" title="share on Twitter"><i class="fa-brands fa-twitter" aria-hidden="true"></i></a></li></ul>';
        $output .= theme_main_alert();
		return $output;
    }

endif;

if ( ! function_exists( 'theme_main_entry_meta' ) ) :
	/**
	 * "Theme posted on" pattern.
	 *
	 * @since v1.0
	 */
	function theme_main_entry_meta($value = null) {
		$author_id = get_the_author_meta( 'ID' ); 
        if(get_field('custom_author')){

            $author = get_field('custom_author');

            $role = get_field('custom_author_role');
        } else {
            $newAuthorID = 'user_'.$author_id;
            $role = get_field('role__position_at_supply', $newAuthorID);
            $author = get_the_author();
        }
		
		$permalink = get_the_permalink();
		$output = '<div class="entry-meta mt-0">'.theme_main_share_buttons().'<span class="font-weight-bold h6 mb-0 author-meta vcard d-block">'.$author.'</span><span class="sep h8">'.$role.'</span></div>';
		return $output;
	}
	//old text 
	/**
	 * <div class="entry-meta"><span class="font-weight-bold author-meta vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span><br /><span class="sep h8 text-capitalize cp2">%4$s</span><ul class="social-nav share-buttons"><li><a class="" id="copy-to-clipboard" href="#" target="_blank" title="Copy to clipboard"><i class="fa-solid fa-link" aria-hidden="true"></i></a></li><li><a class="" href="https://www.linkedin.com/sharing/share-offsite/?url=%5$s" target="_blank" title="Share on LinkedIn"><i class="fa-brands fa-linkedin-in" aria-hidden="true"></i></a></li><li><a class="" href="https://www.facebook.com/sharer/sharer.php?u=%5$s" target="_blank" title="Share on Facebook"><i class="fa-brands fa-facebook" aria-hidden="true"></i></a></li><li><a class="twitter-share-button" href="https://twitter.com/intent/tweet" target="_blank" title="share on Twitter"><i class="fa-brands fa-twitter" aria-hidden="true"></i></a></li></ul></div>
	 */
endif;

if ( ! function_exists( 'get_theme_main_link' ) ) :
	/**
	 * "Theme posted on" pattern.
	 *
	 * @since v7.8
	 */
	function get_theme_main_link($custom=null) {
        $output ='';
        $classes ='';
        $link = '';
        $linkClass = 'internal-link';
        $linkTitle = get_field( 'link_text' );
        if(empty($linkTitle)){
            $linkTitle = get_sub_field('link_text');
        }
        $page_lookup = get_field( 'page_lookup' ); 
        if(empty($page_lookup)){
            $page_lookup = get_sub_field('page_lookup');
        }
        $linkURL = get_field( 'url' );
        if(empty($linkURL)){
            $linkURL = get_sub_field('url');
        }
        if ( have_rows( 'link_options' ) ) :
            while ( have_rows( 'link_options' ) ) : the_row(); 
                $padding_block = get_sub_field( 'padding_bottom' ); 

                if (isset($padding_block)) {
                    $classes .= ' '.$padding_block;
                }
                if ( get_sub_field( 'use_url' ) == 1 ) {
                    if (isset($linkURL)) {
                        $link = $linkURL;
                    }
                    if(empty($linkTitle)){
                        $linkTitle = 'Let’s talk about your project';
                    }
                } else {
                    if ( $page_lookup ) : 
                        $link = get_permalink( $page_lookup );
                        if(empty($linkTitle)){
                            $linkTitle = get_the_title( $page_lookup );
                        }
                    endif; 
                }
                if ( get_sub_field( 'external_url' ) == 1 ) :
                    $linkClass = 'link-up';
                endif;
            endwhile;
        endif;
        if(!empty($link)){
            $output .='<a class="'.esc_html($linkClass).'" '; 
            if($linkClass){
                $output .='target="_blank" '; 
            } 
            $output .='href="'.esc_url( $link).'">'.esc_html( $linkTitle ).'</a>';
        }


		return $output;
    }

endif;
if ( ! function_exists( 'theme_main_article_posted_on' ) ) :
	/**
	 * "Theme posted on" pattern.
	 *
	 * @since v1.0
	 */
	function theme_main_article_posted_on() {
		printf(
			wp_kses_post( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author-meta vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'supply' ) ),
			esc_url( get_the_permalink() ),
			esc_attr( get_the_date() . ' - ' . get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() . ' - ' . get_the_time() ),
			esc_url( get_author_posts_url( (int) get_the_author_meta( 'ID' ) ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'supply' ), get_the_author() ),
			get_the_author()
		);
	}
endif;

if ( ! function_exists( 'theme_main_custom_edit_post_link' ) ) :
    /**
     * Style Edit buttons as badges: https://getbootstrap.com/docs/5.0/components/badge
     *
     * @since v1.0
     */
    function theme_main_custom_edit_post_link( $output ) {
        return str_replace( 'class="post-edit-link"', 'class="post-edit-link badge badge-secondary"', $output );
    }
endif;
add_filter( 'edit_post_link', 'theme_main_custom_edit_post_link' );
if ( ! function_exists( 'theme_main_custom_edit_comment_link' ) ) :
    function theme_main_custom_edit_comment_link( $output ) {
        return str_replace( 'class="comment-edit-link"', 'class="comment-edit-link badge badge-secondary"', $output );
    }
endif;
add_filter( 'edit_comment_link', 'theme_main_custom_edit_comment_link' );