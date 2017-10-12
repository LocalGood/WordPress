<?php
// curlでgoteoにAPI投げる関数
function request_api_curl($_url, $_params = array(), $_obj_out = true){

    if ( !is_array($_params) )
        return false;

    if (!empty($_params)) {
        $ch = curl_init($_url . '?' . http_build_query($_params));
    } else {
        $ch = curl_init($_url);
    }

    $curl_opt = array();
    $curl_opt[CURLOPT_RETURNTRANSFER] = true;

    // テスト環境ではBASIC認証通す
    if(strpos($_SERVER['SERVER_NAME'], 'il3c') > 0) {
        $curl_opt[CURLOPT_USERPWD] = 'goteo:XH5DpX3Ttaca';
    }

    curl_setopt_array($ch, $curl_opt);

    $_result = curl_exec($ch);
    curl_close($ch);

    if ($_obj_out){

        // JSON妥当性チェック
        $_string = json_decode($_result);
        if (json_last_error() == JSON_ERROR_NONE) {
            $_result = $_string;
        };

    }
    return $_result;
}

// スキルからプロジェクト検索
function get_projects_by_skill($_skillid = ''){
    $_url = get_option( 'lg_config__goteo_baseurl', false ) . '/json/get_projects_by_skill';
    $_params = array(
        'skillid' => $_skillid
    );
    return request_api_curl($_url, $_params);
}

// スキルからユーザー検索
function get_user_by_skill($_skillid) {
    $_url = get_option( 'lg_config__goteo_baseurl', false ) . '/json/get_users';
    $_params = array (
        'skillid' => $_skillid
    );
    return request_api_curl($_url, $_params);
}

// スキルIDから子スキル取得
function get_children_skill($_skillid){
    $_url = get_option( 'lg_config__goteo_baseurl', false ) . '/json/get_children';
    $_params = array (
        'parentid' => $_skillid
    );
    return request_api_curl($_url, $_params);
}

// スキルIDからスキル詳細取得
function get_skill_info($_skillid){
    $_url = get_option( 'lg_config__goteo_baseurl', false ) . '/json/get_skill';
    $_params = array (
        'skillid' => $_skillid
    );
    return request_api_curl($_url, $_params);
}

// ユーザーIDからユーザー詳細取得
function get_user_info($_userid){
    $_url = get_option( 'lg_config__goteo_baseurl', false ) . '/json/get_user';
    $_params = array (
        'id' => $_userid
    );
    return request_api_curl($_url, $_params);
}

function get_user_avatar($_userid, $_size = 80){
    $_url = get_option( 'lg_config__goteo_baseurl', false ) . '/json/get_user_avatar';
    $_params = array (
        'id' => $_userid,
        'size' => $_size
    );
    return request_api_curl($_url, $_params);
}

function get_pickup_projects(){
    $_url = get_option( 'lg_config__goteo_baseurl', false ) . '/json/get_pickup_projects';
    return request_api_curl($_url);
}
