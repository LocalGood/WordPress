<?php get_header(); ?>
<div class="contents_wrapper">
    <div class="inner">
        <?php breadcrumbs(); ?>
        <?php
        if (have_posts()):
            $terms = get_the_terms($post->ID, 'data_type');
            if (!empty($terms)):
                $terms = array_shift($terms);
                ?>
                <h1><?= $terms->name; ?>の一覧</h1>
            <?php
            endif;
            while (have_posts()): the_post();
                data_viz();
            endwhile;
        endif;
        ?>
        <div class="c-pager"">
            <div class="c-pager_container">
                <?php
                paging();
                ?>
            </div>
        </div>
    </div><!--.inner-->
</div>
<?php
    get_template_part('footer', 'sp')
?>