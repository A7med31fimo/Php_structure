<?php
$mail_config = require __DIR__ . "/../../config/mail.php";
var_dump($GLOBALS['mail_config']["from_address"]);
function sendMAil(array $mails, string $subject, string $message)
{
    if ($GLOBALS['mail_config']["protocol"] == 'ssl') {
        ini_set("SMTP", $GLOBALS['mail_config']["smtp_domain"]);
        ini_set("smtp_port", $GLOBALS['mail_config']["smtp_port"]);
    }
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
    $headers .= 'From:' . $GLOBALS['mail_config']["from_address"] . "\r\n";

    foreach ($mails as $mail) {
        if (!mail($mail, $subject, $message, $headers)) {
            return new Exception("Mail not sent");
        }
    }
    return "Mail sent successfully";
}

sendMAil(['ahmed1@gmail.com'],'Test Subject', '<h1>This is a test mail message.</h1>');