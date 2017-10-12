<?php
if ( DEVICE == 'sp' ):
	// スマホ
	get_template_part( 'page', 'earth_view-sp' );
else:
	get_header(); ?>

	<div class="c-contents_wrapper c-w1096">

		<?php breadcrumbs(); ?>
		<div class="static_page">

			<div class="c-page_title_wrapper">
				<h2 class="c-page_title c-title05"><?php the_title(); ?></h2>
			</div>
			<div class="article_area">
				<h2 class="c-group_title01">エリア</h2>
				<div class="single_contents_box">
					<?php
					if ( have_posts() ): the_post();
						remove_filter( 'the_content', 'wpautop' );
						the_content();
					endif;
					?>
				</div>
			</div>

			<div class="article_area">
				<h2 class="c-group_title01">テーマ</h2>
				<div class="article_box__wrapper">
					<div class="single_contents_box">
						<?php echo get_post_meta( $post->ID, 'earth_view_area', true ) ?>
					</div><!--.theme_box-->
				</div>
			</div>

			<div class="article_area">
				<h2 class="c-group_title01"><?php echo LG_KANJI; ?>を読む</h2>
				<div class="article_box__wrapper">
					<div class="single_contents_box">
						<?php echo get_post_meta( $post->ID, LG_ES . '_read', true ) ?>
					</div><!--.theme_box-->
				</div>
			</div>
		</div>
	</div><!-- .c-contents_wrapper -->

	<?php
	get_footer();
endif;
?>