<?php
/**
 * Template part for displaying posts in a horizontal card layout.
 *
 * @link templates/content/horizontal-card.php
 *
 * @package theme_main
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('card mb-3'); ?>>
    <div class="row g-0">
        <div class="col-md-4">
            <?php if (has_post_thumbnail()) : ?>
                <img src="<?php the_post_thumbnail_url('full'); ?>" class="card-img-top" alt="<?php the_title_attribute(); ?>">
            <?php endif; ?>
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <h3 class="card-title"><?php the_title(); ?></h3>
                <strong class="text-muted"><?php echo get_the_date(); ?></strong>
                <p class="card-text"><?php the_excerpt(); ?></p>
                <?php if (get_field('read_more_toggle', 'option')) : ?>
                    <a href="<?php the_permalink(); ?>" class="btn btn-primary">Read More</a>
                <?php else : ?>
                    <a href="<?php the_permalink(); ?>" class="read-more-link">Read More</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</article>
