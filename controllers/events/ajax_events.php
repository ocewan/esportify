<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../helpers/auth.php';

$userId = $_SESSION['user_id'] ?? null;
$role = $_SESSION['role_id'] ?? null;
$favoriteIds = [];

$players = $_GET['players'] ?? '';
$month = $_GET['month'] ?? '';
$hour = $_GET['hour'] ?? '';

// validation des données
if (in_array((int)$role, [2, 3]) && $userId) {
    $stmtFav = $pdo->prepare("SELECT event_id FROM favorite_event WHERE user_id = ?");
    $stmtFav->execute([$userId]);
    $favoriteIds = $stmtFav->fetchAll(PDO::FETCH_COLUMN);
}

$sql = "
    SELECT e.id, e.title, e.date_event, e.date_end, u.username AS organisateur,
        (SELECT COUNT(*) FROM eventparticipant ep WHERE ep.event_id = e.id AND ep.status = 1) AS participant_count
    FROM event e
    JOIN validation v ON v.event_id = e.id AND v.status = 1
    JOIN user u ON e.created_by = u.id
    WHERE e.date_end > NOW()
";

// filtrage par nombre de joueurs
if ($players === 'lt10') {
    $sql .= " AND (SELECT COUNT(*) FROM eventparticipant ep WHERE ep.event_id = e.id AND ep.status = 1) < 10";
} elseif ($players === 'gte10') {
    $sql .= " AND (SELECT COUNT(*) FROM eventparticipant ep WHERE ep.event_id = e.id AND ep.status = 1) >= 10";
}

// filtrage par mois
if ($month !== '') {
    $sql .= " AND MONTH(e.date_event) = " . intval($month);
}

// filtrage par heure
if ($hour === 'morning') {
    $sql .= " AND HOUR(e.date_event) >= 0 AND HOUR(e.date_event) < 12";
} elseif ($hour === 'afternoon') {
    $sql .= " AND HOUR(e.date_event) >= 12 AND HOUR(e.date_event) < 18";
} elseif ($hour === 'evening') {
    $sql .= " AND HOUR(e.date_event) >= 18 AND HOUR(e.date_event) <= 23";
}

$sql .= " ORDER BY e.date_event ASC";

$stmt = $pdo->query($sql);
$events = $stmt->fetchAll();

// affichage des événements
foreach ($events as $event) {
    $isFavorite = in_array($event['id'], $favoriteIds);

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
