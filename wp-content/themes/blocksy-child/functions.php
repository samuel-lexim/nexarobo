<?php

if (!defined('WP_DEBUG')) {
    die('Direct access forbidden.');
}

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');

    // custom css
    wp_enqueue_style('main-css', get_stylesheet_directory_uri() . '/css/main-style.css');
});


/* Disable WordPress Admin Bar for all users */
add_filter('show_admin_bar', '__return_false');

// Close button
add_filter('blocksy:main:offcanvas:close:icon', function ($icon) {
    $icon = '<svg width="22" height="21" viewBox="0 0 22 21" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.54927 21H0L8.24556 10.2368L0.746365 0H5.2601L11.1244 8.18941L17.2019 0H21.538L13.8966 10.3538L22 21H17.4152L11.0178 12.3719L4.54927 21Z" fill="black"/></svg>';
    return $icon;
});

