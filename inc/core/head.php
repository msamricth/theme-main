<?php

/**
 * Template file: inc/core/head.php
 * Head functions
 * These functions help initate many of the core theme functions such as page color scheme, video functions, the fold and more
 *
 * @package Bootstrap Base
 * @since v1
 */
if (!function_exists('get_theme_Colors_CSS_variables')) {
    /**
     *Base Color Css Variables
     *
     * @since v1
     */
    function get_theme_Colors_CSS_variables($prefixColor, $prefixHexcode)
    {

        $dark_color = get_field('dark_color', 'option');
        $light_color = get_field('light_color', 'option');
        $rgb = HTMLToRGBforComparison($prefixHexcode);
        $hsl = RGBToHSL($rgb);
        if ($hsl->lightness > 150) {
            $text = adjustBrightness($prefixHexcode, '-.3');
            $subtle = adjustBrightness($prefixHexcode, '.4');
            $border = adjustBrightness($prefixHexcode, '.2');
            $contrast = $dark_color;
        } else {
            $text = adjustBrightness($prefixHexcode, '.3');
            $subtle = adjustBrightness($prefixHexcode, '-.4');
            $border = adjustBrightness($prefixHexcode, '-.2');
            $contrast = $light_color;
        }
        return '
        --bs-' . $prefixColor . ': ' . $prefixHexcode . ';
        --bs-' . $prefixColor . '-rgb: ' . HTMLToRGB($prefixHexcode) . ';
        --bs-' . $prefixColor . '-text-emphasis: ' . $text . ';
        --bs-' . $prefixColor . '-bg-subtle: ' . $subtle . ';
        --bs-' . $prefixColor . '-border-subtle: ' . $border . ';
        --theme-main-contrasting-text-' . $prefixColor . ': ' . $contrast . ';
        ';
    }
}
if (!function_exists('get_theme_Colors_Buttons')) {
    /**
     *Base Color Css Variables
     *
     * @since v1
     */
    function get_theme_Colors_Buttons($prefixColor, $prefixHexcode)
    {


        $prefixTextColor = '';
        $prefixhoverColor = '';
        $prefixActiveColor = '';
        $rgb = HTMLToRGBforComparison($prefixHexcode);
        $hsl = RGBToHSL($rgb);
        if ($hsl->lightness > 150) {
            $prefixTextColor = adjustBrightness($prefixHexcode, '-1');
            $prefixhoverColor = adjustBrightness($prefixHexcode, '.4');
            $prefixActiveColor = adjustBrightness($prefixHexcode, '.2');
        } else {
            $prefixTextColor = adjustBrightness($prefixHexcode, '1');
            $prefixhoverColor = adjustBrightness($prefixHexcode, '-.3');
            $prefixActiveColor = adjustBrightness($prefixHexcode, '-.2');
        }
        if (empty($prefixTextColor)) {
            $prefixTextColor = '#000';
        }

        return '
        .wp-block-button .wp-block-button__link.has-' . $prefixColor . '-background-color, .wp-block-button.has-' . $prefixColor . '-background-color {
        --bs-btn-color: ' . $prefixTextColor . ';
        --bs-btn-hover-color: ' . $prefixTextColor . ';
        --bs-btn-active-color: ' . $prefixTextColor . ';
        --bs-btn-disabled-color: ' . $prefixTextColor . ';
        --bs-btn-bg: ' . $prefixHexcode . ';
        --bs-btn-border-color: ' . $prefixHexcode . ';
        --bs-btn-disabled-bg: ' . $prefixHexcode . ';
        --bs-btn-disabled-border-color: ' . $prefixHexcode . ';
        --bs-btn-hover-bg: ' . $prefixhoverColor . ';
        --bs-btn-hover-border-color: ' . $prefixhoverColor . ';
        --bs-btn-focus-shadow-rgb: ' . HTMLToRGB($prefixActiveColor) . ';
        --bs-btn-active-bg: ' . $prefixActiveColor . ';
        --bs-btn-active-border-color: ' . $prefixActiveColor . ';
        }
        ';
    }
}
if (!function_exists('get_theme_head')) {
    /**
     * Background images
     *
     * @since v1
     */
    function get_theme_head()
    {
        $cssVariables = '';
        $cssButtonVariables = '';
        $prefixColor = '';
        $prefixHexcode = '';
        $primary_colors = theme_main_primary_colors();

        foreach ($primary_colors as &$primary_color) {
            $prefixColor = $primary_color['slug'];
            $prefixHexcode = $primary_color['color'];

            $cssVariables .= get_theme_Colors_CSS_variables($prefixColor, $prefixHexcode);
        }

        // buttons
        foreach ($primary_colors as &$primary_color) {
            $prefixColor = $primary_color['slug'];
            $prefixHexcode = $primary_color['color'];

            $cssButtonVariables .= get_theme_Colors_Buttons($prefixColor, $prefixHexcode);
        }

        if (have_rows('extra_colors', 'option')):
            while (have_rows('extra_colors', 'option')):
                the_row();
                $extra_colors_color_label = get_sub_field('color_label');
                $extra_colors_color = get_sub_field('color');
                $extra_colors_color_label = slugify($extra_colors_color_label);

                $cssVariables .= get_theme_Colors_CSS_variables($extra_colors_color_label, $extra_colors_color);
                $cssButtonVariables .= get_theme_Colors_Buttons($extra_colors_color_label, $extra_colors_color);
                $cssButtonVariables .= '
                    .has-' . $extra_colors_color_label . '-color {
                        color: var(--wp--preset--color--' . $extra_colors_color_label . ');
                    }
                    .has-' . $extra_colors_color_label . '-background-color {
                        background-color: var(--wp--preset--color--' . $extra_colors_color_label . ');
                    }
                ';
            endwhile;
        endif;

        $gray500 = get_field('gray-500', 'option');
        $gray600 = get_field('gray-600', 'option');
        $gray800 = get_field('gray-800', 'option');
        $gray900 = get_field('gray-900', 'option');

        $custom_styles = ':root {
            ' . $cssVariables;
        if (isset($gray500)) {
            $custom_styles .= '  --bs-gray-500: ' . $gray500 . ';';
        }
        if (isset($gray600)) {
            $custom_styles .= '  --bs-gray-600: ' . $gray600 . ';';
        }
        if (isset($gray600)) {
            $custom_styles .= '  --bs-gray: ' . $gray600 . ';';
        }
        if (isset($gray800)) {
            $custom_styles .= '  --bs-gray-800: ' . $gray800 . ';';
        }
        if (isset($gray900)) {
            $custom_styles .= '  --bs-gray-900: ' . $gray900 . ';';
        }

        $custom_styles .= '}
        ' . $cssButtonVariables;

        wp_add_inline_style('global-styles', $custom_styles);
    }
}

// Hook the function to an action using its name without parentheses
add_action('wp_enqueue_scripts', 'get_theme_head');


if (!function_exists('bg_images')):
    /**
     * Background images
     *
     * @since v3 - updated v8
     */
    function bg_images()
    {
        if (get_field('background_image', 'option')): ?>
            <style>
                .bg-pattern {
                    background-image: url('<?php the_field('background_image', 'option'); ?>');
                }
            </style>
            <?php
        endif;
        if (get_field('offerings_image', 'option')): ?>
            <style>
                .bg-offerings {
                    background-image: url('<?php the_field('offerings_image', 'option'); ?>');
                }
            </style>
            <?php
        endif;
    }
    add_action('wp_head', 'bg_images', 100);
    add_filter('excerpt_more', '__return_empty_string');
endif;

if (!function_exists('get_hamburger')) {
    /**
     * Hamburger options
     *
     * @since v3 - updated v8
     */
    function get_hamburger()
    {
        if (get_field('hamburger_animation', 'option')):
            return get_field('hamburger_animation', 'option');
        endif;
    }
}


if (!function_exists('transtion_settings')):
    /**
     * transition settings
     *
     * @since v3 - updated v8
     */
    function transtion_settings()
    {
        $headStyles = '';
        $foldTransition = '';
        $transition_duriation = get_field('transition_duriation', 'option');
        $transition_type = get_field('transition_type', 'option');
        if ($transition_duriation) {
            if ($transition_type) {
                $foldTransition = $transition_duriation . ' ' . $transition_type;
                $headStyles .= '<style>#wrapper {   
                    -webkit-transition: background-color ' . $foldTransition . ',color ' . $foldTransition . ', opacity ' . $foldTransition . ', all ' . $foldTransition . ';
                    transition: background-color  ' . $foldTransition . ',color ' . $foldTransition . ', opacity ' . $foldTransition . ', all ' . $foldTransition . ';</style>';
            }
        }
        return $headStyles;
    }

    add_action('wp_head', 'transtion_settings', 100);
endif;

if (!function_exists('get_bodyclasses')):
    /**
     * Body classes for the main document. Most settings can be accessed here : domainname.com/wp-admin/admin.php?page=theme_options
     *
     * @since v1
     */
    function get_bodyclasses()
    {
        $post_id = get_theme_main_postID();
        $navbar_scheme = '';
        $bodyClasses = '';
        $navbar_page_scheme = get_field('navbar_color_settings');
        //$navbar_theme_scheme = get_theme_mod('navbar_scheme', 'navbar-light bg-light'); // Get custom meta-value.
        $scheme = get_scheme();
        if ($navbar_page_scheme) {

            if (str_contains($navbar_page_scheme, 'transparent-dark') !== false) {
                $navbar_scheme .= 'navbar-transparent  nav-bg-transparent-dark';
            } elseif (str_contains($navbar_page_scheme, 'transparent-light') !== false) {
                $navbar_scheme .= 'navbar-transparent nav-bg-transparent-light';
            } else {

                // $navbar_scheme .= 'navbar-' . $navbar_page_scheme;
                //$navbar_scheme .= ' nav-bg-' . $navbar_page_scheme;

            }
        }
        $bodyClasses .= $navbar_scheme;


        if (get_field('fold_on') == 1):
        else:
            $bodyClasses .= ' fold_on ';
        endif;
        if (str_contains($scheme, 'bg-custom') !== false) {
            $bodyClasses .= " customScheme ";
        }
        if (get_field('lazy_load_videos', 'option') == 1):
            $bodyClasses .= 'lazy_load_videos ';
        endif;
        if (get_field('nav_compression', 'option') == 1):
            $bodyClasses .= 'nav_compression ';
        endif;
        if (get_field('make_dropdown_menus_horizontal', 'option') == 1):
            $bodyClasses .= 'make_dropdown_menus_horizontal ';
        endif;
        
        return $bodyClasses;
    }
endif;



if (!function_exists('get_scroller_attributes')):
    /**
     * Data attributes that largely control fold related events and variables. Most settings can be accessed here : domainname.com/wp-admin/admin.php?page=theme_options
     *
     * @since v1
     */
    function get_scroller_attributes()
    {
        $dataAttributes = '';
        $top_trigger_area = get_field('top_trigger_area', 'option');
        if ($top_trigger_area) {
            $dataAttributes .= ' data-topTA="' . $top_trigger_area . '"';
        }
        $bottom_trigger_area = get_field('bottom_trigger_area', 'option');
        if ($bottom_trigger_area) {
            $dataAttributes .= ' data-bottomTA="' . $bottom_trigger_area . '"';
        }
        $scroll_fold_actions_checked_values = get_field('scroll_fold_actions', 'option');
        if ($scroll_fold_actions_checked_values):
            $dataAttributes .= ' data-scroll-actions="';
            foreach ($scroll_fold_actions_checked_values as $scroll_fold_actions_value):
                $dataAttributes .= $scroll_fold_actions_value . ' ';
            endforeach;
            $dataAttributes .= '"';
        endif;
        if (get_field('allow_custom_colors', 'option') == 1):
            $dataAttributes .= ' data-custom="true"';
        endif;

        if (get_field('reset', 'option') == 1):
            $dataAttributes = 'data-fold-reset="true" data-custom="true "';
        endif;

        $debug_log_checked_values = get_field('debug_log', 'option');
        if ($debug_log_checked_values):
            foreach ($debug_log_checked_values as $debug_log_value):
                $dataAttributes .= ' ' . esc_html($debug_log_value) . '="true" ';
            endforeach;
        endif;

        return $dataAttributes;
    }

endif;


if (!function_exists('get_wrapper')):
    /**
     * Class and Attributes for the main page wrapper. This is where the magic happens Most settings can be accessed here : domainname.com/wp-admin/admin.php?page=theme_options
     *
     * @since v1
     */
    function get_wrapper()
    {
        $output = "";
        $wrapperClasses = '';
        $ogClass = '';
        $addtlAttr = '';

        $scheme = get_scheme();

        if (str_contains($scheme, 'bg-custom') !== false) {
            $customBG = get_field('custom_bg_color');
            $customColorVar = get_field('custom_text_color');
            $customColor = '';
            if ($customColorVar) {
                if (str_contains($customColorVar, '#') !== false) {
                    $customColor = $customColorVar;
                } else {
                    $customColor = '#' . $customColorVar;
                }
                $customColor = ' --bgcustom: ' . $customColorVar;
                $addtlAttr .= 'data-color="' . $customColor . '" ';
            }
            $addtlAttr .= 'data-bg="' . $customBG . '"';
        }

        $ogClass = $scheme;
        $wrapperClasses .= $scheme;
        $output .= 'class="' . $wrapperClasses . '" ';
        $output .= 'data-og_class="' . $ogClass . '" ';
        $output .= $addtlAttr;

        return $output;
    }
endif;

if (!function_exists('get_main_classes')):
    /**
     * Class and Attributes for the main page wrapper. This is where the magic happens Most settings can be accessed here : domainname.com/wp-admin/admin.php?page=theme_options
     *
     * @since v1
     */
    function get_main_classes()
    {
        $navbar_position = get_theme_mod('navbar_position', 'static'); // Get custom meta-value.
        $output = "";
        if (isset($navbar_position) && 'fixed_top' === $navbar_position):
        elseif (isset($navbar_position) && 'fixed_bottom' === $navbar_position):
            $output = 'style="padding-bottom: 100px;"';
        endif;
        $output .= ' container';
        return $output;
    }
endif;

if (!function_exists('get_nav_attributes')):

    function get_nav_attributes()
    {
        $output = '';

        $navbar_page_scheme = get_field('navbar_color_settings', get_theme_main_postID());
        if ($navbar_page_scheme) {
            if (str_contains($navbar_page_scheme, 'transparent-dark') !== false) {
                $output .= '--theme-main-nav-bg: var(--bs-border-color-translucent);';
                $output .= '--theme-main-nav-link-color: var(--theme-main-contrasting-text-dark);';
                $output .= '--theme-main-nav-drawer-open-bg: var(--bs-dark);';
                $output .= '--theme-main-nav-drawer-open-color: var(--theme-main-contrasting-text-dark);';

            } elseif (str_contains($navbar_page_scheme, 'transparent-light') !== false) {
                $output .= '--theme-main-nav-bg: transparent;';
                $output .= '--theme-main-nav-link-color: var(--theme-main-contrasting-text-light);';
                $output .= '--theme-main-nav-drawer-open-bg: var(--bs-light);';
                $output .= '--theme-main-nav-drawer-open-color: var(--theme-main-contrasting-text-light);';
            } else {
                $output .= '--theme-main-nav-bg: var(--bs-' . $navbar_page_scheme . ' );';
                $output .= '--theme-main-nav-link-color: var(--theme-main-contrasting-text-' . $navbar_page_scheme . ' );';
                $output .= '--theme-main-nav-drawer-open-bg: var(--bs-' . $navbar_page_scheme . ' );';
                $output .= '--theme-main-nav-drawer-open-color: var(--theme-main-contrasting-text-' . $navbar_page_scheme . ' );';
            }
            $output = 'data-og-scheme="'. $navbar_page_scheme .'" style="' . $output . '"';
        }
        return $output;
    }

endif;

if (!function_exists('get_header_color')):
    function get_header_color()
    {
        $output = '';

        $navbar_page_scheme = get_field('navbar_color_settings', get_theme_main_postID());
        if ($navbar_page_scheme) {
            if (str_contains($navbar_page_scheme, 'transparent-dark') !== false) {
                $output .= '--theme-main-page-header-color: var(--theme-main-contrasting-text-dark);';

            } elseif (str_contains($navbar_page_scheme, 'transparent-light') !== false) {
                $output .= '--theme-main-page-header-color: var(--theme-main-contrasting-text-light);';
            } else {
                $output .= '--theme-main-page-header-color: var(--theme-main-contrasting-text-' . $navbar_page_scheme . ' );';
            }
            $output = 'style="' . $output . '"';
        }
        return $output;
    }

endif;
