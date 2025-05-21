<?php
require_once __DIR__ . '/../../config/db.php';

$id = $_GET['id'] ?? null;
if (!$id) exit;

// récupération de l'événement
$stmt = $pdo->prepare("
    SELECT 
        e.*, 
        u.username AS organizer,
        (SELECT COUNT(*) FROM eventparticipant ep WHERE ep.event_id = e.id AND ep.status = 1) AS participant_count
    FROM event e
    JOIN user u ON e.created_by = u.id
    WHERE e.id = ?
    LIMIT 1
");
$stmt->execute([$id]);
$event = $stmt->fetch();

if ($event) {
    include __DIR__ . '/../../views/partials/event/details_popup.php';
}
