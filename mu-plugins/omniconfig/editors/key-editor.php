<?php
/**
 * API Key Editor module
 *
 * @package localgood/omniconfig
 */

function render_key_editor() {

	$form_elements = array(
		'lg_config__apikey_googlemap' => array(
			'id'    => 'apikey_googlemap',
			'label' => 'Google Maps JavaScript API (<a href="https://console.cloud.google.com/" target="_blank">取得する</a>)',
		),
		'lg_config__apikey_facebook'  => array(
			'id'    => 'apikey_facebook',
			'label' => 'Facebook APP ID (<a href="https://developers.facebook.com/docs/apps/register/?locale=ja_JP" target="_blank">取得する</a>)',
		),
	);
	?>

	<ul class="api_setting_tree">
		<?php foreach ( $form_elements as $key => $elem ) : ?>
			<li>
				<label for="<?php echo $elem['id']; ?>"><?php echo $elem['label']; ?></label>
				<input value="<?php echo get_option( $key ); ?>"
					   id="<?php echo $elem['id']; ?>" name="<?php echo $key; ?>" type="text">
			</li>

		<?php endforeach; ?>

	</ul>
	<?php
} // End render_key_editor().
