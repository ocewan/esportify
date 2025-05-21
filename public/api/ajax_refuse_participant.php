<?php
require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../config/db.php';
require_role(3); // Orga et Admin

$stmt = $pdo->query("
    SELECT ep.id AS participant_id, u.username, e.title AS event_title, e.id AS event_id
    FROM eventparticipant ep
    JOIN user u ON ep.user_id = u.id
    JOIN event e ON ep.event_id = e.id
    WHERE ep.status = 1
      AND e.date_end > NOW()
    ORDER BY e.date_event ASC
");

$participants = $stmt->fetchAll();

// affichage des participants à refuser ou non
if (empty($participants)) {
    echo "<p>Aucun joueur à valider (tous les événements sont terminés ou aucun inscrit).</p>";
} else {
    echo '<table class="user-table" border="1" cellpadding="6">';
    echo '<tr><th>Participant</th><th>Événement</th><th>Action</th></tr>';
    foreach ($participants as $p) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($p['username']) . '</td>';
        echo '<td>' . htmlspecialchars($p['event_title']) . '</td>';
        echo '<td>
            <form action="/index.php?controller=refuse_participant" method="POST">
                <input type="hidden" name="participant_id" value="' . $p['participant_id'] . '">
                <button type="submit">Refuser</button>
            </form></td>';
        echo '</tr>';
    }
    echo '</table>';
}
