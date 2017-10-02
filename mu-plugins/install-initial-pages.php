<?php
/**
 * デフォルト固定ページの自動生成スクリプト
 *
 * @package localgood/IIP
 */

/*
Plugin Name: IIP-LG
Author: #7
Version: 0.1.0
*/

/*
 * 使い方
 * 自動投入したいコンテンツの情報を配列で指定してください。
 * このプラグインは渡されたコンテンツ情報のスラッグをもとに固定ページを探します。
 * もし見つからなければ、content で指定されたファイルの中身を固定ページに流し込みます。
 * （ファイル自体はiip-contents）に以下に配置します。
 * 既に固定ページがある場合は何もしません。
 * 固定ページが削除されたときは自動的に再生成を試みます。
 */
$default_pages = array(
	array(
		'title'   => false,
		'slug'    => 'event_search',
		'content' => false,
	),
	array(
		'title'   => 'event_search-sp',
		'slug'    => 'event_search_sp',
		'content' => false,
	),
	array(
		'title'   => 'spot_search-sp',
		'slug'    => 'spot_search_sp',
		'content' => false,
	),
	array(
		'title'   => 'subject_locations',
		'slug'    => '_subject_locations',
		'content' => false,
	),
	array(
		'title'   => false,
		'slug'    => 'tweet_callback',
		'content' => false,
	),
	array(
		'title'   => 'Twitterに投稿する',
		'slug'    => 'tweet_subject',
		'content' => false,
	),
	array(
		'title'   => get_bloginfo( 'name' ) . 'について',
		'slug'    => 'about',
		'content' => 'about.txt',
	),
	array(
		'title'   => 'あなたの声を投稿する',
		'slug'    => 'submit_subject',
		'content' => 'submit_subject.txt',
	),
	array(
		'title'   => 'お問い合わせ',
		'slug'    => 'contact',
		'content' => 'contact.txt',
	),
	array(
		'title'   => 'ニュース',
		'slug'    => 'lgnews',
		'content' => 'lgnews.txt',
	),
	array(
		'title'   => 'プライバシーポリシー',
		'slug'    => 'privacypolicy',
		'content' => 'privacypolicy.txt',
	),
);

foreach ( $default_pages as $page ) {
	if ( ! get_page_by_path( $page['slug'] ) ) {
		if ( file_exists( plugin_dir_path( __FILE__ ) . '/iip-contents/' . $page['content'] ) ) {
			$content = nl2br( file_get_contents( plugin_dir_path( __FILE__ ) . '/iip-contents/' . $page['content'] ) );
		} else {
			$content = '原稿データが見つからないため、自動投入に失敗しました。手動操作でこのコンテンツを編集してください。';
		}

		wp_insert_post( array(
			'post_content' => $content,
			'post_title'   => $page['title'],
			'post_name'    => $page['slug'],
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_author'  => 1,
		) );
	}
}

