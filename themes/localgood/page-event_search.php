<div id="eventSearchContent" class="event_search">
    <div class="event_search__inner">
        <div id="eventSearchModalClose" class="event_search__close_button">×</div>
        <h2 class="event_search__title">詳細検索</h2>
        <ul id="searchTabSwitch" class="event_search_tabs">
            <li class="active"><a href="#tabItem--Event" class="no-scrolling" data-formmode="event">イベント</a></li>
            <li><a href="#tabItem--Place" class="no-scrolling" data-formmode="place">みんなの拠点</a></li>
        </ul>
        <form action="<?php echo home_url('event'); ?>" class="form" method="get">
            <div id="tabItem--Place" class="event_search__form_wrapper">
                <div class="event_search__left event_search__form">
                    <div class="event_search__form__inner">
                        <div class="on_form">
                            <h3 class="event_search__sub_title">エリア</h3>
                            <label class="event_search__inp_check">
                                <input type="checkbox" class="all-check checkbox" data-target="#chk-place-area">
                                <span class="event_search__inp_check__parts parts"></span>
                                すべて選択
                            </label>
                        </div>
                        <ul class="event_search__inp_check" id="chk-place-area">
                            <?php
                            $areas_obj = get_terms('project_area');
                            foreach ($areas_obj as $area) :
                                ?>
                                <li>
                                    <label class="event_search__inp_check__label">
                                        <input type="checkbox" name="area[]" value="<?php echo $area->slug; ?>"
                                               class="checkbox"
                                               id="area_check_<?php echo $area->slug; ?>">
                                        <span class="event_search__inp_check__parts parts"></span>
                                        <?php echo $area->name; ?>
                                    </label>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <div class="event_search__form__inner">
                        <div class="on_form">
                            <h3 class="event_search__sub_title">スポット</h3>
                            <label class="event_search__inp_check">
                                <input type="checkbox" class="all-check checkbox" data-target="#chk-place-spot">
                                <span class="event_search__inp_check__parts parts"></span>
                                すべて選択
                            </label>
                        </div>
                        <ul class="event_search__inp_check" id="chk-place-spot">
                            <?php
                            $spot_obj = get_terms('project_spot');
                            foreach ($spot_obj as $spot) :
                                ?>
                                <li>
                                    <label class="event_search__inp_check__label">
                                        <input type="checkbox" name="spot[]" value="<?php echo $spot->slug; ?>"
                                               class="checkbox"
                                               id="spot_check_<?php echo $spot->slug; ?>">
                                        <span class="event_search__inp_check__parts parts"></span>
                                        <?php echo $spot->name; ?>
                                    </label>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <div class="event_search__right event_search__form">
                    <div class="event_search__form__inner">
                        <div class="on_form">
                            <h3 class="event_search__sub_title">テーマ</h3>
                            <label class="event_search__inp_check">
                                <input type="checkbox" class="all-check checkbox" data-target="#chk-place-theme">
                                <span class="event_search__inp_check__parts parts"></span>
                                すべて選択
                            </label>
                        </div>
                        <ul class="event_search__inp_check" id="chk-place-theme">
                            <?php
                            $place_theme_obj = get_terms('project_theme');
                            foreach ($place_theme_obj as $place_theme) :
                                ?>
                                <li>
                                    <label class="event_search__inp_check__label">
                                        <input type="checkbox" name="place_theme[]"
                                               value="<?php echo $place_theme->slug; ?>"
                                               class="checkbox"
                                               id="area_check_<?php echo $place_theme->slug; ?>">
                                        <span class="event_search__inp_check__parts parts"></span>
                                        <?php echo $place_theme->name; ?>
                                    </label>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div id="tabItem--Event" class="event_search__form_wrapper active">
                <div class="event_search__left event_search__form">
                    <div class="event_search__form__inner">
                        <div class="on_form">
                            <h3 class="event_search__sub_title">エリア</h3>
                            <label class="event_search__inp_check">
                                <input type="checkbox" class="all-check checkbox" data-target="#chk-event-area">
                                <span class="event_search__inp_check__parts parts"></span>
                                すべて選択
                            </label>
                        </div>
                        <ul class="event_search__inp_check" id="chk-event-area">
                            <?php
                            $areas_obj = get_terms('project_area');
                            foreach ($areas_obj as $area) :
                                ?>
                                <li>
                                    <label class="event_search__inp_check__label">
                                        <input type="checkbox" name="area[]" value="<?php echo $area->slug; ?>"
                                               class="checkbox"
                                               id="area_check_<?php echo $area->slug; ?>">
                                        <span class="event_search__inp_check__parts parts"></span>
                                        <?php echo $area->name; ?>
                                    </label>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <div class="event_search__form__inner">
                        <div class="on_form">
                            <h3 class="event_search__sub_title">カテゴリー</h3>
                            <label class="event_search__inp_check">
                                <input type="checkbox" class="all-check checkbox" data-target="#chk-event-category">
                                <span class="event_search__inp_check__parts parts"></span>
                                すべて選択
                            </label>
                        </div>
                        <ul class="event_search__inp_check" id="chk-event-category">
                            <?php
                            $category_obj = get_terms('event_type');
                            foreach ($category_obj as $category) :
                                ?>
                                <li>
                                    <label class="event_search__inp_check__label">
                                        <input type="checkbox" name="category[]" value="<?php echo $category->slug; ?>"
                                               class="checkbox"
                                               id="area_check_<?php echo $category->slug; ?>">
                                        <span class="event_search__inp_check__parts parts"></span>
                                        <?php echo $category->name; ?>
                                    </label>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <div class="event_search__right event_search__form">
                    <div class="event_search__form__inner">
                        <h3 class="event_search__sub_title">開催日</h3>
                        <div id="date_select" class="event_search__inp_tex_wrapper">
                            <input type="text" class="event_search__inp_tex use-datepicker" name="since">
                            <span class="space">～</span>
                            <input type="text" class="event_search__inp_tex use-datepicker" name="until">
                        </div>
                        <label class="event_search__right__inp_check">
                            <input type="checkbox" name="period" class="unspecified checkbox"
                                   data-target-inputs="#date_select" value="unspecified">
                            <span class="event_search__right__inp_check__parts parts"></span>
                            指定なし
                        </label>
                    </div>

                    <div class="event_search__form__inner">
                        <div class="on_form">
                            <h3 class="event_search__sub_title">テーマ</h3>
                            <label class="event_search__inp_check">
                                <input type="checkbox" class="all-check checkbox" data-target="#chk-event-theme">
                                <span class="event_search__inp_check__parts parts"></span>
                                すべて選択
                            </label>
                        </div>
                        <ul class="event_search__inp_check" id="chk-event-theme">
                            <?php
                            $event_theme_obj = get_terms('project_theme');
                            foreach ($event_theme_obj as $event_theme) :
                                ?>
                                <li>
                                    <label class="event_search__inp_check__label">
                                        <input type="checkbox" name="event_theme[]"
                                               value="<?php echo $event_theme->slug; ?>"
                                               class="checkbox"
                                               id="area_check_<?php echo $event_theme->slug; ?>">
                                        <span class="event_search__inp_check__parts parts"></span>
                                        <?php echo $event_theme->name; ?>
                                    </label>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="event_search__bottom">
                <p id="ajaxLoading" class="search_result_loading">おまちください</p>
                <p id="searchMsg" class="search_result_not_found">検索結果が見つかりません。条件を変更してお試しください。</p>
                <div class="event_search__result">
                    該当件数 <span id="search_result_counter">0</span> 件
                </div>
                <input type="hidden" name="searchFrom" id="searchMode" value="event">
                <input type="submit" value="検索する" id="doSearch" class="event_search__button">
            </div>
        </form>
    </div>
</div>
