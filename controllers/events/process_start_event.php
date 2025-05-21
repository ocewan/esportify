<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../helpers/auth.php';
require_role(3); // Orga ou admin

$eventId = $_POST['event_id'] ?? null;
if (!$eventId) {
    header('Location: /index.php?page=' . ($_SESSION['role_id'] === 4 ? 'admin' : 'organisateur') . '&error=ID manquant');
    exit;
}

// vérification si l'utilisateur a le droit de démarrer cet event
$stmt = $pdo->prepare("SELECT * FROM event WHERE id = ?");
$stmt->execute([$eventId]);
$event = $stmt->fetch();

if (!$event || ($_SESSION['role_id'] < 4 && $event['created_by'] != $_SESSION['user_id'])) {
    header('Location: /index.php?page=organisateur&error=Accès refusé');
    exit;
}

// mise à jour du statut "started"
$stmt = $pdo->prepare("UPDATE event SET started = 1 WHERE id = ?");
$stmt->execute([$eventId]);

header('Location: /index.php?page=' . ($_SESSION['role_id'] === 4 ? 'admin' : 'organisateur') . '&success=Événement démarré');
exit;
