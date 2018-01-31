<?php
if (DEVICE == 'sp'):
// スマホ
    get_template_part( 'page', 'submit_subject-sp' );
else:
    get_header();

    global $post;
    $status = subject_step_status();
    save_subject_session();
    ?>
    <section class="c-contents_wrapper c-w1096">

        <form action="" method="post" id="post_subject" name="post_subject"
              enctype="multipart/form-data">

            <?php breadcrumbs(); ?>

            <div class="c-page_title_wrapper">
                <h2 class="c-page_title c-title05"><?php echo get_the_title(); ?></h2>
                <p class="c-page_title_subtext"><?php echo $post->post_content; ?></p>
            </div>

            <ul class="submit_subject__active">
                <li <?php if ( $status == 'input' ): ?>class="active"<?php endif;
                ?>>
                    内容入力
                    <div class="submit_subject__active__diamond"></div>
                </li>
                <li <?php if ( $status == 'confirm' ): ?>class="active"<?php endif;
                ?>>
                    プレビュー
                    <div class="submit_subject__active__diamond"></div>
                </li>
                <li <?php if ( $status == 'submit' ): ?>class="active"<?php endif;
                ?>>
                    投稿完了
                    <div class="submit_subject__active__diamond"></div>
                </li>
            </ul><!-- /.submit_subject_navi -->

            <section class="submit_subject__form_area">
				<div class="submit_subject__required_desc">
					<span class="required">※</span>
					このマークの付いた項目は必須項目です。
				</div>


                <?php
                if ($status == 'input') :
                    // セッション保存
                    $_session_data = array();
                    if ( ! empty( $_SESSION['subject'] )) {
                        $_session_data = $_SESSION['subject'];
                    }

                    $notice_class = subject_validation_check();
                    ?>
                    <section class="form_block">

                        <h2 class="form_block__title">テーマを選択<span class="required">※</span></h2>
                        <p class="form_block__title_sup">
                            一覧から選択してください。
                        </p>

                        <div class="select_theme__wrapper stw_01">
                            <?php
                            $tree_themes = get_tree_themes();
                            echo '<div class="pickup_category">';
                            foreach ($tree_themes['pickup'] as $t): ?>
								<section class="select_theme">
									<ul class="select_theme__list clearfix">
										<li>
											<input type="checkbox" name="theme[]"
												   value="<?php echo $t->slug; ?>" <?php if ( $search_theme && in_array( $t->slug,
						                            $search_theme )
				                            ) {
					                            echo 'checked="checked"';
				                            } ?> />
											<button <?php if ( $search_theme && in_array( $t->slug,
						                            $search_theme )
				                            ) {
					                            echo 'class="select"';
				                            } ?> ><?php echo $t->name; ?></button>
										</li>
									</ul>
								</section>

                            <?php
                            endforeach;
                            echo '</div>';

                            foreach ($tree_themes as $t):
                                ?>
                                <section class="select_theme">
                                    <h3 class="select_theme__title"><input type="checkbox" name="theme[]"
                                                                           value="<?php echo $t['parent']->slug; ?>"/>
                                        <button><?php echo $t['parent']->name; ?></button>
                                    </h3>
                                    <?php if (isset( $t['children'] )): ?>
                                        <ul class="select_theme__list clearfix">
                                            <?php foreach ($t['children'] as $c): ?>
                                                <li>
                                                    <input type="checkbox" name="theme[]"
                                                           value="<?php echo $c->slug; ?>"/>
                                                    <button><?php echo $c->name; ?></button>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </section>
                            <?php endforeach; ?>
                        </div>

                    </section>

                    <section class="form_block">
                        <h2 class="form_block__title">内容を記入<span class="required">※</span></h2>
                        <p class="form_block__title_sup <?php echo $notice_class; ?>">
                            課題の内容や発生場所を入力してください。
                        </p>
                        <span id="template_select_button"
                              class="form_block__template_select_button">テンプレートから選択</span>
                        <textarea id="subject_content" class="form_block__textarea"
                                  name="subject_content"><?php if ( ! empty( $_session_data['subject_content'] )): echo nl2br( htmlspecialchars( $_session_data['subject_content'] ) ); endif; ?></textarea>
                    </section>

                    <section class="form_block">
                        <h2 class="form_block__title">ピンを立てる</h2>
						<div class="submit_subject__address_search">
							<input id="address_search_input" class="form_block__address_search_input" placeholder="施設名・住所から検索するにはここに入力します">
							<button type="submit" id="address_search_exec" class="form_block__address_search_exec">検索する</button>
							<p><a href="javascript:void(0);" id="map_pin_clear">ピンを削除</a></p>
						</div>
                        <p class="form_block__title_sup">
                            課題の発生場所や関係のある場所にピンを立ててください。<br/>
                            (地図をクリックするとピンが立ちますので、ドラッグして任意の場所に移動してください。)
                        </p>
                        <div id="subject_gmap" class="subject_gmap">
                        </div>
                    </section>

                    <input id="loc_position_lat" name="loc_position_lat" type="hidden"
                           value="<?php if ( ! empty( $_session_data['loc_position_lat'] )): echo $_session_data['loc_position_lat']; endif; ?>"/>
                    <input id="loc_position_lng" name="loc_position_lng" type="hidden"
                           value="<?php if ( ! empty( $_session_data['loc_position_lng'] )): echo $_session_data['loc_position_lng']; endif; ?>"/>

                    <div id="template_panel__wrapper" class="template_panel__wrapper">
                        <?php template_panel(); ?>
                    </div>

                    <?php
                elseif ($status == 'confirm') :
                    $_confirm = $_SESSION['subject'];
                    if ( ! empty( $_confirm['theme'] )) {
                        ?>
                        <div class="form_block">
                            <p class="form_block__title">テーマ</p>
                            <div class="confirm_text">
                                <ul class="selected_theme_list">
                                    <?php
                                    foreach ($_confirm['theme'] as $theme):
                                        $term = get_term_by( 'slug', $theme, 'project_theme' );
                                        if ($term):
                                            ?>
                                            <li>
                                                <?php echo $term->name; ?>
                                            </li>
                                            <?php
                                        endif;
                                    endforeach;
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="form_block">
                        <p class="form_block__title">内容</p>
                        <div class="confirm_text">
                            <?php
                            echo htmlspecialchars( $_confirm['subject_content'] );
                            ?>
                        </div>
                    </div>
                    <?php if ( '' !== $_confirm['loc_position_lat'] && '' !== $_confirm['loc_position_lng'] ) : ?>
                    <div class="form_block">
                        <p class="form_block__title">ピン</p>
                        <div id="preview_gmap"
                             data-lonlat="<?php echo $_confirm['loc_position_lat'] ?>,<?php echo $_confirm['loc_position_lng'] ?>"
                             style="height:400px">
                        </div>
                    </div>
                    <?php
					endif;
                elseif ($status == 'submit') :
                    $subject = $_SESSION['subject'];
                    $subject_id = save_subject( $subject );
                    if ($subject_id > 0) {
                        ?>
                        <p class="post_finish">投稿完了しました</p>
                        <div class="form_block">
                            <a class="see_subject_button" href="<?php echo home_url( '/subject/' ); ?>">投稿一覧へ戻る</a>
                        </div>
                        <?php
                        save_subject_meta( $subject_id, $subject );
                        // セッションクローズ
                        session_destroy();
                        wp_reset_postdata();
                    } else {
                        // 投稿失敗
                        echo 'failed!' . "\n";
                        // セッションクローズ
                        session_destroy();
                    }
                endif;
                ?>
            </section><!-- /.submit_subject__form_area -->

            <?php
            if ($status == 'input'):
                ?>
                <button class="confirm_button" id="stage" type="submit" name="stage" value="confirm">内容を確認する</button>
                <?php
            elseif ($status == 'confirm'):
                ?>
                <div class="form_block c-clearfix">
                    <button class="fix_button" type="submit" name="stage" value="">内容を修正</button>
                    <button class="submit_button" type="submit" name="stage" value="submit">投稿する</button>
                </div>
                <?php
            endif;
            ?>
        </form>

    </section><!--.c-contents_wrapper-->

    <?php get_footer(); ?>

<?php endif; ?>


