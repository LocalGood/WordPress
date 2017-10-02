<?php
if(DEVICE == 'sp'):
    // スマホ
    get_template_part('taxonomy', 'project_theme-sp');
else:
    get_header(); ?>

    <div class="c-contents_wrapper c-w1096">

        <?php breadcrumbs(); ?>

        <?php
        global $post;
        $term_info = get_term_by('slug', get_query_var('term'), 'project_theme');
        ?>

        <div class="c-page_title_wrapper">
            <h2 class="c-page_title c-title05"><?php single_term_title(); ?></h2>
            <p class="c-page_title_subtext"><?= term_description(); ?></p>
        </div>

        <?php
        $paged = get_query_var('paged');
        $args      = array(
            'tax_query' => array(
                array(
                    'taxonomy' => 'project_theme',
                    'terms'    => array( $term_info->slug ),
                    'field'    => 'slug',
                    'operator' => 'IN'
                )
            ),
            'posts_per_page' => 15,
            'paged' => $paged
        );

        query_posts( $args );
        if (have_posts()): ?>
            <div class="article_area">
                <div class="article_box__wrapper">
                    <?php
                    while (have_posts()): the_post();
                        article_box();
                    endwhile;
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
            <?php
        endif;
        ?>
    </div><!-- .c-contents_wrapper -->
<?php
get_footer();
endif;
?>