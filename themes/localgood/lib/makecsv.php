<?php
/**
 * ダウンロード用CSV生成スクリプト
 *
 * @package localgood
 */

/**
 * CSVのパスの設定と取得
 *
 * @param string $file .取得したいCSVファイルの投稿タイプ名（place|event|organizer|base）
 *                        base を指定すると、CSVの設置されたフォルダを返します
 * @param mixed $mode 'url'と指定すると csv ファイルのURLが、それ以外または未指定の場合は csv ファイルのパスを返します
 *
 * @return bool|mixed|string 条件にあった結果を返却します
 */
function lg_get_csv_path( $file, $mode = false ) {
	$destination = array(
		'base'      => ABSPATH . 'csv/',
		'url'       => home_url() . '/csv/',
		'place'     => 'place.csv',
		'event'     => 'event.csv',
		'organizer' => 'organizer.csv',
	);

	if ( ! file_exists( $destination['base'] ) ) {
		if ( ! mkdir( $destination['base'] ) ) {
			return false;
		}
	}

	if ( 'base' === $file ) {
		if ( 'url' === $mode ) {
			return $destination['url'];
		} else {
			return $destination['base'];
		}
	} else {
		if ( 'url' === $mode ) {
			return $destination['url'] . $destination[ $file ];
		} else {
			return $destination['base'] . $destination[ $file ];
		}
	}
}

/**
 * 投稿タイプに応じたCSVを生成します。
 * この関数自体はCSVとして出力するデータを作るだけで、実際の書き出しは _lg_write_csv が行います。
 *
 * @param string $post_type 投稿タイプ名（place|event|organizer）
 *
 * @return bool 成功した場合は true 失敗した場合は false
 */
function lg_make_csv( $post_type ) {
	$csv_base_data = array();

	$config = array(
		'place'     => array(
			'permalink'    => 'LOCAL GOOD掲載URL',
			'title'        => '名称',
			'content'      => '概要',
			'area'         => 'エリア',
			'latitude'     => '地図-緯度',
			'longitude'    => '地図-経度',
			'twitter_url'  => 'Twitter URL',
			'facebook_url' => 'Facebook URL',
			'eyecatch'     => 'アイコン写真',
			'owner'        => '運営者',
			'mail'         => 'メールアドレス',
			'web'          => 'ホームページ',
			'address'      => '住所',
			'tel'          => '電話番号',
			'usage'        => '利用方法',
			'fee'          => '費用',
			'theme'        => 'テーマ',
			'spot'         => 'スポット',
		),
		'event'     => array(
			'permalink'    => 'LOCAL GOOD掲載URL',
			'title'        => '名称（イベントタイトル）',
			'latitude'     => '地図-緯度',
			'longitude'    => '地図-経度',
			'twitter_url'  => 'Twitter URL',
			'facebook_url' => 'Facebook URL',
			'date'         => '開始日時',
			'end_date'     => '終了日時',
			'display_date' => '表示用日時',
			'target'       => '対象',
			'fee'          => '費用',
			'url'          => 'URL',
			'host'         => '開催団体',
			'contact'      => '問い合わせ',
			'place'        => '場所・拠点',
			'organizer'    => '主催者',
			'eyecatch'     => '写真',
			'area'         => 'エリア',
			'theme'        => 'テーマ',
			'type'         => 'イベントの種類',
		),
		'organizer' => array(
			'permalink'    => 'LOCAL GOOD掲載URL',
			'description'  => '概要',
			'web'          => 'ウェブサイト',
			'email'        => 'メールアドレス',
			'twitter_url'  => 'Twitter URL',
			'facebook_url' => 'Facebook URL',
			'eyecatch'     => '写真',
		),
	);

	switch ( $post_type ) {
		case 'place':

			// ラベルをセット
			array_push( $csv_base_data, array_values( $config[ $post_type ] ) );

			$args = array(
				'post_type' => $post_type,
				'nopaging'  => true,
			);

			$posts = get_posts( $args );

			foreach ( $posts as $post ) {
				$single_result = array();

				foreach ( $config[ $post_type ] as $index => $label ) {
					switch ( $index ) {
						case 'permalink':
							$single_result[ $index ] = get_permalink( $post );
							break;

						case 'title':
							$single_result[ $index ] = $post->post_title;
							break;

						case 'content':
							$single_result[ $index ] = $post->post_content;
							break;

						case 'area':
							$terms = wp_get_post_terms( $post->ID, 'project_area' );
							$tmp   = array();
							foreach ( $terms as $term ) {
								$tmp[] = $term->name;
							}
							$single_result[ $index ] = implode( $tmp, '|' );
							break;

						case 'latitude':
							$single_result[ $index ] = get_post_meta( $post->ID, 'place_latitude', true );
							break;

						case 'longitude':
							$single_result[ $index ] = get_post_meta( $post->ID, 'place_longitude', true );
							break;

						case 'twitter_url':
							$meta_value    = get_post_meta( $post->ID, 'place_twitter', true );
							$result_prefix = 'https://twitter.com/';
							if ( ! empty( $meta_value ) ) {
								$single_result[ $index ] = $result_prefix . get_post_meta( $post->ID, 'place_twitter', true );
							} else {
								$single_result[ $index ] = '';
							}
							break;

						case 'facebook_url':
							$single_result[ $index ] = get_post_meta( $post->ID, 'place_facebook', true );
							break;

						case 'eyecatch':
							$single_result[ $index ] = get_the_post_thumbnail_url( $post, 'full' );
							break;

						case 'owner':
							$single_result[ $index ] = get_post_meta( $post->ID, 'place_owner', true );
							break;

						case 'mail':
							$single_result[ $index ] = get_post_meta( $post->ID, 'place_mail', true );
							break;

						case 'web':
							$single_result[ $index ] = get_post_meta( $post->ID, 'place_web', true );
							break;

						case 'address':
							$single_result[ $index ] = get_post_meta( $post->ID, 'place_address', true );
							break;

						case 'tel':
							$single_result[ $index ] = get_post_meta( $post->ID, 'place_tel', true );
							break;

						case 'usage':
							$single_result[ $index ] = get_post_meta( $post->ID, 'place_usage', true );
							break;

						case 'fee':
							$single_result[ $index ] = get_post_meta( $post->ID, 'place_fee', true );
							break;

						case 'theme':
							$terms = wp_get_post_terms( $post->ID, 'project_theme' );
							$tmp   = array();
							foreach ( $terms as $term ) {
								$tmp[] = $term->name;
							}
							$single_result[ $index ] = implode( $tmp, '|' );
							break;

						case 'spot':
							$terms = wp_get_post_terms( $post->ID, 'project_spot' );
							$tmp   = array();
							foreach ( $terms as $term ) {
								$tmp[] = $term->name;
							}
							$single_result[ $index ] = implode( $tmp, '|' );
							break;

					} // End switch().
				} // End foreach().
				array_push( $csv_base_data, array_values( $single_result ) );
			} // End foreach().

			break;
		case 'event':

			// ラベルをセット
			array_push( $csv_base_data, array_values( $config[ $post_type ] ) );

			$args = array(
				'post_type'  => $post_type,
				'nopaging'   => true,
				'meta_key'   => 'event_date',
				'orderby'    => 'meta_value',
				'order'      => 'asc',
			);

			$posts = get_posts( $args );

			foreach ( $posts as $post ) {
				$single_result = array();

				foreach ( $config[ $post_type ] as $index => $label ) {
					switch ( $index ) {
						case 'permalink':
							$single_result[ $index ] = get_permalink( $post );
							break;

						case 'title':
							$single_result[ $index ] = $post->post_title;
							break;

						case 'latitude':
							$single_result[ $index ] = get_post_meta( $post->ID, 'event_latitude', true );
							break;

						case 'longitude':
							$single_result[ $index ] = get_post_meta( $post->ID, 'event_longitude', true );
							break;

						case 'twitter_url':
							$meta_value    = get_post_meta( $post->ID, 'event_twitter', true );
							$result_prefix = 'https://twitter.com/';
							if ( ! empty( $meta_value ) ) {
								$single_result[ $index ] = $result_prefix . get_post_meta( $post->ID, 'event_twitter', true );
							} else {
								$single_result[ $index ] = '';
							}
							break;

						case 'facebook_url':
							$single_result[ $index ] = get_post_meta( $post->ID, 'event_facebook', true );
							break;

						case 'date':
							$single_result[ $index ] = get_post_meta( $post->ID, 'event_date', true );
							break;

						case 'end_date':
							$single_result[ $index ] = get_post_meta( $post->ID, 'event_end_date', true );
							break;

						case 'display_date':
							$single_result[ $index ] = get_post_meta( $post->ID, 'event_display_date', true );
							break;

						case 'target':
							$single_result[ $index ] = get_post_meta( $post->ID, 'event_target', true );
							break;

						case 'fee':
							$single_result[ $index ] = get_post_meta( $post->ID, 'event_fee', true );
							break;

						case 'url':
							$single_result[ $index ] = get_post_meta( $post->ID, 'event_url', true );
							break;

						case 'host':
							$single_result[ $index ] = get_post_meta( $post->ID, 'event_host', true );
							break;

						case 'contact':
							$single_result[ $index ] = get_post_meta( $post->ID, 'event_contact', true );
							break;

						case 'place':
							$place_text = get_post_meta( $post->ID, 'event_place', true );

							if ( empty( $place_text ) ) {
								$place_id = get_post_meta( $post->ID, 'place_id', true );
								if ( ! empty( $place_id ) ) {
									$place_post              = get_post( $place_id );
									$single_result[ $index ] = $place_post->post_title;
								} else {
									$single_result[ $index ] = '';
								}
							} else {
								$single_result[ $index ] = $place_text;
							}

							break;

						case 'organizer':
							$organizer_ids = get_post_meta( $post->ID, 'organizer_id', false );
							foreach ( $organizer_ids as $organizer_id ) {
								if ( ! empty( $organizer_id ) ) {
									$organizer_post          = get_post( $organizer_id );
									$single_result[ $index ] = $organizer_post->post_title;
								} else {
									$single_result[ $index ] = '';
								}
							}
							break;

						case 'eyecatch':
							$single_result[ $index ] = get_the_post_thumbnail_url( $post, 'full' );
							break;

						case 'area':
							$terms = wp_get_post_terms( $post->ID, 'project_area' );
							$tmp   = array();
							foreach ( $terms as $term ) {
								$tmp[] = $term->name;
							}
							$single_result[ $index ] = implode( $tmp, '|' );
							break;

						case 'theme':
							$terms = wp_get_post_terms( $post->ID, 'project_theme' );
							$tmp   = array();
							foreach ( $terms as $term ) {
								$tmp[] = $term->name;
							}
							$single_result[ $index ] = implode( $tmp, '|' );
							break;

						case 'type':
							$terms = wp_get_post_terms( $post->ID, 'event_type' );
							$tmp   = array();
							foreach ( $terms as $term ) {
								$tmp[] = $term->name;
							}
							$single_result[ $index ] = implode( $tmp, '|' );

							break;

					} // End switch().
				} // End foreach().
				array_push( $csv_base_data, array_values( $single_result ) );
			} // End foreach().

			break;
		case 'organizer':

			// ラベルをセット
			array_push( $csv_base_data, array_values( $config[ $post_type ] ) );

			$args = array(
				'post_type' => $post_type,
				'nopaging'  => true,
			);

			$posts = get_posts( $args );

			foreach ( $posts as $post ) {

				$single_result = array();

				foreach ( $config[ $post_type ] as $index => $label ) {
					switch ( $index ) {
						case 'permalink':
							$single_result[ $index ] = get_permalink( $post );
							break;

						case 'title':
							$single_result[ $index ] = $post->post_title;
							break;

						case 'description':
							$single_result[ $index ] = $post->post_content;
							break;

						case 'web':
							$single_result[ $index ] = get_post_meta( $post->ID, 'organizer_url', true );
							break;

						case 'email':
							$single_result[ $index ] = get_post_meta( $post->ID, 'organizer_email', true );
							break;

						case 'twitter_url':
							$meta_value    = get_post_meta( $post->ID, 'organizer_twitter', true );
							$result_prefix = 'https://twitter.com/';
							if ( ! empty( $meta_value ) ) {
								$single_result[ $index ] = $result_prefix . get_post_meta( $post->ID, 'organizer_twitter', true );
							} else {
								$single_result[ $index ] = '';
							}
							break;

						case 'facebook_url':
							$single_result[ $index ] = get_post_meta( $post->ID, 'organizer_facebook', true );
							break;

						case 'eyecatch':
							$single_result[ $index ] = get_the_post_thumbnail_url( $post, 'full' );
							break;

					} // End switch().
				} // End foreach().
				array_push( $csv_base_data, array_values( $single_result ) );
			} // End foreach().
			break;
	} // End switch().

	return _lg_write_csv( $csv_base_data, $config['destination']['base'] . lg_get_csv_path( $post_type ) );
}

/**
 * 与えられたデータをもとにCSVファイルを生成します。
 * CSVを格納するフォルダは事前に準備してあり、適切なパーミッションが設定されているいつようがあります。
 *
 * @param array $data CSVに保存したいデータの入った配列
 * @param string $destination ファイルの保存先（フルパス）
 *
 * @return bool 成功すると true 失敗すると false
 */
function _lg_write_csv( $data, $destination ) {

	if ( $destination ) {
		$file_pointer = fopen( $destination, 'w' );
		if ( $file_pointer ) {
			foreach ( $data as $fields ) {
				fputcsv( $file_pointer, $fields );
			}

			fclose( $file_pointer );

			return true;
		} else {
			echo 'ファイルの作成に失敗';

			return false;
		}
	} else {
		return false;
	}
}

// 開発時に即実行させたいなどの理由で次回の WP Cron スケジュールを削除するには以下をコメント解除してリロード。
// ただしそのままだと次の予定を消し続け、いつまでもスケジュールされなくなるのでリロード後にまたコメントアウトしておくこと
//wp_unschedule_event( wp_next_scheduled( 'lg_csv_update' ),'lg_csv_update' );


// WP Cron に登録
if ( ! wp_next_scheduled( 'lg_csv_update' ) ) {
	wp_schedule_event( time(), 'daily', 'lg_csv_update' );
}

//echo date( 'y-m-d H:i:s' );
//echo '<br>';
//echo date( 'y-m-d H:i:s', wp_next_scheduled( 'lg_csv_update' ) );

// WP Cron が実行する関数
add_action( 'lg_csv_update', function () {
	$update_csv['place']     = lg_make_csv( 'place' );
	$update_csv['event']     = lg_make_csv( 'event' );
	$update_csv['organizer'] = lg_make_csv( 'organizer' );

//	foreach ( $update_csv as $type => $result ) {
//		$msg = ( $result ) ? $type . '.csv update successfully.' : $type . '.csv update failed.';
//		error_log( $msg );
//	}
} );
