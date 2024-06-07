<?php
get_header();


if (have_posts()) {
    the_post();
}

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

