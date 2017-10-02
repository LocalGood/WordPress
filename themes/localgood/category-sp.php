<?php
get_header();
?>
	<div class="underlayer_wrapper">
		<?php include( 's-post_nav.php' ); ?>
		<div class="archive_all">
			<div class="post_title">
				<h1><?php single_term_title(); ?></h1>
				<?php echo term_description(); ?>
			</div>
		</div><!-- .archive_all -->
		<div class="contents_wrapper">
			<div class="category_list">
				<?php
				if ( have_posts() ):
					while ( have_posts() ): the_post();
						article_box();
					endwhile;
				endif;
				?>
			</div><!-- /.category_list -->
			<div class="pager">
				<div class="pager_container">
					<div class="tablenav">
						<?php
						paging();
						?>
					</div>
				</div>
			</div>
		</div><!--.contents_wrapper-->
	</div>
<?php
get_template_part( 'footer', 'sp' );
?>