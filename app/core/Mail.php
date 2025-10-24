<?php

namespace  App\Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Use mailTrap to make email send successfully
 * but change attr ..
 * @param string $email_to  
 * @param string $subject
 * @param string $body
 * @return boolean
 */

class Mail{

    public static function sendMail($email_to, $subject, $body)
    {
        $mail = new PHPMailer(true);
    
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = 'sandbox.smtp.mailtrap.io'; // سيرفر الإرسال
            $mail->SMTPAuth   = true;
            $mail->Username   = 'c7377f40784637';
            $mail->Password   = '9e7acf9cbe6748';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->CharSet    = 'UTF-8';
            $mail->Encoding   = 'base64';
            // Sender & Recipient
            $mail->setFrom('FimoCv@gmail.com', 'CvCreate');
            $mail->addAddress($email_to);
    
            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->AltBody = strip_tags($body);
    
            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Mail Error: {$mail->ErrorInfo}");
            return false;
        }
    }
}
