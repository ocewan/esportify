// Filtres pour la liste des événements
// Fonction de validation des filtres
function isValidInput(value) {
  return /^[a-zA-Z0-9\s-:]*$/.test(value);
}

// Fonction pour appliquer les filtres
function applyFilters() {
  const players = document.getElementById("filter-players").value;
  const month = document.getElementById("filter-month").value;
  const hour = document.getElementById("filter-hour").value;

  // Validation de chaque champ
  if (![players, month, hour].every(isValidInput)) {
    alert("Filtres invalides.");
    return;
  }

  // Préoparation des paramètres pour la requête
  const params = new URLSearchParams({ players, month, hour });

  // Envoi de la requête AJAX pour récupérer les événements filtrés
  fetch(`/index.php?controller=ajax_events&${params}`)
    .then((res) => res.text())
    .then((html) => {
      // Parsage de la réponse HTML en DOM
      const parser = new DOMParser();
      const parsed = parser.parseFromString(html, "text/html");
      const newContent = parsed.querySelector(".events-container");

      const container = document.querySelector(".events-container");
      if (container && newContent) {
        container.replaceWith(newContent);
        bindFavoriteButtons();
      }
    });
}

// Lancer les filtres au chargement de la page
document
  .getElementById("filter-players")
  .addEventListener("change", applyFilters);
document
  .getElementById("filter-month")
  .addEventListener("change", applyFilters);
document.getElementById("filter-hour").addEventListener("change", applyFilters);

// Affichage des détails d'un événement dans une modale (popup)
document.addEventListener("click", function (e) {
  if (e.target.classList.contains("view-details")) {
    const eventId = e.target.dataset.id;

    fetch(`/index.php?controller=event_details&id=${eventId}`)
      .then((res) => res.text())
      .then((html) => {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, "text/html");
        const content = doc.body.firstChild;

        const modalBody = document.getElementById("modal-body");
        modalBody.replaceChildren(); // vide proprement
        if (content) modalBody.appendChild(content);

        document.getElementById("modal").style.display = "flex";
      });
  }
});

// Bouton favori pour les événements
document.addEventListener("click", function (e) {
  const btn = e.target.closest(".fav-btn");
  if (btn) {
    const eventId = btn.dataset.id;

    // Appel à lAPI pour ajouter/retirer un favori
    fetch("/api/toggle_favorite.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `event_id=${eventId}`,
    })
      .then((res) => res.json())
      .then((data) => {
        // insertion de l'icône dans le bouton
        const icon = document.createElement("i");
        icon.className = data.favorited
          ? "fa-solid fa-star"
          : "fa-regular fa-star";
        icon.style.color = data.favorited ? "#FFD43B" : "#a000ff";

        btn.replaceChildren(icon);
        btn.dataset.fav = data.favorited ? "1" : "0";
      })
      .catch((err) => console.error("Erreur favori:", err));
  }
});
