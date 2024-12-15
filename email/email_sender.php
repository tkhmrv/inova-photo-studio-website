<?php
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';
require '../vendor/phpmailer/phpmailer/src/Exception.php';

require_once('../functions.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$username = $_GET['username'];
$email = $_GET['email'];
$email_token = $_GET['token'];

$mail = new PHPMailer(true);
$confirmation_link = "https://tihomirov.xn--80ahdri7a.site/cw/email/email_confirmed.php?token=$email_token";
$titleMail = "Подтверждение регистрации на сайте фотостудии Inova";

try {
  $mail->isSMTP();
  $mail->CharSet = "UTF-8";
  $mail->SMTPAuth = true;

  $mail->Host = $_ENV['MAIL_HOST'];
  $mail->Username = $_ENV['MAIL_USER_ADDRESS'];
  $mail->Password = $_ENV['MAIL_USER_PASSWORD'];
  $mail->SMTPSecure = 'ssl';
  $mail->Port = 465;

  $mail->setFrom($_ENV['MAIL_USER_ADDRESS'], 'Фотостудия Inova - подтверждение регистрации');
  $mail->addAddress($email);

  $mail->isHTML(true);
  $mail->Subject = $titleMail;

  $bodyTemplate = file_get_contents('confirmation_template.php');
  $body = str_replace(
    ['{{username}}', '{{confirmation_link}}'],
    [$username, $confirmation_link],
    $bodyTemplate
  );

  $mail->Body = $body;
  $mail->send();

  echo "Письмо успешно отправлено!";

  // Перенаправление на страницу профиля
  header("Location: ../account.php");
} catch (Exception $e) {
  echo "Ошибка при отправке письма: {$mail->ErrorInfo}!";
}
