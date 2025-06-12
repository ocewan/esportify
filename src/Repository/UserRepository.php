<?php

class UserRepository {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    // vérifie si l'utilisateur existe par son username
    public function existsByUsername(string $username): bool {
    $stmt = $this->db->prepare("SELECT id FROM user WHERE username = ?");
    $stmt->execute([$username]);
    return (bool) $stmt->fetch();
    }

    // insère un nouvel utilisateur dans la base de données
    public function insert(string $username, string $email, string $hashedPassword, int $roleId = 2): bool {
    $stmt = $this->db->prepare("INSERT INTO user (username, email, password, role_id) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$username, $email, $hashedPassword, $roleId]);
    }

    // trouve un user par sn username
    public function findByUsername(string $username): ?array {
    $stmt = $this->db->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    return $user ?: null;
    }

    // mise à jour du rôle d'un utilisateur
    public function updateUserRole(int $userId, int $newRole): bool {
        if (!in_array($newRole, [1, 2, 3, 4])) {
            return false;
        }

        $stmt = $this->db->prepare("UPDATE user SET role_id = ? WHERE id = ?");
        return $stmt->execute([$newRole, $userId]);
    }
}
