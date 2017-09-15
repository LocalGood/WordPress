<?php get_header(); ?>
<div class="underlayer_wrapper single_data">
<?php include('s-post_nav.php');?>

<?php
if (have_posts()): the_post();

    ?>
    <div class="contents_wrapper02">
        <div class="inner">

            <?php
            global $cfs;

            $iframe_src = $cfs->get('iframe_src');
            $iframe_width = $cfs->get('iframe_width');
            $iframe_height = $cfs->get('iframe_height');

            if($iframe_src && $iframe_width && $iframe_height):
                ?>
                <div class="main_visual">
                    <iframe src="<?= esc_html($iframe_src); ?>" width="<?= esc_html($iframe_width); ?>" height="<?= esc_html($iframe_height); ?>"></iframe>
                </div>
            <?php
            elseif (has_post_thumbnail()):
                ?>
                <div class="main_visual">
                    <?php
                    the_post_thumbnail('single-data_visualization');
                    ?>
                </div>
            <?php
            endif;
            ?>
            <div class="single_contents_box">
                <div class="inner">
                    <?php the_content();?>
                </div>
            </div><!-- .single_contents_box -->

        </div><!-- .inner -->

        <div class="common_single_parts_info">
            <h2 class="common_single_parts_info__title">ライター紹介</h2>
            <?php writer_prof(); ?>
        </div>

        <a href="/data/" class="return_news_list">
            データ一覧へ戻る
        </a>

    </div><!-- .contents_wrapper -->
</div>
<?php
endif;
?>
<?php
    get_template_part('footer', 'sp');
?>