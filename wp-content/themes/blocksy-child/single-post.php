<?php
get_header();


if (have_posts()) {
    the_post();
}

//if (
//    function_exists('blc_get_content_block_that_matches')
//    &&
//    blc_get_content_block_that_matches([
//        'template_type' => 'single',
//        'template_subtype' => 'canvas'
//    ])
//) {
//    echo blc_render_content_block(
//        blc_get_content_block_that_matches([
//            'template_type' => 'single',
//            'template_subtype' => 'canvas'
//        ])
//    );
//    have_posts();
//    wp_reset_query();
//    return;
//}

/**
 * Note to code reviewers: This line doesn't need to be escaped.
 * Function blocksy_output_hero_section() used here escapes the value properly.
 */
//if (apply_filters('blocksy:single:has-default-hero', true)) {
//    echo blocksy_output_hero_section([
//        'type' => 'type-2'
//    ]);
//}
?>

    <div class="ct-container-full pdp-wrap">

        <?php do_action('blocksy:single:container:top'); ?>

        <?php
        /**
         * Note to code reviewers: This line doesn't need to be escaped.
         * Function blocksy_single_content() used here escapes the value properly.
         */
        echo blocksy_single_content();
        ?>

        <?php do_action('blocksy:single:container:bottom'); ?>
    </div>

<?php

blocksy_display_page_elements('separated');

have_posts();
wp_reset_query();
get_footer();

