<?php
/**
 * Template file: inc/blocks/image-cloud/block.php
 *
 * Image Cloud Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$blockName = "Image Cloud";
$blockID = "image-cloud";
$classes = $blockID . " ";
// add acf or other functions here

$classes .= ""; // Add extra classes here.
?>
<div <?php echo get_block_settings($block, $blockID, $classes); ?>>
    <?php $image_cloud_ids = get_field('image_cloud'); ?>
    <?php $size = 'full';
    $imgClass = "";
    $animation = ""; ?>
    <?php if ($image_cloud_ids): ?>
        <?php foreach ($image_cloud_ids as $image_cloud_id):
            $itemWidth = get_field('grid_width', $image_cloud_id);
            $animation = get_field('animation', $image_cloud_id);
            if ($animation) {
                $imgClass = 'class="' . $animation . '"';
            }
            $image_alt = get_post_meta($image_cloud_id, '_wp_attachment_image_alt', TRUE);
            ?>
            <div class="image-cloud--item" <?php if ($itemWidth) {
                   echo 'style="--theme-main-image-cloud-item-width: var(--theme-main-image-cloud-item-' . $itemWidth . '-width);"';
               } ?>>
                <div class="image-cloud--item-container">
                    <img src="<?php echo esc_url(wp_get_attachment_image_url($image_cloud_id)); ?>"
                        alt="<?php echo esc_attr($image_alt); ?>" <?php echo $imgClass; ?> />
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</div>