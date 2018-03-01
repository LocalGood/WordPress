<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/wp-blog-header.php';
$post_data = $_POST;

$op_mode = $post_data['action'];

if ( 'comment' === $op_mode ) {

	$time           = current_time( 'mysql' );
	$comment_author = ( isset( $post_data['form_input_name'] ) ) ? $post_data['form_input_name'] : null;
	$comment_body   = ( isset( $post_data['form_input_comment'] ) ) ? $post_data['form_input_comment'] : null;
	$author_ip      = $_SERVER['REMOTE_ADDR'];
	$comment_key    = ( isset( $post_data['comment_key'] ) ) ? $post_data['comment_key'] : null;
	$errors         = 0;
	$error_msg      = false;

	if ( is_null( $comment_body ) ) {
		wp_die( 'コメント本文を入力してください' );
	}

	if ( is_null( $comment_key ) ) {
		wp_die( 'コメントの登録に失敗しました。画面を再読込してからもう一度お試しください。' );
	}


	if ( 0 === $errors ) {
		$comment_id = wp_insert_comment( array(
			'comment_post_ID'      => $post_data['lg_comment_pid'],
			'comment_author'       => $comment_author,
			'comment_author_email' => null,
			'comment_content'      => $comment_body,
			'comment_author_IP'    => $author_ip,
			'comment_agent'        => $_SERVER['HTTP_USER_AGENT'],
			'comment_parent'       => 0,
			'comment_date'         => $time,
			'comment_type'         => '',
		) );


		if ( is_int( $comment_id ) ) {
			add_comment_meta( $comment_id, 'author_ip', $author_ip );
			add_comment_meta( $comment_id, 'author_lgid', $comment_key );
		} else {
			wp_die( 'コメントの登録に失敗しました。画面を再読込してからもう一度お試しください。' );
		}
	}

	$redirect_to = get_permalink( $post_data['lg_comment_pid'] );
	wp_safe_redirect( $redirect_to, 303 );
	exit();
} // End if().
