$(document).ready(function() {
    $('body').append('<div class="button-up" style="display: none;opacity: 0.7;width: 32px;height:100%;position: fixed;left: 0px;top: 0px;cursor: pointer;text-align: center;line-height: 280px;"><img src="images/arrow.png" width="22"></div>');

    $ (window).scroll(function() {
        if ($(this).scrollTop () > 685) {
            $('.button-up').fadeIn();
        } else {
            $ ('.button-up').fadeOut();
        }
    });

    $('.button-up').click(function(){
        $('body,html').animate({
            scrollTop: 0
        }, 100);
        return false;
    });
    $('.button-up').hover(function() {
        $(this).animate({
            'opacity':'1',
        }).css({'box-shadow':'0 0 20px 0 rgba(0, 0, 0, 0.42)'});
    }, function(){
        $(this).animate({
            'opacity':'0.7'
        }).css({'box-shadow':'none'});
    });
});