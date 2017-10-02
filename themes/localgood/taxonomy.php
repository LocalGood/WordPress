<?php
if ( DEVICE == 'sp' ):
	// スマホ
	get_template_part( 'taxonomy', 'sp' );
else:
	get_header(); ?>
	<div class="c-contents_wrapper c-w1096">
		<?php breadcrumbs(); ?>
		<div class="c-page_title_wrapper">
			<h2 class="c-page_title c-title05"><?php single_term_title(); ?></h2>
			<p class="c-page_title_subtext"><?= term_description(); ?></p>
		</div>
		<?php
		global $post;
		if ( have_posts() ): ?>
			<div class="article_area">
				<div class="article_box__wrapper">
					<?php
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
				</div>
				<div class="c-pager c-clearfix">
					<div class="c-pager_container">
						<?php
						paging();
						?>
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
?>