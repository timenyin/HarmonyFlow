<?php
require 'includes/db.php';
require 'includes/session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';

    // Enhanced validation
    if (empty($email) || empty($password)) {
        $_SESSION["ErrorMessage"] = "All fields must be filled out";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["ErrorMessage"] = "Please enter a valid email address";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            if (!$user['email_verified']) {
                $_SESSION["ErrorMessage"] = "Please verify your email first";
            } else {
                // Check remember token
                if (isset($_COOKIE['remember_token']) && $user['remember_token'] === $_COOKIE['remember_token']) {
                    // Check if pass_code is valid
                    if ($user['pass_code'] && strtotime($user['pass_code_expires']) > time()) {
                        session_regenerate_id(true);
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['role'] = $user['role'];
                        $_SESSION["SuccessMessage"] = "Welcome back!";
                        header("Location: dashboard.php");
                        exit;
                    }
                }

                // Only require 2FA if enabled
                if ($user['2fa_enabled']) {
                    $_SESSION['temp_user'] = $user['id'];
                    header("Location: 2fa.php?email=" . urlencode($email));
                    exit;
                } else {
                    // Direct login if 2FA disabled
                    session_regenerate_id(true);
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION["SuccessMessage"] = "Login successful!";
                    header("Location: dashboard.php");
                    exit;
                }
            }
        } else {
            $_SESSION["ErrorMessage"] = "Invalid email or password";
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
    <meta name="description" content="Sign in to your Nexusflow account - Access your dashboard">
    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Sign In</title>
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
                <div class="col-sm-10 col-md-8 col-lg-5 col-xl-5 col-xxl-3"><a
                        class="d-flex flex-center text-decoration-none mb-4" href="index.php">
                        <div class="d-flex align-items-center fw-bolder fs-3 d-inline-block"><img
                                src="assets/img/icons/logo.png" alt="phoenix" width="58" /></div>
                    </a>
                    <div class="text-center mb-7">
                        <h3 class="text-body-highlight">Sign In</h3>
                        <p class="text-body-tertiary">Get access to your account</p>
                        <!-- session alert message -->
                        <?php
                        echo ErrorMessage();
                        echo SuccessMessage();
                        ?>
                        <?php if (isset($user) && !empty($user['name'])): ?>
                            <p>Welcome, <?= htmlspecialchars($user['name']) ?></p>
                        <?php endif; ?>
                    </div>
                    <!-- Find the Google sign-in button and replace it with this -->
                    <?php
                    require_once 'includes/google_auth.php';
                    $googleAuth = new GoogleAuth($pdo);
                    $authUrl = $googleAuth->getAuthUrl();
                    ?>
                    <a href="<?= htmlspecialchars($authUrl) ?>" class="btn btn-phoenix-secondary w-100 mb-3">
                        <span class="fab fa-google text-danger me-2 fs-9"></span>Sign in with Google
                    </a>
                    <button
                        class="btn btn-phoenix-secondary w-100"><span
                            class="fab fa-facebook text-primary me-2 fs-9"></span>Sign in with facebook</button>
                    <div class="position-relative">
                        <hr class="bg-body-secondary mt-5 mb-4" />
                        <div class="divider-content-center">or use email</div>
                    </div>
                    <form method="POST" action="sign-in.php">
                        <div class="mb-3 text-start">
                            <label class="form-label" for="email">Email address</label>
                            <div class="form-icon-container">
                                <input class="form-control form-icon-input" id="email" name="email" type="email"
                                    placeholder="" required />
                                <span class="fas fa-user text-body fs-9 form-icon"></span>
                            </div>
                        </div>

                        <div class="mb-3 text-start">
                            <label class="form-label" for="password">Password</label>
                            <div class="form-icon-container" data-password="data-password">
                                <input class="form-control form-icon-input pe-6" id="password" name="password"
                                    type="password" placeholder="Password" data-password-input="data-password-input"
                                    required />
                                <span class="fas fa-key text-body fs-9 form-icon"></span>
                                <button type="button"
                                    class="btn px-3 py-0 h-100 position-absolute top-0 end-0 fs-7 text-body-tertiary"
                                    data-password-toggle="data-password-toggle">
                                    <span class="uil uil-eye show"></span>
                                    <span class="uil uil-eye-slash hide"></span>
                                </button>
                            </div>
                        </div>

                        <div class="row flex-between-center mb-7">
                            <div class="col-auto">
                                <div class="form-check mb-0">
                                    <input class="form-check-input" id="basic-checkbox" name="remember_me"
                                        type="checkbox" />
                                    <label class="form-check-label mb-0" for="basic-checkbox">
                                        Remember me
                                    </label>
                                </div>
                            </div>
                            <div class="col-auto">
                                <a class="fs-9 fw-semibold" href="forgot-password.php">Forgot Password?</a>
                            </div>
                        </div>

                        <button class="btn btn-primary w-100 mb-3" type="submit">Sign In</button>
                    </form>

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
    <?php include_once('includes/auth_footer.php') ?>
</body>

</html>