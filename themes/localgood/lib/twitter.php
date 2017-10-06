<?php

// twitter, OAuth関連

// URL, API Key, Token
// 本番時に必ず本番用アカウントに切り替える！

define('TWITTER_REQ_UPDATE', 'https://api.twitter.com/1.1/statuses/update.json');
define('TWITTER_REQ_TWEETS', 'https://api.twitter.com/1.1/search/tweets.json');
//define('TWITTER_REQ_TWEETS', 'https://api.twitter.com/1.1/statuses/show.json');
define('TWITTER_REQ_TOKEN', 'https://api.twitter.com/oauth/request_token');
define('TWITTER_GET_TOKEN','https://api.twitter.com/oauth/access_token');

if(strpos($_SERVER['HTTP_HOST'], '.il3c.' ) > 0){
    // テスト環境
    // 池twitterアカウント使用
    define('CONSUMER_KEY', 'wpKsn4bNdaw8owop3WNtVPu2O');
    define('CONSUMER_SECRET', 'wBcHpxYFTY1HrfXkmTvzIUofLClyZkyZUkjsCezTR0Ff4qtNwP');
    define('OAUTH_CALLBACK', home_url().'/tweet_callback/');
    define('TWEET_SEARCH_QUERY', '#'.LG_ES);
//    define('TWEET_SEARCH_QUERY', 'instagram');
} else {
    // 本番用
    define('CONSUMER_KEY', 'HE41SbC59Ln6iIFArJHrYYAT1');
    define('CONSUMER_SECRET', 'B8Sk8U2VuFaznk7MjF8jA1OImrMSPCYy0RwWFmV81phUuOLIJJ');
    define('OAUTH_CALLBACK',  home_url().'/tweet_callback/');
    define('TWEET_SEARCH_QUERY', '#cocohama');
}

// clearsessions.php -> 関数化
function clear_sessions($_url){
    /* Load and clear sessions */
    session_start();
    session_destroy();
    /* Redirect to page with the connect to Twitter option. */
    header('Location: ' . $_url);
}

// ハッシュ付きツイート収集＆WP記事化して投稿
function get_hashed_tweet(){

    // オブジェクト生成＆キー、トークンセット
    $connection = new TwitterOAuth(
        CONSUMER_KEY, CONSUMER_SECRET
    );
    $bearer_token = $connection->getBearerToken();
    $connection->setBearerToken($bearer_token);

    // APIコール
    $content = $connection->OAuthRequest(
        TWITTER_REQ_TWEETS,
        'GET',
        array (
            'q' => TWEET_SEARCH_QUERY,
            'lang' =>'ja',
            'result_type' => 'recent',
            'count' => '100',
            'include_entities' => true
        )
    );
    $json_ret = json_decode($content);
/*
    header("Content-Type: application/json; charset=utf-8");
    echo $content;
    exit;
*/
    if (!empty($json_ret)){

        foreach ($json_ret->statuses as $_ret ) {
//            var_dump(!empty($_ret->coordinates));

            $_twid = $_ret->id;

            $_latlng = array();

            // coordinates が空で bounding_box に Polygon が設定されている場合は Polygon の中心座標を取る
            if (empty($_ret->coordinates)){
                if (!empty($_ret->place) && ($_ret->place->bounding_box->type == "Polygon")){
                    $_polygon = $_ret->place->bounding_box->coordinates;
                    $_latlng = getLatLngCenter($_polygon[0]);
                }
            } else {
                $_latlng[0] = $_ret->coordinates->coordinates[0];
                $_latlng[1] = $_ret->coordinates->coordinates[1];
            }

            if (!empty($_latlng)) {

                // tweet idを記事タイトルに
                $_array = array(
                    $_twid,
                    '',
                    $_ret->text,
                    '',
                    $_latlng[1],
                    $_latlng[0]
                );

                // 画像取得
                // 最初の一枚のみ

                // twitter標準
                $img = '';

                if (!empty($_ret->entities->media)) {
                    $img = $_ret->entities->media[0]->media_url;
                };

                // instagram
                $instaembd = '';
                if (!empty($_ret->entities->urls)) {
                    $_img = $_ret->entities->urls[0]->expanded_url;
                    if (strpos($_img, 'instagram.com/p/') != 0) {
                        $instaurl = 'http://api.instagram.com/oembed?url=' . $_img;
                        $instajson = file_get_contents($instaurl);
                        $json = json_decode($instajson);
                        $instaembd = $json->html;
                    }
                }

                // tweetをタイトル(=id)で検索
                $args = array(
                    'post_type' => 'tweet',
                    'post_status' => 'publish',
                    's' => $_twid,
                    'exact'=> true
                );
    //                $_tweets = new WP_Query( $args );
                $_tweets = get_posts($args);

                wp_reset_postdata();

                if (empty($_tweets)) {
                    // tweetを投稿
                    $arr_data = array(
                        'post_title' => $_array[0],
                        'post_content' => $_array[2],
                        'post_type' => 'tweet',
                        'post_status' => 'publish'
                    );

                    if (!empty($instaembd)){
                        $arr_data['post_content'] .= $instaembd;
                    }

                    $_tweet_id = wp_insert_post($arr_data);

                    if ($_tweet_id > 0) {
                        // 座標をカスタムフィールドに保存
                        if (!empty($_array[4]) && !empty($_array[5]))
                            update_post_meta($_tweet_id, 'twLatLng', $_array[4] . ',' . $_array[5]);
                        // 画像１枚目
                        if (!empty($img)){
                            update_post_meta($_tweet_id, 'twImgUrl', $img);

                            // サムネ生成の為にアイキャッチ登録
                            $upload_dir = wp_upload_dir();
                            $image_data = file_get_contents($img);
                            $filename = basename($img);
                            if(wp_mkdir_p($upload_dir['path']))
                                $file = $upload_dir['path'] . '/' . $filename;
                            else
                                $file = $upload_dir['basedir'] . '/' . $filename;
                            file_put_contents($file, $image_data);

                            $wp_filetype = wp_check_filetype($filename, null );
                            $attachment = array(
                                'post_mime_type' => $wp_filetype['type'],
                                'post_title' => sanitize_file_name($filename),
                                'post_content' => '',
                                'post_status' => 'inherit'
                            );
                            $attach_id = wp_insert_attachment( $attachment, $file, $_tweet_id );
                            require_once(ABSPATH . 'wp-admin/includes/image.php');
                            $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
                            wp_update_attachment_metadata( $attach_id, $attach_data );

                            set_post_thumbnail( $_tweet_id, $attach_id );

                        }
                        // twitter ツイートID
                        update_post_meta($_tweet_id, 'twTweetID', $_ret->id);
                        // twitter 時間
                        update_post_meta($_tweet_id, 'twTweetDate', $_ret->created_at);
                        // twitter ユーザーID
                        update_post_meta($_tweet_id, 'twUserID', $_ret->user->id);
                        // twitter ユーザーネーム
                        update_post_meta($_tweet_id, 'twUserName', $_ret->user->name);
                        // twitter スクリーンネーム
                        update_post_meta($_tweet_id, 'twScreenName', $_ret->user->screen_name);
                    }
                }
            }
        }
    }
}

// イベントの実行間隔を追加
add_filter('cron_schedules', 'my_interval' );
function my_interval($schedules) {
    // 10分毎を追加
    $schedules['10min'] = array(
        'interval' => 1200,
        'display' => 'every 20 minits'
    );
    return $schedules;
}

// The action will trigger when someone visits your WordPress site
add_action('wp', 'my_activation');
function my_activation() {
//    if ( !wp_next_scheduled( 'my_hourly_event' ) ) {
//        wp_schedule_event( current_time( 'timestamp' ), 'hourly', 'my_hourly_event');
//    }
    wp_clear_scheduled_hook('my_hourly_event');

//        wp_clear_scheduled_hook('my_hourly_event');

    if ( !wp_next_scheduled( 'my_hourly_event' ) ) {
        wp_schedule_event( time(), 'twicedaily', 'my_hourly_event');
//        wp_schedule_event( time(), '10min', 'my_hourly_event');
    }
}

add_action('my_hourly_event', 'get_hashed_tweet');
// add_action('my_hourly_event', 'test_echo');

/**
 * Calculate the center point of multiple latitude/longitude coordinate pairs
 * http://stackoverflow.com/questions/6671183/calculate-the-center-point-of-multiple-latitude-longitude-coordinate-pairs
 */

function rad2degr($rad) { return $rad * 180 / pi(); }
function degr2rad($degr) { return $degr * pi() / 180; }

/**
 * @a latLngInDeg array of arrays with latitude and longtitude pairs (in degrees)
 *   e.g. [[latitude1, longtitude1], [latitude2][longtitude2] ...]
 *
 * @return array with the center latitude longtitude pair (in degrees)
 */
function getLatLngCenter($latLngInDegr) {
    $sumX=0;
    $sumY=0;
    $sumZ=0;

    for ($i=0; $i<count($latLngInDegr); $i++) {
        $lat = degr2rad($latLngInDegr[$i][1]);
        $lng = degr2rad($latLngInDegr[$i][0]);
        // sum of cartesian coordinates
        $sumX += cos($lat) * cos($lng);
        $sumY += cos($lat) * sin($lng);
        $sumZ += sin($lat);
    }

    $avgX = $sumX / count($latLngInDegr);
    $avgY = $sumY / count($latLngInDegr);
    $avgZ = $sumZ / count($latLngInDegr);

    // convert average x, y, z coordinate to latitude and longtitude
    $lng = atan2($avgY, $avgX);
    $hyp = sqrt($avgX * $avgX + $avgY * $avgY);
    $lat = atan2($avgZ, $hyp);

    return array(rad2degr($lng), rad2degr($lat));
}
