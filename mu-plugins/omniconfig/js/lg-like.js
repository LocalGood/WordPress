jQuery(document).ready(function ($) {
  // load my fav posts
  var storage_name = 'lgfavposts';
  var my_liked_posts = !(localStorage.getItem(storage_name) === null) ? JSON.parse(localStorage.getItem('lgfavposts')) : [];
  var lg_like_el = $('.lg_like');

  // check my fav posts
  $(lg_like_el).each(function(){
    var my_id = $(this).data('post-id').toString();
    if (my_liked_posts.includes(getHash(my_id))) {
      $(this).addClass('liked');
    }
  });

  // fav button action
  $(lg_like_el).click(function () {
    var button_el = $(this);
    var num_el = $(button_el).find('.num');
    var current_num = parseInt($(num_el).text());
    var post_id = $(this).data('post-id').toString();
    var processing_class = 'processing';
    var liked_class = 'liked';
    var actionMode = (my_liked_posts.includes(getHash(post_id)) === false) ? 'add' : 'put';

    if (actionMode === 'put' && current_num - 1 >= 0) {
      $(num_el).text(current_num - 1);
    } else {
      $(num_el).text(current_num + 1);
    }

    $(this).addClass(processing_class).attr('disabled', 'disabled');
    $.ajax({
      url: wpApiSettings.root + 'lg-like/v1/likeit',
      method: 'GET',
      data: {
        postId: post_id,
        mode: actionMode,
        key: getHash(post_id.slice(-1))
      },
      beforeSend: function (xhr) {
        xhr.setRequestHeader('X-WP-Nonce', wpApiSettings.nonce)
      }
    }).done(function (res) {

      if (res.status === 'success') {

        if (actionMode === 'add') {
          $(button_el).addClass(liked_class);
          my_liked_posts.push(getHash(post_id))
        } else {
          $(button_el).removeClass(liked_class);
          my_liked_posts = my_liked_posts.filter(function (v, i, a) {
            if (v !== getHash(post_id)) {
              return true;
            }
          })
        }
        localStorage.setItem(storage_name, JSON.stringify(my_liked_posts));
      } else if(res.status === 'error') {
        console.log('lg-like.js encounted error');
        console.log(res.msg)
      } else {
        console.log('lg-like.js encounted unknown error')
      }

    }).fail(function (err) {
      console.log('lg-like.js encounted error');
      console.log(err);
    }).always(function () {
      $(button_el).removeClass(processing_class).attr('disabled', false);
    });
  });


  function getHash(val) {
    var hash = CybozuLabs.MD5.calc(val);
    return hash.substr(0,8)
  }
});
