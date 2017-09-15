<?php
if(DEVICE == 'sp'):
// スマホ
    get_template_part('archive', 'skills-sp');
else:
get_header();
    ?>
<div class="c-contents_wrapper c-w1096">
    <?php breadcrumbs(); ?>
    <div class="inner two_column_wrapper">
        <div class="key_topic_box">
            <div class="topix_box">
                <h1 class="c-group_title01">スキルについて</h1>
                <div class="desc">
                    <?php bloginfo('name'); ?>でカテゴライズされているスキルを各スキルガイドが紹介します。そのスキルを募集しているプロジェクトや、スキルを持っているユーザーも紹介します。
                </div>
            </div>
			<div class="skill_guide_box__wrapper">
        <?php if (have_posts()): while (have_posts()): the_post();
            $custom_fields = get_post_custom($post->ID);
            //var_dump($custom_fields);
        ?>
            <div class="skill_guide_box">
                <p class="thumb"><?= wp_get_attachment_image($custom_fields['ssGuideThumbnail'][0],'thumbnail'); ?></p>
                <p class="skill"><?php the_title() ?></p>
                <p class="name"><a href="<?php the_permalink(); ?>"><?= $custom_fields['ssGuideName'][0]; ?></a></p>
            </div>
        <?php endwhile; endif; ?>
			</div>
        </div>
    </div>
</div>

    <?php
    get_footer();
endif;
?>
