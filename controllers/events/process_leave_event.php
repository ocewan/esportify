<?php
require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../config/db.php';
require_role(2); // Joueur, Orga, Admin

$userId = $_SESSION['user_id'] ?? null;
$role = $_SESSION['role_id'] ?? null;
$eventId = $_POST['event_id'] ?? null;

// redirection selon le rôle
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


if (!$userId || !$eventId) {
    redirectToRolePage($role, 'error', 'Paramètres manquants');
    exit;
}

// vérification si l'événement n'a pas encore commencé
$stmt = $pdo->prepare("SELECT date_event FROM event WHERE id = ?");
$stmt->execute([$eventId]);
$event = $stmt->fetch();

if (!$event || strtotime($event['date_event']) <= time()) {
    redirectToRolePage($role, 'error', 'Impossible de se désinscrire d\'un événement déjà commencé');
    exit;
}

// suppression de l'inscription de l'utilisateur
$stmt = $pdo->prepare("DELETE FROM eventparticipant WHERE event_id = ? AND user_id = ?");
$stmt->execute([$eventId, $userId]);

redirectToRolePage($role, 'success', 'Vous avez été désinscrit de l\'événement');
exit;
