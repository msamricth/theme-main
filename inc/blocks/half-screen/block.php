<?php
/**
 * Template file: inc/blocks/half-screen/block.php
 *
 * Half Screen Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$blockName = "Half Screen";
$blockID = "half-screen";
$classes = $blockID . " p-5 p-md-0 ";
$contentColClasses = "";
$content_area_size = get_field('content_area_size');
$layout_order = get_field('layout_order');
$template = array(
    array(
        'core/heading',
        array(
            'level' => 3,
            'placeholder' => 'Half Screen Block Title Here',
            'align' => 'left',
        ),
    ),
    array(
        'core/paragraph',
        array(
            'placeholder' => 'Half Screen Block Paragraph Content Here',
            'align' => 'left',
        ),
    ),
    array(
        'core/button',
        array(
            'placeholder' => 'Half Screen Block Call to Action Here',
            'align' => 'left',
        ),
    ),
);

switch ($content_area_size) {
    case "small":
        $contentColClasses = "col-md-6 col-lg-4 col-xxl-3";
        if (empty($layout_order)) {
            $contentColClasses .= " offset-md-6 offset-lg-8 offset-lg-9";
        }
        break;
    case "medium":
        $contentColClasses = "col-md-7 col-dlg-6 col-3xl-5";
        if (empty($layout_order)) {
            $contentColClasses .= " offset-md-5 offset-dlg-6 offset-3xl-7";
        }
        break;
    case "big":
        $contentColClasses = "col-md-8 col-xxl-7";
        if (empty($layout_order)) {
            $contentColClasses .= " offset-md-4 offset-xxl-5";
        }
        break;
    case "large":
        $contentColClasses = "col-md-10 col-dlg-8 col-3xl-7";
        if (empty($layout_order)) {
            $contentColClasses .= " offset-md-2 offset-dlg-4 offset-3xl-5";
        }
        break;

}
if (!empty($block['backgroundColor'])) {
    $contentColClasses .= ' has-' . $block['backgroundColor'] . '-background-color';
}
// add acf or other functions here
$blockContent = '<InnerBlocks class="half-screen-block-editor-content p-gutter ' . $contentColClasses . '" template="' . esc_attr(wp_json_encode($template)) . '"/>';
$classes .= ""; // Add extra classes here.
?>
<div <?php echo get_block_settings_no_colors($block, $blockID, $classes); ?>>
    <div class="container-fluid">
        <div class="row">
            <?php echo $blockContent; ?>
        </div>
    </div>
    <?php echo get_basic_media_components(); ?>
</div>
