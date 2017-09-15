$ = jQuery;
$(function () {
    var mainHeight = $('.key_visual').height();
    $('.main_nav').css({"display":"none"});
    $(window).scroll(function(){
        var windowHeight = $('body').scrollTop();
        if(windowHeight > mainHeight){
            $('.main_nav').slideDown('slow').css({"position":"fixed","top":"0","left":"0","z-index":"99999"});
        }else{
            $('.main_nav').slideUp('slow').css({"position":"none"});
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
    $('nav .nav_menu-button').click(function(){
       if($(linkList).hasClass('on')){
           $(linkList).slideUp();
           $(linkList).removeClass('on');
           $('.main_nav__link-list').css({"display":"none","position":"none"});
           $('body').css({'overflow':'visible'});
           $('.list_open').removeClass('on');
           $('.list_open dl').slideUp();
           $('nav .close_button').css({"display":"none"});
           $('.nav_menu-button span').css({"display":"block"});
       }else{
           $(linkList).slideDown();
           $(linkList).addClass('on');
           $(linkList).css({'position':'fixed','top':'60px','left':'0'})
           $('body').css({'overflow':'hidden'});
           $('nav .close_button').css({"display":"block"});
           $('.nav_menu-button span').css({"display":"none"});
       }
    });
     var linkList = $('.main_nav__link-list');
    $('.key_visual .nav_menu-button').click(function(){
        if($(linkList).hasClass('on')){
            $(linkList).removeClass('on').slideUp();
            $('.main_nav__link-list').css({"display":"none"});
            $('body').css({'position':'static'});
            $('.list_open').removeClass('on');
            $('.list_open dl').slideUp();
            $('.key_visual .close_button').css({"display":"none"});
            $('.nav_menu-button span').css({"display":"block"});
        }else{
            $(linkList).slideDown();
            $(linkList).addClass('on');
            $(linkList).css({'position':'fixed','top':'60px','left':'0'});
            $('body').css({'position':'fixed'});
            $('.key_visual .close_button').css({"display":"block"});
            $('.nav_menu-button span').css({"display":"none"});
        }
    });
    $('.list_open').click(function(){
        if($(this).hasClass('on')){
            $(this).children('dl').slideUp();
            $(this).removeClass('on');
        }else{
            $(this).children('dl').slideDown();
            $(this).addClass('on');
        }
    });

});