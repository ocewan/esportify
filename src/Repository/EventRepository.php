<?php
require_once __DIR__ . '/../Entity/Event.php';

class EventRepository {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    // retourne la connexion à la base de données
    public function getDb(): PDO {
    return $this->db;
    }

    // récupère tous les événements 
    public function findById(int $id): ?Event {
        $stmt = $this->db->prepare("SELECT e.*, u.username AS organizer, 
        (SELECT COUNT(*) FROM eventparticipant ep WHERE ep.event_id = e.id) AS participant_count
        FROM event e
        JOIN user u ON e.created_by = u.id
        WHERE e.id = ?
        ");
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        if ($row) {
            $event = new Event();
            foreach ($row as $key => $value) {
                if (property_exists($event, $key)) {
                    $event->$key = $value;
                }
            }
            return $event;
        }
        return null;
    }

    // créer un événement
    public function create(Event $event): bool {
    $sql = "INSERT INTO event (title, description, date_event, date_end, created_by, img)
            VALUES (:title, :description, :date_event, :date_end, :created_by, :img)";
    $stmt = $this->db->prepare($sql);

    return $stmt->execute([
        'title' => $event->title,
        'description' => $event->description,
        'date_event' => $event->date_event,
        'date_end' => $event->date_end,
        'created_by' => $event->created_by,
        'img' => $event->img
    ]);
    }

    // mettre à jour un événement
    public function update(Event $event): bool {
    $sql = "UPDATE event SET title = :title, description = :description, date_event = :date_event, date_end = :date_end, img = :img WHERE id = :id AND created_by = :created_by";
    $stmt = $this->db->prepare($sql);

    return $stmt->execute([
        'title' => $event->title,
        'description' => $event->description,
        'date_event' => $event->date_event,
        'date_end' => $event->date_end,
        'img' => $event->img,
        'id' => $event->id,
        'created_by' => $event->created_by
    ]);
    }

    // est-ce que l'user est le créateur de l'événement ?
    public function isOwnedByUser(int $eventId, int $userId): bool {
    $stmt = $this->db->prepare("SELECT 1 FROM event WHERE id = ? AND created_by = ?");
    $stmt->execute([$eventId, $userId]);
    return (bool) $stmt->fetchColumn();
    }

    // démarrer un événement
    public function start(int $eventId): bool {
    $stmt = $this->db->prepare("UPDATE event SET started = 1 WHERE id = ?");
    return $stmt->execute([$eventId]);
    }

    // Vérifie si l'événement a commencé
    public function hasStarted(int $eventId): bool {
    $stmt = $this->db->prepare("SELECT 1 FROM event WHERE id = ? AND started = 1");
    $stmt->execute([$eventId]);
    return (bool) $stmt->fetchColumn();
    }

    // Récupère les événements filtrés
    public function findFilteredEvents(?string $players, ?string $month, ?string $hour): array {
    $sql = "
        SELECT e.id, e.title, e.date_event, e.date_end, u.username AS organisateur,
            (SELECT COUNT(*) FROM eventparticipant ep WHERE ep.event_id = e.id AND ep.status = 1) AS participant_count
        FROM event e
        JOIN validation v ON v.event_id = e.id AND v.status = 1
        JOIN user u ON e.created_by = u.id
        WHERE e.date_end > NOW()
    ";

    if ($players === 'lt10') {
        $sql .= " AND (SELECT COUNT(*) FROM eventparticipant ep WHERE ep.event_id = e.id AND ep.status = 1) < 10";
    } elseif ($players === 'gte10') {
        $sql .= " AND (SELECT COUNT(*) FROM eventparticipant ep WHERE ep.event_id = e.id AND ep.status = 1) >= 10";
    }

    if ($month !== '') {
        $sql .= " AND MONTH(e.date_event) = " . intval($month);
    }

    if ($hour === 'morning') {
        $sql .= " AND HOUR(e.date_event) >= 0 AND HOUR(e.date_event) < 12";
    } elseif ($hour === 'afternoon') {
        $sql .= " AND HOUR(e.date_event) >= 12 AND HOUR(e.date_event) < 18";
    } elseif ($hour === 'evening') {
        $sql .= " AND HOUR(e.date_event) >= 18 AND HOUR(e.date_event) <= 23";
    }

    $sql .= " ORDER BY e.date_event ASC";

    $stmt = $this->db->query($sql);
    return $stmt->fetchAll();
    }
}
