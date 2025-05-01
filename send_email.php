<?php
// Prevent direct script access
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(403);
    exit("Accès non autorisé");
}

// Sanitize and validate input
function sanitizeInput($input) {
    $input = trim($input);
    $input = strip_tags($input);
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    return $input;
}

// Validate email if provided
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// Collect and sanitize form data
$name = sanitizeInput($_POST['name'] ?? '');
$firstname = sanitizeInput($_POST['firstname'] ?? '');
$email = sanitizeInput($_POST['email'] ?? '');
$phone = sanitizeInput($_POST['phone'] ?? '');
$message = sanitizeInput($_POST['message'] ?? '');

// Validate required fields
if (empty($name) || empty($firstname) || empty($phone)) {
    http_response_code(400);
    exit("Champs obligatoires manquants");
}

// Optional email validation
if (!empty($email) && !validateEmail($email)) {
    http_response_code(400);
    exit("Format d'email invalide");
}

// CSRF Protection
session_start();
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    http_response_code(403);
    exit("Jeton de sécurité invalide");
}

// Recipient email
$to = 'cabinetcoaching4010lux@gmail.com';

// Subject
$subject = "Message coaching de " . $name . " " . $firstname;

// Email body
$email_body = "Téléphone: " . $phone . "\n";
if (!empty($email)) {
    $email_body .= "Email: " . $email . "\n\n";
}
$email_body .= "Message:\n" . $message;

// Additional headers for security
$headers = "From: webform@unpasdecote.com\r\n";
$headers .= "Reply-To: " . ($email ?: 'noreply@unpasdecote.com') . "\r\n";
$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Attempt to send email
try {
    $success = mail($to, $subject, $email_body, $headers);
    
    if ($success) {
        // Log successful submission (recommended)
        error_log("Form submission successful from: " . $name . " " . $firstname);
        header("Location: index.html?status=success");
    } else {
        // Log email sending failure
        error_log("Email sending failed for: " . $name . " " . $firstname);
        header("Location: index.html?status=error");
    }
} catch (Exception $e) {
    // Log any unexpected errors
    error_log("Unexpected error: " . $e->getMessage());
    header("Location: index.html?status=error");
}
exit();
?>