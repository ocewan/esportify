<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../src/Repository/UserRepository.php';
require_once __DIR__ . '/../../src/Service/UserService.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// vérification des champs obligatoires
if (empty($username) || empty($password)) {
    header("Location: /index.php?page=login&error=" . urlencode("Champs obligatoires manquants"));
    exit;
}

// vérification des identifiants
$service = new UserService(new UserRepository($pdo));
$user = $service->authenticate($username, $password);

// si l'utilisateur est trouvé, on initialise la session
if ($user) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role_id'] = $user['role_id'];
    header("Location: /index.php?page=home");
    exit;
}

header("Location: /index.php?page=login&error=" . urlencode("Identifiants invalides"));
exit;

