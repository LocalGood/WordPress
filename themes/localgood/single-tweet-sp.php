<?php get_header(); ?>
    <div class="underlayer_wrapper tweet-single_wrapper">
        <?php breadcrumbs(); ?>
        <?php include('s-post_nav.php'); ?>
        <?php
        if (have_posts()): the_post();
            ?>
            <div class="contents_wrapper">
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
                        only_buttons(false);
                        LG::like();
                        LG::comments();
                        social_buttons(false, 'only');
                        ?>
                    </div><!-- .single_contents_box -->
                    <a href="<?php echo home_url('/subject/'); ?>" class="return_news_list">
                        みんなの声へ戻る
                    </a>
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