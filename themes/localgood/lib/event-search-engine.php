<?php

function get_extra_args( $search_mode, $input = false ) {
	$form_input         = ( $input ) ? $input : $_GET;
	$tax_query_request  = array();
	$meta_query_request = array();
	$extra_args         = array();

	switch ( $search_mode ) {
		// イベント検索
		case 'event':

			$extra_args = array(
				'meta_key' => 'event_date',
				'orderby'  => 'meta_value',
				'order'    => 'asc',
			);

			/*
			* GETで絞り込みリクエストがきたら、フィルタ用クエリを生成
			*/
			// エリア
			if ( ! empty( $form_input['area'] ) ) {
				$tax_query_area = array(
					'taxonomy' => 'project_area',
					'field'    => 'slug',
					'terms'    => $form_input['area'],
					'operator' => 'IN',
				);
				array_push( $tax_query_request, $tax_query_area );
			}

			// カテゴリー（event_type）
			if ( ! empty( $form_input['category'] ) ) {
				$tax_query_category = array(
					'taxonomy' => 'event_type',
					'field'    => 'slug',
					'terms'    => $form_input['category'],
					'operator' => 'IN',
				);
				array_push( $tax_query_request, $tax_query_category );
			}

			// テーマ
			if ( ! empty( $form_input['event_theme'] ) ) {
				$tax_query_category = array(
					'taxonomy' => 'project_theme',
					'field'    => 'slug',
					'terms'    => $form_input['event_theme'],
					'operator' => 'IN',
				);
				array_push( $tax_query_request, $tax_query_category );
			}

			// 期間フィルタ
			if ( empty( $form_input['period'] ) ) {
				if ( ! empty( $form_input['since'] ) ) {
					array_push( $meta_query_request, array(
						'key'     => 'event_end_date',
						'value'   => $form_input['since'],
						'compare' => '>=',
						'type'    => 'DATE',
					) );
				}

				if ( ! empty( $form_input['until'] ) ) {
					array_push( $meta_query_request, array(
						'key'     => 'event_date',
						'value'   => $form_input['until'],
						'compare' => '<=',
						'type'    => 'DATE',
					) );
				}
			}

			break;

		// 居場所検索
		case 'place':

			/*
			* GETで絞り込みリクエストがきたら、フィルタ用クエリを生成
			*/
			// エリア
			$tax_query_area = array();
			if ( ! empty( $form_input['area'] ) ) {
				$tax_query_area = array(
					'taxonomy' => 'project_area',
					'field'    => 'slug',
					'terms'    => $form_input['area'],
					'operator' => 'IN',
				);
				array_push( $tax_query_request, $tax_query_area );
			}

			// SPOT
			$tax_query_spot = array();
			if ( ! empty( $form_input['spot'] ) ) {
				$tax_query_spot = array(
					'taxonomy' => 'project_spot',
					'field'    => 'slug',
					'terms'    => $form_input['spot'],
					'operator' => 'IN',
				);
				array_push( $tax_query_request, $tax_query_spot );
			}

			// テーマ
			if ( ! empty( $form_input['place_theme'] ) ) {
				$tax_query_category = array(
					'taxonomy' => 'project_theme',
					'field'    => 'slug',
					'terms'    => $form_input['place_theme'],
					'operator' => 'IN',
				);
				array_push( $tax_query_request, $tax_query_category );
			}

			break;
	} // End switch().

	// フリーワード検索
	if ( ! empty( $form_input['keyword'] ) ) {
		$extra_args = array(
			's' => $form_input['keyword'],
		);
	}

	// tax_query の条件が2つ以上になる場合は relation を追加
	if ( count( $tax_query_request ) > 1 ) {
		$tax_query_request['relation'] = 'AND';
	}

	// meta_query の条件が２つ以上になる場合は relation を追加
	if ( count( $meta_query_request ) > 1 ) {
		$meta_query_request['relation'] = 'AND';
	}


	if ( ! empty( $tax_query_request ) ) {
		$extra_args['tax_query'] = $tax_query_request;
	}

	if ( ! empty( $meta_query_request ) ) {
		$extra_args['meta_query'] = $meta_query_request;
	}

	return $extra_args;
}
