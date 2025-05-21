<?php
function renderUnifiedEventCard(array $event, int $userId, string $role = 'joueur', bool $isFavorite = false): void
{
    $id = $event['id'];
    $title = htmlspecialchars($event['title']);
    $desc = nl2br(htmlspecialchars($event['description'] ?? ''));
    $date = date('d/m/Y à H:i', strtotime($event['date_event']));
    $started = $event['started'] ?? false;
    $creator = isset($event['creator']) ? htmlspecialchars($event['creator']) : '---';

    // statuts distincts
    $validationStatus = $event['status'] ?? null; // validation admin
    $registrationStatus = $event['registration_status'] ?? null; // participation joueur

    $eventTime = strtotime($event['date_event']);
    $endTime = strtotime($event['date_end']);
    $now = time();

    echo '<div class="event-card">';
    echo "<h3>$title</h3>";

    // description ou créateur selon contexte
    if ($role === 'joueur' || $isFavorite) {
        echo "<p class='event-desc'>$desc</p>";
    } elseif ($role === 'admin') {
        echo "<p><strong>Créé par :</strong> $creator</p>";
    }

    echo "<p><strong>Date :</strong> $date</p>";

    // statut d'inscription (affiché uniquement dans favoris ou joueur)
    if ($role === 'joueur' || $isFavorite) {
        echo "<p><strong>Statut :</strong> ";
        switch ((int)$registrationStatus) {
            case 1:
                echo "<span class='status valid'>Inscrit</span>";
                break;
            case -1:
                echo "<span class='status refused'>Refusé</span>";
                break;
            default:
                echo "<span class='status waiting'>Non inscrit</span>";
        }
        echo "</p>";
    }

    echo '<div class="event-actions">';

    // --- Cas ADMIN ---
    if ($role === 'admin' && !$isFavorite) {
        if (!$started && $validationStatus == 1 && $eventTime - $now <= 1800 && $eventTime > $now) {
            echo '<form action="/index.php?controller=start_event" method="POST">';
            echo "<input type='hidden' name='event_id' value='$id'>";
            echo '<button type="submit"><i class="fa-solid fa-rocket" style="color: #000000;"></i>Démarrer</button>';
            echo '</form>';
        } elseif ($started) {
            echo '<span class="status started"><i class="fa-solid fa-circle" style="color: #b30000;"></i>En cours</span>';
        }

        if ($eventTime > $now) {
            echo "<a href='/index.php?page=edit_event&id=$id' class='btn-edit'><i class='fa-solid fa-pencil' style='color: #000000;'></i>Modifier</a>";
        }

        if ($validationStatus === null) {
            echo '<form action="/index.php?controller=validate_event" method="POST" class="admin-validation-form">';
            echo "<input type='hidden' name='event_id' value='$id'>";
            echo '<button type="submit" name="status" value="1"><i class="fa-solid fa-check" style="color: #31b800;"></i>Valider cet évenement</button>';
            echo '<button type="submit" name="status" value="0"><i class="fa-solid fa-x" style="color: #c20d00;"></i>Refuser cet évenement</button>';
            echo '</form>';
        }
    }

    // --- Cas ORGA Mes événements ---
    if ($role === 'orga' && !$isFavorite) {
        if (!$started && $validationStatus == 1 && $eventTime - $now <= 1800 && $eventTime > $now) {
            echo '<form action="/index.php?controller=start_event" method="POST">';
            echo "<input type='hidden' name='event_id' value='$id'>";
            echo '<button type="submit"><i class="fa-solid fa-rocket" style="color: #000000;"></i>Démarrer</button>';
            echo '</form>';
        } elseif ($started) {
            echo '<span class="status started"><i class="fa-solid fa-circle" style="color: #b30000;"></i>En cours</span>';
        }

        if ($eventTime > $now) {
            echo "<a href='/index.php?page=edit_event&id=$id' class='btn-edit'><i class='fa-solid fa-pencil' style='color: #000000;'></i>Modifier</a>";
        }

        if ($event['status'] === null) {
            echo '<span style="color: orange;">En attente de validation</span>';
        } elseif ($event['status'] == 1) {
            echo '<span style="color: green;">Validé</span> (le ' . htmlspecialchars($event['validated_at']) . ')';
        } else {
            echo '<span style="color: red;">Refusé</span> (le ' . htmlspecialchars($event['validated_at']) . ')';
        }
    }

    // --- Cas FAVORIS ou JOUEUR ---
    if ($role === 'joueur' || $isFavorite) {
        if ($registrationStatus === 1 && $started && $now >= $eventTime && $now <= $endTime) {
            echo '<form action="/index.php?controller=enter_event" method="POST">';
            echo "<input type='hidden' name='event_id' value='$id'>";
            echo '<button type="submit"><i class="fa-solid fa-circle-play" style="color:rgb(0, 0, 0);"></i>Rejoindre</button>';
            echo '</form>';
        }

        if (is_null($registrationStatus)) {
            echo '<form action="/index.php?controller=join_event" method="POST">';
            echo "<input type='hidden' name='event_id' value='$id'>";
            echo '<button type="submit">S\'inscrire</button>';
            echo '</form>';
        }

        if ($registrationStatus == 1 && $eventTime > $now) {
            echo '<form action="/index.php?controller=leave_event" method="POST">';
            echo "<input type='hidden' name='event_id' value='$id'>";
            echo '<button type="submit">Se désinscrire</button>';
            echo '</form>';
        }
    }

    echo '</div>';
    echo '</div>'; 
}