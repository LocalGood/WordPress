<?php
/**
 * Other Definition Editor module
 *
 * @package localgood/omniconfig
 */

/**
 * @param string|bool $display 表示したいオプショングループID
 */
function render_definition_editor( $display = false ) {
	if ( $display ) :

		$form_elements = array(
			'names' => array(
				'lg_config__appName_kana'  => array(
					'id'    => 'appname_kana',
					'label' => 'カタカナ表記',
				),
				'lg_config__appName_kanji' => array(
					'id'    => 'appname_kanji',
					'label' => '漢字表記',
				),
				'lg_config__appName_es'    => array(
					'id'    => 'appname_es',
					'label' => '英語表記（半角小文字）',
				),
			),
			'sns'   => array(
				'lg_config__sns_fb' => array(
					'id'    => 'sns_fb',
					'label' => 'Facebook',
				),
				'lg_config__sns_tw' => array(
					'id'    => 'sns_tw',
					'label' => 'Twitter',
				),
				'lg_config__sns_gp' => array(
					'id'    => 'sns_gp',
					'label' => 'Google+',
				),
			),
			'other' => array(
				'lg_config__earthViewUrl'    => array(
					'id'    => 'ev_url',
					'label' => 'EarthView',
				),
				'lg_config__twHash'          => array(
					'id'    => 'tw_hash',
					'label' => 'Twitetr ハッシュタグ',
				),
				'lg_config__analyticsId'     => array(
					'id'    => 'google_analytics',
					'label' => 'Google Analytics ID',
				),
				'lg_config__integration_url' => array(
					'id'    => 'integration_url',
					'label' => '総合TOP',
				),
				'lg_config__goteo_baseurl'   => array(
					'id'    => 'goteo',
					'label' => 'Goteo',
				),
			),
		);
		?>

		<ul class="definition_setting_tree">
			<?php
			$target_array = $form_elements[ $display ];
			foreach ( $target_array as $key => $elem ) : ?>
				<li>
					<label for="<?php echo $elem['id']; ?>"><?php echo $elem['label']; ?></label>
					<input value="<?php echo get_option( $key ); ?>"
						   id="<?php echo $elem['id']; ?>" name="<?php echo $key; ?>" type="text">
				</li>

			<?php endforeach; ?>

		</ul>
		<?php
	endif;
} // End render_key_editor().
