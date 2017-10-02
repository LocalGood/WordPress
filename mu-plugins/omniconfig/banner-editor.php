<?php
/**
 * Banner Editor module
 *
 * @package localgood/omniconfig
 */

function render_banner_editor() {
	?>

	<section id="bannerSetContainer">
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
	foreach ( $banner_sets as $banner_set ) {
		echo get_post_meta( $banner_set->ID, 'banner_size', true );
		$render .= '<dt class="index_sec05__stitle index_sec05__stitle01 c-title_cmn c-title04">' . $banner_set->post_title . '</dt>';

		if ( 'large' === get_post_meta( $banner_set->ID, 'banner_size', true ) ) {
			$render .= '<dd>';
		}
		$render .= '';
		$render .= '';
		$render .= '</dd>';

	}
	$render .= '</dl>';
}
