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
        <?php
        $related_posts = get_related_posts_by_category_and_tag(get_the_ID(), 5);
        if ($related_posts->have_posts()) {
            echo '<div class="blog-related-full">';
                echo '<div class="blog-related-main">';
                    echo '<h3>Related Posts</h3>';
                    echo '<section class="section-blogs_slider">';
                        echo     '<div class="slider-slick_blog">';
                        while ($related_posts->have_posts()) {
                            $related_posts->the_post();
                            $postID = get_the_ID();
                            $link = get_the_permalink();
                            $content = get_the_content();
                            $acfSummaryDescription = get_field("summary_description", $postID);
                            $thumbnail = get_the_post_thumbnail($postID, 'large');
                            $viewTime =  do_shortcode('[rt_reading_time postfix="min read" post_id='.$postID.']');
                            ?>
                            <div class="blog">
                                <div class="blog-round">
                                    <div class='_image'>
                                        <a href='<?php the_permalink(); ?>'><?= $thumbnail ?></a>
                                    </div>
                                </div>
                                <div class="container-box">
                                    <div class="tiny-time">
                                        <span class="author-blog"><?php the_author(); ?></span>|<span class="day"><?= get_the_date('F j, Y') ?></span>|<span class="time"><?= $viewTime; ?></span>
                                    </div>
                                    <strong class="title-blog"><a href="<?php the_permalink(); ?>"> <?php the_title() ?></a></strong>
                                    <p class="description"><?= $acfSummaryDescription ?></p>
                                </div>
                            </div>
                            <?php
                        }
                        echo '</div>';
                    echo '</section>';
                echo '</div>';
            echo '</div>';
            wp_reset_postdata();
        }
        ?>
        <?php do_action('blocksy:single:container:bottom'); ?>
    </div>

<?php

blocksy_display_page_elements('separated');

have_posts();
wp_reset_query();
get_footer();

