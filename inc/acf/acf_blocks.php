<?php 
acf_add_options_page(array(
    'menu_slug' => 'theme_options',
    'page_title' => 'Theme Options',
    'active' => true,
    'menu_title' => 'Theme Options',
    'capability' => 'edit_posts',
    'parent_slug' => '',
    'position' => '',
    'icon_url' => '',
    'redirect' => false,
    'post_id' => 'options',
    'autoload' => false,
    'update_button' => 'Update',
    'updated_message' => 'Options Updated',
));