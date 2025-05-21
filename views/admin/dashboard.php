<?php
require_once __DIR__ . '/../../helpers/auth.php';
require_role(4);
require_once __DIR__ . '/../../config/db.php';
include __DIR__ . '/../partials/header.php';

$userId = $_SESSION['user_id'];
$username = htmlspecialchars($_SESSION['username']);
require_once __DIR__ . '/../partials/dashboard/admin_functions.php';
require_once __DIR__ . '/../partials/dashboard/card_functions.php';

// Récupération des données
$events = fetchAllEventsForAdmin($pdo, $userId);
$stats = fetchAdminStats($pdo);
?>

<!-- affichage du dashboard admin -->
<div class="dashboard-wrapper">
    <h1>Tableau de bord Administrateur<br>Bienvenue <strong><?= $username ?></strong></h1>

    <?php if (isset($_GET['success'])): ?>
        <p style="color:green;"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif; ?>
    <?php if (isset($_GET['error'])): ?>
        <p style="color:red;"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif; ?>

    <h2>Gestion des événements</h2>
    <?php renderAdminEventSections($events, $userId); ?>

    <h2>Mes favoris</h2>
    <?php
    $favorites = fetchAdminFavorites($pdo, $userId);
    if (empty($favorites)) {
        echo "<p>Aucun événement favori.</p>";
    } else {
        echo '<div class="dashboard-event-grid">';
        foreach ($favorites as $fav) {
            renderUnifiedEventCard($fav, $userId, 'admin', true); 
        }
        echo '</div>';
    }
    ?>

<?php include __DIR__ . '/../partials/dashboard/panels.php'; ?>
        
    <div class="stats">
        <h2>Statistiques</h2>
        <ul>
            <li><i class='fa-solid fa-trophy' style='color: #ffffff;'></i> Événements créés : <strong><?= $stats['events'] ?></strong></li>
            <li><i class='fa-solid fa-users' style='color: #ffffff;'></i> Utilisateurs : <strong><?= $stats['users'] ?></strong></li>
        <li><i class='fa-solid fa-hand' style='color: #ffffff;'></i> Participations : <strong><?= $stats['participations'] ?></strong></li>
        </ul>
    </div>
    
</div>

<?php include __DIR__ . '/../partials/dashboard/scores.php'; ?>

<?php include __DIR__ . '/../partials/footer.php'; ?>

<script src="/js/dashboard_ajax.js"></script>