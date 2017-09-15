$ = jQuery;
$(function () {

    //NEWS テーマ選択　POPUP
    $('.select_theme').click(function(){
        $('.popup_bk').css({'display':'block'});
        $('.news_theme').css({'display':'block'});
    });
    $('.news_theme .close_theme,.select_theme__button .button01').click(function(){
        $('.popup_bk').css({'display':'none'});
        $('.news_theme').css({'display':'none'});
    });
});