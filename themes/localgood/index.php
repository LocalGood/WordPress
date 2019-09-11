<?php
if (DEVICE == 'sp'):
    // スマホ
    get_template_part('index', 'sp');
else:
    get_header();
    ?>
    <header id="index_header" class="header index_header clearfix">
        <h1 class="header__logo">
            <a href="<?php echo home_url(); ?>"><img
                        src="<?php echo esc_attr(get_option('lg_config__header_logo_1')) ?>"
                        alt="<?php bloginfo('name'); ?>"/></a>
        </h1>
        <div class="header__right">
            <nav class="header__right__nav">
                <ul id="gnav" class="header__right__nav__gnav">
                    <?php /* if( strpos($_SERVER['HTTP_HOST'], 'sendai') !== FALSE ): ?>
                    <li><a href="<?php echo home_url('/subject/'); ?>">あなたの声を投稿する</a></li>
                    <?php endif; */ ?>
                    <?php $a = 'class="active"'; ?>
                    <li <?php if (is_category() || is_singular('post') || is_tag() || is_page('lgnews')) {
                        echo $a;
                    } ?>>
                        <a href="<?php echo home_url('/lgnews/'); ?>">地域を知る</a>
                        <div class="snav header__right__snav">
                            <div class="header__right__snav__inner">
                                <span class="header__right__snav__second_title">記事</span>
                                <ul>
                                    <li><span><a href="<?php echo home_url('/lgnews/'); ?>">ニュース</a></span></li>
                                    <li><span><a href="<?php echo home_url('/event/'); ?>">みんなの拠点/イベント</a></span></li>
                                    <li <?php if (is_tax('data_type') || is_singular('data') || is_post_type_archive('data')) {
                                        echo $a;
                                    } ?>><span><a href="<?php echo home_url('/data/'); ?>">データ</a></span></li>
                                    <li><span><a href="<?php echo home_url('/lgplayer/'); ?>">人/団体</a></span></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li <?php if (is_singular('skills') || is_post_type_archive('skills')) {
                        echo $a;
                    } ?>>
                        <a href="<?php echo esc_attr(get_option('lg_config__goteo_baseurl', false)); ?>">応援する</a>
                        <div class="header__right__snav">
                            <div class="header__right__snav__inner">
                                <ul>
                                    <li>
                                        <span><a href="<?php echo esc_attr(get_option('lg_config__goteo_baseurl', false)); ?>/discover/">プロジェクト一覧</a></span>
                                    </li>
                                    <li><span><a href="<?php echo home_url('/challenge/'); ?>">プロジェクトを立ち上げる</a></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <?php if (!empty(get_option('lg_config__earthViewUrl', false))) { ?>
                        <li <?php if (is_page('earth_view') || is_tax('project_area') || is_tax('project_theme')) {
                            echo $a;
                        } ?>><a href="<?php echo esc_attr(get_option('lg_config__earthViewUrl', false)); ?>"
                                target="_blank">3Dマップ</a>
                        </li>
                    <?php } ?>
                    <li>
                        <a href="<?php echo home_url('/about/'); ?>"><?php bloginfo('name'); ?>について</a>
                    </li>
                    <?php /* if( strpos($_SERVER['HTTP_HOST'], 'kitaq') === FALSE ): ?>
                    <li class="gnav_goteo">
                        <a href="<?php echo esc_attr(get_option('lg_config__goteo_baseurl', false)); ?>/user/login">新規登録/ログイン</a>
                    </li>
                    <?php endif;*/ ?>
                </ul>
            </nav>
        </div>

    </header>
    <!--.header-->

    <div id="key_visual" class="key_visual"
         style="background-image:url(<?php echo esc_attr(get_option('lg_config__home_wallpaper')); ?>);">
        <h2 class="key_visual__word">
            <?php if (get_option('lg_config__main_logo', false)) : ?>
                <img src="<?php echo get_option('lg_config__main_logo'); ?>"
                     alt="<?php bloginfo('name'); ?>">
            <?php else : ?><?php bloginfo('name'); ?>
            <?php endif; ?>
        </h2>
        <div class="key_visual__updates">
            <?php
            $home_latest_contents = explode(',', get_option('lg_config__top_page_contents'));

            $latest_posts = array_merge(
                get_posts(array(
                    'post_type' => 'post',
                    'posts_per_page' => 3,
                    'orderby' => 'date',
                    'order' => 'DESC',
                    'category_name' => 'news,local_good_player,voice',
                )),
                get_posts(array(
                    'post_type' => array('event', 'data', 'subject', 'tweet'),
                    'posts_per_page' => 3,
                    'orderby' => 'date',
                    'order' => 'DESC',
                ))
            );

            usort($latest_posts, function ($a, $b) {
                return strtotime($a->post_date) > strtotime($b->post_date) ? -1 : 1;
            });

            for ($i = 0; $i < 3; $i++) :
                $post_title = ('tweet' === $latest_posts[$i]->post_type || 'subject' === $latest_posts[$i]->post_type) ?
                    shorten($latest_posts[$i]->post_content, 36) :
                    shorten($latest_posts[$i]->post_title, 36);

                $post_date = date('Y.m.d', strtotime($latest_posts[$i]->post_date));
                $post_url = get_permalink($latest_posts[$i]->ID);
                if (('tweet' === $latest_posts[$i]->post_type || 'subject' === $latest_posts[$i]->post_type)) {
	                $attached_medias_obj = get_attached_media( 'image', $latest_posts[ $i ]->ID );
	                if ( empty( $attached_medias_obj ) ) {
		                $thumbnail = get_stylesheet_directory_uri() . '/images/lg-noimage-pc.jpg';
	                } else {
		                foreach ( $attached_medias_obj as $id => $obj ) {
			                $thumbnail = wp_get_attachment_image_src( $obj->ID, 'medium' )[0];
		                }
	                }

                } else {
                    $thumbnail = (has_post_thumbnail($latest_posts[$i]->ID)) ?
                        wp_get_attachment_image_src(get_post_thumbnail_id($latest_posts[$i]->ID), 'medium', false)[0] :
                        get_stylesheet_directory_uri() . '/images/lg-noimage-pc.jpg';
                }

                if ('post' === $latest_posts[$i]->post_type) {
                    $cats = get_the_category($latest_posts[$i]->ID);
                    switch ($cats[0]->slug) {
                        case 'news':
                            $cat_cfg = array(
                                'icon' => 'news',
                                'label' => 'ニュース',
                            );
                            break;
                        case 'local_good_player' || 'voice':
                            $cat_cfg = array(
                                'icon' => 'organization',
                                'label' => '人/団体',
                            );
                            break;
                        default:
                            $cat_cfg = array(
                                'icon' => '',
                                'label' => '',
                            );
                            break;
                    }
                } else {
                    switch ($latest_posts[$i]->post_type) {
                        case 'event':
                            $cat_cfg = array(
                                'icon' => 'event',
                                'label' => 'みんなの拠点/イベント',
                            );
                            break;
                        case 'data':
                            $cat_cfg = array(
                                'icon' => 'data',
                                'label' => 'データ',
                            );
                            break;
                        case 'tweet' || 'subject':
                            $cat_cfg = array(
                                'icon' => 'voice',
                                'label' => 'みんなの声',
                            );
                            break;
                        default:
                            $cat_cfg = array(
                                'icon' => '',
                                'label' => '',
                            );
                            break;
                    }
                } // End if().
                ?>
                <div class="item">
                    <div class="image">
                        <a href="<?php echo $post_url; ?>">
                            <img src="<?php echo esc_attr($thumbnail); ?>" alt="<?php echo esc_attr($post_title); ?>">
                        </a>
                    </div>
                    <div class="text">
                        <div class="c-clearfix">
                            <span class="date"><?php echo $post_date; ?></span>
                            <span class="category <?php echo esc_attr($cat_cfg['icon']); ?>"><?php echo $cat_cfg['label']; ?></span>
                        </div>
                        <h2 class="title">
                            <a href="<?php echo $post_url; ?>">
                                <?php echo $post_title; ?>
                            </a>
                        </h2>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>

    <div id="contents" class="contents">

        <h2 class="contents__title c-title_cmn c-title01"><?php echo get_option('lg_config__catch_copy'); ?></h2>

        <section class="index_sec01 c-w1200">
            <h3 class="index_sec01__title c-title_cmn c-title02"><?php echo apply_filters('lg_home_element_label_sect1', get_bloginfo('name') . 'について'); ?></h3>
            <?php echo wpautop(get_option('lg_config__about_content')); ?>
        </section>
        <section class="index_sec02">
            <h3 class="index_sec02__title c-title_cmn c-title02"><?php echo apply_filters('lg_home_element_label_sect2', get_bloginfo('name') . 'でできること'); ?></h3>
            <div class="index_sec02__inner_box index_sec02__know_area">
                <dl>
                    <dt><?php echo apply_filters('lg_home_element_label_sect2_1', '地域を知ろう'); ?></dt>
                    <dd>
                        <span><?php echo get_option('lg_config__know_the_zone_msg'); ?></span>
                        <a class="index_sec02__link c-link02" href="<?php echo home_url('/lgnews/'); ?>">地域を知る</a>
                    </dd>
                </dl>
            </div>
            <div class="index_sec02__inner_box index_sec02__join_area">
                <dl>
                    <dt><?php echo apply_filters('lg_home_element_label_sect2_2', '地域に参加しよう'); ?></dt>
                    <dd>
                        <span><?php echo get_option('lg_config__join_the_zone_msg'); ?></span>
                        <a class="index_sec02__link c-link02"
                           href="<?php echo esc_attr(get_option('lg_config__goteo_baseurl', false)); ?>">地域に参加する</a>
                    </dd>
                </dl>
            </div>
        </section>

        <section class="index_sec03 c-w1200">
            <h3 class="index_sec03__title c-title_cmn c-title02"><?php echo apply_filters('lg_home_element_label_sect3', get_bloginfo('name') . 'のこれまで'); ?></h3>
            <ul class="index_sec03__list">
                <li>
                    <dl>
                        <dt>イベントへの参加者</dt>
                        <dd><?php
                            $participants_num = get_option('event_participants');
                            echo $participants_num ? htmlspecialchars($participants_num, ENT_QUOTES) : '0';
                            ?>人
                        </dd>
                    </dl>
                </li>
                <?php
                $_url = get_option('lg_config__goteo_baseurl', false) . '/json/get_goteo_status';
                $_params = array();
                $statobj = request_api_curl($_url, $_params);
                ?>
                <li>
                    <dl>
                        <dt>支援した人</dt>
                        <dd>
                            <?php
                            echo !empty($statobj->investors) ? $statobj->investors : '0';
                            // 450
                            ?>人
                        </dd>
                    </dl>
                </li>
                <li>
                    <dl>
                        <dt>集まった金額</dt>
                        <dd>
                            <?php
                            echo !empty($statobj->total) ? $statobj->total : '0';
                            //                             7,937,970
                            ?>円
                        </dd>
                    </dl>
                </li>
                <li>
                    <dl>
                        <dt>成立したプロジェクト</dt>
                        <dd>
                            <?php
                            echo !empty($statobj->succeed) ? $statobj->succeed : '0';
                            // 14
                            ?>
                            件
                        </dd>
                    </dl>
                </li>
                <li>
                    <dl>
                        <dt>支援を募集中のプロジェクト</dt>
                        <dd>
                            <?php
                            echo !empty($statobj->progress) ? $statobj->progress : '0';
                            ?>件
                        </dd>
                    </dl>
                </li>
            </ul>
        </section>

        <section class="index_sec04">
            <h3 class="index_sec04__title c-title_cmn c-title03">クラウドファンディング</h3>
            <div class="index_sec04__inner_wrap">
                <div class="project_box c-clearfix">
<!--                    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>-->
                    <?php
                    $_promotes = get_pickup_projects();
                    if (!empty($_promotes)) {
                        foreach ($_promotes as $_promo) {
                            $_prj_url = get_option('lg_config__goteo_baseurl', false) . '/widget/project/' . urlencode($_promo->project) . '?lang=ja';
                            ?>
                            <div class="project_box__part">
                                <iframe frameborder="0" width="318px" height="560px" src="<?php echo $_prj_url; ?>"
                                        scrolling="yes"></iframe>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <a class="index_sec04__more_btn c-link02"
                   href="<?php echo esc_attr(get_option('lg_config__goteo_baseurl', false)); ?>">もっと見る</a>
            </div>
        </section>
        <section class="index_sec05 c-w1200">
            <h3 class="index_sec05__title c-title_cmn c-title02"><?php echo esc_html(apply_filters('lg_home_element_label_sect5', '運営体制')); ?></h3>
            <?php lgc_get_banners(); ?>
        </section>
    </div>
    <?php
    get_footer();
endif;
?>
