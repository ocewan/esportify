<?php
require_once __DIR__ . '/../helpers/auth.php';
require_login();
$username = $_SESSION['username'] ?? '';
?>

<?php include __DIR__ . '/partials/header.php'; ?>

<!-- affichage de la page d'accueil personnalisée selon le rôle -->
<section class="hero">
    <div class="hero-text">
        <h1>Bienvenue, <?= htmlspecialchars($username) ?> </h1>
        <p>Vous êtes connecté à Esportify.</p>

        <form method="POST" action="/index.php?controller=redirect_dashboard">
            <button type="submit" class="btn btn-accent">Mon espace</button>
        </form>
    </div>
</section>

<?php include __DIR__ . '/partials/footer.php'; ?>