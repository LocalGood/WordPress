<?php
add_action( 'wp_enqueue_scripts', function () {
	$cssdir = get_stylesheet_directory_uri();
	wp_enqueue_script( 'detail_search_controller_js', $cssdir . '/js/detail_search_control-sp.js', array( 'jquery' ), null, false );
} );
require_once( 'lib/event-search-engine.php' );
$search_mode   = ( isset( $_GET['searchFrom'] ) ) ? $_GET['searchFrom'] : false;
$args          = feature_posts_args();
$feature_posts = get_posts( $args );
$post_not      = array();
if ( $feature_posts ) {
	foreach ( $feature_posts as $p ) {
		$post_not[] = $p->ID;
	}
}

get_header(); ?>
<div class="underlayer_wrapper">
	<?php include( "s-post_nav.php" ); ?>
	<div class="contents_wrapper ">
		<?php knows_map_bar(); ?>
		<div class="knows_map__filter_wrapper  knowsMapFilter">
			<ul class="knows_map__filter">
				<li class="knows_map__filter--text">絞り込み</li>
				<li><input type="checkbox" name="" id="mapFilter-place" checked="checked"
				           class="knows_map__filter--inp_radio togglePin checkbox" value="place">
					<span class="knows_map__filter--inp_radio--parts parts"></span>
					<label for="mapFilter-place" class="knows_map__filter--label">みんなの拠点</label>
				</li>
				<li><input type="checkbox" name="" id="mapFilter-event" checked="checked"
				           class="knows_map__filter--inp_radio togglePin checkbox" value="event">
					<span class="knows_map__filter--inp_radio--parts parts"></span>
					<label for="mapFilter-event" class="knows_map__filter--label">イベント</label>
				</li>
			</ul>
			<div id="gmap" style="height:300px;overflow: auto"></div>
		</div>
		<div class="list_pic_wrapper">
			<?php if ( 'place' !== $search_mode ) :
				$event_query = new WP_Query( get_event_args( $search_mode, $post_not ) );
				if ( $event_query->have_posts() ) :
					?>
					<h3 class="c-group_title01">イベント</h3>
					<div class="list_pic">
						<div class="list_pic_layout">
							<?php
							while ( $event_query->have_posts() ) : $event_query->the_post();
								global $post;
								if ( isset( $_GET['searchFrom'] ) && 'place' === $_GET['searchFrom'] ) {
									place_box( $post );
								} else {
									event_box();
								}
							endwhile;
							?>
							<div class="pager" style="clear: both">
								<div class="pager_container">
									<?php
									paging( $event_query );
									?>
								</div>
							</div>
							<?php wp_reset_postdata(); ?>
							<div style="clear: both"></div>
						</div>
					</div><!--.list_pic-->
					<?php
				endif;
			endif; ?>

			<?php if ( 'event' !== $search_mode ) : ?>
				<h3 class="c-group_title01">みんなの拠点</h3>

				<div class="list_pic">
					<div class="list_pic_layout">
						<?php
						$place_query = new WP_Query( get_place_args( $search_mode, $post_not ) );
						if ( $place_query->have_posts() ) :
							while ( $place_query->have_posts() ) : $place_query->the_post();
								global $post;
								place_box();
							endwhile;
						endif;
						?>
						<?php wp_reset_postdata(); ?>
						<div style="clear: both"></div>
					</div>
				</div><!--.list_pic-->
			<?php endif; ?>
			<?php if ( $feature_posts && ! $search_mode ) : ?>
				<div class="list_pic">
					<div class="list_pic_layout">
						<section class="pickup_area c-clearfix">
							<h2 class="c-group_title01">PICK UP!</h2>
							<?php
							foreach ( $feature_posts as $post ) :
								setup_postdata( $post );
								key_topic_box( $i );
								$i ++;
							endforeach; ?>
						</section>
						<div style="clear: both"></div>
					</div>
				</div><!--.list_pic-->
			<?php endif; ?>
		</div><!--.list_pic_wrapper-->
	</div><!--.contents_wrapper-->
</div>
<?php
get_template_part( 'footer', 'sp' );
?>
<div class="common_select_popup">
	<div class="common_select_popup__item">
		<a href="<?= home_url( '/event_search_sp/' ); ?>" class="image image--event"></a>
		<a href="<?= home_url( '/event_search_sp/' ); ?>" class="text">イベント</a>
	</div>

	<div class="common_select_popup__item">
		<a href="<?= home_url( '/spot_search_sp/' ); ?>" class="image image--spot"></a>
		<a href="<?= home_url( '/spot_search_sp/' ); ?>" class="text">みんなの拠点</a>
	</div>
	<a href="javascript:void(0);" id="selectPopupClose">×</a>
</div>
