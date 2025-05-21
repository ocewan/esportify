<!-- affichage des cards d'événements -->
<div class="event-card" data-event-id="<?= htmlspecialchars($event['id']) ?>">
    <h3><?= htmlspecialchars($event['title']) ?></h3>
    <p><i class="fa-solid fa-gamepad" style="color: #ffffff;"></i> <?= (int)$event['nb_players'] ?> joueurs</p>
    <p><i class="fa-solid fa-clock" style="color: #ffffff;"></i> <?= date('d/m/Y H:i', $eventTime) ?> → <?= date('d/m/Y H:i', $endTime) ?></p>
    <button class="view-details" data-id="<?= htmlspecialchars($event['id']) ?>">Voir + d'infos</button>

    <?php
    // Affichage du bouton de favoris
    $isFav = in_array($event['id'], $favoriteIds);
    if (in_array((int)$role, [2, 3, 4])): ?>
        <button class="fav-btn" data-id="<?= htmlspecialchars($event['id']) ?>" data-fav="<?= $isFav ? '1' : '0' ?>">
            <?= $isFav
                ? '<i class="fa-solid fa-star" style="color: #FFD43B;"></i>'
                : '<i class="fa-regular fa-star" style="color: #a000ff;"></i>' ?>
        </button>
    <?php endif; ?>
</div>