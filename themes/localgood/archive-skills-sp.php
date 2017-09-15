<?php
get_header();
?>
<div class="contents_wrapper">
    <?php breadcrumbs();
//    show_skill_tabs();
    ?>
    <div class="key_topic_box">
        <div class="topix_box">
            <h1 class="skill_guide__title">スキルについて</h1>
            <div class="desc">
                <?php bloginfo('name'); ?>でカテゴライズされているスキルを各スキルガイドが紹介します。そのスキルを募集しているプロジェクトや、スキルを持っているユーザーも紹介します。
            </div>
        </div>
    </div>
    <div class="skill_guide_wrapper">
        <?php if (have_posts()): while (have_posts()): the_post();
            $custom_fields = get_post_custom($post->ID);
            //var_dump($custom_fields);
            ?>
            <div class="skill_guide_box clearfix">
                <p class="thumb"><a href="<?php the_permalink(); ?>"><?= wp_get_attachment_image($custom_fields['ssGuideThumbnail'][0],array(100,100),true); ?></a></p>
                <p class="skill"><?php the_title() ?></p>
                <p class="name"><a href="<?php the_permalink(); ?>"><?= $custom_fields['ssGuideName'][0]; ?></a></p>
            </div>
        <?php endwhile; endif; ?>
    </div>
</div>

<?php
get_template_part('footer', 'sp');
?>