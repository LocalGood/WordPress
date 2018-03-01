<div class="sidebar">
    <?php
    if ($cfs):
        $lat = $cfs->get('lgLatitude');
        $long = $cfs->get('lgLongitude');
        if (!empty($lat) && !empty($long)):
            ?>
            <script type="text/javascript">
              jQuery(function ($) {
                var mapdiv = document.getElementById('gmap')
                var point = new google.maps.LatLng(<?php echo $lat ?>, <?php echo $long ?>)
                var myOptions = {
                  zoom: 16,
                  center: point,
                  mapTypeId: google.maps.MapTypeId.ROADMAP,
                  scaleControl: true
                }
                var map = new google.maps.Map(mapdiv, myOptions)
                var marker = new google.maps.Marker({
                  position: point,
                  map: map
                })
                if (status == google.maps.GeocoderStatus.OK) {
                  map.setCenter(results[0].geometry.location)
                  marker.setPosition(results[0].geometry.location)
                }
              })
            </script>
            <div class="side_block gmap">
                <p class="title">地図</p>
                <div id="gmap"></div>
            </div>
        <?php
        endif;
    endif;
    ?>

    <?php
    if (is_singular('post')):
        ?>
        <div class="side_block theme_list">
            <p class="title">カテゴリー</p>
            <ul>
                <?php
                $args = array(
                    'title_li' => '',
                    'depth' => 1,
                    'exclude' => 1,
                    'show_count' => false
                );
                wp_list_categories($args);
                ?>
            </ul>
        </div>
    <?php
    endif;

    if (is_single()):
        $themes = get_terms('project_theme');
        if ($themes):
            ?>
            <div class="side_block theme_list">
                <p class="title">テーマ</p>
                <ul>
                    <?php
                    foreach ($themes as $theme):
                        if (empty($theme->name))
                            continue;
                        $link = get_term_link($theme->slug, 'project_theme');
                        ?>
                        <li><a href="<?php echo $link; ?>"><?php echo $theme->name ?></a></li>
                    <?php
                    endforeach;
                    ?>
                </ul>
            </div>
        <?php
        endif;

        $areas = get_terms('project_area');
        if ($areas):
            ?>
            <div class="side_block area_list">
                <p class="title">エリア</p>
                <div class="area_box">
                    <ul>
                        <?php
                        foreach ($areas as $area):
                            if (empty($area->name))
                                continue;
                            $link = get_term_link($area->slug, 'project_area');
                            ?>
                            <li><a href="<?php echo $link; ?>"><?php echo $area->name ?></a></li>
                        <?php
                        endforeach;
                        ?>
                    </ul>
                </div>
            </div>
        <?php
        endif;
    endif;
    ?>
    <div class="topic_box banner_area">
        <?php
        $page_id = 211;
        $page = get_post($page_id, 'OBJECT', 'raw');
        $page_include = apply_filters('the_content', $page->post_content);
        echo $page_include;
        ?>
    </div>

</div><!-- .sidebar -->