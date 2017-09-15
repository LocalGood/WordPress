<?php
/**
 * Home Content Editor module
 *
 * @package localgood/omniconfig
 */

function render_home_content_editor() {
?>
<div id="homeContentEditorWrap" class="homecontent_editor_wrap">
	<ul class="hce_navigation">
		<li><a href="#hceSect1">メインビジュアル</a></li>
		<li><a href="#hceSect2">キャッチコピー・<?php bloginfo( 'name' ); ?>について</a></li>
		<li><a href="#hceSect3"><?php bloginfo( 'name' ); ?>でできること</a></li>
	</ul>

	<div id="hceSect1" class="hce_section">
		<h3>メインビジュアル</h3>
		<dl>
			<dt>メインロゴ</dt>
			<dd>
				<img src="<?php echo get_option( 'lg_config__main_logo' ); ?>" class="media-preview media-preview_main_logo">
				<input type="text" name="lg_config__main_logo"
					   value="<?php echo get_option( 'lg_config__main_logo' ); ?>" class="media-url_main_logo input_text_70p">
				<button class="select-media button" data-media-target="main_logo">画像を追加</button>
				<button class="remove-image button" data-target="main_logo">画像を削除</button>
			</dd>
			<dt>トップページ背景</dt>
			<dd>
				<img src="<?php echo get_option( 'lg_config__home_wallpaper' ); ?>" class="media-preview media-preview_home_wallpaper">
				<input type="text" name="lg_config__home_wallpaper"
					   value="<?php echo get_option( 'lg_config__home_wallpaper' ); ?>"
					   class="media-url_home_wallpaper input_text_70p">
				<button class="select-media button" data-media-target="home_wallpaper">画像を追加</button>
				<button class="remove-image button" data-target="home_wallpaper">画像を削除</button>
			</dd>

		</dl>
	</div>
	<div id="hceSect2" class="hce_section">
		<h3>キャッチコピー</h3>
		<dl>
			<dt>キャッチコピー</dt>
			<dd><input type="text" class="input_text_fullsize" name="lg_config__catch_copy"
					   value="<?php echo esc_html( get_option( 'lg_config__catch_copy' ) ); ?>"></dd>
		</dl>

		<h3><?php bloginfo( 'title' ); ?>について</h3>
		<dl>
			<dt>本文</dt>
			<dd>
				<?php
				global $wp_editor_default_options;
				$wp_editor_options  = array_merge( $wp_editor_default_options, array(
					'media_buttons' => false,
					'textarea_rows' => 10,
				) );
				$home_about_content = get_option( 'lg_config__about_content' );
				wp_editor( $home_about_content, 'lg_config__about_content', $wp_editor_options );
				?>
			</dd>
		</dl>
	</div>
	<div id="hceSect3" class="hce_section">
		<h3><?php bloginfo( 'title' ); ?>でできること</h3>
		<dl>
			<dt>地域を知ろう</dt>
			<dd>
				<?php
				global $wp_editor_default_options;
				$wp_editor_options  = array_merge( $wp_editor_default_options, array(
					'media_buttons' => false,
					'textarea_rows' => 5,
				) );
				$home_about_content = get_option( 'lg_config__know_the_zone_msg' );
				wp_editor( $home_about_content, 'lg_config__know_the_zone_msg', $wp_editor_options );
				?>
			</dd>
			<dt>地域をに参加しよう</dt>
			<dd>
				<?php
				global $wp_editor_default_options;
				$wp_editor_options  = array_merge( $wp_editor_default_options, array(
					'media_buttons' => false,
					'textarea_rows' => 5,
				) );
				$home_about_content = get_option( 'lg_config__join_the_zone_msg' );
				wp_editor( $home_about_content, 'lg_config__join_the_zone_msg', $wp_editor_options );
				?>
			</dd>

		</dl>

	</div>

</div>
<?php
} // End render_home_content_editor().
