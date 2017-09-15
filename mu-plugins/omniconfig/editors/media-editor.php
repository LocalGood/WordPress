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
		<p class="description">トップページファーストビューで表示されるロゴ</p>
		<img src="<?php echo get_option( 'lg_config__header_logo_1' ); ?>" class="media-preview media-preview_header_logo_1">
		<input type="text" name="lg_config__header_logo_1"
			   value="<?php echo get_option( 'lg_config__header_logo_1' ); ?>" class="media-url_header_logo_1 input_text_70p">
		<button class="select-media button" data-media-target="header_logo_1">画像を追加</button>
		<button class="remove-image button" data-target="header_logo_1">画像を削除</button>
	</div>
	<div>
		<p>ヘッダーロゴ画像２</p>
		<p class="description">ヘッダーロゴ画像１以外の場所で使われるロゴ</p>
		<img src="<?php echo get_option( 'lg_config__header_logo_2' ); ?>" class="media-preview media-preview_header_logo_2">
		<input type="text" name="lg_config__header_logo_2"
			   value="<?php echo get_option( 'lg_config__header_logo_2' ); ?>" class="media-url_header_logo_2 input_text_70p">
		<button class="select-media button" data-media-target="header_logo_2">画像を追加</button>
		<button class="remove-image button" data-target="header_logo_2">画像を削除</button>
	</div>
	<div>
		<p>フッターロゴ画像</p>
		<img src="<?php echo get_option( 'lg_config__footer_logo' ); ?>" class="media-preview media-preview_footer_logo">
		<input type="text" name="lg_config__footer_logo"
			   value="<?php echo get_option( 'lg_config__footer_logo' ); ?>" class="media-url_footer_logo input_text_70p">
		<button class="select-media button" data-media-target="footer_logo">画像を追加</button>
		<button class="remove-image button" data-target="footer_logo">画像を削除</button>
	</div>


<?php
} // End render_media_editor().
