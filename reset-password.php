<?php
require 'includes/db.php';
require 'includes/mailer.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = bin2hex(random_bytes(32));
    $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    $stmt = $pdo->prepare("
        UPDATE users 
        SET reset_token = ?, reset_expires = ?
        WHERE email = ?
    ");

    if ($stmt->execute([$token, $expires, $email])) {
        $resetLink = "https://yourdomain.com/reset-password.php?token=$token";

        $mail->addAddress($email);
        $mail->Subject = 'Password Reset Request';
        $mail->Body = "Reset link: $resetLink";
        $mail->send();

        header("Location: reset-sent.php");
        exit;
    }
}
?>
<?php
require 'includes/db.php';
require 'includes/mailer.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = bin2hex(random_bytes(32));
    $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    $stmt = $pdo->prepare("
        UPDATE users 
        SET reset_token = ?, reset_expires = ?
        WHERE email = ?
    ");

    if ($stmt->execute([$token, $expires, $email])) {
        $resetLink = "https://yourdomain.com/reset-password.php?token=$token";

        $mail->addAddress($email);
        $mail->Subject = 'Password Reset Request';
        $mail->Body = "Reset link: $resetLink";
        $mail->send();

        header("Location: reset-sent.php");
        exit;
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
    <meta name="description" content="Reset your Nexusflow password - Secure password reset process">
    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Password Reset</title>
    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicons/favicon-16x16.png">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicons/favicon.ico">
    <link rel="manifest" href="assets/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">
    <script src="vendors/simplebar/simplebar.min.js"></script>
    <script src="assets/js/config.js"></script>

    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap"
        rel="stylesheet">
    <link href="vendors/simplebar/simplebar.min.css" rel="stylesheet">
    <link rel="stylesheet" href="unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link href="assets/css/theme-rtl.min.css" type="text/css" rel="stylesheet" id="style-rtl">
    <link href="assets/css/theme.min.css" type="text/css" rel="stylesheet" id="style-default">
    <link href="assets/css/user-rtl.min.css" type="text/css" rel="stylesheet" id="user-style-rtl">
    <link href="assets/css/user.min.css" type="text/css" rel="stylesheet" id="user-style-default">
    <?php include('includes/phoenixIsRTL.php') ?>
</head>

<body>
    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
        <div class="container">
            <div class="row flex-center min-vh-100 py-5">
                <div class="col-sm-10 col-md-8 col-lg-5 col-xl-5 col-xxl-3"><a
                        class="d-flex flex-center text-decoration-none mb-4" href="index.html">
                        <div class="d-flex align-items-center fw-bolder fs-3 d-inline-block"><img
                                src="assets/img/icons/logo.png" alt="phoenix" width="58" /></div>
                    </a>
                    <div class="text-center mb-6">
                        <h4 class="text-body-highlight">Reset new password</h4>
                        <p class="text-body-tertiary">Type your new password</p>
                        <form class="mt-5">
                            <div class="position-relative mb-2" data-password="data-password"><input
                                    class="form-control form-icon-input pe-6" id="password" type="password"
                                    placeholder="Type new password" data-password-input="data-password-input" /><button
                                    class="btn px-3 py-0 h-100 position-absolute top-0 end-0 fs-7 text-body-tertiary"
                                    data-password-toggle="data-password-toggle"><span
                                        class="uil uil-eye show"></span><span
                                        class="uil uil-eye-slash hide"></span></button></div>
                            <div class="position-relative mb-4" data-password="data-password"><input
                                    class="form-control form-icon-input pe-6" id="confirmPassword" type="password"
                                    placeholder="Cofirm new password"
                                    data-password-input="data-password-input" /><button
                                    class="btn px-3 py-0 h-100 position-absolute top-0 end-0 fs-7 text-body-tertiary"
                                    data-password-toggle="data-password-toggle"><span
                                        class="uil uil-eye show"></span><span
                                        class="uil uil-eye-slash hide"></span></button></div><button
                                class="btn btn-primary w-100" type="submit">Set Password</button>
                        </form>
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
    <script src="vendors/popper/popper.min.js"></script>
    <script src="vendors/bootstrap/bootstrap.min.js"></script>
    <script src="vendors/anchorjs/anchor.min.js"></script>
    <script src="vendors/is/is.min.js"></script>
    <script src="vendors/fontawesome/all.min.js"></script>
    <script src="vendors/lodash/lodash.min.js"></script>
    <script src="vendors/list.js/list.min.js"></script>
    <script src="vendors/feather-icons/feather.min.js"></script>
    <script src="vendors/dayjs/dayjs.min.js"></script>
    <script src="assets/js/phoenix.js"></script>
</body>

</html>