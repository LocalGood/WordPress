<?php
get_template_part('header', 'sp');
?>
    <div class="underlayer_wrapper page_sp_php">
        <?php breadcrumbs(); ?>
        <div class="inner">
            <div class="underlayer_title_area">
                <?php if (have_posts()): the_post(); ?>
                    <h2 class="common_underlayer_title-h2">
                        <img src="<?php echo get_option('lg_config__page_ttl_prefix'); ?>">
                        <?php the_title(); ?>
                    </h2>
                    <div class="content">
                        <?php the_content(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div><!--.contents_wrapper-->
<?php
get_template_part('footer', 'sp');
?>