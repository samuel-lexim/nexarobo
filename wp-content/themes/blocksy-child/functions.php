<?php
const __VERSION = '7.7';

if (!defined('WP_DEBUG')) {
    die('Direct access forbidden.');
}

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css', [], __VERSION);

    // custom css
    wp_enqueue_style('typo', get_stylesheet_directory_uri() . '/css/typo.css', [], __VERSION,);
    wp_enqueue_style('elements', get_stylesheet_directory_uri() . '/css/elements.css', [], __VERSION,);
    wp_enqueue_style('layout', get_stylesheet_directory_uri() . '/css/layout.css', [], __VERSION,);
    wp_enqueue_style('wpform', get_stylesheet_directory_uri() . '/css/wpForm.css', [], __VERSION,);
    wp_enqueue_style('header', get_stylesheet_directory_uri() . '/css/header.css', [], __VERSION);
    wp_enqueue_style('footer', get_stylesheet_directory_uri() . '/css/footer.css', [], __VERSION);
    wp_enqueue_style('page-home', get_stylesheet_directory_uri() . '/css/page-home.css', [], __VERSION);
    wp_enqueue_style('page-about', get_stylesheet_directory_uri() . '/css/page-about.css', [], __VERSION);
    wp_enqueue_style('page-get-your-quote', get_stylesheet_directory_uri() . '/css/page-get-your-quote.css', [], __VERSION);


    // Jquery
    wp_enqueue_script('jquery3', get_stylesheet_directory_uri() . '/js/jquery/jquery-3.7.1.min.js',
        [], __VERSION, true);


});

function add_custom_script_to_footer()
{
    // Main js
    wp_enqueue_script('main-script', get_stylesheet_directory_uri() . '/js/main.js',
        [], __VERSION, true);
}

add_action('wp_footer', 'add_custom_script_to_footer');

/* Disable WordPress Admin Bar for all users */
add_filter('show_admin_bar', '__return_false');

// Close button on header
add_filter('blocksy:main:offcanvas:close:icon', function ($icon) {
    $icon = '<svg width="22" height="21" viewBox="0 0 22 21" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.54927 21H0L8.24556 10.2368L0.746365 0H5.2601L11.1244 8.18941L17.2019 0H21.538L13.8966 10.3538L22 21H17.4152L11.0178 12.3719L4.54927 21Z" fill="black"/></svg>';
    return $icon;
});

// Add Page Slug Body Class
function add_slug_body_class($classes)
{
    global $post;
    if (isset($post)) {
        $classes[] = $post->post_type . '-' . $post->post_name;
    }
    return $classes;
}

add_filter('body_class', 'add_slug_body_class');

// Add slug column for PAGE posts
add_filter("manage_page_posts_columns", "page_columns");
function page_columns($columns)
{
    $add_columns = [
        'slug' => 'Slug',
    ];
    $res = array_slice($columns, 0, 2, true) +
        $add_columns +
        array_slice($columns, 2, count($columns) - 1, true);

    return $res;
}

add_action("manage_page_posts_custom_column", "my_custom_page_columns");
function my_custom_page_columns($column)
{
    global $post;
    switch ($column) {
        case 'slug' :
            echo $post->post_name;
            break;
    }
}

add_filter("manage_post_posts_columns", "page_columns");
add_action("manage_post_posts_custom_column", "my_custom_page_columns");

add_filter("manage_ct_content_block_posts_columns", "page_columns");
add_action("manage_ct_content_block_posts_custom_column", "my_custom_page_columns");

// END - Add slug column for PAGE posts


// Custom shortcode to display posts with Slick slider
function custom_slick_posts_shortcode($atts)
{
    // Extract shortcode attributes
    $atts = shortcode_atts(
        [
            'post_type' => 'post',
            'limit' => 15,
        ],
        $atts,
        'slick_posts'
    );

    // Query arguments
    $query_args = [
        'post_type' => $atts['post_type'],
        'posts_per_page' => $atts['limit'],
    ];

    // Fetch posts
    $slick_posts_query = new WP_Query($query_args);

    // Start building the output
    $output = '<div class="slick-posts">';

    // Check if there are any posts
    if ($slick_posts_query->have_posts()) {
        $output .= '<div class="slick-slider">';

        while ($slick_posts_query->have_posts()) {
            $slick_posts_query->the_post();
            $output .= '<div class="slick-slide">';
            // Get the featured image
            if (has_post_thumbnail()) {
                $output .= '<div class="featured-image">' . get_the_post_thumbnail() . '</div>';
            }
            $output .= '<h2>' . get_the_title() . '</h2>';
            $output .= '<div class="entry-content">' . get_the_content() . '</div>';
            $output .= '</div>'; // .slick-slide
        }

        $output .= '</div>'; // .slick-slider
    } else {
        $output .= '<p>No posts found</p>';
    }

    // Restore original post data
    wp_reset_postdata();
    $output .= '</div>'; // .slick-posts
    return $output;
}

add_shortcode('slick_posts', 'custom_slick_posts_shortcode');