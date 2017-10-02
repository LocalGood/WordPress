<?php
/**
 * Color Editor module
 *
 * @package localgood/omniconfig
 */

function render_color_editor() {
	$option_value = get_option( 'lg_config__color_palette', false );

	$form_setting = array(
		'mainCol01' => 'メインカラー1',
		'mainCol02' => 'メインカラー2',
		'subCol01' => 'サブカラー1',
		'subCol02' => 'サブカラー2',
	);

	?>

	<ul class="palette-list">
		<?php foreach ( $form_setting as $slug => $label ) : ?>
			<li>
				<label class="palette_label"
					   for="<?php echo $slug; ?>"><?php echo $label; ?></label>
				<input type="text" value="<?php echo $option_value[ $slug ]; ?>"
					   id="<?php echo $slug; ?>"
					   name="lg_config__color_palette[<?php echo $slug; ?>]"
					   class="color-picker"></li>
		<?php endforeach; ?>
	</ul>
	<?php
} // End render_color_editor().
