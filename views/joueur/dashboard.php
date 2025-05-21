<?php
require_once __DIR__ . '/../../helpers/auth.php';
require_role(2);
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../partials/dashboard/joueur_functions.php';
require_once __DIR__ . '/../partials/dashboard/card_functions.php';
include __DIR__ . '/../partials/header.php';

$userId = $_SESSION['user_id'];
$username = htmlspecialchars($_SESSION['username']);
$events = fetchFavoritedEvents($pdo, $userId);
$nbParticipations = fetchParticipationCount($pdo, $userId);
?>

<!-- affichage du dashboard joueur -->
<div class="dashboard-wrapper">
    <h1>Bienvenue <strong><?= $username ?></strong> <i class="fa-solid fa-hand-peace" style="color: #ffffff;"></i></h1>

    <?php if (isset($_GET['success'])): ?>
        <p style="color:green;"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif; ?>
    <?php if (isset($_GET['error'])): ?>
        <p style="color:red;"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif; ?>

    <h2>Mes événements favoris</h2>
    <?php if (empty($events)): ?>
        <p>Aucun événement à venir pour le moment.</p>
    <?php else: ?>
        <div class="dashboard-event-grid">
            <?php foreach ($events as $event) renderUnifiedEventCard($event, $userId, 'joueur'); ?>
        </div>
    <?php endif; ?>

<?php include __DIR__ . '/../partials/dashboard/panels.php'; ?>

<div class="stats">
        <h2>Mes statistiques</h2>
    <ul>
        <li><i class="fa-solid fa-trophy" style="color: #ffffff;"></i> Participations totales : <strong><?= $nbParticipations ?></strong></li>
    </ul>
</div>

<?php include __DIR__ . '/../partials/dashboard/scores.php'; ?>

</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>

<script src="/js/dashboard_ajax.js"></script>