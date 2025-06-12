<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../src/Entity/Event.php';
require_once __DIR__ . '/../../src/Repository/EventRepository.php';
require_once __DIR__ . '/../../src/Service/EventService.php';
require_once __DIR__ . '/../../helpers/auth.php';

require_role(3); // organisateur ou admin

// Vérifie les champs
if (empty($_POST['id']) || empty($_POST['title']) || empty($_POST['description']) || empty($_POST['date_event']) || empty($_POST['date_end'])) {
    header("Location: /index.php?page=edit_event&id=" . ($_POST['id'] ?? 0) . "&error=Champs requis manquants");
    exit;
}

$repo = new EventRepository($pdo);
$service = new EventService($repo);

// modification de l'événement
$success = $service->updateEvent($_POST, $_SESSION['user_id']);

// Redirection selon le rôle
$redirectPage = $_SESSION['role_id'] === 4 ? 'admin' : 'organisateur';

// Si l'événement est modifié avec succès, on redirige vers la page appropriée
if ($success) {
    header("Location: /index.php?page=$redirectPage&success=Événement modifié");
} else {
    header("Location: /index.php?page=edit_event&id=" . $_POST['id'] . "&error=Erreur lors de la modification");
}
exit;

