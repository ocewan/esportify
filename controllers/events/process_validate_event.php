<?php
require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../src/Repository/EventRepository.php';
require_once __DIR__ . '/../../src/Repository/ValidationRepository.php';
require_once __DIR__ . '/../../src/Service/EventService.php';

require_role(4); // Admin uniquement

$eventId = $_POST['event_id'] ?? null;
$status = isset($_POST['status']) ? (int) $_POST['status'] : null;
$adminId = $_SESSION['user_id'];

if (!$eventId || !in_array($status, [0, 1])) {
    header("Location: /index.php?page=admin&error=Paramètres invalides");
    exit;
}

// verification de l'ID de l'événement et appel du service pour valider l'événement
$service = new EventService(new EventRepository($pdo));
$success = $service->validateEvent((int) $eventId, $adminId, $status);

// Redirection selon le succès de l'opération
if ($success) {
    header("Location: /index.php?page=admin&success=Événement traité");
} else {
    header("Location: /index.php?page=admin&error=Erreur lors de la validation");
}
exit;

