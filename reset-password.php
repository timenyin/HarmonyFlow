<?php
require_once 'includes/db.php';
require_once 'includes/session.php';

// Check if user is authorized to reset password
if (!isset($_SESSION['reset_email'])) {
    $_SESSION["ErrorMessage"] = "Unauthorized access. Please request a password reset first.";
    header("Location: forgot-password.php");
    exit;
}

$email = $_SESSION['reset_email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Enhanced validation
    if (empty($password) || empty($confirm_password)) {
        $_SESSION["ErrorMessage"] = "All fields must be filled out";
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
        // Update password
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET 
            password_hash = ?, 
            twofa_code = NULL, 
            twofa_expires = NULL 
            WHERE email = ?");

        if ($stmt->execute([$hash, $email])) {
            // Clear session data
            unset($_SESSION['reset_email']);

            $_SESSION["SuccessMessage"] = "Password has been reset successfully. You can now login with your new password.";
            header("Location: sign-in.php");
            exit;
        } else {
            $_SESSION["ErrorMessage"] = "Failed to reset password. Please try again.";
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
    <meta name="description" content="Reset your password - Secure password reset process">
    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Password Reset</title>
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
                <div class="col-sm-10 col-md-8 col-lg-5 col-xl-5 col-xxl-4">
                    <a class="d-flex flex-center text-decoration-none mb-4" href="index.php">
                        <div class="d-flex align-items-center fw-bolder fs-3 d-inline-block">
                            <img src="assets/img/icons/logo.png" alt="phoenix" width="58" />
                        </div>
                    </a>
                    <div class="text-center mb-6">
                        <h4 class="text-body-highlight">Reset Your Password</h4>
                        <p class="text-body-tertiary">Create a new strong password for your account</p>
                        <?php echo ErrorMessage(); ?>
                        <?php echo SuccessMessage(); ?>
                    </div>
                    <div class="card shadow-none">
                        <div class="card-body p-4">
                            <form method="POST" action="" class="mt-5">
                                <div class="position-relative mb-2" data-password="data-password">
                                    <input class="form-control form-icon-input pe-6" id="password" type="password"
                                        name="password" placeholder="Type new password"
                                        data-password-input="data-password-input" required />
                                    <button
                                        class="btn px-3 py-0 h-100 position-absolute top-0 end-0 fs-7 text-body-tertiary"
                                        type="button" data-password-toggle="data-password-toggle">
                                        <span class="uil uil-eye show"></span>
                                        <span class="uil uil-eye-slash hide"></span>
                                    </button>
                                </div>
                                <div class="position-relative mb-4" data-password="data-password">
                                    <input class="form-control form-icon-input pe-6" id="confirmPassword"
                                        type="password" name="confirm_password" placeholder="Confirm new password"
                                        data-password-input="data-password-input" required />
                                    <button
                                        class="btn px-3 py-0 h-100 position-absolute top-0 end-0 fs-7 text-body-tertiary"
                                        type="button" data-password-toggle="data-password-toggle">
                                        <span class="uil uil-eye show"></span>
                                        <span class="uil uil-eye-slash hide"></span>
                                    </button>
                                </div>
                                <div class="fs-9 mt-2 mb-4">
                                    <ul class="ps-3 mb-0">
                                        <li>Must be at least 8 characters</li>
                                        <li>Must contain at least one uppercase letter</li>
                                        <li>Must contain at least one lowercase letter</li>
                                        <li>Must contain at least one number</li>
                                        <li>Must contain at least one special character</li>
                                    </ul>
                                </div>
                                <button class="btn btn-primary w-100 mb-3" type="submit">Set Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once('includes/support-chat.php') ?>
    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->

    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <?php include_once('includes/auth_footer.php') ?>

    <?php include_once('includes/custome_javascript.php') ?>


</body>

</html>