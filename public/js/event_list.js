// filtres événements
function applyFilters() {
  const players = document.getElementById("filter-players").value;
  const month = document.getElementById("filter-month").value;
  const hour = document.getElementById("filter-hour").value;

  const params = new URLSearchParams({
    players,
    month,
    hour,
  });

  fetch(`/index.php?controller=ajax_events&${params}`)
    .then((res) => res.text())
    .then((html) => {
      document.querySelector(".events-container").innerHTML = html;
      bindFavoriteButtons();
    });
}

document
  .getElementById("filter-players")
  .addEventListener("change", applyFilters);
document
  .getElementById("filter-month")
  .addEventListener("change", applyFilters);
document.getElementById("filter-hour").addEventListener("change", applyFilters);

// Popup details des events
document.addEventListener("click", function (e) {
  if (e.target.classList.contains("view-details")) {
    const eventId = e.target.dataset.id;
    fetch(`/index.php?controller=event_details&id=${eventId}`)
      .then((res) => res.text())
      .then((html) => {
        document.getElementById("modal-body").innerHTML = html;
        document.getElementById("modal").style.display = "flex";
      });
  }
});

// Toggle pour les favoris
document.addEventListener("click", function (e) {
  const btn = e.target.closest(".fav-btn");
  if (btn) {
    const eventId = btn.dataset.id;

    fetch("/api/toggle_favorite.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: `event_id=${eventId}`,
    })
      .then((res) => res.json())
      .then((data) => {
        btn.innerHTML = data.favorited
          ? '<i class="fa-solid fa-star" style="color: #FFD43B;"></i>'
          : '<i class="fa-regular fa-star" style="color: #a000ff;"></i>';
        btn.dataset.fav = data.favorited ? "1" : "0";
      })
      .catch((err) => console.error("Erreur favori:", err));
  }
});
