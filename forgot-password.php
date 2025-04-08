<?php
require 'includes/db.php';
require 'includes/mailer.php';
require 'includes/session.php';
require 'includes/email_customization.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    // Enhanced validation
    if (empty($email)) {
        $_SESSION["ErrorMessage"] = "Email address is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["ErrorMessage"] = "Please enter a valid email address";
    } else {
        // Check if user exists
        $stmt = $pdo->prepare("SELECT id, name FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($stmt->rowCount() > 0) {
            // Check if user has an expired code
            if ($user['twofa_code'] && strtotime($user['twofa_expires']) <= time()) {
                $_SESSION["ErrorMessage"] = "Previous verification code expired. A new one has been sent.";
                // Generate new code
                $reset_code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                $reset_expires = date('Y-m-d H:i:s', strtotime('+10 minutes'));

                $pdo->prepare("UPDATE users SET twofa_code = ?, twofa_expires = ? WHERE email = ?")
                    ->execute([$reset_code, $reset_expires, $email]);

                // Resend email with new code
                try {
                    $mail->clearAddresses();
                    $mail->addAddress($email);
                    $mail->Subject = 'Your New Password Reset Code';
                    $emailTemplate = getPasswordResetCodeTemplate($user['name'], $reset_code);
                    $mail->Body = $emailTemplate;
                    $mail->AltBody = "Your new password reset code: $reset_code\nExpires in 10 minutes";
                    $mail->send();
                } catch (Exception $e) {
                    // Handle email error
                }

                header("Location: 2fa.php?email=" . urlencode($email) . "&reset=1");
                exit;
            }
            // Generate 6-digit reset code
            $reset_code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $reset_expires = date('Y-m-d H:i:s', strtotime('+10 minutes'));

            // Update user with reset code
            $stmt = $pdo->prepare("UPDATE users SET twofa_code = ?, twofa_expires = ? WHERE email = ?");
            if ($stmt->execute([$reset_code, $reset_expires, $email])) {
                // Send reset email
                try {
                    $mail->clearAddresses();
                    $mail->addAddress($email);
                    $mail->Subject = 'Password Reset Code';

                    // Get email template from the includes file
                    $emailTemplate = getPasswordResetCodeTemplate($user['name'], $reset_code);

                    $mail->Body = $emailTemplate;
                    $mail->AltBody = "Your password reset code: $reset_code\nExpires in 10 minutes";

                    if (!$mail->send()) {
                        $_SESSION["ErrorMessage"] = "Failed to send reset email. Please try again later.";
                    } else {
                        $_SESSION["SuccessMessage"] = "Password reset code sent to your email";
                        header("Location: 2fa.php?email=" . urlencode($email) . "&reset=1");
                        exit;
                    }
                } catch (Exception $e) {
                    $_SESSION["ErrorMessage"] = "Failed to send reset email. Please try again later.";
                }
            } else {
                $_SESSION["ErrorMessage"] = "An error occurred. Please try again later.";
            }
        } else {
            // Don't reveal if email exists for security reasons
            $_SESSION["SuccessMessage"] = "If your email is registered, you will receive a password reset code";
            header("Location: sign-in.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en-US" dir="ltr" data-navigation-type="default" data-navbar-horizontal-shape="default">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Meta Description -->
    <meta name="description" content="Reset your Nexusflow password - Secure password recovery process">
    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Password Recovery</title>
    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->

    <!-- header css links  -->
    <?php include_once('includes/auth_header.php') ?>
    <!-- phoenixIsRTL -->
    <?php include_once('includes/phoenixIsRTL.php') ?>
</head>

<body>
    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
        <div class="container">
            <div class="row flex-center min-vh-100 py-5">
                <div class="col-sm-10 col-md-8 col-lg-5 col-xxl-4"><a
                        class="d-flex flex-center text-decoration-none mb-4" href="index.php">
                        <div class="d-flex align-items-center fw-bolder fs-3 d-inline-block"><img
                                src="assets/img/icons/logo.png" alt="phoenix" width="58" /></div>
                    </a>
                    <div class="px-xxl-5">
                        <div class="text-center mb-6">
                            <h4 class="text-body-highlight">Forgot your password?</h4>
                            <p class="text-body-tertiary mb-5">Enter your email below and we will send you a
                                verification code to reset your password</p>
                            <?php echo ErrorMessage(); ?>
                            <?php echo SuccessMessage(); ?>
                            <form class="d-flex align-items-center mb-5" method="POST" action="">
                                <input class="form-control flex-1" id="email" name="email" type="email"
                                    placeholder="Email" required />
                                <button type="submit" class="btn btn-primary ms-2">Send<span
                                        class="fas fa-chevron-right ms-2"></span></button>
                            </form>
                            <a class="fs-9 fw-bold" href="sign-in.php">Back to login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include('includes/support-chat.php') ?>
    </main><!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->

    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <!-- header css links  -->
    <?php include_once('includes/auth_footer.php') ?>

</body>

</html>