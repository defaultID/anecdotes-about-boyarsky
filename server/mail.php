<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['name'])) {$name = $_POST['name'];}
    if (isset($_POST['userMessage'])) {$userMessage = $_POST['userMessage'];}
    if (isset($_POST['email'])) {$email = $_POST['email'];}
    if (isset($_POST['formData'])) {$formData = $_POST['formData'];}

    $to = "boyarskyID@yandex.ru"; /*Укажите адрес, на который должно приходить письмо*/
    $sendfrom   = "anecdotes@boyarsky.ru"; /*Укажите адрес, с которого будет приходить письмо, можно не настоящий, нужно для формирования заголовка письма*/
    $headers  = "From: " . strip_tags($sendfrom) . "\r\n";
    $headers .= "Reply-To: ". strip_tags($sendfrom) . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html;charset=utf-8 \r\n";
    $subject = "$formData";
    $message = "$formData<br><b>Имя пославшего:</b> $name";
    if ($formData == "Сообщение с сайта") $message .= "<br><b>Email:</b> $email";
    $message .= "<br><b>Сообщение:</b> $userMessage";
    $send = mail ($to, $subject, $message, $headers);
    if ($send == 'true') {
        $response = ($formData == 'Заявка с сайта') ? 'Анекдот отправлен' : 'Сообщение отправлено';
    } else {
        $response = ($formData == 'Заявка с сайта') ? 'Ошибка. Анекдот не отправлен' : 'Ошибка. Сообщение не отправлено';
    }
    echo "<p class='response'>$response</p>";
} else {
    http_response_code(403);
    echo "Ошибка. Попробуйте еще раз";
}