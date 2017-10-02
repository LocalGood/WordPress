<?php get_header(); ?>
    <div class="contents_wrapper" id="top_page">

        <div class="key_visual pr" style="background-image:url(<?php echo esc_attr( get_option( 'lg_config__home_wallpaper' ) ); ?>);">
            <img src="<?php bloginfo('template_directory'); ?>/images/sm/s-main_text.png" alt="LOCAL GOODとは"/>
			<div class="key_visual__updates">
				<h3>更新情報</h3>
		        <?php echo wpautop( get_option( 'home_updates' ) ); ?>
			</div>

            <div class="nav_menu-button pa">
                <span></span>
                <span></span>
                <span></span>
                <div class="close_button">×</div>
            </div>

            <a href="#top_content" class="pa top_page__key_vasual__link">
                <img src="<?php bloginfo('template_directory'); ?>/images/sm/s-top-main-link.png" alt="詳しくはこちら" >
            </a>
        </div>

        <section class="sp_content pr" id="top_content">
            <section class="top_page__box01">
                <h2 class="common_title-h2">
                    このまち、わたしから未来を作る
                </h2>
                <section class="top_page__box01__inner01">
                    <h3 class="common_title-h3">
                        LOCAL GOOD YOKOHAMAについて
                    </h3>
                    <div class="text">
                        　税収減と社会コスト増加が避けられない時代を迎え、住みやすい地域を持続させるには、市民や企業など多様な主体が、それぞれできる範囲で時間・知恵・お金を持ち寄り、支え合うことが大切になってきます。<br />
                        　「LOCAL GOOD YOKOHAMA」は、 サービス、 モノ、 カネ、 ヒト、 情報の循環をつくっていくことを目指し、インターネット上の場と、インターネットを超えた地域の現場両面から、地域をよくする活動「地域のGOOD=ステキないいコト」に市民、企業が参加するきっかけをつくっていきます。
                    </div><!-- /.text -->
                </section>
                
                <section class="top_page__box01__inner02">
                    <h3 class="common_title-h3">
                        LOCAL GOOD YOKOHAMAでできること
                    </h3>
                    <section>
                        <div class="photo">
                            <img src="<?php bloginfo('template_directory'); ?>/images/sm/s-top-photo01.jpg" alt="" width="100%" height="auto">
                        </div>
                        <div class="arrow">
                            <img src="<?php bloginfo('template_directory'); ?>/images/sm/s-common-arrow01.png" alt="">
                        </div>
                        <div class="text_wrapper">
                            <h4 class="common_title-h4">
                                地域を知ろう
                            </h4>
                            <div class="text">
                                　地域で起こっていること、地域の課題や、それに取り組む人がいることを知ることから、スタートしましょう。
                            </div>
                            <a href="/lgnews/" class="link_button01">
                                地域を知る
                            </a>
                        </div>
                    </section>

                    <section>
                        <div class="photo">
                            <img src="<?php bloginfo('template_directory'); ?>/images/sm/s-top-photo02.jpg" alt="" width="100%" height="auto">
                        </div>
                        <div class="arrow">
                            <img src="<?php bloginfo('template_directory'); ?>/images/sm/s-common-arrow01.png" alt="">
                        </div>
                        <div class="text_wrapper02">
                            <h4 class="common_title-h4">
                                地域に参加しよう
                            </h4>
                            <div class="text">
                                　地域の団体のイベントに参加しましょう。活動している団体のプロジェクトに寄付したり、スキルマッチングでボランティアとして地域の課題解決に参加しましょう。
                            </div>
                            <a href="https://cf.yokohama.localgood.jp/" class="link_button01">
                                地域に参加する
                            </a>
                        </div>
                    </section>
                </section>

                <section class="top_page__box01__inner03">
                    <h3 class="common_title-h3">
                        LOCAL GOOD YOKOHAMAのこれまで
                    </h3>
                    <ul>
                        <li class="c_blue">
                            <div class="img">
                                <img src="<?php bloginfo('template_directory'); ?>/images/sm/s-top-icon01.png" alt="">
                            </div>
                            <div class="text">
                                イベントへの参加者
                            </div>
                            <div class="people">
                                <?php
                                    $participants_num = get_option('event_participants');
                                    echo htmlspecialchars($participants_num, ENT_QUOTES);
                                    ?>人
                            </div>
                        </li>
                        <?php
                        $_url = LG_GOTEO_BASE_URL . '/json/get_goteo_status';
                        $_params = array();
                        $statobj = request_api_curl($_url, $_params);
                        ?>
                        <li class="c_pink">
                            <div class="img">
                                <img src="<?php bloginfo('template_directory'); ?>/images/sm/s-top-icon02.png" alt="">
                            </div>
                            <div class="text">
                                支援した人
                            </div>
                            <div class="people">
                                <?php
                                echo !empty($statobj->investors) ? $statobj->investors : '';
                                // 450
                                ?>人
                            </div>
                        </li>
                    </ul>

                    <ul>
                        <li class="c_green">
                            <div class="img">
                                <img src="<?php bloginfo('template_directory'); ?>/images/sm/s-top-icon03.png" alt="">
                            </div>
                            <div class="text">
                                集まった金額
                            </div>
                            <div class="people">
                                <?php
                                echo !empty($statobj->total) ? $statobj->total : '';
                                //                             7,937,970
                                ?>円
                            </div>
                        </li>
                        <li class="c_orange">
                            <div class="img">
                                <img src="<?php bloginfo('template_directory'); ?>/images/sm/s-top-icon04.png" alt="">
                            </div>
                            <div class="text">
                                成立したプロジェクト
                            </div>
                            <div class="people">
                                <?php
                                echo !empty($statobj->succeed) ? $statobj->succeed : '';
                                // 14
                                ?>件
                            </div>
                        </li>
                    </ul>
                    <div class="c_navy">
                        <div class="img">
                            <img src="<?php bloginfo('template_directory'); ?>/images/sm/s-top-icon05.png" alt="">
                        </div>
                        <div class="text">
                            支援を募集中のプロジェクト
                        </div>
                        <div class="people">
                            <?php
                            echo !empty($statobj->progress) ? $statobj->progress : '';
                            // 2
                            ?>件
                        </div>
                    </div>
                </section>
            </section><!-- /.top_page__box01 -->

            <section class="top_page__box02">
                <h4 class="common_title-h4">
                    クラウドファンディング
                </h4>
                <?php
                $_promotes = get_pickup_projects();
                if (!empty($_promotes)){
                    foreach ($_promotes as $_promo){
                        $_prj_url = LG_GOTEO_BASE_URL . '/widget/project/' . urlencode($_promo->project) . '?lang=ja';
                        ?>
                        <div class="project_box__part">
                            <iframe class="autoHeight" frameborder="0" width="100%" height="480px" src="<?= $_prj_url; ?>" scrolling="yes"></iframe>
                        </div>
                        <?php
                    }
                }
                ?>
            </section><!-- /.top_page__box02 -->

            <section class="top_page__box03">
                <h3 class="common_title-h3">
                    運営体制
                </h3>
                <h5 class="common_title-h5">
                    運営主体
                </h5>
                <div class="title">
                    NPO法人 横浜コミュニティデザイン・ラボ
                </div>
                <div class="logo">
                    <a href="http://yokohamalab.jp/" target="_blank">
                        <img src="<?php bloginfo('template_directory'); ?>/images/sm/s-top-ycdl-logo.png" alt="YOKOHAMA COMMUNITY DESIIGN LAB.">
                    </a>
                </div>

                <ul>
                    <li>
                        <a href="http://www.city.yokohama.lg.jp/seisaku/" target="_blank">
                            <img src="<?php bloginfo('template_directory'); ?>/images/sm/s-top-support-icon01.png" alt="画像：OPEN YOKOHAMA">
                        </a>
                    </li>
                    <li>
                        <a href="http://labo.wtnv.jp/" target="_blank">
                            <img src="<?php bloginfo('template_directory'); ?>/images/sm/s-top-support-icon02.png" alt="画像：首都大学東京渡邉英徳研究室">
                        </a>
                    </li>
                </ul>
                <ul>
                    <li>
                        <a href="http://www.ycu-coc.jp/" target="_blank">
                            <img src="<?php bloginfo('template_directory'); ?>/images/sm/s-footer-logo05.png" alt="画像：横浜市立大学影山摩子弥研究室">
                        </a>
                    </li>
                    <li>
                        <a href="http://goteo.org/" target="_blank">
                            <img src="<?php bloginfo('template_directory'); ?>/images/sm/s-footer-logo04.png" alt="画像：Fundacion Goteo">
                        </a>
                    </li>
                </ul>
                <ul>
                    <li>
                        <a href="http://designcat.co/" target="_blank">
                            <img src="<?php bloginfo('template_directory'); ?>/images/sm/s-top-support-icon06.png" alt="画像：Design Cat">
                        </a>
                    </li>
                    <li>
                        <a href="http://info-lounge.jp/" target="_blank">
                            <img src="<?php bloginfo('template_directory'); ?>/images/sm/s-footer-logo08.jpg" alt="画像：インフォラウンジ 合同会社">
                        </a>
                    </li>
                </ul>
                <ul>
                    <li>
                        <a href="http://www.accenture.com/jp-ja/Pages/index.aspx" target="_blank">
                            <img src="<?php bloginfo('template_directory'); ?>/images/sm/s-footer-logo02.png" alt="画像：アクセンチュア株式会社">
                        </a>
                    </li>
                    <li></li>
                </ul>
            </section><!-- /.top_page__box03 -->
        </section><!-- /.sp_content -->

<?php
    get_template_part('footer', 'sp')
?>

