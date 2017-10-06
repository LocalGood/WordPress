<footer>
    <section class="footer_menu_links">
        <div class="footer__link-title">
            ご利用にあたって
        </div>
        <ul>
            <li>
                <a href="/about/">
	                <?php bloginfo('name'); ?>について
                </a>
            </li>
            <li>
                <a href="/mailnews/">
                    メルマガ登録
                </a>
            </li>
            <li>
                <a href="/syoutorihikihou/">
                    特定商取引法について
                </a>
            </li>
            <li>
                <a href="/privacypolicy/">
                    プライバシーポリシー
                </a>
            </li>
            <li>
                <a href="/user_guide/">
                    ユーザーガイド
                </a>
            </li>
            <li>
                <a href="<?= LG_INTEGRATION_URL; ?>/riyou_kiyaku_menu">
                    利用規約
                </a>
            </li>
            <li>
                <a href="/contact/">
                    お問い合わせ
                </a>
            </li>
            <li>
                <a href="/authors/">
                    記者一覧
                </a>
            </li>
        </ul>

        <div class="footer__link-title">
            地域を知る
        </div>
        <span>
            記事
        </span>
        <ul>
            <li>
                <a href="/lgnews/">
                    ニュース
                </a>
            </li>
            <li>
                <a href="/event/">
                    みんなの拠点/イベント
                </a>
            </li>
            <li>
                <a href="/lgplayer/">
                    人/団体
                </a>
            </li>
            <li>
                <a href="/data/">
                    データ
                </a>
            </li>
        </ul>
        <span>
            みんなの声
        </span>
        <ul>
            <li>
                <a href="/subject/">
                    投稿一覧
                </a>
            </li>
            <li>
                <a href="/submit_subject/">
                    あなたの声を投稿する
                </a>
            </li>
        </ul>

        <div class="footer__link-title">
            応援する
        </div>
        <ul>
            <li>
                <a href="<?php if(defined('LG_GOTEO_BASE_URL')){echo LG_GOTEO_BASE_URL;} ?>/discover">
                    プロジェクト一覧
                </a>
            </li>
            <li>
                <a href="<?= home_url('/challenge/'); ?>">
					プロジェクトを立ち上げる
                </a>
            </li>
        </ul>
    </section>
    
    <section class="footer_bottom">
        <div class="footer_logo">
            <a href="/">
                <img src="<?php bloginfo('template_directory'); ?>/images/sm/s-footer-logo.png" alt="<?php bloginfo('name'); ?>">
            </a>
        </div>
        <ul class="sns-area">
           <li>
               <a href="<?php echo home_url('/feed'); ?>" target="_blank">
                 <img src="<?php bloginfo('template_directory'); ?>/images/sm/s-footer-sns-icon01.png" alt="">
               </a>
           </li>
            <li>
                <a href="<?= LG_GOOGLE_PLUS; ?>" target="_blank">
                    <img src="<?php bloginfo('template_directory'); ?>/images/sm/s-footer-sns-icon02.png" alt="">
                </a>
            </li>
            <li>
                <a href="<?= LG_TWITTER; ?>" target="_blank">
                    <img src="<?php bloginfo('template_directory'); ?>/images/sm/s-footer-sns-icon03.png" alt="">
                </a>
            </li>
            <li>
                <a href="<?= LG_FACEBOOK_PAGE; ?>" target="_blank">
                    <img src="<?php bloginfo('template_directory'); ?>/images/sm/s-footer-sns-icon04.png" alt="">
                </a>
            </li>
        </ul>
        <div class="link">
            <span>
                <img src="<?php bloginfo('template_directory'); ?>/images/sm/footer_arrow.png" alt="→">
            </span>
            <a href="http://localgood.jp/">
                LOCAL GOOD 地域課題プラットフォーム
            </a>
        </div>
    </section>

    <?php if(is_home()):?>
    <div class="cw">
        COPYRIGHT© <?php bloginfo('name'); ?>. Some rights reserved.
    </div>
    <?php endif;?>
</footer>

<?php if(! is_home()):?>
<div class="sp_footer_logo-area">
    <ul class="clearfix">
        <li class="left">
            <a href="http://yokohamalab.jp/" target="_blank">
                <img src="<?php echo get_template_directory_uri(); ?>/images/logo_f_labo.jpg" alt="NPO法人 横浜コミュニティデザイン・ラボ">
            </a>
        </li>
        <li class="left">
            <a href="http://www.city.yokohama.lg.jp/seisaku/" target="_blank">
                <img src="<?php bloginfo('template_directory'); ?>/images/sm/s-footer-logo03.png" alt="画像：OPEN YOKOHAMA">
            </a>
        </li>
        <li class="left">
            <a href="http://goteo.org/" target="_blank">
                <img src="<?php bloginfo('template_directory'); ?>/images/sm/s-footer-logo04.png" alt="画像：Fundacion Goteo">
            </a>
        </li>
        <li class="left">
            <a href="http://www.ycu-coc.jp/" target="_blank">
                <img src="<?php bloginfo('template_directory'); ?>/images/sm/s-footer-logo05.png" alt="画像：横浜市立大学影山摩子弥研究室">
            </a>
        </li>
        <li class="left">
            <a href="http://labo.wtnv.jp/" target="_blank">
                <img src="<?php bloginfo('template_directory'); ?>/images/sm/s-footer-logo06.png" alt="画像：首都大学東京渡邉英徳研究室">
            </a>
        </li>
        <li class="left">
            <a href="http://designcat.co/" target="_blank">
                <img src="<?php bloginfo('template_directory'); ?>/images/sm/s-footer-logo07.png" alt="画像：Design Cat">
            </a>
        </li>
        <li class="left">
            <a href="http://info-lounge.jp/" target="_blank">
                <img src="<?php bloginfo('template_directory'); ?>/images/sm/s-footer-logo08.jpg" alt="画像：インフォ・ラウンジ合同会社">
            </a>
        </li>
        <li class="left">
            <a href="http://www.accenture.com/jp-ja/Pages/index.aspx" target="_blank">
                <img src="<?php bloginfo('template_directory'); ?>/images/sm/s-footer-logo02.png" alt="画像：アクセンチュア株式会社">
            </a>
        </li>
    </ul>
    <div class="cw">
        COPYRIGHT© <?php bloginfo('name'); ?>. Some rights reserved.
    </div>
</div>
<?php endif;?>
<?php wp_footer(); ?>
</div><!--.container-->
</body>
</html>