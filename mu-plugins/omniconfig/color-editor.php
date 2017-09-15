<?php
/**
 * Color Editor module
 *
 * @package localgood/omniconfig
 */

function render_color_editor() {
	?>
	<ul class="palette-list">
		<li><label class="palette_label" for="color_1">primary color</label><input type="text"
																				   value="<?php echo get_option( 'lg_config__color_1' ); ?>"
																				   id="color_1"
																				   name="lg_config__color_1"
																				   class="color-picker"></li>
		<li><label class="palette_label" for="color_2">secondary color</label><input type="text"
																					 value="<?php echo get_option( 'lg_config__color_2' ); ?>"
																					 id="color_2"
																					 name="lg_config__color_2"
																					 class="color-picker"></li>
		<li><label class="palette_label" for="color_3">accent color</label><input type="text"
																				  value="<?php echo get_option( 'lg_config__color_3' ); ?>"
																				  id="color_3" name="lg_config__color_3"
																				  class="color-picker"></li>
		<li><label class="palette_label" for="color_4">support color</label><input type="text"
																				   value="<?php echo get_option( 'lg_config__color_4' ); ?>"
																				   id="color_4"
																				   name="lg_config__color_4"
																				   class="color-picker"></li>
		<li><label class="palette_label" for="color_5">link color 1</label><input type="text"
																				  value="<?php echo get_option( 'lg_config__color_5' ); ?>"
																				  id="color_5" name="lg_config__color_5"
																				  class="color-picker"></li>
		<li><label class="palette_label" for="color_6">link color 2</label><input type="text"
																				  value="<?php echo get_option( 'lg_config__color_6' ); ?>"
																				  id="color_6" name="lg_config__color_6"
																				  class="color-picker"></li>
	</ul>
<?php
} // End render_color_editor().
