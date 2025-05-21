<?php
session_start();
require_once __DIR__ . '/../../config/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'], $_POST['event_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing session or event_id']);
    exit;
}

$userId = (int) $_SESSION['user_id'];
$eventId = (int) $_POST['event_id'];

// vérification si favori déjà
$stmt = $pdo->prepare("SELECT 1 FROM favorite_event WHERE user_id = ? AND event_id = ?");
$stmt->execute([$userId, $eventId]);

// si favori, on le supprime, sinon on l'ajoute
if ($stmt->fetch()) {
    $pdo->prepare("DELETE FROM favorite_event WHERE user_id = ? AND event_id = ?")
        ->execute([$userId, $eventId]);
    echo json_encode(['favorited' => false]);
} else {
    $pdo->prepare("INSERT INTO favorite_event (user_id, event_id) VALUES (?, ?)")
        ->execute([$userId, $eventId]);
    echo json_encode(['favorited' => true]);
}
