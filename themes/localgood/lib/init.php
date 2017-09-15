<?php

if(isset($_GET['scss'])){
    require_once __DIR__ . '/../../../../vendor/autoload.php';
    SassCompiler::run(__DIR__ . "/../scss/", __DIR__ . "/../css/");
}

// サムネイル設定
add_theme_support('post-thumbnails');
add_image_size('archive-thumbnails', 345, 250, array('center', 'center'));
//add_image_size('mini-thumbnails', 60, 48, true);
add_image_size('pickup_box_main', 547, 244, array('center', 'center'));
add_image_size('pickup_box_sub', 325, 244, array('center', 'center'));
add_image_size('single-main_visual', 1032, 774, array('center', 'center'));
//add_image_size('single-thumbnail', 640, 480, true);s
add_image_size('single-data_visualization', 938);
add_image_size('related-posts', 210, 168, array('center', 'center'));
//add_image_size('top-main_visual', 938, 320, true);
//add_image_size('pc-winsize-thumbnail', 1100, 9999, true);

add_theme_support('automatic-feed-links');


// session
add_action('init', 'myStartSession', 1);
add_action('wp_logout', 'myEndSession');
add_action('wp_login', 'myEndSession');

function myStartSession() {
    if(!session_id()) {
        session_start();
    }
}

function myEndSession() {
    session_destroy();
}

if (isset($_SERVER['HTTP_USER_AGENT'])){
    $ua = $_SERVER['HTTP_USER_AGENT'];
    //iPad, AndroidタブレットはPCビュー
if(preg_match('/iPod|iPhone/i', $_SERVER['HTTP_USER_AGENT']) === 1 || preg_match('/Android.+Mobile/i', $_SERVER['HTTP_USER_AGENT']) === 1 ) {
//if(strpos($ua, 'LocalGood/iOS (Yokohama)') === 0 || strpos($ua, 'LocalGood/Android (Yokohama)') === 0 ) {
        define('DEVICE', 'sp');
    } else {
        define('DEVICE', 'pc');
    }
} else {
    define('DEVICE', 'pc');
}

function addThumbnailToFeed(){
    global $post;
    if (has_post_thumbnail($post->ID)):
        $_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'archive-thumbnails');
        if (isset($_url[0]) && ($_url != "")):
    ?>
    <image>
        <url><?php echo $_url[0]; ?></url>
        <title><?php echo get_the_title_rss(); ?></title>
        <link><?php echo get_permalink(); ?></link>
        <width><?php echo $_url[1]; ?></width>
        <height><?php echo $_url[2]; ?></height>
    </image>
    <?php
        endif;
    endif;
}
add_action('rss2_item','addThumbnailToFeed');
add_action('rss_item','addThumbnailToFeed');

// Change posts_per_rss value
// for WP 3.9 ONLY !!!!!
// http://dogmap.jp/2013/08/21/post-2984/
function posts_per_rss_for_feed($value) {
    if (!is_feed()) {
        return $value;
    } else {
        if (isset($_GET['ppr']) && !empty($_GET['ppr']) && is_numeric($_GET['ppr'])){
            return intval($_GET['ppr']);
        }
    }
    return $value;
}
add_filter( 'option_posts_per_rss', 'posts_per_rss_for_feed' );


/*-------------------------------------------*/
/* 寄稿者権限でもメディアをアップロードできる
/*-------------------------------------------*/

if ( current_user_can('contributor') && !current_user_can('upload_files') ){
    add_action('admin_init', 'allow_contributor_uploads');
}

function allow_contributor_uploads() {
    $contributor = get_role('contributor');
    $contributor->add_cap('upload_files');
}