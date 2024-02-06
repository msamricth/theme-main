<?php
/**
 * Template part for displaying posts in a vertical card layout.
 *
 * @link templates/content/vertical-card.php
 *
 * @package theme_main
 */
if (isset($args['row_class'])) {
    $row_class = $args['row_class'];
} else {
    // Default to col-lg-4 if $row_class is not defined
    $row_class = 'col-lg-4';
}

$row_class .= ' py-5 ';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class($row_class); ?>>
    <div class="card mb-5">
        <?php if (has_post_thumbnail()): ?>
            <img src="<?php the_post_thumbnail_url('full'); ?>" class="card-img-top" alt="<?php the_title_attribute(); ?>">
        <?php endif; ?>
        <div class="card-body">
            <h3 class="card-title">
                <?php the_title(); ?>
            </h3>
            <strong class="text-muted">
                <?php echo get_the_date(); ?>
            </strong>
            <p class="card-text">
                <?php the_excerpt(); ?>
            </p>
            <?php if (get_field('read_more_toggle', 'option')): ?>
                <a href="<?php the_permalink(); ?>" class="btn btn-primary">Read More</a>
            <?php else: ?>
                <a href="<?php the_permalink(); ?>" class="read-more-link">Read More</a>
            <?php endif; ?>
        </div>
    </div>
</article>