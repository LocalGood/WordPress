jQuery(document).ready(function ($) {
  $('#addNewBannerSet').click(function (e) {
    e.preventDefault();

    var newSetName = $('#addNewBannerSetName').val();

    if (newSetName !== '') {
      var postData = {
        'action': LGJSCONFIG.action.add_new_bannerset,
        'setName': newSetName
      };
      $.ajax({
        type: 'POST',
        url: LGJSCONFIG.endpoint,
        data: postData,
        beforeSend: function () {
          $('#omniconfigMsgBox').fadeIn(500);
        }
      })
        .done(function (res) {
          // ajaxでページ生成が完了したらそのページの編集画面に遷移
          location.href = htmlEntities(res, 'decode');
        })
        .always(function () {
          setTimeout(function () {
            $('#omniconfigMsgBox').fadeOut(500);
          }, 500);
        });

    } else {
      alert('セット名を入力してください。');
    }

  });

  $('.del').click(function (e) {
    e.preventDefault();

    if (confirm('[確認]\nバナーセットを削除しようとしています。この操作は取り消せません。\n実行してもよろしいですか？')) {

      var postData = {
        'action': LGJSCONFIG.action.remove_config_post,
        'target_id': $(this).data('id')
      };

      $.ajax({
        type: 'POST',
        url: LGJSCONFIG.endpoint,
        data: postData,
        beforeSend: function () {
          $('#omniconfigMsgBox').fadeIn(500);
        }
      })
        .done(function (res) {
          $('#bannerset_' + parseInt(res)).parent('.bannerset_box').addClass('removing').fadeOut(1500);

          setTimeout(function () {
            $('#bannerset_' + parseInt(res)).parent('.bannerset_box').remove();
          }, 5000);
        })
        .always(function () {
          setTimeout(function () {
            $('#omniconfigMsgBox').fadeOut(500);
          }, 500);
        });
    }

  });

  $('.regenerate_footer_html').click(function(e){

    e.preventDefault();

    var postData = {
      'action': LGJSCONFIG.action.regenerate_footer_html
    };

    $.ajax({
      type: 'POST',
      url: LGJSCONFIG.endpoint,
      data: postData,
      beforeSend: function () {
        $('#omniconfigMsgBox').fadeIn(500);
      }
    })
      .done(function (res) {
        alert(res);
      })
      .always(function () {
        setTimeout(function () {
          $('#omniconfigMsgBox').fadeOut(500);
        }, 500);
      });

  });


  $('.regenerate_apikeys_json').click(function(e){
    e.preventDefault();

    var postData = {
      'action': LGJSCONFIG.action.regenerate_apikeys_json
    };

    $.ajax({
      type: 'POST',
      url: LGJSCONFIG.endpoint,
      data: postData,
      beforeSend: function () {
        $('#omniconfigMsgBox').fadeIn(500);
      }
    })
      .done(function (res) {
        alert(res);
      })
      .always(function () {
        setTimeout(function () {
          $('#omniconfigMsgBox').fadeOut(500);
        }, 500);
      });

  })



  $('.regenerate_palette_scss').click(function(e){
    e.preventDefault();

    var postData = {
      'action': LGJSCONFIG.action.regenerate_palette_scss
    };

    $.ajax({
      type: 'POST',
      url: LGJSCONFIG.endpoint,
      data: postData,
      beforeSend: function () {
        $('#omniconfigMsgBox').fadeIn(500);
      }
    })
      .done(function (res) {
        alert(res);
      })
      .always(function () {
        setTimeout(function () {
          $('#omniconfigMsgBox').fadeOut(500);
        }, 500);
      });

  })

});
