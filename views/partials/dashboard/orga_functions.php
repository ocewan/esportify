<?php
function fetchEvents($pdo, $userId)
{
    $stmt = $pdo->prepare("SELECT e.*, v.status, v.validated_at, EXISTS (SELECT 1 FROM eventparticipant ep WHERE ep.event_id = e.id AND ep.user_id = ?) AS is_registered FROM event e LEFT JOIN validation v ON e.id = v.event_id WHERE e.created_by = ? AND e.date_end > NOW() ORDER BY e.date_event ASC");
    $stmt->execute([$userId, $userId]);
    return $stmt->fetchAll();
}

function fetchFavorites($pdo, $userId)
{
    $stmt = $pdo->prepare("SELECT e.id, e.title, e.description, e.date_event, e.date_end, e.started, ep.status AS registration_status FROM event e JOIN favorite_event f ON f.event_id = e.id LEFT JOIN eventparticipant ep ON ep.event_id = e.id AND ep.user_id = ? WHERE f.user_id = ? AND e.date_end > NOW() ORDER BY e.date_event ASC");
    $stmt->execute([$userId, $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function renderStats($pdo, $userId)
{
    $countEvents = $pdo->prepare("SELECT COUNT(*) FROM event WHERE created_by = ?");
    $countEvents->execute([$userId]);

    $countParticipants = $pdo->prepare("SELECT COUNT(*) FROM eventparticipant ep JOIN event e ON ep.event_id = e.id WHERE e.created_by = ?");
    $countParticipants->execute([$userId]);

    echo "<h2>Mes statistiques</h2>";
    echo "<ul>
        <li><i class='fa-solid fa-trophy' style='color: #ffffff;'></i> Événements créés : <strong>{$countEvents->fetchColumn()}</strong></li>
        <li><i class='fa-solid fa-users' style='color: #ffffff;'></i> Participants inscrits : <strong>{$countParticipants->fetchColumn()}</strong></li>
    </ul>";
}
