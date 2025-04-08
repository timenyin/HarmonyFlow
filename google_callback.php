<?php
require_once 'includes/db.php';
require_once 'includes/session.php';
require_once 'includes/google_auth.php';
require_once 'includes/google_mailer.php';

// Initialize Google Auth handler
$googleAuth = new GoogleAuth($pdo);

// Check for authorization code
if (isset($_GET['code'])) {
    // Process the callback
    $result = $googleAuth->handleCallback($_GET['code']);
    
    if ($result['success']) {
        // Set session variables
        session_regenerate_id(true);
        $_SESSION['user_id'] = $result['user_id'];
        $_SESSION['role'] = $result['role'];
        
        // Send welcome email if this is a new user
        if ($result['is_new']) {
            try {
                sendGoogleWelcomeEmail($result['email'], $result['name']);
                $_SESSION["SuccessMessage"] = "Welcome to NexusFlow! We've sent you a welcome email.";
            } catch (Exception $e) {
                error_log("Failed to send welcome email: " . $e->getMessage());
                $_SESSION["SuccessMessage"] = "Welcome to NexusFlow!";
            }
        } else {
            $_SESSION["SuccessMessage"] = "Welcome back to NexusFlow!";
        }
        
        // Redirect to dashboard
        header("Location: dashboard.php");
        exit;
    } else {
        // Authentication failed
        $_SESSION["ErrorMessage"] = $result['message'] ?? "Authentication failed. Please try again.";
        header("Location: sign-in.php");
        exit;
    }
} else {
    // No authorization code provided
    $_SESSION["ErrorMessage"] = "Invalid request. Please try again.";
    header("Location: sign-in.php");
    exit;
}