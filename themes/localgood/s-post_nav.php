<?php
global $post;
if ( is_page( 'lgplayer' ) || is_post_type_archive( 'data' ) || is_post_type_archive() || is_page( 'lgnews' ) ): ?>
	<ul class="underlayer_link_list">
		<li <?php if ( is_page( 'lgnews' ) ) : ?>class="active"<?php endif; ?>>
			<a href="/lgnews/">
				<img
					src="<?php bloginfo( 'template_directory' ); ?>/images/sm/s-data-top-icon01<?php if ( is_page( 'lgnews' ) ) : ?>-on<?php endif; ?>.png"
					alt="ニュース">
				<div>
					ニュース
				</div>
			</a>
		</li>
		<li <?php if ( is_post_type_archive( 'event' ) ): ?>class="active"<?php endif; ?>>
			<a href="/event/">
				<img
					src="<?php bloginfo( 'template_directory' ); ?>/images/sm/s-data-top-icon05<?php if ( is_post_type_archive( 'event' ) ): ?>-on<?php endif; ?>.png"
					alt="イベント">
				<div>
					<p>みんなの拠点</p>
					<p>イベント</p>
				</div>
			</a>
		</li>
		<li <?php if ( is_post_type_archive( 'data' ) ): ?>class="active"<?php endif; ?>>
			<a href="/data/">
				<img
					src="<?php bloginfo( 'template_directory' ); ?>/images/sm/s-data-top-icon02<?php if ( is_post_type_archive( 'data' ) ): ?>-on<?php endif; ?>.png"
					alt="データ">
				<div>
					データ
				</div>
			</a>
		</li>
		<li <?php if ( is_page( 'lgplayer' ) ): ?>class="active"<?php endif; ?>>
			<a href="/lgplayer/">
				<img
					src="<?php bloginfo( 'template_directory' ); ?>/images/sm/s-data-top-icon03<?php if ( is_page( 'lgplayer' ) ): ?>-on<?php endif; ?>.png"
					alt="人/団体">
				<div>
					人/団体
				</div>
			</a>
		</li>
		<li <?php if ( is_post_type_archive( 'tweet' ) ) : ?>class="active"<?php endif; ?>>
			<a href="/subject/">
				<img
					src="<?php bloginfo( 'template_directory' ); ?>/images/sm/s-data-top-icon04<?php if ( is_post_type_archive( 'tweet' ) ) : ?>-on<?php endif; ?>.png"
					alt="みんなの声">
				<div>
					みんなの声
				</div>
			</a>
		</li>
	</ul>
<?php endif; ?>
<?php if ( is_page( 'lgnews' ) ) : ?>
	<div class="underlayer_title_area">
		<h2 class="common_underlayer_title-h2">
			ニュース
		</h2>
		<div class="common_underlayer_title-h2__sub_title">
			あなたの身の回りで起きていることを知ることから始めましょう。
		</div>
	</div>
<?php endif; ?>
<?php if ( is_page( 'lgplayer' ) ) : ?>
	<div class="underlayer_title_area">
		<h2 class="common_underlayer_title-h2">
			人/団体
		</h2>
		<div class="common_underlayer_title-h2__sub_title">
			<?= $post->post_content; ?>
		</div>
	</div>
<?php endif; ?>
<?php if ( is_post_type_archive( 'event' ) ) : ?>
	<div class="underlayer_title_area">
		<h2 class="common_underlayer_title-h2">
			みんなの拠点/イベント
		</h2>
		<div class="common_underlayer_title-h2__sub_title">
			地域のカフェ、居場所やイベント情報をご紹介します。
		</div>
	</div>
<?php endif; ?>
<?php if ( is_post_type_archive( 'data' ) || is_singular( 'data' ) ): ?>
	<div class="underlayer_title_area">
		<h2 class="common_underlayer_title-h2">
			データ
		</h2>
		<div class="common_underlayer_title-h2__sub_title">
			地域のデータを見やすい形でまとめました。
		</div>
	</div>
<?php endif; ?>
<?php if ( is_post_type_archive( 'tweet' ) || is_singular( 'subject' ) ) : ?>
	<div class="underlayer_title_area">
		<h2 class="common_underlayer_title-h2">
			みんなの声
		</h2>
		<div class="common_underlayer_title-h2__sub_title">
			地域について寄せられた声の一覧です。
		</div>
	</div>
<?php endif; ?>
