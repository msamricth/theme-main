<?php
/**
 * Template file: inc/blocks/contact-form-7-theme-version/block.php
 *
 * Contact Form 7 (theme version) Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$blockName = "Contact Form 7 (theme version)";
$contact_form_7_shortcode = get_field('contact_form_7_shortcode');
$contact_form_id = get_field('contact_form_id');
$success_message = get_field('success_message');
$error_message = get_field('error_message');



$blockID = "contact-form-" . $contact_form_id;
$classes = $blockID . " contact-form-7-block ";
$honeypot ='honeypot-'. $contact_form_id;

if (empty($success_message)) {
    $success_message = 'Thanks for subscribing.';
}
if (empty($error_message)) {
    $error_message = 'There was a error and your submission did not go through.';
}
?>
<div <?php echo get_block_settings($block, $blockID, $classes); ?>>
    <input size="40" class="wpcf7-form-control wpcf7-text d-none honeypot" id="<?php echo $honeypot; ?>" aria-invalid="false" value=""
        type="text" name="Honeypot">
    <div class="hidden-only-if-sent">
        <?php echo $contact_form_7_shortcode; ?>
    </div>
    <div class="visible-only-if-sent fade-in" style="display:none;">
        <h4><?php echo $success_message ?></h4>
    </div>

    <div class="visible-only-if-sending fade-in" style="display:none;">
        <?php echo theme_main_loading_animation('Sending'); ?>
    </div>

    <div class="visible-only-if-error fade-in" style="display:none;">
        <h4><?php echo $error_message ?></h4>
    </div>
    <?php

    ?>
</div>