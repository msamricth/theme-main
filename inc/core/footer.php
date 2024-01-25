<?php
/**
 * Template file: inc/core/footer.php
 *
 * @package Bootstrap Base
 * @since v1
 */


add_menu_page(
    'Standalone Block Editor',         // Visible page name
    'Block Editor',                    // Menu label
    'edit_posts',                      // Required capability
    'theme_main_footer',                      // Hook/slug of page
    'theme_main_footer_render_block_editor', // Function to render the page
    'dashicons-grid-view'  // Custom icon
);

function theme_main_footer_render_block_editor() {
	?>
	<div
		id="theme-main-block-editor"
		class="theme-main-block-editor"
	>
		Loading Editor...
	</div>
	<?php
}
function theme_main_footer_block_editor_init( $hook ) {

    // Exit if not the correct page.
	if ( 'theme_main_footer' !== $hook ) {
		return;
    }
    wp_enqueue_style( 'wp-format-library' );

    // Enqueue custom styles.
    wp_enqueue_style(
        'getdave-sbe-styles',                       // Handle
        plugins_url( 'build/index.css', __FILE__ ), // Block editor CSS
        array( 'wp-edit-blocks' ),                  // Dependency to include the CSS after it
        filemtime( __DIR__ . '/build/index.css' )
    );
}

add_action( 'admin_enqueue_scripts', 'theme_main_footer_block_editor_init' );