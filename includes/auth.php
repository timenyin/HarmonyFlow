<?php
require_once __DIR__ . '/session.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../sign-in.php");
    exit;
}

function isAdmin()
{
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}
