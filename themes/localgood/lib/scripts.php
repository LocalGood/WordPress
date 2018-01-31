<?php
// JS読み込み
function addScripts() {
	if ( ! is_admin() ) {
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery.bxslider.js', get_template_directory_uri() . '/js/jquery.bxslider.js' );
		wp_enqueue_style( 'normarize.css', get_template_directory_uri() . '/lib_css/normarize.css' );
		wp_enqueue_style( 'commons.css', get_template_directory_uri() . '/css/commons.css' );
		wp_enqueue_style( 'styles.css', get_template_directory_uri() . '/css/styles.css' );
		wp_enqueue_style( 'bxslider.css', get_template_directory_uri() . '/lib_css/jquery.bxslider.css',
			array( 'normarize.css' ) );
		wp_enqueue_script( 'GoogleMap.js', '//maps.googleapis.com/maps/api/js?key=' . get_option( 'lg_config__apikey_googlemap' ) );
		wp_enqueue_script( 'common.js', get_template_directory_uri() . '/js/common.js' );
		if ( DEVICE == 'pc' ):
			wp_enqueue_script( 'localgood.js', get_template_directory_uri() . '/js/localgood.js' );
			if ( is_home() ):
				wp_enqueue_style( 'index.css', get_template_directory_uri() . '/css/index.css',
					array( 'normarize.css', 'commons.css', 'bxslider.css' ) );
				wp_enqueue_script( 'index.js', get_template_directory_uri() . '/js/index.js' );
			else:
				wp_enqueue_style( 'overall.css', get_template_directory_uri() . '/css/overall.css',
					array( 'normarize.css', 'commons.css' ) );
			endif;
		elseif ( DEVICE == 'sp' ):
			wp_enqueue_script( 'localgood.js', get_template_directory_uri() . '/js/localgood-sp.js' );
			if ( is_page( 'mailnews' ) ) {
				wp_enqueue_script( 'mailnews.js', get_template_directory_uri() . '/js/mailnews.js' );
			}
			wp_enqueue_script( 'meanmenu.js', get_template_directory_uri() . '/js/jquery.meanmenu.min.js' );
			wp_enqueue_script( 'sp.js', get_template_directory_uri() . '/js/sp.js' );
			if ( is_page( 'lgnews' ) || is_page( 'lgplayer' ) || is_category() ) {
				wp_enqueue_script( 'news-sp.js', get_template_directory_uri() . '/js/news-sp.js' );
			} elseif ( is_page( 'submit_subject' ) ) {
				wp_enqueue_script( 'subject-sp.js', get_template_directory_uri() . '/js/subject-sp.js' );
			}
			wp_enqueue_style( 'meanmenu.css', get_template_directory_uri() . '/js/meanmenu.min.css' );
			wp_enqueue_style( 'mobile.css', get_template_directory_uri() . '/css/mobile.css',
				array( 'bxslider.css', 'meanmenu.css' ) );
			//wp_enqueue_style( 'mobile_reset.css', get_template_directory_uri().'/css/mobile_reset.css',array());
		endif;
		if ( is_page( 'submit_subject' ) ) {
			wp_enqueue_script( 'submit_subject.js', get_template_directory_uri() . '/js/submit_subject.js' );
		}
		if ( is_post_type_archive( 'subject' ) || is_post_type_archive( 'tweet' ) ) {
			wp_enqueue_script( 'archive-subject.js', get_template_directory_uri() . '/js/archive-subject.js' );
		}
		if ( is_post_type_archive( 'skills' ) || is_singular( 'skills' ) ) {
			if ( DEVICE == 'pc' ):
				wp_enqueue_script( 'archive-skills.js', get_template_directory_uri() . '/js/archive-skills.js' );
			elseif ( ( DEVICE == 'sp' ) && is_archive() || is_singular( 'skills' ) ):
				wp_enqueue_script( 'archive-skills.js', get_template_directory_uri() . '/js/archive-skills-sp.js' );
				wp_enqueue_script( 'flipsnap.min.js', get_template_directory_uri() . '/js/plugins/flipsnap.min.js' );
			endif;
		}
		if ( is_page( 'tweet_subject' ) ) {
			wp_enqueue_script( 'widgets.js', '//platform.twitter.com/widgets.js' );
		}
		if ( is_single() ) {
			wp_enqueue_script( 'single.js', get_template_directory_uri() . '/js/single.js' );
		}

		if ( is_page( 'lgplayer' ) || is_post_type_archive( 'data' ) || is_post_type_archive( 'event' ) || is_category() || is_page( 'lgnews' ) ) {
			wp_enqueue_script( 'search.js', get_template_directory_uri() . '/js/search.js' );
		}
	}
}

add_action( 'wp_enqueue_scripts', 'addScripts' );