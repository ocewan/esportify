<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../helpers/auth.php';
require_role(4);

$userId = $_POST['user_id'] ?? null;
$newRole = $_POST['new_role'] ?? null;

if ($userId && in_array($newRole, [1, 2, 3, 4])) {
    $stmt = $pdo->prepare("UPDATE user SET role_id = ? WHERE id = ?");
    $stmt->execute([$newRole, $userId]);
    header("Location: /index.php?page=admin&success=" . urlencode("Rôle mis à jour"));
    exit;
}

header("Location: /index.php?page=admin&error=" . urlencode("Erreur lors de la mise à jour"));
exit;
