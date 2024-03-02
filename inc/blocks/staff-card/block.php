<?php
/**
 * Template file: inc/blocks/staff-card/block.php
 *
 * Staff Card Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$blockName = "Staff Card";
$blockID = "staff-card";
$classes = $blockID . "  text-bg-dark ";

$staff_image = get_field('staff_image');
$linkedin_url = get_field('linkedin_url');
// add acf or other functions here

$classes .= ""; // Add extra classes here.
?>
<div <?php echo get_block_settings($block, $blockID, $classes); ?>>

    <?php if ($staff_image): ?>
        <img src="<?php echo esc_url($staff_image['url']); ?>" class="card-img"
            alt="<?php echo esc_attr($staff_image['alt']); ?>" />
        <div class="card-overlay"></div>
    <?php endif; ?>

    <?php if ($linkedin_url): ?>
        <a href="<?php echo $linkedin_url; ?>" class="btn-floating btn btn-dark">
            <i class="fa-brands fa-linkedin"></i>
        </a>
    <?php endif; ?>

    <div class="card-img-overlay">
        <h5>
            <?php the_field('staff_member'); ?>
        </h5>
        <span clas="text-uppercase">
            <?php the_field('staff_role'); ?>
        </span>
    </div>

</div>