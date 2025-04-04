<?php
require 'db.php';

// Verify Clerk webhook signature first
$clerk_secret = 'YOUR_CLERK_WEBHOOK_SECRET';

$payload = file_get_contents('php://input');
$signature = $_SERVER['HTTP_SVIX_SIGNATURE'];

if (!verify_signature($payload, $signature, $clerk_secret)) {
    http_response_code(401);
    exit('Invalid signature');
}

$event = json_decode($payload, true);

if ($event['type'] === 'user.created' || $event['type'] === 'user.updated') {
    $user = $event['data'];

    $stmt = $pdo->prepare("
        INSERT INTO users (clerk_user_id, email, name, email_verified, created_at)
        VALUES (:clerk_id, :email, :name, :verified, NOW())
        ON DUPLICATE KEY UPDATE 
        email = VALUES(email),
        name = VALUES(name),
        email_verified = VALUES(email_verified)
    ");

    $stmt->execute([
        ':clerk_id' => $user['id'],
        ':email'    => $user['primary_email_address_id'],
        ':name'     => $user['first_name'] . ' ' . $user['last_name'],
        ':verified' => $user['email_addresses'][0]['verification']['status'] === 'verified' ? 1 : 0
    ]);
}

function verify_signature($payload, $signature, $secret)
{
    $expected = hash_hmac('sha256', $payload, $secret);
    return hash_equals($expected, $signature);
}
