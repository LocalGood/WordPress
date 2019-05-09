<?php
if (DEVICE == 'sp'):
// スマホ
    get_template_part( 'archive', 'sp' );
else:
    ?>
    <?php get_header(); ?>

    <div class="c-contents_wrapper c-w1096">

        <?php breadcrumbs(); ?>
        <?php knows_head_tab(); ?>

        <div class="c-page_title_wrapper">
            <h2 class="c-page_title c-title05"><img src="<?php echo get_option( 'lg_config__page_ttl_prefix' ); ?>">みんなの声</h2>
            <?php if( strpos($_SERVER['HTTP_HOST'], 'kitaq') === FALSE ): ?>
			<a class="subject_post_box__submit_button" href="<?php echo home_url( '/submit_subject/' ); ?>">
				あなたの声を投稿しましょう
			</a>

			<div class="subject_post_box">
				<div class="month_title">
					<div class="subject_post_box__text"><?php echo wpautop(get_option( 'lg_config__tweet_guide_contents' )); ?></div>
				</div>
			</div>
            <?php endif; ?>
        </div>
		<div class="subject_counter">
		    <?php
		    $l30d        = new WP_Query( array(
			    'post_type' => array(
				    'tweet',
				    'subject',
			    ),
			    'date_query' => array(
				    array(
					    'after'    => '-30 day',
				    ),
				    'inclusive' => true,
			    ),
		    ) );
		    $latest_30d  = $l30d->found_posts;
		    $total_posts = $wp_query->found_posts;
		    wp_reset_postdata();

		    echo '<p>最近の投稿：<span class="num">' . $latest_30d . '</span>件</p>';
		    echo '<p>全ての投稿：<span class="num">' . $total_posts . '</span>件</p>';

		    ?>
		</div>

        <?php knows_map_bar(); ?>
        <div id="gmap" ></div>

        <?php
        // "課題を見る"用
        if (in_array( array('subject', 'tweet'), get_query_var( 'post_type' ) )) {
            $is_subject = true;
        } else {
            $is_subject = false;
        }

        if ($is_subject):
            ?>
            <div class="subject_post_box">
                <p class="subject_post_box__text"><?php echo get_option( 'lg_config__tweet_guide_contents' ); ?></p>
                <a class="subject_post_box__submit_button" href="<?php echo home_url( '/submit_subject/' ); ?>">
                    投稿する
                </a>
            </div>
            <div class="subject_map">
                <div id="subjects_view">
                </div>
            </div>
            <?php
        endif;
        ?>
        <div class="article_area">
            <?php
            if(have_posts()):
                while (have_posts()): the_post();
                    article_box();
                endwhile;
            else: ?>
                <p class="articles__no_post">検索条件に合致する投稿がありませんでした。</p>
            <?php endif;
            ?>
        </div>
        <div class="subject_post_box">
            <?php if( strpos($_SERVER['HTTP_HOST'], 'kitaq') === FALSE ): ?>
			<a class="subject_post_box__submit_button" href="<?php echo home_url( '/submit_subject/' ); ?>">
				あなたの声を投稿しましょう
			</a>
            <?php endif; ?>
			<div class="about_delete">
				<p>誤って投稿してしまった、不適切な投稿がある、などで投稿の削除を<br>
					リクエストされる場合は以下のお問合せページからメールにてご連絡ください。</p>
				<a href="<?php echo home_url('contact');?>">お問い合わせページ</a>
			</div>
        </div>
        <div class="c-pager c-clearfix">
            <div class="c-pager_container">
                <?php paging(); ?>
            </div>
        </div>
    </div><!-- .c-contents_wrapper -->
    <?php
    get_footer();
endif;
?>