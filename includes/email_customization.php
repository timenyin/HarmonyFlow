<?php
/**
 * Email template customization functions
 * Contains responsive email templates for the application
 */

/**
 * Generates a verification code email template
 * 
 * @param string $name User's name
 * @param string $code Verification code
 * @return string HTML email template
 */
function getVerificationEmailTemplate($name, $code) {
    return '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Verification Code</title>
        <style>
            @media only screen and (max-width: 620px) {
                .email-container {
                    width: 100% !important;
                }
                .code-container {
                    width: 80% !important;
                }
            }
            body {
                font-family: Arial, sans-serif;
                line-height: 1.6;
                margin: 0;
                padding: 0;
                background-color: #f4f7fa;
            }
            .email-container {
                max-width: 600px;
                margin: 0 auto;
                background: #ffffff;
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            }
            .email-header {
                background-color: #3b71ca;
                padding: 20px;
                text-align: center;
            }
            .email-header img {
                max-width: 150px;
            }
            .email-body {
                padding: 30px;
                color: #333333;
            }
            .email-footer {
                background-color: #f4f7fa;
                padding: 20px;
                text-align: center;
                font-size: 12px;
                color: #666666;
            }
            h1 {
                color: #333333;
                font-size: 24px;
                margin-bottom: 20px;
            }
            p {
                margin-bottom: 15px;
            }
            .code-container {
                background-color: #f8f9fa;
                border: 1px solid #e9ecef;
                border-radius: 6px;
                padding: 20px;
                margin: 25px auto;
                text-align: center;
                width: 60%;
            }
            .verification-code {
                font-size: 32px;
                font-weight: bold;
                letter-spacing: 5px;
                color: #3b71ca;
            }
            .expiry-note {
                font-size: 13px;
                color: #6c757d;
                margin-top: 15px;
            }
        </style>
    </head>
    <body>
        <div class="email-container">
            <div class="email-header">
                <img src="https://yourdomain.com/assets/img/icons/logo.png" alt="NexusFlow Logo">
            </div>
            <div class="email-body">
                <h1>Hi, ' . htmlspecialchars($name) . '</h1>
                <p>Thank you for registering with NexusFlow. To verify your account, please use the verification code below:</p>
                
                <div class="code-container">
                    <div class="verification-code">' . $code . '</div>
                    <p class="expiry-note">This code will expire in 10 minutes</p>
                </div>
                
                <p>If you did not request this verification code, please ignore this email.</p>
                
                <p>Regards,<br>The NexusFlow Team</p>
            </div>
            <div class="email-footer">
                <p>&copy; ' . date('Y') . ' NexusFlow. All rights reserved.</p>
                <p>If you have any questions, please contact our support team.</p>
            </div>
        </div>
    </body>
    </html>
    ';
}

/**
 * Generates a password reset email template
 * 
 * @param string $name User's name
 * @param string $resetLink Password reset link
 * @return string HTML email template
 */
function getPasswordResetEmailTemplate($name, $resetLink) {
    return '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Password Reset</title>
        <style>
            @media only screen and (max-width: 620px) {
                .email-container {
                    width: 100% !important;
                }
                .button-container {
                    width: 100% !important;
                }
            }
            body {
                font-family: Arial, sans-serif;
                line-height: 1.6;
                margin: 0;
                padding: 0;
                background-color: #f4f7fa;
            }
            .email-container {
                max-width: 600px;
                margin: 0 auto;
                background: #ffffff;
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            }
            .email-header {
                background-color: #3b71ca;
                padding: 20px;
                text-align: center;
            }
            .email-header img {
                max-width: 150px;
            }
            .email-body {
                padding: 30px;
                color: #333333;
            }
            .email-footer {
                background-color: #f4f7fa;
                padding: 20px;
                text-align: center;
                font-size: 12px;
                color: #666666;
            }
            h1 {
                color: #333333;
                font-size: 24px;
                margin-bottom: 20px;
            }
            p {
                margin-bottom: 15px;
            }
            .button-container {
                text-align: center;
                margin: 30px 0;
            }
            .reset-button {
                background-color: #3b71ca;
                color: white;
                padding: 12px 30px;
                text-decoration: none;
                border-radius: 4px;
                font-weight: bold;
                display: inline-block;
            }
        </style>
    </head>
    <body>
        <div class="email-container">
            <div class="email-header">
                <img src="https://yourdomain.com/assets/img/icons/logo.png" alt="NexusFlow Logo">
            </div>
            <div class="email-body">
                <h1>Hi, ' . htmlspecialchars($name) . '</h1>
                <p>Someone (hopefully you!) requested a password reset for your account. Click the link below to choose a new password.</p>
                
                <div class="button-container">
                    <a href="' . $resetLink . '" class="reset-button">Reset your password</a>
                </div>
                
                <p>If you did not request a password reset, you can simply ignore this message.</p>
                
                <p>Regards,<br>The NexusFlow Team</p>
            </div>
            <div class="email-footer">
                <p>&copy; ' . date('Y') . ' NexusFlow. All rights reserved.</p>
                <p>If you have any questions, please contact our support team.</p>
            </div>
        </div>
    </body>
    </html>
    ';
}

/**
 * Generates a password reset code email template
 * 
 * @param string $name User's name
 * @param string $code Password reset code
 * @return string HTML email template
 */
function getPasswordResetCodeTemplate($name, $code) {
    return '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Password Reset Code</title>
        <style>
            @media only screen and (max-width: 620px) {
                .email-container {
                    width: 100% !important;
                }
                .code-container {
                    width: 80% !important;
                }
            }
            body {
                font-family: Arial, sans-serif;
                line-height: 1.6;
                margin: 0;
                padding: 0;
                background-color: #f4f7fa;
            }
            .email-container {
                max-width: 600px;
                margin: 0 auto;
                background: #ffffff;
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            }
            .email-header {
                background-color: #3b71ca;
                padding: 20px;
                text-align: center;
            }
            .email-header img {
                max-width: 150px;
            }
            .email-body {
                padding: 30px;
                color: #333333;
            }
            .email-footer {
                background-color: #f4f7fa;
                padding: 20px;
                text-align: center;
                font-size: 12px;
                color: #666666;
            }
            h1 {
                color: #333333;
                font-size: 24px;
                margin-bottom: 20px;
            }
            p {
                margin-bottom: 15px;
            }
            .code-container {
                background-color: #f8f9fa;
                border: 1px solid #e9ecef;
                border-radius: 6px;
                padding: 20px;
                margin: 25px auto;
                text-align: center;
                width: 60%;
            }
            .verification-code {
                font-size: 32px;
                font-weight: bold;
                letter-spacing: 5px;
                color: #3b71ca;
            }
            .expiry-note {
                font-size: 13px;
                color: #6c757d;
                margin-top: 15px;
            }
        </style>
    </head>
    <body>
        <div class="email-container">
            <div class="email-header">
                <img src="https://yourdomain.com/assets/img/icons/logo.png" alt="NexusFlow Logo">
            </div>
            <div class="email-body">
                <h1>Hi, ' . htmlspecialchars($name) . '</h1>
                <p>We received a request to reset your password. To continue with the password reset process, please use the verification code below:</p>
                
                <div class="code-container">
                    <div class="verification-code">' . $code . '</div>
                    <p class="expiry-note">This code will expire in 10 minutes</p>
                </div>
                
                <p>If you did not request a password reset, please ignore this email or contact support if you have concerns.</p>
                
                <p>Regards,<br>The NexusFlow Team</p>
            </div>
            <div class="email-footer">
                <p>&copy; ' . date('Y') . ' NexusFlow. All rights reserved.</p>
                <p>If you have any questions, please contact our support team.</p>
            </div>
        </div>
    </body>
    </html>
    ';
}

// Add this function to your existing email_customization.php file

/**
 * Generates a welcome email template for Google sign-in users
 * 
 * @param string $name User's name
 * @return string HTML email template
 */
function getGoogleWelcomeEmailTemplate($name) {
    return '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Welcome to NexusFlow</title>
        <style>
            @media only screen and (max-width: 620px) {
                .email-container {
                    width: 100% !important;
                }
            }
            body {
                font-family: Arial, sans-serif;
                line-height: 1.6;
                margin: 0;
                padding: 0;
                background-color: #f4f7fa;
            }
            .email-container {
                max-width: 600px;
                margin: 0 auto;
                background: #ffffff;
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            }
            .email-header {
                background-color: #3b71ca;
                padding: 20px;
                text-align: center;
            }
            .email-header img {
                max-width: 150px;
            }
            .email-body {
                padding: 30px;
                color: #333333;
            }
            .email-footer {
                background-color: #f4f7fa;
                padding: 20px;
                text-align: center;
                font-size: 12px;
                color: #666666;
            }
            h1 {
                color: #333333;
                font-size: 24px;
                margin-bottom: 20px;
            }
            p {
                margin-bottom: 15px;
            }
            .button {
                display: inline-block;
                background-color: #3b71ca;
                color: #ffffff;
                text-decoration: none;
                padding: 12px 24px;
                border-radius: 4px;
                font-weight: bold;
                margin: 20px 0;
            }
            .social-icons {
                margin-top: 20px;
            }
            .social-icons a {
                display: inline-block;
                margin: 0 8px;
            }
        </style>
    </head>
    <body>
        <div class="email-container">
            <div class="email-header">
                <img src="https://yourdomain.com/assets/img/icons/logo.png" alt="NexusFlow Logo">
            </div>
            <div class="email-body">
                <h1>Welcome to NexusFlow, ' . htmlspecialchars($name) . '!</h1>
                <p>Thank you for joining NexusFlow using Google Sign-In. We\'re excited to have you on board!</p>
                <p>Your account has been successfully created and you can now access all the features of our platform.</p>
                <p>Here\'s what you can do next:</p>
                <ul>
                    <li>Explore your personalized dashboard</li>
                    <li>Update your profile information</li>
                    <li>Connect with other users</li>
                    <li>Discover our premium features</li>
                </ul>
                <p>If you have any questions or need assistance, our support team is always ready to help.</p>
                <div style="text-align: center;">
                    <a href="https://yourdomain.com/dashboard.php" class="button">Go to Dashboard</a>
                </div>
            </div>
            <div class="email-footer">
                <p>© ' . date('Y') . ' NexusFlow. All rights reserved.</p>
                <p>If you did not create this account, please contact our support team immediately.</p>
                <div class="social-icons">
                    <a href="#"><img src="https://yourdomain.com/assets/img/icons/facebook.png" alt="Facebook"></a>
                    <a href="#"><img src="https://yourdomain.com/assets/img/icons/twitter.png" alt="Twitter"></a>
                    <a href="#"><img src="https://yourdomain.com/assets/img/icons/instagram.png" alt="Instagram"></a>
                </div>
            </div>
        </div>
    </body>
    </html>';
}