<?php
require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../config/db.php';
require_role(2);

include __DIR__ . '/../partials/header.php';

$eventId = $_POST['event_id'] ?? $_GET['id'] ?? null;
$userId = $_SESSION['user_id'];

// vérification si l'événement existe
if (!$eventId) {
    echo "<p>Événement introuvable.</p>";
    include __DIR__ . '/../partials/footer.php';
    exit;
}

$stmt = $pdo->prepare("
SELECT e.title, e.description, e.date_event, e.date_end, e.started, e.img, ep.status
FROM event e
JOIN validation v ON v.event_id = e.id AND v.status = 1
JOIN eventparticipant ep ON ep.event_id = e.id AND ep.user_id = ?
WHERE e.id = ?
");
$stmt->execute([$userId, $eventId]);
$event = $stmt->fetch();

// vérfication que l’événement existe, est validé, démarré et que le joueur est inscrit
if (strtotime($event['date_end']) <= time()) {
    echo "<p>L’événement est terminé.</p>";
    echo '<a href="/index.php?page=home">Retour à l\'accueil</a>';
    include __DIR__ . '/../partials/footer.php';
    exit;
}
if (!$event || $event['status'] != 1) {
    echo "<p>Vous n’avez pas accès à cet événement.</p>";
    include __DIR__ . '/../partials/footer.php';
    exit;
}

if (!$event['started']) {
    echo "<p>L’événement n’a pas encore été lancé par l’organisateur.</p>";
    include __DIR__ . '/../partials/footer.php';
    exit;
}
?>

<!-- affichage de l'événement -->
<section class="event-live-container">
    <h1>Tournoi en cours</h1>

    <div class="event-live-card">
        <h2><?= htmlspecialchars($event['title']) ?></h2>
        <p class="desc"><?= nl2br(htmlspecialchars($event['description'])) ?></p>
            <?php if (!empty($event['img'])): ?>
            <img src="/<?= htmlspecialchars($event['img']) ?>" alt="<?= htmlspecialchars($event['title']) ?>">
            <?php endif; ?>

        <div class="event-meta">
            <p><strong>Début :</strong> <?= date('d/m/Y à H:i', strtotime($event['date_event'])) ?></p>
            <p><strong>Fin :</strong> <?= date('d/m/Y à H:i', strtotime($event['date_end'])) ?></p>
        </div>

        <div class="live-banner">
            <p>Bienvenue <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>, vous êtes bien inscrit à cet événement.</p>
        </div>

        <?php
        $role = $_SESSION['role_id'] ?? null;
        $page = match ($role) {
            2 => 'joueur',
            3 => 'organisateur',
            4 => 'admin',
            default => 'home'
        };
        ?>

        <a href="/index.php?page=<?= $page ?>" class="btn-back"> ⬅ Retour au dashboard</a>

    </div>
</section>



<?php include __DIR__ . '/../partials/footer.php'; ?>