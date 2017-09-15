$ = jQuery;

$(function(){
    if($('.flipsnap_skills').length > 0){

        Flipsnap('.flipsnap_skills');
        var flipsnap = Flipsnap('.flipsnap_skills', {
            distance: 70
        });
        var $next = $('.next').click(function() {
            flipsnap.toNext();
        });
        var $prev = $('.prev').click(function() {
            flipsnap.toPrev();
        });
        flipsnap.element.addEventListener('fspointmove', function() {
            $next.attr('disabled', !flipsnap.hasNext());
            $prev.attr('disabled', !flipsnap.hasPrev());
        }, false);
    }

});