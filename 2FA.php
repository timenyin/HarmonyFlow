<?php
require_once 'includes/db.php';
require_once 'includes/session.php';

// Check if this is a password reset flow
$isReset = isset($_GET['reset']) && $_GET['reset'] == '1';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $code_parts = $_POST['code'] ?? [];
    $isResetPost = isset($_POST['is_reset']) && $_POST['is_reset'] == '1';

    // Enhanced validation
    if (empty($email)) {
        $_SESSION["ErrorMessage"] = "Email address is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["ErrorMessage"] = "Invalid email format";
    } elseif (empty($code_parts) || count($code_parts) !== 6) {
        $_SESSION["ErrorMessage"] = "Please enter the complete 6-digit verification code";
    } else {
        $code = implode('', $code_parts);

        if (!preg_match('/^\d{6}$/', $code)) {
            $_SESSION["ErrorMessage"] = "Verification code must be 6 digits";
        } else {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if (!$user) {
                $_SESSION["ErrorMessage"] = "User not found";
            } elseif ($user['twofa_code'] !== $code) {
                $_SESSION["ErrorMessage"] = "Invalid verification code";
            } elseif (strtotime($user['twofa_expires']) <= time()) {
                $_SESSION["ErrorMessage"] = "Verification code has expired. Please start again.";

                // Redirect based on flow
                if ($isResetPost) {
                    header("Location: forgot-password.php");
                } else {
                    header("Location: sign-up.php");
                }
                exit;
            } else {
                if ($isResetPost) {
                    // For password reset flow
                    $_SESSION['reset_email'] = $email;
                    $_SESSION["SuccessMessage"] = "Code verified successfully. Please set your new password.";
                    header("Location: reset-password.php");
                    exit;
                } else {
                    // For regular 2FA flow
                    // Store code in pass_code for future logins
                    $pdo->prepare("UPDATE users SET 
                        email_verified = 1, 
                        pass_code = ?,
                        pass_code_expires = ?,
                        twofa_code = NULL 
                        WHERE id = ?")
                        ->execute([
                            $code,
                            date('Y-m-d H:i:s', strtotime('+30 days')),
                            $user['id']
                        ]);

                    // Set remember device
                    if (isset($_POST['remember_device'])) {
                        $token = bin2hex(random_bytes(32));
                        setcookie('remember_token', $token, time() + 86400 * 30, '/');
                        $pdo->prepare("UPDATE users SET remember_token = ? WHERE id = ?")
                            ->execute([$token, $user['id']]);
                    }

                    // Redirect to sign-in page instead of dashboard
                    $_SESSION["SuccessMessage"] = "Email verified successfully. Please sign in to access your account.";
                    header("Location: sign-in.php");
                    exit;
                }
            }
        }
    }
}

$email = $_GET['email'] ?? '';
$masked_email = preg_replace('/(?<=.).(?=.*@)/', '*', $email);
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
    <title><?= $isReset ? 'Password Reset Verification' : 'Two-Factor Authentication' ?></title>

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
                            <!-- Add this where you want to display messages, after the h4 heading: -->
                            <h4 class="text-body-highlight">Enter the verification code</h4>
                            <!-- session alert message -->
                            <?php
                            echo ErrorMessage();
                            echo SuccessMessage();
                            ?>
                            <p class="text-body-tertiary mb-0">An email containing a 6-digit verification code has been
                                sent to the email address - <?= htmlspecialchars($masked_email) ?> </p>
                            <P class="fs-10 mb-5">Don't have access? <a href="#!">Use another method</a></P>
                            <!-- verification-form -->
                            <form method="POST" action="2fa.php" class="verification-form"
                                data-2fa-form="data-2fa-form">
                                <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
                                <?php if ($isReset): ?>
                                    <input type="hidden" name="is_reset" value="1">
                                <?php endif; ?>
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <?php for ($i = 0; $i < 6; $i++): ?>
                                        <input class="form-control px-2 text-center" name="code[]" type="number" min="0"
                                            max="9" maxlength="1" required autocomplete="off"
                                            oninput="this.value=this.value.slice(0,1)">
                                    <?php endfor; ?>
                                </div>

                                <?php if (isset($error)): ?>
                                    <div class="alert alert-danger"><?= $error ?></div>
                                <?php endif; ?>

                                <div class="form-check text-start mb-4">
                                    <input class="form-check-input" type="checkbox" name="remember_device"
                                        id="2fa-checkbox">
                                    <label for="2fa-checkbox">Don't ask again on this device</label>
                                </div>

                                <button class="btn btn-primary w-100 mb-5" type="submit">Verify</button>

                                <a class="fs-9" href="#!">
                                    Code will expire in the next <span class="text-warning countdown">10:00</span>
                                </a>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once('includes/support-chat.php') ?>
    </main><!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->


    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->

    <?php include('includes/auth_footer.php') ?>

    <?php include('includes/custome_javascript.php') ?>
</body>

</html>