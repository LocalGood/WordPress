<?php get_header(); ?>
<div class="underlayer_wrapper">
    <?php include( "s-post_nav.php" ); ?>
    <div>

        <?php knows_map_bar(); ?>
		<div id="gmap" class="default-close"></div>

        <div class="list_pic_wrapper">
            <div class="list_pic">
                <div class="list_pic_layout">
                    <?php
                    if (have_posts()):
                        while (have_posts()): the_post();
                            article_box();
                        endwhile; ?>
                    <?php else: ?>
                        <p class="articles__no_post">検索条件に合致する投稿がありませんでした。</p>
                    <?php endif; ?>
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
    </div>
</div>
<?php
get_template_part( 'footer', 'sp' );
?>
