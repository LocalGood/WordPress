<?php
/**
 * Omniconfig Admin Home
 *
 * @package localgood/omniconfig
 */

/*
 * 設定項目の増やし方、値の取得方法
 * name 値が lg_config__ からはじまる input 要素を追加すれば自動的に保存されます。
 * 保存先は options で、上記 name 値で１項目ずつ保存されます。
 * 例：lg_config__apikey_googlemap なら、
 * get_option('lg_config__apikey_googlemap'); で取得できます。
 */

global $lgoc_labels;

$postdata = filter_input_array( INPUT_POST );

if ( 'update' === $postdata['mode'] ) {
	foreach ( $postdata as $key => $value ) {
		if ( preg_match( '/^lg_config__/', $key ) ) {
			if ( empty( $value ) ) {
				delete_option( $key );
			} else {
				update_option( $key, $value );
			}
		}
	}

	// シンボリックリンク作成
	$symlink_cfg = array(
		array(
			'target' => ABSPATH . preg_replace( '/^\//', '', parse_url( get_option( 'lg_config__page_ttl_prefix', false ) )['path'] ),
			'link'  => TEMPLATEPATH . '/images/page_title_icon.png',
		),
		array(
			'target' => ABSPATH . preg_replace( '/^\//', '', parse_url( get_option( 'lg_config__group_ttl_prefix', false ) )['path'] ),
			'link'  => TEMPLATEPATH . '/images/group_title_icon.png',
		),
	);

	foreach ( $symlink_cfg as $cfg ) {
		// TODO : どうしてもうまくシンボリックリンクが貼れない
	}
	echo '<div class="message updated"><p> 設定を保存しました。</p></div> ';
}
//var_dump( $postdata );


?>

<h1><?php echo $lgoc_labels['title']; ?>
	<small><?php echo OMNICONFIG_LG_VERSION; ?></small>
</h1>
<div id="omniconfigMsgBox" class="message updated lg_cfg_msgbox" style="display:none;"><p>お待ち下さい</p></div>

<form action="" method="post">

	<div id="configSection">
		<ul>
			<li><a href="#homePageSetting">トップページ設定</a></li>
			<li><a href="#imageUpload">画像設定</a></li>
			<li><a href="#banner">バナー設定</a></li>
			<li><a href="#color">カラー設定</a></li>
			<li><a href="#apisetting">その他の設定</a></li>
			<li><a href="#fileExport">エクスポート</a></li>
		</ul>

		<section id="homePageSetting" class="config_section">
			<h2>トップページ設定</h2>
			<?php render_home_content_editor(); ?>
		</section>
		<section id="imageUpload" class="config_section">
			<h2>画像設定</h2>
			<?php render_media_editor(); ?>
		</section>

		<section id="banner" class="config_section">
			<h2>バナー設定</h2>
			<?php render_banner_editor(); ?>
		</section>

		<section id="color" class="config_section">
			<h2>カラー設定</h2>
			<?php render_color_editor(); ?>
		</section>

		<section id="apisetting" class="config_section">
			<h2>APIキーの設定</h2>
			<?php render_key_editor(); ?>
			<h2>埋め込み地図のデフォルト地点設定</h2>
			<?php render_map_coordinate_editor(); ?>

		</section>

		<section id="fileExport" class="config_section">
			<h2>ファイルのエクスポート</h2>
			<p><strong>！注意！</strong>エクスポートするまえにそれぞれのファイルを保存しておいてください</p>
			<?php render_export_page(); ?>
		</section>
	</div>

	<input type="hidden" name="mode" value="update">
	<input type="submit" value="保存" class="button button-primary">

</form>

