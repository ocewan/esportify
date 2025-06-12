// Lives de la page d'accueil
// Chargement des lives pour la page d'accueil
function renderLives(containerId, lives) {
  const container = document.getElementById(containerId);
  container.replaceChildren();

  if (lives.length === 0) {
    // Si aucun live, afficher un message
    const msg = document.createElement("p");
    msg.textContent = "Aucun live pour l’instant.";
    msg.style.color = "#aaa";
    container.appendChild(msg);
    return;
  }

  // Créer les cartes pour chaque live
  lives.forEach((live) => {
    const card = document.createElement("div");
    card.className = "live-card";

    const img = document.createElement("img");
    img.setAttribute("src", live.image);
    img.setAttribute("alt", live.jeu);

    const title = document.createElement("h4");
    title.textContent = live.jeu;

    const orga = document.createElement("p");
    orga.textContent = live.organisateur;

    const heure = document.createElement("span");
    heure.textContent = live.heure;

    // Ajoute tous les éléments à la carte
    card.append(img, title, orga, heure);
    container.appendChild(card);
  });
}

// Charge les données des lives depuis l'API
async function loadLives(type, containerId) {
  try {
    const response = await fetch(`/api/get_lives.php?type=${type}`);
    const data = await response.json();
    renderLives(containerId, data);
  } catch (err) {
    console.error("Erreur de chargement des lives :", err);
  }
}

// lancer le chargement des lives au chargement de la page
document.addEventListener("DOMContentLoaded", () => {
  loadLives("en-cours", "lives-en-cours");
  loadLives("a-venir", "lives-a-venir");
});
