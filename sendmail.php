<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './phpmailer/src/Exception.php';
require './phpmailer/src/PHPMailer.php';

$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';
$mail->setLanguage('ru', 'phpmailer/language');
$mail->isHTML(true);

$mail->setFrom('j-c-mail@mail.ru', 'John Carpenter');
$mail->addAddress('plotiwitolp@gmail.com');

$mail->Subject = "TEEEST";

$hand = "Правая";

if ($_POST['hand'] == "left") {
    $hand = "Левая";
}

$body = '<h1>Title</h1>';

if (trim(!empty($_POST['name']))) {
    $body .= '<p><b>Name: </b> ' . $_POST['name'] . '</p>';
}
if (trim(!empty($_POST['email']))) {
    $body .= '<p><b>E-mail: </b> ' . $_POST['email'] . '</p>';
}
if (trim(!empty($_POST['hand']))) {
    $body .= '<p><b>Рука: </b> ' . $hand . '</p>';
}
if (trim(!empty($_POST['age']))) {
    $body .= '<p><b>Возраст: </b> ' . $_POST['age'] . '</p>';
}
if (trim(!empty($_POST['message']))) {
    $body .= '<p><b>Сообщение: </b> ' . $_POST['message'] . '</p>';
}

if (!empty($_FILES['image']['tmp_name'])) {
    $filePath = __DIR__ . "/files/" . $_FILES['image']['name'];

    if (copy($_FILES['image']['tmp_name'], $filePath)) {
        $fileAttach = $filePath;
        $body .= '<p><b>Фото в приложении</b></p>';
        $mail->addAttachment($fileAttach);
    }
}

$mail->Body = $body;

if (!$mail->send()) {
    $message = 'Error';
} else {
    $message = "Данные отправлены!";
}

$response = ['message' => $message];

header('Content-type: application/json');
echo json_encode($response);
