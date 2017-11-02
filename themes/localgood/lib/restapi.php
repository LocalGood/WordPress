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
	register_rest_route( 'api/v1', '/apikeys/', array(
		'methods'  => 'GET',
		'callback' => 'get_apikeys',
	) );
	register_rest_route( 'api/v1', '/get-subjects/', array(
		'methods'  => 'GET',
		'callback' => 'get_subjects',
	) );

} );

function get_apikeys( WP_REST_Request $request ) {
	$json = json_decode( file_get_contents( 'omniconfig/apikeys.json' ) );

	return $json;
};

function get_search_items( WP_REST_Request $request ) {
	$form_data   = $_GET['input_data'];
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
			$args         = array_merge( $default_args, get_extra_args( $search_mode, $form_data ), array(
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

function get_subjects( WP_REST_Request $request ) {
	$return_array = array();
	$subjects     = new WP_Query( array(
		'post_type' => array( 'subject', 'tweet' ),
		'nopaging'  => true,
	) );

	if ( $subjects->have_posts() ) {
		while ( $subjects->have_posts() ) {
			$subjects->the_post();

			$_tmp    = array();
			$_meta   = get_post_custom( $subjects->post->ID );
			$_latlng = array( 0, 0 );

			switch ( $subjects->post->post_type ) {
				case 'subject':
					if ( ! empty( $_meta['sbLatLng'] ) && ( strpos( $_meta['sbLatLng'][0], ',' ) > 0 ) ) {
						$_latlng = explode( ',', $_meta['sbLatLng'][0] );
					}
					$_content = wpautop( $subjects->post->post_content );
					$_thumb   = get_the_post_thumbnail( $subjects->post->ID, 'archive-thumbnails' );
					$_id      = $subjects->post->post_type;
					break;

				case 'tweet':
					if ( ! empty( $_meta['twLatLng'] ) && ( strpos( $_meta['twLatLng'][0], ',' ) > 0 ) ) {
						$_latlng = explode( ',', $_meta['twLatLng'][0] );
					}
					$_content = wpautop( $subjects->post->post_content );
					$_thumb   = get_the_post_thumbnail( $subjects->post->ID, 'archive-thumbnails' );
					$_id      = $subjects->post->post_type;

					break;
				default:
					$_content = '';
					$_id = '';
					$_thumb  = '';

					break;
			}

			if ( ( $_latlng[0] === 0 || $_latlng[1] === 0 ) && ! empty( $_meta['lgLatitude'] ) && ! empty( $_meta['lgLongitude'] ) ) {
				$_latlng = array($_meta['lgLatitude'], $_meta['lgLongitude']);
			}

			$_tmp = array();
			array_push( $return_array, array(
				$subjects->post->post_title,
				get_permalink( $subjects->post ),
				$_content,
				$_thumb,
				$_latlng[0],
				$_latlng[1],
				$_id,
			) );
		} // End while().
	} // End if().
	wp_reset_postdata();

	return $return_array;
};
