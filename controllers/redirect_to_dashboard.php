<?php
require_once __DIR__ . '/../helpers/auth.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../src/Repository/UserRepository.php';
require_once __DIR__ . '/../src/Service/UserService.php';

require_login();

// appel du service pour obtenir l'URL de redirection vers le tableau de bord
$service = new UserService(new UserRepository($pdo));
$redirectUrl = $service->getDashboardRedirectUrl($_SESSION['role_id']);

header("Location: $redirectUrl");
exit;

