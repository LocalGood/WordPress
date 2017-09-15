<?php
/**
 * Created by PhpStorm.
 * User: m454k1
 * Date: 2014/08/25
 * Time: 10:57
 */

$json_array = array();

$args = array(
    'post_type' => array('subject','tweet'),
    'posts_per_page' => -1
);
$subjects_query = new WP_Query($args);

if ($subjects_query->have_posts()) {
    while ($subjects_query->have_posts()) {
        $subjects_query->the_post();

        $_array = array();

        $_thumb = '';

        $cf = get_post_custom($post->ID);

        $latlng = array(0,0);

        if (get_post_type() == 'subject'){
        // 投稿地域課題
            if (!empty($cf['sbLatLng']) && (strpos($cf['sbLatLng'][0], ',') > 0))
                $latlng = explode(',', $cf['sbLatLng'][0]);
            $_content = get_the_excerpt();
            $_thumb = get_the_post_thumbnail($post->ID, 'archive-thumbnails');
            $_id = 'subject';
        } elseif (get_post_type() == 'tweet') {
        // twitter課題
            if (!empty($cf['twLatLng']) && (strpos($cf['twLatLng'][0], ',') > 0))
                $latlng = explode(',', $cf['twLatLng'][0]);
            $_content = get_the_content();
//            $_thumb = '';
            $_thumb = get_the_post_thumbnail($post->ID, 'archive-thumbnails');
            $_id = 'tweet';
        }

        $_array = array(
            get_the_title(),
            get_permalink(),
            $_content,
            $_thumb,
            $latlng[0],
            $latlng[1],
            $_id
        );
        array_push($json_array, $_array);
    }
}

wp_reset_postdata();

$json_val = json_encode( $json_array );

header( 'Content-Type: text/javascript; charset=utf-8' );
echo $json_val;


//if ( $_GET['type'] == 'lg_subject' ) {
//
//    // Wordpress LocalGood 課題マップ
//
//    $args = array(
//        'post_type' => array('subject', ),
//        'posts_per_page' => -1
//    );
//    $subjects_query = new WP_Query($args);
//
//    if ($subjects_query->have_posts()){
//        while ($subjects_query->have_posts()){
//            $subjects_query->the_post();
//
//            $cf = get_post_custom($post->ID);
//            if (!empty($cf['sbLatLng']) && (strpos($cf['sbLatLng'][0],',') > 0 )){
//
//                $_array = array();
//                $latlng = explode(',',$cf['sbLatLng'][0]);
//
//                $_array = array(
//                    get_the_title(),
//                    get_permalink(),
//                    get_the_excerpt(),
//                    get_the_post_thumbnail($post->ID,'archive-thumbnails'),
//                    $latlng[0],
//                    $latlng[1]
//                );
//                array_push($json_array, $_array);
//            }
//        }
//    }
//    wp_reset_postdata();
//
//} elseif ( $_GET['type'] == 'tweet' )  {
//
////    get_hashed_tweet();
//
//// Twitterから課題抽出
////    /* If access tokens are not available redirect to connect page. */
////    if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
////        //    header('Location: ./clearsessions.php');
////        //    clear_sessions(home_url('/tweet_connect/'));
////        clear_sessions(home_url('/tweet_subject/?stat=go_tweet'));
////    }
//
//    /* Get user access tokens out of the session. */
////    $access_token = $_SESSION['access_token'];
//
//    /* Create a TwitterOauth object with consumer/user tokens. */
////    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
//
//    $args = array(
//        'post_type' => array('tweet'),
//        'posts_per_page' => -1
//    );
//    $_tweet_query = new WP_Query($args);
//
//    if ($_tweet_query->have_posts()){
//        while ($_tweet_query->have_posts()){
//            $_tweet_query->the_post();
//
//            $cf = get_post_custom($post->ID);
//
//            if (!empty($cf['twLatLng']) && (strpos($cf['twLatLng'][0],',') > 0 )){
//
//                $latlng = explode(',',$cf['twLatLng'][0]);
//
//                $_array = array(
//                    get_the_title(),
//                    get_permalink(),
//                    get_the_content(),
//                    '',
//                    $latlng[0],
//                    $latlng[1]
//                );
//
//            }
//            array_push($json_array, $_array);
//        }
//    }
//    wp_reset_postdata();
//}

?>