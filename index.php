<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
include_once "server/db.php";
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="google-site-verification" content="XDfYdka3n9Ijgx_0TwBkig7bDw_Yxgk2iU0gkTHfxuE" />
    <meta name="yandex-verification" content="8c99182399d388b7" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Анекдоты про Боярского</title>

    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" href="images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/remodal-default-theme.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
    <script src="js/cookie.js"></script>
    <script src="js/scroll.js"></script>
    <script src="js/jquery.tmpl.js"></script>
    <script src="js/list-news.js"></script>
</head>
<body>
    <header>
        <div class="logo">
            <a href="/"><img src="images/logo.png"></a>
            <a class="addAnecdote" href="#add">Добавить анекдот</a>
            <a href="#donate">Поддержать сайт</a>
            <a href="#feedback">Обратная связь</a>
        </div>
    </header>
    <div class="wrap">
        <div class="random">
            <div id="marqueecontainer" onMouseover="copyspeed=pausespeed" onMouseout="copyspeed=marqueespeed">
                <div id="vmarquee">
                    <?php
                    $random = mysqli_query($link,"SELECT * FROM `anecdotes_table` ORDER BY RAND()");
                    while ($row = mysqli_fetch_assoc($random)) { ?>
                        <div class="<?=($row['id']%2) ? 'red' : 'blue'?>">
                            <span class="aboutAnecdote">#<?=$row['id']?></span>
                            <span class="aboutAnecdote"><?=time_format($row['date'])?></span>
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
            <div id="list-news-btn">Показать ещё</div>
        </div>
        <div class="top">
            <div class="headTop"><img src="images/zenit.png"></div>
            <div class="contentTop">
                <table class="tableTop">
                    <?php
                    $top10 = mysqli_query($link,"SELECT * FROM `anecdotes_table` ORDER BY  `anecdotes_table`.`like` DESC LIMIT 0,5");
                    for ($i = 1; $row = mysqli_fetch_assoc($top10); $i++) { ?>
                        <tr class="<?=($i%2) ? 'blue' : 'red'?>">
                            <td class="numberTop"><div><?=$i?></div></td>
                            <td class="tdAnecdote">
                                <span class="aboutAnecdote">#<?=$row['id']?></span>
                                <span class="aboutAnecdote"><?=time_format($row['date'])?></span>
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
        </div>
        <img class="smile" src="images/smile.png">
    </div>

    <div class="remodal" data-remodal-id="add" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc">
        <div>
            <form id="form">
                <input type="text" class="putName" name="name" placeholder="Имя" required>
                <textarea name="anecdote" rows="8" cols="48" placeholder="Анекдот" required></textarea>
                <input type="submit" class="btn" name="submit" value="Отправить">
                <input type="hidden" name="formData" value="Заявка с сайта">
            </form>
        </div>
    </div>
    <div class="remodal" data-remodal-id="feedback" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc">
        <div>
            <form id="feedForm">
                <input type="text" class="putName" name="name" placeholder="Имя" required>
                <input type="text" class="putEmail" style="margin-top: 0;" name="email" placeholder="Email">
                <textarea name="message" rows="8" cols="48" placeholder="Сообщение" required></textarea>
                <input type="submit" class="btn" name="submit" value="Отправить">
                <input type="hidden" name="formData" value="Сообщение с сайта">
            </form>
        </div>
    </div>
    <div class="remodal" style="width: 429px; max-width: 429px; height: 175px; padding: 8px; border-radius: 11px; margin-bottom: 40px;" data-remodal-id="donate" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc">
        <form id="donateForm">
            <iframe frameborder="0" allowtransparency="true" scrolling="no" src="https://money.yandex.ru/embed/donate.xml?account=410015275771859&quickpay=donate&payment-type-choice=on&default-sum=&targets=%D0%A1%D0%BF%D0%B0%D1%81%D0%B8%D0%B1%D0%BE+%D0%B7%D0%B0+%D0%BF%D0%BE%D0%B4%D0%B4%D0%B5%D1%80%D0%B6%D0%BA%D1%83!&target-visibility=on&project-name=&project-site=&button-text=03&comment=on&hint=%D0%A1%D0%BE%D0%BE%D0%B1%D1%89%D0%B5%D0%BD%D0%B8%D0%B5+(%D0%B2%D0%B0%D1%88%D0%B5+%D0%B8%D0%BC%D1%8F)&successURL=" width="411" height="160"></iframe>
        </form>
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
<script src="js/like.js"></script>
<script src="js/mail.js"></script>
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