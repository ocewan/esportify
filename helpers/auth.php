<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// vérification qu’un utilisateur est connecté
function require_login()
{
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login.php?error=Connexion requise');
        exit;
    }
}

// vérification que l’utilisateur a un rôle minimum
function require_role($minRole)
{
    require_login();
    if ($_SESSION['role_id'] < $minRole) {
        header('Location: /login.php?error=Accès refusé');
        exit;
    }
}
