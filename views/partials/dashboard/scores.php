<?php
require_once __DIR__ . '/../../../config/mongodb.php';
require_once __DIR__ . '/../../../scripts/db_local.php';
$userId = $_SESSION['user_id'] ?? null;
?>

<!-- affichage des scores -->
<?php if ($userId): ?>
    <div class="scores-table-wrapper">
        <h2>Historique de vos scores</h2>
    <table class="scores-table" border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Event</th>
            <th>Score</th>
            <th>Date</th>
        </tr>
        <?php
        $scores = $scoreCollection->find(['user_id' => (string)$userId]);

        foreach ($scores as $score) {
    $eventId = $score['event_id'];
    $eventName = "Inconnu";

    $result = $conn->query("SELECT title FROM event WHERE id = " . (int)$eventId);
    if ($result && $row = $result->fetch_assoc()) {
        $eventName = $row['title'];
    }

    echo "<tr>";
    echo "<td>" . htmlspecialchars($eventName) . "</td>";
    echo "<td>" . $score['score'] . "</td>";
    echo "<td>" . $score['timestamp']->toDateTime()->format('d/m/Y') . "</td>";
    echo "</tr>";
}
        ?>
    </table>
    </div>
<?php else: ?>
    <p>Utilisateur non connecté</p>
<?php endif; ?>
