<?php
require_once __DIR__ . '/../Repository/EventRepository.php';

class EventService {
    private EventRepository $repo;

    public function __construct(EventRepository $repo) {
        $this->repo = $repo;
    }

    // récupérer tous les événements
    public function getEvent(int $id): ?Event {
        return $this->repo->findById($id);
    }

    // créer un événement
    public function createEvent(array $postData, int $userId): bool {
    $images = [
        "Valorant" => "img/valorant.jpg",
        "LoL" => "img/lol.jpg",
        "CallOfDuty" => "img/cod.jpg",
        "Warzone" => "img/warzone.jpg",
        "RocketLeague" => "img/rl.jpg"
    ];

    $title = trim($postData['title']);
    $event = new Event();
    $event->title = $title;
    $event->description = trim($postData['description']);
    $event->date_event = $postData['date_event'];
    $event->date_end = $postData['date_end'];
    $event->created_by = $userId;
    $event->img = $images[$title] ?? null;

    return $this->repo->create($event);
    }

    // mettre à jour un événement
    public function updateEvent(array $postData, int $userId): bool {
    if (empty($postData['id'])) return false;

    $images = [
        "Valorant" => "img/valorant.jpg",
        "LoL" => "img/lol.jpg",
        "CallOfDuty" => "img/cod.jpg",
        "Warzone" => "img/warzone.jpg",
        "RocketLeague" => "img/rl.jpg"
    ];

    $title = trim($postData['title']);
    $event = new Event();
    $event->id = (int) $postData['id'];
    $event->title = $title;
    $event->description = trim($postData['description']);
    $event->date_event = $postData['date_event'];
    $event->date_end = $postData['date_end'];
    $event->created_by = $userId;
    $event->img = $images[$title] ?? null;

    return $this->repo->update($event);
    }

    // rejoindre un événement
    public function joinEvent(int $eventId, int $userId): string {
    $participantRepo = new EventParticipantRepository($this->repo->getDb());

    return $participantRepo->join($eventId, $userId);
    }

    // se désinscrire d'un événement
    public function leaveEvent(int $eventId, int $userId): string {
    $participantRepo = new EventParticipantRepository($this->repo->getDb());
    return $participantRepo->leave($eventId, $userId);
    }

    // validation d'un événement par un admin
    public function validateEvent(int $eventId, int $adminId, int $status): bool {
    $validationRepo = new ValidationRepository($this->repo->getDb());
    return $validationRepo->validate($eventId, $adminId, $status);
    }

    // un joueur peut-il entrer dans l'événement ?
    public function canUserEnterEvent(int $eventId, int $userId): string {
    $participantRepo = new EventParticipantRepository($this->repo->getDb());

    if (!$participantRepo->canEnterEvent($eventId, $userId)) {
        return "Accès refusé à cet événement";
    }

    if (!$this->repo->hasStarted($eventId)) {
        return "Événement non démarré";
    }

    return "ok";
    }

    // démarrer un événement
    public function startEvent(int $eventId, int $userId, int $roleId): string {
    if ($roleId < 4 && !$this->repo->isOwnedByUser($eventId, $userId)) {
        return "Accès refusé";
    }

    $success = $this->repo->start($eventId);
    return $success ? "Événement démarré" : "Erreur lors du démarrage";
    }

    // refuser un participant
    public function refuseParticipant(int $participantId): bool {
    $participantRepo = new EventParticipantRepository($this->repo->getDb());
    return $participantRepo->refuseParticipant($participantId);
    }
}
