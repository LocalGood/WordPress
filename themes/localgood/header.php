<?php
if (DEVICE == 'sp'):
// スマホ
    get_template_part('header', 'sp');
elseif (DEVICE == 'pc'):
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8"/>
    <meta name=viewport content="width=device-width, initial-scale=1">
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
    <meta name="description" content="<?php bloginfo('description'); ?>"/>

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

		$opengraph['description'] = get_the_excerpt();
	}

	foreach ( $opengraph as $key => $value ) {
		echo '<meta property="' . esc_attr( $key ) . '" content="' . esc_attr( $value ) . '">';
	}
	?>

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
    <?php endif; ?>
</head>
<body <?php lg_body_class(); ?>>
<div id="fb-root"></div>
<script>(function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0]
    if (d.getElementById(id)) return
    js = d.createElement(s)
    js.id = id
    js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&appId=<?php echo esc_attr(get_option('lg_config__apikey_facebook', false)); ?>&version=v2.9"
    fjs.parentNode.insertBefore(js, fjs)
  }(document, 'script', 'facebook-jssdk'))</script>

<div class="c-page_wrapper">
    <header id="header" class="normal_header header clearfix">
        <h1 class="header__logo">
            <a href="<?php echo home_url(); ?>"><img
                        src="<?php echo esc_attr(get_option('lg_config__header_logo_2')) ?>"
                        alt="<?php bloginfo('name'); ?>"/></a>
        </h1>
        <div class="header__right">
            <?php if (is_home()) {
                social_buttons(home_url());
            } ?>
            <div class="header__right__search_box">
                <form role="search" id="search_form" method="get" action="/">
                    <input type="text" id="s" name="s" placeholder="キーワード">
                    <input type="image" src="<?php bloginfo('template_directory'); ?>/images/search.png" alt="検索"
                           id="searchBtn" name="searchBtn">
                </form>
            </div>
            <nav class="header__right__nav">
                <ul id="gnav" class="header__right__nav__gnav">
                    <?php $a = 'class="active"'; ?>
                    <li <?php if (is_category() || is_singular('post') || is_tag() || is_page('lgnews') || is_tax('project_area') || is_tax('project_theme')) {
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
                                <span class="header__right__snav__second_title">みんなの声</span>
                                <ul>
                                    <li><span><a href="<?php echo home_url('/subject/'); ?>">投稿一覧</a></span></li>
                                    <?php if( strpos($_SERVER['HTTP_HOST'], 'kitaq') === FALSE ): ?>
                                    <li>
                                        <span><a href="<?php echo home_url('/submit_subject/'); ?>">あなたの声を投稿する</a></span>
                                    </li>
                                    <?php endif; ?>
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
                        <li <?php if (is_page('earth_view')) {
                            echo $a;
                        } ?>><a href="<?php echo esc_attr(get_option('lg_config__earthViewUrl', false)); ?>"
                                target="_blank">3Dマップ</a>
                        </li>
                    <?php } ?>
                    <li>
                        <a href="<?php echo home_url('/about/'); ?>"><?php bloginfo('name'); ?>について</a>
                    </li>
                    <?php if( strpos($_SERVER['HTTP_HOST'], 'kitaq') === FALSE ): ?>
                    <li class="gnav_goteo">
                        <a href="<?php echo esc_attr(get_option('lg_config__goteo_baseurl', false)); ?>/user/login">新規登録/ログイン</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <!--.header-->
    <?php endif;