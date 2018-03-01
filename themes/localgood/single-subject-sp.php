<?php get_header(); ?>

<?php
if (have_posts()): the_post();
    ?>
    <div class="contents_wrapper underlayer_wrapper tweet-single_wrapper">
        <?php breadcrumbs(); ?>
        <div class="inner">

            <div class="underlayer_title_area">
                <h2 class="common_underlayer_title-h2">
                    <img src="<?php echo get_option('lg_config__page_ttl_prefix'); ?>">
                    みんなの声
                </h2>
                <div class="common_underlayer_title-h2__sub_title">
                    地域について寄せられた声の一覧です。
                </div>
            </div>

            <div class="single_contents_box">
                <div class="single_contents_box__inner">
                    <div class="author_area clearfix">
                        <div class="thumbnail">
                            <?php
                            $user = get_subject_user_meta(false, '', 36);
                            echo $user['avatar']; ?>
                        </div>
                        <div class="author_area__text">
                            <div class="author_area__text__name">
                                <?php echo $user['name']; ?>
                            </div>
                            <div class="author_area__text__date">
                                <?php the_date('Y.m.d'); ?>
                            </div>
                        </div>
                    </div><!-- /.author_area -->
                    <div class="inner">
                        <?php the_content(); ?>
                    </div>
                    <?php
                    $attached_medias_obj = get_attached_media('image', $post->ID);
                    foreach ($attached_medias_obj as $id => $obj) {
                        echo wp_get_attachment_image($obj->ID, 'medium');
                    }
                    ?>
                </div><!-- /.single_contents_box__inner -->

                <div class="side_block gmap">
                    <?php
                    $data_lonlat = get_post_lonlat_attr();
                    if (!empty($data_lonlat)):
                        ?>
                        <div id="gmap" <?php echo $data_lonlat; ?> style="height: 300px;margin-bottom:20px;"></div>
                    <?php
                    endif;
                    ?>
                </div>
                <?php
                only_buttons(false);
                LG::like();
                LG::comments();
                social_buttons(false, 'only');
                ?>
            </div><!-- .single_contents_box -->

            <a href="<?php echo home_url('/subject/'); ?>" class="return_news_list">
                みんなの声一覧へ戻る
            </a>

        </div><!-- .inner -->
        <?php related_subjects_or_tweets(); ?>
    </div><!-- .contents_wrapper -->
<?php
endif;
?>
<?php
get_template_part('footer', 'sp');
?>