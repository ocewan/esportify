<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../helpers/auth.php';
require_role(3); // Orga et Admin
?>

<!-- création d'un événement -->
<div class="create-event-panel">
    <?php if (isset($_GET['error'])): ?>
        <div style="color: red;"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
        <div style="color: green;"><?= htmlspecialchars($_GET['success']) ?></div>
    <?php endif; ?>

    <form action="/index.php?controller=create_event" method="POST">
        <label>Nom de l'événement :</label>
        <select name="title" required>
            <option value="Valorant">Valorant</option>
            <option value="LoL">League of Legends</option>
            <option value="CallOfDuty">Call of Duty</option>
            <option value="Warzone">Warzone</option>
            <option value="RocketLeague">Rocket League</option>
        </select>

        <label>Description :</label>
        <textarea name="description" required></textarea>

        <label>Date de début :</label>
        <input type="datetime-local" name="date_event" required>

        <label>Date de fin :</label>
        <input type="datetime-local" name="date_end" required>

        <button type="submit">Créer l'événement</button>
    </form>
</div>