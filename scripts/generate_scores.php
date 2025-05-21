<?php
require_once __DIR__ . '/db_local.php';
require_once __DIR__ . '/../vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$scoreCollection = $client->esportify->scores;

// récuperation de tous les utilisateurs
$users = $conn->query("SELECT id FROM user");

// récupération de tous les événements avec leur date
$events = $conn->query("SELECT id, date_event FROM event");

foreach ($users as $user) {
    foreach ($events as $event) {
        $score = rand(0, 100);

        // conversion de la date SQL en objet DateTime, puis en UTCDateTime MongoDB
        $eventDate = new DateTime($event['date_event']);
        $eventDateUTC = new MongoDB\BSON\UTCDateTime($eventDate->getTimestamp() * 1000);

        // mise à jour ou insertion
        $scoreCollection->updateOne(
            [
                'user_id' => (string)$user['id'],
                'event_id' => (string)$event['id']
            ],
            [
                '$set' => [
                    'score' => $score,
                    'timestamp' => $eventDateUTC
                ]
            ],
            ['upsert' => true]
        );
    }
}
echo "Scores générés";
?>