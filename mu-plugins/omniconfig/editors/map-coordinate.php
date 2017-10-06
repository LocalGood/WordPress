<?php
/**
 * Map Coordinate Editor module
 *
 * @package localgood/omniconfig
 */

function render_map_coordinate_editor() {


	$form_elements = array(
		'lg_config__coordinate_longitude' => array(
			'id'    => 'coordinate_longitude',
			'label' => '経度',
		),
		'lg_config__coordinate_latitude'  => array(
			'id'    => 'coordinate_latitude',
			'label' => '緯度',
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
} // End render_map_coordinate_editor().
