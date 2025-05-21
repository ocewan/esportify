<?php
function fetchAllEventsForAdmin($pdo, $userId)
{
    $stmt = $pdo->query("
        SELECT 
            e.*, u.username AS creator, v.status, v.validated_at, e.started,
            EXISTS (
                SELECT 1 
                FROM eventparticipant ep 
                WHERE ep.event_id = e.id AND ep.user_id = $userId
            ) AS is_registered
        FROM event e
        JOIN user u ON e.created_by = u.id
        LEFT JOIN validation v ON e.id = v.event_id
        WHERE e.date_end > NOW()
        ORDER BY e.date_event ASC
    ");
    return $stmt->fetchAll();
}

function fetchAdminFavorites($pdo, $userId)
{
    $stmt = $pdo->prepare("
        SELECT e.id, e.title, e.description, e.date_event, e.date_end, e.started,
               ep.status AS registration_status
        FROM event e
        JOIN favorite_event f ON f.event_id = e.id
        LEFT JOIN eventparticipant ep ON ep.event_id = e.id AND ep.user_id = ?
        WHERE f.user_id = ? AND e.date_end > NOW()
        ORDER BY e.date_event ASC
    ");
    $stmt->execute([$userId, $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function fetchAdminStats($pdo)
{
    return [
        'users' => $pdo->query("SELECT COUNT(*) FROM user")->fetchColumn(),
        'events' => $pdo->query("SELECT COUNT(*) FROM event")->fetchColumn(),
        'participations' => $pdo->query("SELECT COUNT(*) FROM eventparticipant")->fetchColumn()
    ];
}

function renderAdminEventSections(array $events, int $userId)
{
    $statuts = [
        'pending' => ['label' => "<i class='fa-solid fa-hourglass-half' style='color: #cb8306;'></i> En attente", 'match' => null],
        'valid' => ['label' => "<i class='fa-solid fa-check' style='color: #31b800;'></i> Validés", 'match' => 1],
        'refused' => ['label' => "<i class='fa-solid fa-x' style='color: #c20d00;'></i> Refusés", 'match' => 0],
    ];

    // affichage des événements par statut
    foreach ($statuts as $key => $data) {
        $status = $data['match'];
        echo "<h3>{$data['label']}</h3>";

        $filtered = array_filter($events, function ($e) use ($status) {
            $eventStatus = $e['status'] ?? null;
            if ($status === null) return $eventStatus === null;
            return isset($eventStatus) && (int)$eventStatus === $status;
        });

        if (empty($filtered)) {
            echo "<p>Aucun événement.</p>";
            continue;
        }

        echo '<div class="dashboard-event-grid">';
        foreach ($filtered as $event) {
            renderUnifiedEventCard($event, $userId, 'admin');
        }
        echo '</div>';
    }
}
