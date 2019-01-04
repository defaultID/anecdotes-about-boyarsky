$(document).ready(function(){
    $('body').append('<div class="buttonUp"><img src="images/arrow.png"></div>');

    $(window).scroll(function(){
        if ($(this).scrollTop() > 685) {
            $('.buttonUp').fadeIn();
        } else {
            $ ('.buttonUp').fadeOut();
        }
    });

    $('.buttonUp').click(function(){
        $('body,html').animate({
            scrollTop: 0
        }, 100);
        return false;
    }).hover(function(){
        $(this).animate({
            'opacity':'1'
        }).css({'box-shadow':'0 0 20px 0 rgba(0, 0, 0, 0.42)'});
    }, function(){
        $(this).animate({
            'opacity':'0.7'
        }).css({'box-shadow':'none'});
    });
});