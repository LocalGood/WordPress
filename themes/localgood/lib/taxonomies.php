<?php

// カスタムタクソノミー
function create_custom_taxonomies(){
    $args = array(
        'label' => 'テーマ',
        'labels' => array(
            'name' => 'テーマ',
            'singular_name' => 'テーマ',
            'search_items' => 'テーマを検索',
            'popular_items' => 'よく使われているテーマ',
            'all_items' => 'すべてのテーマ',
            'parent_item' => '親テーマ',
            'edit_item' => 'テーマの編集',
            'update_item' => '更新',
            'add_new_item' => '新規テーマを追加',
            'new_item_name' => '新しいテーマ',
        ),
        'public' => true,
        'show_ui' => true,
        'hierarchical' => true,
    );
    register_taxonomy('project_theme', array('post', 'project', 'data', 'subject', 'event', 'place'), $args);

    $args = array(
        'label' => 'エリア',
        'labels' => array(
            'name' => 'エリア',
            'singular_name' => 'エリア',
            'search_items' => 'エリアを検索',
            'popular_items' => 'よく使われているエリア',
            'all_items' => 'すべてのエリア',
            'parent_item' => '親エリア',
            'edit_item' => 'エリアの編集',
            'update_item' => '更新',
            'add_new_item' => '新規エリアを追加',
            'new_item_name' => '新しいエリア',
        ),
        'public' => true,
        'show_ui' => true,
        'hierarchical' => true,
    );
    register_taxonomy('project_area', array('place','event','post'), $args);

	$args = array(
		'label' => 'スポット',
		'labels' => array(
			'name' => 'スポット',
			'singular_name' => 'スポット',
			'search_items' => 'スポットを検索',
			'popular_items' => 'よく使われているスポット',
			'all_items' => 'すべてのスポット',
			'parent_item' => '親スポット',
			'edit_item' => 'スポットの編集',
			'update_item' => '更新',
			'add_new_item' => '新規スポットを追加',
			'new_item_name' => '新しいスポット',
		),
		'public' => true,
		'show_ui' => true,
		'hierarchical' => true,
	);
	register_taxonomy('project_spot', array('place'), $args);


	$args = array(
        'label' => 'データの種類',
        'labels' => array(
            'name' => 'データの種類',
            'singular_name' => 'データの種類',
            'search_items' => 'データの種類を検索',
            'popular_items' => 'よく使われているデータの種類',
            'all_items' => 'すべてのデータの種類',
            'parent_item' => '親データの種類',
            'edit_item' => 'データの種類の編集',
            'update_item' => '更新',
            'add_new_item' => '新規データの種類を追加',
            'new_item_name' => '新しいデータの種類',
        ),
        'public' => true,
        'show_ui' => true,
        'hierarchical' => true,
    );
    register_taxonomy('data_type', array('data'), $args);

    $args = array(
        'label' => 'イベントの種類',
        'labels' => array(
            'name' => 'イベントの種類',
            'singular_name' => 'イベントの種類',
            'search_items' => 'イベントの種類を検索',
            'popular_items' => 'よく使われているイベントの種類',
            'all_items' => 'すべてのイベントの種類',
            'parent_item' => '親イベントの種類',
            'edit_item' => 'イベントの種類の編集',
            'update_item' => '更新',
            'add_new_item' => '新規イベントの種類を追加',
            'new_item_name' => '新しいイベントの種類',
        ),
        'public' => true,
        'show_ui' => true,
        'hierarchical' => true,
    );
    register_taxonomy('event_type', array('event'), $args);

}
add_action('init', 'create_custom_taxonomies',0);


function get_yokohama_locations()
{
    $_terms = array(
        'city_yokohama' => array('name' => '横浜市', 'lat' => 35.443972, 'long' => 139.63825),
        'naka' => array('name' => '中区', 'lat' => 35.444722, 'long' => 139.642139),
        'hodogaya' => array('name' => '保土ケ谷区', 'lat' => 35.459917, 'long' => 139.596028),
        'minami' => array('name' => '南区', 'lat' => 35.431306, 'long' => 139.608806),
        'totsuka' => array('name' => '戸塚区', 'lat' => 35.396472, 'long' => 139.532333),
        'asahi' => array('name' => '旭区', 'lat' => 35.474667, 'long' => 139.544778),
        'sakae' => array('name' => '栄区', 'lat' => 35.364306, 'long' => 139.554083),
        'izumi' => array('name' => '泉区', 'lat' => 35.417861, 'long' => 139.488722),
        'kohoku' => array('name' => '港北区', 'lat' => 35.519, 'long' => 139.633028),
        'konan' => array('name' => '港南区', 'lat' => 35.400722, 'long' => 139.591222),
        'seya' => array('name' => '瀬谷区', 'lat' => 35.466028, 'long' => 139.498778),
        'isogo' => array('name' => '磯子区', 'lat' => 35.402333, 'long' => 139.618333),
        'kanagawa' => array('name' => '神奈川区', 'lat' => 35.477056, 'long' => 139.629278),
        'midori' => array('name' => '緑区', 'lat' => 35.512361, 'long' => 139.538028),
        'nishi' => array('name' => '西区', 'lat' => 35.453639, 'long' => 139.616917),
        'tsuzuki' => array('name' => '都筑区', 'lat' => 35.544778, 'long' => 139.570722),
        'kanazawa' => array('name' => '金沢区', 'lat' => 35.337278, 'long' => 139.6245),
        'aoba' => array('name' => '青葉区', 'lat' => 35.552778, 'long' => 139.537),
        'tsurumi' => array('name' => '鶴見区', 'lat' => 35.508306, 'long' => 139.682417)
    );
    return $_terms;
}
