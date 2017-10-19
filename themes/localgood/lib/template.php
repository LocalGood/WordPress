<?php
function social_buttons( $permalink = false, $comment = false ) {
	global $post;
	if ( ! $permalink ) {
//        $permalink = get_permalink();
		$permalink = home_url() . $_SERVER['REQUEST_URI'];
	}
	?>
	<?php if ( DEVICE == 'pc' ): ?>
		<!--  ▼　SNSアイコン　▼  -->
		<div id="social_bookmark" class="c-social_bookmark c-clearfix">
			<div id="twitter">
				<a href="https://twitter.com/share" class="twitter-share-button"
				   data-text="<?php generate_share_message(); ?>">Tweet</a>
				<script>
                  !function (d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0]
                    if (!d.getElementById(id)) {
                      js = d.createElement(s)
                      js.id = id
                      js.src = '//platform.twitter.com/widgets.js'
                      fjs.parentNode.insertBefore(js, fjs)
                    }
                  }(document, 'script', 'twitter-wjs')
				</script>
			</div>
			<div id="facebook">
				<div class="fb-like" data-href="<?php echo $permalink; ?>" data-layout="button_count" data-action="like"
					 data-show-faces="false" data-share="true"></div>
			</div>

			<div class="g-plusone" data-size="medium" data-width="60"></div>
			<script type="text/javascript">
              window.___gcfg = {lang: 'ja'};

              (function () {
                var po = document.createElement('script')
                po.type = 'text/javascript'
                po.async = true
                po.src = 'https://apis.google.com/js/platform.js'
                var s = document.getElementsByTagName('script')[0]
                s.parentNode.insertBefore(po, s)
              })()
			</script>
		</div><!-- #social_bookmark -->
		<!--  ▲　SNSアイコン　▲  -->
		<?php if ( $comment ): ?>
			<div class="fb_comment_box">
				<div class="fb-comments" data-href="<?php echo $permalink; ?>" data-width="100%" data-numposts="5"></div>
			</div><!-- /.fb_comment_box -->
		<?php endif;
	else: ?>
		<!--  ▼　SNSアイコン　▼  -->
		<div id="social_bookmark" class="c-social_bookmark c-clearfix">
			<div id="twitter">
				<a href="https://twitter.com/share" class="twitter-share-button"
				   data-text="<?php generate_share_message(); ?>">Tweet</a>
				<script>
                  !function (d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0]
                    if (!d.getElementById(id)) {
                      js = d.createElement(s)
                      js.id = id
                      js.src = '//platform.twitter.com/widgets.js'
                      fjs.parentNode.insertBefore(js, fjs)
                    }
                  }(document, 'script', 'twitter-wjs')
				</script>
			</div>
			<div id="facebook">
				<div class="fb-like" data-href="<?php echo $permalink; ?>" data-layout="button_count" data-action="like"
					 data-show-faces="false" data-share="true"></div>
			</div>

			<div class="g-plusone" data-size="medium" data-width="60"></div>
			<script type="text/javascript">
              window.___gcfg = {lang: 'ja'};

              (function () {
                var po = document.createElement('script')
                po.type = 'text/javascript'
                po.async = true
                po.src = 'https://apis.google.com/js/platform.js'
                var s = document.getElementsByTagName('script')[0]
                s.parentNode.insertBefore(po, s)
              })()
			</script>
		</div><!-- #social_bookmark -->
		<?php if ( $comment ): ?>
			<!--  ▲　SNSアイコン　▲  -->
			<div class="fb_comment_box">
				<div class="fb-comments" data-href="<?php echo $permalink; ?>" data-width="100%" data-numposts="5"></div>
			</div><!-- /.fb_comment_box -->
		<?php endif; ?>
	<?php endif; ?>

	<?php
}

function get_single_post() {
	global $post, $cfs;
	$is_tweet   = ( get_post_type() == 'tweet' );
	$is_subject = ( get_post_type() == 'subject' );
	$is_data    = ( get_post_type() == 'data' );
	$tags       = array();
	$taxonomies = array();
	// post_type によって取得するタクソノミー情報を分ける？
	if ( $post->post_type == 'post' ) {
		$taxonomies = array( 'category', 'theme', 'project_area', 'project_theme' );
	} else if ( $post->post_type == 'data' ) {
		$taxonomies = array( 'theme', 'project_area', 'project_theme' );
	} else if ( $post->post_type == 'subject' ) {
		$taxonomies = array( 'project_area' );
	}
	foreach ( $taxonomies as $t ) {
		$tag = get_the_terms( $post->ID, $t );
		if ( $tag && is_array( $tag ) ) {
			// ニュースは複数タグ許可
			if ( $post->post_type == 'post' ) {
				foreach ( $tag as $tg ) {
					array_push( $tags, $tg );
				}
			} else {
				array_push( $tags, array_pop( $tag ) );
			}
		}
	}
	$user = get_subject_user_meta( false, '' );

	if ( DEVICE == 'sp' )://↓ＳＰ用↓
		?>
		<div class="sp-post_wrapper">
			<div class="post_wrapper">

				<div class="post_title cf">
					<p class="date"><?php the_time( 'Y.m.d' ); ?></p>
					<?php if ( ! $is_subject && ! $is_tweet ): ?>
						<h1><?php the_title(); ?></h1>
						<p class="single__description">
							<?php
							if ( ! $cfs->get( 'lg_post_excerpt' ) ) {
								echo $cfs->get( 'lg_post_excerpt' );
							}
							?>
						</p>
					<?php endif; ?>
					<?php echo get_term_atag( $post->post_type ); ?>

					<?php if ( $is_tweet ): ?>
						<span class="subj_tw">tw</span>
					<?php elseif ( $is_subject ): ?>
						<span class="subj_wp">
                            <?php echo $user['avatar']; ?>
                        </span>
					<?php endif; ?>

					<?php if ( $is_tweet || $is_subject ):
						?>
						<div class="post_info">
							<p class="username">
								<?php if ( ! empty( $user['link'] ) ): ?><a href="<?php echo $user['link']; ?>"
																			target="_blank"><?php endif; ?>
									<?php echo $user['name']; ?>
									<?php if ( ! empty( $user['link'] ) ): ?></a><?php endif; ?>
							</p>
							<p class="postdate">
								<?php echo $user['postdate']; ?>
							</p>
						</div>
						<?php
						if ( $is_tweet && ! empty( $cf ) ):
							$_origtweet = 'https://twitter.com/' . $cf['twScreenName'][0] . '/status/' . $cf['twTweetID'][0];
							?>
							<p class="tags">
                                    <span class="original_tweet"><a href="<?php echo $_origtweet ?>"
																	target="_blank">元のつぶやきを見る</a></span>
							</p>
							<?php
						endif;
						?>
					<?php else: ?>
					<div class="clearfix">
						<?php endif; ?>
						<?php
						if ( ! $is_tweet ):
						?>
					</div><!-- /.clearfix -->

				<?php
				if ( ! is_singular( array( 'data', 'subject', 'skills', 'tweet' ) ) ):
					social_buttons();
					?>
					<div class="single__eyecatch">
						<?php
						$thumb = 'single-main_visual';
						the_post_thumbnail( $thumb );
						?>
					</div>
				<?php endif; ?>


				<?php
				endif;
				if ( $is_data ):
					$ig_source = $cfs->get( 'igSource' );
					$ig_author = $cfs->get( 'igAuthor' );
					$ig_license = $cfs->get( 'igLicense' );

					if ( ! empty( $ig_source ) || ! empty( $ig_source ) | ! empty( $ig_source ) ):
						?>
						<ul class="credit">
							<?php
							if ( $ig_source ):?>
								<li><span class="meta"><label>出典:</label><?php echo $ig_source; ?></span></li>
								<?php
							endif;
							if ( $ig_author ):?>
								<li><span class="meta"><label>作成者:</label><?php echo $ig_author; ?></span></li>
								<?php
							endif;
							if ( $ig_license ):?>
								<li><span class="meta"><label>ライセンス:</label><?php echo $ig_license; ?></span></li>
								<?php
							endif;
							?>
						</ul>
						<?php
					endif;
				endif;
				?>
				</div>
			</div>
		</div><!-- /.sp-post_wrapper -->
	<?php endif; ?>

	<?php
	if ( DEVICE == 'pc' ):
		?>

		<p class="single__postdate"><?php the_time( 'Y.m.d' ); ?></p>
		<div class="single__title_area">
			<?php if ( $is_tweet ): ?>
				<span class="c-subj_tw">tw</span>
			<?php elseif ( $is_subject ):
				?>
				<span class="c-subj_wp">
                            <?php echo $user['avatar']; ?>
                </span>
			<?php endif; ?>

			<?php if ( ! is_singular( 'subject' ) && ! is_singular( 'tweet' ) ): ?>
				<h3 class="single__title c-title05"><?php the_title(); ?></h3>
				<p class="single__description">
					<?php
					if ( ! $cfs->get( 'lg_post_excerpt' ) ) {
						echo $cfs->get( 'lg_post_excerpt' );
					}
					?>
				</p>
			<?php endif; ?>

			<?php if ( $is_tweet || $is_subject ):
				?>
				<div class="single__post_info">
					<p class="single__username">
						<?php if ( ! empty( $user['link'] ) ): ?><a href="<?php echo $user['link']; ?>"
																	target="_blank"><?php endif; ?>
							<?php echo $user['name']; ?>
							<?php if ( ! empty( $user['link'] ) ): ?></a><?php endif; ?>
					</p>

					<p class="single__postdate">
						<?php echo $user['postdate']; ?>
					</p>
				</div>
				<?php
				if ( $is_tweet && ! empty( $cf ) ):
					$_origtweet = 'https://twitter.com/' . $cf['twScreenName'][0] . '/status/' . $cf['twTweetID'][0];
					?>
					<p class="single__tags">
                            <span class="original_tweet"><a href="<?php echo $_origtweet ?>"
															target="_blank">元のつぶやきを見る</a></span>
					</p>
					<?php
				endif;
				?>
			<?php else: ?>
			<div class="single_head_info_area">
				<?php endif; ?>
				<?php echo get_term_atag( $post->post_type ); ?>
			</div>

			<?php
			if ( ! is_singular( array( 'data', 'subject', 'skills', 'tweet' ) ) ):
				echo "<div class='single_head_social_buttons'>";
				social_buttons();
				echo "</div>";
				?>
				<div class="single__eyecatch">
					<?php
					$thumb = 'single-main_visual';
					the_post_thumbnail( $thumb );
					?>
				</div>
			<?php endif; ?>

			<?php
			if ( $is_data ):
				$ig_source = $cfs->get( 'igSource' );
				$ig_author = $cfs->get( 'igAuthor' );
				$ig_license = $cfs->get( 'igLicense' );

				if ( ! empty( $ig_source ) || ! empty( $ig_source ) | ! empty( $ig_source ) ):
					?>
					<ul class="single__credit">
						<?php
						if ( $ig_source ):?>
							<li><span class="meta"><label>出典:</label><?php echo $ig_source; ?></span></li>
							<?php
						endif;
						if ( $ig_author ):?>
							<li><span class="meta"><label>作成者:</label><?php echo $ig_author; ?></span></li>
							<?php
						endif;
						if ( $ig_license ):?>
							<li><span class="meta"><label>ライセンス:</label><?php echo $ig_license; ?></span></li>
							<?php
						endif;
						?>
					</ul>
					<?php
				endif;
			endif;
			?>
		</div><!-- /.post_title -->
	<?php endif; ?>
	<div class="single__post_body">
		<?php
		$_content = get_the_content();
		if ( $is_tweet || $is_subject ) {
			$_content = preg_replace( '/(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)/',
				'<a target="_blank" href="\\1\\2">\\1\\2</a>', $_content );
			$_content = preg_replace( "/\s#(w*[一-龠_ぁ-ん_ァ-ヴーａ-ｚＡ-Ｚa-zA-Z0-9]+|[a-zA-Z0-9_]+|[a-zA-Z0-9_]w*)/u",
				" <a href=\"https://twitter.com/search/%23\\1\" target=\"twitter\">#\\1</a>", $_content );
		}
		$content = apply_filters( 'the_content', $_content );
		echo $content;

		if (
			( $is_subject && has_post_thumbnail( $post->ID ) ) ||
			( $is_tweet && has_post_thumbnail( $post->ID ) )
		):
			?>
			<div class="subject_pic">
				<?php
				the_post_thumbnail( 'archive-thumbnails' );
				?>
			</div>
			<?php
		endif;
		?>
	</div><!-- /.post_body -->

	<?php
	if ( ! is_singular( array( 'data', 'subject', 'skills', 'tweet' ) ) ): ?>
		<div class="related_url">
			<?php
			$link_sets = $cfs->get( 'link_set' );
			if ( $link_sets ):
				?>
				<ul class="link_set">
					<?php
					foreach ( $link_sets as $link ):
						if ( $link['link_url'] != '' && $link['link_title'] != '' ):
							?>
							<li><a href="<?php echo $link['link_url']; ?>" target="_blank"><?php echo $link['link_title']; ?></a>
							</li>
							<?php
						endif;
					endforeach;
					?>
				</ul>
				<?php
			endif;
			?>
		</div>
		<?php
	endif;
}

function topic_box( $cnt = null ) {
	global $post;
	?>
	<div class="topic_box <?php if ( $cnt % 3 == 0 ) {
		echo 'noborder ';
	}
	if ( $cnt > 3 ) {
		echo 'topborder';
	} ?>">
		<div class="topic_box__inner">
			<?php $thumb = ( DEVICE === 'pc' ) ? 'archive-thumbnails' : 'single-main_visual'; ?>
			<div class="topic_box__thumbnail">
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( $thumb ); ?></a>
			</div>
			<?php echo get_term_atag( get_post_type() ); ?>
			<div class="topic_box__title">
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			</div>
		</div>
	</div>
	<?php
}

function article_box() {
	global $post;

	$thumb = ( DEVICE === 'pc' ) ? 'archive-thumbnails' : 'single-main_visual';

	$cf = get_post_custom( $post->ID );

	// "課題を見る"用
	$is_tweet          = ( get_post_type() == 'tweet' );
	$is_subject        = ( get_post_type() == 'subject' );
	$subject_user_meta = get_subject_user_meta( $is_tweet, $cf );

	if ( $is_tweet || $is_subject ) {
		$subj_types = true;
	} else {
		$subj_types = false;
	}

	$data_lonlat = get_post_lonlat_attr();
	if ( ! $data_lonlat && $is_subject ) {
		//位置情報の後方互換
		if ( ! empty( $cf['sbLatLng'] ) && ( strpos( $cf['sbLatLng'][0], ',' ) > 0 ) ) {
			$latlng      = explode( ',', $cf['sbLatLng'][0] );
			$data_lonlat = 'data-long="' . $latlng[1] . '" data-lat="' . $latlng[0] . '"';
		}
	}
	$data_meta = get_post_meta_attr();
	?>
	<section class="article_box common_box" <?php echo $data_lonlat; ?>  <?php echo $data_meta; ?> data-type="<?php echo $post->post_type; ?>">
		<?php
		if ( DEVICE == 'sp' ): ?>
			<div class="list_inner">

				<?php
				// goteoプロジェクト or ユーザー情報等、非WPコンテンツの読み込み用
				// 課題etc, Wordpressコンテンツ
				?>

				<div class="thumbnail">
					<?php if ( get_post_type() == 'subject' || get_post_type() == 'tweet' || is_singular( 'subject' ) ): ?>
					<?php else: ?>
						<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( $thumb ); ?></a>
					<?php endif; ?>
				</div>
				<div class="post_text-area">
					<h2 class="title"><a
							href="<?php the_permalink(); ?>">
							<img src="<?php echo get_option( 'lg_config__group_ttl_prefix' ); ?>" >
							<?php echo shorten( get_the_title(), '34' ); ?></a></h2>

					<?php echo get_term_atag( get_post_type() ); ?>
					<?php
					if ( $subj_types ):
						?>
						<div class="common_single_parts_info__sns">
							<?php if ( $is_tweet ): ?>
								<span class="subj_tw">
                                        <img
											src="<?php echo get_template_directory_uri(); ?>/images/sm/s-archive-subject_twitter-icon.png"
											alt="Twitter"/>
                                    </span>
							<?php elseif ( $is_subject ): ?>
								<span class="subj_wp">
                            <?php echo $subject_user_meta['avatar']; ?>
                                    </span>
							<?php endif; ?>
							<div class="post_info">
								<p class="username">
									<?php if ( empty( $subject_user_meta['name'] ) ): ?>
										匿名
									<?php else: ?>
										<a href="<?php echo $subject_user_meta['link']; ?>"
										   target="_blank"><?php echo $subject_user_meta['name']; ?></a>
									<?php endif; ?>
								</p>
								<p class="postdate">
									<?php echo $subject_user_meta['postdate']; ?>
								</p>
							</div>
						</div>
						<?php
					endif;
					?>
				</div>
			</div>
		<?php else:
			// goteoプロジェクト or ユーザー情報等、非WPコンテンツの読み込み用
			// 課題etc, Wordpressコンテンツ
            ?>
			<div>
				<?php if ( ! $subj_types ): ?>
					<div class="article_box__thumbnail">
						<a class=""
						   href="<?php the_permalink(); ?>"><?php the_post_thumbnail( $thumb ); ?></a>
					</div>
				<?php endif; ?>
				<div class="article_box__texts">
					<div class="article_box__title">
						<h2><?php echo shorten( get_the_title(), '34' ); ?></h2>
					</div>
					<div class="article_box__description">
						<a href="<?php the_permalink(); ?>">
							<p class="article_box__excerpt"><?php echo lg_post_excerpt(); ?></p>
						</a>
					</div>
					<div class="article_box__area">
						<?php
						echo get_term_atag( $post->post_type ); ?>
					</div>
					<?php
					if ( $subj_types ):
						?>
						<div class="c-post_user c-clearfix">
							<?php if ( $is_tweet ): ?>
								<span class="c-subj_tw">tw</span>
							<?php elseif ( $is_subject ): ?>
								<span class="c-subj_wp">
                            <?php echo $subject_user_meta['avatar']; ?>
                        </span>
							<?php endif; ?>
							<div class="c-post_info">
								<p class="c-username">
									<?php if ( empty( $subject_user_meta['name'] ) ): ?>
										匿名
									<?php else: ?>
										<a href="<?php echo $subject_user_meta['link']; ?>"
										   target="_blank"><?php echo $subject_user_meta['name']; ?></a>
									<?php endif; ?>
								</p>
								<p class="c-postdate">
									<?php echo $subject_user_meta['postdate']; ?>
								</p>
							</div>
						</div>
						<?php
					endif;
					?>
				</div><!-- /.article_box__texts -->
			</div>
			<?php
		endif;
		?>
	</section><!-- /.article_box -->
	<?php
}

function related_posts() {
	global $cfs;
	$post_ids = $cfs->get( 'related_posts' );
	?>
	<?php
	$args          = array(
		'posts_per_page' => 3,
		'post__in'       => $post_ids
	);
	$related_posts = new WP_Query( $args );
	if ( in_category( 'news' ) ):
		if ( $related_posts->have_posts() ):?>
			<div class="related_posts">
				<h4 class="related_posts__title c-title05">関連記事</h4>
				<div class="related_posts__inner">
					<?php while ( $related_posts->have_posts() ): $related_posts->the_post();
						?>

						<div class="related_box">
							<a class="related_box__thumbnail"
							   href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'archive-thumbnails' ); ?></a>
							<a class="related_box__texts" href="<?php the_permalink(); ?>">
								<h2 class="related_box__title"><?php the_title(); ?></h2>
								<p class="related_box__excerpt"><?php echo lg_post_excerpt(); ?></p>
							</a>
						</div>
						<?php
					endwhile; ?>
				</div>
			</div>
		<?php endif; endif;
	?>
	<?php
}

function key_topic_box( $index = 0 ) {
	global $post;
	if ( $index !== 0 ) {
		$thumb = 'pickup_box_sub';
	} else {
		$thumb = 'pickup_box_main';
	}
	$data_lonlat = get_post_lonlat_attr();
	$data_meta   = get_post_meta_attr();
	?>
	<section class="topic_box c-clearfix <?php if ( $index !== 0 ) {
		echo 'second';
	} ?>" <?php echo $data_lonlat; ?> <?php echo $data_meta; ?>>
		<a class="topic_box__thumbnail" href="<?php the_permalink(); ?>"><?php the_post_thumbnail( $thumb ); ?></a>
		<div class="topic_box__text_area">
			<a class="topic_box__text_link" href="<?php the_permalink(); ?>">
				<h3 class="topic_box__title"><?php the_title(); ?></h3>
				<div class="topic_box__text">
					<?php
					if ( $post->post_type == 'event' ) {
						$cf = get_post_custom( $post->ID );
						?>
						<p class="topic_box__excerpt">
							<?php
							if ( ! empty( $cf['event_sub_title'] ) && ! empty( $cf['event_sub_title'][0] ) ):
								echo $cf['event_sub_title'][0];
							endif;
							?>
						</p>
						<?php
						if ( ! empty( $cf['event_display_date'] ) && ! empty( $cf['event_display_date'][0] ) ):
							?>
							<dl class="topic_box__date  ">
								<dt>日時:</dt>
								<dd><?php echo $cf['event_display_date'][0]; ?></dd>
							</dl>
							<?php
						endif;
						if ( ! empty( $cf['event_place'] ) && ! empty( $cf['event_place'][0] ) ):
							?>
							<dl class="article_box__place">
								<dt>場所:</dt>
								<dd><?php echo $cf['event_place'][0]; ?></dd>
							</dl>
							<?php
						endif;
					} else {
						echo lg_post_excerpt();
					}
					?>
				</div>
			</a>
			<div class="tags">
				<?php
				if ( ! empty( $cf['event_date'] ) && ! empty( $cf['event_date'][0] ) && strtotime( $cf['event_date'][0] ) ):
					if ( strtotime( date( 'Y-m-d' ) ) <= strtotime( $cf['event_date'][0] ) ) {
						?>
						<span class="c-event_status status">
                                        <?php
										echo '開催予定';
										?>
                                    </span>
						<?php
					} else {
						?>
						<span class="c-event_status status end">
                                        <?php
										echo '終了';
										?>
                                    </span>
						<?php
					}
				endif;
				?>
				<?php echo get_term_atag( $post->post_type ); ?>
			</div>
		</div>
	</section>
	<?php
}

/**
 * @param object $post WordPress Post Object
 */
function place_box( $post = null ) {
	if ( ! $post ) {
		global $post;
	}
	$place_subtitle = ( "" !== ( get_post_meta( $post->ID, 'place_sub_title', true ) ) ) ? get_post_meta( $post->ID, 'place_sub_title', true ) : false;

	$place_latlng = array(
		'latitude'  => get_post_meta( $post->ID, 'place_latitude', true ),
		'longitude' => get_post_meta( $post->ID, 'place_longitude', true ),
	);
	if ( ! empty( $place_latlng['latitude'] ) && ! empty( $place_latlng['longitude'] ) ) {
		$location = "data-lat=\"{$place_latlng['latitude']}\" data-long=\"{$place_latlng['longitude']}\"";
	} else {
		$location = '';
	}

	?>
	<section class="place_box common_box" data-type="place" data-title="<?php echo get_the_title(); ?>"
			 data-href="<?php echo get_permalink(); ?>" <?php echo $location; ?>>
		<div class="place_box__heading">
			<div class="place_box__thumbnail">
				<a href="<?php echo get_permalink( $post->ID ); ?>" class="place_box__title">
					<?php the_post_thumbnail( ( 'pc' === DEVICE ) ? 'thumbnail' : 'large' ); ?>
				</a>
			</div>
			<a href="<?php echo get_permalink( $post->ID ); ?>" class="place_box__title">
				<h2 class=""><?php the_title(); ?></h2>
				<?php if ( $place_subtitle ) : ?>
					<p class=""><?php echo $place_subtitle; ?></p>
				<?php endif; ?>
			</a>
		</div>
		<div class="place_box__description">
			<?php
			$excerpt = get_the_excerpt();
			if ( $place_subtitle ) {
				$excerpt = wp_trim_words( $excerpt, 35, '…' );
			} else {
				$excerpt = wp_trim_words( $excerpt, 48, '…' );
			}
			echo $excerpt;
			?>
		</div>
		<div class="place_box__area">
			<?php
			$tags = get_term_atag( $post->post_type, false );
			foreach ( $tags as $tag ) {
				echo '<span>' . $tag . '</span>';
			}
			?>
		</div>
	</section>
	<?php

}

// スキルページのタブ
function show_skill_tabs( $_post_id = 0 ) {
	global $post;

	$args         = array(
		'post_type'      => 'skills',
		'posts_per_page' => 100
	);
	$tabmenu_item = new WP_Query( $args );

	//for flipsnap
	$_viewport = '';
	$_flipsnap = '';

	if ( DEVICE == 'sp' ):
		$_viewport .= " class='viewport_skills'";
		$_flipsnap .= " class='flipsnap_skills'";
	endif;
	?>
	<div class="tab_menu <?php if ( DEVICE == 'pc' ): echo "two_right";endif; ?>">
		<!--    <p class="prev"><a><img src="--><?// bloginfo('template_directory');
		?><!--/images/prev_btn.png" alt="前へ" /></a></p>-->
		<?php if ( DEVICE == 'pc' ): ?>
			<h2>スキル一覧</h2>
		<?php endif; ?>
		<div<?php echo $_viewport; ?>>
			<ul<?php echo $_flipsnap; ?>>
				<?/*<li<?php if (is_post_type_archive('skills')): echo " class='show'"; endif; ?>>
                <a href="<?php echo home_url('skills'); ?>">スキルについて</a>
            </li>*/
				?>
				<?php
				$cnt = 2;
				if ( $tabmenu_item->have_posts() ):
					while ( $tabmenu_item->have_posts() ):
						$tabmenu_item->the_post();
						?>
						<li<?php if ( $_post_id == $post->ID ): echo " class='show'"; endif; ?>>
							<a href="<?php the_permalink(); ?>"<?php if ( $cnt % 5 == 0 || $cnt == ( $tabmenu_item->post_count + 1 ) ): echo " class='addborder'"; endif; ?>><?php the_title(); ?></a>
						</li>
						<?php
						$cnt ++;
					endwhile;
				endif;
				?>
			</ul>
			<?php if ( DEVICE === 'sp' ): ?>
				<p class="controls">
					<a class="prev">&lt;</a>
					<a class="next">&gt;</a>
				</p>
			<?php endif; ?>
		</div>
	</div>
	<?php
	wp_reset_postdata();
}

//シングル内投稿者欄、投稿者ページ用のプロフィール
function writer_prof() {
	global $post;

	if ( DEVICE === 'pc' ) {
		$user = get_subject_user_meta( false, '', 100 );
	} else {
		$user = get_subject_user_meta( false, '', 400 );
	}
	?>
	<?php if ( DEVICE == 'sp' ): ?>
		<div class="sp_wr_wrapper">
			<div class="wr_ttl_box clearfix">
				<div class="clearfix">
					<div class="thumbnail">
						<?php echo $user['avatar']; ?>
					</div>
					<div class="title">
						<a href="<?php echo $user['link']; ?>"><?php echo $user['name']; ?></a>
						<?php if( !is_author() ):?>
						<a href="<?php echo $user['link']; ?>" class="link">詳細を見る></a>
						<?php endif;?>
					</div>
				</div>
				<div class="topix_right">
					<div class="cnt_text">
						<p><?php echo $user['description']; ?></p>
					</div>
					<div class="sns_line_wrapper">
						<ul class="sns_line clearfix">
							<?php
							$lnk_fb  = get_field( 'prof_fb_url', 'user_' . $user['id'] );
							$lnk_tw  = get_field( 'prof_tw_url', 'user_' . $user['id'] );
							$icon_fb = ( $lnk_fb !== false && $lnk_fb !== "" ) ? "/sm/s-author-fb-on.png" : "/sm/s-author-fb.png";
							$icon_tw = ( $lnk_tw !== false && $lnk_tw !== "" ) ? "/sm/s-author-tw-on.png" : "/sm/s-author-tw.png";
							?>
							<li>
								<?php if ( $lnk_fb ): ?><a href="<?php echo $lnk_fb; ?>"
														   target="_blank"><?php endif; ?>
									<img
										src="<?php bloginfo( 'url' ); ?>/wp-content/themes/localgood/images/<?php echo $icon_fb; ?>"
										alt="facebook">
									<?php if ( $lnk_fb ): ?></a><?php endif; ?>
							</li>
							<li>
								<?php if ( $lnk_tw ): ?><a href="<?php echo $lnk_tw; ?>"
														   target="_blank"><?php endif; ?>
									<img
										src="<?php bloginfo( 'url' ); ?>/wp-content/themes/localgood/images/<?php echo $icon_tw; ?>"
										alt="twitter">
									<?php if ( $lnk_tw ): ?></a><?php endif; ?>
							</li>
						</ul>
					</div><!-- /.sns_line_wrapper -->
				</div>
			</div>
		</div><!-- /.sp_wr_wrapper -->
	<?php else:
//↓ＰＣ用↓
		?>
		<div class="common_single_parts_info">
			<?php if ( ! is_author() ): ?>
				<h3 class="common_single_parts_info--title title">ライター紹介</h3>
			<?php endif; ?>
			<div class="common_single_parts_info--heading">
				<div class="common_single_parts_info--thumbnail">
					<?php echo $user['avatar']; ?>
				</div>
				<div class="common_single_parts_info--name">
					<h3 class="title"><a
							href="<?php echo $user['link']; ?>"><?php echo $user['name']; ?></a>
					</h3>
					<?php if( !is_author() ):?>
					<a href="<?php echo $user['link']; ?>" class="common_single_parts_info--link">詳細を見る></a>
					<?php endif;?>
				</div>
			</div>
			<div class="common_single_parts_info--description">
				<p><?php echo $user['description']; ?></p>
			</div>
			<div class="common_single_parts_info--sns">
				<?php
				$lnk_fb  = get_field( 'prof_fb_url', 'user_' . $user['id'] );
				$lnk_tw  = get_field( 'prof_tw_url', 'user_' . $user['id'] );
				$icon_fb = ( $lnk_fb !== false && $lnk_fb !== "" ) ? "writer_fb_on.png" : "writer_fb_off.png";
				$icon_tw = ( $lnk_tw !== false && $lnk_tw !== "" ) ? "writer_tw_on.png" : "writer_tw_off.png";
				?>


				<?php if ( $lnk_fb ): ?><a href="<?php echo $lnk_fb; ?>"
										   class="fb"
										   target="_blank"><?php endif; ?>
					<img
						src="<?php bloginfo( 'url' ); ?>/wp-content/themes/localgood/images/<?php echo $icon_fb; ?>"
						alt="facebook">
					<?php if ( $lnk_fb ): ?></a><?php endif; ?>

				<?php if ( $lnk_tw ): ?><a href="<?php echo $lnk_tw; ?>"
										   class="tw"
										   target="_blank"><?php endif; ?>
					<img
						src="<?php bloginfo( 'url' ); ?>/wp-content/themes/localgood/images/<?php echo $icon_tw; ?>"
						alt="twitter">
					<?php if ( $lnk_tw ): ?></a><?php endif; ?>

			</div>
		</div>
	<?php endif; ?>
	<?php
}


//投稿者アーカイブ
function writers_archive() {
	$user['id']       = get_the_author_meta( 'ID' );
	$user['nickname'] = get_the_author_meta( 'nickname' );

	$users             = get_users( array( 'orderby=ID' ) );
	$user_datas        = array();
	foreach ( $users as $user ):
		$uid        = $user->ID;
		$args       = array(
			'post_type'      => array( 'post' ),
			'author'         => $uid,
			'order'          => 'DESC',
			'orderby'        => 'modified',
			'posts_per_page' => 1
		);
		$user_query = new WP_Query( $args );

		if ( $user_query->have_posts() ): $user_query->the_post();
			$user_datas[] = $user_query->post;
		endif;
	endforeach;

	array_multisort( $user_datas, SORT_DESC );
	if ( DEVICE == 'sp' ):
		foreach ( $user_datas as $user_data ):
			$uid = $user_data->post_author;
			$user_link = get_author_posts_url($uid);
			?>
			<div class="article_box">
				<div class="list_inner  heightLine-1">
					<div class="article_box__heading">
						<div class="authors_thumbnail">
							<?php echo get_avatar( $uid, 100 ); ?>
						</div>
						<h3><a href="<?php echo $user_link; ?>"><span class="nickname"><?php the_author_meta( 'display_name',
										$uid ); ?></span></a></h3>
					</div>
					<div class="cnt_text">
						<p><?php the_author_meta( 'description', $uid ); ?></p>
						<div class="sns_line_wrapper clearfix">
							<ul class="sns_line clearfix">
								<?php
								$lnk_fb  = get_field( 'prof_fb_url', 'user_' . $uid );
								$lnk_tw  = get_field( 'prof_tw_url', 'user_' . $uid );
								$icon_fb = ( $lnk_fb !== false && $lnk_fb !== "" ) ? "/sm/s-author-fb-on.png" : "/sm/s-author-fb.png";
								$icon_tw = ( $lnk_tw !== false && $lnk_tw !== "" ) ? "/sm/s-author-tw-on.png" : "/sm/s-author-tw.png";
								?>
								<li>
									<?php if ( $lnk_fb ): ?><a href="<?php echo $lnk_fb; ?>"
															   target="_blank"><?php endif; ?>
										<img
											src="<?php bloginfo( 'url' ); ?>/wp-content/themes/localgood/images/<?php echo $icon_fb; ?>"
											alt="facebook">
										<?php if ( $lnk_fb ): ?></a><?php endif; ?>
								</li>
								<li>
									<?php if ( $lnk_tw ): ?><a href="<?php echo $lnk_tw; ?>"
															   target="_blank"><?php endif; ?>
										<img
											src="<?php bloginfo( 'url' ); ?>/wp-content/themes/localgood/images/<?php echo $icon_tw; ?>"
											alt="twitter">
										<?php if ( $lnk_tw ): ?></a><?php endif; ?>
								</li>
							</ul>
						</div><!-- /.sns_line_wrapper -->
					</div>
				</div>
			</div>
			<?php
		endforeach;

	elseif ( DEVICE == 'pc' ):
		?>
		<div class="article_area">
			<div class="article_box__wrapper">
				<?php
				foreach ( $user_datas as $user_data ):

					$uid = $user_data->post_author;
					$user_link = get_author_posts_url($uid);

					?>
					<div class="article_box">
						<div class="article_box__thumbnail">
							<a href="<?php echo $user_link; ?>"><?php echo get_avatar( $uid, 145 ); ?></a>
						</div>
						<div class="article_box__texts">
							<h3 class="article_box__title"><a href="<?php echo $user_link; ?>"><span
										class="nickname"><?php the_author_meta( 'display_name', $uid ); ?></span></a>
							</h3>
							<p class="article_box__description"><a href="<?php echo $user_link; ?>"><?php the_author_meta( 'description', $uid ); ?></a></p>

							<ul class="article_box__sns">
								<?php
								$lnk_fb  = get_field( 'prof_fb_url', 'user_' . $uid );
								$lnk_tw  = get_field( 'prof_tw_url', 'user_' . $uid );
								$icon_fb = ( $lnk_fb !== false && $lnk_fb !== "" ) ? "writer_fb_on.png" : "writer_fb_off.png";
								$icon_tw = ( $lnk_tw !== false && $lnk_tw !== "" ) ? "writer_tw_on.png" : "writer_tw_off.png";
								?>
								<li>
									<?php if ( $lnk_tw ): ?><a href="<?php echo $lnk_tw; ?>"
															   target="_blank"><?php endif; ?>
										<img
											src="<?php bloginfo( 'url' ); ?>/wp-content/themes/localgood/images/<?php echo $icon_tw; ?>"
											alt="twitter">
										<?php if ( $lnk_tw ): ?></a><?php endif; ?>
								</li>
								<li>
									<?php if ( $lnk_fb ): ?><a href="<?php echo $lnk_fb; ?>"
															   target="_blank"><?php endif; ?>
										<img
											src="<?php bloginfo( 'url' ); ?>/wp-content/themes/localgood/images/<?php echo $icon_fb; ?>"
											alt="facebook">
										<?php if ( $lnk_fb ): ?></a><?php endif; ?>
								</li>
							</ul>

						</div>
					</div>
					<?php
				endforeach;
				?>
			</div>
		</div>
		<?php
	endif;
}

function knows_head_tab( $post = null ) {

	$current = 'active';
	$path    = $_SERVER['REQUEST_URI'];

	//タイトル表示の生成
	//-- 20160714 usui ----------------------------------------------------------------------
	// pageアーカイブだったら$post->post_name, カスタム投稿タイプだったら$post->slugを出すように書き直す
	// descriptionはどうするかちょっと考える。
	//---------------------------------------------------------------------------------------
	$page_value = array();
	if ( is_page() ) {
		$page_value['title']       = get_the_title();
		$page_value['description'] = $post->post_content;
	} elseif ( is_category() ) {
		$cat                       = get_the_category();
		$page_value['title']       = $cat[0]->name;
		$page_value['description'] = $cat[0]->description;
	} elseif ( strpos( $path, '/data/' ) !== false ) {
		$page_value['title']       = 'データ';
		$page_value['description'] = '地域のデータを見やすい形でまとめました。';
	} elseif ( strpos( $path, '/subject/' ) !== false || strpos( $path, '/tweet/' ) !== false ) {
		$page_value['title']       = 'みんなの声';
		$page_value['description'] = '地域について寄せられた声の一覧です。';
	}

	?>
	<div class="knows_tab">
		<ul>
			<li class="<?php if ( is_page( 'lgnews' ) || in_category( array( 'news', 'report' ) ) ) {
				echo $current;
			} ?>"><a href="<?php echo home_url( '/lgnews/' ); ?>"><span>ニュース</span></a></li>
			<li class="<?php if ( is_post_type_archive( 'event' ) ) {
				echo $current;
			} ?>"><a href="<?php echo home_url( '/event/' ); ?>" class="small"><span>みんなの拠点/イベント</span></a></li>
			<li class="<?php if ( is_post_type_archive( 'data' ) ) {
				echo $current;
			} ?>"><a href="<?php echo home_url( '/data/' ); ?>"><span>データ</span></a></li>
			<li class="<?php if ( is_page( 'lgplayer' ) || in_category( array( 'local_good_player', 'voice' ) ) ) {
				echo $current;
			} ?>"><a href="<?php echo home_url( '/lgplayer/' ); ?>"><span>人/団体</span></a></li>
			<li class="<?php if ( strpos( $path, '/subject/' ) !== false ) {
				echo $current;
			} ?>"><a href="<?php echo home_url( '/subject/' ); ?>"><span>みんなの声</span></a></li>
		</ul>
	</div>
	<?php
}

function knows_map_bar() { ?>

	<div class="knows_map__bar c-clearfix">
		<div class="knows_map__toggle_button close">
			<span>地図を閉じる</span>
		</div>
		<?php
		global $post;
		if ( "sp" === DEVICE && 'event' === $post->post_type ) : ?>
				<div class="knows_map__search_button">
					<a href="javascript:void(0);" id="filterSearch">詳細検索</a>
				</div>
		<?php endif; ?>

		<div class="knows_map__refine">
			<form action="">

				<?php if ( is_post_type_archive( array( 'subject', 'tweet' ) ) ):
				elseif ( is_post_type_archive( array( 'event' ) ) ): ?>
					<?php/*
                    <div class="knows_map__refine__parts">
                        <select name="event_type" id="f_event_type" class="knows_map__select">
                            <option value="">イベントの種類で絞り込む</option>
                            <?php
                            $event_types = get_terms( 'event_type' );
                            foreach ($event_types as $event_type) {
                                if (isset( $_GET['event_type'] ) && $_GET['event_type'] == $event_type->slug) {
                                    $selected = 'selected="selected"';
                                } else {
                                    $selected = '';
                                }
                                ?>
                                <option
                                    value="<?php echo $event_type->slug; ?>" <?php echo $selected; ?>><?php echo $event_type->name; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
*/ ?>
					<?php
				else: ?>
					<div class="knows_map__refine__parts">
						<select name="project_area" id="f_news_area" class="knows_map__select">
							<option value="">地域で絞り込む</option>
							<?php
							$area_terms = get_terms( 'project_area' );
							foreach ( $area_terms as $area_term ) {
								if ( isset( $_GET['project_area'] ) && $_GET['project_area'] == $area_term->slug ) {
									$selected = 'selected="selected"';
								} else {
									$selected = '';
								}
								?>
								<option
									value="<?php echo $area_term->slug; ?>" <?php echo $selected; ?>><?php echo $area_term->name; ?></option>
								<?php
							}
							?>
						</select>
					</div>
				<?php endif; ?>

				<?php if ( ! is_post_type_archive( array( 'event' ) ) ): ?>
					<span id="knows_map__button" class="knows_map__button">テーマで絞り込む</span>

					<div class="news_theme__pop_wrapper">
						<div class="news_theme__inner_box">
                        <span class="news_theme__close"><img
								src="<?php echo get_template_directory_uri(); ?>/images/close_btn.png" alt="閉じる"></span>
							<div class="select_theme__wrapper stw_02">
								<?php
								$search_theme = false;
								if ( isset( $_GET['theme'] ) && is_array( $_GET['theme'] ) ) {
									$search_theme = $_GET['theme'];
								}
								$tree_themes = get_tree_themes();
								foreach ( $tree_themes as $t ):

									?>
									<section class="select_theme">
										<h3 class="select_theme__title"><input type="checkbox" name="theme[]"
												<?php if ( $search_theme && in_array( $t['parent']->slug,
														$search_theme )
												) {
													echo 'checked="checked"';
												} ?>
																			   value="<?php echo $t['parent']->slug; ?>"/>
											<button <?php if ( $search_theme && in_array( $t['parent']->slug,
													$search_theme )
											) {
												echo 'class="select"';
											} ?> ><?php echo $t['parent']->name; ?></button>
										</h3>
										<?php if ( isset( $t['children'] ) ): ?>
											<ul class="select_theme__list clearfix">
												<?php foreach ( $t['children'] as $c ):
													?>
													<li>
														<input type="checkbox" name="theme[]"
															   value="<?php echo $c->slug; ?>" <?php if ( $search_theme && in_array( $c->slug,
																$search_theme )
														) {
															echo 'checked="checked"';
														} ?> />
														<button <?php if ( $search_theme && in_array( $c->slug,
																$search_theme )
														) {
															echo 'class="select"';
														} ?> ><?php echo $c->name; ?></button>
													</li>
												<?php endforeach; ?>
											</ul>
										<?php endif; ?>
									</section>
								<?php endforeach; ?>
							</div>
							<div class="news_theme clearfix">
								<div class="news_theme__buttons">
									<span class="news_theme__buttons__cancel">キャンセル</span>
									<input id="f_news_theme_submit" type="submit" class="news_theme__buttons__select"
										   value="絞り込む">
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>
				<?php if ( isset( $_GET['theme'] ) && is_array( $_GET['theme'] ) ): ?>
					<a href="<?php echo home_url( '/lgnews/' ); ?>" class="knows_map__bar__reset_button">検索条件をリセット</a>
					<div class="select_themes_bar">
						<ul class="clearfix">
							<?php
							foreach ( $_GET['theme'] as $t ):
								$term = get_term_by( 'slug', $t, 'project_theme' );
								if ( $term ):
									?>
									<li>
										<a href="<?php echo home_url( '/project_theme/' . $term->slug ); ?>"><?php echo $term->name; ?></a>
									</li>
									<?php
								endif;
							endforeach;
							?>
						</ul>
					</div>
				<?php elseif ( is_page( 'lgnews' )): ?>
					<a href="<?php echo home_url( '/lgnews/' ); ?>" class="knows_map__bar__reset_button">検索条件をリセット</a>
				<?php endif; ?>
				<input type="hidden" name="paged" value="1"/>
			</form>
		</div>
	</div>

	<?php if ( ! wp_is_mobile() && is_post_type_archive( 'event' ) ) { ?>
		<?php $search_keyword = $_GET['keyword']; ?>
		<div class="knows_map__filter">
			<ul class="knows_map__filter--left">
				<li class="knows_map__filter--text">キーワード</li>
				<li>
					<form action="" method="get"><input type="hidden" name="searchFrom" value="text"><input
							value="<?php echo esc_html( $search_keyword ); ?>" id="eventSearchInput" name="keyword"
							type="text"
							placeholder="エリア、イベント名など" class="knows_map__filter--inp_tex">
				</li>
				<li><input id="eventSearchSubmit" type="submit"
						   class="knows_map__filter--button knows_map__filter--inp_btn" value="検索"></form></li>
				<li><a href="" class="knows_map__filter--link" id="filterSearch"><span class="icon">+</span>詳細検索</a>
				</li>
			</ul>
			<ul class="knows_map__filter--right  knowsMapFilter">
				<li class="knows_map__filter--text">絞り込み</li>
				<li>
					<label for="mapFilter-place" class="knows_map__filter--label">
						<input type="checkbox" name="show" value="place" id="mapFilter-place" checked="checked"
							   class="knows_map__filter--inp_radio togglePin checkbox"><span
							class="knows_map__filter--inp_radio--parts parts"></span>
						<span class="text">みんなの拠点</span>
					</label>
				</li>
				<li>
					<label for="mapFilter-event" class="knows_map__filter--label">
						<input type="checkbox" name="show" value="event" id="mapFilter-event" checked="checked"
							   class="knows_map__filter--inp_radio togglePin checkbox"><span
							class="knows_map__filter--inp_radio--parts parts"></span>
						<span class="text">イベント</span>
					</label>
				</li>
			</ul>
		</div>
		<?php
	}
}

function lg_body_class( $class = '' ) {
	if ( DEVICE == 'sp' ) {
		$device = 'sp';
	} else {
		$device = 'pc';
	}

	echo 'class="' . join( ' ', get_body_class( $class ) ) . ' ' . $device . '"';
}

function template_panel() {
	?>

	<div class="template_panel">
		<div class="close_button">
			×
		</div>
		<div class="template_panel__select">
			<button>このあたりは　 が多い</button>
			<div class="template_sample">
				例：このあたりは道路沿いにアジサイが多い, このあたりは人が住んでいない家が多い
			</div>
		</div>

		<div class="template_panel__select">
			<button>このあたりは　 が少ない</button>
			<div class="template_sample">
				例：このあたりは自動販売機が少ない, このあたりは人通りが少ない
			</div>
		</div>

		<div class="template_panel__select">
			<button>このあたりは　 がない</button>
			<div class="template_sample">
				例：このあたりはスーパーがない, このあたりは駐車場がない
			</div>
		</div>

		<div class="template_panel__select">
			<button>このあたりは　　困る</button>
			<div class="template_sample">
				例：このあたりは歩道が狭くて困る, このあたりは夜騒ぐ人が多くて困る
			</div>
		</div>

		<div class="template_panel__select">
			<button>もっと　　ほしい</button>
			<div class="template_sample">
				例：もっと公民館の会議室の使用料をやすくしてほしい, もっと並木の手入れをしっかり行ってほしい
			</div>
		</div>

		<div class="template_panel__select">
			<button>このあたりは　　が有名</button>
			<div class="template_sample">
				例：このあたりの駅前の銅像が有名, このあたりの桜並木が有名

			</div>
		</div>

		<div class="template_panel__select">
			<button>このあたりは　　がすてき</button>
			<div class="template_sample">
				例：このあたりの海岸から見える夕日がすてき, このあたりの小物屋さんが売っている手作りキーホルダーがすてき

			</div>
		</div>

	</div><!-- /.template_panel -->

	<?php
}

function lg_post_excerpt() {
	global $cfs;
	$lg_post_excerpt = $cfs->get( 'lg_post_excerpt' );
	if ( ! $lg_post_excerpt ) {
		$lg_post_excerpt = shorten( get_the_excerpt(), '46' );
	}

	return $lg_post_excerpt;
}

function event_box() {
	global $post;
	$cf          = get_post_custom( $post->ID );
	$data_lonlat = get_post_lonlat_attr();
	if ( ! $data_lonlat ) {
		//位置情報の後方互換
		if ( ! empty( $cf['sbLatLng'] ) && ( strpos( $cf['sbLatLng'][0], ',' ) > 0 ) ) {
			$latlng      = explode( ',', $cf['sbLatLng'][0] );
			$data_lonlat = 'data-long="' . $latlng[1] . '" data-lat="' . $latlng[0] . '"';
		}
	}
	$data_meta = get_post_meta_attr();
	if ( DEVICE == 'pc' ):
		?>
		<section class="event_box common_box" <?php echo $data_lonlat; ?>  <?php echo $data_meta; ?>>
			<a class="event_box__thumbnail"
			   href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'archive-thumbnails' ); ?></a>
			<div class="event_box__texts">
				<a href="<?php the_permalink(); ?>">
					<h2 class="event_box__title"><?php echo shorten( get_the_title(), '34' ); ?></h2>
					<p class="event_box__excerpt">
						<?php
						if ( ! empty( $cf['event_sub_title'] ) && ! empty( $cf['event_sub_title'][0] ) ):
							echo shorten( $cf['event_sub_title'][0], 45 );
						endif;
						?>
					</p>
					<?php
					if ( ! empty( $cf['event_display_date'] ) && ! empty( $cf['event_display_date'][0] ) ):
						?>
						<dl class="event_box__date">
							<dt>日時:</dt>
							<dd><p><?php echo $cf['event_display_date'][0]; ?></p></dd>
						</dl>
						<?php
					endif;
					?>
					<?php
					if ( ! empty( $cf['event_place'] ) && ! empty( $cf['event_place'][0] ) ):
						?>
						<dl class="event_box__place">
							<dt>場所:</dt>
							<dd><p><?php echo $cf['event_place'][0]; ?></p></dd>
						</dl>
						<?php
					endif;
					?>
				</a>
				<div class="event_box__tags">
					<?php
					if ( ! empty( $cf['event_date'] ) && ! empty( $cf['event_date'][0] ) && strtotime( $cf['event_date'][0] ) ):
						if ( strtotime( date( 'Y-m-d' ) ) <= strtotime( $cf['event_date'][0] ) ) {
							?>
							<span class="c-event_status">
                                        <?php
                                        echo '開催予定';
                                        ?>
                                    </span>
							<?php
						} else {
							?>
							<span class="c-event_status end">
                                        <?php
                                        echo '終了';
                                        ?>
                                    </span>
							<?php
						}
					endif;
					?>
					<?php echo get_term_atag( get_post_type() ); ?>
				</div>
			</div><!-- /.article_box__texts -->
		</section><!-- /.event_box -->
	<?php else: ?>

		<section class="event_box event" <?php echo $data_lonlat; ?>  <?php echo $data_meta; ?>>
			<div class="list_inner">
				<div class="thumbnail">
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'single-main_visual' ); ?></a>
				</div>
				<div class="post_text-area">
					<h2 class="title"><a href="<?php the_permalink(); ?>"><?php echo shorten( get_the_title(), '44' ); ?></a>
					</h2>
					<?php echo get_term_atag( get_post_type() ); ?>
					<p class="event_box__excerpt">
						<?php
						if ( ! empty( $cf['event_sub_title'] ) && ! empty( $cf['event_sub_title'][0] ) ):
							echo shorten( $cf['event_sub_title'][0], 40 ) . '<br />';
						endif;
						?>
						<?php
						if ( ! empty( $cf['event_display_date'] ) && ! empty( $cf['event_display_date'][0] ) ):
							echo '日時:' . $cf['event_display_date'][0];
							if ( ! empty( $cf['event_date'] ) && ! empty( $cf['event_date'][0] ) && strtotime( $cf['event_date'][0] ) ):
								?>
								<?php
								if ( strtotime( date( 'Y-m-d' ) ) <= strtotime( $cf['event_date'][0] ) ) {
									?>
									<span class="c-event_status">
                                                        <?php
														echo '開催予定';
														?>
                                                </span>
									<?php
								} else {
									?>
									<span class="c-event_status end">
                                    <?php
									echo '終了';
									?>
                                    </span>
									<?php
								}
								?>
								<?php
							endif;
							echo '<br />';
						endif;
						?>
						<?php
						if ( ! empty( $cf['event_place'] ) && ! empty( $cf['event_place'][0] ) ):
							echo '場所:' . $cf['event_place'][0] . '<br />';
						endif;
						?>
					</p>
				</div>
			</div>
		</section><!-- /.event_box -->

		<?php
	endif;
}


// シェア用のテキストを生成
function generate_share_message( $echo = true ) {
	global $post;

	$current_post_type = get_post_type( $post );

	$is_tweet   = ( $current_post_type == 'tweet' );
	$is_subject = ( $current_post_type == 'subject' );

	if ( is_singular() && ( $is_tweet || $is_subject ) ? true : false ) {
		$cf                = get_post_custom( $post->ID );
		$subject_user_meta = get_subject_user_meta( $is_tweet, $cf );
		$author_name       = ( empty( $subject_user_meta['name'] ) ) ? '匿名' : $subject_user_meta['name'];
		$wp_title          = $author_name . ' - ' . $subject_user_meta['postdate'] . ' - ';
	} else {
		$wp_title = wp_title( '-', false, 'right' );
	}

	$site_name  = get_bloginfo( 'name' );
	$return_msg = $wp_title . $site_name;

	if ( $echo ) {
		echo $return_msg;
	} else {
		return $return_msg;
	}

}

function show_single_sns_icons( $class = '' ) {
	global $post;
	$sns_accounts = array(
		'twitter'  => get_post_meta( $post->ID, 'place_twitter', true ),
		'facebook' => get_post_meta( $post->ID, 'place_facebook', true ),
	);
	if ( ! empty( $sns_accounts['facebook'] ) && ! empty( $sns_accounts['facebook'] ) ):
		?>
		<div class="<?php echo $class ? $class : 'common_single_info_heading_area__sns'; ?>">
			<?php if ( ! empty( $sns_accounts['facebook'] ) ): ?><a href="<?php echo $sns_accounts['facebook']; ?>"
																	class="fb"
																	target="_blank"></a><?php endif; ?>
			<?php if ( ! empty( $sns_accounts['twitter'] ) ): ?><a
				href="https://twitter.com/<?php echo $sns_accounts['twitter']; ?>"
				class="tw" target="_blank"></a><?php endif; ?>
		</div>
		<?php
	endif;
}

function event_meta() {
	global $cfs, $post;
	?>
	<div class="event_meta">
		<table>
			<tbody>
			<?php
			if ( $cfs->get( 'event_display_date' ) ):
				?>
				<tr>
					<th>日時</th>
					<td><?php echo $cfs->get( 'event_display_date' ); ?></td>
				</tr>
				<?php
			endif;
			$place_ids = get_post_meta( $post->ID, 'place_id', false );
			if ( $place_ids ):
				?>
				<tr>
					<th>場所</th>
					<td>
						<?php
						foreach ( $place_ids as $place_id ) :
							$permalink = get_post_permalink( $place_id );
							?>
							<a href="<?php echo $permalink; ?>"
							   class="place_link"><?php echo get_the_title( $place_id ) ?></a>
							<?php
						endforeach;
						?>
					</td>
				</tr>
				<?php
			elseif ( $cfs->get( 'event_place' ) ):
				?>
				<tr>
					<th>場所</th>
					<td><?php echo $cfs->get( 'event_place' ); ?></td>
				</tr>
				<?php
			endif;
			if ( $cfs->get( 'event_target' ) ):
				?>
				<tr>
					<th>対象</th>
					<td><?php echo $cfs->get( 'event_target' ); ?></td>
				</tr>
				<?php
			endif;
			if ( $cfs->get( 'event_fee' ) ):
				?>
				<tr>
					<th>費用</th>
					<td><?php echo $cfs->get( 'event_fee' ); ?></td>
				</tr>
				<?php
			endif;
			if ( $cfs->get( 'event_url' ) ):
				?>
				<tr>
					<th>URL</th>
					<td><a href="<?php echo $cfs->get( 'event_url' ); ?>"
						   target="_blank"><?php echo $cfs->get( 'event_url' ); ?></a></td>
				</tr>
				<?php
			endif;
			if ( $cfs->get( 'event_facebook' ) ):
				?>
				<tr>
					<th>Facebook</th>
					<td><a href="<?php echo $cfs->get( 'event_facebook' ); ?>"
						   target="_blank"><?php echo $cfs->get( 'event_facebook' ); ?></a></td>
				</tr>
				<?php
			endif;
			if ( $cfs->get( 'event_twitter' ) ):
				?>
				<tr>
					<th>twitter</th>
					<td><a href="http://twitter.com/<?php echo $cfs->get( 'event_twitter' ); ?>"
						   target="_blank">@<?php echo $cfs->get( 'event_twitter' ); ?></a></td>
				</tr>
				<?php
			endif;
			if ( $cfs->get( 'event_host' ) ):
				?>
				<tr>
					<th>開催団体</th>
					<td><?php echo $cfs->get( 'event_host' ); ?></td>
				</tr>
				<?php
			endif;
			if ( $cfs->get( 'event_contact' ) ):
				?>
				<tr>
					<th>お申し込み・お問い合わせ</th>
					<td><?php echo $cfs->get( 'event_contact' ); ?></td>
				</tr>
				<?php
			endif;
			?>
			</tbody>
		</table>
	</div><!-- .event_meta -->
	<?php
}

/**
 * @param object $post WP Post Object
 * @param string $sns 表示したい SNS サービス名
 * @param string $account $sns のアカウント
 */
function get_sns_timeline( $post, $sns, $account ) {

	switch ( $sns ) {
		case 'facebook':
			echo '<div id="fb-root"></div>';
			echo <<<EOF
<script>(function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.10";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>
EOF;

			echo <<<EOF
<div class="fb-page" data-href="$account"
	 data-tabs="timeline"
	 data-small-header="true" data-adapt-container-width="true"
	 data-hide-cover="false"
	 data-show-facepile="true" data-width="500" data-height="500">
	<blockquote cite="$account"
				class="fb-xfbml-parse-ignore"><a
			href="$account">{$post->post_title}</a>
	</blockquote>
</div>
EOF;
			break;

		case 'twitter':
			echo <<<EOF
<a class="twitter-timeline" data-height="500" href="https://twitter.com/$account">Tweets by {$post->post_title}</a>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
EOF;
			break;
	}
}

function get_place_metas( $post = false ) {
	if ( ! $post ) {
		global $post;
	}

	$place_meta = array(
		array(
			'label' => '運営者',
			'value' => ( ! empty( get_post_meta( $post->ID, 'place_owner', true ) ) ) ? get_post_meta( $post->ID, 'place_owner', true ) : false,
		),
		array(
			'label' => '住所',
			'value' => ( ! empty( get_post_meta( $post->ID, 'place_address', true ) ) ) ? get_post_meta( $post->ID, 'place_address', true ) : false,
		),
		array(
			'label' => 'ウェブサイト',
			'value' => ( ! empty( get_post_meta( $post->ID, 'place_web', true ) ) ) ? '<a href="' . get_post_meta( $post->ID, 'place_web', true ) . '" target="_blank">' . get_post_meta( $post->ID, 'place_web', true ) . '</a>' : false,
		),
		array(
			'label' => 'メールアドレス',
			'value' => ( ! empty( get_post_meta( $post->ID, 'place_mail', true ) ) ) ? get_post_meta( $post->ID, 'place_mail', true )  : false,
		),
		array(
			'label' => '電話番号',
			'value' => ( ! empty( get_post_meta( $post->ID, 'place_tel', true ) ) ) ? get_post_meta( $post->ID, 'place_tel', true ) : false,
		),
		array(
			'label' => '利用方法',
			'value' => ( ! empty( get_post_meta( $post->ID, 'place_usage', true ) ) ) ? get_post_meta( $post->ID, 'place_usage', true ) : false,
		),
		array(
			'label' => '費用',
			'value' => ( ! empty( get_post_meta( $post->ID, 'place_fee', true ) ) ) ? get_post_meta( $post->ID, 'place_fee', true ) : false,
		),
	);

	return $place_meta;
}
