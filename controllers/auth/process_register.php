<?php
require_once __DIR__ . '/../../config/db.php';
session_start();

$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// vérification des champs remplis ou non
if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
    header("Location: /index.php?page=register&error=Veuillez remplir tous les champs.");
    exit;
}

// vérification de la validité de l'email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: /index.php?page=register&error=Adresse email invalide.");
    exit;
}

// vérification de la correspondance des mots de passe
if ($password !== $confirm_password) {
    header("Location: /index.php?page=register&error=Les mots de passe ne correspondent pas.");
    exit;
}

// vérification de l'existence du nom d'utilisateur
$stmt = $pdo->prepare("SELECT id FROM user WHERE username = ?");
$stmt->execute([$username]);
if ($stmt->fetch()) {
    header("Location: /index.php?page=register&error=Nom d'utilisateur déjà pris.");
    exit;
}

// hashage du mot de passe
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// rôle par défaut : joueur (id = 2)
$role_id = 2;

// insertion dans la base de données
$stmt = $pdo->prepare("INSERT INTO user (username, email, password, role_id) VALUES (?, ?, ?, ?)");
$success = $stmt->execute([$username, $email, $hashedPassword, $role_id]);

if ($success) {
    header("Location: /index.php?page=login&success=Compte créé avec succès. Connectez-vous !");
    exit;
} else {
    header("Location: /index.php?page=register&error=Une erreur est survenue. Réessayez.");
    exit;
}

