<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../src/Repository/EventRepository.php';
require_once __DIR__ . '/../../src/Repository/FavoriteRepository.php';

$userId = $_SESSION['user_id'] ?? null;
$role = $_SESSION['role_id'] ?? null;

$players = $_GET['players'] ?? '';
$month = $_GET['month'] ?? '';
$hour = $_GET['hour'] ?? '';

// validation des paramètres
$repo = new EventRepository($pdo);
$events = $repo->findFilteredEvents($players, $month, $hour);

// si l'utilisateur est connecté et a un rôle de joueur ou organisateur, on récupère ses favoris
$favorites = [];
if (in_array((int)$role, [2, 3]) && $userId) {
    $favRepo = new FavoriteRepository($pdo);
    $favorites = $favRepo->getFavoriteEventIdsForUser($userId);
}

// affichage des événements (HTML généré)
foreach ($events as $event) {
    $isFavorite = in_array($event['id'], $favorites);

    echo '<div class="event-card">';
    echo '<h3>' . htmlspecialchars($event['title']) . '</h3>';
    echo '<p><i class="fa-solid fa-gamepad" style="color: #ffffff;"></i> ' . $event['participant_count'] . ' joueurs</p>';
    echo '<p><i class="fa-solid fa-clock" style="color: #ffffff;"></i> ' . date('d/m/Y H:i', strtotime($event['date_event'])) . ' → ' . date('d/m/Y H:i', strtotime($event['date_end'])) . '</p>';
    echo '<button class="view-details" data-id="' . $event['id'] . '">Voir + d\'infos</button>';

    if ($userId && in_array($role, [2, 3])) {
        $favText = $isFavorite ? '<i class="fa-solid fa-star" style="color: #FFD43B;"></i>' : '<i class="fa-regular fa-star" style="color: #a000ff;"></i>';
        $favVal = $isFavorite ? '1' : '0';

        echo '<button class="fav-btn" data-id="' . $event['id'] . '" data-fav="' . $favVal . '">' . $favText . '</button>';
    }

    echo '</div>';
}

