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
            <p class="c-page_title_subtext">地域について寄せられた声の一覧です。</p>
        </div>

        <?php knows_map_bar(); ?>
        <div id="gmap" ></div>

        <div class="subject_post_box">
            <p class="subject_post_box__title">あなたの声を投稿しましょう</p>
            <p class="subject_post_box__text">あなたの身の回りの良い所や気になっていることを教えてください。</p>
            <a class="subject_post_box__submit_button" href="<?php echo home_url( '/submit_subject/' ); ?>">
                投稿する
            </a>
        </div>

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
                <p class="subject_post_box__title">あなたの声を投稿しましょう</p>
                <p class="subject_post_box__text">あなたの身の回りの良い所や気になっていることを教えてください。</p>
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
			$args = array(
				'post_type' => 'subject'
			);
			$subject_posts = new WP_Query($args);
            if ($subject_posts->have_posts()):
                while ($subject_posts->have_posts()): $subject_posts->the_post();
                    article_box();
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
        <div class="subject_post_box">
            <p class="subject_post_box__title">あなたの声を投稿しましょう</p>
            <p class="subject_post_box__text">あなたの身の回りの良い所や気になっていることを教えてください。</p>
                <a class="subject_post_box__submit_button" href="<?php echo home_url( '/submit_subject/' ); ?>">
                    投稿する
                </a>
        </div>
        <div class="c-pager c-clearfix">
            <div class="c-pager_container">
                <?php paging($subject_posts); ?>
            </div>
        </div>
    </div><!-- .c-contents_wrapper -->
    <?php
    get_footer();
endif;
?>
