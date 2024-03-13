<?php
const __VERSION = '7.0';

if (!defined('WP_DEBUG')) {
    die('Direct access forbidden.');
}

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css', [], __VERSION);

    // Slick CSS
//    wp_enqueue_style('slick', get_stylesheet_directory_uri() . '/css/slick/slick.css', [], __VERSION);
//    wp_enqueue_style('slick-theme', get_stylesheet_directory_uri() . '/css/slick/slick-theme.css', [], __VERSION);

    // custom css
    wp_enqueue_style('typo', get_stylesheet_directory_uri() . '/css/typo.css', [], __VERSION,);
    wp_enqueue_style('layout', get_stylesheet_directory_uri() . '/css/layout.css', [], __VERSION,);
    wp_enqueue_style('header', get_stylesheet_directory_uri() . '/css/header.css', [], __VERSION);
    wp_enqueue_style('footer', get_stylesheet_directory_uri() . '/css/footer.css', [], __VERSION);
    wp_enqueue_style('page-home', get_stylesheet_directory_uri() . '/css/page-home.css', [], __VERSION);
    wp_enqueue_style('page-about', get_stylesheet_directory_uri() . '/css/page-about.css', [], __VERSION);


    // Jquery
    wp_enqueue_script('jquery3', get_stylesheet_directory_uri() . '/js/jquery/jquery-3.7.1.min.js',
        array(), __VERSION, true);
//    wp_enqueue_script('jquery-migrate', get_stylesheet_directory_uri() . '/js/jquery/jquery-migrate-1.2.1.min.js',
//        array(), __VERSION, true);

    // Slick js
    wp_enqueue_script('slick-js', get_stylesheet_directory_uri() . '/css/slick/slick.min.js',
        array(), __VERSION, true);
});

function add_custom_script_to_footer() {
    // Main js
    wp_enqueue_script('main-script', get_stylesheet_directory_uri() . '/js/main.js',
        array(), __VERSION, true);
}
add_action('wp_footer', 'add_custom_script_to_footer');

/* Disable WordPress Admin Bar for all users */
add_filter('show_admin_bar', '__return_false');

// Close button
add_filter('blocksy:main:offcanvas:close:icon', function ($icon) {
    $icon = '<svg width="22" height="21" viewBox="0 0 22 21" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.54927 21H0L8.24556 10.2368L0.746365 0H5.2601L11.1244 8.18941L17.2019 0H21.538L13.8966 10.3538L22 21H17.4152L11.0178 12.3719L4.54927 21Z" fill="black"/></svg>';
    return $icon;
});


// Custom shortcode to display posts with Slick slider
function custom_slick_posts_shortcode($atts) {
    // Extract shortcode attributes
    $atts = shortcode_atts(
        array(
            'post_type' => 'post',
            'limit' => 15,
        ),
        $atts,
        'slick_posts'
    );

    // Query arguments
    $query_args = array(
        'post_type' => $atts['post_type'],
        'posts_per_page' => $atts['limit'],
    );

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