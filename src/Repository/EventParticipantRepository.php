<?php

class EventParticipantRepository {
    private PDO $db;

    // Constructeur pour initialiser la connexion à la base de données
    public function __construct(PDO $db) {
        $this->db = $db;
    }

    // s'inscrire à un événement
    public function join(int $eventId, int $userId): string {
        // Vérifie si l'événement est validé
        $stmt = $this->db->prepare("SELECT 1 FROM validation WHERE event_id = ? AND status = 1");
        $stmt->execute([$eventId]);
        if (!$stmt->fetch()) {
            return 'Événement non validé';
        }

        // Vérifie si l'utilisateur est déjà inscrit
        $stmt = $this->db->prepare("SELECT status FROM eventparticipant WHERE event_id = ? AND user_id = ?");
        $stmt->execute([$eventId, $userId]);
        $existing = $stmt->fetch();

        if ($existing) {
            $status = (int)$existing['status'];
            if ($status === -1) return 'Inscription refusée pour cet événement';
            if ($status === 1) return 'Déjà inscrit à cet événement';
            if ($status === 0) {
                // Met à jour le statut à inscrit
                $update = $this->db->prepare("UPDATE eventparticipant SET status = 1 WHERE event_id = ? AND user_id = ?");
                $update->execute([$eventId, $userId]);
                return 'Inscription confirmée !';
            }
            return 'Erreur inconnue d’inscription';
        }

        // Si pas encore inscrit
        $insert = $this->db->prepare("INSERT INTO eventparticipant (event_id, user_id, status) VALUES (?, ?, 1)");
        $insert->execute([$eventId, $userId]);
        return 'Inscription réussie !';
    }

    // se désinscrire d'un événement
    public function leave(int $eventId, int $userId): string {
    // Vérifie que l'événement n'a pas commencé
    $stmt = $this->db->prepare("SELECT date_event FROM event WHERE id = ?");
    $stmt->execute([$eventId]);
    $event = $stmt->fetch();

    if (!$event || strtotime($event['date_event']) <= time()) {
        return "Impossible de se désinscrire d'un événement déjà commencé";
    }

    // Supprime l'inscription
    $stmt = $this->db->prepare("DELETE FROM eventparticipant WHERE event_id = ? AND user_id = ?");
    $stmt->execute([$eventId, $userId]);

    return "Vous avez été désinscrit de l'événement";
    }

    // vérifier si un joueur peut entrer dans un événement
    public function canEnterEvent(int $eventId, int $userId): bool {
    // Vérifie si le joueur est inscrit
    $stmt = $this->db->prepare("SELECT 1 FROM eventparticipant WHERE event_id = ? AND user_id = ? AND status = 1");
    $stmt->execute([$eventId, $userId]);
    return (bool) $stmt->fetchColumn();
    }

    // refuser un participant
    public function refuseParticipant(int $participantId): bool {
    $stmt = $this->db->prepare("UPDATE eventparticipant SET status = -1 WHERE id = ?");
    return $stmt->execute([$participantId]);
    }
}

