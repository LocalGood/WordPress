$ = jQuery;

$(function () {

    ////////////////////
    // smooth scroll
    //
    $('a[href^=#]').click(function(e){
        if (!$(this).hasClass('no-scrolling')) {
          e.preventDefault();
          var speed = 350;
          var href= $(this).attr("href");
          var target = $(href == "#" || href == "" ? 'html' : href);
          var position = target.offset().top;
          $("html, body").animate({scrollTop:position}, speed, "swing");
          return false;
        }

    });

    ////////////////////
    // lgnews, lgplayerのpop up
    //
    $('#knows_map__button').on('click', function(){
        $('.news_theme__pop_wrapper').addClass('view');
    });
    $('.news_theme__close, .news_theme__buttons__cancel').on('click',function(){
        $('.news_theme__pop_wrapper').removeClass('view');
    });
    $('.news_theme__child li').on('click', function(){
        $(this).toggleClass('choice');
    });

    ////////////////////
    // submit_subjectのテーマ選択
    //
    $('.select_theme button').on('click', function(){
        $(this).toggleClass('select');
    });

    ////////////////////
    // submit_subjectのpop up
    //
    $('#template_select_button').on('click', function(){
        $('#template_panel__wrapper').addClass('view');
    });
    $('#template_panel__wrapper .close_button').on('click',function(){
        $('#template_panel__wrapper').removeClass('view');
    });
    $('.template_panel__select button').on('click', function(){
        $(this).toggleClass('choice');
    });

});

