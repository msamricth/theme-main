<div id="post-<?php the_ID(); ?>" <?php post_class('content'); ?>>
    <div class="entry-content">
        <?php
        the_content();

        wp_link_pages(array('before' => '<div class="page-link"><span>' . esc_html__('Pages:', 'theme_main') . '</span>', 'after' => '</div>'));
        ?>
    </div><!-- /.entry-content -->

    <?php
    edit_post_link(__('Edit', 'theme_main'), '<span class="edit-link">', '</span>');
    ?>
</div>