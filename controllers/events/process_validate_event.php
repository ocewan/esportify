<?php
require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../config/db.php';
require_role(4); // Admin uniquement

$eventId = $_POST['event_id'] ?? null;
$status = isset($_POST['status']) ? (int) $_POST['status'] : null;
$adminId = $_SESSION['user_id'];

if (!$eventId || !in_array($status, [0, 1])) {
    header("Location: /index.php?page=admin&error=Paramètres invalides");
    exit;
}

// insertion dans la table validation
$stmt = $pdo->prepare("INSERT INTO validation (event_id, validated_by, status) VALUES (?, ?, ?)");
$stmt->execute([$eventId, $adminId, $status]);

header("Location: /index.php?page=admin&success=Événement traité");
exit;
