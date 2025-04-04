<?php
session_start();
require 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: sign-in.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if (!$user) {
    session_destroy();
    header("Location: sign-in.php");
    exit;
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
    <meta name="description" content="Sign in to your Nexusflow account - Access your dashboard">
    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Sign In</title>
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
                        class="d-flex flex-center text-decoration-none mb-4" href="index.php">
                        <div class="d-flex align-items-center fw-bolder fs-3 d-inline-block"><img
                                src="assets/img/icons/logo.png" alt="phoenix" width="58" /></div>
                    </a>
                    <div class="text-center mb-7">
                        <h3 class="text-body-highlight">Sign In</h3>
                        <p class="text-body-tertiary">Get access to your account</p>
                        <p>Welcome, <?= htmlspecialchars($user['name']) ?></p>
                    </div><button class="btn btn-phoenix-secondary w-100 mb-3"><span
                            class="fab fa-google text-danger me-2 fs-9"></span>Sign in with google</button><button
                        class="btn btn-phoenix-secondary w-100"><span
                            class="fab fa-facebook text-primary me-2 fs-9"></span>Sign in with facebook</button>
                    <div class="position-relative">
                        <hr class="bg-body-secondary mt-5 mb-4" />
                        <div class="divider-content-center">or use email</div>
                    </div>
                    <div class="mb-3 text-start"><label class="form-label" for="email">Email address</label>
                        <div class="form-icon-container"><input class="form-control form-icon-input" id="email"
                                type="email" placeholder="name@example.com" /><span
                                class="fas fa-user text-body fs-9 form-icon"></span></div>
                    </div>
                    <div class="mb-3 text-start"><label class="form-label" for="password">Password</label>
                        <div class="form-icon-container" data-password="data-password"><input
                                class="form-control form-icon-input pe-6" id="password" type="password"
                                placeholder="Password" data-password-input="data-password-input" /><span
                                class="fas fa-key text-body fs-9 form-icon"></span><button
                                class="btn px-3 py-0 h-100 position-absolute top-0 end-0 fs-7 text-body-tertiary"
                                data-password-toggle="data-password-toggle"><span class="uil uil-eye show"></span><span
                                    class="uil uil-eye-slash hide"></span></button></div>
                    </div>
                    <div class="row flex-between-center mb-7">
                        <div class="col-auto">
                            <div class="form-check mb-0"><input class="form-check-input" id="basic-checkbox"
                                    type="checkbox" checked="checked" /><label class="form-check-label mb-0"
                                    for="basic-checkbox">Remember me</label></div>
                        </div>
                        <div class="col-auto"><a class="fs-9 fw-semibold" href="forgot-password.php">Forgot
                                Password?</a></div>
                    </div><button class="btn btn-primary w-100 mb-3">Sign In</button>
                    <div class="text-center"><a class="fs-9 fw-bold" href="sign-up.php">Create an account</a></div>
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