$ = jQuery;

$(function () {

    // android対策 強制width:320px
    //var portraitWidth,landscapeWidth;
    //$(window).bind("resize", function(){
    //    if(Math.abs(window.orientation) === 0){
    //        if(/Android/.test(window.navigator.userAgent)){
    //            if(!portraitWidth)portraitWidth=$(window).width();
    //        }else{
    //            portraitWidth=$(window).width();
    //        }
    //        $("html").css("zoom" , portraitWidth/320 );
    //    }else{
    //        if(/Android/.test(window.navigator.userAgent)){
    //            if(!landscapeWidth)landscapeWidth=$(window).width();
    //        }else{
    //            landscapeWidth=$(window).width();
    //        }
    //        $("html").css("zoom" , landscapeWidth/320 );
    //    }
    //}).trigger("resize");

    // 投稿画像etcを画面幅に収める
    var post_width = $('.post_body').width();
    if ( post_width < $('.post_body div').width() ) {
        $('.post_body div').css({
            width: post_width + 'px'
        });
    }

    if ( post_width < $('.post_body img').width() ) {
        $('.post_body img').css({
            width: post_width + 'px'
        });
    }

    $(window).load(function(){
        // $('iframe').contents().find('td.sy_input').css('width', '250px');
        // $('iframe').contents().find('div#wrapper').css('top','0');
        // var test = $(this).val();
    });
    $('.top_slider').bxSlider({
        pager: true,
        controls: true,
        speed: 1000,
        auto: true,
        pause: 5000
    });

    // smooth scroll
    $('a[href^=#]').click(function(e){
        e.preventDefault();
        var speed = 350;
        var href= $(this).attr("href");
        var target = $(href == "#" || href == "" ? 'html' : href);
        var position = target.offset().top;
        $("html, body").animate({scrollTop:position}, speed, "swing");
        return false;
    });

    $('#knows_map__button').on('click', function(){
        $('.news_theme__pop_wrapper').addClass('view');
    });
    $('.news_theme__close,.news_theme__buttons__cancel').on('click',function(){
        $('.news_theme__pop_wrapper').removeClass('view');
    });

});

