<?php
get_header(); ?>
<div class="underlayer_wrapper page_sp_php earth_view">
    <div class="inner">
        <?php breadcrumbs(); ?>
        <h1><?php the_title(); ?></h1>
    </div>
    <div class="list_pic_wrapper">
        <div class="list_pic">
            <div class="list_pic_layout">
                <h2 class="area_wrapper_title">エリア</h2>
                <div class="area_wrapper cf content">
                    <?php
                    $_page = get_page_by_path('earth_view-sp');
                    if (!empty($_page)){
                        echo $_page->post_content;
                    }
                    ?>
                </div>
            </div>
        </div><!--.list_pic-->
    </div><!--.list_pic_wrapper-->
    <div class="list_pic_wrapper">
        <div class="list_pic">
            <div class="list_pic_layout">
                <h2 class="area_wrapper_title">テーマ</h2>
                <div class="area_wrapper cf content">
                    <div class="theme_box">
                        <?php echo get_post_meta($post->ID , 'earth_view_area' ,true) ?>
                    </div><!--.theme_box-->
                </div>
            </div><!--.list_pic-->
        </div><!--.list_pic_wrapper-->
    </div><!--.contents_wrapper-->
    <div class="list_pic_wrapper">
        <div class="list_pic">
            <div class="list_pic_layout">
                <h2 class="area_wrapper_title"><?php echo get_option( 'lg_config__appName_kanji', false ); ?>を読む</h2>
                <div class="area_wrapper cf">
                    <div class="theme_box content">
                        <?php echo get_post_meta($post->ID , get_option( 'lg_config__appName_es', false ) . '_read' ,true) ?>
                    </div><!--.theme_box-->
                </div>
            </div><!--.list_pic-->
        </div><!--.list_pic_wrapper-->
    </div><!--.contents_wrapper-->
<?php
    get_template_part('footer', 'sp')
?>