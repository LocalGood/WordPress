<?php
// JS読み込み
function addScripts() {
	$version = LG::themeinfo()->version;
	if ( ! is_admin() ) {
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery.bxslider.js', get_template_directory_uri() . '/js/jquery.bxslider.js', array( 'jquery' ), $version );
		wp_enqueue_style( 'normarize.css', get_template_directory_uri() . '/lib_css/normarize.css', array(), $version );
		wp_enqueue_style( 'commons.css', get_template_directory_uri() . '/css/commons.css', array(), $version );
		wp_enqueue_style( 'styles.css', get_template_directory_uri() . '/css/styles.css', array(), $version );
		wp_enqueue_style( 'fontawesome.css', 'https://use.fontawesome.com/releases/v5.0.6/css/all.css', array(), $version );
		wp_enqueue_style( 'bxslider.css', get_template_directory_uri() . '/lib_css/jquery.bxslider.css',
			array( 'normarize.css' ), $version );
		wp_enqueue_script( 'GoogleMap.js', '//maps.googleapis.com/maps/api/js?key=' . get_option( 'lg_config__apikey_googlemap' ), array(), null );
		wp_enqueue_script( 'common.js', get_template_directory_uri() . '/js/common.js', array(), $version );
		if ( DEVICE == 'pc' ):
			wp_enqueue_script( 'localgood.js', get_template_directory_uri() . '/js/localgood.js', array(), $version );
			if ( is_home() ):
				wp_enqueue_style( 'index.css', get_template_directory_uri() . '/css/index.css',
					array( 'normarize.css', 'commons.css', 'bxslider.css' ), $version );
				wp_enqueue_script( 'index.js', get_template_directory_uri() . '/js/index.js', array(), $version );
			else:
				wp_enqueue_style( 'overall.css', get_template_directory_uri() . '/css/overall.css',
					array( 'normarize.css', 'commons.css' ), $version );
			endif;
		elseif ( DEVICE == 'sp' ):
			wp_enqueue_script( 'localgood.js', get_template_directory_uri() . '/js/localgood-sp.js', array(), $version );
			if ( is_page( 'mailnews' ) ) {
				wp_enqueue_script( 'mailnews.js', get_template_directory_uri() . '/js/mailnews.js', array(), $version );
			}
			wp_enqueue_script( 'meanmenu.js', get_template_directory_uri() . '/js/jquery.meanmenu.min.js', array(), $version );
			wp_enqueue_script( 'sp.js', get_template_directory_uri() . '/js/sp.js', array(), $version );
			if ( is_page( 'lgnews' ) || is_page( 'lgplayer' ) || is_category() ) {
				wp_enqueue_script( 'news-sp.js', get_template_directory_uri() . '/js/news-sp.js', array(), $version );
			} elseif ( is_page( 'submit_subject' ) ) {
				wp_enqueue_script( 'subject-sp.js', get_template_directory_uri() . '/js/subject-sp.js', array(), $version );
			}
			wp_enqueue_style( 'meanmenu.css', get_template_directory_uri() . '/js/meanmenu.min.css', array(), $version );
			wp_enqueue_style( 'mobile.css', get_template_directory_uri() . '/css/mobile.css',
				array( 'bxslider.css', 'meanmenu.css' ), $version );
			//wp_enqueue_style( 'mobile_reset.css', get_template_directory_uri().'/css/mobile_reset.css',array());
		endif;
		if ( is_page( 'submit_subject' ) ) {
			wp_enqueue_script( 'submit_subject.js', get_template_directory_uri() . '/js/submit_subject.js', array(), $version );
		}
		if ( is_post_type_archive( 'subject' ) || is_post_type_archive( 'tweet' ) ) {
			wp_enqueue_script( 'archive-subject.js', get_template_directory_uri() . '/js/archive-subject.js', array(), $version );
		}
		if ( is_post_type_archive( 'skills' ) || is_singular( 'skills' ) ) {
			if ( DEVICE == 'pc' ):
				wp_enqueue_script( 'archive-skills.js', get_template_directory_uri() . '/js/archive-skills.js', array(), $version );
			elseif ( ( DEVICE == 'sp' ) && is_archive() || is_singular( 'skills' ) ):
				wp_enqueue_script( 'archive-skills.js', get_template_directory_uri() . '/js/archive-skills-sp.js', array(), $version );
				wp_enqueue_script( 'flipsnap.min.js', get_template_directory_uri() . '/js/plugins/flipsnap.min.js', array(), $version );
			endif;
		}
		if ( is_page( 'tweet_subject' ) ) {
			wp_enqueue_script( 'widgets.js', '//platform.twitter.com/widgets.js', array(), $version );
		}
		if ( is_single() ) {
			wp_enqueue_script( 'single.js', get_template_directory_uri() . '/js/single.js', array(), $version );
		}

		if ( is_page( 'lgplayer' ) || is_post_type_archive( 'data' ) || is_post_type_archive( 'event' ) || is_category() || is_page( 'lgnews' ) ) {
			wp_enqueue_script( 'search.js', get_template_directory_uri() . '/js/search.js', array(), $version );
		}
	}
}

add_action( 'wp_enqueue_scripts', 'addScripts' );