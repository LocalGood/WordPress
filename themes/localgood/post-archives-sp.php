<?php
/*

Template Name: post-archives-sp

*/
get_header(); ?>

	<div class="post underlayer_wrapper">
		<?php include( 's-post_nav.php' ); ?>
		<div>

			<div class="contents_wrapper02">

				<?php knows_map_bar(); ?>
				<div id="gmap"></div>

				<div class="category_list">
					<?php
					global $post, $paged;
					$post_not     = array();
					$feature_html = '';
					if ( ! isset( $_GET['project_area'] ) && ! isset( $_GET['theme'] ) && $paged <= 1 ) :
						$feature_post = new WP_Query( feature_posts_args() );
						if ( $feature_post->have_posts() ):
							ob_start();
							?>
							<h2 class="c-group_title01">PICK UP!</h2>
							<?php
							while ( $feature_post->have_posts() ):
								$feature_post->the_post();
								array_push( $post_not, $post->ID );
								article_box();
							endwhile;
							$feature_html = ob_get_contents();
							ob_clean();
						endif;
					endif;
					wp_reset_postdata();
					if ( is_page( 'lgnews' ) ) {
						echo $feature_html;
					}

					query_posts( post_archives_args( $post_not ) );
					if ( have_posts() ):
						?>
						<h2 class="c-group_title01">
							<?php the_title(); ?>
						</h2>
						<div class="list_pic_wrapper">
							<div class="list_pic">
								<div class="list_pic_layout">
									<?php
									while ( have_posts() ): the_post();
										article_box();
									endwhile;
									?>
								</div>
								<div class="pager">
									<div class="pager_container">
										<div class="tablenav">
											<?php
											paging();
											?>
										</div>
									</div>
								</div>
							</div><!--.list_pic-->
						</div><!--.list_pic_wrapper-->
					<?php endif; ?>
					<?php
					wp_reset_query();
					if ( is_page( 'lgplayer' ) ) {
						echo $feature_html;
					}
					?>
				</div>
			</div>
		</div><!--.contents_wrapper-->
	</div>
<?php
get_template_part( 'footer', 'sp' );
?>