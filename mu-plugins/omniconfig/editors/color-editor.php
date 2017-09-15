<?php
/**
 * Color Editor module
 *
 * @package localgood/omniconfig
 */

function render_color_editor() {
	$option_value = get_option( 'lg_config__color_palette', false );

	$form_setting = array(
		'color1' => '色１',
		'color2' => '色２',
		'color3' => '色３',
		'color4' => '色４',
		'color5' => '色５',
		'color6' => '色６',
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
