<?php
if ( DEVICE == 'sp' ):
	// スマホ
	get_template_part( 'single', 'event-sp' );
else:
	get_header();
	?>

	<div class="c-contents_wrapper c-w1096">

		<?php if ( have_posts() ): the_post();
			global $post, $cfs;
			?>
			<?php breadcrumbs(); ?>
			<div class="c-page_title_wrapper">
				<h2 class="c-page_title c-title05">イベント</h2>
			</div>
			<div class="single_contents_box">
				<div class="single__title_area">
					<h3 class="single__title c-title05"><?php the_title(); ?></h3>
					<p class="single__description"><?php
						if ( $cfs->get( 'event_sub_title' ) ) {
							echo $cfs->get( 'event_sub_title' );
						}
						?>
					</p>
					<div class="single_head_info_area">
					<?php echo get_term_atag( $post->post_type ); ?>
					<?php
					if ( $cfs->get( 'event_date' ) && strtotime( $cfs->get( 'event_date' ) ) ):
						if ( time() <= strtotime( $cfs->get( 'event_date' ) . ' 23:59:59' ) ) {
							?>
							<p class="c-event_status c-cat">
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
					</div>

					<div class="single_head_social_buttons">
					<?php
					social_buttons();
					?>
					</div>

					<div class="single__eyecatch">
						<?php
						$thumb = 'single-main_visual';
						the_post_thumbnail( $thumb );
						?>
					</div>
				</div><!-- /.post_title -->
				<div class="single__post_body">
					<?php
					$_content = get_the_content();
					$content  = apply_filters( 'the_content', $_content );
					the_content();
					?>
					<?php event_meta();?>
				</div><!-- /.post_body -->

				<div class="side_block gmap">
					<?php
					$data_lonlat = get_post_lonlat_attr();
					if ( ! empty( $data_lonlat ) ):
						?>
						<div id="gmap" <?= $data_lonlat; ?> style="height: 400px;margin-bottom:20px;" data-type="<?= esc_html( $post->post_type ); ?>"
						     data-title="<?php the_title(); ?>"></div>
						<?php
					endif;
					?>
				</div>
				<?php social_buttons( false, false ); ?>
			</div><!-- .single_contents_box -->

			<?php
			$organizer_ids = get_post_meta( $post->ID, 'organizer_id', false );
			if ( $organizer_ids ):?>
				<div class="common_single_parts_info">
					<h3 class="common_single_parts_info--title title">主催者情報</h3>
					<?php
					foreach ( $organizer_ids as $organizer_id ) :
						$post = get_post( $organizer_id );
						setup_postdata( $post );
						$permalink = get_post_permalink();
						?>
						<div class="common_single_parts_info--heading">
							<div class="common_single_parts_info--thumbnail">
								<a href="<?php echo $permalink; ?>">
									<?php the_post_thumbnail() ?>
								</a>
							</div>
							<div class="common_single_parts_info--name">
								<h3 class="title">
									<a href="<?php echo $permalink; ?>">
										<?php the_title(); ?>
									</a>
								</h3>
								<a href="<?php echo $permalink; ?>" class="common_single_parts_info--link">詳細を見る></a>
							</div>
						</div>
						<div class="common_single_parts_info--description">
							<?php the_excerpt(); ?>
						</div>
						<?php show_single_sns_icons( "common_single_parts_info--sns" ); ?>
						<?php
					endforeach; ?>
				</div>
				<?php
			endif;
			?>


			<a class="c-back_button" href="<?= home_url( '/event/' ); ?>">イベント一覧へ戻る</a>
		<?php endif; ?>

	</div><!-- .c-contents_wrapper -->

	<?php
	get_footer();
endif;
?>