$ = jQuery;
$(function () {
    var mainHeight = $('.key_visual').height();
    $('.main_nav').css({"display":"none"});
    $(window).scroll(function(){
        var windowHeight = $('body').scrollTop();
        if(windowHeight > mainHeight){
            $('.main_nav').css({"display":"block","position":"fixed","top":"0","left":"0","z-index":"99999"});
        }else{
            $('.main_nav').css({"display":"none","position":"none"});
        }
    });
    //ページ内リンク
    $('a[href^=#]').click(function(){
        var speed = 500;
        var href= $(this).attr("href");
        var target = $(href == "#" || href == "" ? 'html' : href);
        var position = target.offset().top;
        $("html, body").animate({scrollTop:position}, speed, "swing");
        return false;
    });

    //Navi開閉
    var linkList = $('.main_nav__link-list');
    $(linkList).slideUp();
    $('.nav_menu-button').click(function(){
       if($(linkList).hasClass('on')){
           $(linkList).slideUp();
           $(linkList).removeClass('on');
           $('.main_nav').css({"display":"none","position":"none"});
           $('.page_wrapper_fixed').css({'overflow':'visible'});
       }else{
           $(linkList).slideDown();
           $(linkList).addClass('on');
           $(linkList).css({'position':'fixed','top':'60px','left':'0'});
           $('.main_nav').css({"display":"block","position":"fixed","top":"0","left":"0","z-index":"99999"});
           $('.page_wrapper_fixed').css({'overflow':'hidden'});
       }
    });
    $('.list_open dl').slideUp();
    $('.list_open').click(function(){
        if($(this).hasClass('on')){
            $(this).children('dl').slideUp();
            $(this).removeClass('on');
        }else{
            $(this).children('dl').slideDown();
            $(this).addClass('on');
        }
    });

    //NEWS テーマ選択　POPUP
    //$('.popup_bk').css({'display':'none'});
    //$('.news_theme').css({'display':'none'});
    //$('.select_theme').click(function(){
    //    $('.popup_bk').css({'display':'block'});
    //    $('.news_theme').css({'display':'block'});
    //});
    //$('.news_theme .close_theme,.select_theme__button .button01').click(function(){
    //    $('.popup_bk').css({'display':'none'});
    //    $('.news_theme').css({'display':'none'});
    //});

//    投稿ページ
//    $('.template_panel').css({"display":"none"});
//    $('.template_select_button').click(function(){
//        $('.template_panel').css({"display":"block"});
//        $('.popup_bk').css({'display':'block'});
//    });
//    $('.template_panel .close_button').click(function(){
//        $('.template_panel').css({"display":"none"});
//        $('.popup_bk').css({'display':'none'});
//    })
});