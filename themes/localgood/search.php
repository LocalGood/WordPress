<?php
get_header();
?>
    <div class="c-contents_wrapper c-w1096">
        <?php breadcrumbs(); ?>
        <?php
        global $wp_query;
        query_posts(array_merge(
            $wp_query->query,
            array(
                'post__not_in' => array(211)
            )
        ));
        if (have_posts()):
            $search_key = get_query_var('s');
            if (!empty($search_key)):
                ?>
                <div class="c-page_title_wrapper">
                    <h2 class="c-page_title c-title05"><img
                                src="<?php echo get_option('lg_config__page_ttl_prefix'); ?>">
                        「<?php echo $search_key; ?>」の検索結果
                    </h2>
                </div>
            <?php
            endif;
            ?>
            <div class="article_area">
                <?php
                while (have_posts()): the_post();
                    article_box();
                endwhile;
                ?>
            </div>
        <?php
        endif;
        ?>
    </div><!--.contents_wrapper-->
<?php
get_footer();