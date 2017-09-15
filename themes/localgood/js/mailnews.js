$ = jQuery;

$(function () {

    //var test = $('.static_page').children('h1').html();

    //iframe内のスタイル変更
    $(window).load(function(){
        var test = $('#mailnews').attr('id');
        console.log(test);
        $('iframe').contents().find('td.sy_input').css('width', '250px');
    });

});

