<?php
/**
 * サイト共通設定
 *
 * @package localgood/omniconfig
 */

/*
Plugin Name: OMNICONFIG-LG
Author: #7
Version: 0.7.0
*/

add_action( 'init', function () {
	/**
	 * 強制的に LocalGoodテーマを適用
	 */
	$current_theme = wp_get_theme();
	if ( 'localgood' !== $current_theme ) {
		switch_theme( 'localgood' );
	}
} );

$lgoc_settings = array(
	'export_path' => ABSPATH . '/omniconfig',
	'file_name'   => array(
		'footer'    => 'footer.html',
		'footer_sp' => 'footer-sp.html',
		'palette'   => '_palette.scss',
		'apikeys'   => 'apikeys.json',
	),
);

define( 'OMNICONFIG_LG_VERSION', '0.7.0' );
define( 'OMNICONFIG_HOME_URL', add_query_arg( 'page', 'omniconfig', admin_url( 'admin.php' ) ) );

$lgoc_labels = array(
	'title' => get_bloginfo( 'name' ) . 'の設定',
);

$wp_editor_default_options = array(
	'wpautop'          => false,
	'media_buttons'    => true,
	'textarea_rows'    => 12,
	'tinymce'          => true,
	'drag_drop_upload' => false,
);

add_action( 'admin_menu', function () use ( $lgoc_labels ) {
	add_menu_page( $lgoc_labels['title'], $lgoc_labels['title'], 'manage_options', 'omniconfig', 'omniconfig_admin_init', 'dashicons-admin-tools', 150 );
} );

function omniconfig_admin_init() {
	$plugin_dir = plugin_dir_url( __FILE__ ) . basename( __FILE__, '.php' );

	wp_enqueue_media();
	wp_enqueue_script( 'jquery-ui-core' );
	wp_enqueue_script( 'jquery-ui-tabs' );
	wp_enqueue_script( 'lgoc_media_uploader', $plugin_dir . '/js/uploader.js', array( 'jquery' ), null, false );
	wp_enqueue_script( 'jq_spectrum', $plugin_dir . '/lib/bgrins-spectrum/spectrum.js', array( 'jquery' ), null, false );

	wp_enqueue_script( 'lgoc_ajax', $plugin_dir . '/js/ajax.js', array( 'jquery' ), null, false );
	wp_enqueue_script( 'lgoc_common', $plugin_dir . '/js/script.js', array(
		'jquery',
		'jquery-ui-core',
		'jquery-ui-tabs',
		'jq_spectrum',
		'lgoc_ajax',
	), null, false );


	wp_enqueue_style( 'jquery-ui', $plugin_dir . '/css/jquery-ui.min.css', array(), null, 'all' );
	wp_enqueue_style( 'jquery-ui-theme', $plugin_dir . '/css/jquery-ui.theme.min.css', array( 'jquery-ui' ), null, 'all' );
	wp_enqueue_style( 'jq_spectrum', $plugin_dir . '/lib/bgrins-spectrum/spectrum.css', array(), null, 'all' );

	wp_enqueue_style( 'lgoc_common', $plugin_dir . '/css/style.css', array(
		'jquery-ui',
		'jquery-ui-theme',
		'jq_spectrum',
	), null, 'all' );


	wp_localize_script( 'lgoc_common', 'LGJSCONFIG', array(
		'endpoint' => array(
			'wp_ajax'    => admin_url( 'admin-ajax.php' ),
			'wp_home'    => home_url(),
			'goteo_home' => LG_GOTEO_BASE_URL,
		),
		'action'   => array(
			'add_new_bannerset'       => 'lgc_add_new_bannerset',
			'remove_config_post'      => 'lgc_remove_configpost',
			'regenerate_footer_html'  => 'lgc_regenerate_footer_html',
			'regenerate_apikeys_json' => 'lgc_regenerate_apikeys_json',
			'regenerate_palette_scss' => 'lgc_regenerate_palette_scss',
		),
	) );

	echo '<div class="wrap">';
	require_once( 'omniconfig/home.php' );
	echo '</div>';
}

require_once( 'omniconfig/install.php' );
require_once( 'omniconfig/editor-extension.php' );

// Load editor modules.
require_once( 'omniconfig/editors/homecontent-editor.php' );
require_once( 'omniconfig/editors/media-editor.php' );
require_once( 'omniconfig/editors/banner-editor.php' );
require_once( 'omniconfig/editors/color-editor.php' );
require_once( 'omniconfig/editors/key-editor.php' );
require_once( 'omniconfig/editors/map-coordinate.php' );
require_once( 'omniconfig/editors/exporter.php' );
require_once( 'omniconfig/editors/definition-editor.php' );

require_once( 'omniconfig/editors/subject-editor.php' );
