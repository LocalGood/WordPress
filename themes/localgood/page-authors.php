<?php get_header(); ?>
<?php if (DEVICE == 'sp'): ?>
    <div class="underlayer_wrapper author_list">
        <?php include( 's-post_nav.php' ); ?>
        <div class="inner">
            <div class="list_pic_wrapper">
                <div class="list_pic">
                    <div class="list_pic_layout underlayer_title_area">
                        <h2 class="group_title common_underlayer_title-h2"><img src="<?php echo get_option( 'lg_config__page_ttl_prefix' ); ?>"><?= get_the_title(); ?></h2>
                        <?php writers_archive(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="c-contents_wrapper c-w1096">
        <?php breadcrumbs(); ?>
        <div class="c-page_title_wrapper">
            <h2 class="c-page_title c-title05"><img src="<?php echo get_option( 'lg_config__page_ttl_prefix' ); ?>"><?= get_the_title(); ?></h2>
        </div>
        <?php writers_archive(); ?>
    </div><!-- /.c-contents_wrapper -->
<?php endif; ?>

<?php
if (DEVICE == 'sp'):
    get_template_part( 'footer', 'sp' );
else:
    get_footer();
endif;
?>
