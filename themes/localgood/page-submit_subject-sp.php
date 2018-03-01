<?php
get_template_part('header', 'sp');
?>
    <div class="underlayer_wrapper">
        <?php
        global $post;
        $status = subject_step_status();
        save_subject_session();
        ?>
        <form action="" method="post" id="post_subject" name="post_subject"
              enctype="multipart/form-data">
            <div class="underlayer_title_area">
                <h2 class="common_underlayer_title-h2">
                    <img src="<?php echo get_option('lg_config__page_ttl_prefix'); ?>">
                    <?php echo get_the_title(); ?>
                </h2>
                <div class="common_underlayer_title-h2__sub_title">
                    <?php echo $post->post_content; ?>
                </div>
            </div>
            <ul class="submit_subject_navi clearfix">
                <li <?php if ($status == 'input'): ?>class="active"<?php endif; ?>>
                    <a href="">
                        内容入力
                    </a>
                    <div class="diamond"></div>
                </li>
                <li <?php if ($status == 'submit'): ?>class="active"<?php endif; ?>>
                    <a href="">
                        投稿完了
                    </a>
                    <div class="diamond"></div>
                </li>
            </ul><!-- /.submit_subject_navi -->
            <div class="list_pic_wrapper">
                <div class="list_pic">
                    <div class="list_pic_layout">
	                    <?php if ( $status == 'input' ): ?>
							<div class="list_pic__required_desc">
								<span class="required">※</span>
								このマークの付いた項目は必須項目です。
							</div>
	                    <?php endif; ?>
                        <div class="content">
                            <div class="inner">
                                <?php
                                if ($status == 'input'):
                                    // 初期状態または修正

                                    // セッション保存
                                    $_session_data = array();
                                    if (!empty($_SESSION['subject'])) {
                                        $_session_data = $_SESSION['subject'];
                                    }
                                    $notice_class = subject_validation_check();
                                    ?>
                                    <div class="form_block">
                                        <h2 class="subject_title01">
                                            テーマを選択
                                        </h2>
                                        <p class="cap form_block__title_sup theme">
                                            一覧から選択してください。
                                        </p>
                                        <div class="select_theme">
                                            <?php
                                            $tree_themes = get_tree_themes();
                                            echo '<div class="pickup_category">';
                                            foreach ($tree_themes['pickup'] as $t): ?>
                                                <div class="select_theme__wrapper">
                                                    <input type="checkbox" name="theme[]"
                                                           value="<?php echo $t->slug; ?>" <?php if ($search_theme && in_array($t->slug,
                                                            $search_theme)
                                                    ) {
                                                        echo 'checked="checked"';
                                                    } ?> />
                                                    <button <?php if ($search_theme && in_array($t->slug,
                                                            $search_theme)
                                                    ) {
                                                        echo 'class="select"';
                                                    } ?> ><?php echo $t->name; ?></button>
                                                </div>

                                            <?php
                                            endforeach;
                                            echo '</div>';

                                            foreach ($tree_themes as $t):
                                                ?>
                                                <div class="select_theme__wrapper">
                                                    <h3>
                                                        <input type="checkbox" name="theme[]"
                                                               value="<?php echo $t['parent']->slug; ?>"/>
                                                        <button><?php echo $t['parent']->name; ?></button>
                                                    </h3>
                                                    <?php if (isset($t['children'])): ?>
                                                        <ul class="clearfix">
                                                            <?php foreach ($t['children'] as $c): ?>
                                                                <li>
                                                                    <input type="checkbox" name="theme[]"
                                                                           value="<?php echo $c->slug; ?>"/>
                                                                    <button><?php echo $c->name; ?></button>
                                                                </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <div class="form_block">
                                        <h2 class="subject_title01">
                                            内容を記入<span class="required">※</span>
                                        </h2>
                                        <p class="cap form_block__title_sup <?php echo $notice_class; ?> content">
                                            課題の内容や発生場所を入力してください。
                                        </p>
                                        <div class="submit_button_sp">
                                            <span class="template_select_button">テンプレートから選択</span>
                                        </div>

                                        <textarea id="subject_content"
                                                  name="subject_content"><?php if (!empty($_session_data['subject_content'])): echo nl2br(htmlspecialchars($_session_data['subject_content'])); endif; ?></textarea>
                                    </div>

                                    <section class="form_block">
                                        <h2 class="subject_title01">画像を添付する</h2>
                                        <p class="form_block__title_sup <?php echo $notice_class; ?>">
                                            公序良俗に反する画像や、第三者の著作権や肖像権を侵害する可能性のある画像はアップロードしないでください。
                                        </p>
                                        <input type="file" id="form_input_photo2" name="photo">
                                    </section>

                                    <section class="form_block">
                                        <h2 class="subject_title01">
                                            ピンを立てる
                                        </h2>
                                        <div class="submit_subject__address_search">
                                            <input id="address_search_input" class="form_block__address_search_input"
                                                   placeholder="施設名・住所から検索するにはここに入力します">
                                            <button id="address_search_exec" class="form_block__address_search_exec">
                                                検索する
                                            </button>
                                            <p><a href="javascript:void(0);" id="map_pin_clear">ピンを削除</a></p>
                                        </div>
                                        <p class="cap">
                                            課題の発生場所や関係のある場所にピンを立ててください。<br/>
                                            (地図をクリックするとピンが立ちますので、ドラッグして任意の場所に移動してください。)
                                        </p>
                                        <div id="subject_gmap" class="subject_gmap">
                                        </div>
                                    </section>

                                    <input id="loc_position_lat" name="loc_position_lat" type="hidden"
                                           value="<?php if (!empty($_session_data['loc_position_lat'])): echo $_session_data['loc_position_lat']; endif; ?>"/>
                                    <input id="loc_position_lng" name="loc_position_lng" type="hidden"
                                           value="<?php if (!empty($_session_data['loc_position_lng'])): echo $_session_data['loc_position_lng']; endif; ?>"/>
                                    <?php template_panel(); ?>


                                <?php
                                // 投稿完了
                                elseif ($status == 'submit'):
                                    $subject = $_SESSION['subject'];
                                    $subject_id = save_subject($subject, $_FILES);
                                    if ($subject_id > 0) {
                                        ?>
                                        <div class="sp_form_complete">
                                            <p class="hl">投稿完了しました</p>
                                            <div class="form_block">
                                                <p class="see_subject">
                                                    <a href="<?php echo home_url('/subject/'); ?>">投稿一覧へ戻る</a>
                                                </p>
                                            </div>
                                        </div><!-- /.complete -->

                                        <?php
                                        save_subject_meta($subject_id, $subject);

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
                            </div><!-- .inner -->
                        </div> <!-- .content -->
                    </div>
                </div>
            </div>
            <?php
            if ($status == 'input'):
                ?>
                <div class="form_block clearfix">
					<span class="button">
						<button class="submit submit_button02" type="submit" name="stage" id="submitSubject"
                                value="submit">投稿する</button>
					</span>
                </div>
            <?php endif; ?>
        </form>
    </div><!-- /.underlayer_wrapper -->
<?php
get_template_part('footer', 'sp');