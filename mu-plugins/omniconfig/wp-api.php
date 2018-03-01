<?php
/**
 * WP API Settings
 * @package localgood/omniconfig
 */


// Add routing
add_action( 'rest_api_init', function () {
	register_rest_route( 'lg-like/v1', 'likeit', array(
		'method'   => 'GET',
		'callback' => '_do_lg_like_action',
	) );
} );


function _do_lg_like_action( $request ) {
	$params      = $request->get_params();
	$target_id   = $params['postId'];
	$action_mode = $params['mode'];
	$check_key   = $params['key'];
	$result      = array();


	// リクエストが正当なものかをチェック
	$_chk_target = substr( md5( substr( $target_id, - 1 ) ), 0, 8 );
	if ( $_chk_target !== $check_key ) {
		$result['status'] = 'error';
		$result['msg']    = 'Key was not match';

		return $result;
	}

	$current_cnt = get_post_meta( $target_id, '_lg_like_cnt', true );

	switch ( $action_mode ) {
		case 'add':
			$new_cnt = $current_cnt + 1;
			break;

		case 'put':
			$new_cnt = ( $current_cnt - 1 <= 0 ) ? 0 : $current_cnt - 1;
			break;

		default:
			$result['status'] = 'error';
			$result['msg']    = 'Mode is illegal';

			return $result;
			break;
	}

	if ( ! update_post_meta( $target_id, '_lg_like_cnt', $new_cnt ) ) {
		$result['status'] = 'error';
		$result['msg']    = 'Like value save failed.';

		return $result;
	}

	$result['status'] = 'success';

	return $result;
}
