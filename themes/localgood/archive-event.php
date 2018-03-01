<?php
if (DEVICE == 'sp'):
// スマホ
    get_template_part('archive', 'event-sp');
else:
    add_action('wp_enqueue_scripts', function () {
        $cssdir = get_stylesheet_directory_uri();
        wp_enqueue_script('detail_search_controller_js', $cssdir . '/js/detail_search_control.js', array('jquery'), null, false);
        wp_enqueue_script('datepicker', $cssdir . '/js/plugins/air-datepicker/js/datepicker.min.js', array('jquery'), null, false);
        wp_enqueue_style('datepicker', $cssdir . '/js/plugins/air-datepicker/css/datepicker.min.css', array(), null, 'screen');
    });

    get_header();
    require_once('lib/event-search-engine.php');
    global $post, $paged;
    ?>
    <div class="c-contents_wrapper c-w1096">
        <?php breadcrumbs(); ?>

        <?php knows_head_tab($post); ?>

        <div class="c-page_title_wrapper">
            <h2 class="c-page_title c-title05"><img src="<?php echo get_option('lg_config__page_ttl_prefix'); ?>">みんなの拠点/イベント
            </h2>
            <p class="c-page_title_subtext">地域のカフェ、居場所やイベント情報をご紹介します。</p>
        </div>

        <?php knows_map_bar(); ?>

        <div id="gmap"></div>
        <?php
        $search_mode = (isset($_GET['searchFrom'])) ? $_GET['searchFrom'] : false;
        $feature_posts = array();
        $args = feature_posts_args();
        $feature_posts = get_posts($args);
        $post_not = array();
        if ($feature_posts) {
            foreach ($feature_posts as $p) {
                $post_not[] = $p->ID;
            }
        }
        ?>
        <div class="article_area">
            <?php

            if ('place' !== $search_mode) :
                $event_query = new WP_Query(get_event_args($search_mode, $post_not)); ?>
                <section class="event c-clearfix">
                    <h2 class="c-group_title01"><img src="<?php echo get_option('lg_config__group_ttl_prefix'); ?>">イベント
                    </h2>
                    <div class="article_box__wrapper">
                        <?php if ($event_query->have_posts()) : ?>
                            <?php
                            while ($event_query->have_posts()) :
                                $event_query->the_post();
                                event_box();
                            endwhile;
                            ?>
                            <?php
                            if ($event_query->found_posts > $event_query->query['posts_per_page']) :
                                ?>
                                <div class="c-pager c-clearfix">
                                    <div class="c-pager_container">
                                        <?php paging($event_query); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <p class="articles__no_post">検索条件に合致する投稿がありませんでした。</p>
                        <?php endif; ?>
                    </div>
                </section>
            <?php
            endif;
            ?>
            <?php if ($paged <= 1 && 'event' !== $search_mode) :

                $place_query = new WP_Query(get_place_args($search_mode, $post_not));
                if ($place_query->have_posts()) :?>
                    <section class="place c-clearfix">
                        <h2 class="c-group_title01"><img src="<?php echo get_option('lg_config__group_ttl_prefix'); ?>">みんなの拠点
                        </h2>
                        <div class="article_place">
                            <?php
                            while ($place_query->have_posts()) {
                                $place_query->the_post();
                                place_box($place_query->post);
                            } ?>
                        </div>
                    </section>
                <?php
                endif;
                wp_reset_postdata();
                ?>
            <?php endif; ?>
            <?php
            if ($feature_posts && $paged <= 1 && empty($_GET['searchFrom'])) :
                $i = 0;
                ?>
                <section class="pickup_area c-clearfix">
                    <h2 class="c-group_title01"><img src="<?php echo get_option('lg_config__group_ttl_prefix'); ?>">PICK
                        UP!</h2>
                    <section class="topic_box__wrapper">
                        <?php
                        foreach ($feature_posts as $post) :
                            setup_postdata($post);
                            key_topic_box($i);
                            $i++;
                        endforeach; ?>
                    </section>
                </section>
            <?php
            endif;
            ?>
        </div>
        <div id="modalContainer"></div>
    </div><!--.c-contents_wrapper-->
    <?php
    get_footer();
endif;