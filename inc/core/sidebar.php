
<?php
/**
 * Template file: inc/core/sidebar.php
 *
 * 
 * Sidebar functions for the Supply Theme
 *
 * @package Bootstrap Base
 * @since v1
 */


if ( ! function_exists( 'myTheme_registerWidgetAreas' ) ) :
    /**
     * Init Widget areas in Sidebar.
     *
     * @since v1.0
     */
    function myTheme_registerWidgetAreas() {
        // Grab all pages except trashed
        $pages = new WP_Query(Array(
            'post_type' => 'page',
            'post_status' => array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit'),
            'posts_per_page'=>-1
        ));
        // Step through each page
        while ( $pages->have_posts() ) {
            $pages->the_post();
            // Ignore pages with no slug
            if ($pages->post->post_name == '') continue;
            // Register the sidebar for the page. Note that the id has
            // to match the name given in the theme template
            register_sidebar( array(
                'name'          => $pages->post->post_name,
                'id'            => 'widget_area_for_page_'.$pages->post->post_name,
                'before_widget' => '',
                'after_widget'  => '',
                'before_title'  => '',
                'after_title'   => '',
            ) );
            
        }
        register_sidebar(
            array(
                'id'            => 'primary',
                'name'          => __( 'Primary Sidebar' ),
                'description'   => __( 'A short description of the sidebar.' ),
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget'  => '</div>',
                'before_title'  => '<h3 class="widget-title">',
                'after_title'   => '</h3>',
            )
        );
    }
    add_action( 'widgets_init', 'myTheme_registerWidgetAreas' );
endif;