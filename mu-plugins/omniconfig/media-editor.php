<?php
/**
* Media Editor module
*
* @package localgood/omniconfig
*/

function render_media_editor() {
?>
	<div>
		<p>ロゴ画像（大）</p>
		<img src="" class="media-preview media-preview_logo_large">
		<input type="text" name="lg_config__logo_large"
			   value="<?php echo get_option( 'lg_config__logo_large' ); ?>" class="media-url_logo_large input_text_70p">
		<button class="select-media button" data-media-target="logo_large">画像を追加</button>
		<button class="remove-image button" data-target="logo_large">画像を削除</button>
	</div>

	<div>
		<p>ロゴ画像（小）</p>
		<img src="" class="media-preview media-preview_logo_small">
		<input type="text" name="lg_config__logo_small"
			   value="<?php echo get_option( 'lg_config__logo_small' ); ?>" class="media-url_logo_small input_text_70p">
		<button class="select-media button" data-media-target="logo_small">画像を追加</button>
		<button class="remove-image button" data-target="logo_small">画像を削除</button>
	</div>
<?php
} // End render_media_editor().
