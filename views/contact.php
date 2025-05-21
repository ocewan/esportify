<?php
$success = false;
$error = false;

// vérification de la méthode de la requête
// et récupération des données du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = htmlspecialchars(trim($_POST["name"] ?? ""));
    $email = htmlspecialchars(trim($_POST["email"] ?? ""));
    $message = htmlspecialchars(trim($_POST["message"] ?? ""));

    if ($name && $email && $message) {
        $success = true;
    } else {
        $error = true;
    }
}
?>

<?php include __DIR__ . '/partials/header.php'; ?>

<!-- affichage de la section de contact -->
<section class="contact-section">
    <h2>Contacte-nous</h2>
    <p>Une question, une suggestion ou une collaboration ? Écris-nous !</p>

    <?php if ($success): ?>
        <p style="color: green;">✅ Message envoyé avec succès !</p>
    <?php elseif ($error): ?>
        <p style="color: red;">❌ Merci de remplir tous les champs.</p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="name">Nom</label>
        <input type="text" id="name" name="name" required>

        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" required>

        <label for="message">Message</label>
        <textarea id="message" name="message" required></textarea>

        <button type="submit">Envoyer</button>
    </form>
</section>

<?php include __DIR__ . '/partials/footer.php'; ?>