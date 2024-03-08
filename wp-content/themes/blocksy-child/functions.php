<?php

if (! defined('WP_DEBUG')) {
	die( 'Direct access forbidden.' );
}

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

    // custom css
    wp_enqueue_style('main-css', get_stylesheet_directory_uri() .'/css/main-style.css');
});


/* Disable WordPress Admin Bar for all users */
add_filter('show_admin_bar', '__return_false');