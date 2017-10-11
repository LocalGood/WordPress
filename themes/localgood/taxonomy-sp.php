<?php get_header(); ?>
	<div class="underlayer_wrapper">
		<div class="inner">
			<?php breadcrumbs(); ?>
		</div>
		<div class="archive_all">
			<div class="post_title">
				<h1 class="common_underlayer_title-h2">
                    <img src="<?php echo get_option( 'lg_config__page_ttl_prefix' ); ?>">
                    <?php single_term_title(); ?>
                </h1>
				<?php echo term_description(); ?>
			</div>
		</div><!-- .archive_all -->
		<?php if ( have_posts() ): ?>
			<div class="list_pic_wrapper">
				<div class="list_pic">
					<div class="list_pic_layout">
						<?php
						global $post;
						while ( have_posts() ): the_post();
							if ( $post->post_type === 'place' ) {
								place_box();
							} else if ( $post->post_type === 'event' ) {
								event_box();
							} else {
								article_box();
							}
						endwhile;
						?>
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
	</div><!-- .contents_wrapper -->
<?php
get_template_part( 'footer', 'sp' );