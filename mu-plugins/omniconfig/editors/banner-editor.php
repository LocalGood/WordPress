<?php
/**
 * Banner Editor module
 *
 * @package localgood/omniconfig
 */

function render_banner_editor() {
	?>

	<section id="bannerSetContainer">
		<p>各バナーを編集する前にかならず設定を保存してください。バナー編集画面に移動すると保存していない設定は消えてしまいます！</p>
		<?php
		$banner_sets = get_posts(
			array(
				'post_type' => 'lg_configset',
				'no_paging' => true,
				'meta_key'  => 'order',
				'orderby'   => 'meta_value_num',
				'order'     => 'ASC',
			)
		);
		foreach ( $banner_sets as $set ) :
			$edit_link = get_edit_post_link( $set->ID );
			?>
			<div class="bannerset_box">
				<p id="bannerset_<?php echo $set->ID; ?>">
					<span class="num"><?php echo get_post_meta( $set->ID, 'order', true ); ?>：</span>
					<a href="<?php echo $edit_link; ?>"><?php echo $set->post_title; ?></a>
				<p class="bannerset_id">（bannerset_id: <span><?php echo $set->post_name; ?></span>）</p>
				</p>
				<p class="del" data-id="<?php echo $set->ID; ?>">[x]</p>
			</div>
		<?php endforeach; ?>
	</section>

	<hr>
	<h4>バナーセットの追加</h4>
	<p>新規バナーセットを登録する場合は以下のフォームを使用します。</p>
	<input type="text" id="addNewBannerSetName" placeholder="新規バナーセット名">
	<button id="addNewBannerSet" class="button button-primary">バナーセットを追加</button>

	<?php
} // End render_banner_editor().


function lgc_get_banners() {
	$render = '';

	$banner_sets = get_posts(
		array(
			'post_type' => 'lg_configset',
			'no_paging' => true,
			'meta_key'  => 'order',
			'orderby'   => 'meta_value_num',
			'order'     => 'ASC',
		)
	);

	$render .= '<dl>';
	foreach ( $banner_sets as $index => $banner_set ) {
		$banner_size      = get_post_meta( $banner_set->ID, 'banner_size', true );
		$banner_array     = get_post_meta( $banner_set->ID, 'banner_image', false );
		$link_array       = get_post_meta( $banner_set->ID, 'link', false );
		$link_label_array = get_post_meta( $banner_set->ID, 'link_label', false );

		// バナーデータの付け合せ
		$banner_data = array();
		foreach ( $link_label_array as $label_index => $label ) {
			array_push( $banner_data, array(
				'banner' => wp_get_attachment_image_src( $banner_array[ $label_index ], $banner_size )[0],
				'link'   => $link_array[ $label_index ],
				'label'  => $link_label_array[ $label_index ],
			) );
		}

		$dd_class = ( 0 === $index ) ? 'index_sec05__management_list' : 'index_sec05__support_list';

		$render .= '<dt class="index_sec05__stitle index_sec05__stitle01 c-title_cmn c-title04">' . $banner_set->post_title . '</dt>';

		$render .= '<dd class="' . $dd_class . '">';

		if ( 0 === $index ) {
			foreach ( $banner_data as $key => $value ) {
				$render .= '<p>' . $value['label'] . '</p>';
				$render .= '<a href="' . $value['link'] . '">';
				if ( isset( $value['banner'] ) ) {
					$render .= '<img src="' . $value['banner'] . '" alt="' . $value['label'] . '">';
				} else {
					$render .= $value['link_label'];
				}
				$render .= '</a>';
			}
		} else {
			$render .= '<ul>';
			foreach ( $banner_data as $key => $value ) {
				$render .= '<li>';
				$render .= '<a href="' . $value['link'] . '" target="_blank">';
				if ( isset( $value['banner'] ) ) {
					$render .= '<img src="' . $value['banner'] . '" alt="' . $value['label'] . '">';
				} else {
					$render .= $value['link_label'];
				}
				$render .= '</a>';
				$render .= '</li>';
			}
			$render .= '</ul>';
		}
		$render .= '</dd>';
	} // End foreach().
	$render .= '</dl>';

	echo $render;
}

function get_footer_under_banners() {
	$render = '';

	$banner_sets = get_posts(
		array(
			'post_type' => 'lg_configset',
			'no_paging' => true,
			'meta_key'  => 'order',
			'orderby'   => 'meta_value_num',
			'order'     => 'ASC',
		)
	);

	$render .= '<ul>';

	foreach ( $banner_sets as $index => $banner_set ) {
		$banner_size      = get_post_meta( $banner_set->ID, 'banner_size', true );
		$banner_array     = get_post_meta( $banner_set->ID, 'banner_image', false );
		$link_array       = get_post_meta( $banner_set->ID, 'link', false );
		$link_label_array = get_post_meta( $banner_set->ID, 'link_label', false );

		// バナーデータの付け合せ
		$banner_data = array();
		foreach ( $link_label_array as $link_index => $label ) {
			array_push( $banner_data, array(
				'banner' => wp_get_attachment_image_src( $banner_array[ $link_index ], 'medium' )[0],
				'link'   => $link_array[ $link_index ],
				'label'  => $link_label_array[ $link_index ],
			) );
		}

		foreach ( $banner_data as $key => $value ) {
			$render .= '<li>';
			$render .= '<a href="' . $value['link'] . '" target="_blank">';
			if ( isset( $value['banner'] ) ) {
				$render .= '<img src="' . $value['banner'] . '" alt="' . $value['label'] . '">';
			} else {
				$render .= $value['link_label'];
			}
			$render .= '</a>';
			$render .= '</li>';
		}
	}

	$render .= '</ul>';

	echo $render;
}


add_action( 'wp_ajax_lgc_add_new_bannerset', '_lgc_add_new_bannerset' );
/**
 * バナー管理用投稿の生成
 */
function _lgc_add_new_bannerset() {
	$new_set_name = $_POST['setName'];

	// 投稿の作成
	$post_data = array(
		'post_title'  => $new_set_name,
		'post_name'   => 'banner_set_' . dechex( time() ),
		'post_status' => 'publish',
		'post_type'   => 'lg_configset',
	);
	$new_pid   = wp_insert_post( $post_data );

	// タームの割当
	wp_set_object_terms( $new_pid, 'sponsor_banners', 'lg_config_type', false );

	// 管理画面のURLを取得
	$edit_link = get_edit_post_link( $new_pid );
	echo $edit_link;
	wp_die();
}


add_action( 'wp_ajax_lgc_remove_configpost', '_lgc_remove_configpost' );
/**
 * 投稿削除関数
 */
function _lgc_remove_configpost() {
	$target_pid = $_POST['target_id'];
	$deleted    = wp_delete_post( $target_pid, true );
	echo $deleted->ID;
	wp_die();
}
