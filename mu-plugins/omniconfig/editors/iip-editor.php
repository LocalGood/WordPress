<?php
/**
 * Default Page Manager
 *
 * @package localgood/omniconfig
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


function render_iip_editor() {
	global $default_pages;

	echo '<p>初期コンテンツの管理を行えます。<br>ここでの操作は<strong>基本的に取り消すことが出来ません</strong>のでご注意ください。</p>';
	echo '<p>また、ゴミ箱に作成しようとしている投稿のスラッグ（識別子）と同じ投稿が残っている場合、作成に失敗します。その場合はゴミ箱を空にしてから再度実行してください。</p>';

	echo '<div id="defaultPageManagerWrap"></div>';

	echo '<table class="default_page_manager">';
	echo '<tr><th>チェック</th><th>タイトル<small class="slug">スラッグ</small></th><th>操作</th></tr>';
	foreach ( $default_pages as $index => $page_setting ) {
		$current_page = get_page_by_path( $page_setting['slug'] );
		$page_status  = $current_page ? '<span class="exist">設定済</span>' : '<span class="not_exist">未設定</span>';
		$page_title   = ( $page_setting['title'] ) ? $page_setting['title'] : '<span class="no_title">（指定なし）</span>';
		$controler    = $current_page ? '<button class="button remove_default_page" data-target="' . $current_page->ID . '">このページを削除</button>'
			: '<button class="button add_default_page" data-template="index_' . $index . '">テンプレートから生成</button><button class="button add_default_page" data-template="nouse">空のページとして生成</button>';
		echo '<tr>';
		echo '<td class="status">' . $page_status . '</td>';
		echo '<td class="title">' . $page_title . '<small class="slug">' . $page_setting['slug'] . '</small></td>';
		echo '<td class="func">' . $controler . '</td>';
		echo '</tr>';
	}
	echo '</table>';
}


/**
 * デフォルトページ削除
 */
add_action( 'wp_ajax_lgc_remove_default_page', function () use ( $default_pages ) {

	$target = $_POST['target'];
	$result = wp_delete_post($target, true);

	if ( !$result ) {
		echo '失敗しました。';
	} else {
		echo '完了しました。表示に反映するためにこのページをリロードしてください。';
	}
	wp_die();
} );

/**
 * デフォルトページ追加
 */
add_action( 'wp_ajax_lgc_add_default_page', function () use ( $default_pages ) {

	$template = $_POST['template'];

	$index              = (int) preg_replace( '/^index_/', '', $template );
	$target_page_option = $default_pages[ $index ];
	$content            = '';

	if ( 'nouse' !== $template ) {
		if ( file_exists( plugin_dir_path( __FILE__ ) . '../iip-contents/' . $target_page_option['content'] ) ) {
			$content = nl2br( file_get_contents( plugin_dir_path( __FILE__ ) . '../iip-contents/' . $target_page_option['content'] ) );
		} else {
			echo '原稿データが見つからないため、自動投入に失敗しました。手動でコンテンツを入力する場合は、「空のページとして生成」をクリックしてください。';
			wp_die();
		}
	}

	$result = wp_insert_post( array(
		'post_content' => $content,
		'post_title'   => ($target_page_option['title']) ? $target_page_option['title'] : $target_page_option['slug'],
		'post_name'    => $target_page_option['slug'],
		'post_type'    => 'page',
		'post_status'  => 'publish',
		'post_author'  => 1,
	),true );

	if (is_wp_error($result)) {
		echo $result->get_error_message();
	} else {
		echo '完了しました。表示に反映するためにこのページをリロードしてください。';
	}

	wp_die();
} );
