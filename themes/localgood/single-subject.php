<?php
if (DEVICE == 'sp'):
    // スマホ
    get_template_part( 'single', 'subject-sp' );
else:
    get_header();
    global $post;
    ?>

    <div class="c-contents_wrapper c-w1096">

        <?php if (have_posts()): the_post(); ?>
            <?php breadcrumbs(); ?>
            <?php knows_head_tab(); ?>

            <div class="single_contents_box">

                <?php get_single_post(); ?>

                <div class="side_block gmap">
                    <?php
                    $data_lonlat = get_post_lonlat_attr();
                    if (!empty($data_lonlat)):
                    ?>
                    <div id="gmap" <?= $data_lonlat; ?> ></div>
                    <?php
                    endif;
                    ?>
                </div>

                <?php social_buttons(false, true); ?>

				<a class="c-back_button" href="<?= home_url( '/subject/' ); ?>">みんなの声へ戻る</a>
	            <?php related_posts(); ?>
            </div><!-- .single_contents_box -->

        <?php endif; ?>

    </div><!-- .contents_wrapper -->

    <?php
    get_footer();
endif;
?>