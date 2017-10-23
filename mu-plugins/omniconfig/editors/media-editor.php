<?php
/**
* Media Editor module
*
* @package localgood/omniconfig
*/

function render_media_editor() {
?>
	<div>
		<p>ヘッダーロゴ画像１</p>
		<p class="description">トップページファーストビューで表示されるロゴ<span>（推奨画像サイズ：146px x 43px）</span></p>
		<img src="<?php echo get_option( 'lg_config__header_logo_1' ); ?>" class="media-preview media-preview_header_logo_1">
		<input type="text" name="lg_config__header_logo_1"
			   value="<?php echo get_option( 'lg_config__header_logo_1' ); ?>" class="media-url_header_logo_1 input_text_70p">
		<button class="select-media button" data-media-target="header_logo_1">画像を追加</button>
		<button class="remove-image button" data-target="header_logo_1">画像を削除</button>
	</div>
	<div>
		<p>ヘッダーロゴ画像２</p>
		<p class="description">ヘッダーロゴ画像１以外の場所で使われるロゴ<span>（推奨画像サイズ：131px x 39px）</span></p>
		<img src="<?php echo get_option( 'lg_config__header_logo_2' ); ?>" class="media-preview media-preview_header_logo_2">
		<input type="text" name="lg_config__header_logo_2"
			   value="<?php echo get_option( 'lg_config__header_logo_2' ); ?>" class="media-url_header_logo_2 input_text_70p">
		<button class="select-media button" data-media-target="header_logo_2">画像を追加</button>
		<button class="remove-image button" data-target="header_logo_2">画像を削除</button>
	</div>
	<div>
		<p>フッターロゴ画像</p>
        <p class="description"><span>（推奨画像サイズ：280px x 82px）</span></p>
		<img src="<?php echo get_option( 'lg_config__footer_logo' ); ?>" class="media-preview media-preview_footer_logo">
		<input type="text" name="lg_config__footer_logo"
			   value="<?php echo get_option( 'lg_config__footer_logo' ); ?>" class="media-url_footer_logo input_text_70p">
		<button class="select-media button" data-media-target="footer_logo">画像を追加</button>
		<button class="remove-image button" data-target="footer_logo">画像を削除</button>
	</div>

	<div>
		<p>ページタイトルアイコン</p>
        <p class="description"><span>（推奨画像サイズ：39px x 32px）</span></p>
		<img src="<?php echo get_option( 'lg_config__page_ttl_prefix' ); ?>" class="media-preview media-preview_page_ttl_prefix">
		<input type="text" name="lg_config__page_ttl_prefix"
			   value="<?php echo get_option( 'lg_config__page_ttl_prefix' ); ?>" class="media-url_page_ttl_prefix input_text_70p">
		<button class="select-media button" data-media-target="page_ttl_prefix">画像を追加</button>
		<button class="remove-image button" data-target="page_ttl_prefix">画像を削除</button>
	</div>

	<div>
		<p>グループタイトルアイコン</p>
        <p class="description"><span>（推奨画像サイズ：23px x 27px）</span></p>
		<img src="<?php echo get_option( 'lg_config__group_ttl_prefix' ); ?>" class="media-preview media-preview_group_ttl_prefix">
		<input type="text" name="lg_config__group_ttl_prefix"
			   value="<?php echo get_option( 'lg_config__group_ttl_prefix' ); ?>" class="media-url_group_ttl_prefix input_text_70p">
		<button class="select-media button" data-media-target="group_ttl_prefix">画像を追加</button>
		<button class="remove-image button" data-target="group_ttl_prefix">画像を削除</button>
	</div>

	<div>
		<p>favicon</p>
        <p class="description"><span>（推奨画像サイズ：128px x 128px）</span></p>
		<img src="<?php echo get_option( 'lg_config__favicon' ); ?>" class="media-preview media-preview_favicon">
		<input type="text" name="lg_config__favicon"
			   value="<?php echo get_option( 'lg_config__favicon' ); ?>" class="media-url_favicon input_text_70p">
		<button class="select-media button" data-media-target="favicon">画像を追加</button>
		<button class="remove-image button" data-target="favicon">画像を削除</button>
	</div>


	<?php
} // End render_media_editor().
