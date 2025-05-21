<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../helpers/auth.php';
require_role(3); // Orga et admin

$participantId = $_POST['participant_id'] ?? null;

if (!$participantId) {
    header('Location: /index.php?page=refuse_participants&error=ID manquant');
    exit;
}

// vérification si l'utilisateur a le droit de refuser un participant
$stmt = $pdo->prepare("UPDATE eventparticipant SET status = -1 WHERE id = ?");
$stmt->execute([$participantId]);

$redirectPage = $_SESSION['role_id'] === 4 ? 'admin' : 'organisateur';
header("Location: /index.php?page=$redirectPage&success=Inscription refusée");
exit;
