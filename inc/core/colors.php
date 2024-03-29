<?php


if (!function_exists('theme_main_color_array')) {
    /**
     *
     * @since v1
     */
    function theme_main_color_array()
    {
        $primary_color = get_field('primary_color', 'option');
        $secondary_color = get_field('secondary_color', 'option');
        $info_color = get_field('info_color', 'option');
        $error_color = get_field('error_color', 'option');
        $success_color = get_field('success_color', 'option');
        $dark_color = get_field('dark_color', 'option');
        $light_color = get_field('light_color', 'option');
        $gray500 = get_field('gray-500', 'option');
        $gray600 = get_field('gray-600', 'option');
        $gray800 = get_field('gray-800', 'option');
        $gray900 = get_field('gray-900', 'option');
        $primary_color = array(
            'name' => esc_attr__('Primary Color', theme_namespace()),
            'slug' => 'primary',
            'color' => $primary_color,
        );
        $secondary_color = array(
            'name' => esc_attr__('Secondary Color', theme_namespace()),
            'slug' => 'secondary',
            'color' => $secondary_color,
        );
        $info_color = array(
            'name' => esc_attr__('info Color', theme_namespace()),
            'slug' => 'info',
            'color' => $info_color,
        );
        $error_color = array(
            'name' => esc_attr__('error Color', theme_namespace()),
            'slug' => 'danger',
            'color' => $error_color,
        );
        $success_color = array(
            'name' => esc_attr__('success Color', theme_namespace()),
            'slug' => 'success',
            'color' => $success_color,
        );
        $dark_color = array(
            'name' => esc_attr__('dark Color', theme_namespace()),
            'slug' => 'dark',
            'color' => $dark_color,
        );
        $light_color = array(
            'name' => esc_attr__('Light Color', theme_namespace()),
            'slug' => 'light',
            'color' => $light_color,
        );
        $gray500 = array(
            'name' => esc_attr__('gray-500 Color', theme_namespace()),
            'slug' => 'gray-500',
            'color' => $gray500,
        );
        $gray600 = array(
            'name' => esc_attr__('gray-500 Color', theme_namespace()),
            'slug' => 'gray-600',
            'color' => $gray600,
        );
        $gray800 = array(
            'name' => esc_attr__('gray-500 Color', theme_namespace()),
            'slug' => 'gray-800',
            'color' => $gray800,
        );
        $gray900 = array(
            'name' => esc_attr__('gray-500 Color', theme_namespace()),
            'slug' => 'gray-900',
            'color' => $gray900,
        );
        $colorScheme = array($primary_color, $secondary_color, $info_color, $error_color, $success_color, $dark_color, $light_color, $gray500, $gray600, $gray800, $gray900);
        return $colorScheme;
    }
}
if (!function_exists('theme_main_primary_colors')) {
    function theme_main_primary_colors()
    {
        $primary_color = get_field('primary_color', 'option');
        $secondary_color = get_field('secondary_color', 'option');
        $info_color = get_field('info_color', 'option');
        $error_color = get_field('error_color', 'option');
        $success_color = get_field('success_color', 'option');
        $dark_color = get_field('dark_color', 'option');
        $light_color = get_field('light_color', 'option');
        $primary_color = array(
            'name' => esc_attr__('Primary Color', theme_namespace()),
            'slug' => 'primary',
            'color' => $primary_color,
        );
        $secondary_color = array(
            'name' => esc_attr__('Secondary Color', theme_namespace()),
            'slug' => 'secondary',
            'color' => $secondary_color,
        );
        $info_color = array(
            'name' => esc_attr__('info Color', theme_namespace()),
            'slug' => 'info',
            'color' => $info_color,
        );
        $error_color = array(
            'name' => esc_attr__('error Color', theme_namespace()),
            'slug' => 'danger',
            'color' => $error_color,
        );
        $success_color = array(
            'name' => esc_attr__('success Color', theme_namespace()),
            'slug' => 'success',
            'color' => $success_color,
        );
        $dark_color = array(
            'name' => esc_attr__('dark Color', theme_namespace()),
            'slug' => 'dark',
            'color' => $dark_color,
        );
        $light_color = array(
            'name' => esc_attr__('Light Color', theme_namespace()),
            'slug' => 'light',
            'color' => $light_color,
        );
        $colorScheme = array($primary_color, $secondary_color, $info_color, $error_color, $success_color, $dark_color, $light_color);
        return $colorScheme;
    }
}
if (!function_exists('get_the_fold')) {
    function get_the_fold()
    {
        $classes = 'fold match-nav ';
        $classes .= 'match_' . get_scheme_new();
        return '<div class="' . $classes . '"></div>';
    }
}
if (!function_exists('get_theme_main_colors_depth')) {
    function get_theme_main_colors_depth($color)
    {
        $primary_colors = theme_main_primary_colors();

        foreach ($primary_colors as &$primary_color) {
            $prefixColor = $primary_color['slug'];
            $prefixHexcode = $primary_color['color'];

            if (str_contains($prefixColor, $color)) {
                $rgb = HTMLToRGBforComparison($prefixHexcode);
                $hsl = RGBToHSL($rgb);
                if ($hsl->lightness > 150) {
                    $output = 'dark';
                } else {
                    $output = 'light';
                }
            }
        }
        if (isset($output)) {
            return $output;
        }

    }
}