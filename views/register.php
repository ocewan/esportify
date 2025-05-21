<?php include __DIR__ . '/../views/partials/header.php'; ?>

<!-- affichage de la page de création de compte -->
<section class="form-section">
    <h1>Créer un compte</h1>

    <?php if (isset($_GET['error'])): ?>
        <div style="color: red;">
            <?= htmlspecialchars($_GET['error']) ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
        <div style="color: green;">
            <?= htmlspecialchars($_GET['success']) ?>
        </div>
    <?php endif; ?>

    <form action="/index.php?controller=register" method="POST">
        <input type="text" name="username" placeholder="Nom d'utilisateur" required><br>
        <input type="email" name="email" placeholder="Adresse e-mail" required pattern="^[^\s@]+@[^\s@]+\.[^\s@]+$" title="Veuillez entrer une adresse e-mail valide"><br>
        <input type="password" name="password" placeholder="Mot de passe" required><br>
        <input type="password" name="confirm_password" placeholder="Confirmez mot de passe" required><br>
        <button type="submit">S'inscrire</button>
    </form>
</section>

<?php include __DIR__ . '/../views/partials/footer.php'; ?>