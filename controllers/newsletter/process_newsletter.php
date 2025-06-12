<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../src/Repository/NewsletterRepository.php';
require_once __DIR__ . '/../../src/Service/NewsletterService.php';

session_start();

$email = trim($_POST['email'] ?? '');

// appel du service pour s'abonner à la newsletter
$service = new NewsletterService(new NewsletterRepository($pdo));
$result = $service->subscribe($email);

// gestion du résultat de l'abonnement
if ($result === "ok") {
    $_SESSION['newsletter_feedback'] = ['success' => 'Inscription réussie à la newsletter.'];
} else {
    $_SESSION['newsletter_feedback'] = ['error' => $result];
}

header('Location: /index.php#newsletter');
exit;

