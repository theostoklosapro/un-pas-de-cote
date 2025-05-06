<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sécurité de base : échapper les entrées
    function clean_input($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    $name = clean_input($_POST["name"] ?? '');
    $firstname = clean_input($_POST["firstname"] ?? '');
    $email = filter_var($_POST["email"] ?? '', FILTER_VALIDATE_EMAIL);
    $phone = clean_input($_POST["phone"] ?? '');
    $message = clean_input($_POST["message"] ?? '');
    $consent = isset($_POST["consent"]);

    if (!$name || !$firstname || !$phone || !$message || !$consent) {
        http_response_code(400);
        echo "Champs obligatoires manquants.";
        exit;
    }

    $to = "christelle@moncoachfamilial.com";
    $subject = "Nouveau message de $firstname $name";
    $body = "Nom : $name\nPrénom : $firstname\nEmail : $email\nTéléphone : $phone\n\nMessage :\n$message";
    $headers = "From: no-reply@moncoachfamilial.com";

    if (mail($to, $subject, $body, $headers)) {
        http_response_code(200);
        echo "Message envoyé";
    } else {
        http_response_code(500);
        echo "Erreur lors de l'envoi";
    }
}
?>
