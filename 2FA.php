<?php
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $code = implode('', $_POST['code']);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && $user['twofa_code'] === $code && strtotime($user['twofa_expires']) > time()) {
        // Update verification status
        $pdo->prepare("UPDATE users SET email_verified = 1, twofa_code = NULL WHERE id = ?")
            ->execute([$user['id']]);

        header("Location: sign-in.php");
        exit;
    } else {
        $error = "Invalid or expired verification code";
    }
}

// Get email from URL parameter
$email = isset($_GET['email']) ? urldecode($_GET['email']) : '';
?>
<!DOCTYPE html>
<html lang="en-US" dir="ltr" data-navigation-type="default" data-navbar-horizontal-shape="default">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Meta Description -->
    <meta name="description"
        content="Two-Factor Authentication - Verify your identity with a 6-digit code sent to your email">
    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Two-Factor Authentication</title>
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
                <div class="col-sm-10 col-md-8 col-lg-5 col-xxl-4"><a
                        class="d-flex flex-center text-decoration-none mb-4" href="index.html">
                        <div class="d-flex align-items-center fw-bolder fs-3 d-inline-block"><img
                                src="assets/img/icons/logo.png" alt="phoenix" width="58" /></div>
                    </a>
                    <div class="px-xxl-5">
                        <div class="text-center mb-6">
                            <h4 class="text-body-highlight">Enter the verification code</h4>
                            <p class="text-body-tertiary mb-0">An email containing a 6-digit verification code has been
                                sent to the email address - exa*********.com </p>
                            <P class="fs-10 mb-5">Don’t have access? <a href="#!">Use another method</a></P>
                            <form method="POST" action="2fa.php" class="verification-form"
                                data-2fa-form="data-2fa-form">
                                <input type="hidden" name="email" value="<?= htmlspecialchars($_GET['email'] ?? '') ?>">
                                <div class="d-flex align-items-center gap-2 mb-3"><input
                                        class="form-control px-2 text-center" type="number" /><input
                                        class="form-control px-2 text-center" type="number" /><input
                                        class="form-control px-2 text-center" type="number" /><span>-</span><input
                                        class="form-control px-2 text-center" type="number" /><input
                                        class="form-control px-2 text-center" type="number" /><input
                                        class="form-control px-2 text-center" type="number" /></div>
                                <div class="form-check text-start mb-4"><input class="form-check-input"
                                        id="2fa-checkbox" type="checkbox" /><label for="2fa-checkbox">Don’t ask again on
                                        this device</label></div><Button class="btn btn-primary w-100 mb-5"
                                    type="submit" disabled="disabled">Verify</Button><a class="fs-9" href="#!">Didn’t
                                    receive the code? </a>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>

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