<?php
if(DEVICE == 'sp'):
    // スマホ
    get_template_part('page', 'sp');
else:
    get_header();
?>

    <div class="c-contents_wrapper c-w1096">
        <?php breadcrumbs(); ?>
        <div class="static_page">
            <?php if(have_posts()): the_post(); ?>
                <div class="c-page_title_wrapper">
                    <h2 class="c-page_title c-title05"><img src="<?php echo get_option( 'lg_config__page_ttl_prefix' ); ?>"><?php the_title(); ?></h2>
                </div>
                <div class="single_contents_box">
                    <?php the_content(); ?>
                </div>
            <?php endif; ?>
        </div>
    </div><!--.contents_wrapper-->
<?php
get_footer();
endif;
?>