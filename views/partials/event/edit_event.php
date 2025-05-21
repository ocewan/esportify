<?php
require_once __DIR__ . '/../../../helpers/auth.php';
require_once __DIR__ . '/../../../config/db.php';
require_role(3); // Orga ou Admin

include __DIR__ . '/../../partials/header.php';

// vérification de l'ID de l'événement
if (!isset($_GET['id'])) {
    header('Location: /index.php?page=' . ($_SESSION['role_id'] === 4 ? 'admin' : 'organisateur') . '&error=ID manquant');
    exit;
}

$eventId = (int) $_GET['id'];

// vérification que l'utilisateur a le droit de modifier l'événement
if ($_SESSION['role_id'] === 4) {
    // Admin peut modifier tous les événements
    $stmt = $pdo->prepare("SELECT * FROM event WHERE id = ?");
    $stmt->execute([$eventId]);
} else {
    // Orga ne peut modifier que les siens
    $stmt = $pdo->prepare("SELECT * FROM event WHERE id = ? AND created_by = ?");
    $stmt->execute([$eventId, $_SESSION['user_id']]);
}

$event = $stmt->fetch();

// redirection si pas d'événement trouvé
if (!$event) {
    header('Location: /index.php?page=' . ($_SESSION['role_id'] === 4 ? 'admin' : 'organisateur') . '&error=Événement introuvable ou accès refusé');
    exit;
}
?>

<!-- affichage du formulaire de modification -->
<div class="edit-container">
<h1>Modifier l’événement</h1>

<?php if (isset($_GET['error'])): ?>
    <p style="color:red"><?= htmlspecialchars($_GET['error']) ?></p>
<?php endif; ?>

<form action="/index.php?controller=edit_event" method="POST">
    <input type="hidden" name="id" value="<?= $event['id'] ?>">

    <label>Titre :</label>
    <select name="title" required>
    <?php
    $titles = ["Valorant", "LoL", "CallOfDuty", "Warzone", "RocketLeague"];
    foreach ($titles as $title) {
        $selected = ($event['title'] === $title) ? 'selected' : '';
        echo "<option value=\"$title\" $selected>$title</option>";
    } ?>
    </select>

    <label>Description :</label>
    <textarea name="description" required><?= htmlspecialchars($event['description']) ?></textarea>

    <label>Date de début :</label>
    <input type="datetime-local" name="date_event" value="<?= date('Y-m-d\TH:i', strtotime($event['date_event'])) ?>" required>

    <label>Date de fin :</label>
    <input type="datetime-local" name="date_end" value="<?= date('Y-m-d\TH:i', strtotime($event['date_end'])) ?>" required>

    <button type="submit">Enregistrer les modifications</button>
</form>

<p><a href="/index.php?page=<?= $_SESSION['role_id'] === 4 ? 'admin' : 'organisateur' ?>">← Retour au tableau de bord</a></p>
</div>

<?php include __DIR__ . '/../../partials/footer.php'; ?>