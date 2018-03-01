<?php

//body_classにslug追加
function pagename_class( $classes = '' ) {
	if ( is_page() ) {
		$page      = get_post( get_the_ID() );
		$add_class = $page->post_name;
		$classes[] = $add_class;
	}
	if ( is_post_type_archive( 'tweet' ) ) {
		$classes[] = 'post-type-archive-subject';
	}
	if ( ! empty( $_POST['stage'] ) && ( $_POST['stage'] == 'confirm' ) ) {
		$classes[] = 'confirm-subject';
	}
	if ( ! is_post_type_archive( 'skills' ) ) {
		if ( is_archive() || is_page( 'authors' ) || ! is_singular( array( 'data', 'subject', 'skills', 'tweet' ) ) ) {
			$classes[] = 'author_view';
		}
	}

	return $classes;
}

add_filter( 'body_class', 'pagename_class' );

// 抜粋の長さを変更する
function custom_excerpt_length( $length ) {
	return 63;
}

add_filter( 'excerpt_length', 'custom_excerpt_length' );

// excerpt 省略記号
function new_excerpt_more( $more ) {
	return '...';
}

add_filter( 'excerpt_more', 'new_excerpt_more' );

// タグ無効化/非表示
// http://stackoverflow.com/questions/4249694/how-do-i-remove-a-taxonomy-from-wordpress/8363082#8363082
add_action( 'init', 'usr_unregister_taxonomy' );
function usr_unregister_taxonomy() {
	global $wp_taxonomies;
	$taxonomy = 'post_tag';
	if ( taxonomy_exists( $taxonomy ) ) {
		unset( $wp_taxonomies[ $taxonomy ] );
	}
}

function get_term_atag( $posttype, $single = true ) {
	global $post;
	$term_link_array = array();

	$taxonomies = array();
	switch ( $posttype ) {
		case 'post':
			$taxonomies = array( 'project_area', 'category', 'project_theme' );
			break;
		case 'data':
			$taxonomies = array( 'data_type', 'project_theme' );
			break;
		case 'event':
			$taxonomies = array( 'event_type', 'project_area', 'project_theme' );
			break;
		case 'place':
			$taxonomies = array( 'project_spot', 'project_area', 'project_theme' );
			break;
	}

	foreach ( $taxonomies as $tax ) {
		$term = get_the_terms( $post->ID, $tax );
		if ( ! empty( $term ) ) {
			if ( is_singular() ) {
				foreach ( $term as $t ) {
					$link              = get_term_link( $t );
					$term_link_array[] = '<a class="c-cat c-cat_' . $t->slug . ' c-' . $tax . '" href="' . $link . '">' . $t->name . '</a>';
				}
			} else {
				$term              = array_shift( $term );
				$link              = get_term_link( $term );
				$term_link_array[] = '<a class="c-cat c-cat_' . $term->slug . ' c-' . $tax . '" href="' . $link . '">' . $term->name . '</a>';
			}
		}
	}
	if ( $single ) {
		$term_link = implode( ' ', $term_link_array );
	} else {
		$term_link = $term_link_array;
	}

	return $term_link;
}

//xhtmlのタグを全てvalidに
//http://www.tinymce.com/wiki.php/Configuration:valid_elements
//function _my_tinymce($initArray) {
//    if(!isset($initArray[ 'extended_valid_elements' ])){
//        $initArray[ 'extended_valid_elements' ] = '';
//    }
//    $initArray[ 'extended_valid_elements' ] .= "a[accesskey|charset|class|coords|dir<ltr?rtl|href|hreflang|id|lang|name"
//        ."|onblur|onclick|ondblclick|onfocus|onkeydown|onkeypress|onkeyup"
//        ."|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|rel|rev"
//        ."|shape<circle?default?poly?rect|style|tabindex|title|target|type],"
//        ."abbr[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
//        ."|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
//        ."|title],"
//        ."acronym[class|dir<ltr?rtl|id|id|lang|onclick|ondblclick|onkeydown|onkeypress"
//        ."|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
//        ."|title],"
//        ."address[class|align|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
//        ."|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
//        ."|onmouseup|style|title],"
//        ."applet[align<bottom?left?middle?right?top|alt|archive|class|code|codebase"
//        ."|height|hspace|id|name|object|style|title|vspace|width],"
//        ."area[accesskey|alt|class|coords|dir<ltr?rtl|href|id|lang|nohref<nohref"
//        ."|onblur|onclick|ondblclick|onfocus|onkeydown|onkeypress|onkeyup"
//        ."|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup"
//        ."|shape<circle?default?poly?rect|style|tabindex|title|target],"
//        ."base[href|target],"
//        ."basefont[color|face|id|size],"
//        ."bdo[class|dir<ltr?rtl|id|lang|style|title],"
//        ."big[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
//        ."|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
//        ."|title],"
//        ."blockquote[cite|class|dir<ltr?rtl|id|lang|onclick|ondblclick"
//        ."|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout"
//        ."|onmouseover|onmouseup|style|title],"
//        ."body[alink|background|bgcolor|class|dir<ltr?rtl|id|lang|link|onclick"
//        ."|ondblclick|onkeydown|onkeypress|onkeyup|onload|onmousedown|onmousemove"
//        ."|onmouseout|onmouseover|onmouseup|onunload|style|title|text|vlink],"
//        ."br[class|clear<all?left?none?right|id|style|title],"
//        ."button[accesskey|class|dir<ltr?rtl|disabled<disabled|id|lang|name|onblur"
//        ."|onclick|ondblclick|onfocus|onkeydown|onkeypress|onkeyup|onmousedown"
//        ."|onmousemove|onmouseout|onmouseover|onmouseup|style|tabindex|title|type"
//        ."|value],"
//        ."caption[align<bottom?left?right?top|class|dir<ltr?rtl|id|lang|onclick"
//        ."|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
//        ."|onmouseout|onmouseover|onmouseup|style|title],"
//        ."center[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
//        ."|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
//        ."|title],"
//        ."cite[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
//        ."|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
//        ."|title],"
//        ."code[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
//        ."|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
//        ."|title],"
//        ."col[align<center?char?justify?left?right|char|charoff|class|dir<ltr?rtl|id"
//        ."|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown"
//        ."|onmousemove|onmouseout|onmouseover|onmouseup|span|style|title"
//        ."|valign<baseline?bottom?middle?top|width],"
//        ."colgroup[align<center?char?justify?left?right|char|charoff|class|dir<ltr?rtl"
//        ."|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown"
//        ."|onmousemove|onmouseout|onmouseover|onmouseup|span|style|title"
//        ."|valign<baseline?bottom?middle?top|width],"
//        ."dd[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup"
//        ."|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],"
//        ."del[cite|class|datetime|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
//        ."|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
//        ."|onmouseup|style|title],"
//        ."dfn[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
//        ."|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
//        ."|title],"
//        ."dir[class|compact<compact|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
//        ."|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
//        ."|onmouseup|style|title],"
//        ."div[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick"
//        ."|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
//        ."|onmouseout|onmouseover|onmouseup|style|title],"
//        ."dl[class|compact<compact|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
//        ."|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
//        ."|onmouseup|style|title],"
//        ."dt[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup"
//        ."|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],"
//        ."em/i[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
//        ."|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
//        ."|title],"
//        ."fieldset[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
//        ."|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
//        ."|title],"
//        ."font[class|color|dir<ltr?rtl|face|id|lang|size|style|title],"
//        ."form[accept|accept-charset|action|class|dir<ltr?rtl|enctype|id|lang"
//        ."|method<get?post|name|onclick|ondblclick|onkeydown|onkeypress|onkeyup"
//        ."|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|onreset|onsubmit"
//        ."|style|title|target],"
//        ."frame[class|frameborder|id|longdesc|marginheight|marginwidth|name"
//        ."|noresize<noresize|scrolling<auto?no?yes|src|style|title],"
//        ."frameset[class|cols|id|onload|onunload|rows|style|title],"
//        ."h1[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick"
//        ."|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
//        ."|onmouseout|onmouseover|onmouseup|style|title],"
//        ."h2[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick"
//        ."|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
//        ."|onmouseout|onmouseover|onmouseup|style|title],"
//        ."h3[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick"
//        ."|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
//        ."|onmouseout|onmouseover|onmouseup|style|title],"
//        ."h4[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick"
//        ."|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
//        ."|onmouseout|onmouseover|onmouseup|style|title],"
//        ."h5[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick"
//        ."|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
//        ."|onmouseout|onmouseover|onmouseup|style|title],"
//        ."h6[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick"
//        ."|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
//        ."|onmouseout|onmouseover|onmouseup|style|title],"
//        ."head[dir<ltr?rtl|lang|profile],"
//        ."hr[align<center?left?right|class|dir<ltr?rtl|id|lang|noshade<noshade|onclick"
//        ."|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
//        ."|onmouseout|onmouseover|onmouseup|size|style|title|width],"
//        ."html[dir<ltr?rtl|lang|version],"
//        ."iframe[align<bottom?left?middle?right?top|class|frameborder|height|id"
//        ."|longdesc|marginheight|marginwidth|name|scrolling<auto?no?yes|src|style"
//        ."|title|width],"
//        ."img[align<bottom?left?middle?right?top|alt|border|class|dir<ltr?rtl|height"
//        ."|hspace|id|ismap<ismap|lang|longdesc|name|onclick|ondblclick|onkeydown"
//        ."|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
//        ."|onmouseup|src|style|title|usemap|vspace|width],"
//        ."input[accept|accesskey|align<bottom?left?middle?right?top|alt"
//        ."|checked<checked|class|dir<ltr?rtl|disabled<disabled|id|ismap<ismap|lang"
//        ."|maxlength|name|onblur|onclick|ondblclick|onfocus|onkeydown|onkeypress"
//        ."|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|onselect"
//        ."|readonly<readonly|size|src|style|tabindex|title"
//        ."|type<button?checkbox?file?hidden?image?password?radio?reset?submit?text"
//        ."|usemap|value],"
//        ."ins[cite|class|datetime|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
//        ."|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
//        ."|onmouseup|style|title],"
//        ."isindex[class|dir<ltr?rtl|id|lang|prompt|style|title],"
//        ."kbd[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
//        ."|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
//        ."|title],"
//        ."label[accesskey|class|dir<ltr?rtl|for|id|lang|onblur|onclick|ondblclick"
//        ."|onfocus|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout"
//        ."|onmouseover|onmouseup|style|title],"
//        ."legend[align<bottom?left?right?top|accesskey|class|dir<ltr?rtl|id|lang"
//        ."|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
//        ."|onmouseout|onmouseover|onmouseup|style|title],"
//        ."li[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup"
//        ."|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title|type"
//        ."|value],"
//        ."link[charset|class|dir<ltr?rtl|href|hreflang|id|lang|media|onclick"
//        ."|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
//        ."|onmouseout|onmouseover|onmouseup|rel|rev|style|title|target|type],"
//        ."map[class|dir<ltr?rtl|id|lang|name|onclick|ondblclick|onkeydown|onkeypress"
//        ."|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
//        ."|title],"
//        ."menu[class|compact<compact|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
//        ."|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
//        ."|onmouseup|style|title],"
//        ."meta[content|dir<ltr?rtl|http-equiv|lang|name|scheme],"
//        ."noframes[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
//        ."|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
//        ."|title],"
//        ."noscript[class|dir<ltr?rtl|id|lang|style|title],"
//        ."object[align<bottom?left?middle?right?top|archive|border|class|classid"
//        ."|codebase|codetype|data|declare|dir<ltr?rtl|height|hspace|id|lang|name"
//        ."|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
//        ."|onmouseout|onmouseover|onmouseup|standby|style|tabindex|title|type|usemap"
//        ."|vspace|width],"
//        ."ol[class|compact<compact|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
//        ."|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
//        ."|onmouseup|start|style|title|type],"
//        ."optgroup[class|dir<ltr?rtl|disabled<disabled|id|label|lang|onclick"
//        ."|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
//        ."|onmouseout|onmouseover|onmouseup|style|title],"
//        ."option[class|dir<ltr?rtl|disabled<disabled|id|label|lang|onclick|ondblclick"
//        ."|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout"
//        ."|onmouseover|onmouseup|selected<selected|style|title|value],"
//        ."p[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick"
//        ."|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
//        ."|onmouseout|onmouseover|onmouseup|style|title],"
//        ."param[id|name|type|value|valuetype<DATA?OBJECT?REF],"
//        ."pre/listing/plaintext/xmp[align|class|dir<ltr?rtl|id|lang|onclick|ondblclick"
//        ."|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout"
//        ."|onmouseover|onmouseup|style|title|width],"
//        ."q[cite|class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
//        ."|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
//        ."|title],"
//        ."s[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup"
//        ."|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],"
//        ."samp[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
//        ."|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
//        ."|title],"
//        ."script[charset|defer|language|src|type],"
//        ."select[class|dir<ltr?rtl|disabled<disabled|id|lang|multiple<multiple|name"
//        ."|onblur|onchange|onclick|ondblclick|onfocus|onkeydown|onkeypress|onkeyup"
//        ."|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|size|style"
//        ."|tabindex|title],"
//        ."small[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
//        ."|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
//        ."|title],"
//        ."span[align<center?justify?left?right|class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
//        ."|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
//        ."|onmouseup|style|title],"
//        ."strike[class|class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
//        ."|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
//        ."|onmouseup|style|title],"
//        ."strong/b[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
//        ."|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
//        ."|title],"
//        ."style[dir<ltr?rtl|lang|media|title|type],"
//        ."sub[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
//        ."|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
//        ."|title],"
//        ."sup[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
//        ."|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
//        ."|title],"
//        ."table[align<center?left?right|bgcolor|border|cellpadding|cellspacing|class"
//        ."|dir<ltr?rtl|frame|height|id|lang|onclick|ondblclick|onkeydown|onkeypress"
//        ."|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|rules"
//        ."|style|summary|title|width],"
//        ."tbody[align<center?char?justify?left?right|char|class|charoff|dir<ltr?rtl|id"
//        ."|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown"
//        ."|onmousemove|onmouseout|onmouseover|onmouseup|style|title"
//        ."|valign<baseline?bottom?middle?top],"
//        ."td[abbr|align<center?char?justify?left?right|axis|bgcolor|char|charoff|class"
//        ."|colspan|dir<ltr?rtl|headers|height|id|lang|nowrap<nowrap|onclick"
//        ."|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
//        ."|onmouseout|onmouseover|onmouseup|rowspan|scope<col?colgroup?row?rowgroup"
//        ."|style|title|valign<baseline?bottom?middle?top|width],"
//        ."textarea[accesskey|class|cols|dir<ltr?rtl|disabled<disabled|id|lang|name"
//        ."|onblur|onclick|ondblclick|onfocus|onkeydown|onkeypress|onkeyup"
//        ."|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|onselect"
//        ."|readonly<readonly|rows|style|tabindex|title],"
//        ."tfoot[align<center?char?justify?left?right|char|charoff|class|dir<ltr?rtl|id"
//        ."|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown"
//        ."|onmousemove|onmouseout|onmouseover|onmouseup|style|title"
//        ."|valign<baseline?bottom?middle?top],"
//        ."th[abbr|align<center?char?justify?left?right|axis|bgcolor|char|charoff|class"
//        ."|colspan|dir<ltr?rtl|headers|height|id|lang|nowrap<nowrap|onclick"
//        ."|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove"
//        ."|onmouseout|onmouseover|onmouseup|rowspan|scope<col?colgroup?row?rowgroup"
//        ."|style|title|valign<baseline?bottom?middle?top|width],"
//        ."thead[align<center?char?justify?left?right|char|charoff|class|dir<ltr?rtl|id"
//        ."|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown"
//        ."|onmousemove|onmouseout|onmouseover|onmouseup|style|title"
//        ."|valign<baseline?bottom?middle?top],"
//        ."title[dir<ltr?rtl|lang],"
//        ."tr[abbr|align<center?char?justify?left?right|bgcolor|char|charoff|class"
//        ."|rowspan|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
//        ."|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
//        ."|title|valign<baseline?bottom?middle?top],"
//        ."tt[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup"
//        ."|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],"
//        ."u[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup"
//        ."|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],"
//        ."ul[class|compact<compact|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown"
//        ."|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover"
//        ."|onmouseup|style|title|type],"
//        ."var[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress"
//        ."|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style"
//        ."|title]";
//    return $initArray;
//}
////TMAより後に実行されるように、10000番ぐらいにフック登録
//add_filter('tiny_mce_before_init', '_my_tinymce', 10000);

function get_cat_ids( $cat_slugs, $in_category = true ) {
	$cat_ids = array();
	foreach ( $cat_slugs as $c ) {
		$cat = get_category_by_slug( $c );
		if ( $in_category ) {
			$cat_ids[] = array( $cat->term_id, 'category' );
		} else {
			$cat_ids[] = $cat->term_id;
		}
	}

	return $cat_ids;
}

;

function get_term_ids( $tax_slugs, $taxonomy_name ) {
	$tax_ids = array();
	foreach ( $tax_slugs as $t ) {
		$_term     = get_term_by( 'slug', $t, $taxonomy_name );
		$tax_ids[] = array( $_term->term_id, $taxonomy_name );
	}

	return $tax_ids;
}

// shorten from goteo
function shorten( $text, $width = null ) {
	if ( mb_strlen( $text ) < $width ) {
		return $text;
	} else {
		return mb_substr( $text, 0, $width ) . '...';
	}
}


function localgood_option_page_content() {
	$opt_name  = 'event_participants';
	$opt_name2 = 'home_updates';
	if ( isset( $_POST['event_participants_hidden'] ) == 'Y' ) {
		update_option( $opt_name, $_POST[ $opt_name ] );
		update_option( $opt_name2, $_POST[ $opt_name2 ] );
		?>
		<div class="updated"><p><strong>更新しました。</strong></p></div>
		<?php
	}
	$opt_val = get_option( $opt_name );
	?>
	<div class="wrap">
		<form name="form1" method="post" action="">
			<h2>イベントへの参加者</h2>
			<input type="hidden" name="event_participants_hidden" value="Y">
			<input type="text" name="<?php echo $opt_name; ?>" value="<?php echo $opt_val; ?>" size="80">


			<h2>トップページ更新情報</h2>
			<?php
			global $wp_editor_default_options;
			$wp_editor_options  = array_merge( $wp_editor_default_options, array(
				'media_buttons' => false,
				'textarea_rows' => 10,
			) );
			$home_about_content = get_option( $opt_name2 );
			wp_editor( $home_about_content, $opt_name2, $wp_editor_options );
			?>

			<p class="submit">
				<input type="submit" name="Submit" value="更新"/>
			</p>
		</form>
	</div>
	<?php
}

add_action( 'admin_menu', 'localgood_option_page' );
function localgood_option_page() {
	add_options_page( 'トップページ設定', 'トップページ設定', 'administrator', 'localgood_option_page_content',
		'localgood_option_page_content' );
}

function save_subject_session() {
	// 入力項目
	$user_data = array(
		'subject_content'  => '',  // 本文
		'loc_position_lat' => '', // 座標lat
		'loc_position_lng' => '',   // 座標lng
		'theme'            => '',        // テーマ
	);

	// データ保存
	if ( is_array( $_POST ) ) {
		foreach ( $user_data as $k => $v ) {
			if ( array_key_exists( $k, $_POST ) && ( ! empty( $_POST[ $k ] ) ) ) {
				$_SESSION['subject'][ $k ] = $_POST[ $k ];
			} else {
				if ( ! empty( $_SESSION['subject'] ) && array_key_exists( $k,
						$_SESSION['subject'] )
				) {
					if ( ! empty( $_POST['stage'] ) && ( $_POST['stage'] == 'confirm' ) ) {
						$_SESSION['subject'][ $k ] = '';
					}
				};
			}
		}
	};
}

function get_tree_themes() {
	$themes       = get_terms( 'project_theme', array( 'hide_empty' => false ) );
	$tree_themes  = array();
	$pickup_terms = array();
	//親の抽出
	foreach ( $themes as $t ) {
		if ( ! get_field( 'pickup_flg', $t ) ) {
			if ( $t->parent == '0' ) {
				$tree_themes[ $t->term_id ]['parent'] = $t;
			}
		}

	}
	foreach ( $tree_themes as $k => $parent ) {
		foreach ( $themes as $t ) {
			if ( ! get_field( 'pickup_flg', $t ) ) {
				if ( $t->parent == $k ) {
					if ( isset( $tree_themes[ $k ]['children'] ) ) {
						$tree_themes[ $k ]['children'][] = $t;
					} else {
						$tree_themes[ $k ]['children'] = array( $t );
					}
				}
			}
		}
	}

	foreach ( $themes as $t ) {
		if ( get_field( 'pickup_flg', $t ) ) {
			$pickup_terms[] = $t;
		}
	}

	$tree_themes['pickup'] = $pickup_terms;

	return $tree_themes;
}

function feature_posts_args() {
	return array(
		'post_type'      => array( 'event', 'data', 'post' ),
		'meta_query'     => array(
			array(
				'key'   => 'top_report_pickup',
				'value' => '1'
			),
		),
		'meta_key'       => '_thumbnail_id',
		'posts_per_page' => 3
	);
}

function post_archives_args( $post_not ) {
	global $paged;
	if ( is_page( 'lgplayer' ) ) {
		$cat_slugs = array( 'local_good_player', 'voice' );
	} else {
		$cat_slugs = array( 'news', 'report', 'editor' );
	}
	$cat_ids = get_cat_ids( $cat_slugs, false );
	$args    = array(
		'category__in'   => $cat_ids,
		'posts_per_page' => 15,
		'orderby'        => 'date',
		'order'          => 'DESC',
		'paged'          => $paged
	);
	if ( ! empty( $_GET['project_area'] ) ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'project_area',
				'terms'    => $_GET['project_area'],
				'field'    => 'slug'
			)
		);
	}
	if ( ! empty( $_GET['theme'] ) ) {
		$q = array(
			'taxonomy' => 'project_theme',
			'terms'    => $_GET['theme'],
			'field'    => 'slug'
		);

		if ( isset( $args['tax_query'] ) && is_array( $args['tax_query'] ) ) {
			$args['tax_query'][] = $q;
		} else {
			$args['tax_query'] = array( $q );
		}
	}
	if ( $post_not ) {
		$args['post__not_in'] = $post_not;
	}

	return $args;
}

function get_post_lonlat_attr() {
	global $post, $cfs;
	$lat  = null;
	$long = null;
	if ( $post->post_type === 'event' ) {
		$acf_place_data = get_field( 'place_geo' );
		if ( isset( $acf_place_data['lat'] ) && isset( $acf_place_data['lng'] ) ) {
			$lat  = $acf_place_data['lat'];
			$long = $acf_place_data['lng'];
		} else {
			$lat  = $cfs->get( 'place_latitude' );
			$long = $cfs->get( 'place_longitude' );
		}
		if ( ! $lat || ! $long ) {
			$place_id = $cfs->get( 'place_id' );
			if ( $place_id && ! empty( $place_id[0] ) ) {
				$head_place_id = $place_id[0];
				$lat           = get_post_meta( $head_place_id, 'place_latitude', true );
				$long          = get_post_meta( $head_place_id, 'place_longitude', true );
			}
		}
	} else if ( $post->post_type === 'place' ) {
		$acf_place_data = get_field( 'place_geo' );
		if ( isset( $acf_place_data['lat'] ) && isset( $acf_place_data['lng'] ) ) {
			$lat  = $acf_place_data['lat'];
			$long = $acf_place_data['lng'];
		} else {
			$lat  = $cfs->get( 'place_latitude' );
			$long = $cfs->get( 'place_longitude' );
		}
	}
	if ( empty( $lat ) && empty( $long ) ) {
		$lat  = $cfs->get( 'lgLatitude' );
		$long = $cfs->get( 'lgLongitude' );
	}
	if ( empty( $lat ) && empty( $long ) ) {
		$llstr = get_post_meta( $post->ID, 'sbLatLng', true );
		$arr   = explode( ',', $llstr );
		if ( count( $arr ) > 0 ) {
			$lat  = $arr[0];
			$long = $arr[1];
		}
	}

	$data_lonlat = '';
	if ( $lat && $long ) {
		$data_lonlat = 'data-long="' . $long . '" data-lat="' . $lat . '"';
	}

	return $data_lonlat;
}

function get_post_meta_attr() {
	global $post;
	$data_meta = '';
	if ( get_post_type() == 'subject' || get_post_type() == 'tweet' ) {
		$title = get_the_excerpt();
	} else {
		$title = get_the_title();
	}
	$href = get_permalink();
	if ( $title && $href ) {
		$data_meta = 'data-title="' . $title . '" data-href="' . $href . '"';
	}

	return $data_meta;
}

function save_subject( $subject, $file_obj ) {
	$errors    = 0;
	$error_msg = array();

	$arr_data = array(
		'post_title'   => '課題 No-#' . time(),
		'post_content' => htmlspecialchars( $subject['subject_content'] ),
		'post_status'  => 'publish',
		'post_type'    => 'subject',
	);

	if ( ! function_exists( 'wp_generate_attachment_metadata' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
		require_once( ABSPATH . 'wp-admin/includes/media.php' );
	}

	if ( isset( $file_obj ) && ! empty( $file_obj['photo']['tmp_name'] ) ) {
		if ( ! isset( $file_obj['photo']['error'] ) || ! is_int( $file_obj['photo']['error'] ) ) {
			$errors ++;
			$error_msg[] = 'パラメータが不正です';
		}

		// $_FILE のエラーハンドリング
		switch ( $file_obj['photo']['error'] ) {
			case UPLOAD_ERR_OK: // OK
				break;
			case UPLOAD_ERR_INI_SIZE:  // php.ini定義の最大サイズ超過
			case UPLOAD_ERR_FORM_SIZE: // フォーム定義の最大サイズ超過 (設定した場合のみ)
				$errors ++;
				$error_msg[] = 'ファイルサイズが大きすぎます';
				break;
			default:
				$errors ++;
				$error_msg[] = 'その他のエラーが発生しました';
		}


		// file type check
		$filetype_test      = wp_check_filetype_and_ext( $file_obj['photo']['tmp_name'], $file_obj['photo']['name'] );
		$safe_mimetype_list = array(
			'image/png',
			'image/jpg',
			'image/jpeg',
			'image/gif',
		);

		if ( false !== $filetype_test['proper_filename'] ) {
			$errors ++;
			$error_msg[] = 'ファイル形式が不正です';
		} elseif ( false === array_search( $filetype_test['type'], $safe_mimetype_list, true ) ) {
			$errors ++;
			$error_msg[] = '許可されていないファイル形式です';
		}

		if ( 0 === $errors ) {
			$new_post_id = wp_insert_post( $arr_data );
			// メディアを投稿に紐づけ
			media_handle_upload( 'photo', $new_post_id );

			return $new_post_id;
		} else {
			echo 'ファイルアップロードに失敗しました。';
			echo '<ul>';
			foreach ( $error_msg as $msg ) {
				echo "<li>$msg</li>";
			}
			echo '</ul>';

			return false;
		}
	} else {
		$new_post_id = wp_insert_post( $arr_data );
		return $new_post_id;
	}// End if().
}


function save_subject_meta( $subject_id, $subject ) {
	global $cfs;
	// タクソノミー
	if ( ! empty( $subject['theme'] ) ) {
		wp_set_object_terms(
			$subject_id,
			$subject['theme'],
			'project_theme'
		);
	}

	// メタデータ登録
	// 座標
	if ( ! empty( $subject['loc_position_lat'] ) && ! empty( $subject['loc_position_lng'] ) ) {
		$cfs->save( array(
			'lgLatitude'  => $subject['loc_position_lat'],
			'lgLongitude' => $subject['loc_position_lng']
		), array( 'ID' => $subject_id, ) );
	}
}

function get_current_url() {
	return ( empty( $_SERVER["HTTPS"] ) ? "http://" : "https://" ) . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
}

function subject_validation_check() {
	if (
		isset( $_POST['stage'] ) && $_POST['stage'] == 'confirm'
		&& ( empty( $_SESSION['subject'] ) || ! empty( $_SESSION['subject'] ) && empty( $_SESSION['subject']['subject_content'] ) )
	) {
		$notice_class = 'red';
	} else {
		$notice_class = '';
	}

	return $notice_class;
}

function subject_step_status() {
	if ( ! empty( $_POST['stage'] ) && ( $_POST['stage'] == 'confirm' )
	     && ! empty( $_POST['subject_content'] )
	) {
		$status = 'confirm';
	} elseif ( ! empty( $_POST['stage'] ) && ( $_POST['stage'] == 'submit' ) ) {
		$status = 'submit';
	} else {
		$status = 'input';
	}

	return $status;
}

function get_subject_user_meta( $is_tweet, $cf = array(), $avatar_size = 40 ) {
	global $post;
	if ( ! is_int( $avatar_size ) ) {
		return false;
	}
	$avatar = '';
	if ( $is_tweet ) {
		! empty( $cf['twUserName'][0] ) ? $name = $cf['twUserName'][0] : $name = 'twitter user';
		! empty( $cf['twScreenName'][0] ) ? $user_link = 'https://twitter.com/' . $cf['twScreenName'][0] : $user_link = 'https://twitter.com/';
		! empty( $cf['twTweetDate'][0] ) ? $postdate = date( 'Y.m.d',
			strtotime( $cf['twTweetDate'][0] ) ) : $postdate = get_the_time( 'Y.m.d' );
	} else {
		if ( get_post_type() == 'subject' && get_the_author_meta( 'ID' ) == 1 ) {
			$user_link = '';
			$name      = '';
			$avatar    = '<img alt="" src="http://0.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s=' . $avatar_size . '" class="avatar avatar photo avatar-default" >';
		} else {
			$user_link = get_author_posts_url( get_the_author_meta( 'ID' ) );
			$name      = get_the_author_meta( 'display_name' );
			$avatar    = get_avatar( get_the_author_meta( 'ID' ), $avatar_size );
		}
		$postdate = get_the_time( 'Y.m.d' );
	}

	return array(
		'id'          => get_the_author_meta( 'ID' ),
		'description' => get_the_author_meta( 'description' ),
		'link'        => $user_link,
		'name'        => $name,
		'postdate'    => $postdate,
		'avatar'      => $avatar
	);
}

add_action( 'admin_head-edit-tags.php', function () {
	add_filter( 'get_terms', function ( $terms, $taxonomies ) {
		if ( 'project_area' === $taxonomies[0] ) {
			foreach ( $terms as $key => $term ) {
				$terms[ $key ]->description = wp_trim_words(
					strip_tags( $term->description ),
					100,
					'[...]'
				);
			}
		}

		return $terms;
	}, 100, 2 );
} );


// タクソノミー「テーマ」の th「カウント」を「表示」に変更
add_filter( 'manage_edit-project_theme_columns', function ( $columns ) {
	$columns['posts'] = '表示';

	return $columns;
} );

// @todo: タクソノミー「テーマ」の td 「カウント」のリンクテキストを「表示」に変更
// https://codex.wordpress.org/Plugin_API/Filter_Reference/manage_$taxonomy_id_columns
//add_action( 'manage_project_theme_custom_column', function ( $content, $column_name, $term_id ) {
//	var_dump($content);
//	var_dump($column_name);
//	var_dump($term_id);
//}, 10, 3 );


add_filter( 'query_vars', function ( $vars ) {
	$vars[] = 'aps';
	$vars[] = 'eps';

	return $vars;
} );

// 分割されたページの、２ページめ以降かどうかをチェック
function is_paged_multipage() {
	global $multipage;
	return ($multipage && get_query_var( 'page' ) > 0) ? true : false;
}
