<?php
/**
 * Created by PhpStorm.
 * User: m454k1
 * Date: 2014/08/12
 * Time: 15:07
 */

//var_dump($_POST['stage']);
//if (!empty($_POST['stage']) && $_POST['stage'] == 'tweet'):

// データ保存
$_tweet_data = array(
    'tweet_content', 'tweet_lat', 'tweet_lng'
);
if (is_array($_POST)){
    foreach($_tweet_data as $_k ){
        if (array_key_exists($_k, $_POST) && (!empty($_POST[$_k]))){
            $_SESSION['tweet_data'][$_k] = $_POST[$_k];
        }
    }
}


// テンプレ表示
function show_wp_template($_content){
    get_header();
    ?>
        <div class="c-contents_wrapper c-w1096">
            <?php breadcrumbs(); ?>
            <?php knows_head_tab(); ?>

            <div class="inner">
                <?php breadcrumbs(); ?>
                <div class="static_page">
                    <?php if(have_posts()): the_post(); ?>
                    <h1>twitterに投稿しました</h1>
                    <div class="content">
                        <?php
//                        var_dump($_SESSION);
                        ?>
                        <?= $_content ?>

                        <div class="form_block cf">
                            <span class="button">
                                <a class="button reset" style="margin-left:0" href="<?= home_url(); ?>">ホームに戻る</a>
                            </span>
                        </div>

                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div><!--.contents_wrapper-->
    <?php
    get_footer();
};


// メイン処理

if (!empty($_GET['stat']) && ( $_GET['stat'] == 'go_tweet' )){

    // connect.php
    $_content = '<a href="' . home_url('/tweet_subject/?stat=get_token') . '">つぶやく</a>';

    show_wp_template( $_content );

} elseif (
    ( !empty($_GET['stat']) && ( $_GET['stat'] == 'get_token' ) ) ||
    ( !empty($_POST['stage']) &&  ( $_POST['stage'] == 'tweet' ) )
) {

    // redirect.php

    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

    /* Get temporary credentials. */
    $request_token = $connection->getRequestToken(OAUTH_CALLBACK);

    /* Save temporary credentials to session. */
    $_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
    $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

    if (!empty($_GET['dest'])){
        $_SESSION['dest'] = $_GET['dest'];
    }

    /* If last connection failed don't display authorization link. */
    switch ($connection->http_code) {
        case 200:
            /* Build authorize URL and redirect user to Twitter. */
            $url = $connection->getAuthorizeURL($token);
            header('Location: ' . $url);
            break;
        default:
            /* Show notification if something went wrong. */
            echo 'Could not connect to Twitter. Refresh the page or try again later.';
    }
    exit;

} else {

    /* If access tokens are not available redirect to connect page. */
    if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
        //    header('Location: ./clearsessions.php');
        //    clear_sessions(home_url('/tweet_connect/'));
        clear_sessions(home_url('/tweet_subject/?stat=go_tweet'));
    }

    /* Get user access tokens out of the session. */
    $access_token = $_SESSION['access_token'];

    /* Create a TwitterOauth object with consumer/user tokens. */
    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

    /* If method is set change API call made. Test is called by default. */
    //    $content = $connection->get('account/verify_credentials');
//    $content = $connection->OAuthRequest(
//        TWITTER_REQ_TWEETS,
//        'GET',
//        array('q' =>'#yokohama',
//        'lang' =>'ja',
//        'count'=>'20')
//    );

    $_params = array();

    $_params['status'] = $_SESSION['tweet_data']['tweet_content'];

    if (!empty($_SESSION['tweet_data']['tweet_lat'])){
        $_params['lat'] = floatval($_SESSION['tweet_data']['tweet_lat']);
        $_params['display_coordinates'] = true;
    }

    if (!empty($_SESSION['tweet_data']['tweet_lng'])){
        $_params['long'] = floatval($_SESSION['tweet_data']['tweet_lng']);
        $_params['display_coordinates'] = true;
    }


    $content = $connection->OAuthRequest(
        TWITTER_REQ_UPDATE,
        'POST',
        $_params
    );

    $json_ret = json_decode($content);

    if (!empty($json_ret)){


//        $content = $connection->get('statuses/oembed');
        $_content = $connection->OAuthRequest(
            'https://api.twitter.com/1.1/statuses/oembed.json',
            'GET',
            array('id'=>$json_ret->id)
        );

        $_oembed = '';

        if (!empty($_content)) {
            $_json_ret = json_decode($_content);
            if (!empty($_json_ret->html)){
                $_oembed = $_json_ret->html;
            }
        };

/*        ob_start();
        echo '<p>$_params</p>';
        var_dump($_params);
        echo '<p>$json_ret</p>';
        var_dump($json_ret);
//        foreach ($json_ret as $_ret){
//            var_dump($_ret);
//        }
        $_content = ob_get_contents();
        ob_end_clean();*/

        show_wp_template( $_oembed );
    };
}