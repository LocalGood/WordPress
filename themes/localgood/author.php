<?php get_header(); ?>
<?php
global $wp_query;
$args = array(
	'post_type'      => array( 'post' ),
	'posts_per_page' => 9,
);

?>
<?php if ( DEVICE == 'sp' ) : ?>
	<div class="underlayer_wrapper author_post">
		<div class="inner two_column_wrapper">
			<div class="key_topic_box two_left">
				<?php
				$user['id']           = get_the_author_meta( 'ID' );
				$user['display_name'] = get_the_author_meta( 'display_name' );
				$user['link']         = get_author_posts_url($user['id']);
				writer_prof();
				?>
				<div class="list_pic_wrapper">
					<h2 class="group_title"><?php echo $user['display_name']; ?>さんの記事一覧</h2>
					<div class="list_pic">
						<div class="list_pic_layout">
							<?php
							$args = array(
								'post_type'      => array( 'post' ),
								'posts_per_page' => 9,
							);

							if ( have_posts() ) :
								while ( have_posts() ) : the_post();
									article_box();
								endwhile;
							endif;
							?>
							<div class="pager" style="clear: both">
								<div class="pager_container">
									<?php paging(); ?>
								</div>
							</div>
							<div style="clear: both"></div>
						</div>
					</div>
				</div><!-- /.list_pic_wrapper -->
			</div>
		</div>
	</div><!-- /.underlayer_wrapper -->
<?php else : ?>

	<div class="c-contents_wrapper c-w1096 author_single">
		<?php breadcrumbs(); ?>
		<?php
		$user['id']           = get_the_author_meta( 'ID' );
		$user['display_name'] = get_the_author_meta( 'display_name' );
		$user['link']         = home_url() . '/author/' . get_the_author_meta( 'user_login', $user['id'] );

		writer_prof();
		?>
		<div class="article_area">
			<h2 class="c-group_title01"><?php echo $user['display_name']; ?>さんの記事一覧</h2>
			<div class="article_box__wrapper">
				<?php
				$aps_paged = absint( get_query_var( 'aps', 1 ) );
				$args      = array_merge( $wp_query->query, array(
					'post_type'      => array( 'post' ),
					'posts_per_page' => 9,
					'paged'          => $aps_paged,
				) );

				$my_posts = new WP_Query( $args );
				if ( $my_posts->have_posts() ) :
					while ( $my_posts->have_posts() ) : $my_posts->the_post();
						article_box();
					endwhile;
				endif;
				wp_reset_postdata();
				?>
			</div>
		</div>
		<div class="c-pager c-clearfix">
			<div class="c-pager_container">
				<?php
				$pager_options = array(
					'paginate_base'   => $user['link'] . '%_%',
					'paginate_format' => '?aps=%#%',
					'current'         => $aps_paged,
				);
				paging( $my_posts, $pager_options );
				?>
			</div>
		</div>

		<?php
		$eps_paged = absint( get_query_var( 'eps', 1 ) );
		$args      = array_merge( $wp_query->query, array(
			'post_type'      => array( 'event' ),
			'posts_per_page' => 9,
			'paged'          => $eps_paged,
		) );
		$my_events = new WP_Query( $args );
		if ( $my_events->have_posts() ) :
		?>
		<div class="article_area">
			<h2 class="c-group_title01"><?php echo $user['display_name']; ?>さんの登録したイベント一覧</h2>
			<div class="article_box__wrapper">
				<?php
					while ( $my_events->have_posts() ) : $my_events->the_post();
						article_box();
					endwhile;
				?>
			</div>
		</div>
		<?php endif;?>
		<div class="c-pager c-clearfix">
			<div class="c-pager_container">
				<?php
				$pager_options = array(
					'paginate_base'   => $user['link'] . '%_%',
					'paginate_format' => '?eps=%#%',
					'current'         => $eps_paged,
				);
				paging( $my_events, $pager_options );
				?>
			</div>
		</div>
	</div><!-- /.c-contents_wrapper -->

<?php endif; ?>

<?php
if ( DEVICE == 'sp' ) :
	get_template_part( 'footer', 'sp' );
else :
	get_footer();
endif;
?>
