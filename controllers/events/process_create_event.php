<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../src/Entity/Event.php';
require_once __DIR__ . '/../../src/Repository/EventRepository.php';
require_once __DIR__ . '/../../src/Service/EventService.php';
require_once __DIR__ . '/../../helpers/auth.php';

require_role(3); // Organisateur ou Admin

// Vérification champs requis
if (empty($_POST['title']) || empty($_POST['description']) || empty($_POST['date_event']) || empty($_POST['date_end'])) {
    header("Location: /index.php?page=create_event&error=Champs requis manquants");
    exit;
}

$repo = new EventRepository($pdo);
$service = new EventService($repo);
$success = $service->createEvent($_POST, $_SESSION['user_id']);

// redirection selon le rôle
$redirectPage = $_SESSION['role_id'] === 4 ? 'admin' : 'organisateur';

// Si l'événement est créé avec succès, on redirige vers la page appropriée
if ($success) {
    header("Location: /index.php?page=$redirectPage&success=Événement créé, en attente de validation");
} else {
    header("Location: /index.php?page=create_event&error=Erreur lors de la création");
}
exit;

