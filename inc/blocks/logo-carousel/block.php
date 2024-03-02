<?php
/**
 * Template file: inc/blocks/logo-carousel/block.php
 *
 * Logo Carousel Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$blockName = "Logo Carousel";
$blockID = "logo-carousel";
$classes = $blockID . " ";


$secondary_cta = get_field('secondary_cta');
$primary_cta = get_field('primary_cta');

$classes .= ""; // Add extra classes here.
$count = 0;
$slideCount = 0;
$title = get_field('section_title');
$blurb = get_field('section_blurb');
$title_type = get_field('type');
?>
<div <?php echo get_block_settings($block, $blockID, $classes); ?>>
    <?php if ($title) { ?>
        <div class="sticky-top  sticky-header pt-gutter fold animation-on fade-in" id="logo-carousel-header">
            <div class="container">
                <?php if (empty($type)) {
                    $type = 'h1';
                }
                echo '<' . $type . ' class="text-center">' . $title . '</' . $type . '>';
                if ($blurb) {
                    echo '<p class="lead text-center">' . $blurb . '</p>';
                } ?>
            </div>
        </div>
    <?php } ?>
    <div class="scroll-slider">
        <div class="scroll-slider-container logo-carousel">
            <?php if (have_rows('repeater_logos', 'option')): ?>
                <?php while (have_rows('repeater_logos', 'option')):
                    the_row(); ?>
                    <?php $logo = get_sub_field('logo'); ?>
                    <?php if ($logo): ?>
                        <div class="logo scroll-slide px-4"><img src="<?php echo esc_url($logo['url']); ?>"
                                alt="<?php echo esc_attr($logo['alt']); ?>" />
                        </div>
                    <?php endif; ?>
                    <?php $count++; endwhile; ?>
            <?php else: ?>
                <?php // No rows found ?>
            <?php endif; ?>

            <div class="scroll-slide" style="min-width: 100vw">
                <div class="container text-center">
                    <div class="row">
                        <?php if ($secondary_cta): ?>
                            <div class="col-md-6 col-sm-10 col-11 mx-auto px-lg-5 px-xl-0">
                                </a>
                                <a href="<?php echo esc_url($secondary_cta['url']); ?>"
                                    target="<?php echo esc_attr($secondary_cta['target']); ?>"
                                    class="h3 cta-link btn-link btn text-dark mt-3 my-md-0">
                                    <?php echo esc_html($secondary_cta['title']); ?><i class="fa fa-angle-right fa-1x"
                                        aria-hidden="true"></i>
                                </a>
                            </div>
                        <?php endif; ?>
                        <?php if ($primary_cta): ?>
                            <div class="col-md-6 col-sm-10 col-11 mx-auto px-lg-5">
                                <a href="<?php echo esc_url($primary_cta['url']); ?>"
                                    target="<?php echo esc_attr($primary_cta['target']); ?>"
                                    class="h3 cta-link btn-link btn text-primary mb-3 my-md-0">
                                    <?php echo esc_html($primary_cta['title']); ?><i class="fa fa-angle-right fa-1x"
                                        aria-hidden="true"></i>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>