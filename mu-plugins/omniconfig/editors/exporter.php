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
	<ul>
		<li>
			<p>
				<button class="regenerate_palette_scss button">_palette.scss を再生成する</button>
			</p>
		</li>

		<h4>SCSSファイルのコンパイル（スタイルシートの更新）</h4>
		<li>
			<p>
				<button class="exec_scss_compile_wp button">WordPress</button>
				<button class="exec_scss_compile_goteo button"
						data-compile-key="<?php echo hash( 'md5', 'foobar' ); ?>">Goteo
				</button>
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
	$out    = $lgoc_settings['export_path'] . '/' . $lgoc_settings['file_name']['footer'];
	$result = array();
	ob_start();
	get_footer();
	$result['pc'] = file_put_contents( $out, ob_get_clean() );

	$out = $lgoc_settings['export_path'] . '/' . $lgoc_settings['file_name']['footer_sp'];
	ob_start();
	get_template_part( 'footer', 'sp' );
	$result['sp'] = file_put_contents( $out, ob_get_clean() );


	if ( ! empty( $result ) ) {
		$msg = ( $result['pc'] ) ? 'PC -> OK' : 'PC -> ERROR';
		$msg .= '\n';
		$msg .= ( $result['sp'] ) ? 'SP -> OK' : 'SP -> ERROR';
		echo $msg;
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
		$result['apikey']['googlemap'] = get_option( 'lg_config__apikey_googlemap' );
	}

	if ( ! empty( get_option( 'lg_config__apikey_facebook' ) ) ) {
		$result['apikey']['facebook'] = get_option( 'lg_config__apikey_facebook' );
	}

	if ( ! empty( get_option( 'lg_config__coordinate_longitude' ) ) ) {
		$result['googlemaps']['coordinate']['longitude'] = get_option( 'lg_config__coordinate_longitude' );
	}

	if ( ! empty( get_option( 'lg_config__coordinate_latitude' ) ) ) {
		$result['googlemaps']['coordinate']['latitude'] = get_option( 'lg_config__coordinate_latitude' );
	}

	if ( ! empty( get_option( 'lg_config__default_zoomlevel' ) ) ) {
		$result['googlemaps']['default_zoom_level'] = get_option( 'lg_config__default_zoomlevel' );
	}

	if ( ! empty( get_option( 'lg_config__header_logo_1' ) ) ) {
		$result['images']['header_logo_1'] = get_option( 'lg_config__header_logo_1' );
	}

	if ( ! empty( get_option( 'lg_config__header_logo_2' ) ) ) {
		$result['images']['header_logo_2'] = get_option( 'lg_config__header_logo_2' );
	}

	if ( ! empty( get_option( 'lg_config__favicon' ) ) ) {
		$result['images']['favicon'] = get_option( 'lg_config__favicon' );
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
