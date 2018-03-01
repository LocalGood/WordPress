jQuery(document).ready(function ($) {
  // load my fav posts
  var storage_name = 'lguid';
  var salt = '37217893726260';
  var lg_userid = !(localStorage.getItem(storage_name) === null)
    ? localStorage.getItem(storage_name)
    : create_uid();

  function create_uid() {
    var date = new Date()
    var time = date.getTime()
    var msec = date.getMilliseconds()
    var base = Math.floor((parseInt(salt) / msec) + time)

    var new_uid = CybozuLabs.MD5.calc(base).substr(7, 14);
    localStorage.setItem(storage_name, new_uid)
  }



  // コメントフォーム関連の変数
  var comment_input_field = $('.commentInput')
  var submit_btn = $('#lg_comment_submit')


  $('#lg_comment_form').on('submit', function (e) {
    $('#lg_comment_key').attr('name', 'comment_key').val(lg_userid)
    $(submit_btn).attr('disabled','disabled').val($(submit_btn).val() + '中')
  })

  $('#form_input_name').keydown(function(e){
    if ((e.which && e.which === 13) || (e.keyCode && e.keyCode === 13)) {
      e.preventDefault();
    }
  })

  autosize($(comment_input_field));

  $(comment_input_field).keyup(function(e){
    var textcount = $(this).val().length;

    if (textcount > 0) {
      $(submit_btn).attr('disabled',false)
    } else {
      $(submit_btn).attr('disabled','disabled')
    }
  })

});
