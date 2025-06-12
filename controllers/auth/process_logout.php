<?php
require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../config/db.php'; // pas obligatoire ici, mais cohérent
require_once __DIR__ . '/../../src/Repository/UserRepository.php';
require_once __DIR__ . '/../../src/Service/UserService.php';

// vérification de la session
$service = new UserService(new UserRepository($pdo));
$service->logout();

header("Location: /index.php");
exit;

