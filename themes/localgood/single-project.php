<?php get_header(); ?>

<?php
if (have_posts()): the_post();
    ?>
    <div class="contents_wrapper">
        <div class="inner">
            <?php breadcrumbs(); ?>
            <?php
            if (has_post_thumbnail()):
                ?>
                <div class="main_visual">
                    <?php
                    the_post_thumbnail('single-main_visual');
                    ?>
                </div>
            <?php
            endif;
            ?>
            <div class="single_contents_box">
                <div class="inner">
                    <?php get_single_post(); ?>
                </div>
            </div><!-- .single_contents_box -->
            <?php get_sidebar(); ?>
        </div><!-- .inner -->
    </div><!-- .contents_wrapper -->
<?php
endif;
?>
<?php get_footer();?>