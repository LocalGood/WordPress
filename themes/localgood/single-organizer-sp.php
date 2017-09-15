<?php
get_header();
?>

	<div class="underlayer_wrapper">
		<?php if ( have_posts() ): the_post();
			global $post, $cfs;
			?>

			<?php breadcrumbs(); ?>

			<div class="sp_common_single_info_heading_area">
				<div class="title_wrapper">
					<div class="sp_common_single_info_heading_area__thumbnail">
						<?php
						$thumb = 'single-main_visual';
						the_post_thumbnail( $thumb );
						?>
					</div>
					<h3 class="sp_common_single_info_heading_area__text__title"><?php the_title(); ?></h3>
				</div>

				<div class="sp_common_single_info_heading_area__description">
					<?php
					$_content = get_the_content();
					$content  = apply_filters( 'the_content', $_content );
					the_content();
					?>
				</div>
				<? show_single_sns_icons( "sp_common_single_info_heading_area__sns" ); ?>
			</div>

			<?php
			$twitter_account = get_post_meta( $post->ID, 'place_twitter', true );
			if ( ! empty( $twitter_account ) ):
				?>
				<div class="common_single_timeline">
					<h2 class="c-group_title01"><?php the_title(); ?>さんの最新情報</h2>
					<div class="common_single_timeline__inner">
						<a class="twitter-timeline" data-height="380" href="https://twitter.com/<?php echo $twitter_account; ?>">Tweets
							by <?php the_title(); ?></a>
						<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
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
				'key'     => 'organizer_id',
				'value'   => $post->ID,
				'compare' => 'IN'
			),
			'posts_per_page' => 9
		);
		query_posts( $args );
		if ( have_posts() ):?>
			<div class="list_pic_wrapper">
				<h2 class="c-group_title01"><?php the_title(); ?>さんが主催のイベント</h2>
				<div class="list_pic">
					<div class="list_pic_layout">
						<?php
						while ( have_posts() ): the_post();
							global $post;
							event_box();
						endwhile; ?>
						<div class="pager" style="clear: both">
							<div class="pager_container">
								<?php
								paging();
								?>
							</div>
						</div>
						<div style="clear: both"></div>
					</div>
				</div><!--.list_pic-->
			</div><!--.list_pic_wrapper-->
			<?php
		endif;
		?>
	</div><!-- .c-contents_wrapper -->

<?php
get_template_part( 'footer', 'sp' );
?>