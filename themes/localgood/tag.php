<?php
get_header(); ?>

    <div class="contents_wrapper post">
        <div class="inner">
            <?php breadcrumbs(); ?>
        </div>
        <div class="topic_pic_wrapper">
            <div class="topic_pic">
                <div class="topic_pic_layout">
                    <?php
                    $cnt = 0;
                    if (have_posts()):
                        while (have_posts()): the_post();
                            $cnt++;
                            topic_box($cnt);
                        endwhile;
                    endif;
                    ?>
                    <div style="clear: both"></div>
                </div>
            </div><!--.topic_pic-->
        </div><!--.topic_pic_wrapper-->
    </div><!--.contents_wrapper-->

<?php get_footer();
?>