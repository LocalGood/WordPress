<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8"/>
    <?php
    $meta_kwds = implode(',', array(
        get_bloginfo('name'),
        get_option('lg_config__appName_kana', false),
        'コミュニティ',
        'コミュニティ経済',
        get_option('lg_config__appName_kanji', false),
        '地域',
    ));
    ?>
    <meta name="keywords" content="<?php echo $meta_kwds; ?>"/>
    <?php if (!is_single()): ?>
        <meta name="description" content="<?php bloginfo( 'description' ); ?>"/>
    <?php endif; ?>

	<meta property="fb:app_id" content="<?php echo esc_attr( get_option( 'lg_config__apikey_facebook', false ) ); ?>"/>

	<?php
	$opengraph = array(
		'fb:app_id'      => get_option( 'lg_config__apikey_facebook', false ),
		'og:title'       => generate_share_message( false ),
		'og:url'         => 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
		'og:type'        => ( is_home() ) ? 'website' : 'article',
		'og:locale'      => 'ja_JP',
		'og:image'       => get_template_directory_uri() . '/images/ogimg.png?ver=' . LG::themeinfo()->version,
		'og:description' => get_bloginfo( 'description' ),
	);


	if ( is_single() ) {
		setup_postdata( $post );
		$eyecatch = wp_get_attachment_image_src( get_post_thumbnail_id(), 'single-thumbnail' );

		if ( $eyecatch ) {
			$_imgurl = '';

			$_fn_array = explode( '/', $eyecatch[0] );
			for ( $i = 0; $i < count( $_fn_array ); $i ++ ) {
				$_imgurl .= $_fn_array[ $i ];
				if ( $i != ( count( $_fn_array ) - 1 ) ) {
					$_imgurl .= '/';
				}
			};
			$opengraph['og:image'] = $_imgurl;
		} else {
			$attached_medias_obj = get_attached_media( 'image', $post->ID );
			foreach ( $attached_medias_obj as $id => $obj ) {
				$_imgurl = wp_get_attachment_image_src( $obj->ID, 'medium' )[0];
				if ( $_imgurl ) {
					$opengraph['og:image'] = $_imgurl;
				}
			}
		}

		$opengraph['og:description'] = get_the_excerpt();
        echo '<meta name="description" content="' . get_the_excerpt() . '"/>';
	}

	foreach ( $opengraph as $key => $value ) {
		echo '<meta property="' . esc_attr( $key ) . '" content="' . esc_attr( $value ) . '">';
	}
	?>
    <meta name="twitter:card" content="summary" />

    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
    <title><?php
        global $page, $paged, $post;
        $current_post_type = get_post_type($post);

        $is_tweet = ($current_post_type == 'tweet');
        $is_subject = ($current_post_type == 'subject');

        if (is_singular() && ($is_tweet || $is_subject) ? true : false) {
            $cf = get_post_custom($post->ID);
            $subject_user_meta = get_subject_user_meta($is_tweet, $cf);
            $author_name = (empty($subject_user_meta['name'])) ? '地域の仲間' : $subject_user_meta['name'];

            echo $author_name . ' - ' . $subject_user_meta['postdate'] . ' | ';

        } else {
            wp_title('|', true, 'right');
        }
        bloginfo('name');

        ?></title>
    <link rel="shortcut icon " type="image/vnd.microsoft.icon"
          href="<?php echo esc_attr(get_option('lg_config__favicon')) ?>"/>
    <?php

    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wp_shortlink_wp_head');

    remove_action('wp_head', 'feed_links');
    remove_action('wp_head', 'feed_links_extra');

    remove_action('wp_head', 'index_rel_link');
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    remove_action('wp_head', 'feed_links_extra', 3, 0);
    remove_action('wp_head', 'index_rel_link');
    remove_action('wp_head', 'parent_post_rel_link');
    remove_action('wp_head', 'start_post_rel_link');
    remove_action('wp_head', 'rel_canonical');
    wp_head();

    if (!strpos($_SERVER['SERVER_NAME'], 'il3c')):
        ?>
        <script>
          (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r
            i[r] = i[r] || function () {
              (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date()
            a = s.createElement(o),
              m = s.getElementsByTagName(o)[0]
            a.async = 1
            a.src = g
            m.parentNode.insertBefore(a, m)
          })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga')

          ga('create', '<?php echo esc_attr(get_option('lg_config__analyticsId', false)); ?>', 'localgood.jp')
          ga('send', 'pageview')

        </script>
    <?php
    endif;
    ?>
</head>
<body id="page_top" <?php lg_body_class(); ?>>
<div id="fb-root"></div>
<script>(function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0]
    if (d.getElementById(id)) return
    js = d.createElement(s)
    js.id = id
    js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&appId=<?php echo esc_attr(get_option('lg_config__apikey_facebook', false)); ?>&version=v2.9"
    fjs.parentNode.insertBefore(js, fjs)
  }(document, 'script', 'facebook-jssdk'))</script>

<div class="container<?php if (is_home()): ?>-top<?php endif; ?>">
    <?php if (is_home()): ?>
        <nav class="main_nav clearfix">
            <a href="<?php echo home_url(); ?>" class="nav_logo">
                <img src="<?php echo esc_attr(get_option('lg_config__header_logo_2')) ?>"
                     alt="<?php bloginfo('name'); ?>"/>
            </a>
            <div class="nav_menu-button">
                <span></span>
                <span></span>
                <span></span>
                <div class="close_button">×</div>
            </div>
            <nav class="main_nav__link-list">
                <ul class="list01">
                    <?php if( strpos($_SERVER['HTTP_HOST'], 'sendai') !== FALSE ): ?>
                    <?php if (is_home()): ?>
                        <li>
                            <a href="<?php echo home_url('/subject/'); ?>" class="list01__text">
                                あなたの声を投稿する
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php endif; ?>
                    <li class="list_open">
                        <div class="list01__text">
                            地域を知る
                        </div>
                        <dl class="list02">
                            <dt>
                                記事
                            </dt>
                            <dd>
                                <a href="<?php echo home_url('/lgnews/'); ?>">
                                    ニュース
                                </a>
                            </dd>
                            <dd>
                                <a href="<?php echo home_url('/event/'); ?>">
                                    みんなの拠点/イベント
                                </a>
                            </dd>
                            <dd>
                                <a href="<?php echo home_url('/data/'); ?>">
                                    データ
                                </a>
                            </dd>
                            <dd>
                                <a href="<?php echo home_url('/lgplayer/'); ?>">
                                    人/団体
                                </a>
                            </dd>
                            <dt>
                                みんなの声
                            </dt>
                            <dd>
                                <a href="<?php echo home_url('/subject/'); ?>">
                                    投稿一覧
                                </a>
                            </dd>
                            <?php if( strpos($_SERVER['HTTP_HOST'], 'sendai') !== FALSE ): ?>
                            <dd>
                                <a href="<?php echo home_url('/submit_subject/'); ?>">
                                    あなたの声を投稿する
                                </a>
                            </dd>
                            <?php endif; ?>
                        </dl>
                    </li>
                    <li class="list_open">
                        <div class="list01__text">
                            応援する
                        </div>
                        <dl class="list02">
                            <dt></dt>
                            <dd>
                                <a href="<?php echo esc_attr(get_option('lg_config__goteo_baseurl', false)); ?>/discover/">
                                    プロジェクト一覧
                                </a>
                            </dd>
                            <dd>
                                <a href="<?php echo home_url('/challenge/'); ?>">
                                    プロジェクトを立ちあげる
                                </a>
                            </dd>
                        </dl>
                    </li>
                    <?php if (!empty(get_option('lg_config__earthViewUrl', false))) { ?>
                        <li>
                            <a href="<?php echo esc_attr(get_option('lg_config__earthViewUrl', false)); ?>"
                               target="_blank" class="list01__text">
                                3Dマップ
                            </a>
                        </li>
                    <?php } ?>
                    <li>
                        <a href="/about/" class="list01__text"><?php bloginfo('name'); ?>について</a>
                    </li>
                    <?php if( strpos($_SERVER['HTTP_HOST'], 'kitaq') === FALSE ): ?>
                    <li>
                        <a href="<?php echo esc_attr(get_option('lg_config__goteo_baseurl', false)); ?>/user/login"
                           class="list01__text">
                            新規登録/ログイン
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </nav>

        <nav class="main_nav__link-list">
            <ul class="list01">
                <?php if( strpos($_SERVER['HTTP_HOST'], 'sendai') !== FALSE ): ?>
                <?php if (is_home()): ?>
                    <li>
                        <a href="<?php echo home_url('/subject/'); ?>" class="list01__text">
                            あなたの声を投稿する
                        </a>
                    </li>
                <?php endif; ?>
                <?php endif; ?>
                <li class="list_open">
                    <div class="list01__text">
                        地域を知る
                    </div>
                    <dl class="list02">
                        <dt>
                            記事
                        </dt>
                        <dd>
                            <a href="<?php echo home_url('/lgnews/'); ?>">
                                ニュース
                            </a>
                        </dd>
                        <dd>
                            <a href="<?php echo home_url('/event/'); ?>">
                                みんなの拠点/イベント
                            </a>
                        </dd>
                        <dd>
                            <a href="<?php echo home_url('/data/'); ?>">
                                データ
                            </a>
                        </dd>
                        <dd>
                            <a href="<?php echo home_url('/lgplayer/'); ?>">
                                人/団体
                            </a>
                        </dd>
                        <?php if (!is_home()): ?>
                            <dt>
                                みんなの声
                            </dt>
                            <dd>
                                <a href="<?php echo home_url('/subject/'); ?>">
                                    投稿一覧
                                </a>
                            </dd>
                            <?php if( strpos($_SERVER['HTTP_HOST'], 'sendai') !== FALSE ): ?>
                            <dd>
                                <a href="<?php echo home_url('/submit_subject/'); ?>">
                                    あなたの声を投稿する
                                </a>
                            </dd>
                            <?php endif; ?>
                        <?php endif; ?>
                    </dl>
                </li>
                <li class="list_open">
                    <div class="list01__text">
                        応援する
                    </div>
                    <dl class="list02">
                        <dt></dt>
                        <dd>
                            <a href="<?php echo esc_attr(get_option('lg_config__goteo_baseurl', false)); ?>/discover">
                                プロジェクト一覧
                            </a>
                        </dd>
                        <dd>
                            <a href="<?php echo home_url('/challenge/'); ?>">
                                プロジェクトを立ち上げる
                            </a>
                        </dd>
                    </dl>
                </li>
                <?php if (!empty(get_option('lg_config__earthViewUrl', false))) { ?>
                    <li>
                        <a href="<?php echo esc_attr(get_option('lg_config__earthViewUrl', false)); ?>" target="_blank"
                           class="list01__text">
                            3Dマップ
                        </a>
                    </li>
                <?php } ?>
                <li>
                    <a href="/about/" class="list01__text"><?php bloginfo('name'); ?>について</a>
                </li>
                <?php if( strpos($_SERVER['HTTP_HOST'], 'kitaq') === FALSE ): ?>
                <li>
                    <a href="<?php echo esc_attr(get_option('lg_config__goteo_baseurl', false)); ?>/user/login"
                       class="list01__text">
                        新規登録/ログイン
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php else: ?>
    <nav class="main_nav02 clearfix">
        <a href="<?php echo home_url(); ?>" class="nav_logo">
            <img src="<?php echo esc_attr(get_option('lg_config__header_logo_2')) ?>" alt="<?php bloginfo('name'); ?>"/>
        </a>
        <div class="nav_menu-button">
            <span></span>
            <span></span>
            <span></span>
            <div class="close_button">×</div>
        </div>
        <nav class="main_nav__link-list">
            <ul class="list01">
                <li class="list_open">
                    <div class="list01__text">
                        地域を知る
                    </div>
                    <dl class="list02">
                        <dt>
                            記事
                        </dt>
                        <dd>
                            <a href="<?php echo home_url('/lgnews/'); ?>">
                                ニュース
                            </a>
                        </dd>
                        <dd>
                            <a href="<?php echo home_url('/event/'); ?>">
                                みんなの拠点/イベント
                            </a>
                        </dd>
                        <dd>
                            <a href="<?php echo home_url('/data/'); ?>">
                                データ
                            </a>
                        </dd>
                        <dd>
                            <a href="<?php echo home_url('/lgplayer/'); ?>">
                                人/団体
                            </a>
                        </dd>
                        <dt>
                            みんなの声
                        </dt>
                        <dd>
                            <a href="<?php echo home_url('/subject/'); ?>">
                                投稿一覧
                            </a>
                        </dd>
                        <?php if( strpos($_SERVER['HTTP_HOST'], 'sendai') !== FALSE ): ?>
                        <dd>
                            <a href="<?php echo home_url('/submit_subject/'); ?>">
                                あなたの声を投稿する
                            </a>
                        </dd>
                        <?php endif; ?>
                    </dl>
                </li>
                <li class="list_open">
                    <div class="list01__text">
                        応援する
                    </div>
                    <dl class="list02">
                        <dt></dt>
                        <dd>
                            <a href="<?php echo esc_attr(get_option('lg_config__goteo_baseurl', false)); ?>/discover">
                                プロジェクト一覧
                            </a>
                        </dd>
                        <dd>
                            <a href="<?php echo home_url('/challenge/'); ?>">
                                プロジェクトを立ち上げる
                            </a>
                        </dd>
                    </dl>
                </li>
                <?php if (!empty(get_option('lg_config__earthViewUrl', false))) { ?>
                    <li>
                        <a href="<?php echo esc_attr(get_option('lg_config__earthViewUrl', false)); ?>" target="_blank"
                           class="list01__text">
                            3Dマップ
                        </a>
                    </li>
                <?php } ?>
                <li>
                    <a href="/about/" class="list01__text"><?php bloginfo('name'); ?>について</a>
                </li>
                <?php if( strpos($_SERVER['HTTP_HOST'], 'kitaq') === FALSE ): ?>
                <li>
                    <a href="<?php echo esc_attr(get_option('lg_config__goteo_baseurl', false)); ?>/login"
                       class="list01__text">
                        新規登録/ログイン
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </nav>
    </nav>

<?php endif; ?>