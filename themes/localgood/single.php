<?php
if(DEVICE == 'sp'):
    // スマホ
    get_template_part('single', 'sp');
else:
    get_header();
    ?>

    <div class="c-contents_wrapper c-w1096">

    <?php if (have_posts()): the_post(); ?>

        <?php breadcrumbs(); ?>

        <?php
        $cat                       = get_the_category();
        $page_value['title']       = $cat[0]->name;
        $page_value['description'] = $cat[0]->description;
        ?>
        <div class="c-page_title_wrapper">
            <h2 class="c-page_title c-title05"><img src="<?php echo get_option( 'lg_config__page_ttl_prefix' ); ?>"><?= $page_value['title']; ?></h2>
        </div>

        <div class="single_contents_box">

            <?php get_single_post(); ?>

            <div class="side_block gmap">
                <?php
                $data_lonlat = get_post_lonlat_attr();
                if (!empty($data_lonlat)):
                ?>
                <div id="gmap" <?= $data_lonlat; ?> style="height: 400px;margin-bottom:20px;"></div>
                <?php
                endif;
                ?>
            </div>

            <?php social_buttons(false, true); ?>

        </div><!-- .single_contents_box -->

        <?php writer_prof(); ?>

        <a class="c-back_button" href="<?= home_url('/lgnews/'); ?>">ニュース一覧へ戻る</a>
        <?php related_posts(); ?>
    <?php endif; ?>

    </div><!-- .c-contents_wrapper -->

<?php
get_footer();
endif;
?>