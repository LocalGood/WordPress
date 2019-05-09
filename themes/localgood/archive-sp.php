<?php get_header(); ?>
<div class="underlayer_wrapper">
    <?php include('s-post_nav.php'); ?>
    <div class="underlayer_title_area">
        <div class="submit_subjects_link">
			<h2 class="common_underlayer_title-h2">
				<img src="<?php echo get_option('lg_config__page_ttl_prefix'); ?>">
				みんなの声
			</h2>
            <?php if( strpos($_SERVER['HTTP_HOST'], 'kitaq') === FALSE ): ?>
            <h3>
                あなたの声を投稿しましょう
            </h3>
            <a class="subject_post_box__submit_button" href="<?php echo home_url('/submit_subject/'); ?>">
                あなたの声を投稿しましょう
            </a>
            <div class="common_underlayer_title-h2__sub_title text">
                <div class="month_title">
                    <p><?php echo wpautop(get_option('lg_config__tweet_guide_contents')); ?></p>
                </div>
            </div>
            <?php endif; ?>
        </div><!-- /.submit_subjects_link -->
        <div class="subject_counter">
            <?php
            $l30d = new WP_Query(array(
                'post_type' => array(
                    'tweet',
                    'subject',
                ),
                'date_query' => array(
                    array(
                        'after' => '-30 day',
                    ),
                    'inclusive' => true,
                ),
            ));
            $latest_30d = $l30d->found_posts;
            $total_posts = $wp_query->found_posts;
            wp_reset_postdata();

            echo '<p>最近の投稿：<span class="num">' . $latest_30d . '</span>件</p>';
            echo '<p>全ての投稿：<span class="num">' . $total_posts . '</span>件</p>';

            ?>
        </div>
    </div>

    <div class="knows_map_bar_padding">
        <?php knows_map_bar(); ?>
    </div><!-- /.knows_map_bar_padding -->

    <div id="gmap"></div>

    <div class="list_pic_wrapper">
        <div class="list_pic">
            <div class="list_pic_layout">
                <?php
                if (have_posts()):
                    while (have_posts()): the_post();
                        article_box();
                    endwhile;
                else: ?>
                    <p class="articles__no_post">検索条件に合致する投稿がありませんでした。</p>
                <?php endif;
                ?>
            </div>

            <div class="underlayer_title_area">
                <div class="submit_subjects_link">
                    <?php if( strpos($_SERVER['HTTP_HOST'], 'kitaq') === FALSE ): ?>
                    <h3>
                        あなたの声を投稿しましょう
                    </h3>
                    <div class="common_underlayer_title-h2__sub_title text">
                        <a class="subject_post_box__submit_button" href="<?php echo home_url('/submit_subject/'); ?>">
                            あなたの声を投稿しましょう
                        </a>
                    </div>
                    <?php endif; ?>

                    <div class="about_delete">
                        <p>誤って投稿してしまった、不適切な投稿がある、<br>
                            などで投稿の削除を リクエストされる場合は<br>
                            以下のお問合せページからメールにてご連絡ください。</p>
                        <a href="<?php bloginfo('url'); ?>/contact/">お問合せページ</a>
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
get_template_part('footer', 'sp');
?>
