<?php
// contact.php - Simple contact form handler

header("Content-Type: text/plain; charset=UTF-8");
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo "Only POST requests are allowed.";
    exit;
}

// Set your email here:
$to = 'responsible@example.com';

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

if (!$name || !$email || !$message || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo "Please fill all fields with a valid email.";
    exit;
}

// Prepare message
$subject = "Contact form message from $name";
$body = "Name: $name\nEmail: $email\nMessage:\n$message\n";
$headers = "From: $email\r\nReply-To: $email\r\n";

// Use mail() or store in database, etc.
if (mail($to, $subject, $body, $headers)) {
    echo "Thank you for contacting us!";
} else {
    http_response_code(500);
    echo "Failed to send. Please try again later.";
}
?>