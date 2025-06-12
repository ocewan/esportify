<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../src/Repository/EventRepository.php';
require_once __DIR__ . '/../../src/Repository/EventParticipantRepository.php';
require_once __DIR__ . '/../../src/Service/EventService.php';

require_role(2); // Joueur, Orga, Admin

$userId = $_SESSION['user_id'] ?? null;
$role = $_SESSION['role_id'] ?? null;
$eventId = $_POST['event_id'] ?? null;

// fonction pour rediriger vers la page appropriée selon le rôle
function redirectToRolePage($role, $type = 'success', $message = '')
{
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

// appel du service pour quitter l'événement
$service = new EventService(new EventRepository($pdo));
$result = $service->leaveEvent((int)$eventId, $userId);

// Choix type de redirection
$type = str_starts_with($result, "Vous avez été") ? 'success' : 'error';
redirectToRolePage($role, $type, $result);
