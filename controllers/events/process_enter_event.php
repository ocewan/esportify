<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../helpers/auth.php';
require_login();

// vérification du rôle
if ($_SESSION['role_id'] < 2) {
    header('Location: /index.php?page=accueil&error=Accès non autorisé');
    exit;
}

$eventId = $_POST['event_id'] ?? null;
$userId = $_SESSION['user_id'];
$role = $_SESSION['role_id'];
$page = match ($role) {
    2 => 'joueur',
    3 => 'organisateur',
    4 => 'admin',
    default => 'accueil'
};

// vérification de l'ID de l'événements
if (!$eventId) {
    header("Location: /index.php?page=$page&error=ID manquant");
    exit;
}

// vérification si inscrit
$stmt = $pdo->prepare("SELECT * FROM eventparticipant WHERE event_id = ? AND user_id = ? AND status = 1");
$stmt->execute([$eventId, $userId]);
$participant = $stmt->fetch();

if (!$participant) {
    header("Location: /index.php?page=$page&error=Accès refusé à cet événement");
    exit;
}

// Vérifie que l’event a commencé
$stmt = $pdo->prepare("SELECT * FROM event WHERE id = ? AND started = 1");
$stmt->execute([$eventId]);
$event = $stmt->fetch();

if (!$event) {
    header("Location: /index.php?page=$page&error=Événement non démarré");
    exit;
}

header("Location: /index.php?page=event&id=$eventId");
exit;
