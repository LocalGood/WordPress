jQuery(document).ready(function ($) {
  // 検索モーダル制御
  $('#filterSearch').on('click',function(e) {
    e.preventDefault();
    $('.container, .common_select_popup').addClass('popup_active');
  });

  $('#selectPopupClose').on('click',function(e){
    e.preventDefault();
    $('.container, .common_select_popup').removeClass('popup_active');
  });

  $(window).load(function(){
    count_search_result();
  });

  $('input').on('change', function () {
    count_search_result();
  });

  $("input[type='text']").on('blur', function () {
    var extra_data = {'keyword':$(this).val()};
    count_search_result(extra_data);
  });

  function count_search_result(extra_data) {
    var form = $('form');
    var search_mode = $(form).find("input[name='searchFrom']").val();
    var input_data = {};


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

    if (extra_data !== undefined ) {
      input_data = $.extend( true, {}, input_data, extra_data);
    }

    $.ajax({
      url: '/wp-json/api/v1/get-search-items',
      type: 'GET',
      dataType: 'JSON',
      data: {
        device: 'SP',
        search_mode: search_mode,
        input_data: input_data
      },
      beforeSend: function(){
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