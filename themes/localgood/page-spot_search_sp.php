<?php
add_action( 'wp_enqueue_scripts', function () {
	$cssdir = get_stylesheet_directory_uri();
	wp_enqueue_script( 'detail_search_controller-sp_js', $cssdir . '/js/detail_search_control-sp.js', array( 'jquery' ), null, false );
} );
get_header();
?>
<div class="underlayer_wrapper">
	<div class="sp_event_search">
		<div class="sp_event_search__inner">
			<h2 class="sp_event_search__title">みんなの拠点検索</h2>
			<form action="<?php echo home_url( 'event' ); ?>" class="form" method="get">
				<input type="hidden" name="searchFrom" value="place">

			<ul class="sp_event_search__heading">
				<li>
					<input type="reset" value="条件をリセット" class="sp_event_search__inp_btn">
				</li>
				<li>
					<input type="text" name="keyword" placeholder="キーワードから探す" class="sp_event_search__inp_tex">
				</li>
			</ul>


				<div id="tabItem--Place" class="sp_event_search__form_wrapper">
					<div class="sp_event_search__form">
						<div class="sp_event_search__form__inner">
							<h3 class="sp_event_search__sub_title">エリア</h3>
							<div class="sp_event_search__inp_area">
								<ul class="sp_event_search__inp_check">
									<?php
									$areas_obj = get_terms( 'project_area' );
									foreach ( $areas_obj as $area ) :
										?>
										<li>
											<label class="sp_event_search__inp_check__label">
												<input type="checkbox" name="area[]"
													   id="area_check_<?php echo $area->slug; ?>" class="checkbox">
												<span class="sp_event_search__inp_check__parts parts"></span>
												<?php echo $area->name; ?>
											</label>
										</li>
									<?php endforeach; ?>
								</ul>
							</div>
						</div>
					</div>

					<div class="sp_event_search__form">
						<div class="sp_event_search__form__inner">
							<h3 class="sp_event_search__sub_title">スポット</h3>
							<div class="sp_event_search__inp_area">
								<ul class="sp_event_search__inp_check">
									<?php
									$areas_obj = get_terms( 'project_spot' );
									foreach ( $areas_obj as $area ) :
										?>
										<li>
											<label class="sp_event_search__inp_check__label">
												<input type="checkbox" name="spot[]"
													   class="checkbox"
													   id="spot_check_<?php echo $area->slug; ?>">
												<span class="sp_event_search__inp_check__parts parts"></span>
												<?php echo $area->name; ?>
											</label>
										</li>
									<?php endforeach; ?>
								</ul>
							</div>
						</div>
					</div>
				</div>

				<div class="sp_event_search__bottom">
					<div class="sp_event_search__result">
						<span id="search_result_counter">0</span> 件
					</div>
					<input type="submit" value="検索する" class="sp_event_search__button">
				</div>
			</form>
		</div>
	</div>
</div>
<?php
get_template_part( 'footer', 'sp' )
?>
