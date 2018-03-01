<?php
if (DEVICE == 'sp'):
    // スマホ
    get_template_part('single', 'sp');
else:
    get_header();
    ?>
    <div class="c-contents_wrapper c-w1096">
        <?php if (have_posts()): the_post(); ?>
            <?php breadcrumbs(); ?>
            <?php
            $cat = get_the_category();
            ?>
            <div class="c-page_title_wrapper">
                <h2 class="c-page_title c-title05">
                    <img src="<?php echo get_option('lg_config__page_ttl_prefix'); ?>"><?php echo $page_value['title']; ?>
                </h2>
            </div>
            <div class="single_contents_box">
                <?php get_single_post(); ?>
                <div class="side_block gmap">
                    <?php
                    $data_lonlat = get_post_lonlat_attr();
                    if (!empty($data_lonlat)):
                        ?>
                        <div id="gmap" <?php echo $data_lonlat; ?> style="height: 400px;margin-bottom:20px;"></div>
                    <?php
                    endif;
                    ?>
                </div>
                <?php
                social_buttons(false, true);
                ?>
            </div><!-- .single_contents_box -->
            <?php writer_prof(); ?>
            <?php if (in_category('news')) : ?>
                <a href="<?php echo home_url('/lgnews/'); ?>" class="return_news_list">
                    ニュース一覧へ戻る
                </a>
            <?php elseif (in_category('local_good_player')) : ?>
                <a href="<?php echo home_url('/lgplayer/'); ?>" class="return_news_list">
                    人/団体一覧へ戻る
                </a>
            <?php endif; ?>
            <?php related_posts(); ?>
        <?php endif; ?>
    </div><!-- .c-contents_wrapper -->
    <?php
    get_footer();
endif;