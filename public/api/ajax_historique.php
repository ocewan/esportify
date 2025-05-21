<?php
require_once __DIR__ . '/../../helpers/auth.php';
require_login();
require_once __DIR__ . '/../../config/db.php';

header('Content-Type: text/html');

$userId = $_SESSION['user_id'];
$roleId = $_SESSION['role_id'];

// vérication du rôle de l'utilisateur
if ($roleId === 4) {
    $stmt = $pdo->query("SELECT e.*, u.username AS creator FROM event e JOIN user u ON e.created_by = u.id WHERE e.date_end < NOW() ORDER BY e.date_end DESC");
} elseif ($roleId === 3) {
    $stmt = $pdo->prepare("SELECT DISTINCT e.*, u.username AS creator FROM event e JOIN user u ON e.created_by = u.id LEFT JOIN eventparticipant ep ON ep.event_id = e.id AND ep.user_id = :user WHERE (e.created_by = :user OR ep.user_id = :user) AND e.date_end < NOW() ORDER BY e.date_end DESC");
    $stmt->execute(['user' => $userId]);
} else {
    $stmt = $pdo->prepare("SELECT e.*, u.username AS creator FROM event e JOIN user u ON e.created_by = u.id JOIN eventparticipant ep ON ep.event_id = e.id WHERE ep.user_id = ? AND ep.status = 1 AND e.date_end < NOW() ORDER BY e.date_end DESC");
    $stmt->execute([$userId]);
}
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

// affichage des événements terminés
if (empty($events)) {
    echo "<p>Aucun événement terminé pour le moment.</p>";
} else {
    echo '<div class="events-container">';
    foreach ($events as $event) {
        $title = htmlspecialchars($event['title']);
        $desc = nl2br(htmlspecialchars($event['description']));
        $creator = htmlspecialchars($event['creator']);
        $end = date('d/m/Y H:i', strtotime($event['date_end']));

        echo '<div class="event-history">';
        echo '<div class="event-card">';
        echo "<h3>$title</h3>";
        echo "<p class='event-desc'>$desc</p>";
        echo "<p><strong>Organisé par :</strong> $creator</p>";
        echo "<p class='event-info'><strong>Terminé le :</strong> $end</p>";
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
}
