<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enabled = isset($_POST['2fa_enabled']) ? 1 : 0;

    $stmt = $pdo->prepare("UPDATE users SET 2fa_enabled = ? WHERE id = ?");
    $stmt->execute([$enabled, $_SESSION['user_id']]);

    $_SESSION["SuccessMessage"] = "Security settings updated successfully!";
    header("Location: security.php");
    exit;
}

$stmt = $pdo->prepare("SELECT 2fa_enabled FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="bi bi-shield-lock me-2"></i>Security Settings</h4>
                    </div>
                    <div class="card-body">
                        <!-- session alert message -->
                        <?php
                        echo ErrorMessage();
                        echo SuccessMessage();
                        ?>

                        <form method="POST">
                            <div class="mb-4">
                                <h5 class="mb-3"><i class="bi bi-two-factor-authentication me-2"></i>Two-Factor
                                    Authentication</h5>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="2faToggle" name="2fa_enabled"
                                        <?= $user['2fa_enabled'] ? 'checked' : '' ?> style="width: 3em; height: 1.5em;">
                                    <label class="form-check-label ms-2" for="2faToggle">
                                        Enable Two-Factor Authentication
                                    </label>
                                </div>
                                <small class="text-muted">Adds an extra layer of security to your account</small>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-save me-2"></i>Save Settings
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>