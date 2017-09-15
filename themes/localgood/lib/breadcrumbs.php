<?php
// ぱんくずリスト
function breadcrumbs() {
	?>
	<div id="breadcrumb" class="c-breadcrumb">
		<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
			<a href="<?= home_url(); ?>" itemprop="url">
				<span itemprop="title">HOME</span>
			</a>
		</div>
		<?php
		if ( is_category() || is_singular( 'post' ) ):
			$postcat = get_the_category();
			if ( ! empty( $postcat ) ):
				?>
				<?php $catid = $postcat[0]->cat_ID; ?>
				<?php $allcats = array( $catid ); ?>
				<?php
				while ( ! $catid == 0 ) {
					$mycat = get_category( $catid );
					$catid = $mycat->parent;
					array_push( $allcats, $catid );
				}
				array_pop( $allcats );
				$allcats = array_reverse( $allcats );
				?>
				<span class="c-breadcrumb__separator">&rsaquo;</span>
				<?php
				if ( in_category( array( 'news', 'report' ) ) ):
					?>
					<a href="<?= home_url( 'lgnews' ); ?>" itemprop="url">
						<span itemprop="title">ニュース</span>
					</a>
					<?php
				elseif ( in_category( array( 'local_good_player', 'voice' ) ) ):
					?>
					<a href="<?= home_url( 'lgplayer' ); ?>" itemprop="url">
						<span itemprop="title">人/団体</span>
					</a>
					<?php
				endif;
				?>
				<?php /*--- 親カテゴリーがある場合は表示させる --- */ ?>
				<?php foreach ( $allcats as $catid ): ?>
				<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
					<span class="c-breadcrumb__separator">&rsaquo;</span>
					<a href="<?= get_category_link( $catid ); ?>" itemprop="url">
						<span itemprop="title"><?= get_cat_name( $catid ); ?></span>
					</a>
				</div>
			<?php endforeach;
			endif;
		elseif ( is_tag() ):
			$posttag = get_the_tags();
			$posttag = array_shift( $posttag );
			if ( ! empty( $posttag ) ):
				?>
				<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
					<span class="c-breadcrumb__separator">&rsaquo;</span>
					<a href="<?= home_url( '/tag/' . $posttag->slug ); ?>" itemprop="url">
						<span itemprop="title"><?= $posttag->name; ?></span>
					</a>
				</div>
				<?php
			endif;
		elseif ( is_post_type_archive( 'event' ) || is_singular( 'event' )
		         || is_post_type_archive( 'place' ) || is_singular( 'place' ) ):
			?>
			<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
				<span class="c-breadcrumb__separator">&rsaquo;</span>
				<?php if ( is_singular( 'event' ) || is_singular( 'place' ) ): ?>
				<a href="<?= home_url( '/event' ); ?>" itemprop="url">
					<?php endif; ?>
					<span itemprop="title">みんなの拠点/イベント</span>
					<?php if ( is_singular( 'event' ) ): ?>
				</a>
			<?php endif; ?>
			</div>
			<?php
		elseif ( is_post_type_archive( 'data' ) ):
			?>
			<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
				<span class="c-breadcrumb__separator">&rsaquo;</span>
				<span itemprop="title">データ</span>
			</div>
			<?php
		elseif ( is_tax( 'data_type' ) || is_tax( 'event_type' ) || is_tax( 'project_type' ) || is_tax( 'project_area' )  || is_tax( 'project_spot' ) || is_tax( 'project_theme' )  ):
			global $wp_query;
			$term = get_queried_object();
			?>
			<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
				<span class="c-breadcrumb__separator">&rsaquo;</span>
				<a href="<?= home_url( $term->taxonomy . '/' . $term->slug ); ?>" itemprop="url">
					<span itemprop="title"><?= $term->name; ?></span>
				</a>
			</div>
			<?php
		elseif ( is_singular( 'data' ) ):
			global $post;
			$term = get_the_terms( $post->ID, 'data_type' );
			if ( ! empty( $posttag ) ):
				$term = array_shift( $term );
				?>
				<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
					<span class="c-breadcrumb__separator">&rsaquo;</span>
					<a href="<?= home_url( $term->taxonomy . '/' . $term->slug ); ?>" itemprop="url">
						<span itemprop="title"><?= $term->name; ?></span>
					</a>
				</div>
				<?php
			endif;

		elseif ( is_tax( array( 'project_area' ) ) ):
			global $wp_query;
			$term = get_queried_object();
			?>
			<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
				<span class="c-breadcrumb__separator">&rsaquo;</span>
				<?php
				if ( in_category( array( 'news', 'report' ) ) ):
					?>
					<a href="<?= home_url( 'lgnews' ); ?>" itemprop="url">
						<span itemprop="title">ニュース</span>
					</a>
					<?php
				elseif ( in_category( array( 'local_good_player', 'voice' ) ) ):
					?>
					<a href="<?= home_url( 'lgplayer' ); ?>" itemprop="url">
						<span itemprop="title">人/団体</span>
					</a>
					<?php
				endif;
				?>
				<span class="c-breadcrumb__separator">&rsaquo;</span>
				<span itemprop="title">エリア</span>
				<span class="c-breadcrumb__separator">&rsaquo;</span>
				<a href="<?= home_url( $term->taxonomy . '/' . $term->slug ); ?>" itemprop="url">
					<span itemprop="title"><?= $term->name; ?></span>
				</a>
			</div>
			<?php
		elseif ( is_tax( array( 'project_theme' ) ) ):
			global $wp_query;
			$term = get_queried_object();
			?>
			<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
				<span class="c-breadcrumb__separator">&rsaquo;</span>
				<?php
				if ( in_category( array( 'news', 'report' ) ) ):
					?>
					<a href="<?= home_url( 'lgnews' ); ?>" itemprop="url">
						<span itemprop="title">ニュース</span>
					</a>
					<?php
				elseif ( in_category( array( 'local_good_player', 'voice' ) ) ):
					?>
					<a href="<?= home_url( 'lgplayer' ); ?>" itemprop="url">
						<span itemprop="title">人/団体</span>
					</a>
					<?php
				endif;
				?>
				<span class="c-breadcrumb__separator">&rsaquo;</span>
				<a href="<?= home_url( $term->taxonomy . '/' . $term->slug ); ?>" itemprop="url">
					<span itemprop="title"><?= $term->name; ?></span>
				</a>
			</div>
			<?php
		elseif ( is_post_type_archive( 'skills' ) || is_singular( 'skills' ) ):
			?>
			<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
				<span class="c-breadcrumb__separator">&rsaquo;</span>
				<span itemprop="title">スキルを活かす</span>
			</div>
			<?php
		elseif ( is_author() ):
			?>
			<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
				<span class="c-breadcrumb__separator">&rsaquo;</span>
				<span itemprop="title"><?php the_author(); ?> による記事一覧</span>
			</div>
			<?php
		elseif ( is_singular( 'subject' ) || is_singular( 'tweet' ) || is_archive() ):
			?>
			<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
				<span class="c-breadcrumb__separator">&rsaquo;</span>
				<a href="<?= home_url( 'subject' ); ?>" itemprop="url">
					<span itemprop="title">みんなの声</span>
				</a>
			</div>
			<?php
		elseif ( is_404() ):
			?>
			<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
				<span class="c-breadcrumb__separator">&rsaquo;</span>
				<span itemprop="title">ページが見つかりませんでした</span>
			</div>
			<?php
		elseif ( is_search() ):
			$_keyword = get_query_var( 's' );
			if ( ! empty( $_keyword ) ):
				$_keyword = '「' . $_keyword . '」の検索結果';
				?>
				<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
					<span class="c-breadcrumb__separator">&rsaquo;</span>
					<span itemprop="title"><?= $_keyword; ?></span>
				</div>
				<?php
			endif;
		endif;
		if ( is_singular() ):
			if ( is_singular( 'subject' ) || is_singular( 'tweet' ) ) {
				$_text = strip_tags( get_the_content() );
				if ( mb_strlen( $_text ) < 20 ) {
					$_title = $_text;
				} else {
					$_title = mb_substr( $_text, 0, 20 ) . '...';
				}
			} else {
				$_title = get_the_title();
			}
			?>
			<span class="c-breadcrumb__separator">&rsaquo;</span>
			<span><?= $_title; ?></span>
			<?php
		endif;
		?>
	</div><!--- end [breadcrumb] -->
	<?php
}
