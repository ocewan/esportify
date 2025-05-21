<?php
require_once __DIR__ . '/../helpers/auth.php';
require_login();

// redirection vers la page appropriée en fonction du rôle de l'utilisateur
switch ($_SESSION['role_id']) {
    case 2:
        header("Location: /index.php?page=joueur");
        break;
    case 3:
        header("Location: /index.php?page=organisateur");
        break;
    case 4:
        header("Location: /index.php?page=admin");
        break;
    default:
        header("Location: /index.php?page=logout");
        break;
}
exit;
