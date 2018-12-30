$('.like').die('click').live("click",function() {
    var id = $(this).attr("class").split("like");
    var msg_id = +id[1];
    var rel = $(this).attr("rel");
    var URL = 'server/message_like_ajax.php';
    var dataString = 'msg_id=' + msg_id + '&rel=' + rel;
    $.ajax({
        type: "POST",
        url: URL,
        data: dataString,
        cache: false,
        success: function (html) {
            if (rel === 'Like') {
                setcookie(msg_id,msg_id,10); //Cтавим кук (10 - число действующих дней)
                $('.' + msg_id).attr('rel', 'Unlike').attr('class', 'doneLike like ' + msg_id);
                $('.amount' + msg_id).html(html);
            } else {
                setcookie(msg_id,msg_id,-10);
                $('.' + msg_id).attr('rel', 'Like').attr('class', 'like ' + msg_id);
                $('.amount' + msg_id).html(html);
            }
        }
    })
});