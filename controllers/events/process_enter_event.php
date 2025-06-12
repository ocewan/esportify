<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../src/Repository/EventRepository.php';
require_once __DIR__ . '/../../src/Repository/EventParticipantRepository.php';
require_once __DIR__ . '/../../src/Service/EventService.php';

require_login();

// Vérification du rôle de l'utilisateur
$eventId = $_POST['event_id'] ?? null;
$userId = $_SESSION['user_id'];
$role = $_SESSION['role_id'];
$page = match ($role) {
    2 => 'joueur',
    3 => 'organisateur',
    4 => 'admin',
    default => 'accueil'
};

// vérification de l'ID de l'événement
if (!$eventId) {
    header("Location: /index.php?page=$page&error=ID manquant");
    exit;
}

// vérification de l'entrée de l'utilisateur dans l'événement
$service = new EventService(new EventRepository($pdo));
$canEnter = $service->canUserEnterEvent((int)$eventId, $userId);

// si l'utilisateur ne peut pas entrer dans l'événement, redirection avec message d'erreur
if ($canEnter !== "ok") {
    header("Location: /index.php?page=$page&error=" . urlencode($canEnter));
    exit;
}

header("Location: /index.php?page=event&id=$eventId");
exit;

