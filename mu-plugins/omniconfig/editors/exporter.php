<?php
/**
 * File Export module
 *
 * @package localgood/omniconfig
 */

function render_export_page() {
	global $lgoc_settings;
	?>
	<h4>footer.html の再構築</h4>
	<p>
		<button class="regenerate_footer_html button">footer.html を再構築する</button>
	</p>

	<h4>_palette.scss の再構築</h4>
	<p>未実装</p>
	<ul>
		<li>
			<p>
				<button class="regenerate_palette_scss button">_palette.scss を再生成する</button>
			</p>
		</li>

		<li>
			<p>
				<button class="exec_scss_compile button">SCSS を再コンパイルする</button>
			</p>
		</li>
	</ul>

	<h4>apikeys.json の再構築</h4>
	<p>
		<button class="regenerate_apikeys_json button">apikeys.json を再構築する</button>
	</p>

	<?php
}// End render_export_page.




add_action( 'wp_ajax_lgc_regenerate_footer_html', '_lgc_regenerate_footer_html' );
/**
 * footer.html再生成
 */
function _lgc_regenerate_footer_html() {
	global $lgoc_settings;
	$out = $lgoc_settings['export_path'] . '/' . $lgoc_settings['file_name']['footer'];
	ob_start();
	get_footer();
	$result = file_put_contents( $out, ob_get_clean() );

	if ( $result ) {
		echo '完了しました。';
	} else {
		echo '失敗しました。';
	}
	wp_die();
}


add_action( 'wp_ajax_lgc_regenerate_palette_scss', '_lgc_regenerate_palette_scss' );
/**
 * _palette.scss再生成
 */
function _lgc_regenerate_palette_scss() {
	global $lgoc_settings;
	$out = $lgoc_settings['export_path'] . '/' . $lgoc_settings['file_name']['palette'];

	$option_values = get_option( 'lg_config__color_palette', false );

	ob_start();

	foreach ( $option_values as $key => $value ) {
		echo '$' . $key . ': ' . $value . '; ';
	}

	$result = file_put_contents( $out, ob_get_clean() );

	if ( $result ) {
		echo '完了しました。';
	} else {
		echo '失敗しました。';
	}
	wp_die();
}



add_action( 'wp_ajax_lgc_regenerate_apikeys_json', '_lgc_regenerate_apikeys_json' );
/**
 * apikeys.json再生成
 */
function _lgc_regenerate_apikeys_json() {
	global $lgoc_settings;
	$out = $lgoc_settings['export_path'] . '/' . $lgoc_settings['file_name']['apikeys'];

	$result = array();

	if ( ! empty( get_option( 'lg_config__apikey_googlemap' ) ) ) {
		$result['googlemap'] = get_option( 'lg_config__apikey_googlemap' );
	}

	if ( ! empty( get_option( 'lg_config__apikey_facebook' ) ) ) {
		$result['facebook'] = get_option( 'lg_config__apikey_facebook' );
	}


	add_filter( 'lgcongif_apikey_json', $result );

	ob_start();

	echo json_encode( $result );

	$result = file_put_contents( $out, ob_get_clean() );

	if ( $result ) {
		echo '完了しました。';
	} else {
		echo '失敗しました。';
	}
	wp_die();
}
