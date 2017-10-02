<?php
if ( 'sp' === DEVICE ) :
	// スマホ
	get_template_part( 'taxonomy', 'project_spot-sp' );
else :
	get_header(); ?>

	<div class="c-contents_wrapper c-w1096">

		<?php breadcrumbs(); ?>

		<?php global $post; ?>

		<div class="c-page_title_wrapper">
			<h2 class="c-page_title c-title05"><?php single_term_title(); ?></h2>
			<p class="c-page_title_subtext"><?php echo term_description(); ?></p>
		</div>

		<?php
		$queried_object = get_queried_object();

		$args           = array(
			'posts_per_page' => 15,
			'post_type'      => $post->post_type,
			'tax_query'      => array(
				array(
					'taxonomy' => $queried_object->taxonomy,
					'field'    => 'slug',
					'terms'    => $queried_object->slug,
					'operator' => 'IN',
				),
			),
			'paged'          => get_query_var( 'paged', 1 ),
		);
		$custom_posts   = new WP_Query( $args );

		if ( $custom_posts->have_posts() ) : ?>
			<div class="article_area">
				<div class="article_box__wrapper">
					<?php
					while ( $custom_posts->have_posts() ) : $custom_posts->the_post();
						article_box();
					endwhile;
					wp_reset_postdata();
					?>
				</div>
				<div class="c-pager c-clearfix">
					<div class="c-pager_container">
						<?php paging( $custom_posts ); ?>
					</div>
				</div>
			</div>
			<?php
		endif;
		?>
	</div><!-- .c-contents_wrapper -->
	<?php
	get_footer();
endif;
