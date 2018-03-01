<?php
if (DEVICE == 'sp'):
    // スマホ
    get_template_part('single', 'subject-sp');
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

                <div class="single_contents_box__image">
                    <?php
                    $attached_medias_obj = get_attached_media('image', $post->ID);
                    foreach ($attached_medias_obj as $id => $obj) {
                        echo wp_get_attachment_image($obj->ID, 'large');
                    }
                    ?>
                </div>

                <div class="side_block gmap">
                    <?php
                    $data_lonlat = get_post_lonlat_attr();
                    if (!empty($data_lonlat)):
                        ?>
                        <div id="gmap" <?php echo $data_lonlat; ?> ></div>
                    <?php
                    endif;
                    ?>
                </div>

                <?php
                only_buttons(false);
                LG::like();
                LG::comments();
                social_buttons(false, 'only');
                ?>
                <a class="c-back_button" href="<?php echo home_url('/subject/'); ?>">みんなの声へ戻る</a>
            </div><!-- .single_contents_box -->
            <?php related_subjects_or_tweets(); ?>
        <?php endif; ?>
    </div><!-- .contents_wrapper -->
    <?php
    get_footer();
endif;
?>