<?php
require_once __DIR__ . '/mailer.php';
require_once __DIR__ . '/email_customization.php';

/**
 * Send a welcome email to users who registered with Google
 * 
 * @param string $email User's email address
 * @param string $name User's name
 * @return bool Success status
 */
function sendGoogleWelcomeEmail($email, $name) {
    global $mail;
    
    try {
        $mail->clearAddresses();
        $mail->addAddress($email);
        $mail->Subject = 'Welcome to NexusFlow!';
        
        // Get welcome email template
        $emailTemplate = getGoogleWelcomeEmailTemplate($name);
        
        $mail->Body = $emailTemplate;
        $mail->AltBody = "Welcome to NexusFlow, $name! Thank you for joining our platform using Google Sign-In.";
        
        return $mail->send();
    } catch (Exception $e) {
        error_log("Google Welcome Email Error: " . $e->getMessage());
        return false;
    }
}