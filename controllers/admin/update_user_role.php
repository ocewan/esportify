<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../src/Repository/UserRepository.php';
require_once __DIR__ . '/../../src/Service/UserService.php';

require_role(4); // admin uniquement

$userId = $_POST['user_id'] ?? null;
$newRole = $_POST['new_role'] ?? null;

// vérification des paramètres
if (!$userId || !$newRole) {
    header("Location: /index.php?page=admin&error=" . urlencode("Paramètres manquants"));
    exit;
}

// vérification du rôle
$service = new UserService(new UserRepository($pdo));
$success = $service->changeUserRole((int) $userId, (int) $newRole);

// redirection selon le succès de l'opération
if ($success) {
    header("Location: /index.php?page=admin&success=" . urlencode("Rôle mis à jour"));
} else {
    header("Location: /index.php?page=admin&error=" . urlencode("Erreur lors de la mise à jour"));
}
exit;
