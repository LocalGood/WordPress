<?php
/**
 * Color Editor module
 *
 * @package localgood/omniconfig
 */

function render_color_editor() {
	$option_value = get_option( 'lg_config__color_palette', false );

	$form_setting = array(
		'mainCol01' => array(
			'label'   => 'メインカラー1',
			'default' => '#255b7f',
		),
		'mainCol02' => array(
			'label'   => 'メインカラー2',
			'default' => '#009acb',
		),
		'subCol01'  => array(
			'label'   => 'サブカラー1',
			'default' => '#009480',
		),
		'subCol02'  => array(
			'label'   => 'サブカラー2',
			'default' => '#e08e22',
		),
	);

	?>

	<ul class="palette-list">
		<?php foreach ( $form_setting as $slug => $setting ) :
			$value = ( ! empty( $option_value[ $slug ] ) ) ? $option_value[ $slug ] : $setting['default'];
			?>
			<li>
				<label class="palette_label"
					   for="<?php echo $slug; ?>"><?php echo $setting['label']; ?></label>
				<input type="text" value="<?php echo esc_attr( $value ); ?>"
					   id="<?php echo $slug; ?>"
					   name="lg_config__color_palette[<?php echo $slug; ?>]"
					   class="color-picker"></li>
		<?php endforeach; ?>
	</ul>
	<?php
} // End render_color_editor().
