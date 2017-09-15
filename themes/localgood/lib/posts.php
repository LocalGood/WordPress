<?php
// カットオーバーまで機能隠蔽
// オーサー機能リリース（2015/12/08）
//function is_cutover(){
//    return time() >= strtotime("2015/12/18 3:00");
//}
add_post_type_support( 'page', 'excerpt' );
add_post_type_support( 'post', 'excerpt' );

// pre_get_posts
function change_loop_condition( $query )
{

    if (is_admin() || ! $query->is_main_query()) {
        return;
    }
    // HOME
    if (is_home()) {
    }

    if (is_post_type_archive( 'data' )) {
        $query->set( 'posts_per_page', 15 );
    }

    if (is_post_type_archive( 'skills' )) {
        $query->set( 'posts_per_page', - 1 );
        $query->set( 'post_type', 'skills' );
    }

    if (is_category() || is_author()) {
        $query->set( 'posts_per_page', 15 );
    }

    if (is_tax( 'data_type' )) {
        $query->set( 'post_type', 'data' );
    }

    if (is_post_type_archive( 'event' ) ) {
        $query->set( 'posts_per_page', 9 );
        $query->set( 'orderby', 'modified' );
        $query->set( 'order',  'asc');
    }

    if (is_post_type_archive( 'subject' )) {
        $query->set( 'post_type', array( 'tweet', 'subject' ) );
        $query->set( 'posts_per_page', 18 );
        if (isset( $_GET['theme'] ) && is_array( $_GET['theme'] )) {
            $query->set( 'tax_query', array(
                    array(
                        'taxonomy' => 'project_theme',
                        'terms'    => $_GET['theme'],
                        'field'    => 'slug',
                        'operator' => 'IN'
                    )
                )
            );
        }
    }

}

add_action( 'pre_get_posts', 'change_loop_condition' );


// Project投稿タイプ（カスタム投稿タイプ）
function create_localgood_type()
{
    $args = array(
        'label'               => 'イベント',
        'labels'              => array(
            'singular_name'      => 'イベント',
            'add_new_item'       => '新しいイベントを作成',
            'add_new'            => '新規追加',
            'new_item'           => '新しいイベント',
            'edit_item'          => 'イベントを編集',
            'view_item'          => 'イベントを表示',
            'not_found'          => 'イベントは見つかりませんでした',
            'not_found_in_trash' => 'ゴミ箱にイベントはありません。',
            'search_items'       => 'イベントを検索',
        ),
        'public'              => true,
        'show_ui'             => true,
        'query_var'           => true,
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'menu_position'       => 5,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'taxonomies'          => array( 'event_type', 'tax_event_tag' ),
        'supports'            => array( 'title', 'thumbnail', 'editor', 'revisions' )
    );
    register_post_type( 'event', $args );

    $args = array(
        'label'               => 'データ',
        'labels'              => array(
            'singular_name'      => 'データ',
            'add_new_item'       => '新しいデータを作成',
            'add_new'            => '新規追加',
            'new_item'           => '新しいデータ',
            'edit_item'          => 'データを編集',
            'view_item'          => 'データを表示',
            'not_found'          => 'データは見つかりませんでした',
            'not_found_in_trash' => 'ゴミ箱にデータはありません。',
            'search_items'       => 'データを検索',
        ),
        'public'              => true,
        'show_ui'             => true,
        'query_var'           => true,
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'menu_position'       => 5,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'taxonomies'          => array( 'data_type' ),
        'supports'            => array( 'title', 'thumbnail', 'editor', 'revisions', 'excerpt' )
    );
    register_post_type( 'data', $args );

    $args = array(
        'label'               => '課題',
        'labels'              => array(
            'singular_name'      => '課題',
            'add_new_item'       => '新しい課題を作成',
            'add_new'            => '新規追加',
            'new_item'           => '新しい課題',
            'edit_item'          => '課題を編集',
            'view_item'          => '課題を表示',
            'not_found'          => '課題は見つかりませんでした',
            'not_found_in_trash' => 'ゴミ箱に課題はありません。',
            'search_items'       => '課題を検索',
        ),
        'public'              => true,
        'show_ui'             => true,
        'query_var'           => true,
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'menu_position'       => 5,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'taxonomies'          => array( 'project_area' ),
        'supports'            => array( 'title', 'thumbnail', 'editor', 'revisions', 'custom-fields', 'excerpt' )
    );
    register_post_type( 'subject', $args );

    $args = array(
        'label'               => 'スキル',
        'labels'              => array(
            'singular_name'      => 'スキル',
            'add_new_item'       => '新しいスキルを作成',
            'add_new'            => '新規追加',
            'new_item'           => '新しいスキル',
            'edit_item'          => 'スキルを編集',
            'view_item'          => 'スキルを表示',
            'not_found'          => 'スキルは見つかりませんでした',
            'not_found_in_trash' => 'ゴミ箱にスキルはありません。',
            'search_items'       => 'スキルを検索',
        ),
        'public'              => true,
        'show_ui'             => true,
        'query_var'           => true,
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'menu_position'       => 5,
        'has_archive'         => true,
        'exclude_from_search' => false,
//        'taxonomies' => array('data_type'),
        'supports'            => array( 'title', 'editor', 'revisions', 'excerpt' )
    );
    register_post_type( 'skills', $args );

    $args = array(
        'label'               => 'みんなの声',
        'labels'              => array(
            'singular_name'      => 'みんなの声ツイート',
            'add_new_item'       => '新しいみんなの声ツイートを作成',
            'add_new'            => '新規追加',
            'new_item'           => '新しいみんなの声ツイート',
            'edit_item'          => 'みんなの声ツイートを編集',
            'view_item'          => 'みんなの声ツイートを表示',
            'not_found'          => 'みんなの声ツイートは見つかりませんでした',
            'not_found_in_trash' => 'ゴミ箱にみんなの声ツイートはありません。',
            'search_items'       => 'みんなの声ツイートを検索',
        ),
        'public'              => true,
        'show_ui'             => true,
        'query_var'           => 'twid',
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'menu_position'       => 5,
        'has_archive'         => true,
        'exclude_from_search' => false,
//        'taxonomies' => array('data_type'),
        'supports'            => array( 'title', 'editor', 'revisions', 'custom-fields', 'thumbnail', 'excerpt' )
    );
    register_post_type( 'tweet', $args );


	$args = array(
		'label'               => 'みんなの拠点',
		'labels'              => array(
			'singular_name'      => '拠点',
			'add_new_item'       => '新しい拠点を作成',
			'add_new'            => '新規追加',
			'new_item'           => '新しい拠点',
			'edit_item'          => '拠点を編集',
			'view_item'          => '拠点を表示',
			'not_found'          => '拠点は見つかりませんでした',
			'not_found_in_trash' => 'ゴミ箱に拠点はありません。',
			'search_items'       => '拠点を検索',
		),
		'public'              => true,
		'show_ui'             => true,
		'query_var'           => true,
		'capability_type'     => 'post',
		'hierarchical'        => false,
		'menu_position'       => 5,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'taxonomies'          => array( 'project_area' ),
		'supports'            => array( 'title', 'thumbnail', 'editor', 'revisions' )
	);
	register_post_type( 'place', $args );

	$args = array(
		'label'               => '主催者',
		'labels'              => array(
			'singular_name'      => '主催者',
			'add_new_item'       => '新しい主催者を作成',
			'add_new'            => '新規追加',
			'new_item'           => '新しい主催者',
			'edit_item'          => '主催者を編集',
			'view_item'          => '主催者を表示',
			'not_found'          => '主催者は見つかりませんでした',
			'not_found_in_trash' => 'ゴミ箱に主催者はありません。',
			'search_items'       => '主催者を検索',
		),
		'public'              => true,
		'show_ui'             => true,
		'query_var'           => true,
		'capability_type'     => 'post',
		'hierarchical'        => false,
		'menu_position'       => 5,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'taxonomies'          => array( 'event_type' ),
		'supports'            => array( 'title', 'thumbnail', 'editor', 'revisions' )
	);
	register_post_type( 'organizer', $args );

}

add_action( 'init', 'create_localgood_type', 0 );

//
//  カスタム投稿タイプのパーマリンクをpost_idに
//
add_action( 'init', 'myposttype_rewrite' );
function myposttype_rewrite()
{
    global $wp_rewrite;

    $queryarg = 'post_type=data&p=';
    $wp_rewrite->add_rewrite_tag( '%data_id%', '([^/]+)', $queryarg );
    $wp_rewrite->add_permastruct( 'data', '/data/%data_id%', false );

    $queryarg = 'post_type=subject&p=';
    $wp_rewrite->add_rewrite_tag( '%subject_id%', '([^/]+)', $queryarg );
    $wp_rewrite->add_permastruct( 'subject', '/subject/%subject_id%', false );

    $queryarg = 'post_type=tweet&p=';
    $wp_rewrite->add_rewrite_tag( '%tweet_id%', '([^/]+)', $queryarg );
    $wp_rewrite->add_permastruct( 'tweet', '/tweet/%tweet_id%', false );

    $queryarg = 'post_type=skills&p=';
    $wp_rewrite->add_rewrite_tag( '%skills_id%', '([^/]+)', $queryarg );
    $wp_rewrite->add_permastruct( 'skills', '/skills/%skills_id%', false );

    $queryarg = 'post_type=event&p=';
    $wp_rewrite->add_rewrite_tag( '%event_id%', '([^/]+)', $queryarg );
    $wp_rewrite->add_permastruct( 'event', '/event/%event_id%', false );

	$queryarg = 'post_type=place&p=';
	$wp_rewrite->add_rewrite_tag( '%place_id%', '([^/]+)', $queryarg );
	$wp_rewrite->add_permastruct( 'place', '/place/%place_id%', false );

	$queryarg = 'post_type=organizer&p=';
	$wp_rewrite->add_rewrite_tag( '%organizer_id%', '([^/]+)', $queryarg );
	$wp_rewrite->add_permastruct( 'organizer', '/organizer/%organizer_id%', false );
}

add_filter( 'post_type_link', 'myposttype_permalink', 1, 3 );
function myposttype_permalink( $post_link, $id = 0, $leavename )
{
    global $wp_rewrite;
    $post = get_post( $id );
    if (is_wp_error( $post )) {
        return $post;
    }

    $newlink = $wp_rewrite->get_extra_permastruct( $post->post_type );

//    if ($post->post_type == 'area_info' && !empty($post->post_name)){
//        $newlink = str_replace("%" . $post->post_type . "_id%", $post->post_name, $newlink);
//    } else {
    $newlink = str_replace( "%" . $post->post_type . "_id%", $post->ID, $newlink );
//    }

    $newlink = home_url( user_trailingslashit( $newlink ) );

    return $newlink;
}

function get_event_args($search_mode = false, $post_not = array()){
	global $paged;
	$default_args = array(
		'post_type'      => 'event',
		'orderby' => 'modified',
		'post__not_in' => $post_not,
		'paged'          => $paged,
		'posts_per_page' => 9,
	);
	if ( ! $search_mode ) {
		$default_args['meta_query'] = array(
			array(
				'key'     => 'event_end_date',
				'value'   => date( 'Y-m-d' ),
				'compare' => '>=',
				'type'    => 'DATE',
			)
		);
	}
	$args = array_merge( $default_args, get_extra_args( $search_mode ) );
	if ( $search_mode !== 'event' ) {
		$args     = array_merge( $args, array(
			'post__not_in' => array(),
		) );
	}
	return $args;
}


function get_place_args($search_mode = false, $post_not = array()){
	$default_args = array(
		'post_type' => 'place',
		'orderby' => 'modified',
		'post__not_in' => $post_not,
		'nopaging'  => true,
	);
	$args = array_merge( $default_args, get_extra_args( $search_mode ) );
	if ( $search_mode !== 'place' ) {
		$args     = array_merge( $args, array(
			'post__not_in' => array(),
		) );
	}
	return $args;
}
