<?php
/**
 * REST API 関連
 *
 * @package api
 */

add_action( 'rest_api_init', function () {
	register_rest_route( 'api/v1', '/get-search-items/', array(
		'methods'  => 'GET',
		'callback' => 'get_search_items',
	) );
} );

function get_search_items( WP_REST_Request $request ) {
	$form_data = $_GET['input_data'];
	$search_mode = ( isset( $_GET['search_mode'] ) ) ? $_GET['search_mode'] : false;
	require_once( 'event-search-engine.php' );

	$args = false;

	$post_not = array();

	switch ( $search_mode ) {
		case 'event' :

			$default_args = array(
				'posts_per_page' => 9,
				'post_type'      => 'event',
			);

			$extra_args = array();

			$post_not = array();
			$args     = array_merge( $default_args, get_extra_args( $search_mode, $form_data ), array(
				'post__not_in' => $post_not,

			) );

			break;

		case 'place' :

			$default_args = array(
				'post_type' => 'place',
				'nopaging'  => true,
			);
			$args         = array_merge( $default_args, get_extra_args( $search_mode ,$form_data ), array(
				'post__not_in' => $post_not,
			) );
			if ( ! empty( $tax_query_request ) ) {
				$args['tax_query'] = $tax_query_request;
			}
			break;
	} // End switch().

	if ( $args ) {
		$query = new WP_Query( $args );
		return $query->found_posts;
	} else {
		return false;
	}
};
