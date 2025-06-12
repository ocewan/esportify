<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../src/Repository/EventRepository.php';
require_once __DIR__ . '/../../src/Service/EventService.php';

require_role(3); // Orga ou admin

$eventId = $_POST['event_id'] ?? null;
$userId = $_SESSION['user_id'];
$roleId = $_SESSION['role_id'];
$page = $roleId === 4 ? 'admin' : 'organisateur';

// vérification de l'ID de l'événement
if (!$eventId) {
    header("Location: /index.php?page=$page&error=ID manquant");
    exit;
}

// vérification que l'événement n'est pas déjà démarré et appel du service pour démarrer l'événement
$service = new EventService(new EventRepository($pdo));
$result = $service->startEvent((int)$eventId, $userId, $roleId);

$type = $result === "Événement démarré" ? "success" : "error";
header("Location: /index.php?page=$page&$type=" . urlencode($result));
exit;
