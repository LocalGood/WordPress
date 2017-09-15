<?php
if (DEVICE == 'sp'):
// スマホ
    get_template_part( 'single', 'skills-sp' );
else:
    get_header();
    ?>
    <?php
    if (have_posts()): the_post();
        $ss_infos = $cfs->get();

        $skill_id = $ss_infos['ssSkillID'];

        $thumb_id = $ss_infos['ssGuideThumbnail'];

        $child_skills = array();
        if ( ! empty( $skill_id )) {
            $child_skills = get_children_skill( $skill_id );
            if (is_array( $child_skills )) {
                $child_skills = $child_skills[0];
            }
        }

        // おすすめユーザー
        $recomm_users = array();
        if ( ! empty( $ss_infos['ssRecommendUser_1'] )) {
            array_push( $recomm_users, $ss_infos['ssRecommendUser_1'] );
        };
        if ( ! empty( $ss_infos['ssRecommendUser_2'] )) {
            array_push( $recomm_users, $ss_infos['ssRecommendUser_2'] );
        };
        if ( ! empty( $ss_infos['ssRecommendUser_3'] )) {
            array_push( $recomm_users, $ss_infos['ssRecommendUser_3'] );
        };

        $recomm_users_info = array();
        if ( ! empty( $recomm_users )) {
            foreach ($recomm_users as $r_user) {
                $r_user_info = get_user_info( $r_user );
                if ( ! empty( $r_user_info )) {
                    $recomm_users_info[] = $r_user_info;
                }
            }
        }

        ?>
        <div class="c-contents_wrapper c-w1096">

            <?php
            breadcrumbs();
            ?>
            <div class="single_skills--wrapper">
                <div class="key_topic_box single_skills--inner">
					<p class="hl">スキルガイド(<?php the_title() ?>)</p>
					<ul class="sub_skill cf single_skills--list">
						<?php

						foreach ($child_skills as $s):
							$_skillinfo = get_skill_info( $s->id );
							?>
							<li class="single_skills--list__item"><?= $_skillinfo[0]->name; ?></li>
							<?php
						endforeach;
						?>
					</ul>
					<div class="c-clearfix">
						<div class="single_skills--thumbnail">
							<?= wp_get_attachment_image( $thumb_id, 'thumbnail' ); ?>
						</div>
						<div class="single_skills--text topix_right">
							<h2><?= $ss_infos['ssGuideName']; ?></h2>
							<div class="cnt_text">
								<?= $ss_infos['ssGuideDesc']; ?>
							</div>
							<?php if ( ! empty( $ss_infos['ssUserID'] )):
								$ss_profile_url = LG_GOTEO_BASE_URL . '/user/profile/' . esc_html( $ss_infos['ssUserID'] ) . '/';
								?>
								<ul class="contact">
									<li class="profile">
										<a href="<?= $ss_profile_url; ?>">
											プロフィールを見る
										</a>
									</li>
								</ul>
							<?php endif; ?>
							<?/*
					<div class="child_skills">
						<p class="hl">求められるスキル</p>
						<ul>
							<?php
							if (!empty($child_skills)){
								foreach ($child_skills as $_skill){
									$_skillinfo = get_skill_info($_skill->id);
									echo '<li>' . $_skillinfo[0]->name . '</li>';
								}
							}
							?>
						</ul>
					</div>
					*/ ?>
						</div>
					</div>
                </div>
            </div>

            <?php
            if ( ! empty( $child_skills )):
                // スキルを募集しているプロジェクト
                //  おそらくこれもダブルのでは
                $_tmparray = array();
                foreach ($child_skills as $_skill) {
                    $_tmparray[] = $_skill->id;
                };
                $_param_str = implode( ',', $_tmparray );
                $_projects  = get_projects_by_skill( $_param_str );
                if (is_array( $_projects )) {
                    ?>
                    <div class="list_pic_wrapper">
                        <div class="list_pic">
                            <div class="list_pic_layout">
                                <h2 class="group_title">スキル募集中のプロジェクト</h2>
                                <?php
                                $cnt = 0;

                                foreach ($_projects as $_proj) {
                                    $cnt ++;
                                    $_proj_url   = LG_GOTEO_BASE_URL . '/widget/project/' . $_proj->id . '?lang=ja';
                                    $_iframe_src = '<iframe class="skills" frameborder="0" height="480px" src="' . $_proj_url . '" width="280px" scrolling="no"></iframe>';
                                    ?>
                                    <section class="article_box">
                                        <?= $_iframe_src; ?>
                                    </section>
                                    <?php
                                    article_box( $_iframe_src );
                                    ?>
                                    <?php
                                }
                                ?>
                                <div style="clear: both"></div>
                            </div>
                        </div><!--.list_pic-->
                    </div><!--.list_pic_wrapper-->
                    <?php
                }
            endif; // if (!empty($child_skills))
            ?>


            <?php
            // おすすめユーザー
            if ( ! empty( $recomm_users_info )):
                ?>
                <div class="list_pic_wrapper">
                    <div class="list_pic">
                        <div class="list_pic_layout">
                            <h2 class="group_title">このスキルを持ったおすすめユーザー</h2>
                            <?php

                            $cnt = 0;
                            foreach ($recomm_users_info as $_recommuser):
                                $cnt ++;

                                // goteoユーザー名, ID, プロフィールURL取得
                                $_ru_name        = $_recommuser[0]->name;
                                $_ru_id          = $_recommuser[0]->id;
                                $_ru_profile_url = LG_GOTEO_BASE_URL . '/user/profile/' . $_ru_id . '/';

                                // ユーザーavatarげっと
                                $_ru_thumbnail = get_user_avatar( $_ru_id, 80 );

                                if ( ! empty( $_recommuser[0]->about )) {
                                    $_ru_desc = $_recommuser[0]->about;
                                }

                                if ( ! empty( $_recommuser[0]->webs )) {
                                    $_ru_web = $_recommuser[0]->webs;
                                }

                                ?>
                                <div class="article_box holder">
                                    <div class="list_inner heightLine-recommuser<?php if ($cnt % 2 == 0) {
                                        echo ' noborder';
                                    } ?>">
                                        <div class="thumbnail">
                                            <a href="<?= $_ru_profile_url; ?>">
                                                <img src="<?= $_ru_thumbnail[0] ?>" alt="<?= $_ru_name ?>"/>
                                            </a>
                                        </div>
                                        <div class="holder_right">
                                            <h2 class="title"><a href="<?= $_ru_thumbnail[0] ?>"><?= $_ru_name ?></a>
                                            </h2>
                                            <p class="excerpt">
                                                <?php
                                                if ( ! empty( $_ru_desc )) {
                                                    echo $_ru_desc;
                                                }
                                                ?>
                                            </p>
                                            <ul class="contact">
                                                <li class="profile"><a href="<?= $_ru_profile_url; ?>">プロフィールを見る</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            endforeach;
                            ?>
                            <div style="clear: both"></div>
                        </div>
                    </div><!--.list_pic-->
                </div><!--.list_pic_wrapper-->
                <?php
            endif;
            ?>
        </div><!-- .contents_wrapper -->
        <?php
    endif;
    ?>
    <?php
    get_footer();
endif;
?>