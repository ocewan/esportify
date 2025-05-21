<?php
$role = $_SESSION['role_id'];

// affichage du panneaux d'actions selon le rôle
if (in_array($role, [3, 4])): ?>
    <h3>
        <a href="#" class="ajax-link" data-url="/api/ajax_create_event.php" data-target="ajax-create">
            <i class="fa-solid fa-plus" style="color: #ffffff;"></i> Créer un événement
        </a>
    </h3>
    <div class="ajax-panel" id="ajax-create"></div>

    <h3>
        <a href="#" class="ajax-link" data-url="/api/ajax_refuse_participant.php" data-target="panel-refuse">
            <i class="fa-solid fa-list-check" style="color: #ffffff;"></i> Gérer les participants
        </a>
    </h3>
    <div class="ajax-panel" id="panel-refuse"></div>
<?php endif; ?>

<?php if ($role === 4): ?>
    <h3>
        <a href="#" class="ajax-link" data-url="/api/ajax_manage_users.php" data-target="panel-users">
            <i class="fa-solid fa-lock" style="color: #ffffff;"></i> Gérer les utilisateurs
        </a>
    </h3>
    <div class="ajax-panel" id="panel-users"></div>
<?php endif; ?>

<h3>
    <a href="#" class="ajax-link" data-url="/api/ajax_historique.php" data-target="panel-history">
        <i class="fa-solid fa-clock-rotate-left" style="color: #ffffff;"></i> Voir l'historique des événements
    </a>
</h3>
<div class="ajax-panel" id="panel-history"></div>
