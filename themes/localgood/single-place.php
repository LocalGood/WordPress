<?php
if ( DEVICE == 'sp' ) :
	// スマホ
	get_template_part( 'single', 'place-sp' );
else :
	get_header();
	global $post;
	$eps_paged    = get_query_var( 'eps', 1 );
	$sns_accounts = array(
		'twitter'  => get_post_meta( $post->ID, 'place_twitter', true ),
		'facebook' => get_post_meta( $post->ID, 'place_facebook', true ),
	);
	?>

	<div class="c-contents_wrapper c-w1096">
		<?php if ( have_posts() ) : the_post();
			global $post, $cfs;
			$self_post_obj = $post;
			$self_post_id = $self_post_obj->ID;
			?>
			<?php breadcrumbs(); ?>

			<div class="c-page_title_wrapper">
				<h2 class="c-page_title c-title05">みんなの拠点</h2>
			</div>
			<div class="common_single_info_heading_area">
				<div class="common_single_info_heading_area__base_info">
					<div class="common_single_info_heading_area__thumbnail">
						<?php
						$thumb = 'single-main_visual';
						the_post_thumbnail( $thumb );
						?>
					</div>
					<div>
						<div class="common_single_info_heading_area__flex">
							<h3 class="single__title c-title05"><?php the_title(); ?></h3>
							<?php if ( get_post_meta( $post->ID, 'place_sub_title', true ) ) : ?>
								<p class=""><?php echo get_post_meta( $post->ID, 'place_sub_title', true ); ?></p>
							<?php endif; ?>
							<?php show_single_sns_icons(); ?>
						</div>
						<div class="common_single_info_heading_area__tags">
							<?php
							$tags = get_term_atag( $post->post_type, false );
							foreach ( $tags as $tag ) {
								echo '<span>' . $tag . '</span>';
							}
							?>
						</div>
					</div>
				</div>

				<div class="common_single_info_heading_area__text">
					<p class="single__description">
						<?php
						$_content = get_the_content();
						$content  = apply_filters( 'the_content', $_content );
						the_content();
						?>
					</p>

					<h4>拠点情報</h4>
					<dl class="single__information">
						<?php
						$place_meta = get_place_metas( $self_post_obj );
						foreach ( $place_meta as $meta_data ) :
							if ( $meta_data['value'] ) :
								?>
								<dt><?php echo $meta_data['label']; ?></dt>
								<dd><?php echo $meta_data['value']; ?></dd>
								<?php
							endif;
						endforeach; ?>
					</dl>
				</div>
			</div>
			<?php if ( $eps_paged && 1 === $eps_paged ) : ?>

				<?php if ( ! empty( $sns_accounts['twitter'] ) || ! empty( $sns_accounts['facebook'] ) ) : ?>
					<div class="common_single_timeline">
						<h2 class="c-group_title01"><?php the_title(); ?>さんの最新情報</h2>
						<div class="common_single_timeline__inner">

							<?php if ( ! empty( $sns_accounts['twitter'] ) && ! empty( $sns_accounts['facebook'] ) ) : ?>
							<div class="common_single_timeline__wrapper">
								<?php endif; ?>
								<?php if ( ! empty( $sns_accounts['twitter'] ) ) : ?>
									<div class="common_single_timeline__widget tw">
										<?php get_sns_timeline( $post, 'twitter', $sns_accounts['twitter'] ); ?>
									</div>
								<?php endif; ?>

								<?php if ( ! empty( $sns_accounts['facebook'] ) ) : ?>
									<div class="common_single_timeline__widget fb">
										<?php get_sns_timeline( $post, 'facebook', $sns_accounts['facebook'] ); ?>
									</div>
								<?php endif; ?>
								<?php if ( ! empty( $sns_accounts['twitter'] ) && ! empty( $sns_accounts['facebook'] ) ) : ?>
							</div>
						<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>

				<div class="common_single_gmap">
					<h2 class="c-group_title01"><?php the_title(); ?>さんの場所</h2>
					<div class="side_block gmap">
						<?php
						$data_lonlat = get_post_lonlat_attr();
						if ( ! empty( $data_lonlat ) ) :
							?>
							<div id="gmap" <?php echo $data_lonlat; ?> style="height: 400px;margin-bottom:20px;"
								 data-type="<?php echo esc_html( $post->post_type ); ?>"
								 data-title="<?php the_title(); ?>"></div>
							<?php
						endif;
						?>
					</div>
				</div>
			<?php endif; ?>
		<?php endif; ?>
		<?php

		$args = array(
			'post_type'      => array( 'event' ),
			'meta_key'       => 'event_date',
			'orderby'        => 'meta_value',
			'order'          => 'asc',
			'meta_query'     => array(
				array(
					'key'     => 'place_id',
					'value'   => $post->ID,
					'compare' => 'IN',
				),
				array(
					'key'     => 'event_date',
					'value'   => date( 'Y-m-d' ),
					'compare' => '>=',
				),
				'relation' => 'AND',
			),
			'posts_per_page' => 9,
			'paged'          => $eps_paged,
		);

		$place_events = new WP_Query( $args );
		if ( $place_events->have_posts() ) : ?>
			<div class="article_area">
				<h2 class="c-group_title01"><?php the_title(); ?>さんで開催のイベント</h2>
				<div class="article_box__wrapper">
					<?php
					while ( $place_events->have_posts() ) :
						$place_events->the_post();
						event_box();
					endwhile;
					?>
				</div>
			</div>
			<?php
		endif;
		?>
		<div class="c-pager c-clearfix">
			<div class="c-pager_container">
				<?php
				$pager_options = array(
					'paginate_base'   => get_permalink( $self_post_id ) . '%_%',
					'paginate_format' => '?eps=%#%',
					'current'         => $eps_paged,
				);
				paging( $place_events, $pager_options );
				?>
			</div>
		</div>

		<?php
		$photos = get_post_meta( $self_post_id, 'place_photo', false );
		if ( ! empty( $photos ) ) :
			?>
			<div class="article_area photo_gallery">
				<?php
				foreach ( $photos as $photo ) :
					$image = wp_get_attachment_image_src( $photo, 'medium' );
					$full_image = wp_get_attachment_image_src( $photo, 'full' );
					$meta = strip_tags( get_post_meta( $photo, '_wp_attachment_image_alt', true ) );
					?>
					<a href="<?php echo $full_image[0]; ?>" target="_blank"><img src="<?php echo $image[0]; ?>" alt=""></a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div><!-- .c-contents_wrapper -->
	<?php
	get_footer();
endif;
?>
