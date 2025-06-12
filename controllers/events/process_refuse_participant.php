<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../src/Repository/EventRepository.php';
require_once __DIR__ . '/../../src/Repository/EventParticipantRepository.php';
require_once __DIR__ . '/../../src/Service/EventService.php';

require_role(3); // Orga et admin

$participantId = $_POST['participant_id'] ?? null;
$redirectPage = $_SESSION['role_id'] === 4 ? 'admin' : 'organisateur';

// vérification de l'ID du participant
if (!$participantId) {
    header("Location: /index.php?page=refuse_participants&error=ID manquant");
    exit;
}

// vérification de l'entrée de l'utilisateur dans l'événement et appel du service pour refuser le participant
$service = new EventService(new EventRepository($pdo));
$success = $service->refuseParticipant((int) $participantId);

// Choix de la redirection en fonction du succès de l'opération
$type = $success ? 'success' : 'error';
$message = $success ? 'Inscription refusée' : 'Erreur lors du refus';
header("Location: /index.php?page=$redirectPage&$type=" . urlencode($message));
exit;

