<footer class="footer">

    <div class="footer__upper">
        <div class="c-clearfix c-w1096">
            <div class="footer__upper_left">
                <div class="footer__logo">
					<img src="<?php echo esc_attr( get_option( 'lg_config__footer_logo' ) ); ?>"
						 alt="<?php bloginfo( 'name' ); ?>ロゴ">
				</div>
                <ul class="footer__sns_link">
                    <li class="rss"><a href="<?php echo home_url('feed'); ?>" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/rss_btn.png" alt="rss" /></a></li>
                    <?php if ( !empty(get_option( 'lg_config__sns_gp', false )) ){ ?>
                        <li class="g_plus"><a href="<?php echo esc_attr( get_option( 'lg_config__sns_gp', false ) ); ?>" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/gplus_btn.png" alt="google plus" /></a></li>
                    <?php } ?>
                    <?php if ( !empty(get_option( 'lg_config__sns_tw', false )) ){ ?>
                        <li class="tw_btn"><a href="<?php echo esc_attr( get_option( 'lg_config__sns_tw', false ) ); ?>" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/tw_btn.png" alt="twitter" /></a></li>
                    <?php } ?>
                    <?php if ( !empty(get_option( 'lg_config__sns_fb', false )) ){ ?>
                        <li class="fb_btn"><a href="<?php echo esc_attr( get_option( 'lg_config__sns_fb', false ) ); ?>" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/fb_btn.png" alt="facebook" /></a></li>
                    <?php } ?>
                </ul>
                <a class="footer__integration_site" href="<?php echo esc_attr( get_option( 'lg_config__integration_url', false ) ); ?>/">LOCAL GOOD 地域課題プラットフォーム</a>
            </div>
            <ul class="footer__upper_right">
                <li>
                    <span class="footer__upper_second_title">ご利用にあたって</span>
                    <ul>
                        <li class="about"><a href="<?php echo home_url('about'); ?>"><?php bloginfo('name'); ?>について</a></li>
                        <li><a href="<?php echo home_url('mailnews'); ?>">メルマガ登録</a></li>
                        <li class="syoutorihikihou"><a href="<?php echo home_url('syoutorihikihou'); ?>">特定商取引法に基づく表記</a></li>
                        <li><a href="<?php echo home_url('privacypolicy'); ?>">プライバシーポリシー</a></li>
                        <li><a href="<?php echo home_url('user_guide'); ?>">ユーザーガイド</a></li>
                        <li><a href="<?php echo esc_attr( get_option( 'lg_config__integration_url', false ) ); ?>/riyou_kiyaku_menu">利用規約</a></li>
                        <li><a href="<?php echo home_url('contact'); ?>">お問い合わせ</a></li>
                        <li><a href="<?php echo home_url('authors'); ?>">記者一覧</a></li>
                    </ul>
                </li>
                <li>
                    <span class="footer__upper_second_title">地域を知る</span>
                    <span class="footer__upper__third_title">記事</span>
                    <ul>
                        <li><a href="<?php echo home_url('lgnews'); ?>">ニュース</a></li>
                        <li><a href="<?php echo home_url('event'); ?>">みんなの拠点/イベント</a></li>
                        <li><a href="<?php echo home_url('lgplayer'); ?>">人/団体</a></li>
                        <li><a href="<?php echo home_url('data'); ?>">データ</a></li>
                    </ul>
                    <span class="footer__upper__third_title">みんなの声</span>
                    <ul>
                        <li><a href="<?php echo home_url('subject'); ?>">投稿一覧</a></li>
                        <?php if( strpos($_SERVER['HTTP_HOST'], 'kitaq') === FALSE ): ?>
                        <li><a href="<?php echo home_url('submit_subject'); ?>">あなたの声を投稿する</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <li>
                    <span class="footer__upper_second_title">応援する</span>
                    <ul>
                        <li><a href="<?php echo esc_attr( get_option( 'lg_config__goteo_baseurl', false ) ); ?>">プロジェクト一覧</a></li>
                        <li><a href="<?php echo home_url('/challenge/'); ?>">プロジェクトを立ち上げる</a></li>
                    </ul>
					<span class="footer__upper_second_title">CSVダウンロード</span>
					<ul>
						<li><a href="<?php echo lg_get_csv_path('place', 'url'); ?>">みんなの拠点一覧</a></li>
						<li><a href="<?php echo lg_get_csv_path('event', 'url'); ?>">イベント一覧</a></li>
						<li><a href="<?php echo lg_get_csv_path('organizer', 'url'); ?>">主催者一覧</a></li>
					</ul>
                </li>
            </ul>
        </div>
    </div>
    <div class="footer__under">
        <div class="c-w1096">
            <?php get_footer_under_banners(); ?>
        </div>
        <p class="footer__copyright">
            <span>COPYRIGHT© <?php echo apply_filters('lg_footer_copyright_name', get_bloginfo('name')); ?>. Some rights reserved.</span>
        </p>
    </div>
</footer>
<?php wp_footer(); ?>
</div><!--.c-page_wrapper-->
</body>
</html>