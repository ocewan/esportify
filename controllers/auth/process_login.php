<?php
require_once __DIR__ . '/../../config/db.php';
session_start();

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// vérification des champs remplis ou non
if (empty($username) || empty($password)) {
    header("Location: /index.php?page=login&error=" . urlencode("Champs obligatoires manquants"));
    exit;
}

// récupération de l'utilisateur
$stmt = $pdo->prepare("SELECT * FROM user WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    // connexion réussie : stocker les infos utiles
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role_id'] = $user['role_id'];

    // redirection vers l'accueil connecté
    header("Location: /index.php?page=home");
    exit;
} else {
    // mauvais identifiants
    header("Location: /index.php?page=login&error=" . urlencode("Identifiants invalides"));
    exit;
}
