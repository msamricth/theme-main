<?php
/**
 * Template Name: Blog Index
 * Description: The template for displaying the Blog index /blog.
 *
 */

get_header();
echo get_the_fold();
get_template_part('templates/archive/loop');

get_footer();
