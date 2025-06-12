<?php

class FavoriteRepository {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    // ajouter un événement aux favoris d'un utilisateur
    public function getFavoriteEventIdsForUser(int $userId): array {
        $stmt = $this->db->prepare("SELECT event_id FROM favorite_event WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
