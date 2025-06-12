<!-- affichage d'un popup d'événement -->
<div class="modal-title">
<?php if (!empty($event->img)): ?>
  <img src="/<?= htmlspecialchars($event->img) ?>" alt="<?= htmlspecialchars($event->title) ?>">
<?php endif; ?>
<h2><?= htmlspecialchars($event->title) ?></h2>
</div>
<div class="modal-cols">
  <div class="modal-col-1">
    <h3>Organisé par :</h3>
    <p><?= htmlspecialchars($event->organizer ?? 'Inconnu') ?></p>
  </div>
  <div class="modal-col-2">
    <h3>Description :</h3>
    <p><?= nl2br(htmlspecialchars($event->description)) ?></p>
  </div>
  <div class="modal-col-3">
    <h3>Début :</h3>
    <p><?= date('d/m/Y à H:i', strtotime($event->date_event)) ?></p>
  </div>
  <div class="modal-col-4">
    <h3>Fin :</h3>
    <p><?= date('d/m/Y à H:i', strtotime($event->date_end)) ?></p>
  </div>
  <div class="modal-col-5">
    <h3>Participants inscrits :</h3>
    <p><?= htmlspecialchars($event->participant_count ?? 0) ?></p>
  </div>
</div>
