<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../helpers/auth.php';
include __DIR__ . '/../partials/header.php';

$userId = $_SESSION['user_id'] ?? null;
$role = $_SESSION['role_id'] ?? null;
$favoriteIds = [];

// vérification du rôle
if (in_array((int)$role, [2, 3, 4]) && $userId) {
    $stmtFav = $pdo->prepare("SELECT event_id FROM favorite_event WHERE user_id = ?");
    $stmtFav->execute([$userId]);
    $favoriteIds = $stmtFav->fetchAll(PDO::FETCH_COLUMN);
}

// récupération des événements
$stmt = $pdo->query("SELECT e.id, e.title, e.date_event, e.date_end, u.username AS organisateur,
        (SELECT COUNT(*) FROM eventparticipant ep WHERE ep.event_id = e.id) AS nb_players
        FROM event e
        JOIN validation v ON v.event_id = e.id AND v.status = 1
        JOIN user u ON e.created_by = u.id
        ORDER BY e.date_event ASC");
$events = $stmt->fetchAll();
$now = time();
?>

<!-- affichage des événements validés -->
<section class="section-events">
    <h1>Tous les événements</h1>

    <?php include __DIR__ . '/../partials/event/event_filters.php'; ?>

    <div class="events-container">
        <?php
        foreach ($events as $event) {
            $eventTime = strtotime($event['date_event']);
            $endTime = strtotime($event['date_end']);
            if (strtotime($event['date_end']) < $now) continue;
            include __DIR__ . '/../partials/event/event_card.php';
        }
        ?>
    </div>
</section>

<!-- affichage de la popup d'événement -->
<?php include __DIR__ . '/../partials/event/event_modal.php'; ?>
<script src="/js/event_list.js"></script>
<?php include __DIR__ . '/../partials/footer.php'; ?>