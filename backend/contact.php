<?php
// contact.php - Secure contact form handler with CSRF protection and input validation

session_start();

header("Content-Type: text/plain; charset=UTF-8");

// Security headers
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("Referrer-Policy: strict-origin-when-cross-origin");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo "Only POST requests are allowed.";
    exit;
}

// CSRF token validation
if (!isset($_POST['csrf_token']) || !isset($_SESSION['csrf_token']) || 
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    http_response_code(403); // Forbidden
    echo "Invalid CSRF token.";
    exit;
}

// Rate limiting (simple implementation)
if (!isset($_SESSION['last_submit_time'])) {
    $_SESSION['last_submit_time'] = 0;
}

$time_since_last_submit = time() - $_SESSION['last_submit_time'];
if ($time_since_last_submit < 60) { // 60 second cooldown
    http_response_code(429); // Too Many Requests
    echo "Please wait before submitting again.";
    exit;
}

// Set your email here:
$to = 'responsible@example.com';

// Input validation and sanitization functions
function sanitize_string($input, $max_length = 1000) {
    $input = trim($input);
    $input = substr($input, 0, $max_length);
    return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
}

function validate_email($email) {
    $email = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    // Additional validation for common email injection patterns
    $dangerous_patterns = ['\r', '\n', '%0a', '%0d', 'content-type:', 'bcc:', 'cc:'];
    foreach ($dangerous_patterns as $pattern) {
        if (stripos($email, $pattern) !== false) {
            return false;
        }
    }
    return $email;
}

// Validate and sanitize inputs
$name = sanitize_string($_POST['name'] ?? '', 100);
$email = validate_email($_POST['email'] ?? '');
$message = sanitize_string($_POST['message'] ?? '', 2000);

// Comprehensive validation
$errors = [];
if (empty($name)) {
    $errors[] = "Name is required.";
} elseif (strlen($name) < 2 || strlen($name) > 100) {
    $errors[] = "Name must be between 2 and 100 characters.";
}

if (!$email) {
    $errors[] = "Valid email is required.";
}

if (empty($message)) {
    $errors[] = "Message is required.";
} elseif (strlen($message) < 10 || strlen($message) > 2000) {
    $errors[] = "Message must be between 10 and 2000 characters.";
}

if (!empty($errors)) {
    http_response_code(400);
    echo implode(" ", $errors);
    exit;
}

// Prepare secure email
$subject = "Contact form message from " . $name;
$body = "Name: " . $name . "\n";
$body .= "Email: " . $email . "\n";
$body .= "IP Address: " . $_SERVER['REMOTE_ADDR'] . "\n";
$body .= "User Agent: " . substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 200) . "\n";
$body .= "Message:\n" . $message . "\n";

// Secure headers to prevent injection
$headers = "From: " . $email . "\r\n";
$headers .= "Reply-To: " . $email . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

// Update rate limiting
$_SESSION['last_submit_time'] = time();

// Send email with error handling
try {
    if (mail($to, $subject, $body, $headers)) {
        // Clear CSRF token after successful submission
        unset($_SESSION['csrf_token']);
        echo "Thank you for contacting us! Your message has been sent successfully.";
    } else {
        error_log("Mail function failed for contact form submission");
        http_response_code(500);
        echo "Failed to send message. Please try again later.";
    }
} catch (Exception $e) {
    error_log("Contact form exception: " . $e->getMessage());
    http_response_code(500);
    echo "An error occurred. Please try again later.";
}
?>