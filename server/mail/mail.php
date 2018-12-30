<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['name'])) {$name = $_POST['name'];}
    if (isset($_POST['anecdote'])) {$anecdote = $_POST['anecdote'];}
    if (isset($_POST['formData'])) {$formData = $_POST['formData'];}

    $to = "boyarskyID@yandex.ru"; /*Укажите адрес, на который должно приходить письмо*/
    $sendfrom   = "anecdotes@boyarsky.com"; /*Укажите адрес, с которого будет приходить письмо, можно не настоящий, нужно для формирования заголовка письма*/
    $headers  = "From: " . strip_tags($sendfrom) . "\r\n";
    $headers .= "Reply-To: ". strip_tags($sendfrom) . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html;charset=utf-8 \r\n";
    $subject = "$formData";
    $message = "$formData <br><b>Имя пославшего:</b> $name <br><b>Анекдот:</b> $anecdote";
    $send = mail ($to, $subject, $message, $headers);
    if ($send == 'true')
    {
        echo '<center><p class="success">Анекдот отправлен</p></center>';
    }
    else
    {
        echo '<center><p class="fail"><b>Ошибка. Анекдот не отправлен</b></p></center>';
    }
} else {
    http_response_code(403);
    echo "Попробуйте еще раз";
}