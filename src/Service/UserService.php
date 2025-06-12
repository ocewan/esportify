<?php
require_once __DIR__ . '/../Repository/UserRepository.php';

class UserService {
    private UserRepository $repo;

    public function __construct(UserRepository $repo) {
        $this->repo = $repo;
    }

    // créer un compte utilisateur
    public function register(string $username, string $email, string $password, string $confirmPassword): string {
        // Vérification des champs
    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        return "Veuillez remplir tous les champs.";
    }
        // Vérification de la validité de l'email et des mots de passe
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Adresse email invalide.";
    }

    if ($password !== $confirmPassword) {
        return "Les mots de passe ne correspondent pas.";
    }
        // Vérification du nom d'utilisateur 
    if ($this->repo->existsByUsername($username)) {
        return "Nom d'utilisateur déjà pris.";
    }
    // hash du mot de passe
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $success = $this->repo->insert($username, $email, $hashedPassword, 2);

    return $success ? "ok" : "Une erreur est survenue. Réessayez.";
    }

    // Authentification de l'utilisateur
    public function authenticate(string $username, string $password): ?array {
    $user = $this->repo->findByUsername($username);

    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }

    return null;
    }

    // déconnexion de l'utilisateur
    public function logout(): void {
    session_unset();
    session_destroy();
    }

    // mise à jour du rôle d'un utilisateur
    public function changeUserRole(int $userId, int $newRole): bool {
        return $this->repo->updateUserRole($userId, $newRole);
    }

    // redirection vers le tableau de bord selon le rôle
    public function getDashboardRedirectUrl(int $roleId): string {
    return match ($roleId) {
        2 => '/index.php?page=joueur',
        3 => '/index.php?page=organisateur',
        4 => '/index.php?page=admin',
        default => '/index.php?page=logout'
    };
    }
}
