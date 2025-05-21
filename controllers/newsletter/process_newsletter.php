<?php
require_once __DIR__ . '/../../config/db.php';

session_start();

// récuperation et nettoyage de l’email
$email = trim($_POST['email'] ?? '');

// validation de l’email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['newsletter_feedback'] = ['error' => 'Email invalide'];
    header('Location: /index.php#newsletter');
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO newsletter (email) VALUES (:email)");
    $stmt->execute(['email' => $email]);

    $_SESSION['newsletter_feedback'] = ['success' => 'Inscription réussie à la newsletter.'];
    header('Location: /index.php#newsletter');
    exit;
} catch (PDOException $e) {
    // gère erreur
    if ($e->getCode() === '23000') {
        $_SESSION['newsletter_feedback'] = ['error' => 'Cet email est déjà inscrit.'];
    } else {
        error_log("Newsletter error: " . $e->getMessage()); // journal d’erreur
        $_SESSION['newsletter_feedback'] = ['error' => 'Une erreur technique est survenue.'];
    }

    header('Location: /index.php#newsletter');
    exit;
}
