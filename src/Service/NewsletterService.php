<?php
require_once __DIR__ . '/../Repository/NewsletterRepository.php';

class NewsletterService {
    private NewsletterRepository $repo;

    public function __construct(NewsletterRepository $repo) {
        $this->repo = $repo;
    }

    // S'abonner à la newsletter
    public function subscribe(string $email): string {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Email invalide";
        }

        try {
            $this->repo->insert($email);
            return "ok";
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                return "Cet email est déjà inscrit.";
            }
            error_log("Newsletter error: " . $e->getMessage());
            return "Une erreur technique est survenue.";
        }
    }
}
