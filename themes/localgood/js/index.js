$ = jQuery;

$(function () {

    //indexページのheader挙動
    var winH = $(window).height(),
        nav = $('#header');

    $(window).scroll(function () {

        if($(window).scrollTop() > 200 ) {
            nav.addClass('fixed');
        } else {
            nav.removeClass('fixed');
        }
    });

});