<footer>
    <section class="footer_menu_links">
        <div class="footer__link-title">
            ご利用にあたって
        </div>
        <ul>
            <li>
                <a href="<?php echo home_url('about'); ?>">
	                <?php bloginfo('name'); ?>について
                </a>
            </li>
            <li>
                <a href="<?php echo home_url('mailnews'); ?>">
                    メルマガ登録
                </a>
            </li>
            <li>
                <a href="<?php echo home_url('syoutorihikihou'); ?>">
                    特定商取引法について
                </a>
            </li>
            <li>
                <a href="<?php echo home_url('privacypolicy'); ?>">
                    プライバシーポリシー
                </a>
            </li>
            <li>
                <a href="<?php echo home_url('user_guide'); ?>">
                    ユーザーガイド
                </a>
            </li>
            <li>
                <a href="<?php echo esc_attr( get_option( 'lg_config__integration_url', false ) ); ?>/riyou_kiyaku_menu">
                    利用規約
                </a>
            </li>
            <li>
                <a href="<?php echo home_url('contact'); ?>">
                    お問い合わせ
                </a>
            </li>
            <li>
                <a href="<?php echo home_url('authors'); ?>">
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
                <a href="<?php echo home_url('lgnews'); ?>">
                    ニュース
                </a>
            </li>
            <li>
                <a href="<?php echo home_url('event'); ?>">
                    みんなの拠点/イベント
                </a>
            </li>
            <li>
                <a href="<?php echo home_url('lgplayer'); ?>">
                    人/団体
                </a>
            </li>
            <li>
                <a href="<?php echo home_url('data'); ?>">
                    データ
                </a>
            </li>
        </ul>
        <span>
            みんなの声
        </span>
        <ul>
            <li>
                <a href="<?php echo home_url('subject'); ?>">
                    投稿一覧
                </a>
            </li>
            <li>
                <a href="<?php echo home_url('submit_subject'); ?>">
                    あなたの声を投稿する
                </a>
            </li>
        </ul>

        <div class="footer__link-title">
            応援する
        </div>
        <ul>
            <li>
                <a href="<?php echo esc_attr( get_option( 'lg_config__goteo_baseurl', false ) ); ?>/discover">
                    プロジェクト一覧
                </a>
            </li>
            <li>
                <a href="<?php echo home_url('/challenge/'); ?>">
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
                <a href="<?php echo esc_attr( get_option( 'lg_config__sns_gp', false ) ); ?>" target="_blank">
                    <img src="<?php bloginfo('template_directory'); ?>/images/sm/s-footer-sns-icon02.png" alt="">
                </a>
            </li>
            <li>
                <a href="<?php echo esc_attr( get_option( 'lg_config__sns_tw', false ) ); ?>" target="_blank">
                    <img src="<?php bloginfo('template_directory'); ?>/images/sm/s-footer-sns-icon03.png" alt="">
                </a>
            </li>
            <li>
                <a href="<?php echo esc_attr( get_option( 'lg_config__sns_fb', false ) ); ?>" target="_blank">
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
</footer>

<div class="sp_footer_logo-area">
    <?php get_footer_under_banners(); ?>
    <div class="cw">
        COPYRIGHT© <?php bloginfo('name'); ?>. Some rights reserved.
    </div>
</div>
<?php wp_footer(); ?>
</div><!--.container-->
</body>
</html>