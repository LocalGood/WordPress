<?php get_header(); ?>
	<div class="underlayer_wrapper">
		<div class="contents_wrapper">

			<div class="inner">
				<?php breadcrumbs(); ?>
			</div>

			<?php global $post; ?>

			<div class="archive_all">
				<div class="post_title">
					<h1><?php single_term_title(); ?></h1>
					<?php echo term_description(); ?>
				</div>
			</div><!-- .archive_all -->

			<?php
			$queried_object = get_queried_object();

			$args         = array(
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
			$custom_posts = new WP_Query( $args );

			if ( $custom_posts->have_posts() ) : ?>
				<div class="list_pic_wrapper">
					<div class="list_pic">
						<div class="list_pic_layout">
							<?php
							while ( $custom_posts->have_posts() ) : $custom_posts->the_post();
								article_box();
							endwhile;
							?>
							<div class="pager" style="clear: both">
								<div class="pager_container">
									<?php paging( $custom_posts ); ?>
								</div>
							</div>
							<div style="clear: both"></div>
						</div>
					</div><!--.list_pic-->
				</div><!--.list_pic_wrapper-->
				<?php
			endif;
			?>
		</div><!-- .contents_wrapper -->
	</div>
<?php get_template_part( 'footer', 'sp' );
