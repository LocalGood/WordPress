<?php
/**
 * LG Class
 * @pcakage localgood/omniconfig
 */


add_action( 'wp_enqueue_scripts', function () {
	$plugin_dir = plugin_dir_url( __FILE__ ) . basename( __FILE__, '.php' );
	wp_register_script( 'cybozu_md5', $plugin_dir . '/../js/md5.js', array(), null, false );
	wp_register_script( 'autosize', $plugin_dir . '/../lib/autosize.min.js', array( 'jquery' ), null, false );
} );


class LG {
	/**
	 * Show custom like button
	 * This method have no options.
	 * @since 1.0.0
	 */
	public function like() {
		$plugin_dir = plugin_dir_url( __FILE__ ) . basename( __FILE__, '.php' );
		wp_enqueue_script( 'lg_like_script', $plugin_dir . '/../js/lg-like.js', array(
			'jquery',
			'wp-api',
			'cybozu_md5',
			'autosize',
		), null, false );

		global $post;
		$like_label       = get_option( 'lg_config__lgLike_label' , 'いいね' );
		$current_like_cnt = ! empty( get_post_meta( $post->ID, '_lg_like_cnt', true ) ) ? get_post_meta( $post->ID, '_lg_like_cnt', true ) : 0;

		echo "<button class='lg_like' data-post-id='{$post->ID}'>$like_label<span class='num'>$current_like_cnt</span></button>";
	}

	/**
	 * Custom comments counter
	 * This method have no options.
	 * @since 1.1.0
	 */
	public function c_counter() {
		global $post;

		$comment_count = get_comments( array(
			'post_id' => $post->ID,
			'count'   => true,
		) );

		$link = get_permalink( $post ) . '#comments';

		echo "<span class='comment_counter'><a href='$link'>コメント<span class='num'>$comment_count</span></a></span>";
	}

	/**
	 * Custom comment field
	 *
	 * $args values:
	 *                wrap_el  コメントブロックをラップする要素（デフォルトはDIV）
	 *         class_basename  コメントブロックの各種クラスの基本名（デフォルトは lg_comments）
	 *               title_el  タイトルをラップする要素（デフォルトはh3）
	 *            title_label  タイトルテキスト。（デフォルトは「コメント」、lg_comment_editor_title_text を通る）
	 *
	 * @since 1.1.0
	 *
	 * @param array $args option args
	 */
	public function comments( $args = array() ) {
		$plugin_dir = plugin_dir_url( __FILE__ ) . basename( __FILE__, '.php' );
		wp_enqueue_script( 'lg_comments_script', $plugin_dir . '/../js/lg-comment.js', array(
			'jquery',
			'cybozu_md5',
			'autosize',
		), null, false );


		global $post;
		$cfg = array_merge( array(
			'wrap_el'        => 'div',
			'class_basename' => 'lg_comments',
			'title_el'       => 'h3',
			'title_prefix'   => '',
			'title_label'    => 'ダイレクトコメント',
			'title_suffix'   => '<small>（Facebookログイン不要）</small>',
			'name_label'     => 'ペンネーム',
			'comment_label'  => 'メッセージ',
			'submit_label'   => '投稿',
			'show_count'     => true,
		), $args );

		$post_id = $post->ID;

		$el_title = apply_filters( 'lg_comment_editor_title_text', $cfg['title_label'] );


		// コメントの取得
		$comments = get_comments( array(
			'post_id' => $post_id,
		) );

		if ( $cfg['show_count'] ) {
			$comment_count = '<span class="count"><span class="num">' . count( $comments ) . '</span>件</span>';
		} else {
			$comment_count = null;
		}


		// form 要素生成
		$form_el = "<{$cfg['wrap_el']} class='{$cfg['class_basename']}' id='comments'>";
		// title
		$form_el .= "<{$cfg['title_el']} class='{$cfg['class_basename']}--title'>{$cfg['title_prefix']}{$el_title}{$comment_count}{$cfg['title_suffix']}</{$cfg['title_el']}>";

		$form_action = get_bloginfo( 'url' ) . '/wp-content/mu-plugins/omniconfig/lg-post-comments.php';
		// comment form
		$form_el .= "<div class='{$cfg['class_basename']}--form'>";
		$form_el .= "<form action='$form_action' method='post' id='lg_comment_form'>";
		$form_el .= '<input type="hidden" id="lg_comment_key">';
		$form_el .= "<input type='hidden' name='lg_comment_pid' value='$post_id'>";
		$form_el .= '<input type="hidden" name="action" value="comment">';

		$form_el .= "<div class='{$cfg['class_basename']}--input_comment'>";
		$form_el .= "<textarea id='' name='form_input_comment' class='commentInput' placeholder='コメントを追加...'></textarea>";
		$form_el .= '</div>';

		$form_el .= "<div class='{$cfg['class_basename']}--bottom'>";

		$form_el .= "<div class='{$cfg['class_basename']}--input_name'>";
		$form_el .= "<input id='form_input_name' name='form_input_name' placeholder='ペンネームを入力...' type='text' size='20' maxlength='30'>";
		$form_el .= '</div>';

		// todo:captchaする？
		$form_el .= "<div class='{$cfg['class_basename']}--buttons'>";
		$form_el .= "<input type='submit' value='{$cfg['submit_label']}' id='lg_comment_submit' disabled='disabled'>";
		$form_el .= '</div>';

		$form_el .= '</div>';
		$form_el .= '</form>';
		$form_el .= '</div>';

		// comment list
		$form_el .= "<div class='{$cfg['class_basename']}--list'>";

		foreach ( $comments as $index => $comment ) {
			$comment_author = ( ! empty( $comment->comment_author ) ) ? $comment->comment_author : '地域の仲間';

			$form_el .= "<div class='{$cfg['class_basename']}--comment_block'>";
			$form_el .= "<p class='{$cfg['class_basename']}--comment_author'>" . esc_html( $comment_author ) . '</p>';
			$form_el .= "<div class='{$cfg['class_basename']}--comment_body commentBody'>" . nl2br( strip_tags( $comment->comment_content ) ) . '</div>';
			$form_el .= "<p class='{$cfg['class_basename']}--comment_date'>" . date( 'Y/m/d', strtotime( $comment->comment_date ) ) . '</p>';
			$form_el .= '</div>';
		}

		$form_el .= '</div>';

		$form_el .= "</{$cfg['wrap_el']}>";

		echo $form_el;
	}

	public function themeinfo() {

		$themes        = get_themes();
		$current_theme = get_current_theme();
		if ( ! isset( $themes[ $current_theme ] ) ) {
			delete_option( 'current_theme' );
			$current_theme = get_current_theme();
		}
		$ct                 = (object) array();
		$ct->name           = $current_theme;
		$ct->title          = $themes[ $current_theme ]['Title'];
		$ct->version        = $themes[ $current_theme ]['Version'];
		$ct->parent_theme   = $themes[ $current_theme ]['Parent Theme'];
		$ct->template_dir   = $themes[ $current_theme ]['Template Dir'];
		$ct->stylesheet_dir = $themes[ $current_theme ]['Stylesheet Dir'];
		$ct->template       = $themes[ $current_theme ]['Template'];
		$ct->stylesheet     = $themes[ $current_theme ]['Stylesheet'];
		$ct->screenshot     = $themes[ $current_theme ]['Screenshot'];
		$ct->description    = $themes[ $current_theme ]['Description'];
		$ct->author         = $themes[ $current_theme ]['Author'];
		$ct->tags           = $themes[ $current_theme ]['Tags'];
		$ct->theme_root     = $themes[ $current_theme ]['Theme Root'];
		$ct->theme_root_uri = $themes[ $current_theme ]['Theme Root URI'];

		return $ct;

	}

}
