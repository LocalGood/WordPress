<?php
/*
 * Pagination unit.
 *
 * @package library
 */

/**
 * 拡張ページ送り関数
 *
 * @param mixed $query WP_Query Object を指定すると、そのクエリをもとにページャーを生成。未指定なら global から取得。
 * @param array $options 追加オプション配列。
 *
 * $options パラメータ詳細
 * 		現在受け取ることができるのは以下の通りです。いずれも paginate_links の対応するオプションを上書きします。
 * 			paginate_base		paginate_links の base を上書きします
 * 			paginate_format		paginate_links の format を上書きします
 * 			current				paginate_links の current を上書きします
 *
 * 		(example)
 * 			$options = array(
 * 				'paginate_base'   => get_permalink($post->ID) . '%_%',
 * 				'paginate_format' => '?my_paged=%#%',
 * 				'current'         => get_query_var('my_paged',1),
 * 			);
 * 		このように指定すると、ページ送りリンクは ?paged=n の代わりに $my_paged=n というパラメータをつけるようになります。
 */
function paging( $query = false, $options = array() ) {
	global $wp_rewrite, $wp_query, $paged;
	if ( ! $query ) {
		$query = $wp_query;
	}

	$paginate_base = get_pagenum_link( 1 );
	if ( strpos( $paginate_base, '?' ) || ! $wp_rewrite->using_permalinks() ) {
		$paginate_format = '';
		$paginate_base   = add_query_arg( 'paged', '%#%' );
	} else {
		$paginate_format = ( substr( $paginate_base, - 1, 1 ) == '/' ? '' : '/' ) .
						   user_trailingslashit( 'page/%#%/', 'paged' );
		$paginate_base   .= '%_%';
	}

	// $options に設定があれば上書き
	if ( isset( $options['paginate_format'] ) ) {
		$paginate_format = $options['paginate_format'];
	}
	if ( isset( $options['paginate_base'] ) ) {
		$paginate_base = $options['paginate_base'];
	}

	if ( isset( $options['current'] ) ) {
		$current_page = $options['current'];
	} elseif ( $paged ) {
		$current_page = $paged;
	} else {
		$current_page = 1;
	}

	// render pagination
	echo '<div class="tablenav">';
	$pagenate_links_cfg_base = array(
		'base'      => $paginate_base,
		'format'    => $paginate_format,
		'total'     => $query->max_num_pages,
		'current'   => $current_page,
		'prev_text' => '&lt;',
		'next_text' => '&gt;',
	);
	if ( DEVICE == 'pc' ) {
		echo paginate_links( array_merge( $pagenate_links_cfg_base, array(
			'mid_size' => ( isset( $options['mid_size'] ) ) ? isset( $options['mid_size'] ) : 5,
		) ) );
	} else {
		echo paginate_links( array_merge( $pagenate_links_cfg_base, array(
			'mid_size' => ( isset( $options['mid_size'] ) ) ? isset( $options['mid_size'] ) : 2,
		) ) );
	}
	echo '</div>';
}
