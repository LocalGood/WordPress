<?php
/**
 * Created by PhpStorm.
 * User: m454k1
 * Date: 2014/09/01
 * Time: 14:38
 */


/* Start session and load lib */
// session_start();
// require_once('lib/twitteroauth/twitteroauth.php');
// require_once('lib/config.php');

/* If the oauth_token is old redirect to the connect page. */
if (isset($_REQUEST['oauth_token']) && $_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
    $_SESSION['oauth_status'] = 'oldtoken';
//    clear_sessions(home_url('/tweet_connect/'));
    if (!empty($_SESSION['dest']) && ($_SESSION['dest'] == 'map')){
        clear_sessions(home_url('/tweet_subject/?stat=get_token&dest=map'));
    } else {
        clear_sessions(home_url('/tweet_subject/?stat=go_tweet'));
    }
}

/* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

/* Request access tokens from twitter */
$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

/* Save the access tokens. Normally these would be saved in a database for future use. */
$_SESSION['access_token'] = $access_token;

/* Remove no longer needed request tokens */
unset($_SESSION['oauth_token']);
unset($_SESSION['oauth_token_secret']);

/* If HTTP response is 200 continue otherwise send to connect page to retry */
if (200 == $connection->http_code) {
    /* The user has been verified and the access tokens can be saved for future use */
    $_SESSION['status'] = 'verified';

    if (!empty($_SESSION['dest']) && ($_SESSION['dest'] == 'map')){
        unset($_SESSION['dest']);
        header('Location: ' . home_url('/subject/') );
        exit;
    }

    header('Location: ' . home_url('/tweet_subject/') );

} else {
    /* Save HTTP status for error dialog on connnect page.*/
//     clear_sessions(home_url('/tweet_connect/'));
    if (!empty($_SESSION['dest']) && ($_SESSION['dest'] == 'map')){
        clear_sessions(home_url('/tweet_subject/?stat=get_token&dest=map'));
    } else {
        clear_sessions(home_url('/tweet_subject/?stat=go_tweet'));
    }

}
