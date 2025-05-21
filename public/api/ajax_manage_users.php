<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../helpers/auth.php';
require_role(4); // admin 

$stmt = $pdo->query("
    SELECT id, username, email, role_id 
    FROM user
    ORDER BY username ASC
");
$users = $stmt->fetchAll();

$roles = [
    1 => "Invité",
    2 => "Joueur",
    3 => "Organisateur",
    4 => "Administrateur"
];

echo '<table class="user-table"><tr><th>Nom</th><th>Email</th><th>Rôle</th><th>Modifier</th></tr>';

// affichage des utilisateurs
foreach ($users as $user) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($user['username']) . '</td>';
    echo '<td>' . htmlspecialchars($user['email']) . '</td>';
    echo '<td>' . $roles[$user['role_id']] . '</td>';
    echo '<td>
        <form method="POST" action="/index.php?controller=update_user_role">
            <input type="hidden" name="user_id" value="' . $user['id'] . '">
            <select name="new_role">';
    foreach ($roles as $id => $label) {
        $selected = ($id == $user['role_id']) ? 'selected' : '';
        echo "<option value='$id' $selected>$label</option>";
    }
    echo '</select>
            <button type="submit"><i class="fa-solid fa-check" style="color:rgb(0, 0, 0);"></i></button>
        </form>
    </td>';
    echo '</tr>';
}
echo '</table>';
