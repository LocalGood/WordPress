<?php
/*

Template Name: post-archives

*/
if (DEVICE == 'sp'):
    // スマホ
    get_template_part( 'post', 'archives-sp' );
else:
    get_header();
    global $post, $paged;
    ?>
    <div class="c-contents_wrapper c-w1096">
        <?php breadcrumbs(); ?>

        <?php knows_head_tab( $post ); ?>

        <div class="c-page_title_wrapper">
            <h2 class="c-page_title c-title05"><img src="<?php echo get_option( 'lg_config__page_ttl_prefix' ); ?>"><?php echo get_the_title(); ?></h2>
            <p class="c-page_title_subtext"><?php echo $post->post_content; ?></p>
        </div>

        <?php knows_map_bar(); ?>
        <div id="gmap" ></div>
        <?php
        $post_not = array();
        $feature_html = '';
        if ( ! isset( $_GET['project_area'] ) && ! isset( $_GET['theme'] ) && $paged <= 1) :
            $feature_post = new WP_Query( feature_posts_args() );
            $i    = 0;
            if ($feature_post->have_posts()):
                ob_start();
                ?>
                <section class="pickup_area c-clearfix">
                    <h2 class="c-group_title01"><img src="<?php echo get_option( 'lg_config__group_ttl_prefix' ); ?>" >PICK UP!</h2>
					<section class="topic_box__wrapper">
						<?php
						while ($feature_post->have_posts()) :$feature_post->the_post();
							key_topic_box( $i );
							array_push( $post_not, $post->ID );
							$i ++;
						endwhile; ?>
					</section>
                </section>
                <?php
                $feature_html = ob_get_contents();
                ob_clean();
            endif;
        endif;
        wp_reset_postdata();
        if(is_page('lgnews')){ echo $feature_html; }
        ?>
        <div class="article_area">
            <h2 class="c-group_title01">
				<img src="<?php echo get_option( 'lg_config__group_ttl_prefix' ); ?>" ><?php the_title(); ?>
            </h2>
            <div class="article_box__wrapper">
                <?php
                query_posts( post_archives_args( $post_not ) );
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
        <?php
        wp_reset_query();
        if(is_page('lgplayer')){ echo $feature_html; }
        ?>
    </div><!--.c-contents_wrapper-->
    <?php
    get_footer();
endif;
?>