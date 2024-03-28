<?php
const __VERSION = '7.31';

if (!defined('WP_DEBUG')) {
    die('Direct access forbidden.');
}

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css', [], __VERSION);

    // custom components
    wp_enqueue_style('typo', get_stylesheet_directory_uri() . '/css/typo.css', [], __VERSION,);
    wp_enqueue_style('elements', get_stylesheet_directory_uri() . '/css/elements.css', [], __VERSION,);
    wp_enqueue_style('layout', get_stylesheet_directory_uri() . '/css/layout.css', [], __VERSION,);
    wp_enqueue_style('wpform', get_stylesheet_directory_uri() . '/css/wpForm.css', [], __VERSION,);

    // Slick
    wp_enqueue_style('slick-css', get_stylesheet_directory_uri() . '/css/slick/slick.min.css', [], __VERSION);
    wp_enqueue_style('slick-theme', get_stylesheet_directory_uri() . '/css/slick/slick-theme.min.css', [], __VERSION);
    wp_enqueue_style('slick-posts', get_stylesheet_directory_uri() . '/css/sc-slick_posts.css', [], __VERSION);

    // Page Sections
    wp_enqueue_style('header', get_stylesheet_directory_uri() . '/css/header.css', [], __VERSION);
    wp_enqueue_style('footer', get_stylesheet_directory_uri() . '/css/footer.css', [], __VERSION);
    wp_enqueue_style('page-home', get_stylesheet_directory_uri() . '/css/page-home.css', [], __VERSION);
    wp_enqueue_style('page-about', get_stylesheet_directory_uri() . '/css/page-about.css', [], __VERSION);
    wp_enqueue_style('page-get-your-quote', get_stylesheet_directory_uri() . '/css/page-get-your-quote.css', [], __VERSION);
    wp_enqueue_style('pdp-css', get_stylesheet_directory_uri() . '/css/PDP.css', [], __VERSION);
    wp_enqueue_style('listing-css', get_stylesheet_directory_uri() . '/css/listing.css', [], __VERSION);


    // Jquery
    wp_enqueue_script('jquery3', get_stylesheet_directory_uri() . '/js/jquery/jquery-3.7.1.min.js',
        [], __VERSION, true);


});

function add_custom_script_to_footer()
{
    // Slick JS
    wp_enqueue_script('slick-js', get_stylesheet_directory_uri() . '/js/slick.min.js',
        [], __VERSION, true);

    // Main js
    wp_enqueue_script('main-script', get_stylesheet_directory_uri() . '/js/main.js',
        [], __VERSION, true);

    // Custom JS for PDP
    if (is_single()) {
        wp_enqueue_script('pdp-js', get_stylesheet_directory_uri() . '/js/pdp.js',
            [], __VERSION, true);
    }
}

add_action('wp_footer', 'add_custom_script_to_footer');

/* Disable WordPress Admin Bar for all users */
add_filter('show_admin_bar', '__return_false');

// Close button on header
add_filter('blocksy:main:offcanvas:close:icon', function ($icon) {
    $icon = '<svg width="22" height="21" viewBox="0 0 22 21" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.54927 21H0L8.24556 10.2368L0.746365 0H5.2601L11.1244 8.18941L17.2019 0H21.538L13.8966 10.3538L22 21H17.4152L11.0178 12.3719L4.54927 21Z" fill="black"/></svg>';
    return $icon;
});

// Remove default image sizes here.
function remove_extra_image_sizes()
{
    foreach (get_intermediate_image_sizes() as $size) {
        if (!in_array($size, ['thumbnail', 'medium', 'medium_large', 'large'])) {
            remove_image_size($size);
        }
    }
}

add_action('init', 'remove_extra_image_sizes');

add_image_size('large', 500, 650, true);
add_image_size('medium_large', 251, 344, true); // not same the large ratio
add_image_size('medium', 450, 350, true);
add_image_size('thumbnail', 101, 101, true);

add_theme_support('large');
add_theme_support('medium_large');
add_theme_support('medium');
add_theme_support('thumbnail');
update_option('medium_large_size_w', 251);
update_option('medium_large_size_h', 344);

// END - Remove default image sizes here.


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

// Custom Blocksy Breadcrumbs
add_filter(
    'blocksy:breadcrumbs:items-array',
    function ($items) {
        $customItem = [
            'url' => '/products',
            'name' => 'Products'
        ];

        if (is_single()) {
            // Add Products item to the index 1
            array_splice($items, 1, 0, [$customItem]);

            // Remove the last item (Post Title) and the link on category (item index = 2)
            unset($items[3]);
        }
        return $items;
    }
);

// Custom shortcode to display posts with Slick slider
add_shortcode('slick_posts', 'custom_slick_posts_shortcode');
function custom_slick_posts_shortcode($atts)
{
    // Extract shortcode attributes
    $atts = shortcode_atts(
        [
            'post_type' => 'post',
            'limit' => 15,
            'order' => 'DESC',
            'list' => ''
        ],
        $atts,
        'slick_posts'
    );

    $ids = [];
    if ($atts['list']) {
        $ids = explode(",", $atts['list']);
    }

    // Query arguments
    if ($ids && count($ids) > 0) {
        $query_args = [
            'post_type' => $atts['post_type'],
            'posts_per_page' => $atts['limit'],
            'post__in' => $ids,
            'orderby' => 'date',
            'order' => $atts['order'],
        ];
    } else {
        $query_args = [
            'post_type' => $atts['post_type'],
            'posts_per_page' => $atts['limit'],
            'orderby' => 'date',
            'order' => $atts['order'],
        ];
    }

    // Fetch posts
    $slick_posts_query = new WP_Query($query_args);

    // Start building the output
    $output = '<section class="section-posts_slider">';

    // Check if there are any posts
    if ($slick_posts_query->have_posts()) {
        $output .= '<div class="slider-slick_posts">';

        while ($slick_posts_query->have_posts()) {
            $slick_posts_query->the_post();
            $postID = get_the_ID();
            $link = get_the_permalink();
            // Get the ACF featured image
            $acfHomeImgID = get_field("image_for_home_slider", $postID);
            $thumbnail = wp_get_attachment_image($acfHomeImgID, 'medium');

            $output .= '<div class="slider-slick_posts-item">';
            $output .= "<a class='_link' href='{$link}'>";
            $output .= '<div class="_acfImage">' . $thumbnail;

            $output .= '<div class="_bottomInner">';
            $output .= '<h4 class="_h4 s24">' . get_the_title() . '</h2>';
            $output .= '<p class="_excerpt">' . get_the_excerpt() . '</p>';
            $output .= '</div>';

            $output .= '</div>';
            $output .= '</a></div>';
        }

        $output .= '</div>'; // .slick-slider
    }

    // Restore original post data
    wp_reset_postdata();
    $output .= '</section>'; // .slick-posts
    return $output;
}


// Category slider
add_shortcode('category_listing', 'category_listing_shortcode');
function category_listing_shortcode($atts)
{
    // Extract shortcode attributes
    $atts = shortcode_atts(
        [
            'post_type' => 'post',
            'cat' => 'cooking-robots',
            'heading' => '',
            'limit' => 20,
            'order' => 'DESC'
        ],
        $atts,
        'category_listing'
    );

    // Query arguments
    $query_args = [
        'post_type' => $atts['post_type'],
        'post_status' => 'publish',
        'tax_query' => [
            [
                'taxonomy' => 'category',
                'field' => 'slug',
                'terms' => $atts['cat'],
            ],
        ],
        'posts_per_page' => $atts['limit'],
        'orderby' => 'date',
        'order' => $atts['order'],
    ];

    // Get Category
    $category = get_term_by('slug', $atts['cat'], 'category');

    // Fetch posts
    $slick_posts_query = new WP_Query($query_args);

    // Start building the output
    $output = '<section class="plp-category_section">';

    $output .= "<h2 class='_categoryHeading'>{$category->name}</h2>";


    // Check if there are any posts
    if ($slick_posts_query->have_posts()) {
        $output .= '<div class="plp-category_slick topRightArrow">';

        while ($slick_posts_query->have_posts()) {
            $slick_posts_query->the_post();
            $postID = get_the_ID();
            $link = get_the_permalink();
            $thumbnail = get_the_post_thumbnail($postID, 'medium_large');

            $output .= '<div class="category_slick-item">'; // item-wrap
            $output .= '<div class="_itemInner">'; // _itemInner

            $output .= "<div class='_image'><a href='{$link}'>{$thumbnail}</a></div>";

            $output .= '<div class="_bottomInner">';
            $output .= '<h2 class="_tit">' . get_the_title() . '</h2>';

            // Tag
            $tags = get_the_tags();
            $tag_cloud = '';
            if ($tags) {
                $tag_links = [];
                foreach ($tags as $tag) {
                    $tag_links[] = '#' . $tag->name;
                }
                $tag_cloud = implode(' ', $tag_links);
            }

            $output .= '<p class="_tag">Recommended for:<br>' . $tag_cloud . '</p>';
            $output .= "<a class='button' href='{$link}'>Learn More</a>";
            $output .= '</div>';

            $output .= '</div>'; // ._itemInner
            $output .= '</div>'; // .category_slick-item
        }

        $output .= '</div>'; // .slick-slider
    }

    // Restore original post data
    wp_reset_postdata();
    $output .= '</section>';
    return $output;
}

