<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../src/Entity/Event.php';
require_once __DIR__ . '/../../src/Repository/EventRepository.php';
require_once __DIR__ . '/../../src/Service/EventService.php';

$repo = new EventRepository($pdo);
$service = new EventService($repo);

// vérification de l'authentification
$eventId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$event = $service->getEvent($eventId);

// Si l'événement n'existe pas
if (!$event) {
    echo "Événement introuvable.";
    exit;
}

include __DIR__ . '/../../views/partials/event/details_popup.php';
