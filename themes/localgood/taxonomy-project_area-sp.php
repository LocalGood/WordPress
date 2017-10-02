<?php
get_header(); ?>

    <div class="contents_wrapper">

        <div class="inner">
            <?php breadcrumbs(); ?>
        </div>

        <div class="archive_all">
            <div class="post_title">
                <h1><?php single_term_title(); ?></h1>
                <?= term_description(); ?>
            </div>
        </div><!-- .archive_all -->

        <?php
        global $post;
        $term_info = get_term_by( 'slug', get_query_var( 'term' ), 'project_area' );

        $args = array(
            'posts_per_page' => 15,
            'post_type'      => array( 'post', 'data' ),
            'tax_query'      => array(
                array(
                    'taxonomy' => 'project_area',
                    'terms'    => array( $term_info->slug ),
                    'field'    => 'slug',
                    'operator' => 'IN'
                )
            )
        );
        query_posts( $args );
        if (have_posts()): ?>
            <div class="list_pic_wrapper">
                <div class="list_pic">
                    <div class="list_pic_layout">
                        <?php
                        while (have_posts()): the_post();
                            article_box();
                        endwhile;
                        ?>
                        <div class="pager" style="clear: both">
                            <div class="pager_container">
                                <?php
                                paging();
                                ?>
                            </div>
                        </div>
                        <div style="clear: both"></div>
                    </div>
                </div><!--.list_pic-->
            </div><!--.list_pic_wrapper-->
            <?php
        endif;
        ?>
    </div><!-- .contents_wrapper -->
<?php
get_template_part( 'footer', 'sp' )
?>