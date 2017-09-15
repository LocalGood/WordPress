<?php

// SimpleXMLElement拡張 for CDATA対応
class SimpleXMLExtended extends SimpleXMLElement
{
    public function addCData($cdata_text) {
        $node= dom_import_simplexml($this);
        $no = $node->ownerDocument;
        $node->appendChild($no->createCDATASection($cdata_text));
    }
}

// KMZ出力
function get_subject_posts(){

    global $post;

    $args = array(
        'post_type' => array('subject','tweet'),
        'posts_per_page' => -1
    );
    $subjects_query = new WP_Query($args);


    if ($subjects_query->have_posts()) {

        /***
         * KML
         */

        $_node_name = 'localgood_subject_' . date('YmdGis');
        $_node_open = '1';

        $kml_root = new SimpleXMLExtended('<?xml version="1.0" encoding="UTF-8"?><kml xmlns="http://www.opengis.net/kml/2.2" xmlns:gx="http://www.google.com/kml/ext/2.2" xmlns:kml="http://www.opengis.net/kml/2.2" xmlns:atom="http://www.w3.org/2005/Atom"><Folder><name>' . $_node_name . '</name><open>' . $_node_open . '</open></Folder></kml>');

        /*
         *  wordpress
         */
        $kml_document_wp = $kml_root->Folder->addChild('Document');
        $kml_document_wp->addChild('name','wp');
        $kml_document_wp->addChild('Folder');
        $kml_document_wp->Folder->addChild('name', 'Subject Mapping');

        $style_wp = $kml_document_wp->addChild('StyleMap');
        $style_wp->addAttribute('id', 'wp_style');

        $style_wp_pair = $style_wp->addChild('Pair');
        $style_wp_pair->addChild('key', 'normal');
        $style_wp_pair->addChild('styleUrl', '#wp_nm');

        $style_wp_pair = $style_wp->addChild('Pair');
        $style_wp_pair->addChild('key', 'highlight');
        $style_wp_pair->addChild('styleUrl', '#wp_hl');

        $style_hl = $kml_document_wp->addChild('Style');
        $style_hl->addAttribute('id', 'wp_hl');

        $style_hl_icon = $style_hl->addChild('IconStyle');
        $style_hl_icon->addChild('color', 'ccffffff');
        $style_hl_icon->addChild('scale', '0.8');
//        $style_hl_icon->addChild('Icon')->addChild('href','http://maps.google.com/mapfiles/kml/paddle/ylw-circle.png');
//        $style_hl_icon->addChild('Icon')->addChild('href','http://media.mapping.jp/orange_circle.png');
        $style_hl_icon->addChild('Icon')->addChild('href', get_template_directory_uri() . '/images/lg_yellow_circle.png');

        $style_hl_icon_hotspot = $style_hl_icon->addChild('hotSpot');
        $style_hl_icon_hotspot->addAttribute('x', '0.5');
        $style_hl_icon_hotspot->addAttribute('y', '0.5');
        $style_hl_icon_hotspot->addAttribute('xunits', 'fraction');
        $style_hl_icon_hotspot->addAttribute('yunits', 'fraction');

        $style_hl_label = $style_hl->addChild('LabelStyle');
        $style_hl_label->addChild('color','80ffffff');
//        $style_hl_label->addChild('scale','0.8');
        $style_hl_label->addChild('scale','0');

        $style_hl->addChild('BalloonStyle')->addChild('text', '$[description]');

        $style_hl->addChild('LineStyle')->addChild('color', '4dffffff');

        $style_nm = $kml_document_wp->addChild('Style');
        $style_nm->addAttribute('id', 'wp_nm');

        $style_nm_icon = $style_nm->addChild('IconStyle');
        $style_nm_icon->addChild('color', 'ccffffff');
        $style_nm_icon->addChild('scale', '0.6');
//        $style_nm_icon->addChild('Icon')->addChild('href','http://maps.google.com/mapfiles/kml/paddle/ylw-circle.png');
//        $style_nm_icon->addChild('Icon')->addChild('href','http://media.mapping.jp/orange_circle.png');
        $style_nm_icon->addChild('Icon')->addChild('href', get_template_directory_uri() . '/images/lg_yellow_circle.png');

        $style_nm_icon_hotspot = $style_nm_icon->addChild('hotSpot');
        $style_nm_icon_hotspot->addAttribute('x', '0.5');
        $style_nm_icon_hotspot->addAttribute('y', '0.5');
        $style_nm_icon_hotspot->addAttribute('xunits', 'fraction');
        $style_nm_icon_hotspot->addAttribute('yunits', 'fraction');

        $style_nm->addChild('LabelStyle')->addChild('scale','0');

        $style_nm->addChild('BalloonStyle')->addChild('text', '$[description]');

        $style_nm->addChild('LineStyle')->addChild('color', '4dffffff');

        /*
         *  twitter
         */
        $kml_document_tw = $kml_root->Folder->addChild('Document');
        $kml_document_tw->addChild('name','tw');
        $kml_document_tw->addChild('Folder');
        $kml_document_tw->Folder->addChild('name', 'Subject Mapping');

        $style_tw = $kml_document_tw->addChild('StyleMap');
        $style_tw->addAttribute('id', 'tw_style');

        $style_tw_pair = $style_tw->addChild('Pair');
        $style_tw_pair->addChild('key', 'normal');
        $style_tw_pair->addChild('styleUrl', '#tw_nm');

        $style_tw_pair = $style_tw->addChild('Pair');
        $style_tw_pair->addChild('key', 'highlight');
        $style_tw_pair->addChild('styleUrl', '#tw_hl');

        $style_hl = $kml_document_tw->addChild('Style');
        $style_hl->addAttribute('id', 'tw_hl');

        $style_hl_icon = $style_hl->addChild('IconStyle');
        $style_hl_icon->addChild('color', 'ccffffff');
        $style_hl_icon->addChild('scale', '0.8');
//    $style_hl_icon->addChild('Icon')->addChild('href','http://maps.google.com/mapfiles/kml/paddle/ltblu-circle.png');
        $style_hl_icon->addChild('Icon')->addChild('href', get_template_directory_uri() . '/images/lg_cyan_circle.png');

        $style_hl_icon_hotspot = $style_hl_icon->addChild('hotSpot');
        $style_hl_icon_hotspot->addAttribute('x', '0.5');
        $style_hl_icon_hotspot->addAttribute('y', '0.5');
        $style_hl_icon_hotspot->addAttribute('xunits', 'fraction');
        $style_hl_icon_hotspot->addAttribute('yunits', 'fraction');

        $style_hl_label = $style_hl->addChild('LabelStyle');
        $style_hl_label->addChild('color','80ffffff');
//        $style_hl_label->addChild('scale','0.8');
        $style_hl_label->addChild('scale','0');

        $style_hl->addChild('BalloonStyle')->addChild('text', '$[description]');

        $style_hl->addChild('LineStyle')->addChild('color', '4dffffff');

        $style_nm = $kml_document_tw->addChild('Style');
        $style_nm->addAttribute('id', 'tw_nm');

        $style_nm_icon = $style_nm->addChild('IconStyle');
        $style_nm_icon->addChild('color', 'ccffffff');
        $style_nm_icon->addChild('scale', '0.6');
//        $style_nm_icon->addChild('Icon')->addChild('href','http://maps.google.com/mapfiles/kml/paddle/ltblu-circle.png');
//        $style_nm_icon->addChild('Icon')->addChild('href','http://media.mapping.jp/cyan_circle.png');
        $style_nm_icon->addChild('Icon')->addChild('href', get_template_directory_uri() . '/images/lg_cyan_circle.png');

        $style_nm_icon_hotspot = $style_nm_icon->addChild('hotSpot');
        $style_nm_icon_hotspot->addAttribute('x', '0.5');
        $style_nm_icon_hotspot->addAttribute('y', '0.5');
        $style_nm_icon_hotspot->addAttribute('xunits', 'fraction');
        $style_nm_icon_hotspot->addAttribute('yunits', 'fraction');

        $style_nm->addChild('LabelStyle')->addChild('scale','0');

        $style_nm->addChild('BalloonStyle')->addChild('text', '$[description]');

        $style_nm->addChild('LineStyle')->addChild('color', '4dffffff');

        while ($subjects_query->have_posts()) {

            $subjects_query->the_post();

            $_array = array();

            $cf = get_post_custom($post->ID);

            $latlng = array(0,0);

            if (get_post_type() == 'subject'){
                // 投稿地域課題
                if (!empty($cf['sbLatLng']) && (strpos($cf['sbLatLng'][0], ',') > 0))
                    $latlng = explode(',', $cf['sbLatLng'][0]);
                $_content = get_the_excerpt();
                $_thumb = get_the_post_thumbnail($post->ID, 'archive-thumbnails');
                $_id = 'subject';

                $_placemark = $kml_document_wp->Folder->addChild('Placemark');

                $_placemark->addChild('styleUrl','#wp_style');

                // name and TimeStamp
                $_placemark->addChild('name', get_the_title());
                $_placemark->addChild('TimeStamp')->addChild('when', get_the_time('c'));

                // description w/ CData
                $_doing_text =
                    '<p class="doing_text">' . get_the_time('c') . '</p>' .
                    '<p class="doing_text">' . $_content . '</p>';

                if (has_post_thumbnail($post->ID)){
                    $_img = get_the_post_thumbnail($post->ID,'related-posts');
                    $_doing_text .= '<p class="subject_img">' . $_img . '</p>';
                };

                $_description = $_placemark->addChild('description');
                $_description->addCData($_doing_text);

                // Point
                $_point = $_placemark->addChild('Point');
                $_point->addChild('altitudeMode', 'absolute');
                $_point->addChild('coordinates', $latlng[1] . ',' . $latlng[0]);

            } elseif (get_post_type() == 'tweet') {
                // twitter課題
                if (!empty($cf['twLatLng']) && (strpos($cf['twLatLng'][0], ',') > 0))
                    $latlng = explode(',', $cf['twLatLng'][0]);
                $_content = get_the_content();
                $_thumb = '';
                $_id = 'tweet';

                $_placemark = $kml_document_tw->Folder->addChild('Placemark');

                $_placemark->addChild('styleUrl','#tw_style');

                // name and TimeStamp
                $_placemark->addChild('name', get_the_title());
                $_placemark->addChild('TimeStamp')->addChild('when', get_the_time('c'));

                // description w/ CData
                $_doing_text =
                    '<p class="doing_text">' . get_the_time('c') . '</p>' .
                    '<p class="doing_text">' . $_content . '</p>';

                if (has_post_thumbnail($post->ID)){
                    $_img = get_the_post_thumbnail($post->ID,'related-posts');
                    $_doing_text .= '<p class="subject_img">' . $_img . '</p>';
                };

                $_description = $_placemark->addChild('description');
                $_description->addCData($_doing_text);

                // Point
                $_point = $_placemark->addChild('Point');
                $_point->addChild('altitudeMode', 'absolute');
                $_point->addChild('coordinates', $latlng[1] . ',' . $latlng[0]);
            }
        }

        $kml = new DOMDocument('1.0');
        $kml->loadXML($kml_root->asXML());
        $kml->formatOutput = true;

//        header('Content-Type: application/xml; charset=utf-8');
//        header('Content-type: application/vnd.google-earth.kml+xml');
        $kmlString = $kml->saveXML();

        header("Content-Type: application/json; charset=utf-8");
        echo json_encode(simplexml_load_string($kmlString));


        //header('Content-Type: application/vnd.google-earth.kmz');
        //header('Content-Disposition: attachment; filename="localgood_subjects.kmz"');
/*
        $dirpath = ABSPATH . '/kml/';

//        if (!file_exists($dirpath)){
//            mkdir($dirpath, 0777);
//            chmod($dirpath, 0777);
//        }

        $file = $dirpath . 'localgood_subjects.kmz';
        $zip = new ZipArchive();

        if ($zip->open($file, ZIPARCHIVE::CREATE)!==TRUE) {
            exit("cannot open <$file>\n");
        };
        $zip->addFromString("doc.kml", $kmlString);
        $zip->close();
*/
    }

    wp_reset_postdata();
}


// CZML出力
function get_subject_posts_json(){

    global $post;

    $args = array(
        'post_type' => array('subject','tweet'),
        'posts_per_page' => -1
    );
    $subjects_query = new WP_Query($args);

    $json = '';

    if ($subjects_query->have_posts()) {

        // CZML base
        $_document_id = 'document';
        $_document_ver = '1.0';
        // LocalGood specific
        $_document_name = 'localgood_subject_' . date('YmdGis');

        // 配列で作成
        $czml_root = array();

        // CZML基本情報
        $czml_root[0] = array(
            'id' => $_document_id,
            'name' => $_document_name,
            'version' => $_document_ver
        );


        while ($subjects_query->have_posts()) {

            $subjects_query->the_post();
            $cf = get_post_custom($post->ID);
            $latlng = array(0,0);

            $subject = array();

            if (get_post_type() == 'subject'){
                // 投稿地域課題
                if (!empty($cf['sbLatLng']) && (strpos($cf['sbLatLng'][0], ',') > 0))
                    $latlng = explode(',', $cf['sbLatLng'][0]);
                $_content = get_the_content();
                $_title = get_the_title();
                $_id = $post->ID;

                // description
                $_doing_text =
                    '<p class="doing_text">' . get_the_time('c') . '</p>' .
                    '<p class="doing_text">' . $_content . '</p>';
                if (has_post_thumbnail($post->ID)){
                    $_img = get_the_post_thumbnail($post->ID,'related-posts');
                    $_doing_text .= '<p class="subject_img">' . $_img . '</p>';
                };
                $_description = $_doing_text;

                // Point
                $_position = array(
                    'cartographicDegrees' => array(
                        (float)$latlng[1],      // lat
                        (float)$latlng[0],      // long
                        0                       // height
                    )
                );

//                $_image = get_template_directory_uri() . '/images/lg_yellow_circle.png';
                $_image = './lg_yellow_circle.png';

                $subject = array(
                    'id' => $_id,
                    'name' => $_title,
                    'description' => $_description,
                    'billboard' => array(
                        'horizontalOrigin'=> 'CENTER',
                        'image'=> $_image,
                        'scale'=> 0.6,
                        'show'=> 'true',
                        'verticalOrigin'=> 'CENTER'
                    ),
                    'position' => $_position
                );


            } elseif (get_post_type() == 'tweet') {
                // twitter課題
                if (!empty($cf['twLatLng']) && (strpos($cf['twLatLng'][0], ',') > 0))
                    $latlng = explode(',', $cf['twLatLng'][0]);
                $_content = get_the_content();
                $_title = get_the_title();
                $_id = $post->ID;

                // description
                $_doing_text =
                    '<p class="doing_text">' . get_the_time('c') . '</p>' .
                    '<p class="doing_text">' . $_content . '</p>';
                if (has_post_thumbnail($post->ID)){
                    $_img = get_the_post_thumbnail($post->ID,'related-posts');
                    $_doing_text .= '<p class="subject_img">' . $_img . '</p>';
                };
                $_description = $_doing_text;

                // Point
                $_position = array(
                    'cartographicDegrees' => array(
                        (float)$latlng[1],      // lat
                        (float)$latlng[0],      // long
                        0                       // height
                    )
                );

//                $_image = get_template_directory_uri() . '/images/lg_cyan_circle.png';
                $_image = './lg_cyan_circle.png';

                $subject = array(
                    'id' => $_id,
                    'name' => $_title,
                    'description' => $_description,
                    'billboard' => array(
                        'horizontalOrigin'=> 'CENTER',
                        'image'=> $_image,
                        'scale'=> 0.6,
                        'show'=> 'true',
                        'verticalOrigin'=> 'CENTER'
                    ),
                    'position' => $_position
                );



            }
            if (!empty($subject)){
                array_push($czml_root, $subject);
            }
        }

//        header("Content-Type: application/json; charset=utf-8");
//        echo json_encode($czml_root);
        $json = json_encode($czml_root);
    }

    $dirpath = ABSPATH . '/kml/';

//    if (!file_exists($dirpath)){
//        mkdir($dirpath, 0777);
//        chmod($dirpath, 0777);
//    }

    $file = $dirpath . 'localgood_subjects.czml';
    file_put_contents($file, $json, LOCK_EX);

    wp_reset_postdata();
}

add_action('wp', 'my_kml_activation');
function my_kml_activation() {
    wp_clear_scheduled_hook('my_kml_hourly_event');
    if ( !wp_next_scheduled( 'my_kml_hourly_event' ) ) {
        wp_schedule_event( time(), 'hourly', 'my_kml_hourly_event');
//        wp_schedule_event( time(), '2min', 'my_kml_hourly_event');
    }
}
//add_action('my_kml_hourly_event', 'get_subject_posts');
add_action('my_kml_hourly_event', 'get_subject_posts_json');
