<?php
/**
 * Editor Page Extension
 *
 * @package localgood/omniconfig
 */

add_action( 'current_screen', function () {
	$current_screen = get_current_screen();

	if ( 'lg_configset' === $current_screen->post_type ) {

		add_action( 'edit_form_top', function () {
			$sitename = get_bloginfo( 'title' );

			echo '<div class="message updated">';
			echo '<p>' . $sitename . 'の設定を編集中です。<a href="' . OMNICONFIG_HOME_URL . '" class="page-title-action">設定ページに戻る</a></p>';
			echo '</div>';
		} );

	}
} );





