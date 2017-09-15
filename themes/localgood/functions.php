<?php

require_once locate_template('/lib/init.php');        // 初期設定の関数
require_once locate_template('/lib/scripts.php');     // CSSやJavascript関連の関数
require_once locate_template('/lib/posts.php');       // 投稿, 投稿タイプカスタマイズ
require_once locate_template('/lib/taxonomies.php');  // タクソノミー関連カスタマイズ
require_once locate_template('/lib/paging.php');      // ページング, ページャー
require_once locate_template('/lib/breadcrumbs.php'); // パンくずリストの関数
require_once locate_template('/lib/template.php');      // テンプレート関数
require_once locate_template('/lib/custom.php');      // その他カスタマイズの関数
require_once locate_template('/lib/twitteroauth/twitteroauth.php');      // twitter連携用
require_once locate_template('/lib/twitter.php');      // twitter連携用
require_once locate_template('/lib/kml.php');      // google earth連携用
require_once locate_template('/lib/goteo.php');      // goteo連携用
require_once locate_template('/lib/restapi.php');      // カスタムREST API関連
require_once locate_template('/lib/makecsv.php');      // CSV生成用
