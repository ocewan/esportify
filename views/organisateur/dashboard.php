<?php
require_once __DIR__ . '/../../helpers/auth.php';
require_role(3);
require_once __DIR__ . '/../../config/db.php';
include __DIR__ . '/../partials/header.php';

$userId = $_SESSION['user_id'];
$username = htmlspecialchars($_SESSION['username']);

include __DIR__ . '/../partials/dashboard/orga_functions.php';
include __DIR__ . '/../partials/dashboard/card_functions.php';
?>

<!-- affichage du dashboard organisateur -->
<div class="dashboard-wrapper">
    <h1>Tableau de bord Organisateur <br> Bienvenue <strong><?= $username ?></strong> <i class="fa-solid fa-hand-peace"></i></h1>


    <h2>Mes événements créés</h2>
    <?php
    $events = fetchEvents($pdo, $userId);
    echo '<div class="dashboard-event-grid">';
    foreach ($events as $event) renderUnifiedEventCard($event, $userId, 'orga');
    echo '</div>';
    ?>

    <h2>Mes favoris</h2>
    <?php
    $favorites = fetchFavorites($pdo, $userId);
    if (empty($favorites)) {
        echo "<p>Aucun événement favori.</p>";
    } else {
        echo '<div class="dashboard-event-grid">';
        
        foreach ($favorites as $fav) renderUnifiedEventCard($fav, $userId, 'orga', true);
        echo '</div>';
    }
    ?>

    <?php include __DIR__ . '/../partials/dashboard/panels.php'; ?>
    <?php renderStats($pdo, $userId); ?>
    <?php include __DIR__ . '/../partials/dashboard/scores.php'; ?>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>

<script src="/js/dashboard_ajax.js"></script>