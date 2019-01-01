$('.like').die('click').live("click",function() {
    var id = $(this).attr("class").split("like");
    id = +id[1];
    var rel = $(this).attr("rel");
    var URL = 'server/like.php';
    var dataString = 'id=' + id + '&rel=' + rel;
    $.ajax({
        type: "POST",
        url: URL,
        data: dataString,
        cache: false,
        success: function (html) {
            if (rel === 'Like') {
                setcookie(id,id,10);
                $('.' + id).attr('rel', 'Unlike').attr('class', 'doneLike like ' + id);
            } else {
                setcookie(id,id,-10);
                $('.' + id).attr('rel', 'Like').attr('class', 'like ' + id);
            }
            $('.amount' + id).html(html);
        }
    })
});