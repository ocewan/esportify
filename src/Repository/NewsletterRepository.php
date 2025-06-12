<?php

class NewsletterRepository {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    // inserer une adresse email dans la table newsletter
    public function insert(string $email): bool {
        $stmt = $this->db->prepare("INSERT INTO newsletter (email) VALUES (:email)");
        return $stmt->execute(['email' => $email]);
    }
}
