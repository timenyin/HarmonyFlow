<?php
require 'includes/db.php';
require 'includes/mailer.php';
require 'includes/session.php';
require 'includes/email_customization.php'; // Add this new include

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirmPassword'] ?? '';
    $terms_accepted = isset($_POST['termsService']);

    // Enhanced validation
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $_SESSION["ErrorMessage"] = "All fields must be filled out";
    } elseif (!$terms_accepted) {
        $_SESSION["ErrorMessage"] = "You must accept the terms and privacy policy";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["ErrorMessage"] = "Please enter a valid email address";
    } elseif (strlen($password) < 8) {
        $_SESSION["ErrorMessage"] = "Password should be at least 8 characters";
    } elseif (
        !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) ||
        !preg_match('/[0-9]/', $password) || !preg_match('/[\W]/', $password)
    ) {
        $_SESSION["ErrorMessage"] = "Password must include uppercase, lowercase, number, and special character";
    } elseif ($password !== $confirm_password) {
        $_SESSION["ErrorMessage"] = "Passwords don't match";
    } else {
        // Check existing user
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch();
            // Check if user has an expired code - add isset check to prevent warning
            if (isset($user['twofa_code']) && $user['twofa_code'] && isset($user['twofa_expires']) && strtotime($user['twofa_expires']) <= time()) {
                $_SESSION["ErrorMessage"] = "Previous verification code expired. A new one has been sent.";
                // Generate new code and send email
                $twofa_code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                $twofa_expires = date('Y-m-d H:i:s', strtotime('+10 minutes'));

                $pdo->prepare("UPDATE users SET twofa_code = ?, twofa_expires = ? WHERE email = ?")
                    ->execute([$twofa_code, $twofa_expires, $email]);

                // Resend email with new code
                try {
                    $mail->clearAddresses();
                    $mail->addAddress($email);
                    $mail->Subject = 'Your New Verification Code';
                    $emailTemplate = getVerificationEmailTemplate($name, $twofa_code);
                    $mail->Body = $emailTemplate;
                    $mail->AltBody = "Your new verification code: $twofa_code\nExpires in 10 minutes";
                    $mail->send();
                } catch (Exception $e) {
                    // Handle email error
                }

                header("Location: 2fa.php?email=" . urlencode($email));
                exit;
            }
            $_SESSION["ErrorMessage"] = "Email already registered";
        } else {
            // Generate 2FA code
            $twofa_code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $twofa_expires = date('Y-m-d H:i:s', strtotime('+10 minutes'));
            $hash = password_hash($password, PASSWORD_DEFAULT);

            // Insert user with 2FA disabled by default
            $stmt = $pdo->prepare("
                INSERT INTO users (email, password_hash, name, twofa_code, twofa_expires, 2fa_enabled)
                VALUES (?, ?, ?, ?, ?, 0)
            ");

            if ($stmt->execute([$email, $hash, $name, $twofa_code, $twofa_expires])) {
                // Send verification email
                try {
                    $mail->clearAddresses();
                    $mail->addAddress($email);
                    $mail->Subject = 'Your Verification Code';

                    // Get email template from the includes file
                    $emailTemplate = getVerificationEmailTemplate($name, $twofa_code);

                    $mail->Body = $emailTemplate;
                    $mail->AltBody = "Your verification code: $twofa_code\nExpires in 10 minutes";

                    if (!$mail->send()) {
                        $_SESSION["ErrorMessage"] = "Failed to send verification email. Please try again later.";
                    } else {
                        $_SESSION["SuccessMessage"] = "Registration successful! Please verify your email.";
                        header("Location: 2fa.php?email=" . urlencode($email));
                        exit;
                    }
                } catch (Exception $e) {
                    $_SESSION["ErrorMessage"] = "Failed to send verification email. Please try again later.";
                }
            } else {
                $_SESSION["ErrorMessage"] = "Registration failed. Please try again.";
            }
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
    <meta name="description" content="Create your NexusFlow account - Join us today">
    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Sign Up</title>
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
                <div class="col-sm-10 col-md-8 col-lg-5 col-xl-5 col-xxl-3">
                    <a class="d-flex flex-center text-decoration-none mb-4" href="index.php">
                        <div class="d-flex align-items-center fw-bolder fs-3 d-inline-block">
                            <img src="assets/img/icons/logo.png" alt="phoenix" width="58" />
                        </div>
                    </a>
                    <div class="text-center mb-7">
                        <h3 class="text-body-highlight">Sign Up</h3>
                        <p class="text-body-tertiary">Create your account today</p>
                        <!-- session alert message -->
                        <?php
                        echo ErrorMessage();
                        echo SuccessMessage();
                        ?>
                    </div>

                    <!-- Find the Google sign-up button and replace it with this -->
                    <?php
                    require_once 'includes/google_auth.php';
                    $googleAuth = new GoogleAuth($pdo);
                    $authUrl = $googleAuth->getAuthUrl();
                    ?>
                    <a href="<?= htmlspecialchars($authUrl) ?>" class="btn btn-phoenix-secondary w-100 mb-3">
                        <span class="fab fa-google text-danger me-2 fs-9"></span>Sign up with Google
                    </a>
                    <button class="btn btn-phoenix-secondary w-100">
                        <span class="fab fa-facebook text-primary me-2 fs-9"></span>Sign up with facebook
                    </button>

                    <div class="position-relative mt-4">
                        <hr class="bg-body-secondary" />
                        <div class="divider-content-center">or use email</div>
                    </div>

                    <form method="POST" action="sign-up.php">
                        <div class="mb-3 text-start">
                            <label class="form-label" for="name">Name</label>
                            <input class="form-control" id="name" name="name" type="text" placeholder="Name" required />
                        </div>
                        <div class="mb-3 text-start">
                            <label class="form-label" for="email">Email address</label>
                            <input class="form-control" id="email" name="email" type="email"
                                placeholder="name@example.com" required />
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-sm-6">
                                <label class="form-label" for="password">Password</label>
                                <div class="position-relative" data-password="data-password">
                                    <input class="form-control form-icon-input pe-6" id="password" name="password"
                                        type="password" placeholder="Password" data-password-input="data-password-input"
                                        required />
                                    <button
                                        class="btn px-3 py-0 h-100 position-absolute top-0 end-0 fs-7 text-body-tertiary"
                                        data-password-toggle="data-password-toggle" type="button">
                                        <span class="uil uil-eye show"></span>
                                        <span class="uil uil-eye-slash hide"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="confirmPassword">Confirm Password</label>
                                <div class="position-relative" data-password="data-password">
                                    <input class="form-control form-icon-input pe-6" id="confirmPassword"
                                        name="confirmPassword" type="password" placeholder="Confirm Password"
                                        data-password-input="data-password-input" required />
                                    <button
                                        class="btn px-3 py-0 h-100 position-absolute top-0 end-0 fs-7 text-body-tertiary"
                                        data-password-toggle="data-password-toggle" type="button">
                                        <span class="uil uil-eye show"></span>
                                        <span class="uil uil-eye-slash hide"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" id="termsService" name="termsService" type="checkbox"
                                required />
                            <label class="form-label fs-9 text-transform-none" for="termsService">
                                I accept the <a href="terms.php">terms</a> and <a href="#!">privacy policy</a>
                            </label>
                        </div>
                        <button class="btn btn-primary w-100 mb-3" type="submit">Sign up</button>
                        <div class="text-center">
                            <a class="fs-9 fw-bold" href="sign-in.php">Sign in to an existing account</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php include('includes/support-chat.php') ?>
    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->

    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <?php include_once('includes/auth_footer.php') ?>
</body>

</html>