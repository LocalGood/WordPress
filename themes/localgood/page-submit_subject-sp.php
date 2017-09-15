<?php
get_template_part( 'header', 'sp' );
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
                    <?= get_the_title(); ?>
                </h2>
                <div class="common_underlayer_title-h2__sub_title">
                    <?= $post->post_content; ?>
                </div>
            </div>
            <ul class="submit_subject_navi clearfix">
                <li <?php if ( $status == 'input' ): ?>class="active"<?php endif; ?>>
                    <a href="">
                        内容入力
                    </a>
                    <div class="diamond"></div>
                </li>
                <li <?php if ( $status == 'confirm' ): ?>class="active"<?php endif; ?>>
                    <a href="">
                        プレビュー
                    </a>
                    <div class="diamond"></div>
                </li>
                <li <?php if ( $status == 'submit' ): ?>class="active"<?php endif; ?>>
                    <a href="">
                        投稿完了
                    </a>
                    <div class="diamond"></div>
                </li>
            </ul><!-- /.submit_subject_navi -->
            <div class="list_pic_wrapper">
                <div class="list_pic">
                    <div class="list_pic_layout">
                        <div class="content">
                            <div class="inner">
                                <?php

                                if ($status == 'input'):
                                    // 初期状態または修正

                                    // セッション保存
                                    $_session_data = array();
                                    if ( ! empty( $_SESSION['subject'] )) {
                                        $_session_data = $_SESSION['subject'];
                                    }

                                    $notice_class = subject_validation_check();

                                    ?>
                                    <div class="form_block">
                                        <h2 class="subject_title01">
                                            テーマを選択
                                        </h2>
                                        <p class="cap">
                                            一覧から選択してください。
                                        </p>
                                        <div class="select_theme">
                                            <?php
                                            $tree_themes = get_tree_themes();
                                            foreach ($tree_themes as $t):
                                                ?>
                                                <div class="select_theme__wrapper">
                                                    <h3>
                                                        <input type="checkbox" name="theme[]"
                                                               value="<?php echo $t['parent']->slug; ?>"/>
                                                        <button><?php echo $t['parent']->name; ?></button>
                                                    </h3>
                                                    <?php if (isset( $t['children'] )): ?>
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
                                            内容を記入
                                        </h2>
                                        <p class="cap <?= $notice_class; ?>">
                                            課題の内容や発生場所を入力してください。
                                        </p>
                                        <div class="submit_button_sp">
                                            <span class="template_select_button">テンプレートから選択</span>
                                        </div>

                                        <textarea id="subject_content"
                                                  name="subject_content"><?php if ( ! empty( $_session_data['subject_content'] )): echo nl2br( htmlspecialchars( $_session_data['subject_content'] ) ); endif; ?></textarea>
                                    </div>

                                    <section class="form_block">
                                        <h2 class="subject_title01">
                                            ピンを立てる
                                        </h2>
                                        <p class="cap">
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
                                    <?php template_panel(); ?>
                                    <?php
                                elseif ($status == 'confirm') :

                                    $_confirm = $_SESSION['subject'];
                                    ?>
                                    <div class="form_block">
                                        <p class="cap">内容</p>
                                        <div class="confirm_text">
                                            <?php
                                            echo htmlspecialchars( $_confirm['subject_content'] );
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form_block">
                                        <p class="cap">ピン</p>
                                        <div id="preview_gmap"
                                             data-lonlat="<?= $_confirm['loc_position_lat'] ?>,<?= $_confirm['loc_position_lng'] ?>">
                                        </div>
                                    </div>
                                    <?php
                                    ?>
                                    <div class="form_block clearfix">
                                            <span class="button">
                                                <button class="submit" type="submit" name="stage"
                                                        value="">内容を修正</button>
                                            </span>
                                        <span class="button">
                                                <button class="submit submit_button02" type="submit" name="stage"
                                                        value="submit">投稿する
                                                </button>
                                            </span>
                                    </div>
                                    <?php
                                // 投稿完了
                                elseif ($status == 'submit'):
                                    $subject = $_SESSION['subject'];
                                    $subject_id = save_subject( $subject );
                                    if ($subject_id > 0) {
                                        ?>
                                        <div class="sp_form_complete">
                                            <p class="hl">投稿完了しました</p>
                                            <div class="form_block">
                                                <p class="see_subject">
                                                    <a href="<?= home_url( '/subject/' ); ?>">投稿一覧へ戻る</a>
                                                </p>
                                            </div>
                                        </div><!-- /.complete -->

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
                            </div><!-- .inner -->
                        </div> <!-- .content -->
                    </div>
                </div>
            </div>
            <?php
            if ($status == 'input'):
                ?>
                <div class="form_block subject_button_area">
                    <span class="button">
                        <button class="submit" id="stage" type="submit" name="stage" value="confirm">内容を確認する</button>
                    </span>
                </div>
            <?php endif; ?>
        </form>
    </div><!-- /.underlayer_wrapper -->
<?php
get_template_part( 'footer', 'sp' );
?>