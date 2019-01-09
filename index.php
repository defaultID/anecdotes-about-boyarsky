<?php
include_once "server/config.php";
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="google-site-verification" content="XDfYdka3n9Ijgx_0TwBkig7bDw_Yxgk2iU0gkTHfxuE" />
    <meta name="yandex-verification" content="8c99182399d388b7" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Анекдоты про Боярского">
    <title>Анекдоты про Боярского</title>

    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" href="images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/remodal-default-theme.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
    <script src="js/cookie.js"></script>
    <script src="js/scroll.js"></script>
    <script src="js/jquery.tmpl.js"></script>
    <script src="js/ajax/wall.js"></script>
</head>
<body>
    <header>
        <div class="headline">
            <a href="/"><img src="images/logo.png"></a>
            <a class="addAnecdote" href="#add">Добавить анекдот</a>
        </div>
    </header>
    <main>
        <div class="random">
            <div id="marqueecontainer" onMouseover="copyspeed=pausespeed" onMouseout="copyspeed=marqueespeed">
                <div id="vmarquee">
                    <?php
                    $random = mysqli_query($link,"SELECT * FROM `anecdotes_table` ORDER BY RAND()");
                    while ($row = mysqli_fetch_assoc($random)) { ?>
                        <div class="<?=($row['id']%2) ? 'red' : 'blue'?>">
                            <span class="aboutAnecdote">#<?=$row['id']?></span>
                            <span class="aboutAnecdote"><?=date_format(date_create_from_format('Y-m-d H:i:s', $row['date']), 'd.m.Y H:i')?></span>
                            <span class="aboutAnecdote"><?=$row['author']?></span>
                            <table class="tableLike">
                                <tr class="trLike">
                                    <td class="imageLike">
                                    <?php if (in_array($row['id'], $_COOKIE)) { ?>
                                            <img class="doneLike like <?=$row['id']?>" src="images/like.png" rel="Unlike">
                                    <?php } else { ?>
                                            <img class="like <?=$row['id']?>" src="images/like.png" rel="Like">
                                    <?php } ?>
                                    </td>
                                    <td class="amountLike amount<?=$row['id']?>"><?=$row['like']?></td>
                                </tr>
                            </table>
                            <p class="titleAnecdote"><?=nl2br($row['title'])?></p>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="wrapWall">
            <div id="wall">
                <script id="template" type="x-jquery-tmpl">
                    {%if id%2 %}
                        <div class="red">
                    {%else%}
                        <div class="blue">
                    {%/if%}
                            <p>#{%= id %}</p>
                            <p>{%= date %}</p>
                            <p>{%= author %}</p>
                            <table class="tableLikeWall">
                                <tr class="trLike">
                                    <td class="imageLike">
                                        <img class="like {%= id %}" src="images/like.png" rel="Like">
                                    </td>
                                    <td class="amountLike amount{%= id %}">{%= like %}</td>
                                </tr>
                            </table>
                            <p class="titleAnecdoteWall">{%html title %}</p>
                        </div>
                </script>
            </div>
            <div id="wallButton">Показать ещё</div>
        </div>
        <div class="top">
            <img class="imageTop" src="images/zenit.png">
            <div class="contentTop">
                <table class="tableTop">
                    <?php
                    $top10 = mysqli_query($link,"SELECT * FROM `anecdotes_table` ORDER BY `anecdotes_table`.`like` DESC LIMIT 0,5");
                    for ($i = 1; $row = mysqli_fetch_assoc($top10); $i++) { ?>
                        <tr class="<?=($i%2) ? 'blue' : 'red'?>">
                            <td class="numberTop"><div><?=$i?></div></td>
                            <td class="tdAnecdote">
                                <span class="aboutAnecdote">#<?=$row['id']?></span>
                                <span class="aboutAnecdote"><?=date_format(date_create_from_format('Y-m-d H:i:s', $row['date']), 'd.m.Y H:i')?></span>
                                <span class="aboutAnecdote"><?=$row['author']?></span>
                                <table class="tableLike">
                                    <tr class="trLike">
                                        <td class="imageLike">
                                        <?php if (in_array($row['id'], $_COOKIE)) { ?>
                                                <img class="doneLike like <?=$row['id']?>" src="images/like.png" rel="Unlike">
                                        <?php } else { ?>
                                                <img class="like <?=$row['id']?>" src="images/like.png" rel="Like">
                                        <?php } ?>
                                        </td>
                                        <td class="amountLike amount<?=$row['id']?>"><?=$row['like']?></td>
                                    </tr>
                                </table>
                                <p><?=nl2br($row['title'])?></p>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
            <footer>
                <a href="#feedback">Обратная связь</a>
                <a href="#donate">Поддержать сайт</a>
                <a href="https://github.com/defaultID/anecdotes-about-boyarsky" target="_blank">GitHub</a>
            </footer>
        </div>
        <img class="smile" src="images/smile.png">
    </main>

    <div class="remodal" data-remodal-id="add" role="dialog">
        <form id="addForm">
            <input type="text" class="putName" name="name" placeholder="Имя" required>
            <textarea name="userMessage" placeholder="Анекдот" required></textarea>
            <input type="submit" class="btn" value="Отправить">
            <input type="hidden" name="formData" value="Заявка с сайта">
        </form>
    </div>
    <div class="remodal" data-remodal-id="feedback" role="dialog">
        <form id="feedForm">
            <input type="text" class="putName" name="name" placeholder="Имя" required>
            <input type="text" class="putEmail" name="email" placeholder="Email">
            <textarea name="userMessage" rows="8" cols="48" placeholder="Сообщение" required></textarea>
            <input type="submit" class="btn" value="Отправить">
            <input type="hidden" name="formData" value="Сообщение с сайта">
        </form>
    </div>
    <div class="remodal donate" data-remodal-id="donate" role="dialog">
        <iframe src="https://money.yandex.ru/quickpay/shop-widget?writer=seller&targets=%D0%A1%D0%BF%D0%B0%D1%81%D0%B8%D0%B1%D0%BE%20%D0%B7%D0%B0%20%D0%BF%D0%BE%D0%B4%D0%B4%D0%B5%D1%80%D0%B6%D0%BA%D1%83!&targets-hint=&default-sum=50&button-text=11&payment-type-choice=on&comment=on&hint=&successURL=&quickpay=shop&account=410015275771859" width="100%" height="301" frameborder="0" allowtransparency="true" scrolling="no"></iframe>
    </div>

<span style="display: none;"><!--LiveInternet counter-->
    <script type="text/javascript">
    document.write("<a href='//www.liveinternet.ru/click' "+
        "target=_blank><img src='//counter.yadro.ru/hit?t14.1;r"+
        escape(document.referrer)+((typeof(screen)=="undefined")?"":
            ";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
                screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
        ";"+Math.random()+
        "' alt='' title='LiveInternet: показано число просмотров за 24"+
        " часа, посетителей за 24 часа и за сегодня' "+
        "border='0' width='88' height='31'><\/a>")
    </script><!--/LiveInternet-->
</span>
<script id="chatBroEmbedCode">/* Chatbro Widget Embed Code Start */function ChatbroLoader(chats,async){async=!1!==async;var params={embedChatsParameters:chats instanceof Array?chats:[chats],lang:navigator.language||navigator.userLanguage,needLoadCode:'undefined'==typeof Chatbro,embedParamsVersion:localStorage.embedParamsVersion,chatbroScriptVersion:localStorage.chatbroScriptVersion},xhr=new XMLHttpRequest;xhr.withCredentials=!0,xhr.onload=function(){eval(xhr.responseText)},xhr.onerror=function(){console.error('Chatbro loading error')},xhr.open('GET','//www.chatbro.com/embed.js?'+btoa(unescape(encodeURIComponent(JSON.stringify(params)))),async),xhr.send()}/* Chatbro Widget Embed Code End */ChatbroLoader({encodedChatId: '3gz2'});</script>
<script src="js/remodal.min.js"></script>
<script src="js/ajax/like.js"></script>
<script src="js/ajax/mail.js"></script>
<script src="js/scroll-top.js"></script>
<script>
    function noselect() {
        return false;
    }
    document.ondragstart = noselect; // запрет на перетаскивание
    document.onselectstart = noselect; // запрет на выделение элементов страницы
    //document.oncontextmenu = noselect; // запрет на выведение контекстного меню
</script>
</body>
</html>