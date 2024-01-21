<?php
/**
 * Template part for displaying posts in a card layout.
 *
 * @link templates/content/index.php
 *
 * @package theme_main
 */

// Determine the number of posts to display in each row
// Determine the number of posts to display in each row
$posts_in_row = ($i == 1) ? 1 : (($i <= 4) ? 3 : 2);

// Determine the card layout
$card_layout_class = ($i == 1) ? 'card-horizontal' : '';

?>
<article id="post-<?php the_ID(); ?>" class="col-md-<?php echo 12 / $posts_in_row; ?>">
    <div class="card <?php echo $card_layout_class; ?>">
        <?php if (has_post_thumbnail() && $card_layout_class !== 'card-horizontal') : ?>
            <img src="<?php the_post_thumbnail_url('large'); ?>" class="card-img-top" alt="<?php the_title_attribute(); ?>">
        <?php endif; ?>
        <div class="card-body">
            <?php if (has_post_thumbnail() && $card_layout_class === 'card-horizontal') : ?>
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="<?php the_post_thumbnail_url('large'); ?>" class="img-fluid rounded-start" alt="<?php the_title_attribute(); ?>">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
            <?php endif; ?>
            
            <h3 class="card-title"><?php the_title(); ?></h3>
            <strong class="text-muted"><?php echo get_the_date(); ?></strong>
            <p class="card-text"><?php the_excerpt(); ?></p>
            <a href="<?php the_permalink(); ?>" class="btn btn-primary">Read More</a>
            
            <?php if (has_post_thumbnail() && $card_layout_class === 'card-horizontal') : ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</article>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'col-sm-6 col-lg-4 col-4xl-3' ); ?>>
	<div class="card mb-4">
		<header class="card-body">
			<h2 class="card-title">
				<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'theme_main' ), the_title_attribute( array( 'echo' => false ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h2>
			<?php
				if ( 'post' === get_post_type() ) :
			?>
				<div class="card-text entry-meta">
					<?php
						theme_main_article_posted_on();

					?>
				</div><!-- /.entry-meta -->
			<?php
				endif;
			?>
		</header>
		<div class="card-body">
			<div class="card-text entry-content">
				<?php
					if ( has_post_thumbnail() ) {
						echo '<div class="post-thumbnail">' . get_the_post_thumbnail( get_the_ID(), 'large' ) . '</div>';
					}

					
					the_excerpt();
				?>
				<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . esc_html__( 'Pages:', 'theme_main' ) . '</span>', 'after' => '</div>' ) ); ?>
			</div><!-- /.card-text -->
			<footer class="entry-meta">
				<a href="<?php the_permalink(); ?>" class="btn btn-outline-secondary"><?php esc_html_e( 'more', 'theme_main' ); ?></a>
			</footer><!-- /.entry-meta -->
		</div><!-- /.card-body -->
	</div><!-- /.col -->
</article><!-- /#post-<?php the_ID(); ?> -->
