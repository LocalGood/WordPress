<?php
if (DEVICE == 'sp'):
// スマホ
    get_template_part( 'archive', 'data-sp' );
else:
    get_header();
    global $post, $paged;
    ?>
    <div class="c-contents_wrapper c-w1096">
        <?php breadcrumbs(); ?>

        <?php knows_head_tab( $post ); ?>

        <div class="c-page_title_wrapper">
            <h2 class="c-page_title c-title05"><img src="<?php echo get_option( 'lg_config__page_ttl_prefix' ); ?>">データ</h2>
            <p class="c-page_title_subtext">地域のデータを見やすい形でまとめました。</p>
        </div>

        <?php knows_map_bar(); ?>
        <div id="gmap" class="default-close"></div>

        <div class="article_area">
            <div class="article_box__wrapper">
                <?php
                global $wp_query;
                $post_not      = array();
                $feature_posts = array();
                if ( ! isset( $_GET['project_area'] ) && ! isset( $_GET['theme'] )) {
                    $args          = feature_posts_args();
                    $feature_posts = get_posts( $args );
                    if ($feature_posts):
                        foreach ($feature_posts as $p) {
                            $post_not[] = $p->ID;
                        }
                    endif;
                    $args = array_merge( $wp_query->query, array(
                        'post__not_in' => $post_not,
                        'posts_per_page' => 15
                    ) );
                } else {
                    $args = $wp_query->query;
                }

                if (!empty( $_GET['project_area'] )) {
                    $args['tax_query'] = array(
                        array(
                            'taxonomy' => 'project_area',
                            'terms'    => $_GET['project_area'],
                            'field'    => 'slug'
                        )
                    );
                }
                if (!empty( $_GET['theme'] )) {
                    //WPデフォルトでは配列形式でGETで渡せないのでキーを変えて対応
                    $args['tax_query'] = array(
                        array(
                            'taxonomy' => 'project_theme',
                            'terms'    => $_GET['theme'],
                            'field'    => 'slug'
                        )
                    );
                }
                query_posts( $args );
                if (have_posts()):
                    while (have_posts()): the_post();
                        article_box();
                    endwhile; ?>
                <?php else: ?>
                    <p class="articles__no_post">検索条件に合致する投稿がありませんでした。</p>
                <?php endif; ?>
                <div class="c-pager c-clearfix">
                    <div class="c-pager_container">
                        <?php
                        paging();
                        ?>
                    </div>
                </div>
                <?php
                if ($feature_posts && $paged <= 1):
                    $i = 0;
                    ?>
                    <section class="pickup_area c-clearfix">
                        <h2 class="c-group_title01"><img src="<?php echo get_option( 'lg_config__group_ttl_prefix' ); ?>" >PICK UP!</h2>
						<section class="topic_box__wrapper">
							<?php
							foreach ($feature_posts as $post):
								setup_postdata( $post );
								key_topic_box( $i );
								$i ++;
							endforeach; ?>
						</section>
                    </section>
                    <?php
                endif;
                ?>
            </div>
        </div>
    </div><!--.c-contents_wrapper-->

    <?php
    get_footer();
endif;
?>
