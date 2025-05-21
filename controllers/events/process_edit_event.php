<?php
require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../config/db.php';
require_role(3); // Orga ou Admin

$id = $_POST['id'] ?? null;
$title = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');
$date_event = $_POST['date_event'] ?? '';
$date_end = $_POST['date_end'] ?? '';

// vérification des champs remplis ou non
if (!$id || !$title || !$description || !$date_event || !$date_end) {
    header("Location: /index.php?page=edit_event&id=$id&error=Champs manquants");
    exit;
}

// vérification que l'utilisateur a le droit de modifier l'événement
if ($_SESSION['role_id'] === 4) {
    // Admin peut modifier tout
    $stmt = $pdo->prepare("SELECT * FROM event WHERE id = ?");
    $stmt->execute([$id]);
} else {
    // Orga seulement ses propres events
    $stmt = $pdo->prepare("SELECT * FROM event WHERE id = ? AND created_by = ?");
    $stmt->execute([$id, $_SESSION['user_id']]);
}

$event = $stmt->fetch();

// redirection si pas d'événement trouvé
// ou si l'utilisateur n'est pas le créateur de l'événement
if (!$event) {
    header("Location: /index.php?page=" . ($_SESSION['role_id'] === 4 ? 'admin' : 'organisateur') . "&error=Accès refusé");
    exit;
}

// mise à jour
$stmt = $pdo->prepare("UPDATE event SET title = ?, description = ?, date_event = ?, date_end = ? WHERE id = ?");
$stmt->execute([$title, $description, $date_event, $date_end, $id]);

header("Location: /index.php?page=" . ($_SESSION['role_id'] === 4 ? 'admin' : 'organisateur') . "&success=Événement modifié");
exit;
