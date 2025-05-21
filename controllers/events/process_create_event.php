<?php
require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../config/db.php';
require_role(3); // Organisateur ou Admin

$title = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');
$date_event = $_POST['date_event'] ?? '';
$date_end = $_POST['date_end'] ?? '';
$images = [
    "Valorant" => "img/valorant.jpg",
    "LoL" => "img/lol.jpg",
    "CallOfDuty" => "img/cod.jpg",
    "Warzone" => "img/warzone.jpg",
    "RocketLeague" => "img/rl.jpg"
];
$img = $images[$title] ?? null;

// vérification des champs remplis ou non
if (empty($title) || empty($description) || empty($date_event) || empty($date_end)) {
    header("Location: /index.php?page=create_event&error=Champs requis manquants");
    exit;
}

// insertion dans la base de données
try {
    $stmt = $pdo->prepare("INSERT INTO event (title, description, date_event, date_end, created_by, img) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$title, $description, $date_event, $date_end, $_SESSION['user_id'], $img]);

    $redirectPage = $_SESSION['role_id'] === 4 ? 'admin' : 'organisateur';
    header("Location: /index.php?page=$redirectPage&success=Événement créé, en attente de validation");
    exit;
} catch (Exception $e) {
    header("Location: /index.php?page=create_event&error=" . urlencode("Erreur : " . $e->getMessage()));
    exit;
}
