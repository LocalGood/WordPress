<?php
get_header();
?>
    <div class="contents_wrapper earth_view">
    <div class="inner">
        <?php breadcrumbs(); ?>
        <h1><?php the_title(); ?></h1>
    </div>
    <div class="area_wrapper">
        <p>この投稿を管理者あてに通報しました。</p>
    </div>
<?php
get_template_part('footer', 'sp')
?>