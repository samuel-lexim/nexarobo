<?php
const __VERSION = '8.5';

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
    wp_enqueue_style('pricing-css', get_stylesheet_directory_uri() . '/css/pricingPlan.css', [], __VERSION);
    wp_enqueue_style('listing-blog-css', get_stylesheet_directory_uri() . '/css/listing-blog.css', [], __VERSION);
    wp_enqueue_style('blog-detail-css', get_stylesheet_directory_uri() . '/css/blog-detail.css', [], __VERSION);

    // MemberPress
    wp_enqueue_style('mp-form', get_stylesheet_directory_uri() . '/css/memberpress-form.css', [], __VERSION);
    wp_enqueue_style('page-login', get_stylesheet_directory_uri() . '/css/page-login.css', [], __VERSION);


});

function add_custom_script_to_footer()
{
    // Slick JS
    if (is_front_page()
        || is_single()
        || is_home()
        || is_page('about')
        || is_page('products')
    ) {
        wp_enqueue_script('slick-js', get_stylesheet_directory_uri() . '/js/slick.min.js',
            [], __VERSION, true);
    }

    // Main js
    wp_enqueue_script('main-js', get_stylesheet_directory_uri() . '/js/main.js',
        [], __VERSION, true);

    // Home js
    if (is_front_page()) {
        wp_enqueue_script('home-js', get_stylesheet_directory_uri() . '/js/home.js',
            [], __VERSION, true);
    }

    // PDP JS
    if (is_single()) {
        wp_enqueue_script('pdp-js', get_stylesheet_directory_uri() . '/js/pdp.js',
            [], __VERSION, true);
    }

    // PLP JS
    if (is_page('products')) {
        wp_enqueue_script('plp-js', get_stylesheet_directory_uri() . '/js/plp.js',
            [], __VERSION, true);
    }

    // START - Memberpress js
    $data = get_plugin_data(BLOCKSY__FILE__);
    $blocksyVersion = $data['Version'];

    if (is_page('thank-you') ||
        is_singular('memberpressproduct') ||
        is_page('account')
    ) {
        wp_enqueue_style('ct-main-styles', get_template_directory_uri() . '/static/bundle/main.min.css', [], $blocksyVersion);
        wp_enqueue_style('typo', get_stylesheet_directory_uri() . '/css/typo.css', [], __VERSION,);
        wp_enqueue_style('elements', get_stylesheet_directory_uri() . '/css/elements.css', [], __VERSION,);
        wp_enqueue_style('layout', get_stylesheet_directory_uri() . '/css/layout.css', [], __VERSION,);
        wp_enqueue_style('wpform', get_stylesheet_directory_uri() . '/css/wpForm.css', [], __VERSION,);
        wp_enqueue_style('header', get_stylesheet_directory_uri() . '/css/header.css', [], __VERSION);
        wp_enqueue_style('fixed-header', get_stylesheet_directory_uri() . '/css/page-account-header.css', [], __VERSION);
        wp_enqueue_style('footer', get_stylesheet_directory_uri() . '/css/footer.css', [], __VERSION);
        wp_enqueue_style('mp-form', get_stylesheet_directory_uri() . '/css/memberpress-form.css', [], __VERSION);
        wp_enqueue_style('page-account-js', get_stylesheet_directory_uri() . '/css/page-account.css', [], __VERSION);
    }

    if (is_page('login')) {
        wp_enqueue_script('mpLogin-js', get_stylesheet_directory_uri() . '/js/mpLogin.js',
            [], __VERSION, true);
    }
    if (is_page('register')) {
        wp_enqueue_script('mpRegister-js', get_stylesheet_directory_uri() . '/js/mpRegister.js',
            [], __VERSION, true);
    }

    if (is_page('account')) {
        // wp_enqueue_script('stripe-js', 'https://js.stripe.com/v3/', array(), null);
        wp_enqueue_style('page-account-js', get_stylesheet_directory_uri() . '/css/page-account.css',
            [], __VERSION);
        wp_enqueue_script('mpAccount-js', get_stylesheet_directory_uri() . '/js/mpAccount.js',
            [], __VERSION, true);
    }

    if (is_page('thank-you')) {
        wp_enqueue_style('mp-thanks', get_stylesheet_directory_uri() . '/css/mp-thanks.css', [], __VERSION);
    }

    if (is_singular('memberpressproduct')) {
        wp_enqueue_style('mp-product', get_stylesheet_directory_uri() . '/css/mp-product.css', [], __VERSION);

    }
    // END - Memberpress js
}

add_action('wp_footer', 'add_custom_script_to_footer');

/* Disable WordPress Admin Bar for all users */
add_filter('show_admin_bar', '__return_false');

// Close button on header
add_filter('blocksy:main:offcanvas:close:icon', function ($icon) {
    $icon = '<svg width="22" height="21" viewBox="0 0 22 21" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.54927 21H0L8.24556 10.2368L0.746365 0H5.2601L11.1244 8.18941L17.2019 0H21.538L13.8966 10.3538L22 21H17.4152L11.0178 12.3719L4.54927 21Z" fill="black"/></svg>';
    return $icon;
});

// Change dashboard Posts to Products
function cp_change_post_object() {
    $get_post_type = get_post_type_object('post');
    $labels = $get_post_type->labels;
    $labels->name = 'Products';
    $labels->singular_name = 'Products';
    $labels->add_new = 'Add Product';
    $labels->add_new_item = 'Add Product';
    $labels->edit_item = 'Edit Product';
    $labels->new_item = 'Products';
    $labels->view_item = 'View Product';
    $labels->search_items = 'Search Product';
    $labels->not_found = 'No Products found';
    $labels->not_found_in_trash = 'No Products found in Trash';
    $labels->all_items = 'All Products';
    $labels->menu_name = 'Products';
    $labels->name_admin_bar = 'Products';
}
add_action( 'init', 'cp_change_post_object' );

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
        'id'   => 'ID',
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
        case 'id' :
            echo $post->ID;
            break;
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
            'orderby' => 'post__in'
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


// Category slider
add_shortcode('category_blog_listing', 'category_blog_listing_shortcode');
function category_blog_listing_shortcode($atts)
{
    // Extract shortcode attributes
    $query_args = [
        'post_type' => 'blog',
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
    ];

    // Fetch posts
    $slick_posts_query = new WP_Query($query_args);

    // Start building the output
    $output = '<div class="category-blog-main">';

    // Check if there are any posts
    if ($slick_posts_query->have_posts()) {
        $output .= '<div class="blog-list">';
        $i = 1;
        while ($slick_posts_query->have_posts()) {
            $slick_posts_query->the_post();
            $postID = get_the_ID();
            $link = get_the_permalink();
            $content = get_the_content();
            $acfSummaryDescription = get_field("summary_description", $postID);
            $viewTime = do_shortcode('[rt_reading_time postfix="min read" post_id=' . $postID . ']');
            if ($i < 2) {
//                $trimmed_content = wp_trim_words($content, 9, '...');
                $thumbnail = get_the_post_thumbnail($postID, 'full');
                $output .= '<div class="main-blog">';
                $output .= '<div class="container-img">';
                $output .= "<div class='_image'><a href='{$link}'>{$thumbnail}</a></div>";
                $output .= '</div>';
                $output .= '<div class="container-content">';
                $output .= '<p class="blog-nexarobo">Nexarobo Blog</p>';
                $output .= '<strong class="title-blog"><a href="' . $link . '">' . get_the_title() . '</a></strong>';
                $output .= '<p class="description">' . $acfSummaryDescription . '</p>';
                $output .= '<div class="tiny-time"><span class="day">' . get_the_date('F j, Y') .
                    '</span>|<span class="time">' . $viewTime . '</span></div>';
                $output .= '</div>';
                $output .= '</div>';
            } else {
                $trimmed_content = wp_trim_words($content, 14, '...');
                $thumbnail = get_the_post_thumbnail($postID, 'large');
                $output .= '<div class="blog">';
                $output .= '<div class="blog-round">';
                $output .= "<div class='_image'><a href='{$link}'>{$thumbnail}</a></div>";
                $output .= '<div class="container-box">';
                $output .= '<div class="tiny-time"><span class="day">' . get_the_date('F j, Y') .
                    '</span>|<span class="time">' . $viewTime . '</span></div>';
                $output .= '<strong class="title-blog"><a href="' . $link . '">' . get_the_title() . '</a></strong>';
                $output .= '<p class="description">' . $acfSummaryDescription . '</p>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';
            }
            $i++;
        }

        $output .= '</div>'; // .slick-slider
    }

    // Restore original post data
    wp_reset_postdata();
    $output .= '</div>';
    return $output;
}

//estimated reading time
function reading_time()
{
    global $post;
    $content = get_post_field('post_content', $post->ID);
    $word_count = str_word_count(strip_tags($content));
    $readingtime = ceil($word_count / 200);

    if ($readingtime == 1) {
        $timer = " minute";
    } else {
        $timer = " minutes";
    }
    $totalreadingtime = $readingtime . $timer;

    return $totalreadingtime;
}

// Customize sub-menu in header
if (!function_exists('blocksy_menu_get_child_svgs')) {
    function blocksy_menu_get_child_svgs()
    {
        // 'default' => '<svg class="ct-icon" width="8" height="8" viewBox="0 0 15 15"><path d="M2.1,3.2l5.4,5.4l5.4-5.4L15,4.3l-7.5,7.5L0,4.3L2.1,3.2z"/></svg>',
        return [
            'default' => '<svg class="88888" width="11" height="7" viewBox="0 0 11 7" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 1L5.5 5.5L10 1" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',

            'mobile-toggle-type-1' => '<svg class="ct-icon toggle-icon-1" width="15" height="15" viewBox="0 0 15 15"><path d="M3.9,5.1l3.6,3.6l3.6-3.6l1.4,0.7l-5,5l-5-5L3.9,5.1z"/></svg>',

            'mobile-toggle-type-2' => '<svg class="ct-icon toggle-icon-2" width="15" height="15" viewBox="0 0 15 15"><path d="M14.1,6.6H8.4V0.9C8.4,0.4,8,0,7.5,0S6.6,0.4,6.6,0.9v5.7H0.9C0.4,6.6,0,7,0,7.5s0.4,0.9,0.9,0.9h5.7v5.7C6.6,14.6,7,15,7.5,15s0.9-0.4,0.9-0.9V8.4h5.7C14.6,8.4,15,8,15,7.5S14.6,6.6,14.1,6.6z"/></svg>',

            'mobile-toggle-type-3' => '<svg class="ct-icon toggle-icon-3" width="12" height="12" viewBox="0 0 15 15"><path d="M2.6,5.8L2.6,5.8l4.3,5C7,11,7.3,11.1,7.5,11.1S8,11,8.1,10.8l4.2-4.9l0.1-0.1c0.1-0.1,0.1-0.2,0.1-0.3c0-0.3-0.2-0.5-0.5-0.5l0,0H3l0,0c-0.3,0-0.5,0.2-0.5,0.5C2.5,5.7,2.5,5.8,2.6,5.8z"/></svg>',
        ];
    }
}

// Memberpress - show Login / Logout button
function display_login_logout_link($attr)
{
    $output = '<div class="loginButton">';
    if (is_user_logged_in()) {
        // User is logged in
        $logout_url = wp_logout_url(home_url('/'));
        $currentUser = wp_get_current_user();
        $name = $currentUser->get('first_name');
        if (strlen($name) > 7) {
            $name = substr($name, 0, 7) . '...';
        }

        $output .= '<a href="javascript:void(0)" class="_dropdownClick _inner">' .
            '<span class="_ico_avatar">' .
            '<img class="_mobile" src="' . get_stylesheet_directory_uri() . '/images/headers/ico-avatar-blue.png' . '" width="25px" />' .
            '<img class="_desktop" src="' . get_stylesheet_directory_uri() . '/images/headers/ico-avatar-white.png' . '" width="25px" />' .

            //  '<svg class="_mobile" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="25" height="25" viewBox="0 0 25 25" fill="none"><rect width="25" height="25" fill="url(#pattern0_2173_1442)"/><defs><pattern id="pattern0_2173_1442" patternContentUnits="objectBoundingBox" width="1" height="1"><use xlink:href="#image0_2173_1442" transform="scale(0.00195312)"/></pattern><image id="image0_2173_1442" width="512" height="512" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAgAAAAIACAYAAAD0eNT6AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyhpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDkuMS1jMDAyIDc5LmE2YTYzOTY4YSwgMjAyNC8wMy8wNi0xMTo1MjowNSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIDI1LjkgKE1hY2ludG9zaCkiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6RDc4NzY5RkQxQjM0MTFFRkFEOEZGN0RCNjQ4OTk3RTQiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6RDc4NzY5RkUxQjM0MTFFRkFEOEZGN0RCNjQ4OTk3RTQiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpENzg3NjlGQjFCMzQxMUVGQUQ4RkY3REI2NDg5OTdFNCIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpENzg3NjlGQzFCMzQxMUVGQUQ4RkY3REI2NDg5OTdFNCIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PtFwh5UAAFtESURBVHja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"/></defs></svg>' .
            //  '<svg class="_desktop" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="25" height="25" viewBox="0 0 25 25" fill="none"><rect width="25" height="25" fill="url(#pattern0_2181_342)"/><defs><pattern id="pattern0_2181_342" patternContentUnits="objectBoundingBox" width="1" height="1"><use xlink:href="#image0_2181_342" transform="scale(0.00195312)"/></pattern><image id="image0_2181_342" width="512" height="512" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAgAAAAIACAYAAAD0eNT6AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyhpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDkuMS1jMDAyIDc5LmE2YTYzOTY4YSwgMjAyNC8wMy8wNi0xMTo1MjowNSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIDI1LjkgKE1hY2ludG9zaCkiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6RDc4NzY5RjkxQjM0MTFFRkFEOEZGN0RCNjQ4OTk3RTQiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6RDc4NzY5RkExQjM0MTFFRkFEOEZGN0RCNjQ4OTk3RTQiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpENzg3NjlGNzFCMzQxMUVGQUQ4RkY3REI2NDg5OTdFNCIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpENzg3NjlGODFCMzQxMUVGQUQ4RkY3REI2NDg5OTdFNCIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PiXzla0AAFVzSURBVHja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"/></defs></svg>' .

            '</span>' .
            '<span class="_name">' . $name . '</span>' .
            '<span class="_ico_arrow">' .
            '<svg xmlns="http://www.w3.org/2000/svg" width="11" height="7" viewBox="0 0 11 7" fill="none"><path d="M1 1.25L5.5 5.75L10 1.25" stroke="#37A7F4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>' .
            '</span>' .
            '</a>';

        $output .= '<div class="_accountDropMenu" style="display:none">' .
            '<a href="/account">My Account</a>' .
            '<a href="' . $logout_url . '">Log out</a>' .
            '</div>';


    } else {
        // User is not logged in
        // $login_url = wp_login_url(home_url('/login'));
        $output .= '<a class="_inner" href="/login">Log in</a>';
    }
    $output .= '</div>';
    return $output;
}

add_shortcode('login_logout_link', 'display_login_logout_link');

// Releated Blog
function get_related_posts_by_category_and_tag($post_id, $num_posts = 9)
{
    $related_posts = new WP_Query(
        [
            'post_type' => 'blog',
            'category__in' => wp_get_post_categories($post_id),
            'tag__in' => wp_get_post_tags($post_id, ['fields' => 'ids']),
            'post__not_in' => [$post_id],
            'posts_per_page' => $num_posts,
            'orderby' => 'rand'
        ]
    );
    //var_dump($post_id);
    return $related_posts;
}

function load_single_blog_scripts()
{
    if (is_singular('blog')) {
        wp_enqueue_script(
            'single-blog-js', // Tên định danh của script
            get_stylesheet_directory_uri() . '/js/single-blog.js', // Đường dẫn tới file script
            ['jquery'], // Các script phụ thuộc
            null, // Phiên bản của script (có thể dùng filemtime để tự động cập nhật khi file thay đổi)
            true // Tải script ở footer
        );
    }
}

add_action('wp_enqueue_scripts', 'load_single_blog_scripts');

// Hàm shortcode để hiển thị thời gian đọc
function reading_time_shortcode($atts)
{
    $postID = get_the_ID();
    $viewTime = do_shortcode('[rt_reading_time postfix="min read" post_id=' . $postID . ']');

    $output = '<div class="section-author-blog">';
    $output .= '<span class="day">' . get_the_date('F j, Y') .
        '</span>|<span class="time">' . $viewTime . '</span>';
    $output .= '</div>';

    return $output;
}

add_shortcode('reading_time', 'reading_time_shortcode');

//Capture any completed transaction (recurring and non-recurring) event
function mepr_capture_completed_transaction($event)
{
    /** @var MeprTransaction $transaction */
    $transaction = $event->get_data();
    $user = $transaction->user();

    if (isset($transaction->id)) { // set key = invoice_number
        $key = findInvoiceNumberFromTransId($transaction->id);
    }

    if (!isset($key) || !$key) { // set key = transaction_id
        $key = $transaction->id;
    }

    if (isset($user->ID) && isset($key) && $key) {
        $bill_street1 = get_user_meta($user->ID, "mepr-address-one", true);
        $bill_street2 = get_user_meta($user->ID, "mepr-address-two", true);
        $bill_city = get_user_meta($user->ID, "mepr-address-city", true);
        $bill_state = get_user_meta($user->ID, "mepr-address-state", true);
        $bill_zip = get_user_meta($user->ID, "mepr-address-zip", true);
        $bill_country = get_user_meta($user->ID, "mepr-address-country", true);
        $bill_email = $user->user_email;
        // Store billing address data
        update_user_meta($user->ID, $key . '_mepr-address-one', $bill_street1);
        update_user_meta($user->ID, $key . '_mepr-address-two', $bill_street2);
        update_user_meta($user->ID, $key . '_mepr-address-city', $bill_city);
        update_user_meta($user->ID, $key . '_mepr-address-state', $bill_state);
        update_user_meta($user->ID, $key . '_mepr-address-zip', $bill_zip);
        update_user_meta($user->ID, $key . '_mepr-address-country', $bill_country);
        update_user_meta($user->ID, $key . '_mepr-address-email', $bill_email);
    }
}

/**
 * add_action( 'mepr-event-transaction-completed', array( $this, 'create_invoice_number' ));
 * create_invoice_number has default priority = 10
 */
add_action('mepr-event-transaction-completed', 'mepr_capture_completed_transaction', 100);

function findInvoiceNumberFromTransId($transId = null)
{
    if (!$transId) {
        return null;
    }
    global $wpdb;
    $db = MePdfDB::fetch();
    $invoice_no = $wpdb->get_var(
        "SELECT `invoice_number` FROM {$db->invoice_numbers} WHERE `transaction_id`={$transId} LIMIT 1"
    );
    return $invoice_no;
}

/**
 * @param $invoiceNumber
 *
 * @return array|object|stdClass|null
 */
function getInvoiceByInvoiceNumber($invoiceNumber = null)
{
    if (!$invoiceNumber) {
        return null;
    }
    global $wpdb;
    $db = MePdfDB::fetch();
    $invoice = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT i.id, i.transaction_id, i.invoice_number, t.user_id 
            FROM {$db->invoice_numbers} AS i 
            LEFT JOIN {$wpdb->prefix}mepr_transactions AS t ON i.transaction_id = t.id 
            WHERE i.invoice_number = %d 
            LIMIT 1",
            $invoiceNumber
        )
    );

    return $invoice;
}

// Register and add the secret key setting field
function secret_key_settings_register() {
    add_settings_field(
        'secret_key_setting', // Setting ID
        'Secret Key Stripe', // Setting Title
        'secret_key_setting_callback', // Callback function
        'general' // Page to display the setting
    );

    register_setting('general', 'secret_key_setting', 'esc_attr');
}
add_action('admin_init', 'secret_key_settings_register');

// Display the secret key setting field
function secret_key_setting_callback() {
    $value = get_option('secret_key_setting', '');
    echo '<input type="text" id="secret_key_setting" name="secret_key_setting" value="' . esc_attr($value) . '" />';
}

/**
 * @param $chargeId
 * @return string
 */
function get_stripe_charge_network_details($chargeId) {
    $my_custom_value = get_option('secret_key_setting', '');
    if (!empty($my_custom_value)) {
        $secretKey = $my_custom_value;
    } else {
        $secretKey = '';
    }

    $ch = curl_init();

    // Set the URL for the request
    curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/charges/' . $chargeId);

    // Set the HTTP method to GET
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Set the header to include the authorization
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $secretKey,
    ]);

    // Execute the request
    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        return "";
    } else {
        // No cURL errors, decode the JSON response
        $decodedResponse = json_decode($response, true);

        if (isset($decodedResponse['payment_method_details']['card']['brand'])) {
            $networkDetails = $decodedResponse['payment_method_details']['card']['brand'];
            return $networkDetails;
        } else {
            return "";
        }
    }

    // Close the cURL handle
    curl_close($ch);
}
