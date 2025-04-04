<?php
require __DIR__ . '/../vendor/autoload.php';

$mail = new PHPMailer\PHPMailer\PHPMailer(true);

try {
    // Gmail SMTP Configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'haloblack2k@gmail.com';
    $mail->Password = 'rrzlfknjsmvmhcbq';
    $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Sender info
    $mail->setFrom('haloblack2k@gmail.com', 'NexusFlow');
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';
} catch (Exception $e) {
    error_log("Mailer Error: " . $e->getMessage());
    die('Mail configuration error');
}
