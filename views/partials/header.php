<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!-- Header -->
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Esportify</title>
    <link rel="stylesheet" href="/style/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
</head>

<body>

    <header class="header">
        <div class="logo">
            <img src="/img/logo-vide.png" alt="Logo Esportify" />
            <a href="/index.php?page=accueil">ESPORTIFY</a>
        </div>
        <nav class="nav" id="nav">
            <a href="/">Accueil</a>
            <a href="/index.php?page=event_list">Event</a>
            <a href="/index.php?page=contact">Contact</a>
        </nav>
        <div class="auth-links">
            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="/index.php?page=login">Se connecter</a>
                <a href="/index.php?page=register" class="btn btn-accent">S'inscrire</a>
            <?php else: ?>
                <a href="/index.php?controller=redirect_dashboard" class="btn btn-accent">Mon espace</a>
                <a href="/index.php?page=logout">Se déconnecter</a>
            <?php endif; ?>
        </div>
        <div class="menu-toggle" id="menu-toggle">
            <i class="fa-solid fa-bars"></i>
        </div>
    </header>

    <div class="page-wrapper">