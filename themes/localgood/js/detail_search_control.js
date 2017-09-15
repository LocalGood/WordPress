jQuery(document).ready(function ($) {
  // 検索モーダル制御
  $('#filterSearch').on('click', function (e) {
    e.preventDefault();


    var url_query = window.location.search;
    $('#modalContainer').load('/event_search' + url_query , function () {
      var eventModalEntity = $('#eventSearchContent');

      $(eventModalEntity).show();
      count_search_result();

      // モーダルとじる
      $('#eventSearchModalClose').on('click', function (e) {
        e.preventDefault();
        $(eventModalEntity).fadeOut();
      });

      // タブ切り替え
      $('#searchTabSwitch').find('a').click(function (e) {
        e.preventDefault();
        var target = $(this).attr('href');

        $(target).addClass('active').siblings('.event_search__form_wrapper').removeClass('active');
        $(this).parent('li').addClass('active').siblings('li').removeClass('active');
        $('#searchMode').val($(this).data('formmode'));
        count_search_result();
      });

      // すべて選択の制御
      $('.all-check').on('change', function () {
        var target = $(this).data('target');
        if ($(this).is(':checked')) {
          $(target).find('input:checkbox').attr('checked', 'checked');
        } else {
          $(target).find('input:checkbox').attr('checked', false);
        }
      });

      // Date picker plugin
      $(function () {

        $('.use-datepicker').datepicker({
          clearButton: true,
          onSelect: function () {
            count_search_result();
          },
          language: {
            days: ['日曜日', '月曜日', '火曜日', '水曜日', '木曜日', '金曜日', '土曜日'],
            daysShort: ['日曜', '月曜', '火曜', '水曜', '木曜', '金曜', '土曜'],
            daysMin: ['日', '月', '火', '水', '木', '金', '土'],
            months: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
            monthsShort: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
            today: '今日',
            clear: '日付をクリア',
            dateFormat: 'yyyy-mm-dd',
            timeFormat: 'hh:ii aa',
            firstDay: 1
          }
        });
      });

      $('.unspecified').on('change', function () {
        var target = $(this).data('target-inputs');
        if ($(this).is(':checked')) {
          $(target).find('input').each(function () {
            $(this).attr('disabled', 'disabled');
          });
        } else {
          $(target).find('input').each(function () {
            $(this).attr('disabled', false);
          });
        }
      });

      $(eventModalEntity).find('input').on('change', function () {
        count_search_result();
      });

      function count_search_result() {
        var form = $(eventModalEntity).find('form');
        var search_mode = $(form).find("input[name='searchFrom']").val();
        var input_data;

        switch (search_mode) {
          case 'place':
            input_data = {
              'area': get_checkbox_val($(form).find("input[name='area[]']:checked")),
              'spot': get_checkbox_val($(form).find("input[name='spot[]']:checked")),
              'place_theme': get_checkbox_val($(form).find("input[name='place_theme[]']:checked"))
            };
            break;

          case 'event':
            input_data = {
              'area': get_checkbox_val($(form).find("input[name='area[]']:checked")),
              'category': get_checkbox_val($(form).find("input[name='category[]']:checked")),
              'event_theme': get_checkbox_val($(form).find("input[name='event_theme[]']:checked")),
              'period': $(form).find("input[name='period']:checked").val(),
              'since': $(form).find("input[name='since']").val(),
              'until': $(form).find("input[name='until']").val()
            };
            break;

        }

        $.ajax({
          url: '/wp-json/api/v1/get-search-items',
          type: 'GET',
          dataType: 'JSON',
          data: {
            device: 'PC',
            search_mode: search_mode,
            input_data: input_data
          },
          beforeSend: function(xhr, setting){
            $('#ajaxLoading').fadeIn(500);
          }
        })
          .done(function (result) {

            $('#search_result_counter')
              .prop('Counter', function(index, prop){
                if (!prop) {
                  return $(this).text();
                } else {
                  return prop;
                }
              })
              .animate({
                Counter: result
              }, {
                duration: 500,
                easing: 'swing',
                step: function(now) {
                  $(this).text(Math.ceil(now));
                }
              });

            if (parseInt(result) === 0) {
              $('#doSearch').attr('disabled', 'disabled');
              $('#searchMsg').fadeIn(500);
            } else {
              $('#doSearch').attr('disabled', false);
              $('#searchMsg').fadeOut(500);
            }
          })
          .fail(function (error) {
            console.log("error");
            console.log(error);
          })
          .always(function () {
            $('#ajaxLoading').fadeOut(500);
          });

      }

      // グループ化されたチェックボックスの値を取得
      function get_checkbox_val(el) {
        var tmp = [];
        $(el).each(function() {
          tmp.push($(this).val());
        });
        return tmp;
      }

    });
  });
});