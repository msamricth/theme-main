<?php
/**
 * Template file: inc/core/footer.php
 *
 * @package Bootstrap Base
 * @since v1
 */



if (!function_exists('theme_main_footer_get_options')):

    function theme_main_footer_get_options($classes)
    {
        $footer_options = '';
        $footer_classes = $classes;
        $footer_styles = '';
        $footer_background_image = get_field("footer_background_image", "option");
        $footer_background_color = get_field("footer_background_color", "option");
        $footer_background_graident_top = get_field("footer_background_graident_top", "option");
        $footer_background_graident_bottom = get_field("footer_background_graident_bottom", "option");


        if ($footer_background_color) {
            $footer_styles .= '--theme-main-footer-background-color: var(--bs-' . $footer_background_color . '); ';
            $footer_styles .= '--theme-main-footer-color: var(--theme-main-contrasting-text-' . $footer_background_color . '); ';
            
            $footer_classes .= ' match-nav fold match_'.$footer_background_color;
        }
        if ($footer_background_image) {
            $footer_classes .= ' has-background-image ';
            $footer_styles .= 'background-image:url(' . $footer_background_image . '); ';

        }
        if ($footer_background_graident_top && $footer_background_graident_bottom) {
            $footer_classes .= ' has-background-gradient ';
            $footer_styles .= '--theme-main-footer-background-gradient-top: var(--bs-' . $footer_background_graident_top . '); ';
            $footer_styles .= '--theme-main-footer-background-gradient-bottom: var(--bs-' . $footer_background_graident_bottom . '); ';
            //	$footer_options =' has-background-image" style="background-image="url('.$footer_background_image.');';

        }
        $footer_options = 'class="' . $footer_classes.'"';
        if($footer_styles ){
            //$footer_options .= '" ';
            $footer_options .= ' style="' . $footer_styles . '"';
        }
        return $footer_options;
    }
endif;