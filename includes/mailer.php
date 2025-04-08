<?php
require __DIR__ . '/../vendor/autoload.php';

$mail = new PHPMailer\PHPMailer\PHPMailer(true);

try {
    $mail->SMTPDebug = 0;
    $mail->Debugoutput = function ($str, $level) {
        error_log("SMTP Debug (level $level): $str");
    };

    // Gmail SMTP Configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'haloblack2k@gmail.com';
    $mail->Password = 'rrzlfknjsmvmhcbq';
    $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;
    $mail->Timeout = 45;
    
    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        ]
    ];

    if (!$mail->smtpConnect()) {
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        if (!$mail->smtpConnect()) {
            throw new Exception('Failed to connect using both SSL and STARTTLS');
        }
    }

    $mail->setFrom('haloblack2k@gmail.com', 'NexusFlow');
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->XMailer = 'NexusFlow Mailer';
    $mail->Priority = 1;
    $mail->addCustomHeader('Importance: High');
    $mail->addCustomHeader('X-Priority: 1 (Highest)');
} catch (Exception $e) {
    error_log("Mailer Error: " . $e->getMessage());
    die('An error occurred while sending the email. Please try again later.');
}
