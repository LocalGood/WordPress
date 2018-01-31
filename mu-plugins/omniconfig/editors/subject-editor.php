<?php
/**
 * Tweet Setting Module
 *
 * @package localgood/omniconfig
 */

add_action( 'admin_menu', function () {
	add_submenu_page( 'edit.php?post_type=tweet', 'みんなの声の設定', '設定', 'manage_options', 'tweet-settings', 'tweet_setting_page_init' );
	function tweet_setting_page_init() {

		if ( isset( $_POST ) && 'update' === $_POST['mode'] ) {
			if ( isset( $_POST['tweet_guide_contents'] ) ) {
				update_option( 'lg_config__tweet_guide_contents', $_POST['tweet_guide_contents'] );
			} else {
				delete_option( 'lg_config__tweet_guide_contents' );
			}

			echo '<div class="message updated"><p>設定を保存しました。</p></div>';
		}

		$tweet_guide_contents = get_option( 'lg_config__tweet_guide_contents' );

		// render
		echo '<div class="wrap">';
		echo '<h1>みんなの声の設定</h1>';
		echo '<hr>';
		echo '<p>（TODO:ガイダンス考える）</p>';

		echo '<form method="post">';
		wp_editor( $tweet_guide_contents, 'tweet_guide_contents_editor', array(
			'wpautop'       => true,
			'media_buttons' => true,
			'textarea_name' => 'tweet_guide_contents',
			'textarea_rows' => 18,
		) );
		echo '<hr>';
		echo '<input type="hidden" name="mode" value="update">';
		echo '<input type="submit" value="保存" class="button button-primary">';
		echo '</form>';
		echo '</div>';


	}
} );
