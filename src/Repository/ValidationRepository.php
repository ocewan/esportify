<?php

class ValidationRepository {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    // vérifie si l'événement existe et est en attente de validation
    public function validate(int $eventId, int $adminId, int $status): bool {
        if (!in_array($status, [0, 1])) {
            return false;
        }

        $stmt = $this->db->prepare("INSERT INTO validation (event_id, validated_by, status) VALUES (?, ?, ?)");
        return $stmt->execute([$eventId, $adminId, $status]);
    }
}
