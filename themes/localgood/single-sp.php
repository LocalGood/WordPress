<?php get_header(); ?>
    <div class="underlayer_wrapper">
        <?php breadcrumbs(); ?>
        <?php include('s-post_nav.php'); ?>
        <?php
        if (have_posts()): the_post();
            ?>
            <div class="contents_wrapper<?php if (in_category('news')) : ?> single_news<?php endif; ?>">
                <div class="inner">
                    <div class="single_contents_box">
                        <div class="inner">
                            <?php get_single_post(); ?>
                        </div>
                        <div class="side_block gmap">
                            <?php
                            $data_lonlat = get_post_lonlat_attr();
                            if (!empty($data_lonlat)):
                                ?>
                                <div id="gmap" <?php echo $data_lonlat; ?>
                                     style="height: 400px;margin-bottom:20px;"></div>
                            <?php
                            endif;
                            ?>
                        </div>
                        <?php
                        social_buttons(false, true);
                        ?>
                    </div><!-- .single_contents_box -->
                    <div class="common_single_parts_info">
                        <h2 class="common_single_parts_info__title">ライター紹介</h2>
                        <?php writer_prof(); ?>
                    </div>
                    <?php if (in_category('news')) : ?>
                        <a href="<?php echo home_url('/lgnews/'); ?>" class="return_news_list">
                            ニュース一覧へ戻る
                        </a>
                    <?php elseif (in_category('local_good_player')) : ?>
                        <a href="<?php echo home_url('/lgplayer/'); ?>" class="return_news_list">
                            人/団体一覧へ戻る
                        </a>
                    <?php endif; ?>
                </div><!-- .inner -->
                <?php related_posts(); ?>
            </div><!-- .contents_wrapper -->
        <?php
        endif;
        ?>
    </div>
<?php
get_template_part('footer', 'sp');
?>