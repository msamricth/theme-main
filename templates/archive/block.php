<?php $page_id = get_option( 'page_for_posts' );
?>
			
<div id="post-<?php the_ID(); ?>" <?php post_class('content'); ?>>
    <div class="entry-content">
        <?php
        echo apply_filters( 'the_content', get_post_field( 'post_content', $page_id ) );

        wp_link_pages(array('before' => '<div class="page-link"><span>' . esc_html__('Pages:', 'theme_main') . '</span>', 'after' => '</div>'));
        ?>
    </div><!-- /.entry-content -->

    <?php
    edit_post_link(__('Edit', 'theme_main'), '<span class="edit-link">', '</span>');
    ?>
</div>