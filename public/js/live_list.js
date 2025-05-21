// Lives de la page d'accueil
function renderLives(containerId, lives) {
  const container = document.getElementById(containerId);

  if (lives.length === 0) {
    container.innerHTML = `<p style="color: #aaa;">Aucun live pour l’instant.</p>`;
    return;
  }

  container.innerHTML = lives
    .map(
      (live) => `
        <div class="live-card">
          <img src="${live.image}" alt="${live.jeu}">
          <h4>${live.jeu}</h4>
          <p>${live.organisateur}</p>
          <span>${live.heure}</span>
        </div>
      `
    )
    .join("");
}

async function loadLives(type, containerId) {
  try {
    const response = await fetch(`/api/get_lives.php?type=${type}`);
    const data = await response.json();
    renderLives(containerId, data);
  } catch (err) {
    console.error("Erreur de chargement des lives :", err);
  }
}

document.addEventListener("DOMContentLoaded", () => {
  loadLives("en-cours", "lives-en-cours");
  loadLives("a-venir", "lives-a-venir");
});
