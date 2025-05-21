<?php

function fetchFavoritedEvents(PDO $pdo, int $userId): array
{
    $stmt = $pdo->prepare("SELECT e.id, e.title, e.description, e.date_event, e.date_end, e.started,
                                   ep.status AS registration_status
                            FROM favorite_event f
                            JOIN event e ON f.event_id = e.id
                            JOIN validation v ON v.event_id = e.id AND v.status = 1
                            LEFT JOIN eventparticipant ep ON ep.event_id = e.id AND ep.user_id = ?
                            WHERE f.user_id = ? AND e.date_end > NOW()
                            ORDER BY e.date_event ASC");
    $stmt->execute([$userId, $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function fetchParticipationCount(PDO $pdo, int $userId): int
{
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM eventparticipant WHERE user_id = ?");
    $stmt->execute([$userId]);
    return (int)$stmt->fetchColumn();
}

