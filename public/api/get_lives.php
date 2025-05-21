<?php
require_once __DIR__ . '/../../config/db.php';

$type = $_GET['type'] ?? null;
$now = date('Y-m-d H:i:s');

if (!$type || !in_array($type, ['en-cours', 'a-venir'])) {
    http_response_code(400);
    echo json_encode(["error" => "Type invalide"]);
    exit;
}

$query = "
    SELECT e.title AS jeu, e.date_event, e.created_by, u.username AS organisateur
    FROM event e
    JOIN validation v ON e.id = v.event_id
    JOIN user u ON u.id = e.created_by
    WHERE v.status = 1
";

// filtrage par type d'événement
if ($type === 'en-cours') {
    $query .= " AND e.started = 1 AND e.date_event <= :now";
} elseif ($type === 'a-venir') {
    $query .= " AND e.started = 0 AND e.date_event > :now";
}

$query .= " ORDER BY e.date_event ASC";

$stmt = $pdo->prepare($query);
$stmt->execute(['now' => $now]);
$events = $stmt->fetchAll();

$imageName = $type === 'en-cours' ? 'live-now.png' : 'live-soon.png';

// vérification si des événements sont trouvés
$response = array_map(function ($e) use ($imageName) {
    return [
        'jeu' => $e['jeu'],
        'image' => "/img/{$imageName}",
        'heure' => date('H\Hi', strtotime($e['date_event'])),
        'organisateur' => $e['organisateur'],
    ];
}, $events);

header('Content-Type: application/json');
echo json_encode($response);