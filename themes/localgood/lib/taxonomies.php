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
