<?php get_header(); ?>
<div class="underlayer_wrapper">
    <?php include( 's-post_nav.php' ); ?>
    <div class="underlayer_title_area">
        <div class="submit_subjects_link">
            <h3>
                あなたの声を投稿しましょう
            </h3>
            <div class="common_underlayer_title-h2__sub_title text">
                あなたの身の回りの良い所や気になっていることを教えてください。
                <a class="subject_post_box__submit_button" href="<?php echo home_url( '/submit_subject/' ); ?>">
                    投稿する
                </a>
            </div>
        </div><!-- /.submit_subjects_link -->
    </div>

    <div class="knows_map_bar_padding">
        <?php knows_map_bar(); ?>
    </div><!-- /.knows_map_bar_padding -->

    <div id="gmap" ></div>

    <div class="list_pic_wrapper">
        <div class="list_pic">
            <div class="list_pic_layout">
                <?php
                if(have_posts()):
                while (have_posts()): the_post();
                    article_box();
                endwhile;
                endif;
                ?>
            </div>

            <div class="underlayer_title_area">
                <div class="submit_subjects_link">
                    <h3>
                        あなたの声を投稿しましょう
                    </h3>
                    <div class="common_underlayer_title-h2__sub_title text">
                        あなたの身の回りの良い所や気になっていることを教えてください。
                        <a class="subject_post_box__submit_button" href="<?php echo home_url( '/submit_subject/' ); ?>">
                            投稿する
                        </a>
                    </div>
                </div><!-- /.submit_subjects_link -->
            </div>

            <div class="pager">
                <div class="pager_container">
                    <div class="tablenav">
                        <?php
                        paging();
                        ?>
                    </div>
                </div>
            </div>
        </div><!--.list_pic-->
    </div><!--.list_pic_wrapper-->
</div>
<?php
get_template_part( 'footer', 'sp' );
?>
