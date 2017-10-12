<?php
if (DEVICE == 'sp'):
    // スマホ
    get_template_part( 'single', 'data-sp' );
else:
    get_header();
    ?>

    <div class="c-contents_wrapper c-w1096">

    <?php if (have_posts()): the_post(); ?>

        <?php breadcrumbs(); ?>

        <div class="c-page_title_wrapper">
            <h2 class="c-page_title c-title05"><img src="<?php echo get_option( 'lg_config__page_ttl_prefix' ); ?>">データ</h2>
            <p class="c-page_title_subtext">地域のデータを見やすい形でまとめました。</p>
        </div>

        <?php
        global $cfs;

        $iframe_src    = $cfs->get( 'iframe_src' );
        $iframe_width  = $cfs->get( 'iframe_width' );
        $iframe_height = $cfs->get( 'iframe_height' );

        if ($iframe_src && $iframe_width && $iframe_height):
            ?>
            <div class="main_visual">
                <iframe src="<?php echo esc_html( $iframe_src ); ?>" width="<?php echo esc_html( $iframe_width ); ?>"
                        height="<?php echo esc_html( $iframe_height ); ?>"></iframe>
            </div>
            <?php
        elseif (has_post_thumbnail()):
            ?>
            <div class="main_visual">
                <?php
                the_post_thumbnail( 'single-data_visualization' );
                ?>
            </div>
            <?php
        endif;
        ?>
        <div class="single_contents_box">
            <?php get_single_post(); ?>
        </div><!-- .single_contents_box -->

        <a class="c-back_button" href="<?php echo home_url('/data/'); ?>">データ一覧へ戻る</a>
    <?php endif; ?>

    </div><!-- .c-contents_wrapper -->

    <?php
    get_footer();
endif;
?>