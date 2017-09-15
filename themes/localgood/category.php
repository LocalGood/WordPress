<?php
if(DEVICE == 'sp'):
    // スマホ
    get_template_part('category', 'sp');
else:
    get_header();
?>
    <div class="c-contents_wrapper c-w1096">

        <?php breadcrumbs(); ?>

        <?php
        $cat                       = get_the_category();
        $page_value['title']       = $cat[0]->name;
        $page_value['description'] = $cat[0]->description;
        ?>

        <div class="c-page_title_wrapper">
            <h2 class="c-page_title c-title05"><?= $page_value['title']; ?></h2>
        </div>

        <div class="article_area">
            <div class="article_box__wrapper">
                <?php
                if (have_posts()):
                    while (have_posts()): the_post();
                        article_box();
                    endwhile;
                endif;
                ?>
            </div>
            <div class="c-pager c-clearfix">
                <div class="c-pager_container">
                    <?php
                    paging();
                    ?>
                </div>
            </div>
        </div>
    </div><!--.c-contents_wrapper-->

<?php get_footer();
endif;
?>