<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../helpers/auth.php';

require_login();

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
}

// vérification si l'événement est validé
$stmt = $pdo->prepare("SELECT 1 FROM validation WHERE event_id = ? AND status = 1");
$stmt->execute([$eventId]);
if (!$stmt->fetch()) {
    redirectToRolePage($role, 'error', 'Événement non validé');
}

// vérification si le joueur est déjà inscrit/refusé
$stmt = $pdo->prepare("SELECT status FROM eventparticipant WHERE event_id = ? AND user_id = ?");
$stmt->execute([$eventId, $userId]);
$existing = $stmt->fetch();

if ($existing) {
    $status = (int)$existing['status'];

    if ($status === -1) {
        redirectToRolePage($role, 'error', 'Inscription refusée pour cet événement');
    } elseif ($status === 1) {
        redirectToRolePage($role, 'error', 'Déjà inscrit à cet événement');
    } elseif ($status === 0) {
        // mise à jour du statut à inscrit
        $update = $pdo->prepare("UPDATE eventparticipant SET status = 1 WHERE event_id = ? AND user_id = ?");
        $update->execute([$eventId, $userId]);
        redirectToRolePage($role, 'success', 'Inscription confirmée !');
    } else {
        redirectToRolePage($role, 'error', 'Erreur inconnue d’inscription');
    }
}

// nouvel enregistrement
$insert = $pdo->prepare("INSERT INTO eventparticipant (event_id, user_id, status) VALUES (?, ?, 1)");
$insert->execute([$eventId, $userId]);

redirectToRolePage($role, 'success', 'Inscription réussie !');
