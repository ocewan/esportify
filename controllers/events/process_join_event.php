<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../src/Entity/EventParticipant.php';
require_once __DIR__ . '/../../src/Repository/EventRepository.php';
require_once __DIR__ . '/../../src/Repository/EventParticipantRepository.php';
require_once __DIR__ . '/../../src/Service/EventService.php';
require_once __DIR__ . '/../../helpers/auth.php';

require_login();

// vérification du rôle de l'utilisateur
$userId = $_SESSION['user_id'] ?? null;
$role = $_SESSION['role_id'] ?? null;
$eventId = $_POST['event_id'] ?? null;

// fonction pour rediriger vers la page appropriée selon le rôle
function redirectToRolePage($role, $type, $message) {
    $page = match ($role) {
        2 => 'joueur',
        3 => 'organisateur',
        4 => 'admin',
        default => 'home'
    };
    header("Location: /index.php?page=$page&$type=" . urlencode($message));
    exit;
}

// vérification des paramètres requis
if (!$userId || !$eventId) {
    redirectToRolePage($role, 'error', 'Paramètres manquants');
}

$eventId = (int) $eventId;

// création du service et appel de la méthode pour rejoindre l'événement
$service = new EventService(new EventRepository($pdo));
$resultMessage = $service->joinEvent($eventId, $userId);

// si le message contient "Inscription réussie", c’est un succès
if (str_starts_with($resultMessage, 'Inscription')) {
    redirectToRolePage($role, 'success', $resultMessage);
} else {
    redirectToRolePage($role, 'error', $resultMessage);
}

