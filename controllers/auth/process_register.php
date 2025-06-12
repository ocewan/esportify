<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../src/Repository/UserRepository.php';
require_once __DIR__ . '/../../src/Service/UserService.php';

$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// vérification des champs 
$service = new UserService(new UserRepository($pdo));
$result = $service->register($username, $email, $password, $confirm_password);

// redirection selon le résultat de l'enregistrement
if ($result === "ok") {
    header("Location: /index.php?page=login&success=" . urlencode("Compte créé avec succès. Connectez-vous !"));
} else {
    header("Location: /index.php?page=register&error=" . urlencode($result));
}
exit;


