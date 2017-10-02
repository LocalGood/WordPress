<?php
get_header();
?>
    <div class="underlayer_wrapper taxonomy_project_theme_page">

        <div class="archive_all underlayer_title_area">
            <div class="post_title">
                <h1 class="common_underlayer_title-h2"><?php single_term_title(); ?></h1>
                <div class="common_underlayer_title-h2__sub_title">
                    <?= term_description(); ?>
                </div>
            </div>
        </div><!-- .archive_all -->

        <?php
        global $post;
        $term_info = get_term_by( 'slug', get_query_var( 'term' ), 'project_theme' );
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
            'posts_per_page' => 9,// temporary
            'paged' => $paged
        );
        query_posts( $args );
        if (have_posts()): ?>
            <div class="list_pic_wrapper">
                <div class="list_pic">
                    <div class="list_pic_layout">
                        <h2 class="group_title"><?= $term_info->name ?></h2>
                        <?php
                        while (have_posts()): the_post();
                            article_box();
                        endwhile;

                        ?>
                        <div style="clear: both"></div>
                    </div>
                </div><!--.list_pic-->
            </div><!--.list_pic_wrapper-->
            <div class="pager">
                <div class="pager_container">
                    <div class="tablenav">
                        <?php
                        paging();
                        ?>
                    </div>
                </div>
            </div>
            <?php
        endif;
        ?>
    </div><!-- .contents_wrapper -->
<?php
get_template_part( 'footer', 'sp' );
?>
