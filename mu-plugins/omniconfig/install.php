<?php
add_action( 'init', 'lg_add_config_cpt' );
/**
 * 管理用投稿タイプの登録
 */
function lg_add_config_cpt() {
	register_post_type(
		'lg_configset',
		array(
			'labels'              => array(
				'name' => 'setting',
			),
			'public'              => true,
			'show_in_nav_menus'   => false,
			'show_in_menu'        => false,
			'capability_type'     => 'post',
			'hierarchical'        => false,
			'taxonomies'          => array( 'lg_config_type' ),
			'has_archive'         => false,
			'exclude_from_search' => true,
		)
	);
}

add_action( 'init', 'lg_add_config_tax' );
/**
 * 管理用タクソノミーの登録
 */

function lg_add_config_tax() {
	register_taxonomy(
		'lg_config_type',
		'lg_configset',
		array(
			'public'             => true,
			'show_in_nav_menus'  => false,
			'show_in_quick_edit' => false,
			'hierarchical'       => true,
			'labels'             => array(
				'name' => 'config category',
			),
		)
	);
}


$lg_config_taxonomy_terms = array(
	array(
		'term'      => 'sponsor_banners',
		'taxonomy'  => 'lg_config_type',
		'arguments' => array(
			'slug' => 'sponsor_banners',
		),
	),
);

foreach ( $lg_config_taxonomy_terms as $term ) {
	wp_insert_term( $term['term'], $term['taxonomy'], $term['arguments'] );
}

// omniconfig用 query_vars の登録
add_filter( 'query_vars', function ( $vars ) {
	$vars[] = 'action';

	return $vars;
} );
