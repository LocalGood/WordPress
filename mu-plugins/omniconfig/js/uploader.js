jQuery(document).ready(function ($) {
  var mediaUploader, target_path, preview_elem;
  $('.select-media').click(function (e) {
    e.preventDefault();

    var media_target = $(this).data('media-target');
    console.log(media_target);
    target_path = '.media-url_' + media_target;
    preview_elem = '.media-preview_' + media_target;

    if (mediaUploader) {
      mediaUploader.open();
      return;
    }

    mediaUploader = wp.media.frames.file_frame = wp.media({
      title: '画像を選択',
      button: {
        text: '閉じる'
      },
      multiple: false
    });

    mediaUploader.on('select', function(){
      var attachment = mediaUploader.state().get('selection').first().toJSON();
      console.log(attachment);
      console.log($(target_path), $(preview_elem));

      $(target_path).val(attachment.url);
      $(preview_elem).attr('src', attachment.url);
    });

    mediaUploader.open();
  });


  $('.remove-image').click(function(e){
    e.preventDefault();

    var remove_target = $(this).data('target');
    var remove_target_url = '.media-url_' + remove_target;
    var remove_target_preview = '.media-preview_' + remove_target;

    $(remove_target_url).val('');
    $(remove_target_preview).attr('src',false);

  });

});

