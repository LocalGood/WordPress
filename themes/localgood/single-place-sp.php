<?php
get_header();
?>

	<div class="underlayer_wrapper">
<?php if ( have_posts() ) :
	the_post();
	global $post, $cfs;
	$self_post_obj = $post;
	$self_post_id  = $self_post_obj->ID;
	$eps_paged     = get_query_var( 'eps', 1 );
	$sns_accounts  = array(
		'twitter'  => get_post_meta( $post->ID, 'place_twitter', true ),
		'facebook' => get_post_meta( $post->ID, 'place_facebook', true ),
	);
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

		<div class="sp_common_single_info_heading_area__tags">
			<?php
			$tags = get_term_atag( $post->post_type, false );
			foreach ( $tags as $tag ) {
				echo '<span>' . $tag . '</span>';
			}
			?>
		</div>

		<div class="sp_common_single_info_heading_area__sns">
			<?php if ( ! empty( $sns_accounts['facebook'] ) ) : ?>
				<a href="<?php echo $sns_accounts['facebook']; ?>">
					<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/writer_fb_on.png" alt="">
				</a>
			<?php else : ?>
				<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/writer_fb_off.png" alt="">
			<?php endif; ?>

			<?php if ( ! empty( $sns_accounts['twitter'] ) ) : ?>
				<a href="<?php echo $sns_accounts['twitter']; ?>">
					<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/writer_tw_on.png" alt="">
				</a>
			<?php else : ?>
				<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/writer_tw_off.png" alt="">
			<?php endif; ?>
		</div>

		<div class="sp_common_single_info_heading_area__description">
			<?php
			$_content = get_the_content();
			$content  = apply_filters( 'the_content', $_content );
			the_content();
			?>
		</div>

		<div class="sp_common_single_info_heading_area__description">
			<?php
			$_content = get_the_content();
			$content  = apply_filters( 'the_content', $_content );
			the_content();
			?>

			<h4 class="sp_common_single_info_heading_area__description__title">拠点情報</h4>
			<dl>
				<?php
				$place_meta = get_place_metas( $self_post_obj );
				foreach ( $place_meta as $meta_data ) :
					if ( $meta_data['value'] ) :
						?>
						<dt><?php echo $meta_data['label']; ?></dt>
						<dd><?php echo $meta_data['value']; ?></dd>
						<?php
					endif;
				endforeach; ?>
			</dl>
		</div>

	</div>

	<?php
	$photos = get_post_meta( $self_post_id, 'place_photo', false );
	if ( ! empty( $photos ) ) :
		?>
		<div class="article_area photo_gallery">
			<?php
			foreach ( $photos as $photo ) :
				$image = wp_get_attachment_image_src( $photo, 'medium' );
				$full_image = wp_get_attachment_image_src( $photo, 'full' );
				$meta = strip_tags( get_post_meta( $photo, '_wp_attachment_image_alt', true ) );
				?>
				<a href="<?php echo $full_image[0]; ?>" target="_blank"><img src="<?php echo $image[0]; ?>" alt=""></a>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<div class="common_single_gmap">
		<h2 class="c-group_title01">
            <img src="<?php echo get_option( 'lg_config__group_ttl_prefix' ); ?>" >
            <?php the_title(); ?>さんの場所
        </h2>
		<div class="side_block gmap">
			<?php
			$data_lonlat = get_post_lonlat_attr();
			if ( ! empty( $data_lonlat ) ) :
				?>
				<div id="gmap" <?php echo $data_lonlat; ?> style="height: 400px;margin-bottom:20px;"
					 data-type="<?php echo esc_html( $post->post_type ); ?>"
					 data-title="<?php the_title(); ?>"></div>
			<?php endif;?>
			</div>
		</div>

<?php endif; // end if have_posts(). ?>
<?php
$args = array(
	'post_type'      => array( 'event' ),
	'meta_key'       => 'event_date',
	'orderby'        => 'meta_value',
	'order'          => 'asc',
	'meta_query'     => array(
		'key'     => 'place_id',
		'value'   => $post->ID,
		'compare' => 'IN',
	),
	'posts_per_page' => 9,
);
query_posts( $args );
if ( have_posts() ) :?>
	<h2 class="c-group_title01">
        <img src="<?php echo get_option( 'lg_config__group_ttl_prefix' ); ?>" >
        <?php the_title(); ?>さんで開催のイベント
    </h2>
	<div class="list_pic_wrapper">
		<div class="list_pic">
			<div class="list_pic_layout">
				<?php
				while ( have_posts() ) : the_post();
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
	<?php endif; ?>
	</div><!-- .c-contents_wrapper -->

<?php
get_template_part( 'footer', 'sp' );
