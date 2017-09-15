<?php
if ( DEVICE == 'sp' ):
	// スマホ
	get_template_part( 'single', 'organizer-sp' );
else:
	get_header();
	?>
	<div class="c-contents_wrapper c-w1096">
		<?php if ( have_posts() ): the_post();
			global $post, $cfs;
			?>
			<?php breadcrumbs(); ?>
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
				</div>
			</div>
		<?php endif; ?>
		<?php
		$eps_paged = get_query_var( 'eps', 1 );
		$args = array(
			'post_type'      => array( 'event' ),
			'meta_key'       => 'event_date',
			'orderby'        => 'meta_value',
			'order'          => 'asc',
			'meta_query'     => array(
				array(
					'key'     => 'organizer_id',
					'value'   => $post->ID,
					'compare' => 'IN',
				),
			),
			'posts_per_page' => 12,
			'paged'          => $eps_paged,
		);
		$organizer_events = new WP_Query( $args );
		if ( $organizer_events->have_posts() ) : ?>
			<div class="article_area">
				<h2 class="c-group_title01"><?php the_title(); ?>さんが主催のイベント</h2>
				<div class="article_box__wrapper">
					<?php
					while ( $organizer_events->have_posts() ) :
						$organizer_events->the_post();
						event_box();
					endwhile;
					?>
				</div>
			</div>
			<div class="c-pager c-clearfix">
				<div class="c-pager_container">
					<?php
					$pager_options = array(
						'paginate_base'   => get_permalink( $self_post_id ) . '%_%',
						'paginate_format' => '?eps=%#%',
						'current'         => $eps_paged,
					);
					paging( $organizer_events, $pager_options );
					?>
				</div>
			</div>
			<?php
		endif;
		?>
	</div><!-- .c-contents_wrapper -->
	<?php
	get_footer();
endif;
?>