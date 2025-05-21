<?php include __DIR__ . '/../views/partials/header.php'; ?>

<!-- affichage de la page de connexion -->
<section class="form-section">
    <h1>Se connecter</h1>

    <?php if (isset($_GET['error'])): ?>
        <div style="color: red;">
            <?= htmlspecialchars($_GET['error']) ?>
        </div>
    <?php endif; ?>

    <form action="/index.php?controller=login" method="POST">
        <input type="text" name="username" placeholder="Nom d'utilisateur" required><br>
        <input type="password" name="password" placeholder="Mot de passe" required><br>
        <button type="submit">Se connecter</button>
    </form>
</section>

<?php include __DIR__ . '/../views/partials/footer.php'; ?>