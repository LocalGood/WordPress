<?php get_header(); ?>
	<div class="underlayer_wrapper">
		<?php include( 's-post_nav.php' ); ?>
        <?php breadcrumbs(); ?>
		<?php if ( have_posts() ): the_post();
			global $post, $cfs;
			$event_type = get_the_terms( $post->ID, 'event_type' );
			?>
			<div class="contents_wrapper">
				<div class="inner">
					<div class="single_contents_box">
						<div class="inner">
							<div class="sp-post_wrapper">
								<div class="post_wrapper">
									<div class="post_title cf">
										<h1><?php the_title(); ?></h1>

										<p class="single__description"><?php
											if ( $cfs->get( 'event_sub_title' ) ) {
												echo $cfs->get( 'event_sub_title' );
											}
											?>
										</p>

										<div class="clearfix">
											<?php echo get_term_atag( $post->post_type ); ?>
											<?php
											if ( $cfs->get( 'event_date' ) && strtotime( $cfs->get( 'event_date' ) ) ) :
												if ( time() <= strtotime( $cfs->get( 'event_date' ) . ' 23:59:59' ) ) {
													?>
													<p class="c-event_status">
														<?php
														echo '開催予定';
														?>
													</p>
													<?php
												} else {
													?>
													<p class="c-event_status end">
														<?php
														echo '終了';
														?>
													</p>
													<?php
												}
											endif;
											?>

											<?php
											if ( ! empty( $tags ) ) : ?>
												<p class="tags">
													<?php foreach ( $tags as $tag ) :
														?>
														<span><a
																href="<?php echo get_term_link( $tag ); ?>"><?php echo $tag->name; ?></a></span>
														<?php
													endforeach; ?>
												</p>
												<?php
											endif;
											?>
										</div><!-- /.clearfix -->

										<?php social_buttons(); ?>
										<div class="single__eyecatch">
											<?php
											$thumb = 'single-main_visual';
											the_post_thumbnail( $thumb );
											?>
										</div>
									</div>
								</div>
							</div><!-- /.sp-post_wrapper -->

							<div class="single__post_body">
								<?php
								$_content = get_the_content();
								$content  = apply_filters( 'the_content', $_content );
								the_content();
								?>
								<?php event_meta(); ?>
							</div><!-- /.post_body -->

							<div class="side_block gmap">
								<?php
								$data_lonlat = get_post_lonlat_attr();
								if ( ! empty( $data_lonlat ) ):
									?>
									<div id="gmap" <?php echo $data_lonlat; ?> style="height: 400px;margin-bottom:20px;" data-type="<?php echo esc_html( $post->post_type ); ?>"
									     data-title="<?php the_title(); ?>"></div>
									<?php
								endif;
								?>
							</div>
						</div>
					</div><!-- .single_contents_box -->

					<?php
					$organizer_ids = get_post_meta( $post->ID, 'organizer_id', false );
					if ( $organizer_ids ) : ?>
					<div class="common_single_parts_info">
						<h2 class="common_single_parts_info__title">主催者紹介</h2>
						<?php
						foreach ( $organizer_ids as $organizer_id ) :
							$post = get_post( $organizer_id );
							setup_postdata( $post );
							$permalink    = get_post_permalink();
							$sns_accounts = array(
								'twitter'  => get_post_meta( $organizer_id, 'organizer_twitter', true ),
								'facebook' => get_post_meta( $organizer_id, 'organizer_facebook', true ),
							);
							?>
							<div class="common_single_parts_info__heading">
								<div class="common_single_parts_info__thumbnail">
									<?php the_post_thumbnail( 'thumbnail' ); ?>
								</div>
								<div class="common_single_parts_info__text">
									<h2 class="title"><?php the_title(); ?></h2>
									<a href="<?php echo $permalink; ?>">詳細を見る ></a>
								</div>
							</div>
							<div class="common_single_parts_info__description">
								<?php echo wp_trim_words( get_the_content(), '150', '[...]' ); ?>
							</div>
							<div class="common_single_parts_info__sns">
								<?php if ( ! empty( $sns_accounts['facebook'] ) ) : ?>
									<a href="<?php echo $sns_accounts['facebook']; ?>">
										<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/writer_fb_on.png" alt="">
									</a>
								<?php else : ?>
									<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/writer_fb_off.png" alt="">
								<?php endif; ?>

								<?php if ( ! empty( $sns_accounts['twitter'] ) ) : ?>
									<a href="<?php echo $sns_accounts['twitter']; ?>">
										<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/writer_tw_on.png" alt="">
									</a>
								<?php else : ?>
									<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/writer_tw_off.png" alt="">
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
						<?php endif; ?>

					</div>

					<a href="/event/" class="return_news_list">
						イベント一覧へ戻る
					</a>

				</div><!-- .inner -->
				<?php related_posts(); ?>
			</div><!-- .contents_wrapper -->
		<?php endif; ?>
	</div>
<?php get_template_part( 'footer', 'sp' ); ?>
